<?php

include '../config/koneksi.php';

if (isset($_POST['konfirmasi'])) {
    $id_lelang = $_POST['id_lelang'];
    $status = $_POST['status']; // ini diambil dari radio button

    if ($status == 'dibuka') {
        // Buka lelang
        $stmt = $koneksi->prepare("UPDATE tb_lelang SET status = 'Dibuka' WHERE id_lelang = ?");
        $stmt->bind_param("i", $id_lelang);
        $stmt->execute();

        // Ambil id_barang dari tb_lelang
        $getBarang = $koneksi->prepare("SELECT id_barang FROM tb_lelang WHERE id_lelang = ?");
        $getBarang->bind_param("i", $id_lelang);
        $getBarang->execute();
        $getResult = $getBarang->get_result();
        $barangData = $getResult->fetch_assoc();
        $id_barang = $barangData['id_barang']; 

        // Update status barang ke 'Dilelang'
        $updateBarang = $koneksi->prepare("UPDATE tb_barang SET status = 'dilelang' WHERE id_barang = ?");
        $updateBarang->bind_param("i", $id_barang);
        $updateBarang->execute();


        header("Location: /bidcar/model/petugas/data_lelang.php");
        exit;
    }

    if ($status == 'ditutup') {
    //  1. Ambil penawaran tertinggi
    $query = "SELECT id_history, id_user, penawaran_harga FROM history_lelang WHERE id_lelang = ? ORDER BY penawaran_harga DESC LIMIT 1";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_lelang);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    //buat update status barang 'dilelang', 'sudah dilelanf' atau 'belum dilelang'
    $getBarang = $koneksi->prepare("SELECT id_barang FROM tb_lelang WHERE id_lelang = ?");
    $getBarang->bind_param("i", $id_lelang);
    $getBarang->execute();
    $getResult = $getBarang->get_result();
    $barangData = $getResult->fetch_assoc();
    $id_barang = $barangData['id_barang'];

    $updateBarang = $koneksi->prepare("UPDATE tb_barang SET status = 'sudah dilelang' WHERE id_barang = ?");
    $updateBarang->bind_param("i", $id_barang);
    $updateBarang->execute();


    if (!$data) {
        echo "<script>alert('Belum ada penawaran pada lelang ini.'); window.location.href='/bidcar/model/petugas/data_lelang.php';</script>";
        exit;
    }

    $id_history_pemenang = $data['id_history'];
    $id_user_pemenang = $data['id_user'];
    $finalPrice = $data['penawaran_harga'];

    // 2. Set semua status history jadi 'Kalah'
    $updateAll = $koneksi->prepare("UPDATE history_lelang SET status = 'Kalah' WHERE id_lelang = ?");
    $updateAll->bind_param("i", $id_lelang);
    $updateAll->execute();

    // 3. Set pemenang jadi 'Menang'
    $updateWinner = $koneksi->prepare("UPDATE history_lelang SET status = 'Menang' WHERE id_history = ?");
    $updateWinner->bind_param("i", $id_history_pemenang);
    $updateWinner->execute();

    // 4. Update tb_lelang ke harga akhir, id_user ke pemenang, status, dan tgl_selesai
    $updateLelang = $koneksi->prepare("UPDATE tb_lelang SET harga_akhir = ?, id_user = ?, status = 'Ditutup', tgl_selesai = NOW() WHERE id_lelang = ?");
    $updateLelang->bind_param("iii", $finalPrice, $id_user_pemenang, $id_lelang);
    $updateLelang->execute();


        header("Location: /bidcar/model/petugas/data_lelang.php");
        exit;
    }
}
?>