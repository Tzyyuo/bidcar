<?php
session_start();
include '../../config/koneksi.php';

if (!isset($_GET['id_lelang'])) {
    echo "Lelang tidak ditemukan.";
    exit;
}

$id_lelang = $_GET['id_lelang'];

// Ambil detail lelang + barang
$query = "SELECT l.*, b.nama_barang, b.harga_awal, b.gambar, b.deskripsi_barang, b.lokasi, b.transmisi, b.tgl
          FROM tb_lelang l
          JOIN tb_barang b ON l.id_barang = b.id_barang
          WHERE l.id_lelang = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_lelang);
$stmt->execute();
$result = $stmt->get_result();
$lelang = $result->fetch_assoc();

// Ambil penawar
$query_penawar = "SELECT h.penawaran_harga, m.nama_lengkap
                  FROM history_lelang h
                  JOIN tb_masyarakat m ON h.id_user = m.id_user
                  WHERE h.id_lelang = ?";
$stmt = $koneksi->prepare($query_penawar);
$stmt->bind_param("i", $id_lelang);
$stmt->execute();
$penawar = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Lelang - BidCar</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: white;
            padding: 20px;
            border-right: 1px solid #ddd;
        }

        .sidebar h1 {
            color: #2b6cb0;
            font-weight: bold;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin-top: 30px;
        }

        .sidebar li {
            margin-bottom: 20px;
        }

        .sidebar a {
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
        }

        .content {
            flex: 1;
            padding: 40px;
            background: #fff;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .image {
            width: 350px;
            height: auto;
            border-radius: 10px;
            overflow: hidden;
        }

        .detail {
            flex: 1;
            padding-left: 40px;
        }

        .car-info {
            display: flex;
        }

        .info-title {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .description {
            margin-top: 10px;
            line-height: 1.6;
        }

        .price {
            font-weight: bold;
            font-size: 1.2em;
            margin-top: 10px;
        }

        .lelang-controls {
            margin-top: 20px;
        }

        .radio-wrap {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .btn-confirm {
            background-color: #ccc;
            color: #888;
            border: none;
            padding: 10px 20px;
            cursor: not-allowed;
            border-radius: 5px;
            transition: 0.3s;
            margin-top: 15px;
        }

        .btn-confirm.active {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <h1>BidCar.</h1>
            <ul>
                <li><a href="dashboard_petugas.php">Dashboard</a></li>
                <li><a href="data_barang.php">Barang</a></li>
                <li><a href="data_lelang.php">Data Lelang</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="top-bar">
                <h2>Info Lebih Lanjut</h2>
                <div>Petugas</div>
            </div>
            <div class="car-info">
                <div class="image">
                    <img src="../../img/<?= $lelang['gambar'] ?>" width="100%" alt="Gambar Barang">
                </div>
                <div class="detail">
                    <h3 class="info-title"><?= strtoupper($lelang['nama_barang']) ?></h3>

                    <p class="tgl-transmisi"></p><?= $lelang['tgl'] ?><br>
                    ⚙️ <?= $lelang['transmisi'] ?></>

                    <p class="description"><?= $lelang['deskripsi_barang'] ?></p>
                    </p>
                    <p class="price">Harga Dasar Lelang<br><span> Rp <?= number_format($lelang['harga_awal']) ?></span></p>
                    <p>Harga Akhir Lelang<br><span>Rp <?= $lelang['harga_akhir'] ? 'Rp ' . number_format($lelang['harga_akhir']) : '-' ?></span></p>
                    <p>⏱️ Waktu tersisa 3 hari lagi</p>


                        <div class="form-status">
                             <form action="../../controllers/lelang_controllers.php" method="POST">
                            <input type="hidden" name="id_lelang" value="<?= $id_lelang ?>">

                            <label><input type="radio" name="status" value="dibuka"> Buka</label>
                            <label><input type="radio" name="status" value="ditutup"> Tutup</label>
                        </div>

                        <div class="form-konfirmasi">
                            <button type= "submit" class="btn-confirm" name="konfirmasi" id="btnKonfirmasi" disabled>Konfirmasi</button>
                        </div>


                        <script>
                            const radios = document.querySelectorAll('input[name="status"]');
                            const btn = document.getElementById('btnKonfirmasi');

                            radios.forEach(radio => {
                                radio.addEventListener('change', () => {
                                    btn.disabled = false;
                                    btn.classList.add('active');
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../../views/list_penawar.php'; ?>
</body>

</html>