<?php
include "../koneksi.php";
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
ob_start();
if (isset($_GET['page'])) {
    $page = htmlentities($_GET['page']);
}

?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard</title>


    <!-- FONT MONTSERRAT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">


    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="../css/index.css" rel="stylesheet">



</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap  shadow d-flex align-item-center px-2">
        <h1 class="navbar-brand fw-bold" style="color: #ff6851; background-color: transparent;"><span
                class="fw-light">Hello,</span>
            <?php
            session_start();
            include "koneksi.php";

            if (isset($_SESSION['username'])) {

                $username = $_SESSION['username'];
                $query = "SELECT name FROM user WHERE username = '$username'";
                $result = $koneksi->query($query);


                if ($result) {

                    $row = $result->fetch_assoc();
                    $name = $row['name'];

                    echo "<span class='name'>$name</span>";
                } else {

                    echo "Error: " . $koneksi->error;
                }
            } else {
                // Jika pengguna belum login
                header("Location: ../login.php"); // Redirect ke halaman login jika belum login
                exit();
            }
            ?>
        </h1>

        <div class="div">
            <a href="?page=keranjang" class="me-3 text-light"><span data-feather="shopping-cart"></span></a>
            <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <button class="navbar-toggler  d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky ">
                    <ul class="nav flex-column mt-3">
                        <li class="nav-item">
                            <a class="nav-link  <?php if ($page == 'dashboard' || $page == '') echo 'active'; ?> "
                                aria-current="page" href="?page=dashboard">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($page == 'orders') echo 'active'; ?>" href="?page=orders">
                                <span data-feather="file"></span>
                                Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if ($page == 'transaksi') echo 'active'; ?>"
                                href="?page=transaksi">
                                <span data-feather="book"></span>
                                transaction list
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="settings"></span>
                                Setting
                            </a>
                        </li>


                        <li class="nav-item">
                            <button class="nav-link border-0 bg-transparent " id="logout">
                                <span data-feather="log-out"></span>
                                Logout
                            </button>
                        </li>
                    </ul>

                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 ">
                <?php
                $file = "$page.php";
                $cek = strlen('$page');
                if ($cel > 30 || !file_exists($file) || empty($page)) {
                    include("dashboard.php");
                } else {
                    include($file);
                }
                ?>
            </main>
        </div>
    </div>




    <script>
    document.getElementById('logout').addEventListener('click', function(event) {
        document.getElementById('popupLogout').style.display = 'block';
    });

    document.getElementById('cancel').addEventListener('click', function() {
        document.getElementById('popupLogout').style.display = 'none';
    });

    document.getElementById('confirm').addEventListener('click', function() {
        window.location.href = '../logout.php';
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
        integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous">
    </script>
    <script src="script.js"></script>
</body>

</html>