<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>


    <!-- FONT MONTSERRAT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="inspinia/css/bootstrap.min.css" rel="stylesheet">

    <!-- Inspinia -->
    <link href="inspinia/css/animate.css" rel="stylesheet">
    <link href="inspinia/css/style.css" rel="stylesheet">

    <!-- My Style -->
    <link rel="stylesheet" href="css/style.css">
</head>

<style>
    body {
        background: url('img/bg-login-register.jpg');
        backdrop-filter: blur(4px);
    }
</style>

<body>

    <div class="loginColumns animated fadeInDown " id="login">
        <div class="ibox-content">
            <div class="content">
                <h1 class="text-center ">Restaurant</h1>


                <form class="m-t" role="form" action="action.php?stts=login" method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username" required="">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="pass" placeholder="Password" required="">
                    </div>
                    <a href="#" class="forgot">
                        <small>Forgot password?</small>
                    </a>
                    <button type="submit" class="btn btn-mainColor block full-width m-b" name="login">Login</button>

                    <p class="haveAccount text-center text-light">
                        <small>Do not have an account?</small>
                        <a href="register.php"><small>Register</small></a>
                    </p>
                </form>
                <?php

                if (isset($_GET['error'])) {

                    echo "<script>alert('Username or password is incorrect');</script>";
                }
                ?>
            </div>

        </div>
    </div>
</body>

</html>