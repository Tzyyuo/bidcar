<?php 
include '../config/koneksi.php';

session_start();

if(isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
} else {
    header("Location: /bidcar/views/login.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

$sql = "SELECT h.*, l.id_barang, b.nama_barang, ,.nama_lengkap FROM tb_history_lelang h JOIN tb_lelang l ON h.id_lelnag = l.id_lelang
JOIN tb_barang b ON l.id_barang = b.id_barang JOIN tb_masyarakat m ON h.id_user = m.id_user WHERE h.id_user = ?";

if ($filter == 'menang') {
    $sql .= " AND h.status = 'menang'";
} elseif ($filter == 'kalah') {
    $sql .= " AND h.status = 'kalah'";
}
$sql .= " ORDER BY h.id_history DESC";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id_user);   
$stmt->execute();
$result = $stmt->get_result();

$data_history = [];
while ($row = $result->fetch_assoc()){
    $data_history[] = $row;
}

include '../views/history_menang.php';

?>