<?php 
include '../koneksi.php';
session_start();
// ambil data untuk dimasukkan ke tabel penjualan
$nota 			= $_POST['nota'];
$tanggal		= $_POST['tanggal'];
$nama_customer 	= $_POST['nama_customer'];
$sub_total 		= $_POST['sub_total'];
$diskon 		= $_POST['diskon'];
$total 			= $_POST['total'];
$dibayar 		= $_POST['bayar'];
$kembali 		= $_POST['kembali'];
$kasir 			= $_SESSION['id_user'];

// insert ke table penjualan
mysqli_query($koneksi, "INSERT INTO penjualan 
						VALUES(NULL, '$nota', '$tanggal', '$nama_customer', 
									 '$sub_total', '$diskon', '$total', 
									 '$dibayar', '$kembali', '$kasir')")
						or die(mysqli_errno($koneksi));


// ambil data untuk dimasukkan ke table transaksi dan untuk mengurangi stok juga (btw ngambilnya di table yang di JS)
$id_penjualan 	 = mysqli_insert_id($koneksi);
$menu 		     = $_POST['menu'];
$harga 		  	 = $_POST['harga'];
$quantity 	     = $_POST['quantity'];
$total_transaksi = $_POST['total_transaksi'];

$jumlah_pembelian= count($menu);

for($a=0;$a<$jumlah_pembelian;$a++){

	$t_menu		 = $menu[$a];
	$t_harga  	 = $harga[$a];
	$t_jumlah    = $quantity[$a];
	$t_total     = $total_transaksi[$a];

	// ambil jumlah produk
	$detail        = mysqli_query($koneksi, "SELECT * FROM menu WHERE kode_menu='$t_menu'");
	$de            = mysqli_fetch_assoc($detail);
	$jumlah_menu   = $de['stok'];

	// kurangi jumlah produk
	$jp = $jumlah_menu - $t_jumlah;
	mysqli_query($koneksi, "UPDATE menu SET stok='$jp' WHERE kode_menu='$t_menu'");

	// simpan data TRANSAKSI
	mysqli_query($koneksi, "INSERT INTO transaksi 
							VALUES(NULL,'$nota','$t_menu','$t_harga','$t_jumlah','$t_total')")
							or die(mysqli_errno($koneksi));

}


header("location:transaksi_riwayat.php?alert=sukses");