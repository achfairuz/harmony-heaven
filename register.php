<?php
session_start();
include "koneksi.php";
$usernameerror = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['nama'] ?? "";
    $address = $_POST['alamat'] ?? "";
    $phonenumber = $_POST['phonenumber'] ?? "";
    $username = $_POST['username'] ?? "";
    $pass = $_POST['pass'] ?? "";
    $confirmPass = $_POST['confirmPass'] ?? "";

    $check_username_query = "SELECT * FROM user WHERE username = '$username'";
    $check_username_result = $koneksi->query($check_username_query);

    if ($check_username_result->num_rows > 0) {
        $usernameerror = "Username sudah ada. Silahkan pilih username lain.";
    } else {
        $sql = "INSERT INTO user (username, name, address, phonenumber, pass) VALUES ('$username','$name','$address','$phonenumber','$pass')";
        if ($koneksi->query($sql) === true) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $koneksi->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- FONT MONTSERRAT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- My Style -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Tambahkan gaya CSS khusus di sini */
        .register {
            max-width: 400px;
            /* Mengatur lebar maksimum form */
            margin: auto;
            /* Pusatkan form secara horizontal */
            padding: 20px;
            /* Berikan ruang di sekitar konten form */
        }

        /* Lebarkan elemen input agar sesuai */
        .form-group input {
            width: 100%;
            /* Gunakan lebar maksimum untuk input */
        }

        /* Tambahkan spasi bawah antara elemen form */
        .form-group {
            margin-bottom: 20px;
        }

        /* Atur lebar tombol */
        button[type="submit"] {
            width: 100%;
        }
    </style>
</head>


<body style="background: url('img/bg-login-register.jpg'); backdrop-filter: blur(4px);">

    <div class="register px-4" id="register">
        <div class="content loginColumns animated fadeInDown">
            <h1 class="text-center fw-bold text-light mb-4">Restaurant</h1>

            <form role="form" action="register.php" method="POST" onsubmit="return validateForm()">

                <div class="form-group">
                    <input type="text" class="form-control" name="nama" id="name" placeholder="Enter Name" required="">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="alamat" id="address" placeholder="Enter Address" required="">
                </div>

                <div class="form-group">
                    <input type="tel" class="form-control" name="phonenumber" id="phonenumber" placeholder="Enter Phone Number" required="">
                </div>


                <!-- di bagian form -->
                <div class="form-group">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username" required="">
                    <span class="text-danger"><?php echo $usernameerror; ?></span>
                </div>



                <div class="form-group">
                    <input type="password" class="form-control" name="pass" id="pass" placeholder="Password" required="">
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" name="confirmPass" id="confirmPass" placeholder="Confirm Password" required="">
                    <div id="passwordError" class="text-danger"></div>
                </div>

                <button type="submit" class="btn btn-mainColor block full-width m-b mt-4" name="register">Register</button>

                <p class="haveAccount text-center text-light mt-3">
                    <small>already have an account?</small>
                    <a href="login.php" style="text-decoration: none;"><small>Login</small></a>
                </p>
            </form>
        </div>
    </div>

    <script>
        // Validasi password
        function validateForm() {
            var password = document.getElementById("pass").value;
            var confirmPassword = document.getElementById("confirmPass").value;
            if (password != confirmPassword) {
                document.getElementById("passwordError").innerHTML = "Password and Confirm Password do not match.";
                return false; // Mencegah formulir disubmit
            }
            return true; // Lanjutkan submit jika password cocok
        }
    </script>

</body>

</html>