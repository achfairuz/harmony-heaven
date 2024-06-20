 <div class="title d-flex justify-content-between align-items-center overflow-y">
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