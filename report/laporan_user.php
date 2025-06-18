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

// Cek hak akses
if ($_SESSION['level'] != 1 && $_SESSION['level'] != 2) {
    echo "<script>
        alert('Anda tidak memiliki akses ke halaman ini.');
        window.history.back();
    </script>";
    exit;
}

$id_user = $_GET['id_user'] ?? '';
$jumlah_penawaran = $_GET['jumlah_penawaran'] ?? '';


$query = "SELECT m.id_user, m.nama_lengkap, m.username, m.telp, COUNT(p.id_penawaran) AS jumlah_penawaran, GROUP_CONCAT(DISTINCT b.nama_barang SEPARATOR ', ') AS barang_menang
        FROM tb_masyarakat m LEFT JOIN tb_penawaran p ON m.id_user = p.id_user LEFT JOIN tb_lelang l ON l.id_user = m.id_user
        LEFT JOIN tb_barang b ON l.id_barang = b.id_barang GROUP BY m.id_user";

if ($id_user != '') {
    $id_user = mysqli_real_escape_string($koneksi, $id_user);
    $query .= " AND m.id_user = '$id_user'";
}
if ($jumlah_penawaran != '') {
    $jumlah_penawaran = mysqli_real_escape_string($koneksi, $jumlah_penawaran);
    $query .= " AND p.id_penawaran = '$jumlah_penawaran'";
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
    <meta charset="UTF-8">
    <title>Laporan Pengguna</title>
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <link rel="stylesheet" href="../css/laporan_user.css">
</head>

<body>
        <div class="sidebar">
            <h1>BidCar.</h1>
            <hr class="sidebar-divider"/>

            <ul>
                <li><a href="/bidcar/model/admin/dashboard_admin.php"><img src="../img/dashboard-icon.svg" alt="dashboard"/>Dashboard</a></li>
                <li><a href="/bidcar/model/admin/data_barang.php"><img src="../img/barang-icon.svg" alt="barang"/>Data Barang</a></li>
                <li><a href="/bidcar/model/admin/data_lelang.php"><img src="../img/lelang-icon.svg" alt="lelang"/>Data Lelang</a></li>
                <li><a href="/bidcar/model/admin/data_petugas.php"><img src="../img/admin-icon.svg" alt="admin"/>Data Petugas</a></li>
                <li class="active"><a href="/bidcar/model/admin/data_pengguna.php"><img src="../img/user-icon.svg" alt="user"/>Data User</a></li>
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

                            <img src="/bidcar/img/<?= $pfp['foto']?>" alt="Foto Petugas" class="petugas-icon">
                            <span><?= htmlspecialchars($pfp['username'])?></span>
                        </div>
                    </a>
                </div>
            </div>

            <h2>Laporan User</h2>

            <div class="print-info">
                <p><strong>Jumlah Penawaran Minimum:</strong>
                    <?= htmlspecialchars($jumlah_penawaran_min != '' ? $jumlah_penawaran_min : 'Tidak Ada Filter') ?>
                </p>
                <p><strong>Dicetak pada:</strong> <?= strftime('%d %B %Y, %H:%M:%S', time()) ?> WIB</p>
            </div>

            <div class="filter">
                <form method="GET" action="">
                    <label>Jumlah Penawaran Minimum:
                        <input type="number" name="jumlah_penawaran" value="<?= htmlspecialchars($jumlah_penawaran_min) ?>">
                    </label>
                    <button type="submit">Tampilkan</button>
                </form>
            </div>

            <table>
                <tr>
                    <th>ID Pengguna</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>No. Telepon</th>
                    <th>Jumlah Penawaran</th>
                    <th>Barang Yang Dimenangkan</th>
                </tr>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_user']) ?></td>
                            <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['telp']) ?></td>
                            <td><?= htmlspecialchars($row['jumlah_penawaran']) ?></td>
                            <td><?= $row['barang_menang'] ? htmlspecialchars($row['barang_menang']) : 'Tidak Ada' ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Tidak ada data pengguna sesuai filter.</td>
                    </tr>
                <?php endif; ?>
            </table>

            <div class="print-btn">
                <button onclick="window.print()">Cetak Laporan</button>
            </div>
        </div>

</body>
</html>