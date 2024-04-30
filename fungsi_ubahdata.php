<?php
include "koneksi.php";

if (isset($_POST['submit'])) {
	// $id=$_POST['id'];
	$nama = $_POST['nama'];
	$password = $_POST['password'];
	$nik = $_POST['nik'];

	$sql = "update user set nama='$nama', password='$password', nik='$nik' where nama ='$nama' ";
	$query = mysqli_query($koneksi, $sql);
	$sql2 = "update user_login set username='$nama', password='$password', hak_akses='$nik' where username ='$nama' ";
	$query2 = mysqli_query($koneksi, $sql2);

	echo "<script language='javascript'>
	alert('user berhasil di update');
	document.location='dashboard.php';
	</script>";
} else {
	echo "Data tidak di ubah";
}
