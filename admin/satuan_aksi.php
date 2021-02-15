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
		$kode_satuan 	= htmlspecialchars($_POST["kode_satuan"]);
		$nama_satuan 	= htmlspecialchars($_POST["nama_satuan"]);

		if( $kode_satuan == '' || $nama_satuan == '' ) {
			echo " <script>window.alert('Form Anda Belum Lengkap'); window.location'satuan_data.php?view=tambah&d=bl'";
		}else {
			//proses query simpan data
			$simpan 	= mysqli_query($koneksi, 
							"INSERT INTO satuan
								(kode_satuan, nama_satuan) VALUES 
								('$kode_satuan', '$nama_satuan')");
			if( $simpan ) {
				echo " <script>window.alert('Satuan $nama_satuan Berhasil Ditambahkan !'); window.location='satuan_data.php?d=sukses'</script>";
			}else {
				echo " <script>window.alert('Satuan $nama_satuan Gagal Ditambahkan !'); window.location='satuan_data.php?d=gagal'</script>";
			}
		}

	}elseif( $_GET['act'] == 'update' )  { // jika act update
		// proses menyimpan data
		// menyimpan kiriman form ke variabel
		$kode_satuan 	= htmlspecialchars($_POST["kode_satuan"]);
		$nama_satuan 	= htmlspecialchars($_POST["nama_satuan"]);

		if( $kode_satuan == '' || $nama_satuan == '' ) {
			echo " <script>window.alert('Form Anda Belum Lengkap'); window.location'satuan_data.php?view=tambah&d=bl'";
		}else {
			$update 	= mysqli_query($koneksi, 
							"UPDATE satuan 
							SET nama_satuan = '$nama_satuan' WHERE kode_satuan = '$kode_satuan'");

			if( $update ) {
				echo " <script>window.alert('Satuan $nama_satuan Berhasil Diupdate !'); window.location='satuan_data.php?d=sukses'</script>";
			}else {
				echo " <script>window.alert('Satuan $nama_satuan Gagal Diupdate !'); window.location='satuan_data.php?d=gagal'</script>";
			}
		}

	}elseif( $_GET['act'] == 'delete' ) {// jika act del
		$hapus		= mysqli_query($koneksi, 
						"DELETE FROM satuan 
						WHERE kode_satuan = '$_GET[kode_satuan]'");

		if( $hapus ) {
	    		echo "<script>window.alert('Data Berhasil Dihapus !'); window.location='satuan_data.php?d=sukses'</script>";
	    	}else {
	    		echo "<script>window.alert('Data Gagal Dihapus !'); window.location='satuan_data.php?d=gagal'</script>";
	    }
	}

}
?>