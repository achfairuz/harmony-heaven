<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-expanded="false">
                <span data-feather="calendar"></span>
                This month
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#">This month</a></li>
                <li><a class="dropdown-item" href="#">Last month</a></li>
                <li><a class="dropdown-item" href="#">Last quarter</a></li>
                <li><a class="dropdown-item" href="#">Year</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Income -->
<div class="container-fluid mb-3">
    <div class="row">
        <div class="col-md-5 bg-mainColor text-white px-4 py-2 rounded" style="background-color: #ff6851;">
            <h1>Income</h1>
            <div class="content text-end">
                <?php
                include 'koneksi.php'; // Memasukkan file koneksi.php
                $sql = "SELECT SUM(total_pembayaran) as total FROM pembayaran WHERE status_pembayaran = 'Lunas'";
                $result = $koneksi->query($sql);
                if ($result) {
                    $row = $result->fetch_assoc();
                    $total = $row['total'];
                    if ($total === null) {
                        $total = 0;
                    }
                ?>
                    <h2>Rp. <?php echo number_format($total, 0, ',', '.'); ?></h2>
                <?php
                } else {
                    echo "<h2>Rp. 0</h2>"; // Menampilkan 0 jika tidak ada data
                }
                ?>
                <p style="opacity: 0.8;">Total income</p>
            </div>
        </div>
    </div>
</div>

<!-- Order -->
<div
    class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2>Order</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-expanded="false">
                <span data-feather="calendar"></span>
                Today
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">Yesterday</a></li>
                <li><a class="dropdown-item" href="#">Last 7 days</a></li>
                <li><a class="dropdown-item" href="#">This week</a></li>
                <li><a class="dropdown-item" href="#">Last week</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Nav Tabs -->
<ul class="nav nav-tabs" id="transactionTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="proses-tab" data-bs-toggle="tab" data-bs-target="#proses" type="button"
            role="tab" aria-controls="proses" aria-selected="true">Proses</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="berhasil-tab" data-bs-toggle="tab" data-bs-target="#berhasil" type="button"
            role="tab" aria-controls="berhasil" aria-selected="false">Pembayaran Berhasil</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="batal-tab" data-bs-toggle="tab" data-bs-target="#batal" type="button" role="tab"
            aria-controls="batal" aria-selected="false">Di Batalkan</button>
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
                        <th scope="col">ID pesanan</th>
                        <th scope="col">Nama Pembeli</th>

                        <th scope="col">Date</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Money Received</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Proof of Payment</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    session_start();
                    include 'koneksi.php';
                    $nomer = 1;

                    $query = "SELECT pesanan.*, DATE_FORMAT(pesanan.tanggal_pesanan, '%d-%M-%Y') as tanggal, pembayaran.* , user.name
                              FROM pesanan 
                              JOIN pembayaran ON pembayaran.id_pesanan = pesanan.id_pesanan
                              JOIN user ON user.id_user = pesanan.id_user

                              WHERE pembayaran.status_pembayaran = 'Pending'";
                    $result = $koneksi->query($query);
                    if ($result->num_rows > 0) {
                        while ($aa = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <th scope="row"><?php echo $nomer++; ?></th>
                                <td><?php echo $aa['id_pesanan'] ?></td>
                                <td><?php echo $aa['name'] ?></td>


                                <td><?php echo $aa['tanggal'] ?></td>
                                <td><?php echo htmlspecialchars($aa['metode_pembayaran']); ?></td>
                                <td>Rp. <?php echo number_format($aa['uang_terima'], 0, ',', '.'); ?></td>
                                <td>Rp. <?php echo number_format($aa['total_harga'], 0, ',', '.'); ?></td>
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
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td>
                                    <?php if ($aa['metode_pembayaran'] == 'Kasir') { ?>
                                        <a href="?page=pembayaran&id_pesanan=<?php echo $aa['id_pesanan']; ?>&id_pembayaran=<?php echo $aa['id_pembayaran']; ?>"
                                            class="btn btn-primary btn-sm">Payment</a>
                                    <?php } elseif ($aa['metode_pembayaran'] == 'bankTransfer') { ?>
                                        <a href="CRUD.php?stts=confirmpembayaran&id_pesanan=<?php echo $aa['id_pesanan']; ?>&id_pembayaran=<?php echo $aa['id_pembayaran']; ?>"
                                            class="btn btn-success btn-sm" style="font-size: 0.875rem;"
                                            onclick="return confirm('Apakah Anda yakin ingin mengonfirmasi pembayaran ini?')">Confirm</a>
                                        <a href="CRUD.php?stts=tolakpembayaran&id_pesanan=<?php echo htmlspecialchars($aa['id_pesanan']); ?>&id_pembayaran=<?php echo htmlspecialchars($aa['id_pembayaran']); ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin membatalkan pembayaran ini?')">Cancel</a>
                                    <?php } ?>
                                </td>
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
                        <th scope="col">Money Received</th>
                        <th scope="col">Change Money</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Proof of Payment</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomerberhasil = 1;
                    $query_berhasil = "SELECT pesanan.*, DATE_FORMAT(pesanan.tanggal_pesanan, '%d-%M-%Y') as tanggal, pembayaran.* 
                                       FROM pesanan 
                                       JOIN pembayaran ON pembayaran.id_pesanan = pesanan.id_pesanan 
                                       WHERE pembayaran.status_pembayaran = 'Lunas'";
                    $result_berhasil = $koneksi->query($query_berhasil);
                    if ($result_berhasil->num_rows > 0) {
                        while ($aa = $result_berhasil->fetch_assoc()) {
                    ?>
                            <tr>
                                <th scope="row"><?php echo $$nomerberhasil++; ?></th>
                                <td><?php echo $aa['tanggal'] ?></td>
                                <td><?php echo htmlspecialchars($aa['metode_pembayaran']); ?></td>
                                <td>Rp. <?php echo number_format($aa['uang_terima'], 0, ',', '.'); ?></td>
                                <td>Rp. <?php echo number_format($aa['uang_kembali'], 0, ',', '.'); ?></td>
                                <td>Rp. <?php echo number_format($aa['total_pembayaran'], 0, ',', '.'); ?></td>
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

                                <td><span class="badge bg-success">Success</span></td>
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

    <!-- Pembayaran Dibatalkan Tab -->
    <div class="tab-pane fade" id="batal" role="tabpanel" aria-labelledby="batal-tab">
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Money Received</th>
                        <th scope="col">Change Money</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Proof of Payment</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomorbatal = 1;
                    $query_batal = "SELECT pesanan.*, DATE_FORMAT(pesanan.tanggal_pesanan, '%d-%M-%Y') as tanggal, pembayaran.* 
                                    FROM pesanan 
                                    JOIN pembayaran ON pembayaran.id_pesanan = pesanan.id_pesanan 
                                    WHERE pembayaran.status_pembayaran = 'Gagal'";
                    $result_batal = $koneksi->query($query_batal);
                    if ($result_batal->num_rows > 0) {
                        while ($aa = $result_batal->fetch_assoc()) {
                    ?>
                            <tr>
                                <th scope="row"><?php echo $nomorbatal++; ?></th>
                                <td><?php echo $aa['tanggal'] ?></td>
                                <td><?php echo htmlspecialchars($aa['metode_pembayaran']); ?></td>
                                <td>Rp. <?php echo number_format($aa['uang_terima'], 0, ',', '.'); ?></td>
                                <td>Rp. <?php echo number_format($aa['uang_kembali'], 0, ',', '.'); ?></td>
                                <td>Rp. <?php echo number_format($aa['total_pembayaran'], 0, ',', '.'); ?></td>
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
                                ?><td><span class="badge bg-danger">Canceled</span></td>
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