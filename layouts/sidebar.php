<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            width: 260px;
            height: 100vh;
            /* min-height: 100vh; */
            background-color: #FDFDFD;
            padding: 34px 20px;
            border-right: 1px solid #e0e0e0;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="sidebar">

            <h1>BidCar.</h1>
            <hr class="sidebar-divider" />

            <ul>
                <li><a href="/bidcar/model/admin/dashboard_admin.php"><img src="../../img/dashboard-icon.svg" alt="dashboard" />Dashboard</a></li>
                <li class="active"><a href="/bidcar/model/admin/data_barang.php"><img src="../../img/barang-icon.svg" alt="barang" />Data Barang</a></li>
                <li><a href="/bidcar/model/admin/data_lelang.php"><img src="../../img/lelang-icon.svg" alt="lelang" />Data Lelang</a></li>
                <li><a href="/bidcar/model/admin/data_petugas.php"><img src="../../img/admin-icon.svg" alt="admin" />Data Petugas</a></li>
                <li><a href="/bidcar/model/admin/data_pengguna.php"><img src="../../img/user-icon.svg" alt="user" />Data User</a></li>
            </ul>

            <hr class="sidebar-divider" />
            <form method="GET" action="../controllers/logout_controllers.php">
                <button type="button" name="logout" class="logout-btn">
                    <a href="/bidcar/controllers/logout_controllers.php"><img src="../../img/logout-icon.svg" alt="logout" />Logout</a>
                </button>
            </form>
        </div>

    </div>

</body>

</html>