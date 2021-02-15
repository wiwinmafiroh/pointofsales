<?php include ('sidebar.php'); ?>



<!-- bagian content -->
<div class="col-md users">



  <div class="card cardaksi">
    <h5 class="card-header cardaksi-header">Transaksi Penjualan</h5>
    <div class="card-body">
    	<!-- <a href="penjualan.php" class="btn btn-sm btn-primary tambah"><i class="fa fa-file"></i> &nbsp; DATA PENJUALAN</a> -->


    	<form action="transaksi_act.php" method="POST">

    		<!-- BARIS PERTAMA KASIR, NOTA, TANGGAL, NAMA PEMBELI -->
    		<div class="row">
    			<div class="col-md-3">
    				<input type="hidden" name="kasir" value="<?= $SESSION['id_user']; ?>">
                    <div class="form-group">
                        <label>Kasir</label>
                        <input type="text" class="form-control" value="<?= $_SESSION['nama_lengkap']; ?>" required readonly>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Nota</label>
                          <?php 
                                // mencari kode Produk dengan nilai paling besar
                          $hasil = mysqli_query($koneksi,"SELECT max(nota) as maxNota FROM penjualan");
                          $kp = mysqli_fetch_array($hasil);
                          $kodenota = $kp['maxNota'];
                          // echo $kodeInvoice;
                          // echo "<br/>";
                          $noUrut = substr($kodenota, 6, 3);
                          // echo $noUrut;
                          $noUrut++;
                          // echo $noUrut;
                          $depan = ('TR');
                          $thn = date('y');
                          $bln = date('m');
                          $tgl = date('d');
                          $char = $thn.$bln.$tgl;
                          $nomornota = $char . sprintf("%02s", $noUrut);
                          // echo $noInvoice;
                          ?>
                        <input type="text" class="form-control" name="nota" placeholder="Masukkan Nomor Nota" value="<?= $nomornota; ?>" required readonly>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tanggal Transaksi</label>
                        <input type="text" name="tanggal" class="form-control datepicker2" placeholder="Masukkan Tanggal" value="<?= date("Y-m-d"); ?>" required>
                        <!-- <input type="date" class="form-control" name="tanggal" placeholder="Masukkan Tanggal Transaksi" value="<?php echo date('Y-m-d') ?>" required> -->
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Nama Pembeli</label>
                        <input type="text" class="form-control" name="nama_customer" placeholder="Nama Pembeli" required>
                    </div>
                </div>
    		</div>
            <!-- AKHIR BARIS PERTAMA KASIR, NOTA, TANGGAL, NAMA PEMBELI -->
            <hr>


            <!-- BARIS KEDUA INPUT MENU, QTY DLL -->
            <div class="row">
                <h5>Pilih Menu</h5>
            </div>

            <div class="row">

                <div class="col-md-2">
                    <label>Kode Menu</label>
                    <input type="hidden" class="form-control" name="tambahkan_id" id="tambahkan_id">
                    <input type="text" class="form-control" name="tambahkan_kode" id="tambahkan_kode" readonly style="width: 125%;">
                </div>

                <div class="col-md-1">
                    <button type="button" class="btn" data-toggle="modal" data-target="#cariMenu" style="margin-top: 32px; width: 100%; border-radius: 0px 10% 10% 0px; background-color: #D2B48C;">
                        <i class="fa fa-search"></i>
                    </button>
                </div>

                <!-- Modal Untuk Mencari Produk -->
                <div class="modal fade" id="cariMenu" tabindex="-1" role="dialog" aria-labelledby="cariMenuLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalScrollableTitle">Pilih Menu</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="table">
                                    <table class="table table-bordered table-striped table-hover" id="datatable">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Kode Menu</th>
                                                <th class="text-center">Nama Menu</th>
                                                <th class="text-center">Stok</th>
                                                <th class="text-center">Harga Jual</th>
                                                <th class="text-center">Gambar</th>
                                                <th class="text-center"></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php  
                                            $no =1;
                                            $sqlPilihMenu = mysqli_query($koneksi, "SELECT menu.*, kategori.nama_kategori, satuan.nama_satuan 
                                              FROM menu 
                                              INNER JOIN kategori ON menu.kode_kategori=kategori.kode_kategori 
                                              INNER JOIN satuan ON menu.kode_satuan=satuan.kode_satuan 
                                              WHERE kode_menu = kode_menu");
                                            while ( $m = mysqli_fetch_array($sqlPilihMenu) ) :
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++; ?></td>
                                                    <td class="text-center"><?= $m['kode_menu']; ?></td>
                                                    <td>
                                                        <?= $m['nama_menu']; ?>
                                                        <br>
                                                        <small><?= $m['nama_kategori']; ?></small>
                                                    </td>
                                                    <td>
                                                        <?= $m['stok']; ?>
                                                        <br>
                                                        <small><?= $m['nama_satuan']; ?></small>
                                                    </td>
                                                    <td class="text-center"><?= "Rp ".number_format($m['harga_jual']).","; ?></td>
                                                    <td class="text-center"><img src="<?= "../img/upload/menu/".$m['gambar']; ?>" width=50%;></td>
                                                    <td class="text-center">
                                                        <?php if ( $m['stok'] > 0 ) : ?>
                                                            <input type="hidden" id="kode_<?= $m['kode_menu']; ?>" value="<?= $m['kode_menu']; ?>">

                                                            <input type="hidden" id="nama_<?= $m['kode_menu']; ?>" value="<?= $m['nama_menu']; ?>">

                                                            <input type="hidden" id="hargajual_<?= $m['kode_menu']; ?>" value="<?= $m['harga_jual']; ?>">

                                                            <button type="button" class="btn btn-success btn-sm modal-pilih-menu" id="<?= $m['kode_menu']; ?>" data-dismiss="modal">Pilih</button>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>

                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Akhir Modal Untuk Mencari Produk -->

                <?php 
                $no =1;
                $p = mysqli_query($koneksi, "SELECT * FROM menu");
                $j = mysqli_fetch_array($p)
                ?>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Nama Menu</label>
                        <input type="text" class="form-control" id="tambahkan_nama" disabled>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="text" class="form-control" id="tambahkan_harga" disabled style="width: 115%;">
                    </div>
                </div>

                <div class="col-md-1">
                    <div class="form-group">
                        <label>Qty</label>
                        <input type="number" class="form-control" id="tambahkan_quantity" min="0" max="<?= $j['stok']; ?>" style="width: 115%;">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Total</label>
                        <input type="text" class="form-control" id="tambahkan_total_harga_peritem" disabled style="width: 115%;">
                    </div>
                </div>

                <div class="col-md-1">
                    <div class="form-group">
                        <span class="btn btn-sm pull-right btn-block" id="tombol-tambahkan" style="margin-top: 31px; background-color: #F4A460;"><i class="fas fa-shopping-cart fa-2x"></i></span>
                    </div>
                </div>

            </div>
            <!-- AKHIR BARIS KEDUA INPUT MENU, QTY DLL -->
            <hr>


            <!-- BARIS KETIGA CETAK MENU KE DAFTAR PEMBELIAN -->
            <div class="row">
                <h5>Daftar Pembelian</h5>
            </div>

            <div class="row">
                
                <div class="col-md-12">
                    <table class="table table-bordered table-striped table-hover" id="table-pembelian">
                        <thead>
                            <tr class="text-center">
                                <th>Kode Menu</th>
                                <th>Nama Menu</th>
                                <th>Harga</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- numpang lewat -->
                        </tbody>

                        <tfoot>
                            <tr style="background-color: #F5F5DC !important;">
                              <td style="text-align: right;" colspan="2"><b>Total</b></td>
                              <td style="text-align: right;"><span class="pembelian_harga" id="0">Rp 0,</span></td>
                              <td style="text-align: center;"><span class="pembelian_quantity" id="0">0</span></td>
                              <td style="text-align: right;"><span class="pembelian_total_keseluruhan" id="0">Rp 0,</span></td>
                              <td style="text-align: center;"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
            <!-- AKHIR BARIS KETIGA CETAK MENU KE DAFTAR PEMBELIAN -->
            <hr>


            <!-- BARIS KEEMPAT PEMBAYARAN DILAKUKAN DISINI -->
            <div class="row">
                <h5>Pembayaran</h5>
            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="card">
                      <div class="card-body">
                        
                        <table class="table table-borderless">

                            <tr>
                                <th width="50%">Sub Total Pembelian</th>
                                    <td width="50%">
                                        <input type="hidden" name="sub_total" class="sub_total_akhir_form" value="0">
                                        <span class="sub_total_pembelian" id="0">Rp 0,-</span>
                                    </td>
                            </tr>

                            <tr>
                                <th>Diskon</th>
                                <td>
                                    <div class="row" style="margin-left: -15px;">
                                        <div class="input-group" style="width: 90%; margin-left: 15px;">
                                            <input class="form-control total_diskon" type="number" min="0" max="100" id="0" name="diskon" value="0" required>
                                            <div class="input-group-prepend">
                                              <div class="input-group-text">%</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th>Total Pembelian</th>
                                <td>
                                    <input type="hidden" name="total" class="total_akhir_form" value="0">
                                    <span class="total_pembelian" id="0">Rp 0,-</span>
                                </td>
                            </tr>

                        </table>

                      </div>
                    </div>
                </div>


                <div class="col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Bayar</th>
                                    <td width="70%">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <div class="input-group-text">Rp</div>
                                            </div>
                                            <input class="form-control total_bayar" type="number" id="0" name="bayar" required>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th width="30%">Kembali</th>
                                    <td width="70%">
                                        <input type="hidden" name="kembali" class="kembali_form" value="0">
                                        <span class="total_kembali" id="0">Rp 0,-</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="form-group"  style="margin-top: 10px; text-align: center;">
                        <a href="transaksi_tambah.php" class="btn" style="color: black; background-color: #F08080; width: 120px;"><b><i class="fa fa-trash"></i> Batalkan</b></a>
                        <button class="btn" style="color: black; background-color: #ADD8E6; margin-left: 4px; width: 120px;"><i class="fa fa-check"></i><b> Proses</b> </button>
                    </div>
                </div>
            </div>
            <!-- AKHIR BARIS KEEMPAT PEMBAYARAN DILAKUKAN DISINI -->

    	</form>
    </div>
  </div>



</div>
<!-- akhir bagian content -->



<?php include ('footer.php'); ?>