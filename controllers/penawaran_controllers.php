

<?php
session_start();
include '../config/koneksi.php'; // ganti path kalau perlu

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil data dari form
    $id_lelang = (int) $_POST['id_lelang'];
    $raw_harga = $_POST['harga_penawaran'] ?? null;
    $harga_penawaran = (int) preg_replace('/\D/', '', $raw_harga);
    $id_user = $_SESSION['id_user'] ?? null;

    if (!$id_user) {
        die("User belum login.");
    }

    // 1. Ambil harga_awal dari tb_barang
    $stmt1 = $koneksi->prepare("
        SELECT b.harga_awal 
        FROM tb_lelang l
        JOIN tb_barang b ON l.id_barang = b.id_barang 
        WHERE l.id_lelang = ?
    ");
    $stmt1->bind_param("i", $id_lelang);
    $stmt1->execute();
    $res1 = $stmt1->get_result();
    $row1 = $res1->fetch_assoc();
    $stmt1->close();

    if (!$row1) {
        die("Lelang tidak ditemukan.");
    }

    // 2. Validasi harga
    $harga_awal = $row1['harga_awal'];
    if ($harga_penawaran < $harga_awal) {
        die("Harga penawaran harus lebih tinggi dari harga awal.");
    }

    // 3. Insert ke tb_penawaran
    $stmt2 = $koneksi->prepare("
        INSERT INTO tb_penawaran (id_lelang, id_user, harga_penawaran) 
        VALUES (?, ?, ?)
    ");
    $stmt2->bind_param("iii", $id_lelang, $id_user, $harga_penawaran);
    $stmt2->execute();
    $stmt2->close();

    // 4. Update tb_lelang (harga_akhir)
    $stmt3 = $koneksi->prepare("
        UPDATE tb_lelang SET harga_akhir = ? WHERE id_lelang = ?
    ");
    $stmt3->bind_param("ii", $harga_penawaran, $id_lelang);
    $stmt3->execute();
    $stmt3->close();

    // 5. Simpan ke history_lelang
    $stmt4 = $koneksi->prepare("
        INSERT INTO history_lelang (id_lelang, id_user, penawaran_harga, status) 
        VALUES (?, ?, ?, 'pending')
    ");
    $stmt4->bind_param("iii", $id_lelang, $id_user, $harga_penawaran);
    $stmt4->execute();
    $stmt4->close();

    // 6. Redirect atau tampilkan pesan
   echo "<script>alert('Penawaran berhasil disimpan.'); window.history.back;</script>";
    exit;
}
?>
