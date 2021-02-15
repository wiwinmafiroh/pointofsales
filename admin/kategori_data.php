<?php include ('sidebar.php'); ?>



<!-- bagian content -->
<div class="col-md users">


<!-- menentukan apakah ada request get view, kalau tdk ada akan bernilai null  -->
<?php $view = isset($_GET['view']) ? $_GET['view'] : null; ?>

<?php 
switch($view) :

  default : ?>
      <h5>DATA KATEGORI</h5>
      <div class="card cardaksi">
        <div class="card-body">
          <a href="kategori_data.php?view=tambah" class="btn tambah" style="background-color: #D2B48C"><i class="fas fa-plus"></i><b>&nbsp; Tambah</b></a>

          <table class="table table-striped table-bordered data" id="datatable">
            <thead>
              <tr>
                <th style="text-align: center;">No</th>
                <th>Kode Kategori</th>
                <th>Nama Kategori</th>
                <th style="text-align: center;">Aksi</th>
              </tr>
            </thead>
            
            <tbody>
              <?php  
              $no           = 1;
              $sqlkategori  = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY kode_kategori ASC");
              ?>

              <?php while( $data = mysqli_fetch_array($sqlkategori) ) : ?>

                <tr class="isitable">
                  <td style="text-align: center;"><?= $no; ?></td>
                  <td><?= $data["kode_kategori"]; ?></td>
                  <td><?= $data["nama_kategori"]; ?></td>
                  <td style="text-align: center;">
                    <a href="kategori_data.php?view=edit&kode_kategori=<?= $data["kode_kategori"];  ?>" class="btn edit" style="background-color: #ADD8E6;"><b>Edit</b></a>

                    <a href="kategori_aksi.php?act=delete&kode_kategori=<?= $data["kode_kategori"]; ?>" onclick="return confirm('Yakin akan Menghapus Kategori <?= $data["nama_kategori"]; ?>?');" class="btn hapus" style="background-color: #F08080"><b>Hapus</b></a>
                  </td>
                </tr>

              <?php $no++; endwhile; ?>
            </tbody>
          </table>

        </div>
      </div>
  <?php break; ?>



  <?php case "tambah" : ?>
      <!-- membuat kode kategori otomatis -->
      <?php  
        $simbol         = "K";
        $query          = mysqli_query($koneksi, 
                          "SELECT max(kode_kategori) AS last FROM
                          kategori WHERE kode_kategori LIKE '$simbol%'");
        $data           = mysqli_fetch_array($query);
        $kodeterakhir   = $data['last'];
        $nomorterakhir  = substr($kodeterakhir, 2, 3 );
        $nextnomor      = $nomorterakhir + 1;
        $nextkode       = $simbol.sprintf('%03s', $nextnomor);
      ?>

      <div class="card cardaksi">
        <h5 class="card-header cardaksi-header">Tambah Data Kategori</h5>

        <div class="card-body">
          <form method="post" action="kategori_aksi.php?act=insert">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users"  for="kode_kategori" >Kode Kategori</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="kode_kategori" value="<?= $nextkode; ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label"  for="nama_kategori">Nama Kategori</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="nama_kategori" class="form-control" required id="nama_kategori" required>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-12 btntambahkurang">
                <button type="submit" class="btn" name="submit" value="Simpan" style="background-color: #ADD8E6;"><b>Simpan</b></button>
                <a href="kategori_data.php" class="btn" style="background-color: #AFEEEE"><b>Batal</b></a>
              </div>
            </div>
          </form>
        </div>

      </div>
  <?php break; ?>



  <?php case "edit" : ?>

    <?php  
      $sqledit    = mysqli_query($koneksi, "SELECT * FROM kategori WHERE kode_kategori = '$_GET[kode_kategori]'");
      $d          = mysqli_fetch_array($sqledit);
    ?>
      <div class="card cardaksi">
        <h5 class="card-header cardaksi-header">Tambah Data Kategori</h5>

        <div class="card-body">
          <form method="post" action="kategori_aksi.php?act=update">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users"  for="kode_kategori" >Kode Kategori</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="kode_kategori" value="<?= $d['kode_kategori']; ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label"  for="nama_kategori">Nama Kategori</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" value="<?= $d['nama_kategori']; ?>" required>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-12 btntambahkurang">
                <button type="submit" class="btn" name="submit" value="Update Data" style="background-color: #ADD8E6;"><b>Update</b></button>

                <a href="kategori_data.php" class="btn" style="background-color: #AFEEEE"><b>Batal</b></a>
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