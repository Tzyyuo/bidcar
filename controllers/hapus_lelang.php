<?php

include '../config/koneksi.php';

if(isset($_GET['hapus']) && isset($_GET['id_lelang'])) {

    $id_lelang = $_GET['id_lelang'];

    $query = "DELETE FROM tb_lelang WHERE id_lelang = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_lelang);

    if($stmt->execute()){
        echo "<script>
            alert('Data berhasil dihapus');
            window.location.href = '/bidcar/model/petugas/data_lelang.php';
          </script>";
    } else {
        echo "<script>
            alert('Gagal untuk hapus data');
            window.location.href = '/bidcar/model/petugas/data_lelang.php';
          </script>";
    }

}


?>