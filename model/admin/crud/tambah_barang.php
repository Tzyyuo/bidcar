<?php 
include '../../../config/koneksi.php';

if (isset($_POST['tambah_barang'])) {

    $nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $harga_awal = mysqli_real_escape_string($koneksi, $_POST['harga_awal']);
    $tgl = mysqli_real_escape_string($koneksi, $_POST['tgl']);
    $deskripsi_barang = mysqli_real_escape_string($koneksi, $_POST['deskripsi_barang']);
    $transmisi = mysqli_real_escape_string($koneksi, $_POST['transmisi']);
    $nama_file = $_FILES['gambar']['name'];
    $type_file = $_FILES['gambar']['type'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    $path = "/bidcar/img";
    $allowed_types = array('image/png', 'image/jpeg'); 
    $ukuran_file = $_FILES['gambar']['size'] ?? 0;
    $max_size = 2048000;
    

    $query = "INSERT INTO tb_barang (nama_barang, harga_awal, tgl, deskripsi_barang, transmisi, gambar) 
          VALUES ('$nama_barang', '$harga_awal', '$tgl', '$deskripsi_barang', '$transmisi', '$nama_file')";
    $message = '';

    if (mysqli_query($koneksi, $query)) {
        $message = "Pendataan berhasil";
    } else {
        $message = "Gagal melakukan input data: " . mysqli_error($koneksi);
    }

    if ($_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        if (in_array($type_file, $allowed_types) && $ukuran_file <= $max_size) {
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
            if (move_uploaded_file($tmp_file, $path . $nama_file)) {
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

include '../../../layouts/sidebar.php';

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendataan Barang</title>

</head>
<body>
    <div class="content">
        <h1>Form Tambah Barang</h1>
        <?php if (isset($message)) echo "<p>$message</p>"; ?>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="nama">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" placeholder="Masukkan nama barang" required>
            </div>

            <div class="gambar">
                <label for="gambar">Gambar:</label>
                <input type="file" id="gambar" name="gambar" required>
            </div>
            
            <div class="deskripsi"> 
                <label for="harga_awal">Harga Awal:</label>
                <input type="text" id="harga_awal" name="harga_awal" required>
                
                <label for="tgl">Tanggal Mulai:</label>
                <input type="date" id="tgl" name="tgl" required>
                
                <label for="deskripsi_barang">Deskripsi Barang:</label>
                <input type="text" id="deskripsi_barang" name="deskripsi_barang" placeholder="Masukkan deskripsi barang" required>

                <label for="transmisi">Transmisi:</label>
                <select id="transmisi" name="transmisi" required>
                    <option value="">-- Pilih Transmisi --</option>
                    <option value="Manual">Manual</option>
                    <option value="Automatic">Otomatis</option>
                </select>
            </div>
            
            <button type="submit" name="tambah_barang">Tambahkan</button>
        </form>
    </div>
</body>
</html>