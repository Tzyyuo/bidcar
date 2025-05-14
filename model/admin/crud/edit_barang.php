<?php

include '../../../config/koneksi.php';

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
if (isset($_POST['tambah_barang'])) {
    $id_barang = $_GET['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga_awal = $_POST['harga_awal'];
    $tgl = $_POST['tgl'];
    $deskripsi_barang = $_POST['deskripsi_barang'];
    $transmisi = $_POST['transmisi'];

    // Cek apakah user upload gambar baru
    if (!empty($_FILES['gambar']['name'])) {
        $nama_file = $_FILES['gambar']['name'];
        $tmp_file = $_FILES['gambar']['tmp_name'];
        $path = "../../../assets/img/" . $nama_file;
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

        move_uploaded_file($tmp_file, $path);
    } else {
        // Jika gambar tidak diupload, pakai gambar lama
        $nama_file = $data['gambar'];
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
    <title>Pendataan Barang</title>
</head>
<body>
    <div class="content">
        <h1>Edit Barang</h1>
        <?php if (isset($message)) echo "<p>$message</p>"; ?>
        <form method="POST" action="" enctype="multipart/form-data">

            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" value="<?= $data['nama_barang'] ?? '' ?>" required>
            </div>

            <div class="form-group">
                <label for="gambar">Gambar:</label><br>
                <?php if (!empty($data['gambar'])): ?>
                    <img src="../../../assets/img/<?= $data['gambar'] ?>" width="100"><br>
                <?php endif; ?>
                <input type="file" id="gambar" name="gambar">
            </div>

            <div class="form-group">
                <label for="harga_awal">Harga Awal</label>
                <input type="text" id="harga_awal" name="harga_awal" value="<?= $data['harga_awal'] ?? '' ?>" required>
            </div>

            <div class="form-group">
                <label for="tgl">Tanggal Mulai</label>
                <input type="date" id="tgl" name="tgl" value="<?= $data['tgl'] ?? '' ?>" required>
            </div>

            <div class="form-group">
                <label for="deskripsi_barang">Deskripsi Barang</label>
                <input type="text" id="deskripsi_barang" name="deskripsi_barang" value="<?= $data['deskripsi_barang'] ?? '' ?>" required>
            </div>

            <div class="form-group">
                <select id="transmisi" name="transmisi" required>
                    <option value="">-- Pilih Transmisi --</option>
                 <option value="Manual" <?= (isset($data['transmisi']) && $data['transmisi'] == 'Manual') ? 'selected' : '' ?>>Manual</option>
                <option value="Otomatis" <?= (isset($data['transmisi']) && $data['transmisi'] == 'Otomatis') ? 'selected' : '' ?>>Otomatis</option>
                </select>
            </div>

            <button type="submit" name="tambah_barang">Simpan Perubahan</button>
        </form>

    </div>
</body>
</html>