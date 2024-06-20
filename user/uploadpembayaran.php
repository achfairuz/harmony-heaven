<style>
body {
    background-color: #f8f9fa;
}

.card {
    margin-top: 50px;
}

.card-header {
    background-color: #007bff;
    color: #fff;
}

.btn-primary {
    background-color: #007bff;
    border: none;
}

.btn-primary:hover {
    background-color: #0056b3;
}
</style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Upload Bukti Pembayaran</h4>
                    </div>
                    <div class="card-body">
                        <form action="CRUD.php?stts=upload" method="post" enctype="multipart/form-data">
                            <?php $id_pembayaran = $_GET['id_pembayaran'];


                            ?>
                            <div class="mb-3">
                                <label for="paymentProof" class="form-label">Upload Bukti Pembayaran</label>
                                <input class="form-control" name="file_bukti" type="file" id="paymentProof" required>
                                <input type="hidden" name="id_pembayaran" value="<?php echo $id_pembayaran ?>">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>