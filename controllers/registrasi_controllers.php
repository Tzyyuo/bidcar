<?php

include '../config/koneksi.php';

if(isset($_POST['submit'])){
    $nama_lengkap = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $telp = $_POST['telp'];

    $query = "INSERT INTO tb_masyarakat (nama_lengkap, username, password, telp) values (?,?,?,?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ssss", $nama_lengkap, $username, $password, $telp);
    
    if ($stmt->execute()) {
        header("Location: /bidcar/views/login.php");
        exit;
    } else {
        echo "Gagal melakukan registrasi!";
        exit;
    }
}

?>

