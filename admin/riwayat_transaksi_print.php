<?php 
include '../koneksi.php';
date_default_timezone_set('Asia/Jakarta');

session_start();
if($_SESSION['level'] != "Admin" ) {
  echo "<script>window.alert('Untuk Mengakses Halaman Dashboad Admin, Anda Harus Login Sebagai Admin!'); window.location='../index.php'</script>";
}


?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Cetak Riwayat Transaksi</title>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
</head>
<body style="padding: 30px; font-size: 23px;">

	<center>
		<img src="../img/icon.png" style="width: 20%; height: 20%;">
		<h2>Angkringan Lek'Tok</h2>
		<p>Jl. Mutiara Gading City No.83, <br>Babelan Kota, Kec. Babelan, Bekasi, Jawa Barat 17610 <br>Telepon: 0821-1124-1424</p>
	</center>
	<br>

	<center>
		<h2>RIWAYAT TRANSAKSI</h2>
    	<br> 
	</center>

	<?php 
	if($_GET['id']) { ?>

	<?php 
	include "../koneksi.php";
		$id 		= $_GET['id'];
		$penjualan 	= mysqli_query($koneksi,"SELECT penjualan.*, user.id_user, user.nama_lengkap 
												FROM penjualan 
												INNER JOIN user ON penjualan.id_user = user.id_user 
												WHERE id_penjualan = '$id'"
									);

		while($p = mysqli_fetch_array($penjualan)) : ?>

			<div class="row">
				<div class="col-lg-4">
					<table class="table table-borderless">
						<tr>
							<th>Nota</th>
							<th>:</th>
							<td><?= $p['nota']; ?></td>
						</tr>

						<tr>
							<th>Tanggal Pembelian</th>
							<th>:</th>
							<td><?= date('d M Y', strtotime($p['tanggal_penjualan'])); ?></td>
						</tr>

						<tr>
							<th>Pembeli</th>
							<th>:</th>
							<td><?= $p['nama_customer']; ?></td>
						</tr>

						<tr>
							<th width="30%;">Kasir</th>
							<th width="1%">:</th>
							<td><?= $p['nama_lengkap']; ?></td>
						</tr>
					</table>					
				</div>
			</div>
			<br>

			<h5><b>Daftar Pembelian</b></h5>

			<table class="table table-bordered table-striped table-hover" id="table-pembelian"> 
				<thead>
					<tr>
						<th width="20%">Kode Menu</th>
						<th width="30">Nama Menu</th>
						<th width="20%" style="text-align: center;">Harga</th>
						<th width="10%" style="text-align: center;">Quantity</th>
						<th width="20%" style="text-align: center;">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$id_penjualan 	  = $p['nota'];
					$paftar_penjualan = mysqli_query($koneksi,"
											SELECT menu.kode_menu, menu.nama_menu, kategori.kode_kategori, kategori.nama_kategori, transaksi.harga, transaksi.quantity, transaksi.total_transaksi 
											FROM transaksi 
											INNER JOIN menu ON transaksi.kode_menu = menu.kode_menu 
											INNER JOIN kategori ON menu.kode_kategori = kategori.kode_kategori 
											WHERE nota='$id_penjualan'");

				while($pp = mysqli_fetch_assoc($paftar_penjualan)) : ?>
							<td><?php echo $pp['kode_menu']; ?></td>
							<td>
								<?php echo $pp['nama_menu']; ?>
								<br>
								<small class="text-muted"><?php echo $pp['nama_kategori']; ?></small>
							</td>
							<td style="text-align: center;"><?php echo "Rp ".number_format($pp['harga']).","; ?></td>  
							<td style="text-align: center;"><?php echo $pp['quantity']; ?></td>
							<td style="text-align: center;"><?php echo "Rp ".number_format($pp['total_transaksi']).","; ?></td>  
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
			<br>

			<h5><b>Pembayaran</b></h5>
			<div class="row">

				<div class="col-md-6">
					<table class="table table-bordered table-striped">
						<tr>
							<th>Sub Total</th>
							<td>
								<span class="sub_total_pembelian"><?= "Rp ".number_format($p['sub_total_penjualan']).","; ?></span>
							</td>
						</tr>
						<tr>
							<th>Diskon</th>
							<td>
								<?php echo $p['diskon_penjualan'] ?>%
							</td>
						</tr>
						<tr>
							<th>Total</th>
							<td>
								<span class="total_pembelian"><?= "Rp ".number_format($p['total_penjualan']).","; ?></span>
							</td>
						</tr>
					</table>
				</div>


				<div class="col-md-6">
				<table class="table table-bordered table-striped">
                    <tr>
                        <th>Bayar</th>
                        <td>
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
			<br>

		<?php endwhile; ?>

	<?php  
	} else {
	?>

		<div class="alert alert-info text-center">
			Silahkan Filter Laporan Terlebih Dulu.
		</div>

	<?php } ?>


	<script>
		window.print();
		$(document).ready(function(){

		});
	</script>


</body>
</html>
