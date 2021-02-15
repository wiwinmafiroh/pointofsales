<?php include ('sidebar.php'); ?>



<!-- bagian content -->
<div class="col-md users">


<!-- menentukan apakah ada request get view, kalau tdk ada akan bernilai null  -->
<?php $view = isset($_GET['view']) ? $_GET['view'] : null; ?>

<?php 
switch($view) :

  default : ?>
      <div class="card cardaksi">
        <h5 class="card-header cardaksi-header">Data Menu</h5>
        <div class="card-body">
          <a href="menu_data.php?view=tambah" class="btn tambah" style="background-color: #D2B48C"><i class="fas fa-plus"></i><b>&nbsp; Tambah</b></a>

          <table class="table table-striped table-bordered" id="datatable">
            <thead>
              <tr>
                <th style="text-align: center;">No</th>
                <th>Nama Menu</th>
                <th style="text-align: center;">Harga Jual</th>
                <th style="text-align: center;">Stok</th>
                <th style="text-align: center;">Gambar</th>
                <th style="text-align: center;">Aksi</th>
              </tr>
            </thead>
            
            <tbody>
              <?php  
              $no       = 1;
              $sqlmenu  = mysqli_query($koneksi, 
                            "SELECT * FROM menu");
              ?>

              <?php while( $data = mysqli_fetch_array($sqlmenu) ) : ?>

                <tr class="isitable">
                  <td style="text-align: center;"><?= $no; ?></td>
                  <td><?= $data["nama_menu"]; ?></td>
                  <td style="text-align: center;"><?= number_format($data["harga_jual"]) ?></td>
                  <td style="text-align: center;"><?= $data["stok"]; ?></td>
                  <td style="text-align: center;"><img src="<?= "../img/upload/menu/".$data["gambar"]; ?>" width=50%;></td>
                  <td style="text-align: center;">
                    <a href="menu_data.php?view=detail&kode_menu=<?= $data["kode_menu"];  ?>" class="btn edit" style="color: black; margin-bottom: 5px; width: 30%; background-color: #ADD8E6;"><b><i class="fa fa-search"></i></b></a>

                    <a href="menu_data.php?view=edit&kode_menu=<?= $data["kode_menu"];  ?>" class="btn edit" style="color: black; margin-bottom: 5px; width: 30%; background-color: #AFEEEE"><b><i class="fas fa-edit"></i></b></a>

                    <a href="menu_aksi.php?act=delete&kode_menu=<?= $data["kode_menu"]; ?>" onclick="return confirm('Yakin akan Menghapus Kategori <?= $data["nama_menu"]; ?>?');" class="btn hapus" style="color: black; margin-bottom: 5px; width: 30%; background-color: #F08080"><b><i class="fa fa-trash" aria-hidden="true"></i></b></a>
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
        $simbol         = "M";
        $query          = mysqli_query($koneksi, 
                          "SELECT max(kode_menu) AS last FROM
                          menu WHERE kode_menu LIKE '$simbol%'");
        $data           = mysqli_fetch_array($query);
        $kodeterakhir   = $data['last'];
        $nomorterakhir  = substr($kodeterakhir, 2, 3 );
        $nextnomor      = $nomorterakhir + 1;
        $nextkode       = $simbol.sprintf('%03s', $nextnomor);
      ?>

      <div class="card cardaksi">
        <h5 class="card-header cardaksi-header">Tambah Data Menu</h5>

        <div class="card-body">
          <form action="menu_aksi.php?act=insert" method="post"  enctype="multipart/form-data">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users"  for="kode_menu" >Kode Menu</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="kode_menu" value="<?= $nextkode; ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label"  for="kode_kategori">Kategori</label>
              <div class="col-sm-7">
                <select name="kode_kategori" class="form-control">
                  <option disabled selected>- Pilih Kategori -</option>
                  <?php  
                  $sqlkategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY kode_kategori ASC");
                  while( $k = mysqli_fetch_array($sqlkategori) ) : ?>
                    <option value="<?= $k['kode_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label"  for="nama_menu">Nama Menu</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="nama_menu" class="form-control" id="nama_menu" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users">Harga Jual</label>
              <div class="input-group col-sm-7">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp</div>
                </div>
                <input type="number" class="form-control" name="harga_jual" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users">Harga Modal</label>
              <div class="input-group col-sm-7">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp</div>
                </div>
                <input type="number" class="form-control" name="harga_modal" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label"  for="kode_satuan">Satuan</label>
              <div class="col-sm-7">
                <select name="kode_satuan" class="form-control" required>
                  <option>- Pilih Satuan -</option>
                  <?php  
                  $sqlsatuan = mysqli_query($koneksi, "SELECT * FROM satuan ORDER BY kode_satuan ASC");
                  while( $s = mysqli_fetch_array($sqlsatuan) ) : ?>
                    <option value="<?= $s['kode_satuan'] ?>"><?= $s['nama_satuan'] ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label" for="stok">Gambar</label>
              <div class="col-sm-7">
                <input type="file" name="gambar" id="gambar" required>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-12 btntambahkurang">
                <button type="submit" class="btn" name="submit" value="Simpan" style="color: black; background-color: #ADD8E6;"><b>Simpan</b></button>
                <a href="menu_data.php" class="btn" style="background-color: #AFEEEE"><b>Batal</b></a>
              </div>
            </div>
          </form>
        </div>

      </div>
  <?php break; ?>



  <?php case "edit" : ?>

    <?php  
      $sqledit    = mysqli_query($koneksi, "SELECT * FROM menu WHERE kode_menu = '$_GET[kode_menu]'");
      $d          = mysqli_fetch_array($sqledit);
    ?>
      <div class="card cardaksi">
        <h5 class="card-header cardaksi-header">Edit Data Menu</h5>

        <div class="card-body">
          <form  action="menu_aksi.php?act=update" method="post" enctype="multipart/form-data">
            <input type="hidden" name="gambarlama" value="<?= $d['gambar'] ?>">
            
            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users"  for="kode_menu" >Kode Menu</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="kode_menu" value="<?= $d['kode_menu']; ?>" readonly>
              </div>
            </div>

<!--             <div class="form-group row">
              <label class="col-sm-5 col-form-label"  for="kode_kategori">Kategori</label>
              <div class="col-sm-7">
                <select name="kode_kategori" class="form-control">
                    <option value="<?= $k['kode_kategori'] ?>"><?= $d['nama_kategori'] ?></option>
                </select>
              </div>
            </div> -->

            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users"  for="nama_menu" >Nama Menu</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="nama_menu" value="<?= $d['nama_menu']; ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users" for="harga_jual">Harga Jual</label>
              <div class="input-group col-sm-7">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp</div>
                </div>
                <input type="text" class="form-control" name="harga_jual" id="harga_jual" value="<?= $d['harga_jual']; ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users" for="harga_modal">Harga Modal</label>
              <div class="input-group col-sm-7">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp</div>
                </div>
                <input type="text" class="form-control" name="harga_modal" id="harga_modal" value="<?= $d['harga_modal']; ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users"  for="stok" >Stok</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="stok" value="<?= $d['stok']; ?>" readonly>
              </div>
            </div>

<!--             <div class="form-group row">
              <label class="col-sm-5 col-form-label"  for="kode_satuan">Satuan</label>
              <div class="col-sm-7">
                <select name="kode_satuan" class="form-control">
                  <?php  
                  while( $s = mysqli_fetch_array($sqledit) ) : ?>
                    <option value="<?= $s['kode_satuan'] ?>"><?= $s['nama_satuan'] ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
            </div> -->

            <div class="form-group row">
              <label class="col-sm-5 col-form-label" for="gambar">Gambar</label>
              <div class="col-sm-7">
                <img src="../img/upload/menu/<?= $d['gambar']; ?>" width="99">
                <input type="file" name="gambar" id="gambar">
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-12 btntambahkurang">
                <button type="submit" class="btn" name="submit" value="Update Data" style="background-color: #ADD8E6;"><b>Update</b></button>

                <a href="menu_data.php" class="btn" style="background-color: #AFEEEE"><b>Batal</b></a>
              </div>
            </div>
          </form>
        </div>
      </div>


  <?php break; ?>


  <?php case "detail" : ?>
      <?php  
      $sqldetail    = mysqli_query($koneksi, "SELECT menu.*, kategori.nama_kategori, satuan.nama_satuan 
                      FROM menu 
                      INNER JOIN kategori ON menu.kode_kategori=kategori.kode_kategori 
                      INNER JOIN satuan ON menu.kode_satuan=satuan.kode_satuan 
                      WHERE kode_menu = '$_GET[kode_menu]'");
      $detail       = mysqli_fetch_array($sqldetail);
      ?>

      
      <div class="card cardaksi">
        <h5 class="card-header cardaksi-header">Detail Menu</h5>

        <div class="card-body">
          <form method="post" action="">

            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users"  for="kode_menu" >Kode Menu</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="kode_menu" value="<?= $detail['kode_menu']; ?>" readonly>
              </div>
            </div> 

            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users"  for="kode_kategori" >Kategori</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="kode_kategori" value="<?= $detail['nama_kategori']; ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users"  for="nama_menu" >Nama Menu</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="nama_menu" value="<?= $detail['nama_menu']; ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users" for="harga_jual">Harga Jual</label>
              <div class="input-group col-sm-7">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp</div>
                </div>
                <input type="text" class="form-control uang" name="harga_jual" id="harga_jual" value="<?= $detail['harga_jual']; ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users" for="harga_modal">Harga Modal</label>
              <div class="input-group col-sm-7">
                <div class="input-group-prepend">
                  <div class="input-group-text">Rp</div>
                </div>
                <input type="text" class="form-control uang" name="harga_modal" id="harga_modal" value="<?= $detail['harga_modal']; ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users"  for="stok" >Stok</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="stok" value="<?= $detail['stok']; ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users"  for="kode_kategori" >Satuan</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="kode_satuan" value="<?= $detail['nama_satuan']; ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label" for="gambar">Gambar</label>
              <div class="col-sm-7">
                <img src="../img/upload/menu/<?= $detail['gambar']; ?>" width="99">
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-12 btntambahkurang">
                <a href="menu_data.php" class="btn" style="background-color: #AFEEEE"><b>Kembali</b></a>
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