<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang BidCar</title>
    <style>
        .about-section {
  display: flex;
  justify-content: left;
  gap: 40px;
  padding: 30px 120px;
}

.about-heading {
  text-align: center;
  /* margin-bottom: 2rem; */
}

.outline-btn {
  border: 1.5px solid #1a1a1a;
  padding: 0.4rem 1rem;
  border-radius: 2rem;
  font-weight: 500;
  font-size: 1rem;
  display: inline-block;
}

.outline-btn .highlight {
  color: #4AA3A2;
}

.card-lelang {
  display: flex;
  justify-content: center;
  gap: 40px;
}

.fitur-kartu {
  position: relative;
  width: 350px;
  /* height: 340px; */
}

.fitur-kartu img {
  width: 100%;
  height: 100%;
}

.teks-kartu {
  position: absolute;
  top: 58%;
  left: 50%;
  transform: translate(-50%, -25%);
  width: 80%;
  text-align: left;
  color: #333;
}

.teks-kartu h3 {
  font-size: 40px;
  margin-bottom: 10px;
  line-height: 1.1;
  letter-spacing: 1px;
  font-family: 'Product Sans Light';
}

.warna-verif {
  color: #FDFDFD;
}

.teks-kartu p {
  font-size: 13px;
  line-height: 1.3;
  font-family: 'Helvetica Neue';
  font-weight: 300;
  letter-spacing: 0.4px;
}

    </style>
</head>

<body>
    <!-- Tentang -->
    <section class="about-section" id="about-me">
        <div class="about-heading">
            <span class="outline-btn">Kenapa Lelang di <span class="highlight">BidCar?</span></span>
        </div>
    </section>

    <section class="card-lelang">
        <div class="fitur-kartu">
            <img src="/bidcar/img/easy-icon.svg" alt="Easy Auction">
            <div class="teks-kartu">
                <h3>Easy <br>Auction</h3>
                <p>Ikuti proses lelang mobil tanpa ribet! Cukup daftar, pilih mobil, dan mulai bid langsung dari perangkat kamu. Semuanya real-time dan transparan</p>
            </div>
        </div>

        <div class="fitur-kartu">
            <img src="/bidcar/img/verified-icon.svg" alt="Verified Cars">
            <div class="teks-kartu">
                <span class="warna-verif">
                    <h3>Verified <br>Cars</h3>
                    <p>Semua mobil yang dilelang telah melalui inspeksi menyeluruh. Dapatkan informasi detail dan kondisi asli mobil sebelum kamu menawar!</p>
                </span>
            </div>
        </div>

        <div class="fitur-kartu">
            <img src="/bidcar/img/trusted-icon.svg" alt="Trusted Platform">
            <div class="teks-kartu">
                <h3>Trusted <br>Platform</h3>
                <p>Dengan sistem keamanan canggih dan tim support yang siap bantu 24/7, BidCar selalu memastikan setiap transaksi berlangsung aman dan nyaman</p>
            </div>
        </div>
    </section>

    <!-- Tentang -->
    </secti>
</body>

</html>