<?php
error_reporting(0);
session_start();
include "koneksi.php";

if (isset($_GET['id_supplayer'])) {
	$kode = $_GET['id_supplayer'];
	$username =  $_POST['username'];
	$ip_access = $_SERVER['REMOTE_ADDR'];
	$username = $_SESSION['username'];
	$sql = "update tabel_supplayer set deleted_at = now(), deleted_by = '$username', ip_access = '$ip_access' where id_supplayer ='$kode'";
	$query = mysqli_query($koneksi, $sql);
	// $sql = "delete from tabel_supplayer where id_supplayer ='$kode'";
	// $sql2 = "delete from user_login where username ='$kode'";
	// $query2 = mysqli_query($koneksi, $sql2);

	echo "<script language='javascript'>
	alert('supplayer berhasil dihapus');
	document.location='v_supplayer.php';
	</script>";
} else {
	echo "Data yang dihapus belum dipilih";
}
