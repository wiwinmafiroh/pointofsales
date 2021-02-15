<?php include ('sidebar.php'); ?>



<!-- bagian content -->
<div class="col-md users">


  <h5>LAPORAN <small>Data Laporan Penjualan</small></h5>
  <div class="card cardaksi">
    <div class="card-body">

    	<div class="card" style="min-width: 955px; border: 1px solid #CD853F;">
		  <div class="card-body">
		    <h5 class="card-title" style="font-size: 18px;">Filter Laporan Penjualan</h5>

		    <form method="get" action="">
		    <div class="row">
		    	<div class="col-md-4">
			    <div class="form-group">
		            <label style="font-size: 15px;">Mulai Tanggal</label>
		            <input autocomplete="off" type="text" value="<?php if(isset($_GET['tanggal_dari'])){echo $_GET['tanggal_dari'];}else{echo "";} ?>" name="tanggal_dari" class="form-control datepicker2" placeholder="Mulai Tanggal" required="required">
		      </div>
		      </div>

	        <div class="col-md-4">
	        <div class="form-group">
                <label style="font-size: 15px;">Sampai Tanggal</label>
                <input autocomplete="off" type="text" value="<?php if(isset($_GET['tanggal_sampai'])){echo $_GET['tanggal_sampai'];}else{echo "";} ?>" name="tanggal_sampai" class="form-control datepicker2" placeholder="Sampai Tanggal" required="required">
          </div>
          </div>

          <div class="col-md-2">
          <div class="form-group">
                <input style="margin-top: 36px; background-color: #D2B48C; font-size: 14px; text-decoration: bold; font-weight: bold;" type="submit" value="TAMPILKAN" class="btn btn-sm btn-block">
          </div>
          </div>
        </div>
	    	</form>

		  </div>
		</div>



    	<div class="card" style="min-width: 955px; margin-top: 20px; border: 1px solid #CD853F;">
		  <div class="card-body">
		    <h5 class="card-title" style="font-size: 18px;">Data Penjualan</h5>

		      <?php 
            	if(isset($_GET['tanggal_sampai']) && isset($_GET['tanggal_dari'])){
	              $tgl_dari = $_GET['tanggal_dari'];
	              $tgl_sampai = $_GET['tanggal_sampai'];
              ?>

              <div class="row"  style="margin-left: -15px;">
                <div class="col-lg-5">
                  <table class="table table-bordered">
                    <tr style="background-color: white !important;">
                      <td style="font-size: 15px; width: 300px; border-color: #D3D3D3 !important;">Dari Tanggal</td>
                      <td style="width: 1px; border-color: #D3D3D3 !important;">:</td>
                      <td style="border-color: #D3D3D3 !important;"><?= date("d M Y", strtotime($tgl_dari)); ?></td>
                    </tr>
                    <tr>
                      <td style="font-size: 15px; width: 300px; border-color: #D3D3D3 !important;">Sampai Tanggal</td>
                      <td style="width: 1px; border-color: #D3D3D3 !important;">:</td>
                      <td style="border-color: #D3D3D3 !important;"><?= date("d M Y", strtotime($tgl_sampai)); ?></td>
                    </tr>
                  </table>
                </div>
              </div>

              <a href="laporan_print.php?tanggal_dari=<?= $tgl_dari ?>&tanggal_sampai=<?= $tgl_sampai ?>" target="_blank" class="btn btn-sm" style="margin-bottom: 15px; background-color: #ADD8E6;"><i class="fa fa-print"></i><b> &nbsp PRINT</b></a>
              <div class="table-responsive">

                <table class="table table-bordered" id="datatable">
                  <thead>
                    <tr>
                      <th width="1%">No</th>
                      <th width="10%" class="text-center">Nota</th>
                      <th class="text-center">Tanggal</th>
                      <th class="text-center">Pembeli</th>
                      <th class="text-center">Sub Total</th>
                      <th width="1%" class="text-center">Diskon</th>
                      <th class="text-center">Total Bayar</th>
                      <th class="text-center">Modal</th>
                      <th class="text-center">Laba</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no=1;
                    $x_total_sub_total = 0;
                    $x_total_total = 0;
                    $x_total_modal = 0;
                    $x_total_laba = 0;
                    $data = mysqli_query($koneksi, "SELECT *FROM penjualan WHERE date(tanggal_penjualan) >= '$tgl_dari' and date(tanggal_penjualan) <= '$tgl_sampai' order by id_penjualan desc");
                    while($d = mysqli_fetch_array($data)){
                      ?>
                      <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td class="text-center"><?php echo $d['nota']; ?></td>
                        <td class="text-center"><?php echo date('d-m-Y', strtotime($d['tanggal_penjualan'])); ?></td>
                        <td class="text-left"><?php echo $d['nama_customer']; ?></td>
                        <td class="text-right"><?php echo "Rp ".number_format($d['sub_total_penjualan']).","; ?></td>
                        <td class="text-center"><?php echo $d['diskon_penjualan']; ?>%</td>
                        <td class="text-right"><?php echo "Rp ".number_format($d['total_penjualan']).","; ?></td>
                        <td class="text-right">

                          <?php 
                          $id_penjualan = $d['id_penjualan'];
                          $total_modal = 0;

                          $modal = mysqli_query($koneksi, "SELECT penjualan.nota as nota_penjualan, penjualan.total_penjualan, penjualan.tanggal_penjualan, transaksi.nota as nota_transaksi, transaksi.quantity, transaksi.total_transaksi, transaksi.kode_menu as menu_transaksi, menu.kode_menu as menu_menu, menu.harga_modal 
                                                  FROM penjualan
                                                  LEFT JOIN transaksi ON transaksi.nota = penjualan.nota 
                                                  LEFT JOIN menu ON menu.kode_menu = transaksi.kode_menu
                                                  WHERE id_penjualan='$id_penjualan' ");
                          while($l = mysqli_fetch_array($modal)){
                            $m = $l['harga_modal'] * $l['quantity'];
                            $total_modal += $m;
                          }
                          ?>

                          <?php echo "Rp ".number_format($total_modal).","; ?>

                        </td>
                        <td class="text-right">

                          <?php 
                          $total_laba = $d['total_penjualan'] - $total_modal;
                          ?>
                          <?php echo "Rp ".number_format($total_laba).","; ?>

                        </td>
                      </tr>
                      <?php 
                      $x_total_sub_total += $d['sub_total_penjualan'];
                      $x_total_total += $d['total_penjualan'];
                      $x_total_modal += $total_modal;
                      $x_total_laba += $total_laba;
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr style="background-color: #F5F5DC !important;">
                      <td colspan="4" class="text-right"><b>TOTAL</b></td>
                      <td class="text-right"><?php echo "Rp ".number_format($x_total_sub_total).","; ?></td>
                      <td class="text-right"></td>
                      <td class="text-right"><?php echo "Rp ".number_format($x_total_total).","; ?></td>
                      <td class="text-right"><?php echo "Rp ".number_format($x_total_modal).","; ?></td>
                      <td class="text-right"><?php echo "Rp ".number_format($x_total_laba).","; ?></td>
                    </tr>
                  </tfoot>
                </table>

              </div>

              <?php 
            }else{
              ?>

              <div class="alert text-center" style="background-color: #DEB887;">
                <b>Silahkan Filter Laporan Terlebih Dulu.</b>
              </div>

              <?php
            }
            ?>

		  </div>
		</div>


    </div>
  </div>



</div>
<!-- akhir bagian content -->



<?php include ('footer.php'); ?>