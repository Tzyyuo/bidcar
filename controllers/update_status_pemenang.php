<?php
$id_lelang = $_GET['id']; 

// 1. Ambil penawaran tertinggi
$query = "SELECT id_history FROM tb_history_lelang WHERE id_lelang = ? ORDER BY penawaran_harga DESC LIMIT 1";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_lelang);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$id_pemenang = $data['id_history'];

// 2. Set semua status jadi 'Kalah' dulu
$updateAll = $koneksi->prepare("UPDATE tb_history_lelang SET status = 'Kalah' WHERE id_lelang = ?");
$updateAll->bind_param("i", $id_lelang);
$updateAll->execute();

// 3. Ubah status pemenang jadi 'Menang'
$updatePemenang = $koneksi->prepare("UPDATE tb_history_lelang SET status = 'Menang' WHERE id_history = ?");
$updatePemenang->bind_param("i", $id_pemenang);
$updatePemenang->execute();

// 4. Simpan harga akhir ke tabel 'tb_lelang'
$hargaAkhir = $koneksi->prepare("SELECT penawaran_harga FROM tb_history_lelang WHERE id_history = ?");
$hargaAkhir->bind_param("i", $id_pemenang);
$hargaAkhir->execute();
$hasil = $hargaAkhir->get_result()->fetch_assoc();
$finalPrice = $hasil['penawaran_harga'];

// 5. tutup lelang dan simpan harga akhir (paling tinggi)
$updateLelang = $koneksi->prepare("UPDATE tb_lelang SET harga_akhir = ?, status = 'Ditutup' WHERE id_lelang = ?");
$updateLelang->bind_param("ii", $finalPrice, $id_lelang);
$updateLelang->execute();
?>