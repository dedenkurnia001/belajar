<?php
error_reporting(0);
session_start();
include "koneksi.php";

if (isset($_POST['submit'])) {
	$nama_supplayer = $_POST['nama_supplayer'];
	$notelpon = $_POST['notelpon'];
	$alamat = $_POST['alamat'];
	$email = $_POST['email'];
	$username =  $_POST['username'];
	$ip_access = $_SERVER['REMOTE_ADDR'];

	$sql = "INSERT INTO tabel_supplayer
	(nama_supplayer,notelpon,alamat,email,created_at,created_by,ip_access)
	VALUES ('$nama_supplayer', '$notelpon', '$alamat', '$email', now(), '$username','$ip_access')";
	$query = mysqli_query($koneksi, $sql);
	// $sql = "INSERT INTO tabel_supplayer VALUES ('','$nama_supplayer', '$notelpon', '$alamat', '$email')";

	echo "<script language='javascript'>
	alert('supplayer berhasil di tambah');
	document.location='v_supplayer.php';
	</script>";
} else {
	echo "Data tidak di simpan";
}
