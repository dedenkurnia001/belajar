<?php
include "koneksi.php";

if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$nama = $_POST['nama'];
	$password = $_POST['password'];
	$hak_akses = $_POST['hak_akses'];

	$sql = "update user_login set name='$nama', password='$password', hak_akses='$hak_akses' where username ='$username' ";
	$query = mysqli_query($koneksi, $sql);

	echo "<script language='javascript'>
	alert('user berhasil di update');
	document.location='dashboardadmin.php';
	</script>";
} else {
	echo "Data tidak di ubah";
}
