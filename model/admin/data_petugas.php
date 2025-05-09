<?php include '../../config/koneksi.php'; 
'../../layouts/sidebar.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Petugas - Admin</title>
</head>
<body>
    <div class="hal-judul">
        <img src="../../img/bidcar.png">
        <h1>Data Petugas/Admin</h1>
    </div>
    <div class="btn">
        <button class ="add-petugas" type ="button" name="tambah" ><a href="../admin/crud/tambah_petugas.php">Tambah Petugas</a></button>
        <button class= "cetak-laporan" type="button" name="print" ><a href="../admin/generate_laporan.php">Cetak Laporan</a></button>
    </div>
    <div class="list-petugas">
        <table border="1">
            <thead>9
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <?php
                $nomor = 1;
                $query = "SELECT * FROM tb_petugas order by id_petugas asc";
                $result = mysqli_query($koneksi, $query);
                ?>
                
                <tr>

                    <?php 

                    while($row = mysqli_fetch_array($result)) {
                    $nama_petugas = $row['nama_petugas'];
                    $username = $row['username'];
                    $password = $row['password'];
                    $status = $row['id_level'];
                    ?>

                    <th><?php echo $nomor++ ?></th>
                    <td><?php echo $nama_petugas ?></td>
                    <td><?php echo $username ?></td>
                    <td><?php echo $password ?></td>
                    <td><?php echo $status ?></td>
                    <td>
                    <button type="button" class="edit-btn" name="edit"><a href="../admin/crud/edit_petugas.php?id_petugas=<?php echo $row['id_petugas'];?>">Edit</a></button>
                    <button type="button" class="delete-btn" name="hapus"><a href="../admin/crud/hapus_petugas.php?id_petugas=<?php echo $row['id_petugas'];?>">Hapus</a></button>
                    </td>
                </tr>
                <?php } ?>

            </tbody>
    </div>
    
</body>
</html>