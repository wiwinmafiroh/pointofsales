<?php include ('sidebar.php'); ?>



<!-- bagian content -->
<div class="col-md users">

    <h5>RIWAYAT TRANSAKSI</h5>
    <div class="card cardaksi">
      <div class="card-body">
        <table class="table table-striped table-bordered" id="datatable">
          <thead>
            <tr>
              <th style="text-align: center;">No</th>
              <th>Nota</th>
              <th>Tanggal</th>
              <th>Pembeli</th>
              <th>Kasir</th>
              <th>Total Bayar</th>
              <th style="text-align: center;">Opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no       = 1;
            $id_user  = $_SESSION['id_user'];
            $penjualan= mysqli_query($koneksi,
                          "SELECT penjualan.*, user.id_user, user.nama_lengkap 
                              FROM penjualan 
                              INNER JOIN user ON penjualan.id_user = user.id_user 
                              ORDER BY id_penjualan DESC");

            while($p = mysqli_fetch_array($penjualan)) { ?>

              <tr>
                <td style="text-align: center;"><?= $no++; ?></td>
                <td><?= $p['nota']; ?></td>
                <td><?= date('d-m-Y', strtotime($p['tanggal_penjualan'])); ?></td>
                <td><?= $p['nama_customer']; ?></td>
                <td><?= $p['nama_lengkap']; ?></td>
                <td style="text-align: right;"><?= "Rp ".number_format($p['total_penjualan']).","; ?></td>
                <td style="text-align: center;">

                  <div class="btn-group">

                    <!-- munculkan detail penjualan -->
                    <button type="button" class="btn" data-toggle="modal" style="color: black; margin-bottom: 5px; width: 30%; border-radius: 4px; background-color: #ADD8E6; margin-right: 7px;" data-target="#detail_riwayat_transaksi_<?= $p['id_penjualan'] ?>">
                       <i class="fa fa-search"></i>
                    </button>

                    <a target="_blank" class="btn" style="color: black; margin-bottom: 5px; width: 30%; border-radius: 4px; background-color: #AFEEEE; margin-right: 7px;" href="riwayat_transaksi_print.php?id=<?= $p['id_penjualan']; ?>">
                      <i class="fa fa-file"></i>
                    </a>

                  </div>

                    <div class="modal fade" id="detail_riwayat_transaksi_<?= $p['id_penjualan'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">

                          <div class="modal-content">
                            
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalScrollableTitle">Detail Transaksi</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>

                            <div class="modal-body">

                              <div class="row">
                                <div class="col-md-12">
                                  <label><b>Kasir</b></label>
                                  <br>
                                  <?= $p['nama_lengkap']; ?>
                                </div>
                                <br>
                                <br>
                                <br>

                                <div class="col-md-4">
                                  <label><b>Nota</b></label>
                                  <br>
                                  <?= $p['nota']; ?>
                                </div>

                                <div class="col-md-4">
                                  <label><b>Tanggal Transaksi</b></label>
                                  <br>
                                  <?= date('d-m-Y', strtotime($p['tanggal_penjualan'])); ?>
                                </div>

                                <div class="col-md-4">
                                  <label><b>Pembeli</b></label>
                                  <br>
                                  <?= $p['nama_customer']; ?>
                                </div>
                              </div>
                              <hr>



                              <div class="row">
                                <b>Daftar Pembelian</b>

                                <div class="col-md-12">
                                <table class="table table-bordered table-striped table-hover" id="table-pembelian">
                                  <thead>
                                    <tr style="background-color: white !important;">
                                      <th width="18%">Kode Menu</th>
                                      <th>Nama Menu</th>
                                      <th width="1%" style="text-align: center;">Harga</th>
                                      <th width="1%" style="text-align: center;">Quantity</th>
                                      <th width="1%" style="text-align: center;">Total</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php  
                                    $id_penjualan     = $p['nota'];
                                    $penjualan_modals = mysqli_query($koneksi,
                                                          "SELECT menu.kode_menu, menu.nama_menu, kategori.kode_kategori, kategori.nama_kategori, transaksi.harga, transaksi.quantity, transaksi.total_transaksi 
                                                          FROM transaksi INNER JOIN menu ON menu.kode_menu = transaksi.kode_menu
                                                          INNER JOIN kategori ON menu.kode_kategori = kategori.kode_kategori 
                                                          WHERE nota='$id_penjualan'");
                                    while ( $pm = mysqli_fetch_assoc($penjualan_modals)) { ?>
                                      <tr>
                                        <td><?= $pm['kode_menu']; ?></td>
                                        <td style="text-align: left; width: 1000px;"><?= $pm['nama_menu']; ?>
                                          <br>
                                          <small class="text-muted"><?= $pm['nama_kategori']; ?></small>
                                        </td>
                                        <td style="text-align: center;"><?= "Rp ".number_format($pm['harga']).","; ?></td>  
                                        <td style="text-align: center;"><?= $pm['quantity']; ?></td>
                                        <td style="text-align: center;"><?= "Rp ".number_format($pm['total_transaksi']).","; ?></td>  
                                      </tr>
                                      <?php } ?>
                                  </tbody>
                                </table>
                                </div>

                              </div>



                              <div class="row">
                                <b>Pembayaran</b>
                              </div>

                              <div class="row">
                                  <div class="col-md-6">
                                  <table class="table table-bordered table-striped">
                                    <tr>
                                      <th style="width: 30%; background-color: #F5DEB3 !important;">Sub Total</th>
                                      <td style="width: 70%; background-color: #F5DEB3 !important;">
                                        <span class="sub_total_pembelian"><?= "Rp ".number_format($p['sub_total_penjualan']).","; ?></span>
                                      </td>
                                    </tr>

                                    <tr>
                                      <th>Diskon</th>
                                      <td>
                                        <?= $p['diskon_penjualan'] ?>%
                                      </td>
                                    </tr>

                                    <tr>
                                      <th style="background-color: #F5DEB3 !important;">Total</th>
                                      <td style="background-color: #F5DEB3 !important;">
                                        <span class="total_pembelian"><?= "Rp ".number_format($p['total_penjualan']).","; ?></span>
                                      </td>
                                    </tr>
                                  </table>
                                  </div>

                                  <div class="col-md-6">
                                  <table class="table table-bordered table-striped">
                                    <tr>
                                        <th style="width: 30; background-color: #F5DEB3 !important;">Bayar</th>
                                        <td style="width: 70; background-color: #F5DEB3 !important;">
                                          <?= "Rp ".number_format($p['dibayar']).","; ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Kembali</th>
                                        <td>
                                            <span class="total_kembali"><?= "Rp ".number_format($p['kembali']).","; ?></span>
                                        </td>
                                    </tr>
                                  </table>
                                </div>
                              </div>
                              </div>



                            </div>

                          </div>
                      </div>
                      
                </td>
              </tr>
              <?php  
              }
              ?>
            </tbody>
        </table>
      </div>
    </div>

</div>
<!-- akhir bagian content -->



<?php include ('footer.php'); ?>