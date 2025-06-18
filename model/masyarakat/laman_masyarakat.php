<?php 
session_start();
include '../../config/koneksi.php'; 

if (!isset($_SESSION['id_user'])) {
    $_SESSION['flash'] = [
    'icon' => 'warning',
    'title' => 'Silakan login!',
    'text' => 'Tidak bisa mengakses laman'
    ];
    header("Location: /bidcar/views/login.php");
    exit;

}

$id_user = $_SESSION['id_user'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_masyarakat WHERE id_user = '$id_user'");
$pfp = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BidCar</title>
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <link rel="stylesheet" href="../../css/laman_masyarakat.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css"><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Navbar -->
    <navbar class="navigasi">
        <div class="logo">
            <img src="/bidcar/img/bidcar alt color 1.svg">
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#about-me">Tentang</a></li>
                <li><a href="#help-center">Pusat Bantuan</a></li>
                <li><a href="../../model/masyarakat/history.php">Riwayat Pelelangan</a></li>
            </ul>
        </div>
        <a href="../../views/profile.php">
        <div class="button-container">
            <button class="profile">
                <?php
                    // Menentukan nama file gambar default/ikon seperti di halaman profil
                    $default_profile_image = 'default.png';
                    $placeholder_icon_image = 'profile-pfp.svg';

                        $foto_user_path = '';
                        if (isset($pfp['foto']) && !empty($pfp['foto']) && $pfp['foto'] != $default_profile_image) {
                            $foto_user_path = htmlspecialchars($pfp['foto']);
                        } else {
                            $foto_user_path = $placeholder_icon_image;
                        }
                    ?>
            <img src="../../img/<?= $foto_user_path ?>" alt="pfp" class="pfp">
            <?= $pfp['username']?>
            </button>

            <a href="/bidcar/controllers/logout_controllers.php"><button class="btn-kontak-kami"><img src="../../img/logout-icon.svg" alt="Phone Icon" class="icon">Logout
            </button></a>
        </div>
        </a>
    </navbar>
    <!-- Navbar -->

    <!-- Banner -->
    <section class="hero-banner" id="home">
        <div class="hero-content">
        </div>
    </section>
    <!-- Banner -->

    <!-- Lelang -->
    <?php
    $query = "SELECT b.id_barang, b.nama_barang, b.gambar, l.id_lelang, l.status,
            l.tgl_lelang AS tgl, b.transmisi AS transmisi, b.harga_awal, COALESCE(l.harga_akhir, b.harga_awal) AS harga_terkini, b.thn
            FROM tb_barang b JOIN tb_lelang l ON b.id_barang = l.id_barang
            WHERE l.status = 'dibuka' ORDER BY l.tgl_lelang DESC";


    $result = mysqli_query($koneksi, $query);

    ?>

    <section class="lelang-section">
        <div class="lelang-heading">
            <span class="outline-btn">Daftar Lelang</span>
        </div>
    </section>

    <div class="card-container">
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <a href="/bidcar/views/penawaran.php?id_barang=<?= $row['id_barang'] ?>&id_lelang=<?= $row['id_lelang'] ?>"
            class="card-link">
            <div class="card">
                <img src="/bidcar/dir/img/<?= $row['gambar'] ?>" alt="<?= $row['nama_barang'] ?>">
                <div class="card-body">
                    <h3><?= strtoupper($row['nama_barang']) ?></h3>
                    <?php 
                        // Set locale untuk tanggal Indonesia
                        setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'id');
                        date_default_timezone_set('Asia/Jakarta');
                    ?>
                      <p><img src="../../img/calendar.svg" alt="thn">
                        <?php
                        $timestamp = strtotime($row['thn']);
                        // Format tanggal ke "Hari Bulan Tahun" dalam bahasa Indonesia
                        echo strftime('%e %B %Y', $timestamp);
                        ?></p>
                    <p><img src="../../img/waktu.svg" alt="waktu">     
                        <?php
                        $timestamp = strtotime($row['tgl']);
                        // Format tanggal ke "Hari Bulan Tahun" dalam bahasa Indonesia
                        echo strftime('%e %B %Y', $timestamp);
                        ?></p>
                    <p><img src="../../img/transmisi.svg" alt="transmisi"> <?= $row['transmisi'] ?></p>
                    <!-- <div class="price">Rp<?= number_format($row['harga_terkini'], 0, ',', '.') ?></div> -->
                    <p class="price">
                    <span>Rp<?= number_format($row['harga_awal'], 0, ',', '.') ?></span>
                    </p>
                </div>
            </div>
        </a>
    <?php endwhile; ?>
</div>
    <!-- Lelang -->

    <hr>

    <!-- Tentang -->
    <section class="about-section" id="about-me">
        <div class="about-heading">
            <span class="outline-btn">Kenapa Lelang di <span class="highlight">BidCar?</span></span>
        </div>
    </section>

    <section class="card-lelang">
    <div class="fitur-kartu">
        <img src="../../img/easy-icon.svg" alt="Easy Auction">
        <div class="teks-kartu">
        <h3>Easy <br>Auction</h3>
        <p>Ikuti proses lelang mobil tanpa ribet! Cukup daftar, pilih mobil, dan mulai bid langsung dari perangkat kamu. Semuanya real-time dan transparan</p>
        </div>
    </div>

    <div class="fitur-kartu">
        <img src="../../img/verified-icon.svg" alt="Verified Cars">
        <div class="teks-kartu">
        <span class="warna-verif"><h3>Verified <br>Cars</h3>
        <p>Semua mobil yang dilelang telah melalui inspeksi menyeluruh. Dapatkan informasi detail dan kondisi asli mobil sebelum kamu menawar!</p></span>
        </div>
    </div>

    <div class="fitur-kartu">
        <img src="../../img/trusted-icon.svg" alt="Trusted Platform">
        <div class="teks-kartu">
        <h3>Trusted <br>Platform</h3>
        <p>Dengan sistem keamanan canggih dan tim support yang siap bantu 24/7, BidCar selalu memastikan setiap transaksi berlangsung aman dan nyaman</p>
        </div>
    </div>
    </section>

    <!-- Tentang -->

    <!-- Pusat Bantuan -->
     <section class="pusat-bantuan" id="help-center"></section>
    <!-- Pusat Bantuan -->

    <!-- Fun Fact -->
     <section class="fun-fact"></section>
    <!-- Fun Fact -->

    <!-- Footer -->
    <footer class="bagian-bawah">
    <div class="isi-footer">
        <img class= "icon-footer" src="../../img/bidcar alt color 2.svg">
        <p>Jl. Jl Doang No.05, RT.007/RW.015, Cilacap,<br>Kec. Kangkung, Kota Ngawi, Jawa Barat<br>17117</p>
        <a href="https://instagram/bidcar.id/">
        <img class="icon-sosmed" src="../../img/ig.svg">
        </a>
        <img class="icon-fb" src="../../img/fb.svg">
        <a href="https://wa.me/6282119313735?text=Halo+selamat+siang+BidCar!+Saya+ingin+bertanya+tentang+lelang.">
        <img class="icon-wa" src="../../img/wa.svg">
        </a>
    </div>
    <div class="hub">
        <h3>Butuh Bantuan Langsung?</h3>
        <p>Tim kami selalu online untuk kamu, 24 jam sehari!</p>
        <div class="kontak-item">
            <img src="../../img/kontak.svg" alt="telepon">
            <span>+62-892-8237-2115</span>
        </div>
        <div class="kontak-item">
            <img src="../../img/email.svg" alt="email">
            <span>bidcar5@gmail.com</span>
        </div>
    </div>
    </footer>
    <!-- Footer -->
     <script>
  window.addEventListener("pageshow", function (event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
      window.location.reload(); 
    }
  });
</script>

</body>

<a href="https://aistudio.instagram.com/ai/722561573512995/?utm_source=share">
    <div class="floating-chatbot-container" onclick="toggleChatbox()">
        <div class="chatbot-bubble">
            <img src="/bidcar/img/bidcar-assistant.png" class="chat-icon" alt="Chat Icon">
            <span class="chat-text">Tanya BidCar Assistant</span>
            <div class="chat-tail"></div>
        </div>
    </div>
</a>

</html>

