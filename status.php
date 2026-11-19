<?php require 'config.php';
// Pesanan diingat otomatis lewat cookie di perangkat pembeli (tanpa perlu mencari).
$l=json_decode($_COOKIE['pesanan_saya']??'[]',true);if(!is_array($l))$l=[];
$kode=trim($_GET['kode']??'');$hp=trim($_GET['hp']??'');$gagal=false;
if($kode&&$hp){
 if(one(q("SELECT 1 x FROM pesanan WHERE kode=? AND no_hp=?",'ss',[$kode,$hp]))){
  $ada=false;foreach($l as $x)if(($x[0]??'')==$kode)$ada=true;
  if(!$ada){array_unshift($l,[$kode,$hp]);setcookie('pesanan_saya',json_encode(array_slice($l,0,20)),time()+86400*90,'/');}
 }else $gagal=true;}
$orders=[];
foreach($l as $x){if(!is_array($x)||count($x)<2)continue;$o=one(q("SELECT * FROM pesanan WHERE kode=? AND no_hp=?",'ss',[$x[0],$x[1]]));if($o)$orders[]=$o;}
usort($orders,fn($a,$b)=>$b['id_pesanan']<=>$a['id_pesanan']);
$steps=['Menunggu Konfirmasi'=>'⏳','Dikonfirmasi'=>'✅','Dikemas'=>'📦','Dikirim'=>'🚚','Selesai'=>'🎁'];
head('Status Pesanan');?>
<div class="d-flex justify-content-between align-items-center mb-3"><h3 class="mb-0">🚚 Status Pesanan Saya</h3><a href="status.php" class="btn btn-sm btn-mint">🔄 Segarkan</a></div>
<?php if($gagal)echo "<div class='alert alert-warning'>Pesanan tidak ditemukan 🥺 Cek lagi kode & no. HP-nya ya.</div>";
if(!$orders):?><div class="card-cute p-5 text-center mb-3">Belum ada pesanan di perangkat ini 🍃<br><a href="index.php" class="btn btn-pink mt-3">Yuk belanja!</a></div><?php endif;
foreach($orders as $o):$st=$o['status'];$idx=array_search($st,array_keys($steps));$k=explode(' ',$st)[0];?>
<div class="card-cute p-4 mb-3"><div class="d-flex justify-content-between flex-wrap gap-2"><div><b><?=e($o['kode'])?></b> <span class="stat s-<?=$k?>"><?=e($st)?></span><br><small><?=e($o['nama_pembeli'])?> · <?=e($o['tanggal'])?></small></div><div class="price fs-5"><?=rp($o['total'])?></div></div><hr>
<?php if($st=='Dibatalkan'):?><div class="text-center">😢 Pesanan ini dibatalkan.</div><?php else:?><div class="d-flex"><?php $i=0;foreach($steps as $nm=>$ic):?><div class="step <?=$i<=$idx?'on':''?>"><div class="dot"><?=$ic?></div><small><?=$nm?></small></div><?php $i++;endforeach;?></div><?php endif;?>
<details class="mt-3"><summary class="small">Lihat isi pesanan</summary><div class="mt-2"><?php foreach(all(q("SELECT d.*,p.nama FROM detail_pesanan d JOIN produk p USING(id_produk) WHERE id_pesanan=?",'i',[$o['id_pesanan']])) as $d):?>
<div class="d-flex justify-content-between"><span><?=e($d['nama'])?> × <?=$d['jumlah']?></span><span><?=rp($d['harga']*$d['jumlah'])?></span></div><?php endforeach;?></div></details></div>
<?php endforeach;?>
<details class="mt-4"><summary class="small">Pesanan dibuat di perangkat lain? Cari pakai kode</summary>
<form class="card-cute p-3 mt-2 row g-2"><div class="col-md-5"><input name="kode" class="form-control" placeholder="Kode pesanan" required></div><div class="col-md-4"><input name="hp" class="form-control" placeholder="No. HP saat memesan" required></div><div class="col-md-3"><button class="btn btn-pink w-100">Cari 🔍</button></div></form></details>
<?php foot();