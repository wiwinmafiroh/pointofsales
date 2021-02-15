<?php include ('sidebar.php'); ?>



<!-- bagian content -->
<div class="col-md users">


<!-- menentukan apakah ada request get view, kalau tdk ada akan bernilai null  -->
<?php $view = isset($_GET['view']) ? $_GET['view'] : null; ?>

<?php 
switch($view) :

  default : ?>

      <h5>MANAJEMEN STOK</h5>
      <div class="card cardaksi">
        <div class="card-body">
          <a href="stok_data.php?view=tambah" class="btn tambah" style="background-color: #D2B48C"><i class="fas fa-plus"></i><b>&nbsp; Tambah Stok</b></a>

          <table class="table table-striped table-bordered" id="datatable">
            <thead>
              <tr>
                <th>Kode Menu</th>
                <th>Nama Menu</th>
                <th style="text-align: center;">Stok Menu</th>
                <th></th>
              </tr>
            </thead>
            
            <tbody>
              <?php  
              $menu         = mysqli_query($koneksi,"SELECT * FROM menu");
              ?>

              <?php $no=1; while ($row=mysqli_fetch_array($menu)) : 
                if ($row['stok']<10) {
                $badge='<span class="badge badge-danger"  title="Stok Hampir Habis">!</span>';
                }
                else{
                  $badge='';
                }
              ?>

              <tr class="isitable">
                <td><?=$row['kode_menu'] ?></td>
                <td><?=$row['nama_menu']?></td>
                <td style="text-align: center;"><?=$row['stok']?></td>
                <td><?=$badge?></td>
              </tr>

              <?php $no++; endwhile; ?>
            </tbody>
          </table>

        </div>
      </div>
  <?php break; ?>



  <?php case "tambah" : ?>
      <div class="card cardaksi">
        <h5 class="card-header cardaksi-header">Tambah Stok</h5>

        <div class="card-body">
          <form method="post" action="stok_aksi.php?act=insert">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users"  for="kode_menu">Nama Menu</label>
              <div class="col-sm-7">
                <select name="kode_menu" class="form-control">
                  <option selected disabled>- Pilih Menu -</option>
                  <?php
                  $menu = mysqli_query($koneksi,"SELECT * FROM menu");
                  while ($row = mysqli_fetch_array($menu)) {
                    if ($row['stok']<10) {
                      $style='style="color:red"';
                    }else{
                      $style='';
                    }
                    ?>

                    <option value="<?=$row['kode_menu']?>" <?=$style?> ><?=$row['nama_menu']?> -- <span class="pull-right"><?=$row['stok']?></span></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label"  for="tambah_stok">Tambahan Stok</label>
              <div class="col-sm-7">
                <input type="number" class="form-control" name="tambah_stok" class="form-control" required id="tambah_stok" required>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-12 btntambahkurang">
                <button type="submit" class="btn" name="submit" value="Simpan" style="background-color: #ADD8E6;"><b>Simpan</b></button>

                <a href="stok_data.php" class="btn" style="background-color: #AFEEEE"><b>Batal</b></a>
              </div>
            </div>
          </form>
        </div>

      </div>
  <?php break; ?>

<?php endswitch; ?>



</div>
<!-- akhir bagian content -->



<?php include ('footer.php'); ?>