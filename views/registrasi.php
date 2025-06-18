<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registrasi - BidCar</title>
  <link rel="icon" href="/bidcar/img/icon-web.svg">
  <link rel="stylesheet" href="../css/registrasi.css">
</head>
<body>
    <div class="container-image">
      <div class="image-section">
        <img src="../img/car image(right).svg" alt="Gambar Mobil">
      </div>
    </div>

    <div class="container-form">
      <div class="form-section">
        <div class="header">
          <div class="logo">
            <img src="../img/bidcar signup.svg" alt="Logo BidCar">
          </div>
          <h2>Selamat Datang di <span>BidCar.</span></h2>
          <p>Siapkan akun Anda dan mulailah membuat tawaran pertama Anda!</p>
        </div>

        <form action="../controllers/registrasi_controllers.php" method="POST">
          <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" required>
          </div>

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

          <div class="form-group">
            <label for="password">Password</label>
            <div class="password-input-container">
              <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility()">
                    <img id="toggleIcon" src="../img/eye-close.svg" alt="Show Password"> 
                </span>
            </div>
          </div>

          <button type="submit" class="btn-submit" name="submit">Daftar</button>
        </form>

        <p class="login-link">Sudah Punya Akun? <a href="login.php">Log In</a></p>
      </div>
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

        // JavaScript untuk No. Telepon 08XX-XXXX-XXXX
        document.addEventListener('DOMContentLoaded', function() {
            const telpInput = document.getElementById('telp');

            telpInput.addEventListener('input', function(e) {
                let value = telpInput.value.replace(/\D/g, ''); 
                let formattedValue = '';

                if (value.length > 0) {
                    if (!value.startsWith('08')) {
                        value = '08' + value;
                    }
                    if (value.length > 2) { 
                        formattedValue += value.substring(0, 4); 
                        if (value.length > 4) {
                            formattedValue += '-' + value.substring(4, 8); 
                            if (value.length > 8) {
                                formattedValue += '-' + value.substring(8, 13); 
                            }
                        }
                    } else {
                        formattedValue = value;
                    }
                }

                telpInput.value = formattedValue;
            });

            telpInput.addEventListener('keydown', function(e) {
         
                if (e.key === 'Backspace' || e.key === 'Delete') {
                    return;
                }
              
                if (telpInput.value.length === 2 && telpInput.value === '08' && e.key === 'Backspace') {
                    e.preventDefault(); 
                }
            });

          
            telpInput.addEventListener('focus', function() {
                if (telpInput.value === '') {
                    telpInput.value = '08';
                }
            });

            telpInput.addEventListener('blur', function() {
                if (telpInput.value === '08') {
                    telpInput.value = '';
                }
            });
        });
      </script>
</body>
</html>