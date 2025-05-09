<?php
$koneksi = new mysqli ("localhost", "root", "", "bidcar_lelang_online");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
