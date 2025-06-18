<?php

include __DIR__ . '/../config/koneksi.php';

if(!isset($_SESSION['id_user'])){
    echo "<script>
        alert('Silakan login terlebih dahulu.');
        window.location.href = '/bidcar/views/login.php';
    </script>";
    exit;
}

$query = "SELECT b.id_barang, b.nama_barang, b.gambar, l.id_lelang, l.status, l.tgl_lelang   
        AS tgl, b.transmisi  AS transmisi, b.harga_awal, COALESCE(l.harga_akhir, b.harga_awal) 
        AS harga_terkini FROM tb_barang b JOIN tb_lelang l ON b.id_barang = l.id_barang 
        WHERE l.status = 'dibuka' ORDER BY l.tgl_lelang DESC
";


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
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            padding: 20px;
        }


        .card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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

        a.card-link {
            text-decoration: none;
            color: inherit;
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
            <a href="/bidcar/views/penawaran.php?id_barang=<?= $row['id_barang'] ?>&id_lelang=<?= $row['id_lelang'] ?>">
                <div class="card">
                    <img src="/bidcar/dir/img/<?= $row['gambar'] ?>" alt="<?= $row['nama_barang'] ?>">
                    <div class="card-body">
                        <h3><?= strtoupper($row['nama_barang']) ?></h3>
                        <p><i class="fa-solid fa-calendar"></i> <?= date("d F Y", strtotime($row['tgl'])) ?></p>
                        <p><i class="fa-solid fa-car-side"></i> <?= $row['transmisi'] ?></p>
                        <div class="price">Rp<?= number_format($row['harga_awal'], 0, ',', '.') ?></div>
                        <p class="price">Tawaran saat ini<br><span>Rp<?= number_format($row['harga_terkini'], 0, ',', '.') ?></span></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </a>
    </div>
</body>

</html>