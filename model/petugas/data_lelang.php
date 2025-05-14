<?php
include '../../layouts/sidebar.php';
include '../../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Data Lelang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            width: 50%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            cursor: pointer;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 5px;
            color: white;
        }

        .badge-open {
            background-color: green;
        }

        .badge-close {
            background-color: red;
        }
    </style>

</head>

<body>
    <div class="head">
        <img src="../../img/bidcar.png">
        <h1>Data Lelang</h1>
    </div>

    <div class="container">
        <button onclick="openModal()" class="btn-tambah">+ Tambah Lelang</button>

        <!-- Modal -->
        <div id="modalTambahLelang" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Tambah Lelang</h2>
                <form action="../../controllers/buat_lelang_controllers.php" method="POST">
                    <label for="id_barang">Pilih Barang:</label>
                    <select name="id_barang" required>
                        <option value="">Pilih Barang</option>
                        <?php
                        $barang = mysqli_query($koneksi, "SELECT * FROM tb_barang WHERE id_barang NOT IN (SELECT id_barang FROM tb_lelang)");
                        while ($b = mysqli_fetch_assoc($barang)) {
                            echo "<option value='{$b['id_barang']}'>{$b['nama_barang']}</option>";
                        }
                        ?>
                    </select>

                    <br><br>
                    <label for="tgl_lelang">Tanggal Lelang:</label>
                    <input type="date" name="tgl_lelang" required><br><br>
                    <label for="tgl_selesai">Tanggal Akhir:</label>
                    <input type="date" name="tgl_selesai" required><br><br>

                    <button type="submit" name="simpan">Simpan Lelang</button>
                </form>
            </div>
        </div>
        <script>
            function openModal() {
                document.getElementById("modalTambahLelang").style.display = "block";
            }

            function closeModal() {
                document.getElementById("modalTambahLelang").style.display = "none";
            }
            window.onclick = function(event) {
                var modal = document.getElementById("modalTambahLelang");
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>

        <button type="button" class="cetak-laporan">Cetak Laporan</button>

        <div class="list-barang">
            <table border="1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga Awal</th>
                        <th>Harga Akhir</th>
                        <th>Tanggal Lelang</th>
                        <th>Tanggal Akhir</th>
                        <th>Pemenang</th>
                        <th>Status</th>
                        <th>Info Lanjut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomor = 1;
                    $query = "SELECT l.*, b.nama_barang, b.harga_awal, b.gambar, m.nama_lengkap 
                              FROM tb_lelang l
                              JOIN tb_barang b ON l.id_barang = b.id_barang
                              LEFT JOIN tb_masyarakat m ON l.id_user = m.id_user
                              ORDER BY l.id_lelang DESC";

                    $result = mysqli_query($koneksi, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $gambar = $row['gambar'];
                        $nama_barang = $row['nama_barang'];
                        $harga_awal = $row['harga_awal'];
                        $harga_akhir = $row['harga_akhir'] ?? 'Belum ada';
                        $tgl_lelang= $row['tgl_lelang'] ?? '-';
                        $tgl_selesai = $row['tgl_selesai'] ?? '-';
                        $pemenang = $row['nama_lengkap'] ?? 'Belum ada';
                        $status = $row['status'] ?? 'ditutup';
                        $id_lelang = $row['id_lelang'];
                    ?>
                        <tr>
                            <td><?= $nomor++ ?></td>
                            <td><img src="../../img/<?= $gambar ?>" width="100"></td>
                            <td><?= $nama_barang ?></td>
                            <td><?= number_format($harga_awal) ?></td>
                            <td><?= is_numeric($harga_akhir) ? number_format($harga_akhir) : $harga_akhir ?></td>
                            <td><?= $tgl_lelang?></td>
                            <td><?= $tgl_selesai ?></td>
                            <td><?= $pemenang ?></td>
                            <td>
                                <span class="badge <?= $status === 'dibuka' ? 'badge-open' : 'badge-close' ?>">
                                    <?= ucfirst($status) ?>
                                </span>
                            </td>
                            <td>
                                <button type="button"><a href="info_lebih_lanjut.php?id_lelang=<?= $row['id_lelang']; ?>">Info Lanjut</a></button>
                            </td>

                            <td>
                                <button type="submit" name="hapus"><a href="../../controllers/hapus_lelang.php?id_lelang=<?= $row['id_lelang']; ?>" class="btn-delete" title="Hapus" onclick="return confirm('Yakin hapus data ini?')"> <i class="fa-solid fa-trash"></i></a></button>
                            </td>
        
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>