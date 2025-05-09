<?php 
include '../../layouts/sidebar.php';
include '../../config/koneksi.php';
?>

<!DOCTYPE html>
<h lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - Admin</title>
</head>
<>
    <div class="head-crud-barang">
        <img src="../../img/bidcar.png">
        <h1>Data Barang</h1>
    </div>

    <div class="btn">
        <button type="button" class="tambah-barang"><a href="../admin/crud/tambah_barang.php">Tambah Barang</a></button>
        <button type="button" class="cetak-laporan">Cetak Laporan</button>
    </div>
    

    <divv class="list-barang">
        <table border="1">
            <thead>
                <th>No</th>,.
                <th>Barang</th>
                <th>Nama Barang</th>
                <th>Transmisi</th>
                <th>Tanggal</th>
                <th>Harga Awal</th>
                <th>Deskripsi</th>
                <th>Action</th>
            </thead>

            <tbody>
            
                <?php
                $nomor = 1;
                $query = "SELECT * FROM tb_barang order by id_barang desc";
                $result = mysqli_query($koneksi, $query);
                ?>

            <tr>

            <?php 

            while($row = mysqli_fetch_array($result)) {
            $nama_barang = $row['nama_barang'];
            $tgl = $row['tgl'];
            $harga_awal = $row['harga_awal'];
            $deskripsi_barang = $row['deskripsi_barang'];
            $gambar = $row['gambar'];
            ?>

            <th><?php echo $nomor++ ?></th>
            <td><img src="../../img/<?php echo $gambar; ?>" width="100"></td>
            <td><?php echo $nama_barang ?></td>
            <td><?php echo "transmisi" ?></td>
            <td><?php echo $tgl ?></td>
            <td><?php echo $harga_awal ?></td>
            <td><?php echo $deskripsi_barang ?></td>
            <td><?php echo "hapus/edit" ?></td>
            
           
        </tr>
        <?php } ?>

        </tbody>
        </table>
    </div>
    
    
</body>
</html>

