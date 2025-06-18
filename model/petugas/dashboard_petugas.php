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


$query_petugas = "SELECT nama_petugas FROM tb_petugas WHERE id_petugas = ?";
$stmt = mysqli_prepare($koneksi, $query_petugas);


if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id_petugas);
    mysqli_stmt_execute($stmt);
    $result_petugas = mysqli_stmt_get_result($stmt);

    
    $row = mysqli_fetch_assoc($result_petugas); 


    if (!$row) {
       
        echo "<script>
            alert('Data petugas tidak ditemukan. Silakan login ulang.');
            window.location.href = '../views/login_petugas.php';
        </script>";
        session_destroy(); 
        exit;
    }

    mysqli_stmt_close($stmt); 
} else {
   
    die("Error menyiapkan statement: " . mysqli_error($koneksi));
}

//ttl brg
$total_barang = mysqli_query($koneksi, "SELECT COUNT(*) as total_barang FROM tb_barang");
$total4 = mysqli_fetch_assoc($total_barang);

//ttl lelang
$total_lelang = mysqli_query($koneksi, "SELECT COUNT(*) as total_lelang FROM tb_lelang WHERE status = 'dibuka'");
$total5 = mysqli_fetch_assoc($total_lelang);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <title>Dashboard - Petugas</title>
    <link rel="stylesheet" href="../../css/dashboard_petugas.css">
</head>
<body>
    <div class="container">
    
        <!-- Sidebar -->
        <div class="sidebar">
        <h1>BidCar.</h1>
        <hr class="sidebar-divider" />

        <ul>
            <li class="active"><a href="/bidcar/model/petugas/dashboard_petugas.php"><img src="../../img/dashboard-icon.svg" alt="dashboard"/>Dashboard</a></li>
            <li><a href="/bidcar/model/petugas/data_barang.php"><img src="../../img/barang-icon.svg" alt="barang"/>Data Barang</a></li>
            <li><a href="/bidcar/model/petugas/data_lelang.php"><img src="../../img/lelang-icon.svg" alt="lelang"/>Data Lelang</a></li>
        </ul>

        <hr class="sidebar-divider" />
        <form method="GET" action="../controllers/logout_controllers.php">
            <button type="button" name="logout" class="logout-btn">
            <a href="/bidcar/controllers/logout_controllers.php"><img src="../../img/logout-icon.svg" alt="logout"/>Logout</a>
            </button>
        </form>
        </div>
        <!-- End Sidebar -->

        <!-- Content -->
        <div class="content">
            <div class="navbar-content"> 
                <div class="navbar-left">
                    <img src="../../img/bidcar signup.svg" alt="logo" class="header-logo"/> 
                </div>
                <div class="header-right">
                <a href="../../views/profile-petugas.php">
                    <div class="admin-profile">
                        <?php
                        //nambah profil
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

        <div class="header-admin"><h1>Dashboard Petugas</h1></div>

            <div class="card-grid">
            <div class="card-blue">
            <h4>Total Barang <img src="../../img/barang-icon-outlined.svg" /></h4>
            <h2><?= $total4 ['total_barang']?></h2>
            </div>
            <div class="card-coklat">
            <h4>Lelang Aktif <img src="../../img/lelangaktif-icon-outlined.svg" /></h4>
            <h2><?= $total5 ['total_lelang']?></h2>
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