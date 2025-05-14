<?php
include '../../config/koneksi.php';

$id_barang = $_POST['id_barang'];
$tgl_barang = $_POST['tgl_barang'];
$status = 'dibuka'; // default saat buat
$id_petugas = 1; // ganti sesuai sesi login nanti

$query = "INSERT INTO tb_lelang (id_barang, tgl_barang, status, id_petugas) VALUES (?, ?, ?, ?)";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("sssi", $id_barang, $tgl_barang, $status, $id_petugas);
$stmt->execute();

echo "<script>alert('Lelang berhasil ditambahkan!'); window.location.href='data_lelang.php';</script>";
?>
