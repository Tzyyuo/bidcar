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

if (isset($_POST['tambah_barang'])) {

    $nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $harga_awal_formatted = mysqli_real_escape_string($koneksi, $_POST['harga_awal']);

    $harga_awal = preg_replace('/[^0-9]/', '', $harga_awal_formatted);

    $tgl = mysqli_real_escape_string($koneksi, $_POST['tgl']);
    $deskripsi_barang = mysqli_real_escape_string($koneksi, $_POST['deskripsi_barang']);
    $transmisi = mysqli_real_escape_string($koneksi, $_POST['transmisi']);
    $thn =  mysqli_real_escape_string($koneksi, $_POST['thn']);

    $nama_file = $_FILES['gambar']['name'];
    $type_file = $_FILES['gambar']['type'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    $path = "../../../dir/img";
    $allowed_types = array('image/png', 'image/jpeg');
    $ukuran_file = $_FILES['gambar']['size'] ?? 0;
    $max_size = 2048000;


    $query = "INSERT INTO tb_barang (nama_barang, harga_awal, tgl, deskripsi_barang, transmisi, gambar, thn)
            VALUES ('$nama_barang', '$harga_awal', '$tgl', '$deskripsi_barang', '$transmisi', '$nama_file', '$thn')";
    $message = '';

    if (mysqli_query($koneksi, $query)) {
        $message = "Pendataan berhasil";
    } else {
        $message = "Gagal melakukan input data: " . mysqli_error($koneksi);
    }

    // Cek apakah file gambar diupload
    if ($_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        if (in_array($type_file, $allowed_types) && $ukuran_file <= $max_size) {
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }

            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/bidcar/dir/img/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            if (move_uploaded_file($tmp_file, $target_dir . $nama_file)) {
                $gambar = $path . $nama_file;
                $message .= "<br>Foto berhasil ditambahkan";
            } else {
                $message .= "<br>Gagal menambahkan foto";
            }
        } else {
            $message .= "<br>Format file tidak diizinkan atau ukuran terlalu besar.";
        }
    } else {
        $message .= "<br>Silakan upload gambar.";
    }

    mysqli_close($koneksi);
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendataan Barang</title>
    <link rel="stylesheet" href="../../../css/tambah_barang-admin.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> 
</head>
<body>
    <div class="main-wrapper">
        <div class="sidebar">
            <h1>BidCar.</h1>
            <hr class="sidebar-divider"/>

            <ul>
                <li><a href="/bidcar/model/admin/dashboard_admin.php"><img src="../../../img/dashboard-icon.svg" alt="dashboard"/>Dashboard</a></li>
                <li class="active"><a href="/bidcar/model/admin/data_barang.php"><img src="../../../img/barang-icon.svg" alt="barang"/>Data Barang</a></li>
                <li><a href="/bidcar/model/admin/data_lelang.php"><img src="../../../img/lelang-icon.svg" alt="lelang"/>Data Lelang</a></li>
                <li><a href="/bidcar/model/admin/data_petugas.php"><img src="../../../img/admin-icon.svg" alt="admin"/>Data Petugas</a></li>
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
                <!-- <div class="admin-profile">
                    <img src="../../../img/admin-icon.svg" alt="Admin Icon" class="admin-icon">
                    <span>Admin</span>
                </div> -->
            </div>

            <h1>Form Tambah Barang</h1>
            <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?> <form method="post" action="" enctype="multipart/form-data" class="form-container"> 
                <div class="form-group">
                    <label for="nama_barang">Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang" placeholder="Masukkan Nama Barang" required>
                </div>

                <div class="form-group">
                    <label for="harga_awal">Harga</label>
                    <input type="text" id="harga_awal" name="harga_awal" placeholder="Masukkan Harga" required onkeyup="formatRupiah(this)">
                </div>

                <div class="form-row"> 
                    <div class="form-column">
                        <label for="gambar">Gambar</label>
                        <div class="file-input-wrapper">
                            <label for="gambar" class="file-input-button">Pilih File</label>
                            <span id="file-name-display" class="file-input-display">Tambahkan Gambar</span>
                            <input type="file" id="gambar" name="gambar" required onchange="displayFileName(this)">
                        </div>
                    </div>

                    <div class="form-column">
                        <label for="transmisi">Transmisi</label>
                        <select id="transmisi" name="transmisi" required>
                            <option value="" class="select-transmisi">Pilih Transmisi</option>
                            <option value="Manual">Manual</option>
                            <option value="Automatic">Automatic</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi_barang">Deskripsi</label>
                    <textarea id="deskripsi_barang" name="deskripsi_barang" placeholder="Masukkan Deskripsi Barang" rows="4" required></textarea>
                </div>

                <input type="hidden" id="tgl" name="tgl" value="<?php echo date('Y-m-d'); ?>">
                <label>Tahun</label>
                <input type="date" id="thn" name="thn" value="<?php echo date('Y-m-d'); ?>">


                <button type="submit" name="tambah_barang" class="submit-btn">Tambah</button>
            </form>
        </div>
    </div>

    <script>
        // Menampilkan nama file yang dipilih
        function displayFileName(input) {
            const fileNameDisplay = document.getElementById('file-name-display');
            if (input.files && input.files[0]) {
                fileNameDisplay.textContent = input.files[0].name;
            } else {
                fileNameDisplay.textContent = 'Tambahkan Gambar';
            }
        }

        // Format input harga menjadi format Rupiah
        function formatRupiah(input) {
            let angka = input.value.replace(/[^,\d]/g, '');
            if (angka === '') { 
                input.value = '';
                return;
            }

            angka = angka.replace(/Rp\.?\s?|(\.*)/g, '');

            let rupiah = '';
            let angkarev = angka.toString().split('').reverse().join('');
            for (let i = 0; i < angkarev.length; i++) {
                if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
            }
            rupiah = rupiah.split('', rupiah.length - 1).reverse().join('');
            input.value = 'Rp ' + rupiah;
        }

        document.querySelector('.form-container').addEventListener('submit', function() {
            let hargaInput = document.getElementById('harga_awal');
            hargaInput.value = hargaInput.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>