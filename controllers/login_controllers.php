<?php
session_start();

include '../config/koneksi.php';  

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM tb_petugas WHERE username = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            
            $_SESSION['id_petugas'] = $user['id_petugas'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['level'] = $user['id_level'];  

            if ($user['id_level'] == 1) {
                header("Location: /bidcar/model/admin/dashboard_admin.php");
            } else if ($user['id_level'] == 2) {
                header("Location: /bidcar/model/petugas/dashboard_petugas.php");
                exit;
            }
        } else {
             $_SESSION['flash'] = [
                'icon' => 'error',
                'title' => 'Password Salah!',
                'text' => 'Silakan coba lagi.'
            ];
            header("Location: /bidcar/views/login.php");
            exit;
        }
    } else {
        
        $query = "SELECT * FROM tb_masyarakat WHERE username = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
               
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                
                header("Location: /bidcar/model/masyarakat/laman_masyarakat.php");
            } else {

                  $_SESSION['flash'] = [
                    'icon' => 'error',
                    'title' => 'Password Salah!',
                    'text' => 'Silakan coba lagi.'
                ];
                header("Location: /bidcar/views/login.php");
                exit;
            }
        } else {
            $_SESSION['flash'] = [
                'icon' => 'error', 
                
                'title' => 'Username Tidak Ditemukan!',
                'text' => 'Coba lagi.'
            ];
            header("Location: /bidcar/views/login.php");
            exit;
        }
    }
}
?>
