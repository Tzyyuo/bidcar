<?php
session_start();

include '../config/koneksi.php';

// Cek session login
if (!isset($_SESSION['id_petugas']) || !isset($_SESSION['level'])) {
  echo "<script>
        alert('Silakan login terlebih dahulu.');
        window.location.href = '/bidcar/views/login.php';
    </script>";
  exit;
}

$transmisi = $_GET['transmisi'] ?? '';
$tgl = $_GET['tgl'] ?? '';

// Buat query dasar
$query = "SELECT * FROM tb_barang WHERE 1=1";

// Tambah filter transmisi jika ada
if ($transmisi != '') {
  $transmisi = mysqli_real_escape_string($koneksi, $transmisi);
  $query .= " AND transmisi = '$transmisi'";
}

// Tambah filter tanggal jika ada
if ($tgl != '') {
  $query .= " AND tgl = '$tgl'";
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
  <title>Laporan Barang</title>
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
  body * {
    visibility: hidden;
  }

  .print-area, .print-area * {
    visibility: visible;
  }

}
  </style>
</head>

<body>

  <h2>Laporan Barang</h2>

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

  <div class="print-area">
    <table>
      <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Tanggal</th>
        <th>Harga</th>
        <th>Transmisi</th>
      </tr>
      <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= htmlspecialchars($row['id_barang']) ?></td>
            <td><?= htmlspecialchars($row['nama_barang']) ?></td>
            <td><?= htmlspecialchars($row['tgl']) ?></td>
            <td><?= htmlspecialchars($row['harga_awal']) ?></td>
            <td><?= htmlspecialchars($row['transmisi']) ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="5">Tidak ada data.</td>
        </tr>
      <?php endif; ?>
    </table>
  </div>

  <button onclick="window.print()" class="no-print">Cetak Laporan</button>


</body>

</html>