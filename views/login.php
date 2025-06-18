<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BidCar</title>
    <link rel="icon" href="/bidcar/img/icon-web.svg">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css"><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>
<body>
    <div class="login">
        <div class="container-logo">
            <img class="logo" alt="bidcar" src="../img/bidcar login.svg" width="100px">
            <h2>Masuk ke <span class="brand">BidCar.</span></h2>
            <p class="sub-title">Masukkan akun Anda dan Mulailah membuat tawaran Anda!</p>
        </div>
        <form action="../controllers/login_controllers.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Masukkan Username" required>
            
            <label for="password">Password</label>
            <div class="password-input-container">
              <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility()">
                    <img id="toggleIcon" src="../img/eye-close.svg" alt="Show Password"> 
                </span>
            </div>
            <button type="submit" name="submit">Masuk</button>
        </form>
        <div class="link">
            <p>Belum Punya Akun?<a href="registrasi.php"> Sign Up</a></p>
            <!-- <p>Lupa <a href="lupa_password.php">Password?</a></p> -->
        </div>
    </div>
    <div class="right-side">
        <img src="../img/car image(left).svg" alt="Gambar Mobil">
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.src = '../img/eye-open.svg'; 
                toggleIcon.alt = 'Hide Password';
            } else {
                passwordInput.type = 'password';
                toggleIcon.src = '../img/eye-close.svg'; 
                toggleIcon.alt = 'Show Password'; 
            }
        }
    </script>
    <?php include '../controllers/notifikasi.php';?>
</body>
</html>