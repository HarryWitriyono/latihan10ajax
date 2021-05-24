<?php 
 $kon=new mysqli('localhost','root','');
 $s="create database tokooop";
 $q=$kon -> query($s);
 if ($q) {
	 echo "Database toko sudah dibuat !";
 } else {
	 echo "Database toko gagal dibuat !";
 }
 $s1="create table tokooop.barang (
      kodebarang varchar(30) not null primary key,
	  namabarang varchar(50) not null,
	  satuan varchar(30) not null,
	  jumlah double(10,2) null,
	  hargasatuan double(12,2) null);";
 $q1=$kon->query($s1);
 if ($q1) {
	 echo "Tabel barang sudah dibuat !";
 } else {
	 echo "Tabel barang gagal dibuat !";
 }
?>
