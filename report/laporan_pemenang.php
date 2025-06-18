<?php
session_start();
include '../config/koneksi.php';

// Cek session login (assuming this report also needs login check)
if (!isset($_SESSION['id_petugas']) || !isset($_SESSION['level'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu.');
        window.location.href = '../views/login.php';
    </script>";
    exit;
}

// Cek hak akses (assuming this report also needs access level check)
if ($_SESSION['level'] != 1 && $_SESSION['level'] != 2) {
    echo "<script>
        alert('Anda tidak memiliki akses ke halaman ini.');
        window.history.back();
    </script>";
    exit;
}

// Query untuk Laporan Pemenang Lelang
$query = "SELECT 
            b.nama_barang, 
            b.gambar, 
            m.nama_lengkap, 
            m.username, 
            m.telp, 
            p.harga_penawaran, 
            l.tgl_lelang
          FROM tb_lelang l 
          JOIN tb_barang b ON l.id_barang = b.id_barang 
          JOIN tb_penawaran p ON p.id_lelang = l.id_lelang
          JOIN tb_masyarakat m ON p.id_user = m.id_user 
          WHERE p.harga_penawaran = (SELECT MAX(p2.harga_penawaran) 
                                     FROM tb_penawaran p2 
                                     WHERE p2.id_lelang = l.id_lelang) 
            AND l.status = 'ditutup'"; // Changed 'ditutup' to 'selesai' for clarity, assuming it's the final status. If 'ditutup' is the correct final status, please revert.

$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}

// Set locale untuk tanggal Indonesia
setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'id', 'Indonesian_Indonesia.1252', 'Indonesian');
date_default_timezone_set('Asia/Jakarta');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pemenang Lelang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        h2 {
            margin-bottom: 15px;
            text-align: center;
            color: #000;
        }

        /* Styling untuk info filter yang diterapkan (akan muncul saat cetak) */
        .print-info {
            display: none; /* Sembunyikan secara default */
            margin-bottom: 15px;
            font-size: 0.9em;
            line-height: 1.5;
        }

        .print-info p {
            margin: 0;
            padding: 2px 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px; /* Jarak lebih besar dari judul/filter */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Tambahkan sedikit shadow untuk tampilan di layar */
        }

        th,
        td {
            border: 1px solid #ddd; /* Border lebih terang */
            padding: 10px 12px; /* Padding sedikit lebih besar */
            text-align: left; /* Teks diatur ke kiri untuk keterbacaan yang lebih baik */
            vertical-align: top; /* Konten diatur ke atas */
        }

        th {
            background-color: #f8f8f8; /* Latar belakang header yang sedikit lebih terang */
            font-weight: bold;
            color: #555;
            text-transform: uppercase; /* Huruf kapital di header */
            font-size: 0.85em;
        }

        td {
            font-size: 0.85em;
        }

        /* Styling untuk baris ganjil/genap (opsional, untuk keterbacaan) */
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        img {
            max-width: 80px; /* Perkecil ukuran gambar untuk tabel */
            height: auto;
            display: block; /* Agar img bisa di-margin auto untuk tengah */
            margin: 0 auto; /* Tengah gambar */
            border: 1px solid #eee; /* Sedikit border pada gambar */
            padding: 2px;
        }

        .print-button-container { /* Kontainer untuk tombol cetak */
            text-align: right; /* Pindahkan tombol cetak ke kanan */
            margin-bottom: 20px;
        }

        .print-button-container button { /* Styling tombol cetak */
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .print-button-container button:hover {
            background-color: #218838;
        }

        /* ==================================== */
        /* STYLING UNTUK CETAK (PRINT) */
        /* ==================================== */
        @media print {
            body {
                margin: 0; /* Hapus margin body saat cetak */
                padding: 0;
                -webkit-print-color-adjust: exact; /* Penting untuk warna latar belakang dan teks */
                print-color-adjust: exact;
                font-size: 10pt; /* Ukuran font lebih kecil untuk cetak */
            }

            h2 {
                margin-top: 20px; /* Jarak dari atas kertas */
                margin-bottom: 20px;
                font-size: 1.5em; /* Ukuran heading yang sesuai untuk cetak */
                text-align: center;
                color: #000;
            }

            .filter, /* Tidak ada filter di laporan ini, tapi tetap disembunyikan jika ada */
            .print-button-container { /* Sembunyikan elemen ini saat dicetak */
                display: none;
            }

            .print-info {
                display: block; /* Tampilkan info laporan saat cetak */
                text-align: left;
                margin: 0 20px 20px 20px; /* Jarak dari tepi kertas */
                padding-bottom: 10px;
                border-bottom: 1px solid #eee; /* Garis bawah pemisah */
                font-size: 0.9em;
            }
            .print-info p {
                margin: 0;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 0; /* Tidak perlu margin atas karena ada print-info */
                box-shadow: none; /* Hapus shadow saat cetak */
            }

            th,
            td {
                border: 1px solid #999; /* Border lebih solid untuk cetak */
                padding: 8px 10px;
                font-size: 0.8em; /* Ukuran font lebih kecil di tabel */
            }

            th {
                background-color: #e8e8e8; /* Latar belakang header lebih gelap untuk cetak */
                color: #333;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2; /* Latar belakang baris genap */
            }
            /* Pastikan warna teks tidak terlalu pudar */
            td {
                color: #000;
            }

            img {
                max-width: 60px; /* Perkecil ukuran gambar lebih lanjut untuk cetak */
                height: auto;
                border: none; /* Hapus border pada gambar saat cetak */
            }

            /* Untuk orientasi portrait, karena tabel ini tidak terlalu lebar */
            @page {
                size: A4 portrait;
                margin: 1.5cm; /* Margin yang rapi untuk kertas */
            }
        }
    </style>
</head>

<body>

    <div class="print-button-container">
        <button onclick="window.print()">Cetak Laporan</button>
    </div>

    <h2>Laporan Pemenang Lelang</h2>

    <div class="print-info">
        <p><strong>Dicetak pada:</strong> <?= strftime('%d %B %Y, %H:%M:%S', time()) ?> WIB</p>
    </div>

    <table>
        <tr>
            <th>Gambar</th>
            <th>Nama Barang</th>
            <th>Nama Pemenang</th>
            <th>Username Pemenang</th>
            <th>No. Telepon Pemenang</th>
            <th>Harga Menang</th>
            <th>Tanggal Lelang</th>
        </tr>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="text-align: center;">
                        <?php if (!empty($row['gambar'])): ?>
                            <img src="/bidcar/dir/img/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['nama_barang']) ?>">
                        <?php else: ?>
                            Tidak ada gambar
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                    <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['telp']) ?></td>
                    <td>Rp<?= number_format($row['harga_penawaran'], 0, ',', '.') ?></td>
                    <td>
                        <?php
                            $tgl_lelang_formatted = strftime('%d %B %Y', strtotime($row['tgl_lelang']));
                            echo $tgl_lelang_formatted;
                        ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Tidak ada data pemenang lelang.</td>
            </tr>
        <?php endif; ?>
    </table>

</body>

</html>