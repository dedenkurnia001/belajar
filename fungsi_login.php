<?php
error_reporting(0);
include "koneksi.php";
if (isset($_POST['login'])) {

  $username = $_POST['username'];
  $password = $_POST['password'];

  $a = "select * from user_login where username ='$username' and password='$password'";
  $b = mysqli_query($koneksi, $a);
  $hasil = mysqli_fetch_array($b);
  $result   = mysqli_num_rows($b);
  if ($result > 0) {
    session_start();
    $username = $hasil['username'];
    $hak_akses = $hasil['hak_akses'];

    $_SESSION['username'] = $username;
    $_SESSION['hak_akses'] = $hak_akses;
  } else {
    echo "<script language='javascript'>
    alert('Data user tidak sesuai');
    document.location='index.php';
    </script>";
  }

  if ($hak_akses == "admin") {
    header("Location: dashboardadmin.php");
  } elseif ($hak_akses == "user") {
    header("Location: dashboard.php");
  }
}
