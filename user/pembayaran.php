<?php
session_start();
include "../koneksi.php";

// Pastikan sesi pengguna telah diatur sebelum mengaksesnya
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];

    // Pastikan parameter id_pesanan telah diatur sebelum mengaksesnya
    if (isset($_GET['id_pesanan'])) {
        if (isset($_SESSION['id_meja'])) {
            $id_pesanan = $_GET['id_pesanan'];

            // Gunakan prepared statement untuk mencegah SQL injection
            $sql = "SELECT pesanan.*, detail_pesanan.*, meja.meja 
            FROM pesanan 
            JOIN detail_pesanan ON detail_pesanan.id_pesanan = pesanan.id_pesanan 
            JOIN meja ON meja.id_meja = pesanan.id_meja 
            WHERE pesanan.id_pesanan = ?";

            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("s", $id_pesanan);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $a = $result->fetch_assoc();
            } else {
                echo "Tidak ada pesanan dengan id tersebut.";
                exit;
            }
        } else {
            $id_pesanan = $_GET['id_pesanan'];

            // Gunakan prepared statement untuk mencegah SQL injection
            $sql = "SELECT pesanan.*, detail_pesanan.* 
            FROM pesanan 
            JOIN detail_pesanan ON detail_pesanan.id_pesanan = pesanan.id_pesanan 
            WHERE pesanan.id_pesanan = ?";

            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("s", $id_pesanan);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $a = $result->fetch_assoc();
            } else {
                echo "Tidak ada pesanan dengan id tersebut.";
                exit;
            }
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo "Parameter id_pesanan tidak diatur.";
        exit;
    }
} else {
    echo "Sesi pengguna tidak diatur.";
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link rel="stylesheet" href="path/to/your/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-mainColor">Pembayaran</h1>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th class="fw-light mb-3"><?php echo htmlspecialchars($a['id_pesanan']); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Pesanan</th>
                            <td class="fw-light mb-3"><?php echo htmlspecialchars($a['jenis_pesanan']); ?></td>
                        </tr>
                        <?php if (!empty($a['meja'])) : ?>
                            <tr>
                                <th>No Meja</th>
                                <td class="fw-light mb-3"><?php echo htmlspecialchars($a['meja']); ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <th>Deskripsi</th>
                            <th>Jumlah</th>
                        </tr>
                        <?php
                        $subtotal = 0;

                        $sqlmenu = "SELECT * FROM detail_pesanan 
            JOIN menu ON menu.id_menu = detail_pesanan.id_menu 
            WHERE id_pesanan = ?";
                        $stmtmenu = $koneksi->prepare($sqlmenu);
                        $stmtmenu->bind_param("s", $a['id_pesanan']);
                        $stmtmenu->execute();
                        $resultmenu = $stmtmenu->get_result();

                        while ($aa = $resultmenu->fetch_assoc()) {
                            $subharga = $aa['jumlah'] * $aa['harga'];
                            $subtotal += $subharga;
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($aa['nama_menu']); ?></td>
                                <td>
                                    <?php
                                    echo $aa['jumlah'] . ' x ' . number_format($aa['harga'], 0, ',', '.') . ' = ' . number_format($subharga, 0, ',', '.');
                                    ?>
                                </td>

                            </tr>
                        <?php
                        }


                        $stmtmenu->close();
                        ?>
                        <tr class="subtotal-bg">
                            <td>Sub Total:</td>
                            <td>Rp. <?php echo number_format($a['total_harga'], 0, ',', '.'); ?></td>
                        </tr>
                        <tr class="total-bg">
                            <td>TOTAL:</td>
                            <td>Rp. <?php echo number_format($a['total_harga'], 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-4 d-flex mb-5">
            <div class="col-md-12">
                <h4>Metode Pembayaran</h4>
                <form action="CRUD.php?stts=payment" method="post">
                    <input type="hidden" name="id_pesanan" value="<?php echo htmlspecialchars($a['id_pesanan']); ?>">
                    <input type="hidden" name="total" value="<?php echo htmlspecialchars($a['total_harga']); ?>">

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="kasir" value="Kasir"
                            checked>
                        <label class="form-check-label" for="kasir">Bayar di Kasir</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="bankTransfer"
                            value="bankTransfer">
                        <label class="form-check-label" for="bankTransfer">Bank Transfer BCA: 123456789 An
                            HarmonyHeaven</label>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Lakukan Pembayaran &gt;&gt;</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>