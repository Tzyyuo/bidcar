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
?>

<h2>Tambah Lelang</h2>

<form action="../../controllers/buat_lelang_controllers.php" method="POST">
    <label for="id_barang">Pilih Barang:</label><br>
    <select name="id_barang" required>
        <option value="">-- Pilih Barang --</option>
        <?php
        $barang = mysqli_query($koneksi, "SELECT * FROM tb_barang");
        while($b = mysqli_fetch_assoc($barang)) {
            echo "<option value='{$b['id_barang']}'>{$b['nama_barang']}</option>";
        }
        ?>
    </select>
    <br><br>

    <label for="tgl_barang">Tanggal Lelang:</label><br>
    <input type="date" name="tgl_barang" required><br><br>

    <button type="submit">Simpan Lelang</button>
</form>
