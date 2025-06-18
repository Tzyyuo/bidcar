<?php 
session_start();
include '../../config/koneksi.php'; 

$id_petugas = $_SESSION['id_petugas']; 
$query = mysqli_query($koneksi, "SELECT * FROM tb_petugas WHERE id_petugas = '$id_petugas'");
$pfp = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Lelang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../../css/data_lelang-petugas.css">
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> 
</head>
<body>
    <div class="main-wrapper">
        <div class="sidebar">
            <h1>BidCar.</h1>
            <hr class="sidebar-divider"/>

            <ul>
                <li><a href="/bidcar/model/petugas/dashboard_petugas.php"><img src="../../img/dashboard-icon.svg" alt="dashboard"/>Dashboard</a></li>
                <li><a href="/bidcar/model/petugas/data_barang.php"><img src="../../img/barang-icon.svg" alt="barang"/>Data Barang</a></li>
                <li class="active"><a href="/bidcar/model/petugas/data_lelang.php"><img src="../../img/lelang-icon.svg" alt="lelang"/>Data Lelang</a></li>
            </ul>

            <hr class="sidebar-divider"/>
            <form method="GET" action="../controllers/logout_controllers.php">
                <button type="button" name="logout" class="logout-btn">
                    <a href="/bidcar/controllers/logout_controllers.php"><img src="../../img/logout-icon.svg" alt="logout"/>Logout</a>
                </button>
            </form>
        </div>

        <div class="content">
            <div class="navbar-content">
                <div class="navbar-left">
                    <img src="../../img/bidcar signup.svg" alt="BidCar Logo" class="header-logo">
                </div>
                <div class="header-right">
                    <a href="../../views/profile-petugas.php">
                        <div class="petugas-profile">
                            <?php
                            
                            $default_profile_image = 'default.png';
                            $placeholder_icon_image = 'profile-pfp.svg';

                            $foto_petugas_path = '';
                            if (isset($pfp['foto']) && !empty($pfp['foto']) && $pfp['foto'] != $default_profile_image) {
                                $foto_petugas_path = htmlspecialchars($pfp['foto']);
                            } else {
                                $foto_petugas_path = $placeholder_icon_image;
                            }
                            ?>

                            <img src="/bidcar/img/<?= $foto_petugas_path ?>" alt="Foto Petugas" class="petugas-icon">
                            <span><?= htmlspecialchars($pfp['username'])?></span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="header-lelang"><h1>Data Lelang</h1></div>

            <div class="table-section">
                <div class="table-actions">
                    <button onclick="openModal()" class="tambah-barang-btn"><img src="../../img/add-icon-petugas.svg" alt="add">Tambah Lelang</button>
                    <a href="../../report/laporan_lelang-petugas.php"><button type="button" class="cetak-laporan-btn"><img src="../../img/cetak-icon.svg" alt="print">Cetak Laporan</button></a>
                </div>

                <div class="list-barang">
                    <table> 
                        <thead>
                            <tr>
                                <th class="col-no">No</th>
                                <th class="col-barang-nama">Barang</th> 
                                <th class="col-harga-awal">Harga Awal</th>
                                <th class="col-harga-akhir">Harga Akhir</th>
                                <th class="col-tanggal">Tanggal Akhir</th>
                                <th class="col-pemenang">Pemenang</th>
                                <th class="col-status">Status</th>
                                <th class="col-infolanjut">Info Lanjut</th>
                                <!-- <th class="col-action">Action</th> -->
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
                                $harga_akhir = $row['harga_akhir'] ?? '-';
                                $tgl_lelang= date('d/m/Y', strtotime($row['tgl_lelang'])) ?? '-';
                                $tgl_selesai = date('d/m/Y', strtotime($row['tgl_selesai'])) ?? '-';
                                $pemenang = $row['nama_lengkap'] ?? '-';
                                $status = $row['status'] ?? 'ditutup';
                                $id_lelang = $row['id_lelang'];
                            ?>
                                <tr>
                                    <td><?= $nomor++ ?></td>
                                    <td class="barang-cell">
                                        <img src="../../dir/img/<?= $gambar ?>" alt="<?= $nama_barang ?>" class="barang-img">
                                        <span><?= $nama_barang ?></span>
                                    </td>
                                    <td>Rp <?= number_format($harga_awal, 0, ',', '.') ?></td>
                                    <td><?= is_numeric($harga_akhir) ? 'Rp ' . number_format($harga_akhir, 0, ',', '.') : $harga_akhir ?></td>
                                    <td><?= $tgl_selesai ?></td>
                                    <td><?= $pemenang ?></td>
                                    <td>
                                        <span class="status-badge <?= $status === 'dibuka' ? 'status-badge-open' : 'status-badge-close' ?>">
                                            <?= ucfirst($status) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="info_lebih_lanjut.php?id_lelang=<?= $row['id_lelang']; ?>" class="btn-info-lanjut">...</a>
                                    </td>
                                    <td>
                                        <!-- <a href="../../controllers/hapus_lelang.php?id_lelang=<?= $row['id_lelang']; ?>" class="btn-action delete" onclick="return confirm('Yakin hapus data ini?')"> <i class="fa-solid fa-trash"></i></a> -->
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="modalTambahLelang" class="modal">
        <div class="modal-content">
            <div class="header-modal">
                <h2>Tambah Data Lelang</h2> 
                <span class="close" onclick="closeModal()"><img src="../../img/close-popup.svg" alt="close"></span>
            </div>
            <hr>
            <form action="../../controllers/buat_lelang_controllers.php" method="POST">
                <div class="content-group">
                    <div class="form-group">
                        <label for="id_barang">Pilih Barang</label>
                        <select name="id_barang" required>
                            <option value="">--Pilih Barang--</option>
                            <?php
                            $barang = mysqli_query($koneksi, "SELECT * FROM tb_barang WHERE id_barang NOT IN (SELECT id_barang FROM tb_lelang)");
                            while ($b = mysqli_fetch_assoc($barang)) {
                                echo "<option value='{$b['id_barang']}'>{$b['nama_barang']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="tgl_lelang">Tanggal Awal</label>
                        <input type="date" name="tgl_lelang" id="tgl_lelang" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="tgl_selesai">Tanggal Akhir</label>
                        <input type="date" name="tgl_selesai" required>
                    </div>
                </div>

                <button type="submit" name="simpan" class="modal-submit-btn">Tambah</button>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById("modalTambahLelang").style.display = "flex";

            // Set nilai input tanggal lelang ke tanggal hari ini
            var tglLelangInput = document.getElementById("tgl_lelang");
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;

            tglLelangInput.value = today;
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
</body>
</html>