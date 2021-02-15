<?php 
session_start();
include '../koneksi.php';

if( !isset($_SESSION['login']) ) {
  echo "<script>window.alert('Untuk Mengakses Halaman Dashboad, Anda Harus Login!'); window.location='login.php'</script>";
}

// jika ada get act
if( isset($_GET['act']) ) {

	// jika act = insert
	if( $_GET['act'] == 'insert' ) {
		// simpan inputan form ke variabel
		// ambil data dari tiap elemen dalam form
	    $nama_lengkap     = htmlspecialchars($_POST["nama_lengkap"]);
	    $username         = htmlspecialchars($_POST["username"]);
	    $password         = htmlspecialchars($_POST["password"]);
	    $level            = htmlspecialchars($_POST["level"]);

	    // apabila form belum lengkap
	    if( $nama_lengkap == '' || $username == '' || $_POST['password'] == '' || $level == '' ) {
	    	echo " <script>window.alert('Form Anda Belum Lengkap');";
	    }else {
	    	// proses simpan data
	    	$simpan = mysqli_query($koneksi, "INSERT INTO user (nama_lengkap, username, password, level) VALUES ('$nama_lengkap', '$username', '$password', '$level')");

	    	if( $simpan ) {
	    		echo " <script>window.alert('Data $nama_lengkap Berhasil Ditambahkan !'); window.location='user_data.php?d=sukses'</script>";
	    	}else {
	    		echo " <script>window.alert('Data $nama_lengkap Gagal Ditambahkan !'); window.location='user_data.php?d=gagal'</script>";
	    	}
	    }

	}elseif ( $_GET['act'] == 'update' ) { // jika act = update
		$id_user 		  = $_POST["id_user"];
		$nama_lengkap     = htmlspecialchars($_POST["nama_lengkap"]);
	    $username         = htmlspecialchars($_POST["username"]);
	    $password         = htmlspecialchars($_POST["password"]);
	    $level            = htmlspecialchars($_POST["level"]);

	    // apabila form belum lengkap
	    if( $nama_lengkap == '' || $username == '' || $level == '' ) {
	    	echo " <script>window.alert('Form Anda Belum Lengkap');";
	    }else {

	    	if( $_POST['password'] == '' ) {
	    		$update 	= mysqli_query($koneksi, "UPDATE user SET nama_lengkap = '$nama_lengkap', username = '$username', level = '$level' WHERE id_user = '$id_user'");

	    	}else {
	    		$update 	= mysqli_query($koneksi, "UPDATE user SET nama_lengkap = '$nama_lengkap', username = '$username', password = '$password', level = '$level' WHERE id_user = '$id_user'");
	    	}

	    	if( $update ) {
	    		echo " <script>window.alert('Data $nama_lengkap Berhasil Diubah !'); window.location='user_data.php?d=sukses'</script>";
	    	}else {
	    		echo " <script>window.alert('Data $nama_lengkap Gagal Diubah !'); window.location='user_data.php?d=gagal'</script>";
	    	}

	    }

	}elseif ($_GET['act'] == 'delete') { // jika act = delete
		$hapus 	= mysqli_query($koneksi, "DELETE FROM user WHERE id_user = '$_GET[id_user]' AND id_user!='1'");

		if( $hapus ) {
	    		echo "<script>window.alert('Data Berhasil Dihapus !'); window.location='user_data.php?d=sukses'</script>";
	    	}else {
	    		echo "<script>window.alert('Data Gagal Dihapus !'); window.location='user_data.php?d=gagal'</script>";
	    }

	}else { // jika act bukan insert, upate, atau delete
		header('Location: user_data.php');
	}

}else { // jika tidak ada get act
	header('Location: user_data.php');
}
?>