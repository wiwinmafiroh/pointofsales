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
		$kode_kategori 	= htmlspecialchars($_POST["kode_kategori"]);
		$nama_kategori 	= htmlspecialchars($_POST["nama_kategori"]);

		if( $kode_kategori == '' || $nama_kategori == '' ) {
			echo " <script>window.alert('Form Anda Belum Lengkap'); window.location'kategori_data.php?view=tambah&d=bl'";
		}else {
			//proses query simpan data
			$simpan 	= mysqli_query($koneksi, 
							"INSERT INTO kategori 
								(kode_kategori, nama_kategori) VALUES 
								('$kode_kategori', '$nama_kategori')");
			if( $simpan ) {
				echo " <script>window.alert('Kategori $nama_kategori Berhasil Ditambahkan !'); window.location='kategori_data.php?d=sukses'</script>";
			}else {
				echo " <script>window.alert('Kategori $nama_kategori Gagal Ditambahkan !'); window.location='kategori_data.php?d=gagal'</script>";
			}
		}

	}elseif( $_GET['act'] == 'update' )  { // jika act update
		// proses menyimpan data
		// menyimpan kiriman form ke variabel
		$kode_kategori 	= htmlspecialchars($_POST["kode_kategori"]);
		$nama_kategori 	= htmlspecialchars($_POST["nama_kategori"]);

		if( $kode_kategori == '' || $nama_kategori == '' ) {
			echo " <script>window.alert('Form Anda Belum Lengkap'); window.location'kategori_data.php?view=tambah&d=bl'";
		}else {
			$update 	= mysqli_query($koneksi, 
							"UPDATE kategori 
							SET nama_kategori = '$nama_kategori' WHERE kode_kategori = '$kode_kategori'");

			if( $update ) {
				echo " <script>window.alert('Kategori $nama_kategori Berhasil Diupdate !'); window.location='kategori_data.php?d=sukses'</script>";
			}else {
				echo " <script>window.alert('Kategori $nama_kategori Gagal Diupdate !'); window.location='kategori_data.php?d=gagal'</script>";
			}
		}

	}elseif( $_GET['act'] == 'delete' ) {// jika act del
		$hapus		= mysqli_query($koneksi, 
						"DELETE FROM kategori 
						WHERE kode_kategori = '$_GET[kode_kategori]'");

		if( $hapus ) {
	    		echo "<script>window.alert('Data Berhasil Dihapus !'); window.location='kategori_data.php?d=sukses'</script>";
	    	}else {
	    		echo "<script>window.alert('Data Gagal Dihapus !'); window.location='kategori_data.php?d=gagal'</script>";
	    }
	}

}
?>