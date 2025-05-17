<?php 

if(isset($_POST['edit'])) {
    $id_lelang = $_POST['id_lelang'];
    $id_barang = $_POST['id_barang'];
    $tgl_lelang = $_POST['tgl_lelang'];
    $id_petugas = $_POST['id_petugas'];
    $tgl_selesai = $_POST['tgl_selesai'];
    $status = $_POST['status'];

    // Update data lelang
    $query = "UPDATE tb_lelang SET id_barang = ?, tgl_lelang = ?, id_petugas = ?, tgl_selesai = ?, status = ? WHERE id_lelang = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("issssi", $id_barang, $tgl_lelang, $id_petugas, $tgl_selesai, $status, $id_lelang);
    if ($stmt->execute()) {
        echo "<script>alert('Lelang berhasil diperbarui!'); window.location.href='/bidcar/model/petugas/data_lelang.php';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal memperbarui lelang: " . $stmt->error . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Tidak ada data yang diperbarui.'); window.history.back();</script>";
    exit();

}
?>

<form method="POST" action="">
    <input type="hidden" name="id_lelang" value="<?= $data['id_lelang'] ?>">
    
    <label>ID Barang:</label>
    <input type="number" name="id_barang" value="<?= $data['id_barang'] ?>" required><br>
    
    <label>Tanggal Lelang:</label>
    <input type="date" name="tgl_lelang" value="<?= $data['tgl_lelang'] ?>" required><br>
    
    <label>Tanggal Selesai:</label>
    <input type="date" name="tgl_selesai" value="<?= $data['tgl_selesai'] ?>" required><br>
    
    <label>ID Petugas:</label>
    <input type="number" name="id_petugas" value="<?= $data['id_petugas'] ?>" required><br>
    
    <label>Status:</label>
    <select name="status" required>
        <option value="dibuka" <?= $data['status'] == 'dibuka' ? 'selected' : '' ?>>Dibuka</option>
        <option value="ditutup" <?= $data['status'] == 'ditutup' ? 'selected' : '' ?>>Ditutup</option>
    </select><br>
    
    <button type="submit" name="edit">Simpan Perubahan</button>
</form>
