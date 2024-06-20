<?php
include "koneksi.php";
$status = $_GET["stts"];

if ($status == 'login') {
    $username = $_POST['username'];
    $pass = $_POST['pass'];

    // Menggunakan prepared statement untuk mencegah SQL Injection
    $stmt = $koneksi->prepare("SELECT * FROM user WHERE username = ? AND pass = ?");
    $stmt->bind_param("ss", $username, $pass);
    $stmt->execute();
    $cek = $stmt->get_result();



    if ($cek->num_rows > 0) {
        $user = $cek->fetch_assoc();
        session_start();
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: admin/index.php");
            exit();
        } else {

            header("Location: user/index.php");
            exit();
        }
    } else {
        header("Location: login.php?error=1");
        exit();
    }
}
