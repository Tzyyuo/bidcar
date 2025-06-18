<?php
session_start();
include '../../../config/koneksi.php';

$id_petugas = $_SESSION['id_petugas'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_petugas WHERE id_petugas = '$id_petugas'");
$pfp = mysqli_fetch_assoc($query);

if (isset($_GET['id_barang'])) {
    $id_barang = $_GET['id_barang'];
    $query = "SELECT * FROM tb_barang WHERE id_barang = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_barang);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if (!$data) {
        echo "<script>
                alert('Data tidak ditemukan');
                window.location.href = '/bidcar/model/admin/data_barang.php';
              </script>";
        exit;
    }
}


function formatRupiah($angka) {
    if ($angka === null || $angka === '') {
        return 'Rp 0';
    }
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

if (isset($_POST['update_barang'])) {
    $id_barang = $_GET['id_barang'];
    $nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $harga_awal_formatted = mysqli_real_escape_string($koneksi, $_POST['harga_awal']); 
    $harga_awal = preg_replace('/[^0-9]/', '', $harga_awal_formatted); 

    $tgl = mysqli_real_escape_string($koneksi, $_POST['tgl']);
    $deskripsi_barang = mysqli_real_escape_string($koneksi, $_POST['deskripsi_barang']);
    $transmisi = mysqli_real_escape_string($koneksi, $_POST['transmisi']);

    // Cek apakah user upload gambar baru
    $nama_file = $data['gambar'];
    if (!empty($_FILES['gambar']['name'])) {
        $nama_file = $_FILES['gambar']['name'];
        $tmp_file = $_FILES['gambar']['tmp_name'];
        $path_upload = "../../../dir/img/";
        $allowed_types = ['image/png', 'image/jpeg'];
        $type_file = $_FILES['gambar']['type'];
        $ukuran_file = $_FILES['gambar']['size'];
        $max_size = 2048000;

        if (!in_array($type_file, $allowed_types)) {
            echo "<script>alert('Tipe file tidak diizinkan.');</script>";
            exit;
        }

        if ($ukuran_file > $max_size) {
            echo "<script>alert('Ukuran file terlalu besar (max 2MB).');</script>";
            exit;
        }

        // Pastikan direktori ada
        if (!is_dir($path_upload)) {
            mkdir($path_upload, 0755, true);
        }

        if (!move_uploaded_file($tmp_file, $path_upload . $nama_file)) {
             echo "<script>alert('Gagal mengupload gambar.');</script>";
             exit;
        }
    }

    $stmt = $koneksi->prepare("UPDATE tb_barang SET nama_barang = ?, harga_awal = ?, tgl = ?, deskripsi_barang = ?, transmisi = ?, gambar = ? WHERE id_barang = ?");
    $stmt->bind_param("sissssi", $nama_barang, $harga_awal, $tgl, $deskripsi_barang, $transmisi, $nama_file, $id_barang);

    if ($stmt->execute()) {
        echo "<script>
                alert('Data berhasil diupdate');
                window.location.href = '/bidcar/model/admin/data_barang.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal update data: " . $stmt->error . "');
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
    <title>Edit Barang</title>
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <link rel="stylesheet" href="../../../css/edit_barang-petugas.css">
</head>
<body>
    <div class="main-wrapper">
        <div class="sidebar">
            <h1>BidCar.</h1>
            <hr class="sidebar-divider"/>

            <ul>
                <li><a href="/bidcar/model/petugas/dashboard_petugas.php"><img src="../../../img/dashboard-icon.svg" alt="dashboard"/>Dashboard</a></li>
                <li class="active"><a href="/bidcar/model/petugas/data_barang.php"><img src="../../../img/barang-icon.svg" alt="barang"/>Data Barang</a></li>
                <li><a href="/bidcar/model/petugas/data_lelang.php"><img src="../../../img/lelang-icon.svg" alt="lelang"/>Data Lelang</a></li>

            <hr class="sidebar-divider"/>
            <form method="GET" action="../controllers/logout_controllers.php">
                <button type="button" name="logout" class="logout-btn">
                    <a href="/bidcar/controllers/logout_controllers.php"><img src="../../../img/logout-icon.svg" alt="logout"/>Logout</a>
                </button>
            </form>
        </div>
        <div class="content">
            <div class="navbar-content">
                <div class="navbar-left">
                <img src="../../../img/bidcar signup.svg" alt="BidCar Logo" class="header-logo">
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

            <h1>Edit Barang</h1>
            <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>

            <form method="POST" action="" enctype="multipart/form-data" class="form-container">
                <div class="form-group">
                    <label for="nama_barang">Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang" placeholder="Masukkan Nama Barang" value="<?= $data['nama_barang'] ?? '' ?>" required>
                </div>

                <div class="form-group">
                    <label for="harga_awal">Harga</label>
                    <input type="text" id="harga_awal" name="harga_awal" placeholder="Masukkan Harga" value="<?= formatRupiah($data['harga_awal'] ?? 0) ?>" onkeyup="formatRupiahJS(this)" required>
                </div>

                <div class="form-row">
                    <div class="form-column">
                        <label for="gambar">Gambar</label>
                        <div class="file-input-wrapper">
                            <label for="gambar" class="file-input-button">Pilih File</label>
                            <span id="file-name-display" class="file-input-display">
                                <?php echo !empty($data['gambar']) ? $data['gambar'] : 'Tambahkan Gambar'; ?>
                            </span>
                            <input type="file" id="gambar" name="gambar" onchange="displayFileName(this)">
                        </div>
                    </div>

                    <div class="form-column">
                        <label for="transmisi">Transmisi</label>
                        <select id="transmisi" name="transmisi" required>
                            <option value="Manual" <?= (isset($data['transmisi']) && $data['transmisi'] == 'Manual') ? 'selected' : '' ?>>Manual</option>
                            <option value="Automatic" <?= (isset($data['transmisi']) && $data['transmisi'] == 'Otomatis') ? 'selected' : '' ?>>Otomatis</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi_barang">Deskripsi</label>
                    <textarea id="deskripsi_barang" name="deskripsi_barang" placeholder="Masukkan Deskripsi Barang" rows="4" required><?= $data['deskripsi_barang'] ?? '' ?></textarea>
                </div>

                <input type="hidden" id="tgl" name="tgl" value="<?= $data['tgl'] ?? date('Y-m-d'); ?>">

                <button type="submit" name="update_barang" class="submit-btn">Ubah</button>
            </form>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan nama file gambar yang dipilih
        function displayFileName(input) {
            const fileNameDisplay = document.getElementById('file-name-display');
            if (input.files && input.files[0]) {
                fileNameDisplay.textContent = input.files[0].name;
            } else {
                fileNameDisplay.textContent = '<?php echo !empty($data['gambar']) ? $data['gambar'] : 'Tambahkan Gambar'; ?>';
            }
        }

        // Format input harga ke format Rupiah
        function formatRupiahJS(input) {
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

        document.addEventListener('DOMContentLoaded', function() {
            const hargaInput = document.getElementById('harga_awal');
            if (hargaInput) {
                formatRupiahJS(hargaInput);
            }
            displayFileName(document.getElementById('gambar'));
        });
    </script>
</body>
</html>