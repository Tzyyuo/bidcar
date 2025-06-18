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

// Ambil filter dari GET
$tgl_lelang = $_GET['tgl_lelang'] ?? '';
$tgl_selesai = $_GET['tgl_selesai'] ?? '';
$transmisi = $_GET['transmisi'] ?? '';

// Query dasar
$query = "SELECT l.id_lelang, b.nama_barang,  l.tgl_lelang, b.harga_awal, l.harga_akhir,b.transmisi,m.nama_lengkap AS pemenang FROM tb_lelang l
        JOIN tb_barang b ON l.id_barang = b.id_barang
        LEFT JOIN tb_masyarakat m ON l.id_user = m.id_user
        WHERE 1=1";

// Tambah filter
if ($transmisi != '') {
    $transmisi = mysqli_real_escape_string($koneksi, $transmisi);
    $query .= " AND b.transmisi = '$transmisi'";
}
if ($tgl_lelang != '' && $tgl_selesai != '') {
    $tgl_lelang = mysqli_real_escape_string($koneksi, $tgl_lelang);
    $tgl_selesai = mysqli_real_escape_string($koneksi, $tgl_selesai);
    $query .= " AND l.tgl_lelang BETWEEN '$tgl_lelang' AND '$tgl_selesai'";
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
    <meta charset="UTF-8">
    <title>Laporan Lelang</title>
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <link rel="stylesheet" href="../css/laporan_lelang-petugas.css">
</head>

<body>
            <div class="sidebar">
            <h1>BidCar.</h1>
            <hr class="sidebar-divider"/>

            <ul>
                <li><a href="/bidcar/model/petugas/dashboard_petugas.php"><img src="../img/dashboard-icon.svg" alt="dashboard"/>Dashboard</a></li>
                <li><a href="/bidcar/model/petugas/data_barang.php"><img src="../img/barang-icon.svg" alt="barang"/>Data Barang</a></li>
                <li class="active"><a href="/bidcar/model/petugas/data_lelang.php"><img src="../img/lelang-icon.svg" alt="lelang"/>Data Lelang</a></li>
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
                    <img src="../img/bidcar signup.svg" alt="BidCar Logo" class="header-logo">
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
            <h2>Laporan Lelang</h2>

            <div class="print-info">
                <p><strong>Periode Lelang:</strong>
                    <?php
                    if ($tgl_lelang && $tgl_selesai) {
                        echo strftime('%d %B %Y', strtotime($tgl_lelang)) . ' - ' . strftime('%d %B %Y', strtotime($tgl_selesai));
                    } else {
                        echo 'Semua Tanggal';
                    }
                    ?>
                </p>
                <p><strong>Transmisi:</strong> <?= htmlspecialchars($transmisi != '' ? ucfirst($transmisi) : 'Semua') ?></p>
                <p><strong>Dicetak pada:</strong> <?= strftime('%d %B %Y, %H:%M:%S', time()) ?> WIB</p>
            </div>

            <div class="filter">
                <form method="GET" action="">
                    <label>Transmisi:
                        <select name="transmisi">
                            <option value="">Semua</option>
                            <option value="manual" <?= $transmisi == 'manual' ? 'selected' : '' ?>>Manual</option>
                            <option value="automatic" <?= $transmisi == 'automatic' ? 'selected' : '' ?>>Automatic</option>
                        </select>
                    </label>

                    <label>Tanggal Lelang:
                        <input type="date" name="tgl_lelang" value="<?= htmlspecialchars($tgl_lelang) ?>">
                    </label>

                    <label>Sampai:
                        <input type="date" name="tgl_selesai" value="<?= htmlspecialchars($tgl_selesai) ?>">
                    </label>

                    <button type="submit">Filter</button>
                </form>
            </div>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Tanggal Lelang</th> <th>Harga Awal</th>
                    <th>Harga Akhir</th>
                    <th>Transmisi</th>
                    <th>Pemenang</th>
                </tr>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_lelang']) ?></td>
                            <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                            <td>
                                <?php
                                    // Menggunakan strftime untuk format tanggal Indonesia
                                    $tgl_lelang_formatted = strftime('%d %B %Y', strtotime($row['tgl_lelang']));
                                    echo $tgl_lelang_formatted;
                                ?>
                            </td>
                            <td>Rp<?= number_format($row['harga_awal'], 0, ',', '.') ?></td>
                            <td>Rp<?= number_format($row['harga_akhir'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars(ucfirst($row['transmisi'])) ?></td> <td><?= htmlspecialchars($row['pemenang'] ?? '-') ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Tidak ada data lelang sesuai filter.</td>
                    </tr>
                <?php endif; ?>
            </table>

            <div class="print-btn">
                <button onclick="window.print()">Cetak Laporan</button>
            </div>
        </div>
</body>
</html>