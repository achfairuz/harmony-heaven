<style>
.carousel-inner img {
    width: 100%;
    height: 300px;
    object-fit: cover;
}

.rewards {
    background-color: #fbeee6;
    padding: 40px 20px;
}

.reward-card {
    border-radius: 10px;
    padding: 20px;
    color: #fff;
    margin-bottom: 20px;
}

.reward-card h5 {
    margin-top: 0;
}

.reward-card .progress {
    height: 8px;
    border-radius: 5px;
}
</style>

<?php
session_start();
include '../koneksi.php';

$id_user = $_SESSION['id_user'];
$query = "SELECT SUM(total_pembayaran) as total FROM pembayaran WHERE id_user = '$id_user' AND status_pembayaran = 'Lunas'";
$a = $koneksi->query($query)->fetch_assoc();

$member_silver = 500000;
$member_gold = 700000;
$member_platinum = 1000000;

$total_payment = isset($a['total']) ? $a['total'] : 0;



// Saldo awal tiap member
$remaining_payment = $total_payment;
$result_silver = $member_silver;
$result_gold = $member_gold;
$result_platinum = $member_platinum;

// Kurangi dari silver terlebih dahulu
if ($remaining_payment >= $result_silver) {
    $remaining_payment -= $result_silver;
    $result_silver = 0;
} else {
    $result_silver -= $remaining_payment;
    $remaining_payment = 0;
}

// Lanjut ke gold jika masih ada sisa pembayaran
if ($remaining_payment > 0) {
    if ($remaining_payment >= $result_gold) {
        $remaining_payment -= $result_gold;
        $result_gold = 0;
    } else {
        $result_gold -= $remaining_payment;
        $remaining_payment = 0;
    }
}

// Lanjut ke platinum jika masih ada sisa pembayaran
if ($remaining_payment > 0) {
    if ($remaining_payment >= $result_platinum) {
        $remaining_payment -= $result_platinum;
        $result_platinum = 0;
    } else {
        $result_platinum -= $remaining_payment;
        $remaining_payment = 0;
    }
}

?>

<!-- Carousel -->
<div id="carouselExampleSlidesOnly" class="carousel slide mt-3" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="../img/courosel1.jpg" class="d-block w-100" style="border-radius: 20px;" alt="Restaurant"
                draggable="false">
        </div>
        <div class="carousel-item">
            <img src="../img/courosel2.jpg" class="d-block w-100" alt="Food" style="border-radius: 20px;"
                draggable="false">
        </div>
        <div class="carousel-item">
            <img src="../img/courosel3.jpg" class="d-block w-100" alt="Dining" style="border-radius: 20px;"
                draggable="false">
        </div>
    </div>
</div>

<!-- Rewards Section -->
<div class="rewards text-center mt-4">
    <h1 class="mb-4 text-mainColor">myRewards</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="reward-card text-start"
                    style="background-color: #D9EAD3; <?php echo $result_silver <= 0 ? 'opacity: 0.5;' : ''; ?>">
                    <div class="title mb-3 pb-2 border-bottom">
                        <h2 class="fw-bold">+Rp. <?php echo number_format($result_silver, 0, ',', '.') ?></h2>
                        <p>Lagi untuk naik ke level Gold</p>
                    </div>

                    <div class="keterangan">
                        <div class="detail">
                            <h6>Detail</h6>
                            <ul class="list-unstyled">
                                <li>Diskon 10% untuk setiap transaksi di restoran.</li>
                                <li>Diskon tambahan 5% untuk setiap transaksi pada hari ulang tahun anggota.</li>
                            </ul>
                        </div>
                        <div class="syarat">
                            <h6>Syarat dan Ketentuan :</h6>
                            <ul class="list-unstyled">
                                <li>Diskon hanya berlaku untuk anggota yang memiliki status silver.</li>
                                <li>Diskon tidak dapat digabungkan dengan penawaran atau promosi lainnya.</li>
                                <li>Untuk mendapatkan diskon tambahan pada hari ulang tahun, anggota harus menunjukkan
                                    identifikasi diri yang valid.</li>
                                <li>Manajemen berhak untuk mengubah atau membatalkan diskon tanpa pemberitahuan
                                    sebelumnya.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="reward-card bg-warning text-start">
                    <div class="title mb-3 pb-2 border-bottom">
                        <h2 class="fw-bold">+Rp. <?php echo number_format($result_gold, 0, ',', '.') ?></h2>
                        <p>Lagi untuk naik ke level Platinum</p>
                    </div>

                    <div class="keterangan">
                        <div class="detail">
                            <h6>Detail</h6>
                            <ul class="list-unstyled">
                                <li>Diskon 10% untuk setiap transaksi di restoran.</li>
                                <li>Diskon tambahan 5% untuk setiap transaksi pada hari ulang tahun anggota.</li>
                            </ul>
                        </div>
                        <div class="syarat">
                            <h6>Syarat dan Ketentuan :</h6>
                            <ul class="list-unstyled">
                                <li>Diskon hanya berlaku untuk anggota yang memiliki status gold.</li>
                                <li>Diskon tidak dapat digabungkan dengan penawaran atau promosi lainnya.</li>
                                <li>Untuk mendapatkan diskon tambahan pada hari ulang tahun, anggota harus menunjukkan
                                    identifikasi diri yang valid.</li>
                                <li>Manajemen berhak untuk mengubah atau membatalkan diskon tanpa pemberitahuan
                                    sebelumnya.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="reward-card bg-warning text-start">
                    <div class="title mb-3 pb-2 border-bottom">
                        <h2 class="fw-bold">+Rp. <?php if ($result_gold <= 0) {
                                                        echo number_format($result_platinum, 0, ',', '.');
                                                    } else {
                                                        echo number_format($member_platinum, 0, ',', '.');
                                                    }  ?></h2>
                        <p>Mencapai Batas Silahkan Tunggu 30 Hari untuk Merestart dari awal</p>
                    </div>

                    <div class="keterangan">
                        <div class="detail">
                            <h6>Detail</h6>
                            <ul class="list-unstyled">
                                <li>Diskon 10% untuk setiap transaksi di restoran.</li>
                                <li>Diskon tambahan 5% untuk setiap transaksi pada hari ulang tahun anggota.</li>
                            </ul>
                        </div>
                        <div class="syarat">
                            <h6>Syarat dan Ketentuan :</h6>
                            <ul class="list-unstyled">
                                <li>Diskon hanya berlaku untuk anggota yang memiliki status platinum.</li>
                                <li>Diskon tidak dapat digabungkan dengan penawaran atau promosi lainnya.</li>
                                <li>Untuk mendapatkan diskon tambahan pada hari ulang tahun, anggota harus menunjukkan
                                    identifikasi diri yang valid.</li>
                                <li>Manajemen berhak untuk mengubah atau membatalkan diskon tanpa pemberitahuan
                                    sebelumnya.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>