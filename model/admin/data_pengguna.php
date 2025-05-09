<?php 
include '../../config/koneksi.php'; 
'../../layouts/sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna - Admin</title>
</head>
<body>
    <div class="hal-judul">
        <img src="../../img/bidcar.png">
        <h1>Data Pengguna</h1>
        <button class= "cetak-laporan" type="button" name="print" ><a href="../admin/generate_laporan.php">Cetak Laporan</a></button>
    </div>

    <div class="tabel-pengguna">
        <table border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>NO Telepon</th>
                </tr>
            </thead>

            <tbody>

                <?php
                $nomor = 1;
                $query = "SELECT * FROM tb_masyarakat order by id_user asc";
                $result = mysqli_query($koneksi, $query);
                ?>
                
                <tr>

                    <?php 

                    while($row = mysqli_fetch_array($result)) {
                    $nama_lengkap = $row['nama_lengkap'];
                    $username = $row['username'];
                    $password = $row['password'];
                    $telp = $row['telp'];
                    ?>

                    <th><?php echo $nomor++ ?></th>
                    <td><?php echo $nama_lengkap?></td>
                    <td><?php echo $username ?></td>
                    <td><?php echo $password ?></td>
                    <td><?php echo $telp?></td>
                </tr>
                <?php } ?>

            </tbody>
    </div>
    
</body>
</html>

<?php 


include '../../config/koneksi.php';


?>