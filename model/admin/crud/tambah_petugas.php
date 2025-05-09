<?php
include '../../../config/koneksi.php';

if(isset($_POST['submit'])) {
    $nama_petugas = $_POST['nama_petugas'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $level = $_POST['level'];

    $query ="INSERT INTO tb_petugas (nama_petugas, username, password, id_level) VALUES (?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("sssi", $nama_petugas, $username, $password, $level);
    
    if($stmt->execute()){
        
        echo "<script>
        alert('Data berhasil ditambahkan
        window.location.href = '/bidcar/model/admin/data_petugas.php';
      </script>";
      
      header("Location: /bidcar/model/admin/data_petugas.php");
      
      exit;
    }

}
?>

<?php include '../../../layouts/sidebar.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Petugas - Admin</title>
</head>
<body>
    <div class="hal-judul">
        <img src="../../../img/bidcar.png">
        <h1>Form Tambah Petugas - Admin</h1>
    </div>
    <div class="tambah-petugas">
        <form method="POST" action="">
            <label for="nama_petugas">Nama Petugas</label>
            <input type="text" id="nama_petugas" name="nama_petugas" required>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <label for="level">Level</label>
            <input type="" id="level" name="level" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="submit">Selesai</button>
        </form>
    </div>
    
</body>
</html>