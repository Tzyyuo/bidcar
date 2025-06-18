<?php
session_start();
include '../../config/koneksi.php';

if (!isset($_SESSION['id_user'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu.');
        window.location.href = '/bidcar/views/login.php';
    </script>";
    exit;
}

$id_user = $_SESSION['id_user'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_masyarakat WHERE id_user = '$id_user'");
$pfp = mysqli_fetch_assoc($query);

$id_user = $_SESSION['id_user'];
$query = "SELECT h.*, l.id_barang, b.nama_barang, b.gambar, b.transmisi, b.harga_awal, m.nama_lengkap, 
        l.tgl_lelang AS tgl, l.harga_akhir AS harga_terakhir FROM history_lelang h JOIN tb_lelang l 
        ON h.id_lelang = l.id_lelang JOIN tb_barang b ON l.id_barang = b.id_barang JOIN tb_masyarakat m 
        ON h.id_user = m.id_user WHERE h.id_user = ? AND l.status = 'Ditutup'
        ORDER BY h.id_history DESC";

$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Lelang</title>
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <link rel="stylesheet" href="../../css/history.css">
</head>
<body>
    <!-- Navbar -->
    <navbar class="navigasi">
        <div class="logo">
            <img src="/bidcar/img/bidcar alt color 1.svg">
            <ul>
                <li><a href="../../model/masyarakat/laman_masyarakat.php">Home</a></li>
                <li><a href="../../model/masyarakat/laman_masyarakat.php#about-me">Tentang</a></li>
                <li><a href="../../model/masyarakat/laman_masyarakat.php#help-center">Pusat Bantuan</a></li>
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
    <section class="lelang-section">
        <div class="lelang-heading">
            <span class="outline-btn">History Lelang</span>
        </div>
    </section>

    <div class="card-container">
    <?php while ($row =  $result->fetch_assoc()) : ?>
        <a href="detail_history.php?id_lelang=<?= $row['id_lelang'] ?>"
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

    <!-- Footer -->
    <footer class="bagian-bawah">
    <div class="isi-footer">
        <img class= "icon-footer" src="../../img/bidcar alt color 2.svg">
        <p>Jl. Jl Doang No.05, RT.007/RW.015, Cilacap,<br>Kec. Kangkung, Kota Ngawi, Jawa Barat<br>17117</p>
        <img class="icon-sosmed" src="../../img/ig.svg">
        <img class="icon-fb" src="../../img/fb.svg">
        <img class="icon-wa" src="../../img/wa.svg">
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
</html>