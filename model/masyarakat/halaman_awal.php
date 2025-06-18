<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BidCar</title>
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <link rel="stylesheet" href="/bidcar/css/index.css">
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
            </ul>
        </div>
        <a href="../../views/login.php">
            <div class="button-container">
                <button class="btn-masuk">
                    <img src="../../img/Login.svg" alt="Login Icon" class="icon">
                    <a href="../../views/login.php">Masuk</a>
                </button>

                <button class="btn-kontak-kami">
                    <a href="https://wa.me/6283820428685?text=Halo+Saya+ingin+bertanya+soal+mobil+yang+sedang+dilelang+saya+tertarik+dengan+mobil+ini%3A">
                        Kontak Kami
                    </a>
                    <img src="../../img/phone icon.png" alt="Phone Icon" class="icon">
                </button>
            </div>
        </a>
    </navbar>
    <!-- Navbar -->

    <!-- Banner -->
    <section class="hero-banner" id="home">
        <div class="hero-content">
            <a href="../../views/registrasi.php" class="btn-registrasi">
                Ikut Lelang Disini
                <span class="icon-wrapper">
                    <img src="../../img/arrow-icon.svg" alt="Arrow Icon">
                </span>
            </a>
        </div>
    </section>
    <!-- Banner -->

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
                <span class="warna-verif">
                    <h3>Verified <br>Cars</h3>
                    <p>Semua mobil yang dilelang telah melalui inspeksi menyeluruh. Dapatkan informasi detail dan kondisi asli mobil sebelum kamu menawar!</p>
                </span>
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
            <img class="icon-footer" src="../../img/bidcar alt color 2.svg">
            <p>Jl. Jl Doang No.05, RT.007/RW.015, Cilacap,<br>Kec. Kangkung, Kota Ngawi, Jawa Barat<br>17117</p>
            <a href="https://instagram.com/bidcar.id/">
                <img class="icon-sosmed" src="../../img/ig.svg">
            </a>
            <img class="icon-fb" src="../../img/fb.svg">
            <a href="https://wa.me/6283820428685?text=Halo+selamat+siang+BidCar!+Saya+ingin+bertanya+tentang+lelang.">
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