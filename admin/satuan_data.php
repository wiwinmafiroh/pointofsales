<?php include ('sidebar.php'); ?>



<!-- bagian content -->
<div class="col-md users">


<!-- menentukan apakah ada request get view, kalau tdk ada akan bernilai null  -->
<?php $view = isset($_GET['view']) ? $_GET['view'] : null; ?>

<?php 
switch($view) :

  default : ?>
      <h5>DATA SATUAN</h5>
      <div class="card cardaksi">
        <div class="card-body">
          <a href="satuan_data.php?view=tambah" class="btn tambah" style="background-color: #D2B48C"><i class="fas fa-plus"></i><b>&nbsp; Tambah</b></a>

          <table class="table table-striped table-bordered" id="datatable">
            <thead>
              <tr>
                <th style="text-align: center;">No</th>
                <th>Kode Satuan</th>
                <th>Nama Satuan</th>
                <th style="text-align: center;">Aksi</th>
              </tr>
            </thead>
            
            <tbody>
              <?php  
              $no           = 1;
              $sqlsatuan  = mysqli_query($koneksi, "SELECT * FROM satuan ORDER BY kode_satuan ASC");
              ?>

              <?php while( $data = mysqli_fetch_array($sqlsatuan) ) : ?>

                <tr class="isitable">
                  <td style="text-align: center;"><?= $no; ?></td>
                  <td><?= $data["kode_satuan"]; ?></td>
                  <td><?= $data["nama_satuan"]; ?></td>
                  <td style="text-align: center;">
                    <a href="satuan_data.php?view=edit&kode_satuan=<?= $data["kode_satuan"];  ?>" class="btn edit" style="background-color: #ADD8E6;"><b>Edit</b></a>

                    <a href="satuan_aksi.php?act=delete&kode_satuan=<?= $data["kode_satuan"]; ?>" onclick="return confirm('Yakin akan Menghapus Satuan <?= $data["nama_satuan"]; ?>?');" class="btn hapus" style="background-color: #F08080"><b>Hapus</b></a>
                  </td>
                </tr>

              <?php $no++; endwhile; ?>
            </tbody>
          </table>

        </div>
      </div>
  <?php break; ?>



  <?php case "tambah" : ?>
      <!-- membuat kode satuan otomatis -->
      <?php  
        $simbol         = "S";
        $query          = mysqli_query($koneksi, 
                          "SELECT max(kode_satuan) AS last FROM
                          satuan WHERE kode_satuan LIKE '$simbol%'");
        $data           = mysqli_fetch_array($query);
        $kodeterakhir   = $data['last'];
        $nomorterakhir  = substr($kodeterakhir, 2, 3 );
        $nextnomor      = $nomorterakhir + 1;
        $nextkode       = $simbol.sprintf('%03s', $nextnomor);
      ?>

      <div class="card cardaksi">
        <h5 class="card-header cardaksi-header">Tambah Data Satuan</h5>

        <div class="card-body">
          <form method="post" action="satuan_aksi.php?act=insert">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users"  for="kode_satuan" >Kode Satuan</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="kode_satuan" value="<?= $nextkode; ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label" for="nama_satuan">Nama Satuan</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="nama_satuan" class="form-control" required id="nama_satuan" required>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-12 btntambahkurang">
                <button type="submit" class="btn" name="submit" value="Simpan" style="background-color: #ADD8E6;"><b>Simpan</b></button>

                <a href="satuan_data.php" class="btn" style="background-color: #AFEEEE"><b>Batal</b></a>
              </div>
            </div>
          </form>
        </div>

      </div>
  <?php break; ?>



  <?php case "edit" : ?>

    <?php  
      $sqledit      = mysqli_query($koneksi, "SELECT * FROM satuan WHERE kode_satuan = '$_GET[kode_satuan]'");
      $d            = mysqli_fetch_array($sqledit);
    ?>
      <div class="card cardaksi">
        <h5 class="card-header cardaksi-header">Tambah Data Satuan</h5>

        <div class="card-body">
          <form method="post" action="satuan_aksi.php?act=update">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users"  for="kode_satuan" >Kode Satuan</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="kode_satuan" value="<?= $d['kode_satuan']; ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label"  for="nama_satuan">Nama Satuan</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="nama_satuan" id="nama_satuan" value="<?= $d['nama_satuan']; ?>" required>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-12 btntambahkurang">
                <button type="submit" class="btn" name="submit" value="Update Data" style="background-color: #ADD8E6;"><b>Update</b></button>

                <a href="satuan_data.php" class="btn" style="background-color: #AFEEEE"><b>Batal</b></a>
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