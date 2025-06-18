<?php
session_start();
include (__DIR__) . '/../config/koneksi.php';
if (!isset($_GET['id_lelang'])) {
    echo "Lelang tidak ditemukan.";
    exit;
}

$id_user = $_SESSION['id_user'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_masyarakat WHERE id_user = '$id_user'");
$pfp = mysqli_fetch_assoc($query);

$id_lelang = $_GET['id_lelang'];

//ambil data lelang
$query = "SELECT l.*, b.nama_barang, b.harga_awal, b.gambar, b.deskripsi_barang, b.transmisi, b.tgl, b.thn
          FROM tb_lelang l
          JOIN tb_barang b ON l.id_barang = b.id_barang
          WHERE l.id_lelang = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_lelang);
$stmt->execute();
$result = $stmt->get_result();
$lelang = $result->fetch_assoc();

// Ambil penawar
$query_penawar = "SELECT h.penawaran_harga, m.nama_lengkap
                  FROM history_lelang h
                  JOIN tb_masyarakat m ON h.id_user = m.id_user
                  WHERE h.id_lelang = ?";
$stmt = $koneksi->prepare($query_penawar);
$stmt->bind_param("i", $id_lelang);
$stmt->execute();
$penawar = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Lelang - BidCar</title>
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <link rel="stylesheet" href="../css/penawaran.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css"><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Navbar -->
    <navbar class="navigasi">
        <div class="logo">
            <img src="/bidcar/img/bidcar alt color 1.svg">
            <ul>
                <li><a href="../model/masyarakat/laman_masyarakat.php">Home</a></li>
                <li><a href="../model/masyarakat/laman_masyarakat.php#about-me">Tentang</a></li>
                <li><a href="../model/masyarakat/laman_masyarakat.php#help-center">Pusat Bantuan</a></li>
                <li><a href="../model/masyarakat/history.php">Riwayat Pelelangan</a></li>
            </ul>
        </div>
        <a href="../views/profile.php">
        <div class="button-container">
            <button class="profile">
                <?php
                    
                    $default_profile_image = 'default.png';
                    $placeholder_icon_image = 'profile-pfp.svg';

                   
                        $foto_user_path = '';
                        if (isset($pfp['foto']) && !empty($pfp['foto']) && $pfp['foto'] != $default_profile_image) {
                            $foto_user_path = htmlspecialchars($pfp['foto']);
                        } else {
                            $foto_user_path = $placeholder_icon_image;
                        }
                    ?>
            <img src="../img/<?= $foto_user_path ?>" alt="pfp" class="pfp">
            <?= $pfp['username']?>
            </button>

            <a href="/bidcar/controllers/logout_controllers.php"><button class="btn-kontak-kami"><img src="../img/logout-icon.svg" alt="Phone Icon" class="icon">Logout
            </button></a>
        </div>
        </a>
    </navbar>
    <!-- Navbar -->
        <div class="content">
            <div class="car-info">
                <div class="image">
                    <img src="../dir/img/<?= $lelang['gambar'] ?>" width="100%" alt="Gambar Barang">
                </div>
                <div class="detail">
                    <h3 class="info-title"><?= strtoupper($lelang['nama_barang']) ?></h3>
                      <p>Rilis:
                        <?php
                        $timestamp = strtotime($lelang['thn']);
                        // Format tanggal ke "Hari Bulan Tahun" dalam bahasa Indonesia
                        echo strftime('%e %B %Y', $timestamp);
                        ?></p>
                    <p class="detail-item">
                        <span class="icon"><img src="../img/calendar.svg" alt="kalender"></span> <span class="text-info">
                            <?php
                                // Set locale ke bahasa Indonesia
                                setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'id');

                                date_default_timezone_set('Asia/Jakarta');
                                $tgl_lelang_timestamp = strtotime($lelang['tgl_lelang']);
                                $tgl_selesai_timestamp = strtotime($lelang['tgl_selesai']);

                                $tgl_lelang_formatted = strftime('%d %B %Y', $tgl_lelang_timestamp);
                                $tgl_selesai_formatted = strftime('%d %B %Y', $tgl_selesai_timestamp);

                                echo $tgl_lelang_formatted . ' - ' . $tgl_selesai_formatted;
                            ?>
                        </span>
                    </p>

                    <p class="detail-item">
                        <span class="icon"><img src="../img/transmisi.svg" alt="transmisi"></span> <span class="text-info"><?= htmlspecialchars($lelang['transmisi']) ?></span>
                    </p>

                    <p class="description"><?= htmlspecialchars($lelang['deskripsi_barang']) ?></p>

                    <div class="bottom-info">
                    </div>

                    <div class="harga-section">
                        <div class="harga-item">
                            <p class="harga-label">Harga Dasar Lelang</p>
                            <span class="harga-value">Rp<?= number_format($lelang['harga_awal'], 0, ',', '.') ?></span>
                        </div>

                            <p class="time-left">
                            <span class="icon"><img src="../img/waktu.svg" alt="waktu"></span> <?php
                            $now = new DateTime();
                            $tgl_selesai = new DateTime($lelang['tgl_selesai']);
                            $interval = $now->diff($tgl_selesai);

                            if ($interval->invert == 0 && $interval->days > 0) {
                                echo "Waktu tersisa " . $interval->days . " hari lagi";
                            } elseif ($interval->invert == 0 && $interval->days == 0) {
                                echo "Waktu tersisa kurang dari 1 hari";
                            } else {
                                echo "Lelang sudah selesai";
                            }
                            ?>
                        </p>
                    </div>

                    <div class="form-penawaran">
                        <form method="post" action="../controllers/penawaran_controllers.php">
                            <input type="hidden" name="id_lelang" value="<?= $id_lelang ?>">
                            <input type="text" id="harga_penawaran" name="harga_penawaran" placeholder="Masukkan Nominal Penawaran" required onkeyup="formatRupiah(this)">
                            <button type="submit" class="btn-confirm" name="tawar" id="btnKonfirmasi">Kirim Penawaran</button>
                        </form>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const inputHargaAwal = document.getElementById('harga_awal');

                            function filterNumericInput(event) {
                                let value = event.target.value;
                                value = value.replace(/Rp\s?/g, '').replace(/[^0-9,]/g, '');

                                event.target.value = value;

                                if (typeof formatRupiah === 'function') {
                                    formatRupiah(event.target);
                                }
                            }
                            inputHargaAwal.addEventListener('input', filterNumericInput);

                            if (inputHargaAwal.value) {
                              
                                inputHargaAwal.value = inputHargaAwal.value.replace(/Rp\s?/g, '').replace(/[^0-9,]/g, '');
                                if (typeof formatRupiah === 'function') {
                                    formatRupiah(inputHargaAwal);
                                }
                            }
                        });

                        // Fungsi formatRupiah yang dimodifikasi untuk menambahkan "Rp "
                        function formatRupiah(input) {
                            let angka = input.value.replace(/[^0-9]/g, '');
                                                                            

                            if (!angka) {
                                input.value = "";
                                return;
                            }

                            let reverse = angka.toString().split('').reverse().join('');
                            let ribuan = reverse.match(/\d{1,3}/g);
                            let formatted = ribuan.join('.').split('').reverse().join('');

                            input.value = "Rp " + formatted;
                        }

                    </script>
                </div>
            </div>
        </div>

        <hr>

        <div class="penawar-section">
        <h3>List Penawar</h3>
            <div class="table-section">
                <div class="list-penawar">
                    <table>
                        <thead>
                            <tr>
                                <th class="col-no">No</th>
                                <th class="col-nama">Nama</th>
                                <th class="col-harga">Harga Tawar</th>
                                <th class="col-status">Status</th>
                            </tr>
                        </thead>
                            <tbody>
                               <?php
                               $id_lelang = $_GET['id_lelang'] ?? null;

                               if ($id_lelang !== null) {
                                   $query = "SELECT m.nama_lengkap, h.penawaran_harga, h.status 
                                   FROM history_lelang h
                                   JOIN tb_masyarakat m ON h.id_user = m.id_user
                                   WHERE h.id_lelang = ?
                                   ORDER BY h.penawaran_harga DESC";

                                   $stmt = $koneksi->prepare($query);
                                   if ($stmt === false) {
                                       die('Error prepare: ' . htmlspecialchars($koneksi->error));
                                   }
                                   $stmt->bind_param("i", $id_lelang);
                                   $stmt->execute();
                                   $result = $stmt->get_result();

                                   $nomor = 1;

                                   if ($result->num_rows > 0) {
                                       while ($row = $result->fetch_assoc()) {
                                           $nama_lengkap = htmlspecialchars($row['nama_lengkap']);
                                           $penawaran_harga_rupiah = "Rp" . number_format($row['penawaran_harga'], 0, ',', '.');
                                           
                                           // Tentukan status teks yang akan ditampilkan
                                           $status_teks = ['menang' => 'Menang', 'kalah' => 'Kalah'][$row['status']] ?? 'Tidak Ada';

                                           $status_class = '';
                                           switch ($row['status']) {
                                               case 'menang':
                                                   $status_class = 'status-menang';
                                                   break;
                                               case 'kalah':
                                                   $status_class = 'status-kalah';
                                                   break;
                                               default:
                                                   $status_class = 'status-belum-ada';
                                                   break;
                                           }
                               ?>
                                        <tr>
                                            <td><?= $nomor++ ?></td>
                                            <td><?= $nama_lengkap ?></td>
                                            <td><?= $penawaran_harga_rupiah ?></td>
                                            <td style="text-align: center;"> 
                                                <span class="status-badge <?= htmlspecialchars($status_class) ?>">
                                                    <?= htmlspecialchars($status_teks) ?>
                                                </span>
                                            </td>
                                        </tr>
                               <?php
                                       }
                                   } else {
                                       echo '<tr><td colspan="4">Belum ada penawaran untuk lelang ini.</td></tr>';
                                   }
                                   $stmt->close();
                               } else {
                                   echo '<tr><td colspan="4">ID lelang tidak ditemukan.</td></tr>';
                               }
                               ?>
                           </tbody>
                    </table>
                </div>
            </div>
        </div>

            <!-- Footer -->
    <footer class="bagian-bawah">
    <div class="isi-footer">
        <img class= "icon-footer" src="../img/bidcar alt color 2.svg">
        <p>Jl. Jl Doang No.05, RT.007/RW.015, Cilacap,<br>Kec. Kangkung, Kota Ngawi, Jawa Barat<br>17117</p>
        <img class="icon-sosmed" src="../img/ig.svg">
        <img class="icon-fb" src="../img/fb.svg">
        <img class="icon-wa" src="../img/wa.svg">
    </div>
    <div class="hub">
        <h3>Butuh Bantuan Langsung?</h3>
        <p>Tim kami selalu online untuk kamu, 24 jam sehari!</p>
        <div class="kontak-item">
            <img src="../img/kontak.svg" alt="telepon">
            <span>+62-892-8237-2115</span>
        </div>
        <div class="kontak-item">
            <img src="../img/email.svg" alt="email">
            <span>bidcar5@gmail.com</span>
        </div>
    </div>
    </footer>
    <!-- Footer -->
   <script>
        window.addEventListener("pageshow", function(event) {
            if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
                window.location.reload();
            }
        });
    </script>
 <?php include (__DIR__) . '/../controllers/notifikasi.php';?>
</body>
</html>