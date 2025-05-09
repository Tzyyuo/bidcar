<?php

include '../../../config/koneksi.php';

if (isset($_GET['id_petugas'])) {
    $id_petugas = $_GET['id_petugas'];

    $stmt = $koneksi->prepare("SELECT * FROM tb_petugas WHERE id_petugas = ?");
    $stmt->bind_param("i", $id_petugas); 
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
}

if (isset($_POST['submit'])) {
    $nama = $_POST['nama_petugas'];
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $level = $_POST['level'];

  
    $stmt = $koneksi->prepare("UPDATE tb_petugas SET nama_petugas = ?, username = ?, password = ?, id_level = ? WHERE id_petugas = ?");
    $stmt->bind_param("ssssi", $nama, $username, $password, $level, $id_petugas);

    if ($stmt->execute()) {
        echo "<script>
                alert('Data berhasil diupdate');
                window.location.href = '/bidcar/model/admin/data_petugas.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal update data');
              </script>";
    }

    $stmt->close();
}
?>


<?php include '../../../layouts/sidebar.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Petugas - Admin</title>
</head>
<body>

    <div class="hal-judul">
        <img src="../../img/bidcar.png">
        <h1>Edit Petugas</h1>
    </div>

    <div class="form-edit">
        <form method="POST" action="">
            <label for="nama_petugas">Nama Petugas</label>
            <input type="text" id="nama_petugas" name="nama_petugas" value="<?php echo isset($data['nama_petugas']) ? $data['nama_petugas'] : ''; ?>" required>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>" required>

            <label for="level">Level</label>
            <input type="text" id="level" name="level" value="<?php echo isset($data['id_level']) ? $data['id_level'] : ''; ?>" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="<?php echo isset($data['password']) ? $data['password'] : ''; ?>" required>

            <button type="submit" name="submit">Selesai</button>
        </form>
</div>
