<div
    class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-2">
    <h2 class="mb-0 fw-bold text-mainColor">Customers</h2>
    <div class="search-group input-group mx-md-3 mb-2">
        <input id="searchInput" class="form-control me-2 " type="text" placeholder="Search" aria-label="Search">
        <button id="searchButton" class="btn btn-mainColor btn-outline-secondary" type="button" style="z-index: 0;">
            <span data-feather="search"></span>
        </button>
    </div>
</div>


<div class="table-responsive">
    <table class="table table-striped table-sm table-customer">
        <thead>
            <tr>
                <th scope="col">Id_user</th>
                <th scope="col">Username</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Phone number</th>

            </tr>
        </thead>
        <tbody>
            <?php
                include "koneksi.php";
               $sql = "SELECT * FROM user WHERE role is NULL";
                $result = $koneksi->query($sql);

                  

                 while ($a = $result->fetch_assoc()) {

?>

            <tr>
                <td><?php echo $a['id_user']; ?></td>
                <td><?php echo $a['username']; ?></td>
                <td><?php echo $a['name']; ?></td>
                <td><?php echo $a['address']; ?></td>
                <td><?php echo $a['phonenumber']; ?></td>


            </tr>

            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<script>
// Search
document
    .getElementById("searchButton")
    .addEventListener("click", function searchMenu() {
        const searchValue = document
            .getElementById("searchInput")
            .value.toLowerCase(); // mengubah nilai menjadi huruf kecil semua
        const rows = document.querySelectorAll(".table-customer tbody tr");

        rows.forEach((row) => {
            const cells = row.querySelectorAll("td");
            const match = Array.from(cells).some((cell) => {
                return cell.textContent.toLowerCase().includes(searchValue);
            });
            if (match) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>