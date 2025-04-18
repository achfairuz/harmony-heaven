<div class="row mt-4">
    <div class="col-md-12">
        <div class="d-flex flex-column flex-md-row justify-content-between">
            <h2 class="mb-3 mb-md-0">Manajemen Meja</h2>
            <button class="btn btn-primary btn-sm mt-md-0" data-bs-toggle="modal" data-bs-target="#addTable">Tambah
                Meja</button>
        </div>

        <div class="row mt-4">
            <?php
            include '../koneksi.php';
            $sql = "SELECT * FROM meja";
            $result = $koneksi->query($sql);
            while ($a = $result->fetch_assoc()) {
            ?>
                <div class="col-md-4">
                    <div class="card table-card mb-4" style="border: 1px solid #cc5340;">
                        <div class="card-body d-flex justify-content-between align_items-center">
                            <div class="meja mb-3">
                                <h3 class="card-title fw-bold"><?php echo $a['meja']; ?></h3>
                                <a href="<?php echo $a['link'] ?>" target="_blank">Link Meja</a>
                            </div>

                            <div class="button-control mt-auto text-center">
                                <button class="btn btn-warning mb-2" data-bs-toggle="modal"
                                    data-bs-target="#updateTable<?php echo $a['id_meja']; ?>">Edit</button>
                                <button class="btn btn-danger mb-2" data-bs-toggle="modal"
                                    data-bs-target="#deleteTable<?php echo $a['id_meja']; ?>">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update Table Modal -->
                <div class="modal fade mt-5 pt-5" id="updateTable<?php echo $a['id_meja']; ?>" tabindex="-1"
                    aria-labelledby="updateTableLabel<?php echo $a['id_meja']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="updateTableLabel<?php echo $a['id_meja']; ?>">Update
                                    Meja</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                                $id_meja = $a['id_meja'];
                                $sql = "SELECT * FROM meja WHERE id_meja = '$id_meja'";
                                $resultmeja = $koneksi->query($sql);
                                $meja = $resultmeja->fetch_assoc();
                                ?>
                                <form action="CRUD.php?stts=updatemeja" method="post">
                                    <div class="mb-3">
                                        <label for="tableName" class="form-label">Nama Meja</label>
                                        <input type="text" name="nama_meja" class="form-control" id="tableName"
                                            value="<?php echo $meja['meja']; ?>" required>
                                    </div>
                                    <input type="hidden" name="id_meja" value="<?php echo $id_meja; ?>">
                                    <div class="text-end"><button type="submit"
                                            class="btn btn-warning text-white">Update</button></div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Delete Table Modal -->
                <div class="modal fade mt-5 pt-5" id="deleteTable<?php echo $a['id_meja']; ?>" tabindex="-1"
                    aria-labelledby="deleteTabelLabel<?php echo $a['id_meja']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="updateTableLabel<?php echo $a['id_meja']; ?>">Delete
                                    Meja</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                                $id_meja = $a['id_meja'];
                                $sql = "SELECT * FROM meja WHERE id_meja = '$id_meja'";
                                $resultmeja = $koneksi->query($sql);
                                $meja = $resultmeja->fetch_assoc();
                                ?>
                                <form action="CRUD.php?stts=deletemeja" method="post" class="row">
                                    <input type="hidden" value="<?php echo $meja['id_meja'] ?>" name="id_meja">
                                    <div class="col-12 text-center mb-4">
                                        <h3>Apakah Anda ingin menghapus meja No. <span
                                                class="text-mainColor"><?php echo $meja['meja'] ?></span></h3>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-danger text-white">Delete</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Add Table Modal -->
<div class="modal fade mt-5 pt-5" id="addTable" tabindex="-1" aria-labelledby="addTableLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="addTableLabel">Tambah Meja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="CRUD.php?stts=insertmeja" method="post">
                    <div class="mb-3">
                        <label for="tableName" class="form-label">Nama Meja</label>
                        <input type="text" name="meja" class="form-control" id="tableName" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>