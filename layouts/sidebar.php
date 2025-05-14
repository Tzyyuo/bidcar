<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f8f9fa; }
    .sidebar img { width: 30%; height: auto; border-radius: 10px; }
    .container { display: flex; min-height: 100vh; }
    .sidebar { width: 250px; background: white; padding: 20px; border-right: 1px solid #ddd; }
    .sidebar h1 { color: #2b6cb0; font-weight: bold; }
    .sidebar ul { list-style: none; padding: 0; margin-top: 30px; }
    .sidebar li { margin-bottom: 20px; }
    .sidebar a { text-decoration: none; color: #333; display: flex; align-items: center; }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="sidebar">
            <img src="../img/bidcar.png" alt="BidCar Logo">
            <h1>BidCar.</h1>
            <ul>
                <li><a href="/bidcar/model/admin/dashboard_admin.php">Dashboard</a></li>
                <li><a href="/bidcar/model/admin/data_barang.php">Data Barang</a></li>
                <li><a href="/bidcar/model/admin/data_lelang.php">Data Lelang</a></li>
                <li><a href="/bidcar/model/admin/data_petugas.php">Data Petugas</a></li>
                <li><a href="/bidcar/model/admin/data_pengguna.php">Data User</a></li>
                <li><a href="/bidcar/views/logout.php"><-Logout</a></li>
            </ul>
        </div>
</div>
    
</body>
</html>

    