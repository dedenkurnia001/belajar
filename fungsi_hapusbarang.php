<?php
error_reporting(0);
session_start();
include "koneksi.php";

if (isset($_GET['id_barang'])) {
	$kode = $_GET['id_barang'];
	$username =  $_POST['username'];
	$ip_access = $_SERVER['REMOTE_ADDR'];
	$username = $_SESSION['username'];

	$sql = "update tabel_barang set deleted_at = now(), deleted_by = '$username', ip_access = '$ip_access' where id_barang ='$kode'";
	// $sql = "delete from tabel_barang where id_barang ='$kode'";
	$query = mysqli_query($koneksi, $sql);
	// $sql2 = "delete from user_login where username ='$kode'";
	// $query2 = mysqli_query($koneksi, $sql2);

	echo "<script language='javascript'>
	alert('barang berhasil dihapus');
	
	</script>";
} else {
	echo "Data yang dihapus belum dipilih";
}
