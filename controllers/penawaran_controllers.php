<?php
session_start();
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
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
    WHERE l.id_lelang = ?");
    $stmt1->bind_param("i", $id_lelang);
    $stmt1->execute();
    $res1 = $stmt1->get_result();
    $row1 = $res1->fetch_assoc();
    $stmt1->close();

    if (!$row1) {
        die("Lelang tidak ditemukan.");
    }

    $harga_awal = $row1['harga_awal'];

    // 2. Ambil harga penawaran tertinggi terakhir
    $stmt2 = $koneksi->prepare("SELECT MAX(harga_penawaran) as max_penawaran FROM tb_penawaran WHERE id_lelang = ?");
    $stmt2->bind_param("i", $id_lelang);
    $stmt2->execute();
    $res2 = $stmt2->get_result();
    $row2 = $res2->fetch_assoc();
    $stmt2->close();

    $harga_tertinggi = $row2['max_penawaran'] ?? 0;
    $minimal = max($harga_awal, $harga_tertinggi);

   
if ($harga_penawaran <= $minimal) {
    $_SESSION['flash'] = [
        'icon' => 'error',
        'title' => 'Gagal Melakukan Penawaran!',
        'text' => 'Harga harus lebih tinggi dari '. number_format($minimal, 0, ',', '.') . '!'
    ];
    header("Location: ../views/penawaran.php?id_lelang=" . $id_lelang);
    exit;
}


    // 3. Insert ke tb_penawaran
    $stmt2 = $koneksi->prepare("
        INSERT INTO tb_penawaran (id_lelang, id_user, harga_penawaran) 
        VALUES (?, ?, ?)
    ");
    $stmt2->bind_param("iis", $id_lelang, $id_user, $harga_penawaran);
    $stmt2->execute();
    $stmt2->close();

    // 4. Update harga_akhir
    $stmt3 = $koneksi->prepare("
        UPDATE tb_lelang SET harga_akhir = ? WHERE id_lelang = ?
    ");
    $stmt3->bind_param("si", $harga_penawaran, $id_lelang);
    $stmt3->execute();
    $stmt3->close();

    // 5. Simpan ke history_lelang
    $stmt4 = $koneksi->prepare("
        INSERT INTO history_lelang (id_lelang, id_user, penawaran_harga, status) 
        VALUES (?, ?, ?, 'pending')
    ");
    $stmt4->bind_param("iis", $id_lelang, $id_user, $harga_penawaran);
    $stmt4->execute();
    $stmt4->close();
    
    header("Location: ../views/penawaran.php?id_lelang=" . $id_lelang);

    exit;
}
?>
