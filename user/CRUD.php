<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("location: ../login.php");
}
$id_user = $_SESSION['id_user'];

$status = $_GET['stts'];



if (isset($_GET['stts']) && $_GET['stts'] == 'table') {
    if (isset($_POST['meja']) && !empty($_POST['meja'])) {
        $meja = $_POST['meja'];
        $_SESSION['id_meja'] = $meja;


        if (!isset($_SESSION['username'])) {

            header('Location: ../index.html');
            exit();
        } else {

            header('Location: index.php');
            exit();
        }
    }
} elseif ($status == 'order') {
    $id_user = $_SESSION['id_user'];
    $id_menu = $_POST['id_menu'];

    // Check if the item is already in the cart
    $check_sql = "SELECT * FROM keranjang WHERE id_user = '$id_user' AND id_menu = '$id_menu'";
    $check_result = $koneksi->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Item already in cart, update the quantity
        $update_sql = "UPDATE keranjang SET quantity = quantity + 1 WHERE id_user = '$id_user' AND id_menu = '$id_menu'";
        $result = $koneksi->query($update_sql);
    } else {
        // Item not in cart, insert new row
        $insert_sql = "INSERT INTO keranjang(id_user, id_menu, quantity) VALUES ('$id_user', '$id_menu', 1)";
        $result = $koneksi->query($insert_sql);
    }

    if ($result === true) {
        echo "<script>window.location.href= 'index.php?page=orders'</script>";
    } else {
        echo "Menu Gagal Masuk Ke Keranjang";
    }
} elseif ($status == 'deletekeranjang') {
    $id_keranjang = $_GET['id_keranjang'];

    $sql = "DELETE from keranjang where id_keranjang = '$id_keranjang' ";
    $result = $koneksi->query($sql);
    if ($result === true) {
        echo "<script>
    window.location.href = 'index.php?page=keranjang'
</script>";
    } else {
        echo "Menu Gagal di hapus ";
    }
} elseif ($status == 'checkout') {

    $id_user = $_SESSION['id_user'];
    $id_meja = $_SESSION['id_meja'];

    $totalharga = $_POST['total_harga'];
    $id_menu = $_POST['id_menu'];
    $jumlah = $_POST['jumlah'];
    $id_keranjang = $_POST['id_keranjang'];

    if (!isset($id_meja)) {
        $sql = "INSERT INTO pesanan (id_user, total_harga, status_pesanan, jenis_pesanan) VALUES ('$id_user',  '$totalharga', 'Proses' , 'Takeaway')";
        $result = $koneksi->query($sql);
        if ($result === true) {
            $idpesanan = $koneksi->insert_id;

            foreach ($id_menu as $key => $menus) {
                $jumlahmenu = $jumlah[$key];
                $sqlmenu = "INSERT INTO detail_pesanan (id_pesanan, id_menu, jumlah) VALUES ('$idpesanan', '$menus', '$jumlahmenu')";
                $resultmenu = $koneksi->query($sqlmenu);

                if ($resultmenu !== true) {
                    echo "ERROR: Gagal menambahkan detail pesanan.";
                    exit; // Keluar dari skrip jika terjadi kesalahan
                }
            }

            foreach ($id_keranjang as $key => $keranjang) {
                $sqldeletekeranjang = "DELETE FROM keranjang WHERE id_keranjang = '$keranjang'";
                $resultdelete = $koneksi->query($sqldeletekeranjang);
            }
            // Menghapus keranjang


            // Redirect ke halaman pembayaran setelah berhasil checkout
            echo "<script>alert('Silakan lakukan pembayaran');</script>";
            echo "<script>window.location.href = 'index.php?page=pembayaran&id_pesanan=$idpesanan';</script>";
        } else {
            echo "ERROR: " . $koneksi->error;
        }
    } elseif (isset($id_meja)) {
        $sql = "INSERT INTO pesanan (id_user, id_meja, total_harga, status_pesanan, jenis_pesanan) VALUES ('$id_user', '$id_meja', '$totalharga', 'Proses' , 'Dine In')";
        $result = $koneksi->query($sql);

        if ($result === true) {
            $idpesanan = $koneksi->insert_id;

            foreach ($id_menu as $key => $menus) {
                $jumlahmenu = $jumlah[$key];
                $sqlmenu = "INSERT INTO detail_pesanan (id_pesanan, id_menu, jumlah) VALUES ('$idpesanan', '$menus', '$jumlahmenu')";
                $resultmenu = $koneksi->query($sqlmenu);

                if ($resultmenu !== true) {
                    echo "ERROR: Gagal menambahkan detail pesanan.";
                    exit; // Keluar dari skrip jika terjadi kesalahan
                }
            }

            foreach ($id_keranjang as $key => $keranjang) {
                $sqldeletekeranjang = "DELETE FROM keranjang WHERE id_keranjang = '$keranjang'";
                $resultdelete = $koneksi->query($sqldeletekeranjang);
            }
            // Menghapus keranjang


            // Redirect ke halaman pembayaran setelah berhasil checkout
            echo "<script>alert('Silakan lakukan pembayaran');</script>";
            echo "<script>window.location.href = 'index.php?page=pembayaran&id_pesanan=$idpesanan';</script>";
        } else {
            echo "ERROR: " . $koneksi->error;
        }
    }
} elseif ($status == 'payment') {
    $id_pesanan = $_POST['id_pesanan'];
    $total = $_POST['total'];
    $paymentMethod = $_POST['paymentMethod'];



    if ($paymentMethod == 'Kasir') {

        $sql = "INSERT INTO pembayaran(id_pesanan,id_user,metode_pembayaran,total_pembayaran)VALUES('$id_pesanan','$id_user','$paymentMethod','$total')";
        $result = $koneksi->query($sql);
        if ($result === TRUE) {
            echo "<script>alert('Silakan lakukan pembayaran di kasir');</script>";
            echo "<script>window.location.href = 'index.php?page=orders';</script>";

            exit();
        } else {
            echo "ERROR" . $koneksi->error;
        }
    } else {
        $sql = "INSERT INTO pembayaran(id_pesanan,id_user,metode_pembayaran,uang_terima,total_pembayaran)VALUES('$id_pesanan','$id_user','$paymentMethod','$total','$total')";
        $result = $koneksi->query($sql);
        $id_pembayaran = $koneksi->insert_id;
        echo "<script>alert('Silakan upload pembayaran ');</script>";
        echo "<script>window.location.href = 'index.php?page=uploadpembayaran&id_pembayaran=$id_pembayaran';</script>";
        exit();
    }
} elseif ($status == 'upload') {
    $id_pembayaran = $_POST['id_pembayaran'];

    $file_name = $_FILES['file_bukti']['name'];
    $file_tmp = $_FILES['file_bukti']['tmp_name'];
    $file_type = $_FILES['file_bukti']['type'];
    $file_size = $_FILES['file_bukti']['size'];

    $locate = "../img/pembayaran/";
    $target_file = $locate . basename($file_name);

    if (move_uploaded_file($file_tmp, $target_file)) {
        $sql = "UPDATE pembayaran SET bukti_pembayaran = '$target_file' WHERE id_pembayaran = $id_pembayaran";
        $result = $koneksi->query($sql);
        if ($result === true) {
            echo "<script>alert('Upload bukti pembayaran berhasil. Silahkan Menunggu Konfirmasi Pesanan!!!');</script>";
            echo "<script>window.location.href = 'index.php?page=orders';</script>";
            exit();
        } else {
            echo "<script>alert('Gagal menyimpan informasi pembayaran ke database.');</script>";
            echo "<script>window.location.href = 'index.php?page=uploadpembayaran&id_pembayaran=$id_pembayaran';</script>";

            exit();
        }
    } else {
        echo "<script>alert('Upload gagal.');</script>";
        echo "<script>window.location.href = 'index.php?page=uploadpembayaran&id_pembayaran=$id_pembayaran';</script>";
        exit();
    }
}
