<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - BidCar</title>
</head>
<body>
    <div class="container">
        <div class="forgot">
            <h2>Lupa Password</h2>
            <p>Masukkan password baru Anda</p>

            <form action="../controllers/lupa_password.php" method="POST">

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <button type="submit" name="submit">Selesai</button>
            </form>
        </div>
        <div class="right-side">
            <img src="../img/Maskgroup.png">
        </div>
    </div>
</body>
</html>