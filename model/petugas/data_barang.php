<?php 
session_start();
include '../../config/koneksi.php'; 

if (!isset($_SESSION['id_petugas']) || !isset($_SESSION['level'])) {
   $_SESSION['flash'] = [
    'icon' => 'warning',
    'title' => 'Silakan login!',
    'text' => 'Tidak bisa mengakses laman'
    ];
    header("Location: /bidcar/views/login.php");
    exit;
}

$id_petugas = $_SESSION['id_petugas'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_petugas WHERE id_petugas = '$id_petugas'");
$pfp = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" >
    <title>Data Barang - Petugas</title>
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <link rel="stylesheet" href="../../css/data_barang-petugas.css">
</head>
<body>
    <div class="main-wrapper"> 
        <div class="sidebar">
            <h1>BidCar.</h1>
            <hr class="sidebar-divider"/>

            <ul>
                <li><a href="/bidcar/model/petugas/dashboard_petugas.php"><img src="../../img/dashboard-icon.svg" alt="dashboard"/>Dashboard</a></li>
                <li class="active"><a href="/bidcar/model/petugas/data_barang.php"><img src="../../img/barang-icon.svg" alt="barang"/>Data Barang</a></li>
                <li><a href="/bidcar/model/petugas/data_lelang.php"><img src="../../img/lelang-icon.svg" alt="lelang"/>Data Lelang</a></li>
            </ul>

            <hr class="sidebar-divider" />
            <form method="GET" action="../controllers/logout_controllers.php">
                <button type="button" name="logout" class="logout-btn">
                    <a href="/bidcar/controllers/logout_controllers.php"><img src="../../img/logout-icon.svg" alt="logout"/>Logout</a>
                </button>
            </form>
        </div>

        <div class="content-area"> 
            <div class="navbar-content"> 
                <div class="navbar-left">
                    <img src="../../img/bidcar signup.svg" alt="logo" class="header-logo"/> 
                </div>
                <div class="header-right">
                    <a href="../../views/profile-petugas.php">
                        <div class="petugas-profile">
                            <?php
                            // Menentukan nama file gambar default/ikon seperti di halaman profil
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

            <div class="header-barang"><h1>Data Barang</h1></div>

            <div class="table-section"> 
                <div class="table-actions">
                    <a href="../petugas/crud/tambah_barang.php"><button type="button" class="tambah-barang-btn"><img src="../../img/add-icon-petugas.svg" alt="tambah">Tambah Barang</button></a>
                    <a href="../../report/laporan_barang-petugas.php"><button type="button" class="cetak-laporan-btn"><img src="../../img/cetak-icon.svg" alt="print">Cetak Laporan</button></a>

                </div>
                
                <div class="list-barang">
                    <table> 
                        <thead>
                            <tr>
                                <th class="col-no">No</th>
                                <th class="col-barang-nama">Barang</th> 
                                <th class="col-transmisi">Transmisi</th>
                                <th class="col-tanggal">Tanggal</th>
                                <th class="col-harga-awal">Harga Awal</th>
                                <th class="col-status">Status</th>
                                <th class="col-thn">Tahun Rilis</th>
                                <th class="col-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nomor = 1;
                            $query2 = "SELECT * FROM tb_barang order by id_barang desc";
                            $result = mysqli_query($koneksi, $query2);
                            ?>
                            <?php while($row = mysqli_fetch_array($result)) { ?>
                                <tr>
                                    <td class="col-no"><?php echo $nomor++ ?></td>
                                    <td class="col-barang-nama-data"> <img src="/bidcar/dir/img/<?php echo $row['gambar']; ?>" alt="Barang" class="item-img">
                                        <span class="item-name"><?php echo $row['nama_barang'] ?></span> </td>
                                    <td class="col-transmisi"><?php echo $row['transmisi']?></td>
                                    <td class="col-tanggal"><?php echo date('d/m/Y', strtotime($row['tgl'])) ?></td>
                                    <td class="col-harga-awal">Rp <?php echo number_format($row['harga_awal'], 0, ',', '.') ?></td>
                                    <td class="col-status">
                                        <?php
                                            $status_lelang = $row['status'] ?? 'Belum Lelang';
                                            $status_class = '';
                                            if ($status_lelang == 'Sudah Dilelang') {
                                                $status_class = 'status-sudah-dilelang';
                                            } elseif ($status_lelang == 'Belum Lelang') {
                                                $status_class = 'status-belum-lelang';
                                            } elseif ($status_lelang == 'Dilelang') {
                                                $status_class = 'status-dilelang';
                                            }
                                        ?>
                                        <span class="status-badge <?php echo $status_class; ?>">
                                            <?php echo $status_lelang; ?>
                                        </span>
                                    </td>
                                        <td class="col-thn"><?php echo date('d/m/Y', strtotime($row['thn'])) ?></td>
                                    <td class="col-action">
                                        <div class="action-buttons">
                                            <a href="../petugas/crud/edit_barang.php?id_barang=<?= $row['id_barang']; ?>" class="action-btn edit-btn" title="Edit"><img src="../../img/edit-icon.svg" alt="edit"></a>
                                            <a href="../petugas/crud/hapus_barang.php?id_barang=<?= $row['id_barang']; ?>" class="action-btn delete-btn" title="Hapus" onclick="return confirm('Yakin hapus data ini?')"><img src="../../img/hapus-icon.svg" alt="edit"></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
    <script>
  window.addEventListener("pageshow", function (event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
      window.location.reload();
    }
  });
</script>
</body>
</html>