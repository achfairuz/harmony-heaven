<?php 
include "koneksi.php";

// Query to fetch all categories
$sql_categories = "SELECT DISTINCT kategori FROM menu";
$result_categories = $koneksi->query($sql_categories);

?>

<style>
.content {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    text-align: center;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.content img {
    width: 100%;
    height: 150px;
    /* Adjust this height as needed */
    object-fit: cover;
    border-radius: 8px;
}

.content h2 {
    font-size: 1.25rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.content p {
    font-size: 1rem;
    margin: 0.5rem 0;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.content .price {
    font-weight: bold;

}
</style>


<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light rounded mb-4 mt-3"
    style="background-image: url(img/comingsoon.jpg);">
    <div class="col-md-5 p-lg-5 mx-auto my-5 text-light">
        <h1 class="display-4 fw-normal">Bacon Sandwiches</h1>
        <p class="lead fw-normal" style="opacity: 0.5;">And an even wittier subheading to boot. Jumpstart your marketing
            efforts with
            this
            example based on Apple’s marketing pages.</p>
        <h1>Coming Soon</h1>
    </div>
    <div class="product-device shadow-sm d-none d-md-block"></div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
</div>



<div class="container-fluid">
    <?php
   
    while($row_category = $result_categories->fetch_assoc()) {
        $category = $row_category['kategori'];
   
        $sql_menu = "SELECT * FROM menu WHERE kategori = '$category'";
        $result_menu = $koneksi->query($sql_menu);

       
        echo '<div class="row">';
        echo '<div class="col-12 fw-bold "><h2>' . $category . '</h2></div>';

   
        while($row_menu = $result_menu->fetch_assoc()) {

            echo '<div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl-2 mb-4 p-2">';
            echo '<div class="content text-start">';
            echo '<img src="' . $row_menu["gambar"] . '" class="img img-fluid" alt="gambar_menu_' . $row_menu["id_menu"] . ' ">';
            echo '<h2 class="fw-bold mb-1 mt-2">' . $row_menu["nama_menu"] . '</h2>';
            echo '<p class="mt-1 mb-2">' . $row_menu["keterangan"] . '</p>';
            echo '<div class=""harga>';
            echo '<p class="mt-1 mb-2 text-end fw-bold text-mainColor">Rp. ' . $row_menu["harga"] . '</p>';
            echo '<button class="btn btn-mainColor col-12">Buy</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>'; 
    }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>