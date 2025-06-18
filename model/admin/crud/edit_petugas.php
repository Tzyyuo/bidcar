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

if (isset($_GET['id_petugas'])) {
    $id_petugas = $_GET['id_petugas'];

    $stmt = $koneksi->prepare("SELECT * FROM tb_petugas WHERE id_petugas = ?");
    $stmt->bind_param("i", $id_petugas); 
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
}

if (isset($_POST['submit'])) {
    $nama = $_POST['nama_petugas'];
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $level = $_POST['level'];

  
    $stmt = $koneksi->prepare("UPDATE tb_petugas SET nama_petugas = ?, username = ?, password = ?, id_level = ? WHERE id_petugas = ?");
    $stmt->bind_param("ssssi", $nama, $username, $password, $level, $id_petugas);

    if ($stmt->execute()) {
        echo "<script>
                alert('Data berhasil diupdate');
                window.location.href = '/bidcar/model/admin/data_petugas.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal update data');
              </script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Petugas - Admin</title>
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <link rel="stylesheet" href="../../../css/edit_petugas.css">
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

        <h1>Edit Petugas | Admin</h1>

            <div class="hal-judul">
            </div>
            <div class="tambah-petugas">
                <form method="POST" action="" class="form-container">

                <div class="form-group">
                    <label for="nama_petugas">Nama</label>
                    <input type="text" id="nama_petugas" name="nama_petugas" value="<?php echo isset($data['nama_petugas']) ? $data['nama_petugas'] : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>" required>
                </div>


                    <div class="form-row">
                        <div class="form-column">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" value="<?php echo isset($data['password']) ? $data['password'] : ''; ?>" required>
                        </div>

                        <div class="form-column">
                            <label for="level">Status</label>
                            <select id="level" name="level" required>
                                <option value="1" <?= (isset($data['id_level']) && $data['id_level'] == '1') ? 'selected' : '' ?>>Admin</option>
                                <option value="2" <?= (isset($data['id_level']) && $data['id_level'] == '2') ? 'selected' : '' ?>>Petugas</option>
                            </select>
                        </div>
                    </div>


                    <button type="submit" name="submit" class="submit-btn">Edit</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
