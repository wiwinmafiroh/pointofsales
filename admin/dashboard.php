<?php include('sidebar.php'); ?>



<!-- bagian content -->
<div class="col-md">
  <h5>Dashboard</h5>
  <div class="line"></div>

  <div class="row">
    <div class="card card-dashboard text-white rounded-0" style="background-color: #DEB887">
      <div class="card-body">
        <h5 class="card-title"><?= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user")); ?></h5>
        <p class="card-text text-right">
          Jumlah Users
        </p>
      </div>
    </div>

    <div class="card card-dashboard text-white rounded-0" style="background-color: #CD853F">
      <div class="card-body">
        <h5 class="card-title"><?= mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM menu")); ?></h5>
        <p class="card-text text-right">
          Jumlah Menu
        </p>
      </div>
    </div>

    <div class="card card-dashboard text-white rounded-0" style="background-color: #F4A460">
      <div class="card-body">
        <?php
                $tanggal    = date('Y-m-d');
                $penjualan  = mysqli_query(
                    $koneksi,
                    "SELECT sum(total_penjualan) as total_penjualan 
                                  FROM penjualan 
                                  WHERE tanggal_penjualan = '$tanggal'"
                );
                $p = mysqli_fetch_array($penjualan);
                ?>

        <h5 class="card-title">
          <?php echo ($p["total_penjualan"] != 0) ? "Rp " . number_format($p['total_penjualan']) . "," : "Rp " . 0 . ","; ?>
        </h5>
        <p class="card-text text-right">
          Total Penjualan Hari Ini
        </p>
      </div>
    </div>

    <div class="card card-dashboard text-white rounded-0" style="background-color: #D2B48C">
      <div class="card-body">
        <?php
                $hari_ini     = date('Y-m-d');
                $total_modal  = 0;
                $modal        = mysqli_query(
                    $koneksi,
                    "SELECT penjualan.nota 
                                      as nota_penjualan, penjualan.total_penjualan, penjualan.tanggal_penjualan, transaksi.nota
                                      as nota_transaksi, transaksi.quantity, transaksi.kode_menu 
                                      as menu_transaksi, menu.kode_menu 
                                      as menu_menu, menu.harga_modal 
                                      FROM penjualan
                                      LEFT JOIN transaksi ON transaksi.nota = penjualan.nota 
                                      LEFT JOIN menu ON menu.kode_menu = transaksi.kode_menu
                                      WHERE tanggal_penjualan='$hari_ini' "
                );

                while ($l = mysqli_fetch_array($modal)) {
                    $m = $l['harga_modal'] * $l['quantity'];
                    $total_modal += $m;
                }


                $total_penjualan = 0;
                $penjualan       = mysqli_query(
                    $koneksi,
                    "SELECT sum(total_penjualan) as total_penjualan 
                                        FROM penjualan WHERE tanggal_penjualan = '$hari_ini'"
                );
                $p               = mysqli_fetch_assoc($penjualan);
                $total_penjualan = $p['total_penjualan'];

                $laba = $total_penjualan - $total_modal;
                ?>

        <h5 class="card-title"><?php echo "Rp " . number_format($laba) . "," ?></h5>
        <p class="card-text text-right">
          Laba Hari Ini
        </p>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="card card-besar">
      <div class="card-body text-center">
        <img src="../img/icon.png" width="25%">
        <br>
        <h5>Selamat Datang di Aplikasi Point Of Sales Angkringan Lek'Tok</h5>
      </div>
    </div>
  </div>

</div>
<!-- akhir bagian content -->



<?php include('footer.php'); ?>