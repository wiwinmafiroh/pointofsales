<!-- SCRIPT UNTUK MEMBUAT FORM LOGIN BERFUNGSI -->
<?php
// mengaktifkan session pada PHP
session_start();

// menghubungkan php dengan koneksi database
include "koneksi.php";

// mengecek apakah ada request post / kalau tombol submit di klik akan dilakukan proses
if( $_SERVER["REQUEST_METHOD"] == "POST" ) {
$username   = $_POST["username"]; // tampung data yang dikirim
$password   = $_POST["password"];

  if( $username == '' || $password == '' ) { // cek apakah username / password kosong
    echo "<script>window.alert('Warning! Form Anda Belum Lengkap!')</script>"; // tampilkan pesan
  }else { // ketika datanya sudah lengkap, maka dicek
    $login  = mysqli_query($koneksi, 
              "SELECT * FROM user WHERE 
                username = '$username' AND 
                password = '$password' ");
    $jml    = mysqli_num_rows($login);

    if( $jml > 0 ) { // kalau hasil cek nya ketemu atau > 0
      
      $data   = mysqli_fetch_array($login);

      // cek jika user login sebagai Admin
      if( $data['level'] == "Admin" ) {
        // buat session login dan username
        $_SESSION['login']              = TRUE;
        $_SESSION['id_user']            = $data['id_user'];
        $_SESSION['nama_lengkap']       = $data['nama_lengkap'];
        $_SESSION['username']           = $username;
        $_SESSION['password']           = $password;
        $_SESSION['level']              = "Admin";
        // alihkan ke halaman dashboard Admin
        echo "<script>window.alert('Selamat, Anda Berhasil Login Sebagai Admin!'); window.location='admin/dashboard.php'</script>";

      // cek jika user login sebagai Kasir
      }elseif ( $data['level'] == "Kasir" ) {
        // buat session login dan username
        $_SESSION['login']              = TRUE;
        $_SESSION['id_user']            = $data['id_user'];
        $_SESSION['nama_lengkap']       = $data['nama_lengkap'];
        $_SESSION['username']           = $username;
        $_SESSION['password']           = $password;
        $_SESSION['level']              = "Kasir";
        // alihkan ke halaman dashboar Kasir
        echo "<script>window.alert('Selamat, Anda Berhasil Login Sebagai Kasir!'); window.location='kasir/dashboard.php'</script>";

      }else {
        // alihkan ke halaman login kembali
        echo "<script>window.alert('Username atau Password Anda Tidak Cocok!');</script>"; // maka akan tampil alert.
      }
    }else {
      // alihkan ke halaman login kembali
        echo "<script>window.alert('Username atau Password Anda Tidak Cocok!');</script>"; // maka akan tampil alert.
    }
  }
}
?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <!-- My Fonts -->
    <link rel="stylesheet" type="text/css" href="fontawesome-free/css/all.min.css">

    <!-- My Icon -->
    <link href="img/icon.png" rel="icon">

    <!-- My Css -->
    <style type="text/css">
      hr {
        width: 190px;
        border-top: 3px solid brown;
      }

      .bodylogin {
        background-color: #DEB887;
      }

      .login {
        margin-top: 13%;
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        width: 90%;
        padding: 20px;
        background-color: #FAEBD7;
      }

      .login hr {
        width: 50%;
        border: 1px solid brown;
      }

      .formlogin button {
        width: 49%;
      }

      /* DESKTOP VERSION */
      @media (min-width: 992px) {
      .login {
        width: 30%;
        margin-top: 4%;
        box-shadow: 0 3px 20px rgba(0,0,0,0.3);
        padding: 40px;
      }

      .login hr {
        width: 100%;
        border: 1px solid brown;
      }

      .formlogin button {
        width: 49%;
      }
      }
    </style>

    <title>Login Angkringan Lek'Tok</title>
  </head>
  <body class="bodylogin">
    <!-- LOGO DAN TULISAN -->
    <div class="container login">
      <div class="row">
        <div class="col text-center">
          <img src="img/icon.png" class="img.circle mb-3" alt="Logo" width="140px;">
          <h5>LOGIN APLIKASI POS</h5>
          <hr>
        </div>
      </div>
    <!-- AKHIR LOGO DAN TULISAN -->      



    <!-- FORM LOGIN -->
      <form action="" method="post" role="form" class="formlogin">
        <!-- Username -->
        <div class="form-group">
          <label>Username</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fas fa-user"></i></div>
            </div>
            <input type="text" name="username" class="form-control" placeholder="Masukkan Username Anda">
          </div>
        </div>

        <!-- Password -->
        <div class="form-group">
          <label>Password</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fas fa-unlock-alt"></i></div>
            </div>
            <input type="password" name="password" class="form-control" placeholder="Masukkan Password Anda">
          </div>
        </div>

        <!-- Button -->
        <button type="submit" class="btn btn-primary" value="submit">SUBMIT</button>
        <button type="reset" class="btn btn-danger" value="reset">RESET</button>
      </form>
    </div>
    <!-- AKHIR FORM LOGIN -->



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
  </body>
</html>