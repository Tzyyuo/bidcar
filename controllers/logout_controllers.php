<?php
include '../config/koneksi.php';
session_start();

if(isset($_REQUEST_METHOD ['GET']) == ($_GET['logout']))  {


$username = $_SESSION['username'];
$password = $_SESSION['password'];

$query = "DELETE $_SESSION FROM tb_petugas (nama_lengkap, password) values (?,?)";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("ss", $username, $password);
if($stmt->execute()){
    header("Location: /bidcar/views/login.php");
    }
}

?>