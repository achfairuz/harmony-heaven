<div class="title d-flex justify-content-between align-items-center mt-4 px-4">
    <span data-feather="arrow-left" onclick="back()" style="cursor: pointer; font-size: 1.25rem;"></span>
    <div class="container position-relative z-index-1 p-2">
        <h2 class="text-mainColor fw-bold text-center" style="font-size: 1.5rem;">Pembayaran</h2>
    </div>
</div>

<div class="bg-light position-relative z-index-0 border rounded mt-3">
    <div class="container p-3 mt-4 mb-5">
        <div class="row justify-content-center p-3">
            <div class="col-md-8 p-3">
                <form action="CRUD.php?stts=pembayarankasir" method="post">
                    <?php
                    session_start();
                    include "koneksi.php";
                    $id_pesanan = $_GET['id_pesanan'];
                    $id_pembayaran = $_GET['id_pembayaran'];
                    $query = "SELECT pesanan.*, DATE_FORMAT(pesanan.tanggal_pesanan, '%d-%M-%Y') as tanggal, pembayaran.* 
                              FROM pesanan 
                              JOIN pembayaran ON pembayaran.id_pesanan = pesanan.id_pesanan 
                              WHERE pesanan.id_pesanan = '$id_pesanan' AND pembayaran.id_pembayaran = '$id_pembayaran'";

                    $result = $koneksi->query($query);

                    if ($result->num_rows > 0) {
                        while ($a = $result->fetch_assoc()) {
                    ?>
                            <input type="hidden" name="id_pesanan" value="<?php echo $a['id_pesanan'] ?>">
                            <input type="hidden" name="id_pembayaran" value="<?php echo $a['id_pembayaran'] ?>">

                            <div class="mb-3">
                                <label for="total_pembayaran" class="form-label" style="font-size: 1.2rem;">Total
                                    Pembayaran</label>
                                <input type="text" class="form-control" name="total_pembayaran" id="total_pembayaran"
                                    value="<?php echo $a['total_pembayaran'] ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="uang_terima" class="form-label" style="font-size: 1.2rem;">Uang Diterima</label>
                                <input type="number" name="uang_terima" class="form-control" id="uang_terima" required>
                            </div>

                            <input type="hidden" name="uang_kembalian" id="uang_kembalian">

                            <div class="mb-3 text-end">
                                <div class="row">
                                    <div class="col">
                                        <h5 style="font-size: 1.5rem;">Total Harga:</h5>
                                    </div>
                                    <div class="col text-end">
                                        <h5 style="font-size: 1.5rem;">Rp.
                                            <?php echo number_format($a['total_harga'], 0, ',', '.') ?></h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h5 style="font-size: 1.5rem;">Uang Diterima:</h5>
                                    </div>
                                    <div class="col text-end">
                                        <h5 id="uang_terima_display" style="font-size: 1.5rem;">Rp. </h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h5 style="font-size: 1.5rem;">Kembalian:</h5>
                                    </div>
                                    <div class="col text-end">
                                        <h5 id="uang_kembali_display" style="font-size: 1.5rem;">Rp. </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary" style="font-size: 1.2rem;">Bayar</button>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Data pesanan tidak ditemukan.</div>";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function checkPaymentMethod() {
        var selectedMethod = document.getElementById("metode_pembayaran").value;
        var uangTerimaInput = document.getElementById("uang_terima");
        var totalHarga = parseFloat(document.getElementById("total_pembayaran").value);

        if (selectedMethod === "Qris" || selectedMethod === "transfer bank BCA") {
            uangTerimaInput.value = totalHarga;
            uangTerimaInput.disabled = true;
            document.getElementById("uang_terima_display").innerText = 'Rp. ' + totalHarga.toLocaleString('id-ID');
            document.getElementById("uang_kembali_display").innerText = 'Rp. 0';
            document.getElementById("uang_kembalian").value = 0;
        } else {
            uangTerimaInput.value = "";
            uangTerimaInput.disabled = false;
            document.getElementById("uang_terima_display").innerText = 'Rp. ';
            document.getElementById("uang_kembali_display").innerText = 'Rp. ';
            document.getElementById("uang_kembalian").value = '';
        }
    }

    document.getElementById("uang_terima").addEventListener("input", function() {
        var totalHarga = parseFloat(document.getElementById("total_pembayaran").value);
        var uangTerima = parseFloat(this.value);
        var uangKembali = uangTerima - totalHarga;

        document.getElementById("uang_terima_display").innerText = uangTerima ? 'Rp. ' + uangTerima.toLocaleString(
            'id-ID') : 'Rp. ';
        document.getElementById("uang_kembali_display").innerText = uangKembali >= 0 ? 'Rp. ' + uangKembali
            .toLocaleString('id-ID') : 'Rp. ';
        document.getElementById("uang_kembalian").value = uangKembali >= 0 ? uangKembali : 0;
    });

    function back() {
        window.location.href = '?page=daftar_transaksi';
    }
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