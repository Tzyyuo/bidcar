<?php
session_start();
include '../config/koneksi.php';

// Pastikan ada id_petugas di sesi
if (!isset($_SESSION['id_petugas'])) {
    echo "<script>alert('Petugas tidak teridentifikasi. Silakan login terlebih dahulu.'); window.location.href='/bidcar/views/login.php';</script>";
    exit();
}

if (isset($_POST['simpan'])) {
    $id_barang = $_POST['id_barang'];
    $tgl_lelang = $_POST['tgl_lelang'];
    $id_petugas = $_SESSION['id_petugas'];
    $tgl_selesai = $_POST['tgl_selesai'];
    $status = 'ditutup'; 

    // Simpan ke tabel tb_lelang
    $query = "INSERT INTO tb_lelang (id_barang, tgl_lelang, id_petugas, tgl_selesai, status) VALUES (?, ?, ?, ?, 'ditutup')";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("isis", $id_barang, $tgl_lelang, $id_petugas, $tgl_selesai);

    if ($stmt->execute()) {
        echo "<script>alert('Lelang berhasil ditambahkan!'); window.location.href='/bidcar/model/petugas/data_lelang.php';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal menambahkan lelang: " . $stmt->error . "'); window.history.back();</script>";
    }
}
?>
