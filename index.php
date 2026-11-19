<?php require 'config.php'; head('Beranda');
$k=(int)($_GET['k']??0);$s=trim($_GET['s']??'');
$sql="SELECT p.*,t.nama_toko FROM produk p JOIN penjual t USING(id_penjual) WHERE p.nama LIKE ?";$par=["%$s%"];$ty='s';
if($k){$sql.=" AND p.id_kategori=?";$par[]=$k;$ty.='i';}
$rows=all(q($sql.' ORDER BY p.id_produk DESC',$ty,$par));$kat=all(q("SELECT * FROM kategori"));?>
<div class="hero"><h1>Welcome, Stylish People!🛍️</h1><p class="mb-3">Temukan berbagai barang branded dengan harga terjangkau, tetap stylish, berkualitas, dan ramah di kantong! </p>
<form class="row g-2 justify-content-center"><div class="col-8 col-md-5"><input name="s" value="<?=e($s)?>" class="form-control" placeholder="Cari produk..."></div><div class="col-auto"><button class="btn btn-pink">Cari 🔍</button></div></form></div>
<div class="mb-3 d-flex flex-wrap gap-2"><a href="index.php" class="btn btn-sm <?=$k?'btn-outline-pink':'btn-pink'?>">Semua</a>
<?php foreach($kat as $x):?><a href="?k=<?=$x['id_kategori']?>" class="btn btn-sm <?=$k==$x['id_kategori']?'btn-pink':'btn-outline-pink'?>"><?=e($x['nama_kategori'])?></a><?php endforeach;?></div>
<div class="row row-cols-2 row-cols-md-4 g-3">
<?php foreach($rows as $p):?><div class="col"><div class="card-cute h-100 hov d-flex flex-column"><a href="produk.php?id=<?=$p['id_produk']?>" class="text-decoration-none"><?=img($p)?></a>
<div class="p-3 d-flex flex-column flex-grow-1"><span class="chip align-self-start mb-1"><?=e($p['nama_toko'])?></span><h6><?=e($p['nama'])?></h6><div class="price mb-2"><?=rp($p['harga'])?></div>
<div class="mt-auto d-flex gap-1"><a href="produk.php?id=<?=$p['id_produk']?>" class="btn btn-sm btn-outline-pink flex-fill">Detail</a>
<?php if($p['stok']>0):?><form method="post" action="keranjang.php" class="flex-fill"><input type="hidden" name="aksi" value="tambah"><input type="hidden" name="id" value="<?=$p['id_produk']?>"><button class="btn btn-sm btn-pink w-100">+🛒</button></form><?php else:?><span class="btn btn-sm disabled flex-fill">Habis</span><?php endif;?></div></div></div></div>
<?php endforeach; if(!$rows) echo "<p class='text-center'>Yah, produknya belum ada 🥺</p>";?></div>
<?php foot();
