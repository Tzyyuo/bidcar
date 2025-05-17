<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pemenang Lelang</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; }
        img { max-width: 150px; height: auto; }
        .no-print { margin-bottom: 20px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="no-print">Cetak Laporan</button>
    <h2>Laporan Pemenang Lelang</h2>

    <table>
        <tr>
            <th>Gambar</th>
            <th>Nama Barang</th>
            <th>Nama Pemenang</th>
            <th>Username</th>
            <th>No Telepon</th>
            <th>Harga Menang</th>
            <th>Tanggal Lelang</th>
        </tr>
        <?php

        include '../config/koneksi.php';
        $query = "SELECT b.nama_barang, b.gambar, m.nama_lengkap, m.username, m.telp, p.harga_penawaran, l.tgl_lelang
        FROM tb_lelang l JOIN tb_barang b ON l.id_barang = b.id_barang JOIN tb_penawaran p ON p.id_lelang = l.id_lelang
        JOIN tb_masyarakat m ON p.id_user = m.id_user WHERE p.harga_penawaran = (SELECT MAX(p2.harga_penawaran) 
        FROM tb_penawaran p2 WHERE p2.id_lelang = l.id_lelang) AND l.status = 'ditutup'";

        $result = mysqli_query($koneksi, $query);


        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td><img src='/bidcar/img/{$row['gambar']}' alt='{$row['nama_barang']}'></td>
                <td>{$row['nama_barang']}</td>
                <td>{$row['nama_lengkap']}</td>
                <td>{$row['username']}</td>
                <td>{$row['telp']}</td>
                <td>Rp " . number_format($row['harga_penawaran'], 0, ',', '.') . "</td>
                <td>{$row['tgl_lelang']}</td>

            </tr>";
        }
        ?>
    </table>
        
    <button onclick="window.print()" class="no-print">Cetak Laporan</button>

</body>
</html>
