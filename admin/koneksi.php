<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "restaurant";
$koneksi = mysqli_connect($host, $username, $password, $database);
if($koneksi){
    echo "";
}else{
    echo "Server Not Connected";
}
?>