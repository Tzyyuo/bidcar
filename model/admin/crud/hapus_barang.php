<?php

include '../../../config/koneksi.php';

if (isset($_GET['id_barang'])) {

    $id_barang = $_GET['id_barang'];

    $query = "UPDATE tb_barang SET status = 'arsip' WHERE id_barang = ?";

    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_barang);

    if ($stmt->execute()){
        echo "<script>
        alert('Data berhasil dihapus');
        window.location.href = '/bidcar/model/petugas/data_barang.php';
      </script>";
    } else {
        echo "<script>
        alert('Gagal untuk hapus data');
        window.location.href = '/bidcar/model/petugas/data_barang.php';
      </script>";
    }

    }
    

?>