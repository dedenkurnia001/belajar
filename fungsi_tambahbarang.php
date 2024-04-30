<?php
include "koneksi.php";

if (isset($_POST['submit'])) {
	$nama_barang = $_POST['nama_barang'];
	$jenis_barang = $_POST['jenis_barang'];
	$stok = $_POST['stok'];
	$harga = $_POST['harga'];
	$username =  $_POST['username'];
	$ip_access = $_SERVER['REMOTE_ADDR'];

	$sql = "INSERT INTO tabel_barang 
	(nama_barang,id_barang,jenis_barang,stok,harga,created_at,created_by,ip_access)
	VALUES ('$nama_barang', '', '$jenis_barang', $stok, $harga, now(), '$username','$ip_access')";
	$query = mysqli_query($koneksi, $sql);

	echo "<script language='javascript'>
	alert('barang berhasil di tambah');
	document.location='v_barang.php';
	</script>";
} else {
	echo "Data tidak di simpan";
}
