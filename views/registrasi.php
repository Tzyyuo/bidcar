<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi-BidCar</title>
</head>
<body>
    
    <div class="form-container">
        <div class="logo"><img src="bidcar.png"></div>  
        <div class="image"><img src="Maskgroup.png"> </div>
        <h2>Selamat datang di<span style="color: cadetblue;">BidCar.</span></h2>
        <p>Siapkan akun Anda dan Mulailah membuat tawaran pertama Anda!</p>
        
        <form action = "../controllers/registrasi_controllers.php" method="POST">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" required>
 
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Masukkan Username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan Password" required>

            <label for="telp">No Telepon</label><br>
            <input type="text" id="telp" name="telp" placeholder="Masukkan No. Telepon" required><br><br>

            <button type="submit" name = "submit" class="btn-submit">Daftar</button>
        </form>
        <p>Sudah Punya Akun? <a href="login.php">login</a></p>
    </div>    
</body>
</html>