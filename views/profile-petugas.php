<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id_petugas'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu.');
        window.location.href = '/bidcar/views/login.php';
    </script>";
    exit;
}

$id_petugas = $_SESSION['id_petugas'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_petugas WHERE id_petugas = '$id_petugas'");
$row = mysqli_fetch_assoc($query);


$default_profile_image = 'default.png'; 
$placeholder_icon_image = 'profile-pfp.svg'; 

$foto_path = '';
if (isset($row['foto']) && !empty($row['foto']) && $row['foto'] != $default_profile_image) {

    $foto_path = htmlspecialchars($row['foto']);
} else {
    $foto_path = $placeholder_icon_image;
}

if (isset($_POST['simpan'])) {
    $nama_petugas = $_POST['nama_petugas'];
    $username = $_POST['username'];
   

    if (isset($_SESSION['id_petugas'])) {
        $id_user = $_SESSION['id_petugas'];

        // Update profile
        mysqli_query($koneksi, "UPDATE tb_petugas SET nama_petugas='$nama_petugas', username='$username' WHERE id_petugas='$id_petugas'");


        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0 && $_FILES['foto']['size'] > 0) {
        $nama_file = $_FILES['foto']['name'];
        $tmp_file = $_FILES['foto']['tmp_name'];
        $upload_dir = "../img/"; 
        $path = $upload_dir . $nama_file;

      
        $allowed_ext = ['jpg', 'jpeg', 'png'];
        $file_ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_ext)) {
            if (move_uploaded_file($tmp_file, $path)) {
          
                if (!empty($row['foto']) && $row['foto'] != $default_profile_image && file_exists($upload_dir . $row['foto'])) {
                    unlink($upload_dir . $row['foto']); 
                }
                mysqli_query($koneksi, "UPDATE tb_petugas SET foto='$nama_file' WHERE id_petugas='$id_petugas'");
              
                $row['foto'] = $nama_file;
            } else {
                   $_SESSION['flash'] = [
                'icon' => 'error',
                'title' => 'Gagal mengunggah foto!',
                'text' => 'Silakan coba lagi.'];
                header("Location: /bidcar/views/profile-petugas.php");
            }
        } else {
        $_SESSION['flash'] = [
        'icon' => 'success',
        'title' => 'Profil berhasil diperbarui!',
        'text' => 'Perubahan telah disimpan.'];
        
        $_SESSION['flash_redirect'] = '/bidcar/model/petugas/dashboard_petugas.php'; 
        header("Location: /bidcar/views/profile-petugas.php");
        exit;
        }
    }
    
    $_SESSION['flash'] = [
    'icon' => 'success',
    'title' => 'Profil berhasil diperbarui!',
    'text' => 'Perubahan telah disimpan.'];
    
    $_SESSION['flash_redirect'] = '/bidcar/model/petugas/dashboard_petugas.php';
    header("Location: /bidcar/views/profile-petugas.php");
    exit;
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile</title>
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <link rel="stylesheet" href="../css/profile-petugas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css"><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="profile-container">
            
            <!-- FOTO -->
            <div class="image-section">
                <img id="previewFoto" src="../img/<?= $foto_path ?>" class="foto-profile" alt="Foto Profil">

                <label for="uploadFoto" class="edit-icon">
                    <img src="../img/edit.svg" alt="edit">
                </label>
                <input type="file" id="uploadFoto" name="foto" accept="image/*" onchange="previewGambar(event)" style="display: none;" />
            </div>

            <div class="form-section">
                <div class="logo">
                    <img src="../img/bidcar signup.svg" alt="Logo BidCar" style="height: 40px;">
                </div>
                <h2>Profile</h2>

                <label for="nama_petugas">Nama</label>
                <input class="name-input" type="text" id="nama_petugas" name="nama_petugas" value="<?= $row['nama_petugas'] ?? '' ?>" required>

                <label for="username">Username</label>
                <input class="user-input" type="text" id="username" name="username" value="<?= $row['username'] ?? '' ?>" required>

                <button type="submit" class="btn-submit" name="simpan">Simpan</button>
            </div>
        </div>
    </form>

    <script>
        function previewGambar(event) {
            const input = event.target;
            const reader = new FileReader();

            reader.onload = function () {
                const img = document.getElementById('previewFoto');
                img.src = reader.result;
            };

            if (input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
       <script>
        window.addEventListener("pageshow", function(event) {
            if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
                window.location.reload(); // Paksa reload untuk deteksi session
            }
        });
    </script>
    <?php include '../controllers/notifikasi.php'; ?>
</body>

</html>