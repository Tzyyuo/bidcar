<?php
session_start();
include '../../../config/koneksi.php';

if (!isset($_SESSION['id_petugas']) || !isset($_SESSION['level'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu.');
        window.location.href = '/bidcar/views/login.php';
    </script>";
    exit;
}

$id_petugas = $_SESSION['id_petugas'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_petugas WHERE id_petugas = '$id_petugas'");
$pfp = mysqli_fetch_assoc($query);

if(isset($_POST['submit'])) {
    $nama_petugas = $_POST['nama_petugas'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $level = $_POST['level'];

    $query ="INSERT INTO tb_petugas (nama_petugas, username, password, id_level) VALUES (?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("sssi", $nama_petugas, $username, $password, $level);
    
    if($stmt->execute()){
        
        echo "<script>
        alert('Data berhasil ditambahkan
        window.location.href = '/bidcar/model/admin/data_petugas.php';
      </script>";
      
      header("Location: /bidcar/model/admin/data_petugas.php");
      
      exit;
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Petugas - Admin</title>
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <link rel="stylesheet" href="../../../css/tambah_petugas.css">
</head>
<body>
        <div class="main-wrapper">
        <div class="sidebar">
            <h1>BidCar.</h1>
            <hr class="sidebar-divider"/>

            <ul>
                <li><a href="/bidcar/model/admin/dashboard_admin.php"><img src="../../../img/dashboard-icon.svg" alt="dashboard"/>Dashboard</a></li>
                <li><a href="/bidcar/model/admin/data_barang.php"><img src="../../../img/barang-icon.svg" alt="barang"/>Data Barang</a></li>
                <li><a href="/bidcar/model/admin/data_lelang.php"><img src="../../../img/lelang-icon.svg" alt="lelang"/>Data Lelang</a></li>
                <li class="active"><a href="/bidcar/model/admin/data_petugas.php"><img src="../../../img/admin-icon.svg" alt="admin"/>Data Petugas</a></li>
                <li><a href="/bidcar/model/admin/data_pengguna.php"><img src="../../../img/user-icon.svg" alt="user"/>Data User</a></li>
            </ul>

            <hr class="sidebar-divider" />
            <form method="GET" action="../controllers/logout_controllers.php">
                <button type="button" name="logout" class="logout-btn">
                    <a href="/bidcar/controllers/logout_controllers.php"><img src="../../../img/logout-icon.svg" alt="logout"/>Logout</a>
                </button>
            </form>
        </div>
        <div class="content">
            <div class="navbar-content"> <div class="navbar-left">
                    <img src="../../../img/bidcar alt color 3.svg" alt="BidCar Logo" class="header-logo">
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

        <h1>Form Tambah Petugas | Admin</h1>

            <div class="hal-judul">
            </div>
            <div class="tambah-petugas">
                <form method="POST" action="" class="form-container">

                <div class="form-group">
                    <label for="nama_petugas">Nama</label>
                    <input type="text" id="nama_petugas" name="nama_petugas" placeholder="Masukkan Nama Petugas/Admin" required>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan Username" required>
                </div>


                    <div class="form-row">
                        <div class="form-column">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                        </div>

                        <div class="form-column">
                            <label for="level">Status</label>
                            <select id="level" name="level" required>
                                <option value="" class="select-transmisi">-- Pilih Status --</option>
                                <option value="1">Admin</option>
                                <option value="2">Petugas</option>
                            </select>
                        </div>
                    </div>


                    <button type="submit" name="submit" class="submit-btn">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>