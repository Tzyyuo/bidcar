<?php
include '../../config/koneksi.php';
session_start();
$id_user = $_SESSION['id_user']; // Biar ambil hanya user login

$query = "SELECT h.*, l.id_barang, b.nama_barang, b.gambar, b.transmisi, b.lokasi, b.harga_awal, m.nama_lengkap, l.tgl_lelang AS tgl, l.harga_akhir AS harga_terakhir 
FROM history_lelang h 
JOIN tb_lelang l ON h.id_lelang = l.id_lelang 
JOIN tb_barang b ON l.id_barang = b.id_barang 
JOIN tb_masyarakat m ON h.id_user = m.id_user 
WHERE h.id_user = ?
ORDER BY h.id_history DESC";

$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Lelang</title>
</head>
<body>
    <?php include '../../layouts/header.php';?>

        <!-- Banner -->
    <section class="hero-banner">
        <div class="hero-content">
            <h1 class="hero-title">Lihat Semua Aktivitas Lelang<br>yang Pernah Kamu Ikuti</h1>
            <span class="icon-wrapper">
                <img src="../../img/arrow-icon.svg" alt="Arrow Icon">
            </span>
        </div>
    </section>
    <!-- Banner -->

    <!-- Riwayat Lelang -->
    <button class="back-button">Riwayat Lelang</button>

    <div class="card-container">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <a href="/bidcar/views/detail_history.php?id_lelang=<?= $row['id_lelang'] ?>"class="card-link">
                <div class="card">
                    <img src="/bidcar/img/<?= $row['gambar'] ?>" alt="<?= $row['nama_barang'] ?>">
                    <div class="card-body">
                        <h3><?= strtoupper($row['nama_barang']) ?></h3>
                        <p><i class="fa-solid fa-calendar"></i> <?= date("d F Y", strtotime($row['tgl'])) ?></p>
                        <p><i class="fa-solid fa-location-dot"></i> <?= $row['lokasi'] ?? '-' ?></p>
                        <p><i class="fa-solid fa-car-side"></i> <?= $row['transmisi'] ?></p>
                        <div class="price">Rp<?= number_format($row['harga_terakhir'], 0, ',', '.') ?></div>
                    </div>
                </div>
                </a>
            <?php endwhile; ?>
    </div>






























   