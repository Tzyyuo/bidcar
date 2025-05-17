<?php
include '../config/koneksi.php';
session_start();

// Pastikan user sudah login
$id_user = $_SESSION['id_user'] ?? null;
if (!$id_user) {
    die("Anda harus login untuk menawar.");
}

if (!isset($_POST['penawaran'])) {
    die("Akses tidak valid.");
}

// Ambil POST dan bersihkan
$id_lelang        = (int) $_POST['id_lelang'];
$raw_harga        = $_POST['harga_penawaran'] ?? null;
// Hilangkan semua non-digit (titik/koma) lalu cast ke integer
$harga_penawaran  = (int) preg_replace('/\D/', '', $raw_harga);

// 1. Ambil harga_awal dari tb_lelang → tb_barang
$stmt1 = $koneksi->prepare("
    SELECT b.harga_awal 
    FROM tb_lelang l
    JOIN tb_barang b ON l.id_barang = b.id_barang 
    WHERE l.id_lelang = ?
");
$stmt1->bind_param("i", $id_lelang);
$stmt1->execute();
$res1 = $stmt1->get_result();
$row1 = $res1->fetch_assoc();
$stmt1->close();

if (!$row1) {
    die("Lelang tidak ditemukan.");
}

$harga_awal = (int) $row1['harga_awal'];

// 2. Ambil harga tertinggi dari tb_penawaran (fallback ke 0)
$stmt2 = $koneksi->prepare("
    SELECT MAX(harga_penawaran) AS tertinggi 
    FROM tb_penawaran 
    WHERE id_lelang = ?
");
$stmt2->bind_param("i", $id_lelang);
$stmt2->execute();
$res2 = $stmt2->get_result();
$row2 = $res2->fetch_assoc();
$stmt2->close();

$harga_tertinggi = $row2['tertinggi'] !== null 
    ? (int) $row2['tertinggi'] 
    : 0;

// 3. Tentukan threshold: harus lebih besar dari harga_awal **dan** harga_tertinggi
$threshold = max($harga_awal, $harga_tertinggi);

if ($harga_penawaran <= $threshold) {
    die("Penawaran harus lebih tinggi dari Rp " . number_format($threshold, 0, ',', '.'));
}

// 4. Insert penawaran baru
$stmt3 = $koneksi->prepare("
    INSERT INTO tb_penawaran (id_lelang, id_user, harga_penawaran, tgl_penawaran) 
    VALUES (?, ?, ?, NOW())
");
$stmt3->bind_param("iii", $id_lelang, $id_user, $harga_penawaran);
$stmt3->execute();
$stmt3->close();

// 5. Update harga_akhir di tb_lelang
$stmt4 = $koneksi->prepare("
    UPDATE tb_lelang 
    SET harga_akhir = ? 
    WHERE id_lelang = ?
");
$stmt4->bind_param("ii",$harga_penawaran, $id_lelang);
$stmt4->execute();
$stmt4->close();

echo "Penawaran Rp " . number_format($harga_penawaran,0,',','.') . " berhasil disimpan!";
?>
















 <h2>Riwayat Lelang Anda</h2>

    <div>
        <a href="history_controller.php?filter=semua">Semua</a>
        <a href="history_controller.php?filter=menang">Menang</a>
        <a href="history_controller.php?filter=kalah">Kalah</a>
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Barang</th>
            <th>Penawaran</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
        <?php if (empty($data_history)): ?>
            <tr><td colspan="5">Tidak ada riwayat lelang.</td></tr>
        <?php else: ?>
            <?php foreach ($data_history as $i => $data): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($data['nama_barang']) ?></td>
                    <td>Rp<?= number_format($data['penawaran']) ?></td>
                    <td><?= ucfirst($data['status']) ?></td>
                    <td><?= $data['tanggal'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</body>
</html>

<body>
    <button class="back-button">Daftar Lelang</button>


    <div class="card-container">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <a href="/bidcar/views/penawaran.php?id_barang=<?= $row['id_barang'] ?>&id_lelang=<?= $row['id_lelang'] ?>"
                class="card-link">
                <div class="card">
                    <img src="/bidcar/img/<?= $row['gambar'] ?>" alt="<?= $row['nama_barang'] ?>">
                    <div class="card-body">
                        <h3><?= strtoupper($row['nama_barang']) ?></h3>
                        <p><i class="fa-solid fa-calendar"></i> <?= date("d F Y", strtotime($row['tgl'])) ?></p>
                        <p><i class="fa-solid fa-location-dot"></i> <?= $row['lokasi'] ?? '-' ?></p>
                        <p><i class="fa-solid fa-car-side"></i> <?= $row['transmisi'] ?></p>
                        <div class="price">Rp<?= number_format($row['harga_awal'], 0, ',', '.') ?></div>
                        <p class="price">Tawaran saat ini<br><span>Rp<?= number_format($row['harga_terkini'], 0, ',', '.') ?></span></p>
                    </div>
                </div>
            <?php endwhile; ?>
    </div>
 <h2>Riwayat Lelang Anda</h2>

    <div>
        <a href="history_controller.php?filter=semua">Semua</a>
        <a href="history_controller.php?filter=menang">Menang</a>
        <a href="history_controller.php?filter=kalah">Kalah</a>
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Barang</th>
            <th>Penawaran</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
        <?php if (empty($data_history)): ?>
            <tr><td colspan="5">Tidak ada riwayat lelang.</td></tr>
        <?php else: ?>
            <?php foreach ($data_history as $i => $data): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($data['nama_barang']) ?></td>
                    <td>Rp<?= number_format($data['penawaran']) ?></td>
                    <td><?= ucfirst($data['status']) ?></td>
                    <td><?= $data['tanggal'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</body>
</html>

<body>
    <button class="back-button">Daftar Lelang</button>


    <div class="card-container">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <a href="/bidcar/views/penawaran.php?id_barang=<?= $row['id_barang'] ?>&id_lelang=<?= $row['id_lelang'] ?>"
                class="card-link">
                <div class="card">
                    <img src="/bidcar/img/<?= $row['gambar'] ?>" alt="<?= $row['nama_barang'] ?>">
                    <div class="card-body">
                        <h3><?= strtoupper($row['nama_barang']) ?></h3>
                        <p><i class="fa-solid fa-calendar"></i> <?= date("d F Y", strtotime($row['tgl'])) ?></p>
                        <p><i class="fa-solid fa-location-dot"></i> <?= $row['lokasi'] ?? '-' ?></p>
                        <p><i class="fa-solid fa-car-side"></i> <?= $row['transmisi'] ?></p>
                        <div class="price">Rp<?= number_format($row['harga_awal'], 0, ',', '.') ?></div>
                        <p class="price">Tawaran saat ini<br><span>Rp<?= number_format($row['harga_terkini'], 0, ',', '.') ?></span></p>
                    </div>
                </div>
            <?php endwhile; ?>
    </div>
