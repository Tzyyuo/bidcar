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
$jumlah_penawaran = $_GET['jumlah_penawaran'] ?? '';

// Query dasar

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
            <label>Jumlah Penawaran Minimum:
                <input type="number" name="jumlah_penawaran" value="<?= htmlspecialchars($jumlah_penawaran) ?>">
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
            <th>Nama Lengkap</th>
            <th>Username</th>
            <th>No Telepom</th>
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
                <td colspan="7">Tidak ada data lelang sesuai filter.</td>
            </tr>
        <?php endif; ?>
    </table>
    
    <button onclick="window.print()" class="no-print">Cetak Laporan</button>

</body>

</html>