<?php
session_start();
include '../../config/koneksi.php';

if (!isset($_SESSION['id_petugas']) || !isset($_SESSION['level'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu.');
        window.location.href = '/bidcar/views/login.php';
    </script>";
    exit;
}

if (isset($_GET['id_lelang'])) {
    $id = $_GET['id_lelang'];
    $query = "SELECT l.*, b.nama_barang, b.harga_awal, b.gambar, m.nama_lengkap FROM tb_lelang l
              JOIN tb_barang b ON l.id_barang = b.id_barang LEFT JOIN tb_masyarakat m ON l.id_user = m.id_user
              WHERE l.id_lelang = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        echo "<h2>Detail Lelang</h2>";
        echo "<img src='../../img/{$data['gambar']}' width='200'><br><br>";
        echo "<strong>Nama Barang:</strong> {$data['nama_barang']}<br>";
        echo "<strong>Harga Awal:</strong> Rp " . number_format($data['harga_awal']) . "<br>";
        echo "<strong>Tanggal Lelang:</strong> {$data['tgl_lelang']}<br>";
        echo "<strong>Status:</strong> {$data['status']}<br>";
        echo "<strong>Pemenang:</strong> " . ($data['nama_lengkap'] ?? 'Belum ada') . "<br>";
    } else {
        echo "Data tidak ditemukan.";
    }
}
?>
