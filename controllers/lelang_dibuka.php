<?php

$id_barang = $_POST['id_barang'];
$id_petugas = $_POST['id_petugas'];

$query = "SELECT * FROM tb_lelang where id_barang = ? AND status != 'ditutup'";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_barang);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    $buka = "INSERT INTO tb_lelang (id_barang, tgl_barang, harga_akhir, id_petugas, status) values (?, NOW(), 0, ?, 'dibuka')";
    $stmt = $koneksi->prepare($buka);
    $stmt->bind_param("ii", $id_petugas, $id_barang);
    $stmt->execute();
    header ("Location: bidcar/model/petugas/lelang.php");

} else {
    echo "<script>
    alert('Barang sudah di lelang');
    window.location.href = '/bidcar/model/petugas/lelang.php';
  </script>";
}
?>