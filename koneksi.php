<?php
$host = "localhost";
$username = "root";
$password = "";  // Gunakan password yang sama
$database = "restaurant";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
