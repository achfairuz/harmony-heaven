<style>
.table-menu th,
.table-menu td {
    vertical-align: middle;
    /* Posisi teks vertikal tengah */
}

.table-menu img {
    max-width: 100%;
    height: auto;
}

.table-menu .btn {
    padding: 0.5rem 1rem;
    /* Padding tombol */
    margin-right: 5px;
    /* Jarak antar tombol */
}
</style>
<!-- Product -->

<div
    class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-2">
    <h2 class="mb-0 fw-bold text-mainColor">Product</h2>

    <div class="input-group mx-md-3 mb-2">
        <input id="searchInput" class="form-control me-2 " type="text" placeholder="Search" aria-label="Search">
        <button id="searchButton" class="btn btn-mainColor btn-outline-secondary" type="button" style="z-index: 0;">
            <span data-feather="search"></span>
        </button>
    </div>


    <div class="ms-auto">
        <div class="btn-toolbar mb-2 mb-md-0 d-flex justify-content-end">

            <button type="button" class="btn btn-mainColor btn-outline-secondary me-2 mb-1" id="addMenuBtn">
                <span data-feather="plus"></span>
                Add
            </button>
        </div>
    </div>
</div>

<!-- POP UP ADDMENU -->
<div id="popupMenu" class="popup">
    <div class="popup-content rounded">
        <div class="title d-flex justify-content-between align-items-center ">
            <h2 class="text-mainColor fw-bold">Add Menu</h2>
            <span class="close">&times;</span>
        </div>

        <form role="form" action="CRUD.php?stts=insertmenu" method="POST" enctype="multipart/form-data">
            <div class="mb-2 row">
                <label for="menu_name" class="col-sm-2 col-form-label">Menu Name :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="menu_name" id="menu_name" required="">
                </div>
            </div>

            <div class="mb-2 row">
                <label for="menuImage" class="col-sm-2 col-form-label">Menu Image :</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" id="menuImage" name="menu_image">
                </div>
            </div>

            <div class="mb-2 row">
                <label for="description" class="col-sm-2 col-form-label">Description :</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description" id="description" rows="4" cols="50"></textarea>
                </div>
            </div>

            <div class="mb-2 row">
                <label for="price" class="col-sm-2 col-form-label">Price :</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="price" name="price" required="">
                </div>
            </div>

            <div class="mb-2 row">
                <label for="category" class="col-sm-2 col-form-label">Category :</label>
                <div class="col-sm-10">
                    <select name="category" id="category" class="form-control">
                        <option value="Africa">Africa</option>
                        <option value="Asia">Asia</option>
                        <option value="Europe">Europe</option>
                        <option value="Australia">Australia</option>
                        <option value="America">America</option>
                    </select>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-mainColor mt-3" id="addMenuItem" type="submit">Add Menu</button>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive text-center">
    <table class="table table-striped table-hover table-menu">
        <thead>
            <tr>
                <th style="display: none;"></th>
                <th scope="col">NO</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Category</th>
                <th scope="col">Stock</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "koneksi.php";
            $no = 1;
            $query = "SELECT * FROM menu";
            $result = $koneksi->query($query);
            while ($row = $result->fetch_assoc()) {
                $id_menu = $row['id_menu'];
            ?>
            <tr>
                <td style="display: none;"><?php echo $id_menu ?></td>
                <td><?php echo $no++; ?></td>
                <td><?php echo $row['nama_menu']; ?></td>
                <td><img src="<?php echo $row['gambar']; ?>" class="img-fluid" style="max-width: 150px; height: auto;"
                        alt="menu"></td>
                <td><?php echo $row['keterangan']; ?></td>
                <td><?php echo $row['harga']; ?></td>
                <td><?php echo $row['kategori']; ?></td>
                <td><?php echo $row['stok']; ?></td>
                <td>
                    <button class="btn btn-sm btn-success btn-tambah-stok mb-1" data-id="<?php echo $id_menu; ?>"
                        data-stok="<?php echo $row['stok']; ?>">Tambah Stok</button>

                    <button class="btn btn-sm btn-primary btn-update-menu mb-1" data-id="<?php echo $id_menu; ?>"
                        data-name="<?php echo $row['nama_menu']; ?>" data-image="<?php echo $row['gambar']; ?>"
                        data-description="<?php echo $row['keterangan']; ?>" data-price="<?php echo $row['harga']; ?>"
                        data-category="<?php echo $row['kategori']; ?>">Update</button>

                    <button class="btn btn-sm btn-danger btn-delete-menu mb-1"
                        data-id=" <?php echo $id_menu; ?>">Delete</button>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>


<!-- POPUP TAMBAH STOK -->
<div id="popupTambahStok" class="popup" style="display: none;">
    <div class="popup-content rounded">
        <div class="title d-flex justify-content-between align-items-center">
            <h2 class="text-mainColor fw-bold">Tambah Stok</h2>
            <h1 id="close-btn-stok">&times;</h1>
        </div>

        <form role="form" id="tambahStokForm" method="POST" action="CRUD.php?stts=tambahStok">


            <input type="hidden" name="id_menu" id="tambah_stok_id_menu">
            <div class="mb-2 row">
                <label for="tambah_stok_jumlah" class="col-sm-3 col-form-label">Jumlah Stok</label>
                <div class="col-sm-9">
                    <input type="hidden" class="form-control" name="stok_saat_ini" id="stok_saat_ini">
                    <input type="number" class="form-control" name="jumlah_stok" id="tambah_stok_jumlah" required>
                </div>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-mainColor mt-3" type="submit">Tambah Stok</button>
            </div>
        </form>
    </div>
</div>

<!-- POP UP UPDATE -->
<div id="popupUpdate" class="popup">
    <div class="popup-content rounded">
        <div class="title d-flex justify-content-between align-items-center">
            <h2 class="text-mainColor fw-bold">Update Menu</h2>
            <span class="close">&times;</span>
        </div>

        <form role="form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="existing_image" id="existing_image">

            <div class="mb-2 row">
                <label for="menu_name" class="col-sm-2 col-form-label">Menu Name :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="menu_name" id="menu_name" required>
                </div>
            </div>

            <div class="mb-2 row">
                <label for="menuImage" class="col-sm-2 col-form-label">Menu Image :</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" id="menuImage" name="menu_image">
                </div>
            </div>

            <div class="mb-2 row">
                <label for="description" class="col-sm-2 col-form-label">Description :</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description" id="description" rows="4" cols="50"></textarea>
                </div>
            </div>

            <div class="mb-2 row">
                <label for="price" class="col-sm-2 col-form-label">Price :</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>
            </div>

            <div class="mb-2 row">
                <label for="category" class="col-sm-2 col-form-label">Category :</label>
                <div class="col-sm-10">
                    <select name="category" id="category" class="form-control">
                        <option value="Africa">Africa</option>
                        <option value="Asia">Asia</option>
                        <option value="Europe">Europe</option>
                        <option value="Australia">Australia</option>
                        <option value="America">America</option>
                    </select>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-mainColor mt-3" type="submit">Update Menu</button>
            </div>
        </form>
    </div>
</div>



<!-- POP up delete -->
<div id="popupDelete" class="popup popupdelete">
    <div class="popup-content pop-up rounded">
        <div class="title text-center">
            <span data-feather="alert-triangle" class="mb-2" style="color: red; width: 48px; height: 48px;"></span>
            <h4 class="text-danger fw-bold text-center">Are you sure you want to delete this menu item?</h4>
        </div>
        <div class="d-flex justify-content-end mt-3 d-grid gap-2 d-flex justify-content-center">
            <button class="btn btn-danger mt-3" id="confirmDelete">Delete</button>
            <button class="btn btn-secondary mt-3" id="cancelDelete">Cancel</button>

        </div>
    </div>
</div>


<!-- JAVASCRIPT -->
<script>
// Button Addmenu
document.getElementById("addMenuBtn").addEventListener("click", function() {
    document.getElementById("popupMenu").style.display = "block";
});

document.querySelectorAll(".close").forEach(closeButton => {
    closeButton.addEventListener("click", function() {
        this.closest(".popup").style.display = "none";
    });
});

// Update
document.querySelectorAll(".btn-update-menu").forEach(button => {
    button.addEventListener("click", function() {
        const id = this.closest('tr').querySelector('td[id="id_menu"]').textContent;
        const name = this.closest('tr').querySelector('td:nth-child(3)').textContent;
        const image = this.closest('tr').querySelector('img').src;
        const description = this.closest('tr').querySelector('td:nth-child(5)').textContent;
        const price = this.closest('tr').querySelector('td:nth-child(6)').textContent;
        const category = this.closest('tr').querySelector('td:nth-child(7)').textContent;

        const updatePopup = document.getElementById("popupUpdate");
        updatePopup.style.display = "block";

        // Mengisi formulir pembaruan
        updatePopup.querySelector('input[name="menu_name"]').value = name;
        updatePopup.querySelector('input[name="existing_image"]').value =
            image; // Mengisi gambar yang ada
        updatePopup.querySelector('textarea[name="description"]').value = description;
        updatePopup.querySelector('input[name="price"]').value = price;
        updatePopup.querySelector('select[name="category"]').value = category;

        // Mengatur aksi form untuk menyertakan ID menu
        updatePopup.querySelector('form').action = `CRUD.php?stts=updatemenu&id_menu=${id}`;
    });
});

// Menutup popup pembaruan
document.querySelectorAll(".close").forEach(closeButton => {
    closeButton.addEventListener("click", function() {
        this.closest(".popup").style.display = "none";
    });
});


// Close update popup
document.querySelectorAll(".close").forEach(closeButton => {
    closeButton.addEventListener("click", function() {
        this.closest(".popup").style.display = "none";
    });
});


// Close update popup
document.querySelectorAll(".close").forEach(closeButton => {
    closeButton.addEventListener("click", function() {
        this.closest(".popup").style.display = "none";
    });
});




// Delete koneksi CRUD.php 
let deleteUrl = '';

document.querySelectorAll(".btn-delete-menu").forEach(button => {
    button.addEventListener("click", function() {
        deleteUrl = 'CRUD.php?stts=deletemenu&id_menu=' + this.getAttribute('data-id');
        document.getElementById("popupDelete").style.display = "block";
    });
});

document.getElementById("confirmDelete").addEventListener("click", function() {
    window.location.href = deleteUrl;
});

document.getElementById("cancelDelete").addEventListener("click", function() {
    this.closest(".popupdelete").style.display = "none";
});


// Search
document.getElementById("searchButton").addEventListener("click", function searchMenu() {
        const searchValue = document.getElementById('searchInput').value
            .toLowerCase(); // mengubah nilai menjadi huruf kecil semua
        const rows = document.querySelectorAll('.table-menu tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const match = Array.from(cells).some(cell => {
                return cell.textContent.toLowerCase().includes(searchValue);
            });
            if (match) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

);

// tambah stok
document.querySelectorAll('.btn-tambah-stok').forEach(button => {
    button.addEventListener('click', function() {
        const id_menu = this.getAttribute('data-id');
        const stok = this.getAttribute('data-stok');
        document.getElementById('popupTambahStok').style.display = 'block';
        document.getElementById('tambah_stok_id_menu').value = id_menu;
        document.getElementById('stok_saat_ini').value = stok;

    });
});

// Tutup popup tambah stok
document.querySelectorAll('#close-btn-stok').forEach(button => {
    button.addEventListener('click', function() {
        this.closest('.popup').style.display = 'none';
    });
});
</script>