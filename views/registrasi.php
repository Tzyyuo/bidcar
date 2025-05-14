<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registrasi - BidCar</title>
  <link rel="stylesheet" href="../css/registrasi.css">
</head>
<body>
  <div class="container">
    <div class="image-section">
      <img src="../img/Maskgroup.png" alt="Gambar Mobil">
    </div>
    <div class="form-section">
      <div class="logo">
        <img src="../img/bidcar.png" alt="Logo BidCar">
      </div>
      <h2>Selamat Datang di <span>BidCar.</span></h2>
      <p>Siapkan akun Anda dan mulailah membuat tawaran pertama Anda!</p>

      <form action="../controllers/registrasi_controllers.php" method="POST">
        <label for="nama">Nama Lengkap</label>
        <input type="text" id="nama" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" required>

        <div class="row">
          <div class="col">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Masukkan Username" required>
          </div>
          <div class="col">
            <label for="telp">No Telepon</label>
            <input type="text" id="telp" name="telp" placeholder="Masukkan No. Telp" required>
          </div>
        </div>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Masukkan Password" required >

        <button type="submit" class="btn-submit" name="submit">Daftar</button>
      </form>

      <p class="login-link">Sudah Punya Akun? <a href="login.php">Log In</a></p>
    </div>
  </div>
</body>
</html>
