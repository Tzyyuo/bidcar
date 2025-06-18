<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu.');
        window.location.href = '/bidcar/views/login.php';
    </script>";
    exit;
}

$id_user = $_SESSION['id_user'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_masyarakat WHERE id_user = '$id_user'");
$row = mysqli_fetch_assoc($query);

if (isset($_POST['simpan'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $telp = $_POST['telp'];

    if (isset($_SESSION['id_user'])) {
        $id_user = $_SESSION['id_user'];

      
        mysqli_query($koneksi, "UPDATE tb_masyarakat SET nama_lengkap='$nama_lengkap', username='$username', telp='$telp' WHERE id_user='$id_user'");

      
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0 && $_FILES['foto']['size'] > 0) {
            $nama_file = $_FILES['foto']['name'];
            $tmp_file = $_FILES['foto']['tmp_name'];
            $path = "../img/" . $nama_file;

            if (move_uploaded_file($tmp_file, $path)) {
                mysqli_query($koneksi, "UPDATE tb_masyarakat SET foto='$nama_file' WHERE id_user='$id_user'");
            } else {
                 $_SESSION['flash'] = [
                'icon' => 'error',
                'title' => 'Gagal mengunggah foto!',
                'text' => 'Silakan coba lagi.'
            ];
            header("Location: /bidcar/views/profile.php");
            exit;
            }
        }
          $_SESSION['flash'] = [
                'icon' => 'success',
                'title' => 'Profil berhasil diperbarui!',
                'text' => 'Perubahan telah disimpan.'
            ];
            header("Location: /bidcar/views/profile.php");
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
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css"><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="profile-container">
            
            <!-- FOTO -->
            <div class="image-section">
                <img id="previewFoto" src="../img/<?= $row['foto'] != '' ? $row['foto'] : 'default.png' ?>" class="foto-profile" alt="Foto Profil">

                <label for="uploadFoto" class="edit-icon">
                    <i class="fa-solid fa-pen"></i>
                </label>
                <input type="file" id="uploadFoto" name="foto" accept="image/*" onchange="previewGambar(event)" style="display: none;" />
            </div>

            <div class="form-section">
                <div class="logo">
                    <img src="../img/bidcar signup.svg" alt="Logo BidCar" style="height: 40px;">
                </div>
                <h2>Profile</h2>

                <label for="nama_lengkap">Nama Lengkap</label>
                <input class="name-input" type="text" id="nama_lengkap" name="nama_lengkap" value="<?= $row['nama_lengkap'] ?? '' ?>" required>

                <div class="row">
                    <div class="col">
                        <label for="username">Username</label>
                        <input class="user-input" type="text" id="username" name="username" value="<?= $row['username'] ?? '' ?>" required>
                    </div>
                    <div class="col">
                        <label for="telp">No Telepon</label>
                        <input class="telp-input" type="text" id="telp" name="telp" value="<?= $row['telp'] ?? '' ?>" required>
                    </div>
                </div>

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
                window.location.reload(); 
            }
        });
    </script>
    <?php if (isset($_SESSION['flash'])): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: '<?= $_SESSION['flash']['icon'] ?>',
        title: '<?= $_SESSION['flash']['title'] ?>',
        text: '<?= $_SESSION['flash']['text'] ?>',
        timer: 1800,
        showConfirmButton: false
    
    }).then(() => {
        window.location.href = '/bidcar/model/masyarakat/laman_masyarakat.php'; 
        });
</script>
<?php unset($_SESSION['flash']); endif; ?>
</body>
</html>