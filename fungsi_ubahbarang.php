<?php
error_reporting(0);
session_start();
include "koneksi.php";


if (isset($_POST['submit'])) {
	$nama_barang = $_POST['nama_barang'];
	$id_barang = $_POST['id_barang'];
	$jenis_barang = $_POST['jenis_barang'];
	$stok = $_POST['stok'];
	$harga = $_POST['harga'];
	$username = $_SESSION['username'];
	$ip_access = $_SERVER['REMOTE_ADDR'];

	$sql = "update tabel_barang set 
				nama_barang='$nama_barang',
				jenis_barang='$jenis_barang',
				stok='$stok', 
				harga='$harga' ,
				updated_at=NOW(),
				updated_by='$username',
				ip_access = '$ip_access'
				where id_barang ='$id_barang'";

	$query = mysqli_query($koneksi, $sql);


	echo "<script language='javascript'>
	alert('barang berhasil di update');
	document.location='v_barang.php';
	</script>";
} else {
	echo "Data tidak di ubah";
}
