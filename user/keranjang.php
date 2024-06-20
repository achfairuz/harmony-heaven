<?php
session_start();
include '../koneksi.php';
$id_user = $_SESSION['id_user'];
?>

<form action="CRUD.php?stts=checkout" method="post">
    <div class="container mt-5">
        <h1 class="mb-4 text-mainColor">Keranjang Belanja</h1>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="px-4">Menu</th>
                                <th scope="col" class="px-4">Harga</th>
                                <th scope="col" class="px-4">Jumlah</th>
                                <th scope="col" class="px-4">Total</th>
                                <th scope="col" class="px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT keranjang.*, menu.* FROM keranjang JOIN menu ON menu.id_menu = keranjang.id_menu WHERE id_user = '$id_user'";
                            $a = $koneksi->query($sql);
                            ?>

                            <?php
                            $total_harga = 0;
                            while ($keranjang = $a->fetch_assoc()) {
                                $jumlah_harga = $keranjang['harga'] * $keranjang['quantity'];
                                $total_harga += $jumlah_harga;
                            ?>
                            <tr>
                                <input type="hidden" name="id_keranjang[]"
                                    value="<?php echo $keranjang['id_keranjang'] ?>">
                                <input type="hidden" name="id_menu[]" value="<?php echo $keranjang['id_menu'] ?>">

                                <td class="p-4"><?php echo $keranjang['nama_menu'] ?></td>
                                <td class="p-4 harga">Rp. <?php echo number_format($keranjang['harga'], 0, ',', '.') ?>
                                </td>
                                <td class="p-4">
                                    <input type="number" name="jumlah[]" class="form-control"
                                        value="<?php echo $keranjang['quantity']; ?>" min="1"
                                        onchange="hitungSubtotal(this);">
                                </td>
                                <td class="p-4 subtotal">Rp. <?php echo number_format($jumlah_harga, 0, ',', '.') ?>
                                </td>
                                <td class="p-4">
                                    <a href="CRUD.php?stts=deletekeranjang&id_keranjang=<?php echo $keranjang['id_keranjang'] ?>"
                                        class="btn btn-danger"><span data-feather="trash"></span></a>
                                </td>
                            </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-end my-3 ">
                <input type="hidden" id="input_total_harga" name="total_harga" value="<?php echo $total_harga ?>">
                <h4>Total Keseluruhan: <span id="total_harga_output" class="fw-bold text-mainColor">Rp.
                        <?php echo number_format($total_harga, 0, ',', '.') ?> </span> </h4>
                <button class="btn btn-primary mt-3">Checkout</button>
            </div>
        </div>
    </div>
</form>

<script>
// Fungsi untuk menghitung subtotal saat mengubah jumlah
function hitungSubtotal(input) {
    var row = input.closest('tr');
    var harga = parseFloat(row.querySelector('.harga').innerText.replace('Rp. ', '').replace('.', '').replace(',', ''));
    var jumlah = parseInt(input.value);
    var subtotal = harga * jumlah;
    row.querySelector('.subtotal').innerText = 'Rp. ' + subtotal.toLocaleString('id-ID');
    hitungTotal(); // Panggil fungsi hitungTotal setiap kali subtotal diupdate
}

// Fungsi untuk menghitung total keseluruhan
function hitungTotal() {
    var total = 0;
    var subtotals = document.querySelectorAll('.subtotal');
    subtotals.forEach(function(element) {
        total += parseFloat(element.innerText.replace('Rp. ', '').replace('.', '').replace(',', ''));
    });
    document.getElementById('total_harga_output').innerText = 'Rp. ' + total.toLocaleString('id-ID');
    document.getElementById('input_total_harga').value = total;
}

// Panggil fungsi hitungTotal saat halaman dimuat ulang
window.onload = hitungTotal;
</script>