<?php
include "koneksi.php";

$status = isset($_GET["stts"]) ? $_GET["stts"] : '';
$id_menu = isset($_GET['id_menu']) ? $_GET['id_menu'] : '';

if ($status == 'insertmenu') {
    $menu_name = $_POST['menu_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $file_name = $_FILES['menu_image']['name'];
    $file_tmp = $_FILES['menu_image']['tmp_name'];
    $file_type = $_FILES['menu_image']['type'];
    $file_error = $_FILES['menu_image']['error'];

    $file_name = preg_replace('/\s+/', '_', $file_name);

    $file_location = '../img/uploads/' . $file_name;

    if (move_uploaded_file($file_tmp, $file_location)) {
        $sql = "INSERT INTO menu (nama_menu, gambar, keterangan, harga, kategori) VALUES ('$menu_name', '$file_location', '$description', '$price', '$category')";

        if ($koneksi->query($sql) === TRUE) {
            echo "
            <script>
            alert('Data Berhasil di Masukkan!');
            document.location.href = 'index.php?page=product';
            </script>
            ";
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    } else {
        echo
        " <script>
            alert('Gagal Upload File!');
            document.location.href = 'index.php?page=product';
            </script>";
    }

    // DELETE
} elseif ($status == 'deletemenu' && !empty($id_menu)) {
    $sql = "DELETE FROM menu WHERE id_menu='$id_menu'";

    if ($koneksi->query($sql) === TRUE) {
        echo "
        <script>
        alert('Data Berhasil di Hapus!');
        document.location.href = 'index.php?page=product';
        </script>
        ";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }

    // UPDATE
} elseif ($_GET['stts'] == 'updatemenu') {
    $id_menu = $_GET['id_menu'];
    $menu_name = $_POST['menu_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $existing_image = $_POST['existing_image']; // Gambar yang ada

    // Menangani unggahan file jika gambar baru disediakan
    if ($_FILES['menu_image']['name']) {
        $menu_image = $_FILES['menu_image']['name'];
        $target_dir = "../img/uploads/";
        $target_file = $target_dir . basename($menu_image);

        // Memastikan direktori unggahan ada dan dapat ditulisi
        if (!is_dir($target_dir) || !is_writable($target_dir)) {
            die("Direktori unggahan tidak ada atau tidak dapat ditulisi");
        }

        if (move_uploaded_file($_FILES['menu_image']['tmp_name'], $target_file)) {
            $menu_image = $target_file;
        } else {
            die("Gagal mengunggah file.");
        }
    } else {
        // Menyimpan gambar yang ada jika tidak ada gambar baru diunggah
        $menu_image = $existing_image;
    }

    $sql = "UPDATE menu SET nama_menu='$menu_name', keterangan='$description', harga='$price', kategori='$category', gambar='$menu_image' WHERE id_menu='$id_menu'";
    if ($koneksi->query($sql) === TRUE) {
        echo " <script>
            alert('Data Berhasil di Update!');
            document.location.href = 'index.php?page=product';
            </script>
            ";
        exit();
    } else {
        echo "Error updating record: " . $koneksi->error;
    }
} elseif ($status == 'insertmeja') {
    $meja = $_POST['meja'];

    $sql = "INSERT INTO meja(meja)VALUES('$meja')";
    $result = $koneksi->query($sql);

    if ($result === true) {
        $id_meja = $koneksi->insert_id;
        $sqlupdate = "UPDATE meja SET link = 'http://localhost:8080/user/meja.php?id_meja=" . $id_meja . "' WHERE id_meja = '" . $id_meja . "'";
        $resultupdate = $koneksi->query($sqlupdate);
        echo " <script>
            alert('Meja Berhasil di tambahkan!');
            document.location.href = 'index.php?page=meja';
            </script>
            ";
        exit();
    } else {
        echo "ERROR" . $koneksi->error;
    }
} elseif (isset($_GET['stts']) && isset($_GET['id_pesanan']) && isset($_GET['id_pembayaran'])) {
    $status = $_GET['stts'];
    $id_pembayaran = $_GET['id_pembayaran'];
    $id_pesanan = $_GET['id_pesanan'];

    if ($status == 'confirmpembayaran') {
        $sql = "UPDATE pembayaran SET status_pembayaran = 'Lunas' WHERE id_pembayaran = '$id_pembayaran'";
        $result = $koneksi->query($sql);

        if ($result === true) {
            $sql_pesanan = "UPDATE pesanan SET status_pesanan = 'Sukses' WHERE id_pesanan = '$id_pesanan'";
            $result_pesanan = $koneksi->query($sql_pesanan);

            if ($result_pesanan === true) {
                echo "
                <script>
                    alert('Status Berhasil di Ubah!');
                    document.location.href = 'index.php?page=dashboard';
                </script>
                ";
                exit();
            } else {
                echo "ERROR: " . $koneksi->error;
            }
        } else {
            echo "ERROR: " . $koneksi->error;
        }
    }
}
if (isset($_GET['stts'], $_GET['id_pesanan'], $_GET['id_pembayaran'])) {
    $status = $_GET['stts'];
    $id_pembayaran = $_GET['id_pembayaran'];
    $id_pesanan = $_GET['id_pesanan'];

    if ($status === 'tolakpembayaran') {
        // Update status pembayaran menjadi 'Gagal'
        $sql = "UPDATE pembayaran SET status_pembayaran = 'Gagal' WHERE id_pembayaran = '$id_pembayaran'";
        $result_pembayaran = $koneksi->query($sql);

        if ($result_pembayaran) {
            // Update status pesanan menjadi 'Dibatalkan'
            $sql_pesanan = "UPDATE pesanan SET status_pesanan = 'Dibatalkan' WHERE id_pesanan = '$id_pesanan'";
            $result_pesanan = $koneksi->query($sql_pesanan);

            if ($result_pesanan) {
                echo "
                <script>
                    alert('Status Berhasil di Ubah!');
                    window.location.href = 'index.php?page=dashboard';
                </script>";
                exit();
            } else {
                echo "ERROR: " . $koneksi->error;
            }
        } else {
            echo "ERROR: " . $koneksi->error;
        }
    }
} elseif ($status == 'pembayarankasir') {
    $uang_terima = $_POST['uang_terima'];
    $uang_kembali = $_POST['uang_kembalian'];
    $id_pesanan = $_POST['id_pesanan'];
    $id_pembayaran = $_POST['id_pembayaran'];


    $query = "UPDATE pembayaran SET uang_terima = '$uang_terima' , uang_kembali='$uang_kembali', status_pembayaran = 'Lunas' WHERE id_pembayaran = '$id_pembayaran' AND id_pesanan = '$id_pesanan'";
    $result = $koneksi->query($query);
    if ($result  === true) {
        $sql_pesanan = "UPDATE pesanan SET status_pesanan = 'Sukses' WHERE id_pesanan = '$id_pesanan'";
        $result_pesanan = $koneksi->query($sql_pesanan);

        if ($result_pesanan === true) {
            echo "
                <script>
                    alert('Pembayaran Berhasil!!!');
                    document.location.href = 'index.php?page=dashboard';
                </script>
                ";
            exit();
        } else {
            echo "ERROR: " . $koneksi->error;
        }
    } else {
        echo "ERROR: " . $koneksi->error;
    }
} elseif ($status == 'tambahStok') {
    $id_menu = $_POST['id_menu'];
    $stok = $_POST['jumlah_stok'];
    $stoksaatini = $_POST['stok_saat_ini'];

    $updatestok = $stoksaatini + $stok;
    $sql = "UPDATE menu SET stok = '$updatestok' where id_menu = '$id_menu' ";
    if ($koneksi->query($sql) === true) {
        echo "<script>alert('Berhasil Menambahkan Stok !!!'); window.location.href = 'index.php?page=product';</script>";
    } else {
        echo "<script>alert('Gagal)</script>";
    }
} elseif ($status == 'deletemeja') {
    $id_meja = $_POST['id_meja'];


    $sql = "DELETE FROM meja where id_meja = $id_meja ";
    if ($koneksi->query($sql) === true) {
        echo "<script>alert('Berhasil Menghapus Meja !!!'); window.location.href = 'index.php?page=meja';</script>";
    } else {
        echo "<script>alert('Gagal)</script>";
    }
} elseif ($status == 'updatemeja') {
    $id_meja = $_POST['id_meja'];
    $nama_meja = $_POST['nama_meja'];


    $sql = "UPDATE meja SET meja = $nama_meja WHERE id_meja = $id_meja";
    if ($koneksi->query($sql) === true) {
        echo "<script>alert('Berhasil Update Meja !!!'); window.location.href = 'index.php?page=meja';</script>";
    } else {
        echo "<script>alert('Gagal)</script>";
    }
}
