<body>
    <div class="container mt-5">
        <h2 class="mb-4">Transaction List</h2>

        <!-- Nav Tabs -->
        <ul class="nav nav-tabs" id="transactionTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="proses-tab" data-bs-toggle="tab" data-bs-target="#proses"
                    type="button" role="tab" aria-controls="proses" aria-selected="true">Proses</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="berhasil-tab" data-bs-toggle="tab" data-bs-target="#berhasil" type="button"
                    role="tab" aria-controls="berhasil" aria-selected="false">Pembayaran Berhasil</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="batal-tab" data-bs-toggle="tab" data-bs-target="#batal" type="button"
                    role="tab" aria-controls="batal" aria-selected="false">Di Batalkan</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="transactionTabsContent">
            <!-- Proses Tab -->
            <div class="tab-pane fade show active" id="proses" role="tabpanel" aria-labelledby="proses-tab">
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date</th>
                                <th scope="col">Payment Method</th>
                                <th scope="col">money received</th>
                                <th scope="col">change money</th>
                                <th scope="col">proof of payment</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            session_start();
                            include 'koneksi.php';
                            $nomer = 1;
                            $id_user = $_SESSION['id_user'];
                            $query = "SELECT pesanan.*, DATE_FORMAT(pesanan.tanggal_pesanan, '%d-%M-%Y') as tanggal, pembayaran.* 
                                      FROM pesanan 
                                      JOIN pembayaran ON pembayaran.id_pesanan = pesanan.id_pesanan 
                                      WHERE pesanan.id_user = '$id_user' AND pesanan.status_pesanan = 'Proses'";
                            $result = $koneksi->query($query);
                            if ($result->num_rows > 0) {
                                while ($aa = $result->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $aa['id_pesanan'] ?></th>
                                        <td><?php echo $aa['tanggal'] ?></td>
                                        <td><?php echo htmlspecialchars($aa['metode_pembayaran']); ?></td>
                                        <td>Rp. <?php echo number_format($aa['uang_terima'], 0, ',', '.'); ?></td>
                                        <td>Rp. <?php echo number_format($aa['uang_kembali'], 0, ',', '.'); ?></td>
                                        <?php
                                        if ($aa['metode_pembayaran'] != 'Kasir') {
                                        ?>
                                            <td><a href="<?php echo htmlspecialchars($aa['bukti_pembayaran']); ?>"><img
                                                        src="<?php echo htmlspecialchars($aa['bukti_pembayaran']); ?>"
                                                        alt="proof of payment" class="img img-fluid"
                                                        style="max-width: 100px; max-height: 100px;"></a></td>
                                        <?php
                                        } else {
                                            echo " <td>Kosong</td>";
                                        }
                                        ?>
                                        <td>Rp. <?php echo number_format($aa['total_harga'], 0, ',', '.'); ?></td>

                                        <td><span class="badge bg-warning">Pending</span></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>Tidak ada data pesanan</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pembayaran Berhasil Tab -->
            <div class="tab-pane fade" id="berhasil" role="tabpanel" aria-labelledby="berhasil-tab">
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date</th>
                                <th scope="col">Payment Method</th>
                                <th scope="col">money received</th>
                                <th scope="col">change money</th>
                                <th scope="col">proof of payment</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nomerberhasil = 1;
                            $query_berhasil = "SELECT pesanan.*, DATE_FORMAT(pesanan.tanggal_pesanan, '%d-%M-%Y') as tanggal, pembayaran.* 
                                               FROM pesanan 
                                               JOIN pembayaran ON pembayaran.id_pesanan = pesanan.id_pesanan 
                                               WHERE pesanan.id_user = '$id_user' AND pesanan.status_pesanan = 'Sukses'";
                            $result_berhasil = $koneksi->query($query_berhasil);
                            if ($result_berhasil->num_rows > 0) {
                                while ($aa_berhasil = $result_berhasil->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $nomerberhasil++; ?></th>
                                        <td><?php echo $aa_berhasil['tanggal'] ?></td>
                                        <td><?php echo htmlspecialchars($aa_berhasil['metode_pembayaran']); ?></td>
                                        <td>Rp. <?php echo number_format($aa_berhasil['uang_terima'], 0, ',', '.'); ?></td>
                                        <td>Rp. <?php echo number_format($aa_berhasil['uang_kembali'], 0, ',', '.'); ?></td>
                                        <?php
                                        if ($aa_berhasil['metode_pembayaran'] != 'Kasir') {
                                        ?>
                                            <td><a href="<?php echo htmlspecialchars($aa_berhasil['bukti_pembayaran']); ?>"><img
                                                        src="<?php echo htmlspecialchars($aa_berhasil['bukti_pembayaran']); ?>"
                                                        alt="proof of payment" class="img img-fluid"
                                                        style="max-width: 100px; max-height: 100px;"></a></td>
                                        <?php
                                        } else {
                                            echo " <td>Kosong</td>";
                                        }
                                        ?>
                                        <td>Rp. <?php echo number_format($aa_berhasil['total_pembayaran'], 0, ',', '.'); ?></td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>Tidak ada data pesanan</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Batal Tab -->
            <div class="tab-pane fade" id="batal" role="tabpanel" aria-labelledby="batal-tab">
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date</th>
                                <th scope="col">Payment Method</th>
                                <th scope="col">money received</th>
                                <th scope="col">change money</th>
                                <th scope="col">proof of payment</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nomerbatal = 1;
                            $query_batal = "SELECT pesanan.*, DATE_FORMAT(pesanan.tanggal_pesanan, '%d-%M-%Y') as tanggal, pembayaran.* 
                                            FROM pesanan 
                                            JOIN pembayaran ON pembayaran.id_pesanan = pesanan.id_pesanan 
                                            WHERE pesanan.id_user = '$id_user' AND pesanan.status_pesanan = 'Dibatalkan'";
                            $result_batal = $koneksi->query($query_batal);
                            if ($result_batal->num_rows > 0) {
                                while ($aa_batal = $result_batal->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $nomerbatal++; ?></th>
                                        <td><?php echo $aa_batal['tanggal'] ?></td>
                                        <td><?php echo htmlspecialchars($aa_batal['metode_pembayaran']); ?></td>
                                        <td>Rp. <?php echo number_format($aa_batal['uang_terima'], 0, ',', '.'); ?></td>
                                        <td>Rp. <?php echo number_format($aa_batal['uang_kembali'], 0, ',', '.'); ?></td>
                                        <?php
                                        if ($aa_batal['metode_pembayaran'] != 'Kasir') {
                                        ?>
                                            <td><a href="<?php echo htmlspecialchars($aa_batal['bukti_pembayaran']); ?>"><img
                                                        src="<?php echo htmlspecialchars($aa_batal['bukti_pembayaran']); ?>"
                                                        alt="proof of payment" class="img img-fluid"
                                                        style="max-width: 100px; max-height: 100px;"></a></td>
                                        <?php
                                        } else {
                                            echo " <td>Kosong</td>";
                                        }
                                        ?>
                                        <td>Rp. <?php echo number_format($aa_batal['total_pembayaran'], 0, ',', '.'); ?></td>
                                        <td><span class="badge bg-danger">Cancelled</span></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>Tidak ada data pesanan</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</body>

</html>