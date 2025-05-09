<?php

include '../config/koneksi.php';

if(isset($_POST['submit'])){
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE 'tb_masyarakat' SET 'password'= $password WHERE id_user = ?";

    header("Location: '../../../../bidcar/views/login.php");
}