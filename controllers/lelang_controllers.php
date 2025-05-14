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

        header("Location: /bidcar/model/petugas/data_lelang.php");
        exit;
    }

    if ($status == 'ditutup') {
        // 1. Ambil penawaran tertinggi
        $query = "SELECT id_history FROM history_lelang WHERE id_lelang = ? ORDER BY penawaran_harga DESC LIMIT 1";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("i", $id_lelang);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if (!$data) {
            echo "<script>alert('Belum ada penawaran pada lelang ini.'); window.location.href='/bidcar/model/petugas/data_lelang.php';</script>";
            exit;
        }

        $id_pemenang = $data['id_history'];

        // 2. Semua jadi Kalah
        $updateAll = $koneksi->prepare("UPDATE history_lelang SET status = 'Kalah' WHERE id_lelang = ?");
        $updateAll->bind_param("i", $id_lelang);
        $updateAll->execute();

        // 3. Pemenang jadi Menang
        $updateWinner = $koneksi->prepare("UPDATE history_lelang SET status = 'Menang' WHERE id_history = ?");
        $updateWinner->bind_param("i", $id_pemenang);
        $updateWinner->execute();

        // 4. Simpan harga akhir
        $hargaAkhir = $koneksi->prepare("SELECT penawaran_harga FROM history_lelang WHERE id_history = ?");
        $hargaAkhir->bind_param("i", $id_pemenang);
        $hargaAkhir->execute();
        $hasil = $hargaAkhir->get_result()->fetch_assoc();
        $finalPrice = $hasil['penawaran_harga'];

        $updateLelang = $koneksi->prepare("UPDATE tb_lelang SET harga_akhir = ?, status = 'Ditutup' WHERE id_lelang = ?");
        $updateLelang->bind_param("ii", $finalPrice, $id_lelang);
        $updateLelang->execute();

        header("Location: /bidcar/model/petugas/data_lelang.php");
        exit;
    }
}
?>
