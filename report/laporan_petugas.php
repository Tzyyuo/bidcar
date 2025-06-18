<?php
session_start();
include '../config/koneksi.php';
$id_petugas = $_SESSION['id_petugas']; // Asumsi 'id_petugas' disimpan di session
$query = mysqli_query($koneksi, "SELECT * FROM tb_petugas WHERE id_petugas = '$id_petugas'");
$pfp = mysqli_fetch_assoc($query);

if (!isset($_SESSION['id_petugas']) || !isset($_SESSION['level'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu.');
        window.location.href = '../views/login.php';
    </script>";
    exit;
}

// Cek hak akses
if ($_SESSION['level'] != 1 && $_SESSION['level'] != 2) {
    echo "<script>
        alert('Anda tidak memiliki akses ke halaman ini.');
        window.history.back();
    </script>";
    exit;
}

$id_level = $_GET['level'] ?? '';

$query = "SELECT * FROM tb_petugas WHERE 1=1";

if ($id_level != '') {
    $id_level = mysqli_real_escape_string($koneksi, $id_level);
    $query .= " AND id_level = '$id_level'";
}

$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}

// Set locale untuk tanggal Indonesia (untuk info dicetak pada)
setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'id', 'Indonesian_Indonesia.1252', 'Indonesian');
date_default_timezone_set('Asia/Jakarta');

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Laporan Petugas</title>
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <link rel="stylesheet" href="../css/laporan_petugas.css">
</head>

<body>
        <div class="sidebar">
            <h1>BidCar.</h1>
            <hr class="sidebar-divider"/>

            <ul>
                <li><a href="/bidcar/model/admin/dashboard_admin.php"><img src="../img/dashboard-icon.svg" alt="dashboard"/>Dashboard</a></li>
                <li><a href="/bidcar/model/admin/data_barang.php"><img src="../img/barang-icon.svg" alt="barang"/>Data Barang</a></li>
                <li><a href="/bidcar/model/admin/data_lelang.php"><img src="../img/lelang-icon.svg" alt="lelang"/>Data Lelang</a></li>
                <li class="active"><a href="/bidcar/model/admin/data_petugas.php"><img src="../img/admin-icon.svg" alt="admin"/>Data Petugas</a></li>
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

            <h2>Laporan Petugas</h2>

            <div class="print-info">
                <p><strong>Filter Level:</strong>
                    <?php
                    if ($id_level == '1') {
                        echo 'Admin';
                    } elseif ($id_level == '2') {
                        echo 'Petugas';
                    } else {
                        echo 'Semua Level';
                    }
                    ?>
                </p>
                <p><strong>Dicetak pada:</strong> <?= strftime('%d %B %Y, %H:%M:%S', time()) ?> WIB</p>
            </div>

            <div class="filter">
                <form method="GET" action="">
                    <label>Level:
                        <select name="level">
                            <option value="" <?= $id_level == '' ? 'selected' : '' ?>>Semua</option>
                            <option value="1" <?= $id_level == '1' ? 'selected' : '' ?>>Admin</option>
                            <option value="2" <?= $id_level == '2' ? 'selected' : '' ?>>Petugas</option>
                        </select>
                    </label>

                    <button type="submit">Filter</button>
                </form>
            </div>

            <table>
                <tr>
                    <th>ID Petugas</th>
                    <th>Nama Petugas</th>
                    <th>Level Akses</th> <th>Username</th>
                </tr>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_petugas']) ?></td>
                            <td><?= htmlspecialchars($row['nama_petugas']) ?></td>
                            <td>
                                <?= $row['id_level'] == '1' ? 'Admin' : ($row['id_level'] == '2' ? 'Petugas' : 'Tidak diketahui') ?>
                            </td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Tidak ada data petugas sesuai filter.</td> </tr>
                <?php endif; ?>
            </table>
            <div class="print-btn">
                <button onclick="window.print()">Cetak Laporan</button>
            </div>
        </div>


</body>

</html>