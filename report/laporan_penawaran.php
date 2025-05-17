<?php
session_start();
include '../config/koneksi.php';

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
$query = "SELECT p.id_penawaran, b.nama_barang, l.tgl_lelang, l.tgl_selesai, p.tgl_penawaran, b.transmisi,m.nama_lengkap AS pemenang FROM tb_lelang l
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
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Lelang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            margin-bottom: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .filter,
        .print-btn {
            margin-bottom: 15px;
        }

        @media print {

            .filter,
            .print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>

    <h2>Laporan Penawaran</h2>

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

            <button type="submit">Tampilkan</button>
        </form>
    </div>

    <div class="print-btn">
        <button onclick="window.print()">Cetak</button>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama Penawar</th>
            <th>Nama Barang</th>
            <th>Tanggal</th>
            <th>Harga Awal</th>
            <th>Harga Akhir</th>
            <th>Transmisi</th>
            <th>Pemenang</th>
        </tr>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_lelang']) ?></td>
                    <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                    <td><?= htmlspecialchars($row['tgl_lelang']) ?></td>
                    <td>Rp<?= number_format($row['harga_awal'], 0, ',', '.') ?></td>
                    <td>Rp<?= number_format($row['harga_akhir'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['transmisi']) ?></td>
                    <td><?= htmlspecialchars($row['pemenang'] ?? '-') ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Tidak ada data lelang sesuai filter.</td>
            </tr>
        <?php endif; ?>
    </table>
    
    <button onclick="window.print()" class="no-print">Cetak Laporan</button>

</body>

</html>