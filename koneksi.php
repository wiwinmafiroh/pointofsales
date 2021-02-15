<?php 


$koneksi = mysqli_connect("localhost", "root", "", "pointofsales");


// Cek connection apakah koneksi gagal atau tidak
if (mysqli_connect_errno()) {
	// kalau gagal akan menampilkan pesan koneksi gagal dan kenapa koneksi gagal
	echo "Koneksi Database Gagal : " . mysqli_connect_error();
}

?>