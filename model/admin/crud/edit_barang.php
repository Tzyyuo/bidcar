<?php 

include '../../../config/koneksi.php';

if(isset($_GET['id_barang'])){
    $id_barang = $_GET['id_barang'];

   
    $stmt = $koneksi->prepare( "SELECT * FROM tb_barang where id_barang = ?");
    $stmt->bind_param("i", $id_barang);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_array();
    $stmt->close();
}

if(isset($_POST['tambah_barang'])){
    $nama_barang = $_POST['nama_barang'];
    $harga_awal = $_POST['harga_awal'];
    $tgl = $_POST['tgl'];
    $deskripsi_barang = $_POST['deskripsi_barang'];
    $gambar = $_POST['gambar'];

    $stmt = $koneksi->prepare("UPDATE tb_barang SET nama_barang = ?, harga_awal = ?, tgl = ?, deskripsi_barang =?, gambar =?");
    $stmt->bind_param("sisss", $nama_barang, $harga_awal, $tgl, $deskripsi_barang, $gambar );
    if ($stmt->execute()) {
        echo "<script>
                alert('Data berhasil diupdate');
                window.location.href = '/bidcar/model/petugas/data_petugas.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal update data');
              </script>";
    }

    $stmt->close();

}

?>

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
        
        <form method="post" action="" enctype="multipart/form-data">
            <div class="nama">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" value="<?php echo isset($data['nama_barang']) ? $data['nama_barang'] : ''; ?>" required>                >
            </div>

            <div class="gambar">
                <label for="gambar">Gambar:</label>
                <input type="file" id="gambar" name="gambar" value="<?php echo isset($data['gambar']) ? $data['gambar'] : ''; ?>" required>
            </div>
            
            <div class="deskripsi"> 
                <label for="harga_awal">Harga Awal:</label>
                <input type="text" id="harga_awal" name="harga_awal" value="<?php echo isset($data['harga_awal']) ? $data['harga_awal'] : ''; ?>" required>
                >
                
                <label for="tgl">Tanggal Mulai:</label>
                <input type="date" id="tgl" name="tgl" ; ?> value= "<?php echo isset($data['tanggal mulai']) ? $data['tanggal mulai'] : ''; ?>" required>
                " required>
                
                <label for="deskripsi_barang">Deskripsi Barang:</label>
                <input type="text" id="deskripsi_barang" name="deskripsi_barang" placeholder="Masukkan deskripsi barang" required>
            </div>
            
            <button type="submit" name="tambah_barang">Tambahkan</button>
        </form>
    </div>
</body>
</html>