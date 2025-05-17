<?php

include '../../../config/koneksi.php';

if (isset($_GET['id_petugas'])) {

    $id_petugas = $_GET['id_petugas'];

    $query = "DELETE FROM tb_petugas where id_petugas = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_petugas);

    if ($stmt->execute()){
        echo "<script>
        alert('Data berhasil dihapus');
        window.location.href = '/bidcar/model/admin/data_petugas.php';
      </script>";
    } else {
        echo "<script>
        alert('Gagal untuk hapus data');
        window.location.href = '/bidcar/model/admin/data_petugas.php';
      </script>";
    }

    }


?>