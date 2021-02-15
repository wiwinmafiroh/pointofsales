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
		$kode_kategori 	= $_POST["kode_kategori"];
		$nama_menu 		= $_POST["nama_menu"]; 
		$harga_jual 	= $_POST["harga_jual"];
		$harga_modal	= $_POST["harga_modal"];
		$stok 			= "0";
		$kode_satuan 	= $_POST["kode_satuan"];
		$gambar 		= $_FILES["gambar"];
		$ekstensi_diperbolehkan	= array('png','jpg','jpeg');
		$nama 					= $_FILES['gambar']['name'];
		$x 						= explode('.', $nama);
		$ekstensi 				= strtolower(end($x));
		$ukuran					= $_FILES['gambar']['size'];
		$file_tmp 				= $_FILES['gambar']['tmp_name'];	

		// generate nama gambar baru biar ga sama ceunah
		$nama			= uniqid();
		$nama		   .= '.';
		$nama          .= $ekstensi;

		if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
			if($ukuran < 1044070){			
				move_uploaded_file($file_tmp, '../img/upload/menu/'. $nama);
				$query = "INSERT INTO menu VALUES ('$kode_menu', '$kode_kategori', '$nama_menu', '$harga_jual', '$harga_modal', '$stok', '$kode_satuan', '$nama')";
				$input = mysqli_query($koneksi, $query);
				if($query){
					echo "<script>window.alert('Menu $nama_menu Berhasil Ditambahkan !'); window.location='menu_data.php?d=sukses'</script>";
				}else {
					echo "<script>window.alert('Menu $nama_menu Gagal Ditambahkan !'); window.location='menu_data.php?d=gagal'</script>";
				}

			}else {
					echo 'UKURAN FILE TERLALU BESAR';
			}

		}else{
		echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
		}
		
	}elseif( $_GET['act'] == 'update' )  { // jika act update
				// proses menyimpan data
		// menyimpan kiriman form ke variabel
		$kode_menu 		= $_POST["kode_menu"];
		$nama_menu 		= $_POST["nama_menu"]; 
		$harga_jual 	= $_POST["harga_jual"];
		$harga_modal	= $_POST["harga_modal"];
		$stok 			= $_POST["stok"];
		$gambarlama 	= $_POST["gambarlama"];

		// cek apakah user pilih gambar baru atau tidak
		if( $_FILES['gambar']['error'] === 4 ) {
			$gambar = $gambarlama;
			$update = mysqli_query($koneksi, 
							"UPDATE menu 
							SET nama_menu 		= '$nama_menu',
								harga_jual 		= '$harga_jual', 
								harga_modal 	= '$harga_modal', 
								stok 			= '$stok',
								gambar 			= '$gambarlama'
							WHERE kode_menu = '$kode_menu'");
				if($update){
					echo "<script>window.alert('Menu $nama_menu Berhasil Di Update !'); window.location='menu_data.php?d=sukses'</script>";
				}else {
					echo "<script>window.alert('Menu $nama_menu Gagal Di Update !'); window.location='menu_data.php?d=gagal'</script>";
				}
		}else {
			$kode_menu 		= $_POST["kode_menu"];
			$nama_menu 		= $_POST["nama_menu"]; 
			$harga_jual 	= $_POST["harga_jual"];
			$harga_modal	= $_POST["harga_modal"];
			$stok 			= $_POST["stok"];
			$gambar 		= $_FILES["gambar"];
			$ekstensi_diperbolehkan	= array('png','jpg','jpeg');
			$gambarbaru 			= $_FILES['gambar']['name'];
			$x 						= explode('.', $gambarbaru);
			$ekstensi 				= strtolower(end($x));
			$ukuran					= $_FILES['gambar']['size'];
			$file_tmp 				= $_FILES['gambar']['tmp_name'];	

			// generate nama gambar baru biar ga sama ceunah
			$gambarbaru			= uniqid();
			$gambarbaru		   .= '.';
			$gambarbaru        .= $ekstensi;

			if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
			if($ukuran < 1044070){			
				move_uploaded_file($file_tmp, '../img/upload/menu/'. $gambarbaru);
				$update 	= mysqli_query($koneksi, 
							"UPDATE menu 
							SET nama_menu 		= '$nama_menu', 
								harga_jual 		= '$harga_jual', 
								harga_modal 	= '$harga_modal', 
								stok 			= '$stok',
								gambar 			= '$gambarbaru'
							WHERE kode_menu = '$kode_menu'");
				if($update){
					echo "<script>window.alert('Menu $nama_menu Berhasil Di Update !'); window.location='menu_data.php?d=sukses'</script>";
				}else {
					echo "<script>window.alert('Menu $nama_menu Gagal Di Update !'); window.location='menu_data.php?d=gagal'</script>";
				}

			}else {
					echo 'UKURAN FILE TERLALU BESAR';
			}

		}else{
		echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
		}
		}
		
	}elseif( $_GET['act'] == 'delete' ) {// jika act del
		$hapus		= mysqli_query($koneksi, 
						"DELETE FROM menu
						WHERE kode_menu = '$_GET[kode_menu]'");

		if( $hapus ) {
	    		echo "<script>window.alert('Menu Berhasil Dihapus !'); window.location='menu_data.php?d=sukses'</script>";
	    	}else {
	    		echo "<script>window.alert('Menu Gagal Dihapus !'); window.location='menu_data.php?d=gagal'</script>";
	    }
	}

}
?>