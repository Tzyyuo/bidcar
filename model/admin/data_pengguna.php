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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna - Admin</title>
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <link rel="stylesheet" href="../../css/data_pengguna.css">
</head>
<body>
    <div class="main-wrapper">
        <div class="sidebar">
            <h1>BidCar.</h1>
            <hr class="sidebar-divider"/>

            <ul>
                <li><a href="/bidcar/model/admin/dashboard_admin.php"><img src="../../img/dashboard-icon.svg" alt="dashboard"/>Dashboard</a></li>
                <li><a href="/bidcar/model/admin/data_barang.php"><img src="../../img/barang-icon.svg" alt="barang"/>Data Barang</a></li>
                <li><a href="/bidcar/model/admin/data_lelang.php"><img src="../../img/lelang-icon.svg" alt="lelang"/>Data Lelang</a></li>
                <li><a href="/bidcar/model/admin/data_petugas.php"><img src="../../img/admin-icon.svg" alt="admin"/>Data Petugas</a></li>
                <li class="active"><a href="/bidcar/model/admin/data_pengguna.php"><img src="../../img/user-icon.svg" alt="user"/>Data User</a></li>
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
                    <img src="../../img/bidcar alt color 3.svg" alt="BidCar Logo" class="header-logo">
                </div>
                <div class="header-right">
                <a href="../../views/profile-admin.php">
                    <div class="admin-profile">
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

            <h1>Data User</h1>

            <div class="table-section">
                <div class="table-actions">
                    <a href="../../report/laporan_user.php"><button type="button" class="cetak-laporan-btn"><img src="../../img/cetak-icon.svg" alt="print">Cetak Laporan</button></a>

                </div>

                <div class="list-pengguna">
                    <table>
                        <thead>
                            <tr>
                                <th class="col-no">No</th>
                                <th class="col-nama">Nama</th>
                                <th class="col-username">Username</th>
                                <!-- <th class="col-password">Password</th> -->
                                <th class="col-no-telp">NO Telepon</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $nomor = 1;
                            $query = "SELECT * FROM tb_masyarakat order by id_user asc";
                            $result = mysqli_query($koneksi, $query);
                            ?>
                            
                            <tr>

                                <?php 

                                while($row = mysqli_fetch_array($result)) {
                                $nama_lengkap = $row['nama_lengkap'];
                                $username = $row['username'];
                                $password = $row['password'];
                                $telp = $row['telp'];
                                ?>

                                <th><?php echo $nomor++ ?></th>
                                <td><?php echo $nama_lengkap?></td>
                                <td><?php echo $username ?></td>
                                <!-- <td><?php // echo $password ?></td> -->
                                <td><?php echo $telp?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        <script>
        window.addEventListener("pageshow", function(event) {
            if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
                window.location.reload();
            }
        });
    </script>
</body>
</html>