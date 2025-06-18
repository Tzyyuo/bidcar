<?php
session_start();

include '../config/koneksi.php';
$id_petugas = $_SESSION['id_petugas']; // Asumsi 'id_petugas' disimpan di session
$query = mysqli_query($koneksi, "SELECT * FROM tb_petugas WHERE id_petugas = '$id_petugas'");
$pfp = mysqli_fetch_assoc($query);

// Cek session login
if (!isset($_SESSION['id_petugas']) || !isset($_SESSION['level'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu.');
        window.location.href = '../views/login.php';
    </script>";
    exit;
}


// Ambil filter dari GET
$transmisi = $_GET['transmisi'] ?? '';
$tgl = $_GET['tgl'] ?? '';

// Buat query dasar
$query = "SELECT * FROM tb_barang WHERE 1=1";

// Tambah filter transmisi 
if ($transmisi != '') {
    $transmisi = mysqli_real_escape_string($koneksi, $transmisi);
    $query .= " AND transmisi = '$transmisi'";
}

// Tambah filter tanggal
if ($tgl != '') {
    $query .= " AND tgl = '$tgl'";
}

$result = mysqli_query($koneksi, $query);
if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}

// Set locale untuk tanggal Indonesia
setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'id', 'Indonesian_Indonesia.1252', 'Indonesian');
date_default_timezone_set('Asia/Jakarta');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Laporan Barang</title>
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <link rel="stylesheet" href="../css/laporan_barang-admin.css">
</head>
<body>
            <div class="sidebar">
            <h1>BidCar.</h1>
            <hr class="sidebar-divider"/>

            <ul>
                <li><a href="/bidcar/model/admin/dashboard_admin.php"><img src="../img/dashboard-icon.svg" alt="dashboard"/>Dashboard</a></li>
                <li class="active"><a href="/bidcar/model/admin/data_barang.php"><img src="../img/barang-icon.svg" alt="barang"/>Data Barang</a></li>
                <li><a href="/bidcar/model/admin/data_lelang.php"><img src="../img/lelang-icon.svg" alt="lelang"/>Data Lelang</a></li>
                <li><a href="/bidcar/model/admin/data_petugas.php"><img src="../img/admin-icon.svg" alt="admin"/>Data Petugas</a></li>
                <li><a href="/bidcar/model/admin/data_pengguna.php"><img src="../img/user-icon.svg" alt="user"/>Data User</a></li>
            </ul>

            <hr class="sidebar-divider"/>
            <form method="GET" action="../controllers/logout_controllers.php">
                <button type="button" name="logout" class="logout-btn">
                    <a href="/bidcar/controllers/logout_controllers.php"><img src="../img/logout-icon.svg" alt="logout"/>Logout</a>
                </button>
            </form>
        </div>

    <div class="content">
        <div class="navbar-content">
            <div class="navbar-left">
                <img src="../img/bidcar alt color 3.svg" alt="BidCar Logo" class="header-logo">
            </div>
                <div class="header-right">
                    <a href="../../views/profile-petugas.php">
                        <div class="petugas-profile">
                            <?php
                            // Menentukan nama file gambar default/ikon seperti di halaman profil
                            $default_profile_image = 'default.png';
                            $placeholder_icon_image = 'profile-pfp.svg';

                            // Menentukan path foto yang akan ditampilkan
                            $foto_petugas_path = '';
                            if (isset($pfp['foto']) && !empty($pfp['foto']) && $pfp['foto'] != $default_profile_image) {
                                $foto_petugas_path = htmlspecialchars($pfp['foto']);
                            } else {
                                $foto_petugas_path = $placeholder_icon_image;
                            }
                            ?>

                            <img src="/bidcar/img/<?= $foto_petugas_path ?>" alt="Foto Petugas" class="petugas-icon">
                            <span><?= htmlspecialchars($pfp['username'])?></span>
                        </div>
                    </a>
                </div>
        </div>
    <h2>Laporan Barang</h2>

    <div class="print-info">
        <p><strong>Transmisi:</strong> <?= htmlspecialchars($transmisi != '' ? ucfirst($transmisi) : 'Semua') ?></p>
        <p><strong>Tanggal Barang:</strong>
            <?php
            if ($tgl) {
                echo strftime('%d %B %Y', strtotime($tgl));
            } else {
                echo 'Semua Tanggal';
            }
            ?>
        </p>
        <p><strong>Dicetak pada:</strong> <?= strftime('%d %B %Y, %H:%M:%S', time()) ?> WIB</p>
    </div>

    <div class="filter">
        <form method="GET" action="">
            <label>Transmisi:
                <select name="transmisi">
                    <option value="" <?= $transmisi == '' ? 'selected' : '' ?>>Semua</option>
                    <option value="manual" <?= $transmisi == 'manual' ? 'selected' : '' ?>>Manual</option>
                    <option value="automatic" <?= $transmisi == 'automatic' ? 'selected' : '' ?>>Automatic</option>
                </select>
            </label>

            <label>Tanggal Barang:
                <input type="date" name="tgl" value="<?= htmlspecialchars($tgl) ?>">
            </label>

            <button type="submit">Filter</button>
        </form>
    </div>

    <table>
        <tr>
            <th>ID</th> <th>Nama Barang</th> <th>Tanggal Terdaftar</th> <th>Harga Awal</th>
            <th>Transmisi</th>
        </tr>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_barang']) ?></td>
                    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                    <td>
                        <?php
                            // Menggunakan strftime untuk format tanggal Indonesia
                            $tgl_formatted = strftime('%d %B %Y', strtotime($row['tgl']));
                            echo $tgl_formatted;
                        ?>
                    </td>
                    <td>Rp<?= number_format($row['harga_awal'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars(ucfirst($row['transmisi'])) ?></td> </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Tidak ada data barang sesuai filter.</td>
            </tr>
        <?php endif; ?>
    </table>

    <div class="print-btn">
        <button onclick="window.print()">Cetak Laporan</button>
    </div>

</body>

</html>