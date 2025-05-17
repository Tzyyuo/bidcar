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
$id_user = $_GET['id_user'] ?? '';
$tgl_lelang = $_GET['tgl_lelang'] ?? '';
$tgl_selesai = $_GET['tgl_selesai'] ?? '';
$transmisi = $_GET['transmisi'] ?? '';

// Query dasar
$query = "SELECT p.id_penawaran, harga_penawaran, p.tgl_penawaran, b.nama_barang, b.transmisi, m.id_user, m.nama_lengkap, p2.nama_lengkap AS pemenang
          FROM tb_penawaran p JOIN tb_lelang l ON p.id_lelang = l.id_lelang JOIN tb_barang b ON l.id_barang = b.id_barang
          JOIN tb_masyarakat m ON p.id_user = m.id_user LEFT JOIN tb_masyarakat p2 ON l.id_user = p2.id_user WHERE 1=1";

// Tambah filter
if ($id_user != '') {
    $id_user = mysqli_real_escape_string($koneksi, $id_user);
    $query .= " AND m.id_user = '$id_user'";
}
if ($tgl_lelang != '' && $tgl_selesai != '') {
    $tgl_lelang = mysqli_real_escape_string($koneksi, $tgl_lelang);
    $tgl_selesai = mysqli_real_escape_string($koneksi, $tgl_selesai);
    $query .= " AND l.tgl_lelang BETWEEN '$tgl_lelang' AND '$tgl_selesai'";
}
if ($transmisi != '') {
    $transmisi = mysqli_real_escape_string($koneksi, $transmisi);
    $query .= " AND b.transmisi = '$transmisi'";
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

    <h2>Laporan Pengguna</h2>

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
            <th>Nama Lengkap</th>
            <th>ID</th>
            <th>Barang</th>
            <th>Transmisi</th>
            <th>Tanggal Penawaran</th>
            <th>Harga Tawar</th>
            <th>Pemenang</th>
        </tr>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                    <td><?= htmlspecialchars($row['id_user']) ?></td>
                    <td><?= htmlspecialchars($row['nama_barang'])?></td>
                    <td><?= htmlspecialchars($row['transmisi']) ?></td>
                    <td><?= htmlspecialchars($row['tgl_penawaran']) ?></td>
                    <td><?= htmlspecialchars($row['harga_penawaran']) ?></td>
                    <td><?= htmlspecialchars($row['pemenang'] ?? '-') ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Tidak ada data lelang sesuai filter.</td>
            </tr>
        <?php endif; ?>
    </table>

</body>

</html>