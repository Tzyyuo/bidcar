<?php

include __DIR__ . '/../config/koneksi.php';

$id_user = $_SESSION['id_user'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_masyarakat WHERE id_user='$id_user'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/bidcar/css/header.css">
</head>

<body>

    <navbar class="navigasi">
        <div class="logo">
            <img src="/bidcar/img/bidcar alt color 1.png">
            <ul>
                <li><a href="/bidcar/model/masyarakat/laman_masyarakat.php">Home</a></li>
                <li><a href="/bidcar/layouts/tentang.php">Tentang</a></li>
                <li><a href="/bidcar/layouts/pusatbantuan.php">Pusat Bantuan</a></li>
                <li><a href="/bidcar/model/masyarakat/history.php">Riwayat Pelanggan</a></li>
            </ul>
        </div>
        <div class="navbar-user" style="display: flex; align-items: center; gap: 10px;">
             <a href="/bidcar/views/profile.php">
            <img src="/bidcar/img/<?= $data['foto'] ?>" alt="Foto Profil" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
             </a>
            <span><?= htmlspecialchars($data['nama_lengkap']) ?></span>
            <a href="logout.php" style="margin-left: 10px;">Logout</a>
        </div>

    </navbar>