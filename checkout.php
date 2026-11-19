<?php require 'config.php';
if($_SERVER['REQUEST_METHOD']!='POST'||empty($_SESSION['cart'])){header('Location: keranjang.php');exit;}
$nama=trim($_POST['nama']);$hp=trim($_POST['hp']);$al=trim($_POST['alamat']);$items=[];$tot=0;
foreach($_SESSION['cart'] as $id=>$n){$p=one(q("SELECT * FROM produk WHERE id_produk=?",'i',[$id]));if($p&&$p['stok']>0){$n=min($n,$p['stok']);$items[]=[$id,$n,$p['harga']];$tot+=$n*$p['harga'];}}
if(!$items||!$nama||!$hp||!$al){header('Location: keranjang.php');exit;}
$kode='MG'.date('ymd').rand(100,999);
mysqli_begin_transaction($db);
q("INSERT INTO pesanan(kode,nama_pembeli,no_hp,alamat,total) VALUES(?,?,?,?,?)",'ssssi',[$kode,$nama,$hp,$al,$tot]);
$pid=mysqli_insert_id($db);
foreach($items as [$id,$n,$h])q("INSERT INTO detail_pesanan(id_pesanan,id_produk,jumlah,harga) VALUES(?,?,?,?)",'iiii',[$pid,$id,$n,$h]);
mysqli_commit($db);unset($_SESSION['cart']);
$l=json_decode($_COOKIE['pesanan_saya']??'[]',true);if(!is_array($l))$l=[];array_unshift($l,[$kode,$hp]);setcookie('pesanan_saya',json_encode(array_slice($l,0,20)),time()+86400*90,'/');
head('Pesanan Berhasil');?>
<div class="card-cute p-5 text-center mx-auto" style="max-width:520px"><div style="font-size:64px">🎉</div><h3>Pesanan Diterima!</h3><p>Kode pesananmu:</p><h2 class="price"><?=$kode?></h2>
<p>Simpan kode ini ya. Pesanan menunggu konfirmasi admin.</p><a href="status.php" class="btn btn-pink">Lihat Status Pesanan 🚚</a></div><?php foot();