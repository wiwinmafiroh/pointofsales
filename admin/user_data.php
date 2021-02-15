<?php include ('sidebar.php'); ?>



<!-- bagian content -->
<div class="col-md users">



<?php $view = isset($_GET['view']) ? $_GET['view'] : null; ?>

<?php 
switch($view) :

  default : ?>
      <h5>DATA USER</h5>
      <div class="card cardaksi">
        <div class="card-body">
          <a href="user_data.php?view=tambah" class="btn tambah" style="background-color: #D2B48C"><i class="fas fa-plus"></i><b>&nbsp; Tambah</b></a>

          <table class="table table-striped table-bordered" id="datatable">
            <thead>
              <tr>
                <th style="text-align: center;">No</th>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Level</th>
                <th style="text-align: center; width: 600px;">Aksi</th>
              </tr>
            </thead>
            
            <tbody>
              <?php  
              $no       = 1;
              $sqluser  = mysqli_query($koneksi, "SELECT * FROM user");
              ?>

              <?php while( $data = mysqli_fetch_array($sqluser) ) : ?>

                <tr class="isitable">
                  <td style="text-align: center;"><?= $no; ?></td>
                  <td><?= $data["nama_lengkap"]; ?></td>
                  <td><?= $data["username"]; ?></td>
                  <td><?= $data["level"]; ?></td>
                  <td style="text-align: center;">
                    <a href="user_data.php?view=edit&id_user=<?= $data["id_user"];  ?>" class="btn edit" style="background-color: #ADD8E6;"><b>Edit</b></a>

                    <a href="user_aksi.php?act=delete&id_user=<?= $data["id_user"]; ?>" onclick="return confirm('Yakin akan Menghapus data <?= $data["nama_lengkap"]; ?>?');" class="btn hapus" style="background-color: #F08080"><b>Hapus</b></a>
                  </td>
                </tr>

              <?php $no++; endwhile; ?>
            </tbody>
          </table>

        </div>
      </div>
  <?php break; ?>



  <?php case "tambah" : ?>
      <div class="card cardaksi">
        <h5 class="card-header cardaksi-header">Tambah Data User</h5>

        <div class="card-body">
          <form method="post" action="user_aksi.php?act=insert">
            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users"  for="nama_lengkap" >Nama Lengkap</label>
              <div class="col-sm-7">
                <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" id="nama_lengkap" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label"  for="username">Username</label>
              <div class="col-sm-7">
                <input type="text" name="username" class="form-control" placeholder="Username" required id="username" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label" for="password">Password</label>
              <div class="col-sm-7">
                <input type="password" name="password" class="form-control" placeholder="Password" id="password" required>
              </div>
            </div>

            <fieldset class="form-group">
              <div class="row">
                <legend class="col-form-label col-sm-5 pt-0">Level</legend>
                <div class="col-sm-7">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="level" id="gridRadios1" value="Admin" checked required>
                    <label class="form-check-label" for="gridRadios1">
                      Admin
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="level" id="gridRadios2" value="Kasir" required>
                    <label class="form-check-label" for="gridRadios2">
                      Kasir
                    </label>
                  </div>
                </div>
              </div>
            </fieldset>

            <div class="form-group row">
              <div class="col-sm-12 btntambahkurang">
                <button type="submit" class="btn" name="submit" value="Simpan" style="background-color: #ADD8E6;"><b>Simpan</b></button>
                <a href="user_data.php" class="btn" style="background-color: #AFEEEE"><b>Batal</b></a>
              </div>
            </div>
          </form>
        </div>

      </div>
  <?php break; ?>



  <?php case "edit" : ?>

    <?php 
      $sqledit  = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$_GET[id_user]'");
      $d    = mysqli_fetch_array($sqledit);
    ?>

      <div class="card cardaksi">
        <h5 class="card-header cardaksi-header">Edit Data User</h5>

        <div class="card-body">
          <form method="post" action="user_aksi.php?act=update">
            <input type="hidden" name="id_user" value="<?= $d['id_user']; ?>">

            <div class="form-group row">
              <label class="col-sm-5 col-form-label tambah-users"  for="nama_lengkap" >Nama Lengkap</label>
              <div class="col-sm-7">
                <input type="text" name="nama_lengkap" class="form-control" value="<?= $d['nama_lengkap']; ?>" id="nama_lengkap" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label"  for="username">Username</label>
              <div class="col-sm-7">
                <input type="text" name="username" class="form-control" value="<?= $d['username']; ?>" required id="username" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-5 col-form-label" for="password">Password</label>
              <div class="col-sm-7">
                <input type="password" name="password" class="form-control" placeholder="Kosongkan Jika Tidak di Ganti" id="password">
              </div>
            </div>

            <fieldset class="form-group">
              <div class="row">
                <legend class="col-form-label col-sm-5 pt-0">Level</legend>
                <div class="col-sm-7">
                  <div class="form-check">
                    <label>
                      <input class="form-check-input" type="radio" name="level" id="gridRadios1" value="Admin" <?php if($d['level'] == "Admin") echo "checked"?>>Admin
                    </label>
                  </div>
                  <div class="form-check">
                    <label>
                      <input class="form-check-input" type="radio" name="level" id="gridRadios2" value="Kasir" 
                      <?php if($d['level'] == "Kasir") echo "checked"?>>Kasir
                    </label>
                  </div>
                </div>
              </div>
            </fieldset>

            <div class="form-group row">
              <div class="col-sm-12 btntambahkurang">
                <button type="submit" class="btn" name="submit" value="Update Data" style="background-color: #ADD8E6;"><b>Update</b></button>
                <a href="user_data.php" class="btn" style="background-color: #AFEEEE"><b>Batal</b></a>
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