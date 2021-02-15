<?php  
session_start();
include '../koneksi.php';

if( !isset($_SESSION['login']) ) {
  echo "<script>window.alert('Untuk Mengakses Halaman Dashboad, Anda Harus Login!'); window.location='login.php'</script>";
}

// jika ada get act
if( isset($_GET['act']) ) {

	// jika act insert
	if( $_GET['act'] == 'insert' ) {
		// proses menyimpan data
		// menyimpan kiriman form ke variabel
		$kode_menu 		= $_POST["kode_menu"];
		$tambah_stok	= $_POST["tambah_stok"];
		$sisa 			= mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM menu WHERE kode_menu='$kode_menu'"));
		$tambah_stok	= $sisa['stok']+$tambah_stok;

		if( $kode_menu == '' || $tambah_stok == '' ) {
			echo " <script>window.alert('Form Anda Belum Lengkap'); window.location'stok_data.php?view=tambah&d=bl'";
		}else {
			//proses query simpan data
			$simpan 	= mysqli_query($koneksi, 
							"UPDATE menu 
								SET stok = '$tambah_stok' WHERE kode_menu = '$kode_menu'");

			if( $simpan ) {
				echo " <script>window.alert('Penambahan Stok Berhasil. Saat ini Stok $tambah_stok !'); window.location='stok_data.php?d=sukses'</script>";
			}else {
				echo " <script>window.alert('Penambahan Stok Gagal. Saat ini Sisa $tambah_stok !'); 
					window.location='stok_data.php?d=gagal'</script>";
			}
		}

	}
}
?>