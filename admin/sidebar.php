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

    <!-- JQuery UI -->
    <link rel="stylesheet" type="text/css" href="../js/jquery-ui/jquery-ui.css">

    <!-- Data Tables -->
    <link href="../DataTables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="../DataTables/datatables/buttons.dataTables.min.css" rel="stylesheet">
    
    <!-- My Fonts -->
    <link rel="stylesheet" type="text/css" href="../fontawesome-free/css/all.min.css">
    
    <!-- My Icon -->
    <link href="../img/icon.png" rel="icon">

    <!-- My Css -->
    <link rel="stylesheet" type="text/css" href="../css/dashboard.css">

    <title>Dashboard Angkringan Lek'Tok</title>
  </head>
  <body>
    
    <!-- PEMBUNGKUS UTAMA -->
    <div class="wrapper">

    <!-- BAGIAN SIDEBAR -->
    <!-- BAGIAN SIDEBAR -->
        <!-- Pembungkus Bagian Sidebar -->
        <nav id="sidebar">
            <!-- Group Pertama -->
            <a class="navbar-brand" href="#">
            </a>

            <!-- Group Kedua -->
            <ul class="list-unstyled components">
                <h4><?= $_SESSION['nama_lengkap']; ?></h4>
                <br>
                <small><?= $_SESSION['level']; ?></small>
                <br>
                <img src="../img/icon.png" width="1%" class="rounded-circle">
                

                <!-- 1 -->
                <li class="menu atas">
                  <a href="dashboard.php"><i class="fas fa-tachometer-alt fa-lg"></i>Dashboard</a>
                </li>

                <?php if( $_SESSION['level'] == 'Admin' ) { ?>
                <!-- 2 -->
                <li class="menu">
                  <a href="user_data.php"><i class="fas fa-user-friends fa-lg"></i>User</a>
                </li>

                <!-- 3 -->
                <li class="menu">
                  <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-th-list fa-lg"></i>Kelola Menu</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                      <li>
                        <a href="kategori_data.php"><i class="far fa-circle fa-xs"></i>Kategori</a>
                      </li>
                      <li>
                        <a href="satuan_data.php"><i class="far fa-circle fa-xs"></i>Satuan</a>
                      </li>
                      <li>
                        <a href="menu_data.php"><i class="far fa-circle fa-xs"></i>Menu</a>
                      </li> 
                    </ul>
                </li>

                <!-- 1 -->
                <li class="menu">
                  <a href="stok_data.php"><i class="fa fa-plus"></i>Manajemen Stok</a>
                </li>
                <?php } ?>

                <?php if( $_SESSION['level'] == 'Kasir' ) { ?>
                <!-- 4 --> 
                <li class="menu">
                  <a href="penjualan.php"><i class="fas fa-cash-register fa-lg"></i>Transaksi Penjualan</a>
                </li>
                <?php } ?>

                <!-- 1 -->
                <li class="menu">
                  <a href="riwayat_transaksi.php"><i class="fas fa-chart-line fa-lg"></i>Riwayat Transaksi</a>
                </li>

                <?php if( $_SESSION['level'] == 'Admin' ) { ?>
                <li class="menu">
                  <a href="Laporan.php"><i class="fas fa-file-alt fa-lg"></i>Laporan</a>
                </li>
                <?php } ?>
            </ul>
        </nav>
        <!-- Akhir Pembungkus Bagian Sidebar -->
    <!-- AKHIR BAGIAN SIDEBAR -->
    <!-- AKHIR BAGIAN SIDEBAR -->





    <!-- BAGIAN NAVBAR DAN CONTENT -->
    <!-- BAGIAN NAVBAR DAN CONTENT -->
        <!-- Pembungkus Bagian Navbar dan Content -->
        <div class="content">
            <!-- bagian navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-navbar fixed-top">

                <!-- icon sembunyi -->
                <h4 class="judulatas" mt-5>Angkringan Lek'Tok</h4>
                <button type="button" id="sidebarcollapse" class="btn btn-garis">
                  <i class="fa fa-align-justify"></i> <span></span>
                </button>

                <!-- icon keluar, pemberitahuan, pesan -->
                <div class="icon ml-auto">
                  <h5>
                    <a href="../logout.php"><i class="fas fa-sign-out-alt mr-3 pt-2" data-toggle="tooltip" title="Sign Out" style="color: white;"></i></a>
                  </h5>
                </div>
              
            </nav>
            <!-- akhir bagian navbar -->


