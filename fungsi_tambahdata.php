<?php
include "koneksi.php";

if (isset($_POST['submit'])) {
	$nama = $_POST['nama'];
	$password = $_POST['password'];
	$nik = $_POST['nik'];
	$username = $_POST['username'];
	$hak_akses = $_POST['hak_akses'];


	$sql = "INSERT INTO user VALUES ('$nama', '$password', '$nik')";
	$sql = "INSERT INTO user_login VALUES ('$username', '$password', '$hak_akses')";
	$query = mysqli_query($koneksi, $sql);

	echo "<script language='javascript'>
	alert('user berhasil di tambah');
	document.location='dashboard.php';
	</script>";
} else {
	echo "Data tidak di simpan";
}
