<?php
include '../config/koneksi.php';
$query = "SELECT * FROM tb_barang 
          INNER JOIN tb_lelang ON tb_barang.id_barang = tb_lelang.id_barang
          WHERE tb_lelang.status = 'dibuka' 
          ORDER BY tb_lelang.tgl_lelang DESC";
$result = mysqli_query($koneksi, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Daftar Lelang</title>
    <link rel="stylesheet" href="style.css">
    <style>
    body {
    font-family: Arial, sans-serif;
    background: #f3f8fc;
    margin: 0;
    padding: 20px;
}

.back-button {
    margin-bottom: 20px;
    padding: 8px 16px;
    border: 1px solid black;
    background: transparent;
    cursor: pointer;
    border-radius: 8px;
}

.card-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 24px;
}

.card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
}

.card img {
    width: 100%;
    height: 160px;
    object-fit: cover;
}

.card-body {
    padding: 16px;
}

.card-body h3 {
    font-size: 1rem;
    margin-bottom: 8px;
}

.card-body p {
    margin: 4px 0;
    font-size: 0.85rem;
    color: #444;
}

.price {
    margin-top: 10px;
    font-weight: bold;
    color: #111;
    font-size: 1rem;
}
</style>
</head>
<body>
    <button class="back-button">Daftar Lelang</button>

    <div class="card-container">
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="card">
                <img src="../img/<?= $row['gambar'] ?>" alt="<?= $row['nama_barang'] ?>">
                <div class="card-body">
                    <h3><?= strtoupper($row['nama_barang']) ?></h3>
                    <p><i class="fa-solid fa-calendar"></i> <?= date("d F Y", strtotime($row['tgl'])) ?></p>
                    <p><i class="fa-solid fa-location-dot"></i> <?= $row['lokasi'] ?? '-' ?></p>
                    <p><i class="fa-solid fa-car-side"></i> <?= $row['transmisi'] ?></p>
                    <div class="price">Rp <?= number_format($row['harga_awal'], 0, ',', '.') ?></div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>

</html>