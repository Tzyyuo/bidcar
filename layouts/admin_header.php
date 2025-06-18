<?php
session_start();

include __DIR__ . '/../config/koneksi.php';

$id_petugas = $_SESSION['id_petugas'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_petugas WHERE id_petugas ='$id_petugas'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/bidcar/css/header.css">
</head>

<body>

    <navbar class="navigasi">

        <div class="navbar-user" style="display: flex; align-items: center; gap: 10px;">
             <a href="/bidcar/views/admin_profile.php">
            <img src="/bidcar/img/<?= $data['foto'] ?>" alt="Foto Profil" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
            </a>
            <span><?= htmlspecialchars($data['nama_petugas']) ?></span>
            <a href="logout.php" style="margin-left: 10px;">Logout</a>
        </div>

    </navbar>