<?php 
include '../koneksi.php';
date_default_timezone_set('Asia/Jakarta');

session_start();
if($_SESSION['level'] != "Admin" ) {
  echo "<script>window.alert('Untuk Mengakses Halaman Dashboad Admin, Anda Harus Login Sebagai Admin!'); window.location='../index.php'</script>";
}


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link href="../assets/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="../assets/datatables/buttons.dataTables.min.css" rel="stylesheet">
    
    <!-- My Fonts -->
    <link rel="stylesheet" type="text/css" href="../fontawesome-free/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">

    <!-- My Icon -->
    <link href="../img/icon.png" rel="icon">

    <!-- My Css -->
    <link rel="stylesheet" type="text/css" href="../dashboard.css">

    <title>Laporan Penjualan</title>
  </head>
  <body>



  <style type="text/css">
    .table-tanggal tr th, .table-tanggal tr td{
      padding: 5px;
    }
  </style>

  <center>
    <img src="../img/icon.png" style="width: 20%; height: 20%;">
    <h2>Angkringan Lek'Tok</h2>
    <p>Jl. Mutiara Gading City No.83, <br>Babelan Kota, Kec. Babelan, Bekasi, Jawa Barat 17610 <br>Telepon: 0821-1124-1424</p>

    <br>  
    <br>  
    <h2>LAPORAN PENJUALAN ANGKRINGAN LEK'TOK</h2>
    <br>  
  </center>


  <?php 
  if(isset($_GET['tanggal_sampai']) && isset($_GET['tanggal_dari'])){
    $tgl_dari = $_GET['tanggal_dari'];
    $tgl_sampai = $_GET['tanggal_sampai'];
    ?>

    <div class="row"  style="margin-left: -15px;">
      <div class="col-lg-5">
        <table class="table">
          <tr>
            <td style="font-size: 20px; width: 230px; border: none">Dari Tanggal</td>
            <td style="width: 1px; border: none; font-size: 20px;">:</td>
            <td style="border: none; font-size: 20px;"><?= date("d M Y", strtotime($tgl_dari)); ?></td>
          </tr>
          <tr>
            <td style="font-size: 20px; width: 230px; border: none;">Sampai Tanggal</td>
            <td style="width: 1px; border: none; font-size: 20px;">:</td>
            <td style="border: none; font-size: 20px;"><?= date("d M Y", strtotime($tgl_sampai)); ?></td>
          </tr>
        </table>
      </div>
    </div>

    <br>

    <table class="table table-bordered table-striped">
      <thead>
        <tr style="font-size: 17px;">
          <th width="1%" class="text-center">No</th>
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
          <tr style="font-size: 17px;">
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
        <tr class="bg-info">
          <td colspan="4" class="text-right"><b>TOTAL</b></td>
          <td class="text-center"><?php echo "Rp ".number_format($x_total_sub_total).","; ?></td>
          <td class="text-right"></td>
          <td class="text-right"><?php echo "Rp ".number_format($x_total_total).","; ?></td>
          <td class="text-right"><?php echo "Rp ".number_format($x_total_modal).","; ?></td>
          <td class="text-right"><?php echo "Rp ".number_format($x_total_laba).","; ?></td>
        </tr>
      </tfoot>
    </table>


    <?php 
  }else{
    ?>

    <div class="alert alert-info text-center">
      Silahkan Filter Laporan Terlebih Dulu.
    </div>

    <?php
  }
  ?>



  <script>
    window.print();
    $(document).ready(function(){

    });
  </script>

 </body>
 </html>
