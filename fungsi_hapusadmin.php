<?php
include "koneksi.php";

if (isset($_GET['username'])) {
	$kode = $_GET['username'];
	$sql = "delete from user_login where username ='$kode'";
	$query = mysqli_query($koneksi, $sql);

	echo "<script language='javascript'>
	alert('user berhasil dihapus');
	document.location='dashboardadmin.php';
	</script>";
} else {
	echo "Data yang dihapus belum dipilih";
}
