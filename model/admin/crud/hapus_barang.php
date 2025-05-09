<?php

include '../../../config/koneksi.php';

if(isset($_GET['id_barang'])){

    $id_barang = $_GET['id_barang'];

    $query = "DELETE FROM tb_barang where id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_barang);

    if($stmt->execute()){
        echo "<script>
        alert('Data berhasil dihapus');
        window.location.href = '/bidcar/model/petugas/data_petugas.php';
      </script>";
    } else {
        echo "<script>
        alert('Gagal untuk hapus data');
        window.location.href = '/bidcar/model/petugas/data_petugas.php';
      </script>";
    }

    }

?>