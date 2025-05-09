<?php 

$id_lelang = $_POST['id_lelang'];

$query = "SELECT MAX(nominal) AS harga_akhir, id user FROM tb_penawaran WHERE id_lelang =?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_lelang);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$harga_akhir = $row['harga_akhir']?? 0;


$harga_akhir = $row['harga_akhir'];
$id_user = $row['id_user'];

if($harga_akhir > 0) {
    
}