<?php require '../config.php';admin_only();
$all=['Menunggu Konfirmasi','Dikonfirmasi','Dikemas','Dikirim','Selesai','Dibatalkan'];
if($_SERVER['REQUEST_METHOD']=='POST'){$id=(int)$_POST['id'];$new=$_POST['status'];$o=one(q("SELECT status FROM pesanan WHERE id_pesanan=?",'i',[$id]));
 if($o&&in_array($new,$all)&&$o['status']!=$new){
  $pakai=fn($s)=>!in_array($s,['Menunggu Konfirmasi','Dibatalkan']); // stok sudah terpotong?
  $items=all(q("SELECT * FROM detail_pesanan WHERE id_pesanan=?",'i',[$id]));
  if(!$pakai($o['status'])&&$pakai($new))foreach($items as $d)q("UPDATE produk SET stok=GREATEST(stok-?,0) WHERE id_produk=?",'ii',[$d['jumlah'],$d['id_produk']]);
  if($pakai($o['status'])&&!$pakai($new))foreach($items as $d)q("UPDATE produk SET stok=stok+? WHERE id_produk=?",'ii',[$d['jumlah'],$d['id_produk']]);
  q("UPDATE pesanan SET status=? WHERE id_pesanan=?",'si',[$new,$id]);}
 header('Location: pesanan.php?s='.urlencode($_GET['s']??''));exit;}
head('Kelola Pesanan');$f=$_GET['s']??'';
$rows=$f?all(q("SELECT * FROM pesanan WHERE status=? ORDER BY id_pesanan DESC",'s',[$f])):all(q("SELECT * FROM pesanan ORDER BY id_pesanan DESC"));?>
<h3 class="mb-3">📦 Kelola Pesanan</h3><div class="mb-3 d-flex flex-wrap gap-2"><a href="pesanan.php" class="btn btn-sm <?=$f?'btn-outline-pink':'btn-pink'?>">Semua</a>
<?php foreach($all as $s):?><a href="?s=<?=urlencode($s)?>" class="btn btn-sm <?=$f==$s?'btn-pink':'btn-outline-pink'?>"><?=$s?></a><?php endforeach;?></div>
<?php foreach($rows as $o):$k=explode(' ',$o['status'])[0];?><div class="card-cute p-3 mb-3"><div class="row g-2 align-items-center">
<div class="col-md-4"><b><?=e($o['kode'])?></b> <span class="stat s-<?=$k?>"><?=$o['status']?></span><br><small><?=e($o['nama_pembeli'])?> · <?=e($o['no_hp'])?><br><?=e($o['alamat'])?><br><?=$o['tanggal']?></small></div>
<div class="col-md-4"><small><?php foreach(all(q("SELECT d.*,p.nama FROM detail_pesanan d JOIN produk p USING(id_produk) WHERE id_pesanan=?",'i',[$o['id_pesanan']])) as $d)echo e($d['nama'])." × {$d['jumlah']}<br>";?></small><b class="price"><?=rp($o['total'])?></b></div>
<div class="col-md-4"><form method="post" class="d-flex gap-1 flex-wrap"><input type="hidden" name="id" value="<?=$o['id_pesanan']?>">
<?php if($o['status']=='Menunggu Konfirmasi'):?><button name="status" value="Dikonfirmasi" class="btn btn-sm btn-mint">✅ Konfirmasi</button><button name="status" value="Dibatalkan" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tolak pesanan ini?')">❌ Tolak</button>
<?php else:?><select name="status" class="form-select form-select-sm w-auto"><?php foreach($all as $s)echo "<option ".($s==$o['status']?'selected':'').">$s</option>";?></select><button class="btn btn-sm btn-pink">Ubah</button><?php endif;?></form></div></div></div>
<?php endforeach; if(!$rows)echo "<p class='text-center'>Belum ada pesanan 🍃</p>"; foot();
