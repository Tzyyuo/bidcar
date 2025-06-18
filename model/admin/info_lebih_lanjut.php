<?php
session_start();

include '../../config/koneksi.php';

if (!isset($_SESSION['id_petugas']) || !isset($_SESSION['level'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu.');
        window.location.href = '/bidcar/views/login.php';
    </script>";
    exit;
}

if (!isset($_GET['id_lelang'])) {
    echo "Lelang tidak ditemukan.";
    exit;
}

$id_petugas = $_SESSION['id_petugas']; // Asumsi 'id_petugas' disimpan di session
$query = mysqli_query($koneksi, "SELECT * FROM tb_petugas WHERE id_petugas = '$id_petugas'");
$pfp = mysqli_fetch_assoc($query);

$id_lelang = $_GET['id_lelang'];

// Ambil detail lelang + barang
$query = "SELECT l.*, b.nama_barang, b.harga_awal, b.gambar, b.deskripsi_barang, b.transmisi, b.tgl
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
    <link rel="stylesheet" href="../../css/info_lebih_lanjut-admin.css">
</head>
<body>
    <div class="main-wrapper">
        <div class="sidebar">
            <h1>BidCar.</h1>
            <hr class="sidebar-divider"/>

            <ul>
                <li><a href="/bidcar/model/admin/dashboard_admin.php"><img src="../../img/dashboard-icon.svg" alt="dashboard"/>Dashboard</a></li>
                <li><a href="/bidcar/model/admin/data_barang.php"><img src="../../img/barang-icon.svg" alt="barang"/>Data Barang</a></li>
                <li class="active"><a href="/bidcar/model/admin/data_lelang.php"><img src="../../img/lelang-icon.svg" alt="lelang"/>Data Lelang</a></li>
                <li><a href="/bidcar/model/admin/data_petugas.php"><img src="../../img/admin-icon.svg" alt="admin"/>Data Petugas</a></li>
                <li><a href="/bidcar/model/admin/data_pengguna.php"><img src="../../img/user-icon.svg" alt="user"/>Data User</a></li>
            </ul>

            <hr class="sidebar-divider"/>
            <form method="GET" action="../controllers/logout_controllers.php">
                <button type="button" name="logout" class="logout-btn">
                    <a href="/bidcar/controllers/logout_controllers.php"><img src="../../img/logout-icon.svg" alt="logout"/>Logout</a>
                </button>
            </form>
        </div>

        <div class="content">
            <div class="navbar-content">
                <div class="navbar-left">
                    <img src="../../img/bidcar alt color 3.svg" alt="BidCar Logo" class="header-logo">
                </div>
                <div class="header-right">
                    <a href="../../views/profile-petugas.php">
                        <div class="petugas-profile">
                            <?php
                            // Menentukan nama file gambar default/ikon seperti di halaman profil
                            $default_profile_image = 'default.png';
                            $placeholder_icon_image = 'profile-pfp.svg';

                            $foto_petugas_path = '';
                            if (isset($pfp['foto']) && !empty($pfp['foto']) && $pfp['foto'] != $default_profile_image) {
                                $foto_petugas_path = htmlspecialchars($pfp['foto']);
                            } else {
                                $foto_petugas_path = $placeholder_icon_image;
                            }
                            ?>

                            <img src="/bidcar/img/<?= $foto_petugas_path ?>" alt="Foto Petugas" class="petugas-icon">
                            <span><?= htmlspecialchars($pfp['username'])?></span>
                        </div>
                    </a>
                </div>
            </div>

            <h1>Info Lebih Lanjut</h1>

            <div class="car-info">
                <div class="image">
                    <img src="../../dir/img/<?= $lelang['gambar'] ?>" width="100%" alt="Gambar Barang">
                </div>
                <div class="detail">
                    <h3 class="info-title"><?= strtoupper($lelang['nama_barang']) ?></h3>

                    <p class="detail-item">
                        <span class="icon"><img src="../../img/calendar.svg" alt="kalender"></span> <span class="text-info">
                            <?php
                                // Set locale ke bahasa Indonesia
                                setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'id'); // Mencoba beberapa variasi locale untuk kompatibilitas

                                date_default_timezone_set('Asia/Jakarta');
                                $tgl_lelang_timestamp = strtotime($lelang['tgl_lelang']);
                                $tgl_selesai_timestamp = strtotime($lelang['tgl_selesai']);

                                // Format tanggal menggunakan strftime
                                $tgl_lelang_formatted = strftime('%d %B %Y', $tgl_lelang_timestamp);
                                $tgl_selesai_formatted = strftime('%d %B %Y', $tgl_selesai_timestamp);

                                echo $tgl_lelang_formatted . ' - ' . $tgl_selesai_formatted;
                            ?>
                        </span>
                    </p>

                    <p class="detail-item">
                        <span class="icon"><img src="../../img/transmisi.svg" alt="transmisi"></span> <span class="text-info"><?= htmlspecialchars($lelang['transmisi']) ?></span>
                    </p>

                    <p class="description"><?= htmlspecialchars($lelang['deskripsi_barang']) ?></p>

                    <div class="harga-section">
                        <div class="harga-item">
                            <p class="harga-label">Harga Dasar Lelang</p>
                            <span class="harga-value">Rp<?= number_format($lelang['harga_awal'], 0, ',', '.') ?></span>
                        </div>
                        <div class="harga-separator">
                            <img src="../../img/deal.svg" alt="deal" class="separator-icon">
                        </div>
                        <div class="harga-item">
                            <p class="harga-label">Harga Akhir Lelang</p>
                            <span class="harga-value"><?= $lelang['harga_akhir'] ? 'Rp' . number_format($lelang['harga_akhir'], 0, ',', '.') : '-' ?></span>
                        </div>
                    </div>

                    <div class="bottom-info">
                        <p class="time-left">
                            <span class="icon"><img src="../../img/waktu.svg" alt="waktu"></span> <?php
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
                        <a href="../../controllers/hapus_lelang.php?id_lelang=<?= $row['id_lelang']; ?>" class="delete-link" onclick="return confirm('Apakah Anda yakin ingin menghapus lelang ini?');">
                            <span class="icon"><img src="../../img/delete-small.svg" alt="hapus"></span> Hapus
                        </a>
                    </div>

                     <form action="../../controllers/lelang-controllers.php" method="POST">
                        <input type="hidden" name="id_lelang" value="<?= $id_lelang ?>">

                        <div class="form-status">
                            <label><input type="radio" name="status" value="dibuka"> Buka Lelang</label>
                            <label><input type="radio" name="status" value="ditutup"> Tutup Lelang</label>
                        </div>

                        <div class="form-konfirmasi">
                            <button type="submit" class="btn-confirm" name="konfirmasi" id="btnKonfirmasi" disabled>Konfirmasi</button>
                        </div>
                    </form> 

                    <script>
                            const radios = document.querySelectorAll('input[name="status"]');
                            const btn = document.getElementById('btnKonfirmasi');

                            radios.forEach(radio => {
                                radio.addEventListener('change', () => {
                                    btn.disabled = false;
                                    btn.classList.add('active');
                                });
                            });
                    </script>
                </div>
            </div>

            <hr>

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
                                           $status_teks = ['menang' => 'Menang', 'kalah' => 'Kalah'][$row['status']] ?? 'Belum ada';

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
    </div>
        <script>
        window.addEventListener("pageshow", function(event) {
            if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
                window.location.reload();
            }
        });
    </script>
</body>
</html>