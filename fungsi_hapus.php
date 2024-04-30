<?php
include "koneksi.php";

if (isset($_GET['nama'])) {
	$kode = $_GET['nama'];
	$sql = "delete from user where nama ='$kode'";
	$query = mysqli_query($koneksi, $sql);
	$sql2 = "delete from user_login where username ='$kode'";
	$query2 = mysqli_query($koneksi, $sql2);

	echo "<script language='javascript'>
	alert('user berhasil dihapus');
	document.location='dashboard.php';
	</script>";
} else {
	echo "Data yang dihapus belum dipilih";
}
