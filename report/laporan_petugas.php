<?php
session_start();
include '../config/koneksi.php';

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

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Laporan Petugas</title>
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

    <h2>Laporan Petugas</h2>

    <form method="GET" action="">
        <label>Level:
            <select name="level">
                <option value="" <?= $id_level == '' ? 'selected' : '' ?>>Semua</option>
                <option value="level" <?= $id_level == '1' ? 'selected' : '' ?>>Admin</option>
                <option value="level" <?= $id_level == '2' ? 'selected' : '' ?>>Petugas</option>
            </select>
        </label>

        <button type="submit">Filter</button>
    </form>

    <table border="1" cellpadding="4" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Status</th>
            <th>Username</th>
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
                <td colspan="5">Tidak ada data.</td>
            </tr>
        <?php endif; ?>
    </table>
    
    <button onclick="window.print()" class="no-print">Cetak Laporan</button>

</body>

</html>