<?php
error_reporting(0);
session_start();
include "koneksi.php";

if (isset($_POST['submit'])) {
	$nama_supplayer = $_POST['nama_supplayer'];
	$notelpon = $_POST['notelpon'];
	$alamat = $_POST['alamat'];
	$email = $_POST['email'];
	$id_supplayer = $_POST['id_supplayer'];
	$username = $_SESSION['username'];
	$ip_access = $_SERVER['REMOTE_ADDR'];


	$sql = "update tabel_supplayer set 
			nama_supplayer='$nama_supplayer',
			notelpon='$notelpon',
			alamat='$alamat',
			email='$email',
			updated_at=NOW(),
			updated_by='$username',
			ip_access = '$ip_access'
			where id_supplayer ='$id_supplayer'";
	$query = mysqli_query($koneksi, $sql);


	echo "<script language='javascript'>
	alert('supplayer berhasil di update');
	document.location='v_supplayer.php';
	</script>";
} else {
	echo "Data tidak di ubah";
}
