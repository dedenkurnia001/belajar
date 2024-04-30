<?php
include "koneksi.php";

if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$hak_akses = $_POST['hak_akses'];

	$sql = "INSERT INTO user_login VALUES ('$username', '$password', '$hak_akses')";
	$query = mysqli_query($koneksi, $sql);

	echo "<script language='javascript'>
	alert('user berhasil di tambah');
	document.location='dashboardadmin.php';
	</script>";
} else {
	echo "Data tidak di simpan";
}
