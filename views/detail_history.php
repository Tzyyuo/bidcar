<?php
include '../../config/koneksi.php';

$id_lelang = $_GET['id_lelang'] ?? null;
if (!$id_lelang) {
    echo "Lelang tidak ditemukan.";
    exit;
}

// Ambil detail lelang dan barang
$query = "SELECT l.*, b.*, p.nama_lengkap AS nama_petugas 
FROM tb_lelang l 
JOIN tb_barang b ON l.id_barang = b.id_barang 
LEFT JOIN tb_petugas p ON l.id_petugas = p.id_petugas 
WHERE l.id_lelang = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_lelang);
$stmt->execute();
$detail = $stmt->get_result()->fetch_assoc();

// Ambil peserta lelang
$query2 = "SELECT h.*, m.nama_lengkap 
FROM tb_history_lelang h 
JOIN tb_masyarakat m ON h.id_user = m.id_user 
WHERE h.id_lelang = ? 
ORDER BY h.penawaran DESC";
$stmt2 = $koneksi->prepare($query2);
$stmt2->bind_param("i", $id_lelang);
$stmt2->execute();
$peserta = $stmt2->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Lelang</title>
</head>
<body>
    <h1><?= $detail['nama_barang'] ?></h1>
    <img src="/bidcar/img/<?= $detail['gambar'] ?>" alt="" style="max-width:300px;">
    <p><strong>Lokasi:</strong> <?= $detail['lokasi'] ?></p>
    <p><strong>Transmisi:</strong> <?= $detail['transmisi'] ?></p>
    <p><strong>Harga Awal:</strong> Rp<?= number_format($detail['harga_awal'], 0, ',', '.') ?></p>
    <p><strong>Harga Tertinggi:</strong> Rp<?= number_format($detail['harga_akhir'], 0, ',', '.') ?></p>
    <p><strong>Ditangani oleh:</strong> <?= $detail['nama_petugas'] ?? '-' ?></p>

    <h2>Peserta Lelang</h2>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Penawaran</th>
            <th>Status</th>
        </tr>
        <?php $no = 1; while ($row = $peserta->fetch_assoc()): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_lengkap'] ?></td>
            <td>Rp<?= number_format($row['penawaran'], 0, ',', '.') ?></td>
            <td><?= ucfirst($row['status']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
