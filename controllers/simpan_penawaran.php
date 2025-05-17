<?php 
include '../config/koneksi.php';
session_start();
var_dump($_POST);
var_dump($_SESSION['id_user']);
if($_SERVER['REQUEST_METHOD']== 'POST'){

    $id_lelang = $_POST['id_lelang'];
    $id_user = $_SESSION['id_user'];
    $harga_penawaran = $_POST['harga_penawaran'];

    
    $stmt = $koneksi->prepare("SELECT * FROM tb_penawaran WHERE id_lelang = ? AND id_user = ?");
    $stmt->bind_param("ii", $id_lelang, $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        echo "Anda sudah melakukan penawaran untuk lelang ini.";
    } else {
       
        $stmt = $koneksi->prepare("INSERT INTO tb_penawaran (id_lelang, id_user, harga_penawaran) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $id_lelang, $id_user, $harga_penawaran);
        if($stmt->execute()){
            echo "Penawaran berhasil disimpan.";
        } else {
            echo "Gagal menyimpan penawaran.";
        }
    }
} else {
    echo "Akses tidak valid.";
}
?>