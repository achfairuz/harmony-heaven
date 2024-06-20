<?php
session_start();
include "../koneksi.php";

// Pastikan sesi pengguna telah diatur sebelum mengaksesnya
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];

    // Pastikan parameter id_pesanan telah diatur sebelum mengaksesnya
    if (isset($_GET['id_pesanan'])) {
        $id_pesanan = $_GET['id_pesanan'];

        // Gunakan prepared statement untuk mencegah SQL injection
        $sql = "SELECT pesanan.*, detail_pesanan.*, meja.meja 
                FROM pesanan 
                JOIN detail_pesanan ON detail_pesanan.id_pesanan = pesanan.id_pesanan 
                JOIN meja ON meja.id_meja = pesanan.id_meja 
                WHERE pesanan.id_pesanan = ?";

        // Persiapkan statement
        $stmt = $koneksi->prepare($sql);

        // Bind parameter id_pesanan
        $stmt->bind_param("s", $id_pesanan);

        // Eksekusi statement
        $stmt->execute();

        // Dapatkan hasil
        $result = $stmt->get_result();

        // Periksa apakah ada hasil yang ditemukan
        if ($result->num_rows > 0) {
            // Ambil baris hasil
            $a = $result->fetch_assoc();
        } else {
            // Jika tidak ada hasil yang ditemukan
            echo "Tidak ada pesanan dengan id tersebut.";
            exit;
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
                        <?php if (!empty($a['meja'])) : ?>
                            <tr>
                                <th>Pesanan</th>
                                <td class="fw-light mb-3"><?php echo htmlspecialchars($a['jenis_pesanan']); ?></td>
                            </tr>
                            <tr>
                                <th>No Meja</th>
                                <td class="fw-light mb-3"><?php echo htmlspecialchars($a['meja']); ?></td>
                            </tr>
                        <?php else : ?>
                            <tr>
                                <th>Pesanan</th>
                                <td class="fw-light mb-3"><?php echo htmlspecialchars($a['jenis_pesanan']); ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <th>Deskripsi</th>
                            <th>Jumlah</th>
                        </tr>
                        <?php
                        $subtotal = 0;
                        $id_menu = $a['id_menu'];
                        $sqlmenu = "SELECT * FROM menu WHERE id_menu = ?";
                        $stmtmenu = $koneksi->prepare($sqlmenu);
                        $stmtmenu->bind_param("s", $id_menu);
                        $stmtmenu->execute();
                        $resultmenu = $stmtmenu->get_result();
                        while ($aa = $resultmenu->fetch_assoc()) {
                            $subharga = $a['jumlah'] * $aa['harga'];
                            $subtotal += $subharga;
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($aa['nama_menu']); ?></td>
                                <td>Rp. <?php echo number_format($subharga, 0, ',', '.'); ?></td>
                            </tr>
                        <?php
                        }
                        $stmtmenu->close();
                        ?>
                        <tr class="subtotal-bg">
                            <td>Sub Total:</td>
                            <td>Rp. <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                        </tr>
                        <tr class="total-bg">
                            <td>TOTAL:</td>
                            <td>Rp. <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-4 d-flex mb-5">
            <div class="col-md-12">
                <h4>Metode Pembayaran</h4>
                <form action="CRUD.php?stts=payment" method="post">
                    <input type="hidden" name="id_pesanan" value="<?php echo $a['id_pesanan'] ?>">
                    <input type="hidden" name="total" value="<?php echo $subtotal ?>">


                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="bankTransfer" value="Kasir" checked>
                        <label class="form-check-label" for="bankTransfer">Bayar diKasir</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentMethod" id="bankTransfer" value="bankTransfer">
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