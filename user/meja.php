<?php
session_start();
include "../koneksi.php";



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Select Meja</title>

    <!-- FONT MONTSERRAT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

    <!-- BOOTSTRAP -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="../css/index.css" rel="stylesheet">
    <style>
        .img-container {
            max-width: 60%;
            border-radius: 40px;
        }

        @media (max-width: 576px) {
            .img-container {
                max-width: 100%;
            }

        }
    </style>
</head>

<body>

    <div class="container mt-5 d-flex align-items-center flex-column">
        <form action="CRUD.php?stts=table" method="post">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="title text-center mb-4">
                        <h1 class="fw-bold text-mainColor">Select a Table</h1>
                    </div>
                    <div class="text-center">
                        <img src="../img/meja.jpg" class="img-fluid img-container" alt="meja" draggable="false">
                    </div>
                </div>
            </div>



            <div class="row justify-content-center mt-3">

                <div class="col-10 col-md-4">


                    <select name="meja" class="form-select form-select-md  " id="meja">

                        <?php
                        include '../koneksi.php';

                        $id_meja = $_GET['id_meja'];
                        $sql = "SELECT * FROM meja where id_meja = '$id_meja'";
                        $result = $koneksi->query($sql);

                        if ($result->num_rows > 0) {
                            while ($meja = $result->fetch_assoc()) {
                                echo '<option class="text-center" value="' . $meja['id_meja'] . '" selected >' . $meja['meja'] . '</option>';
                            }
                        }
                        ?>

                    </select>

                </div>

            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary" id="confirmSelection">Confirm
                    Selection</button>
            </div>
        </form>
    </div>


</body>

</html>