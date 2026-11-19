<?php require 'config.php';
$p=one(q("SELECT p.*,t.nama_toko,k.nama_kategori FROM produk p JOIN penjual t USING(id_penjual) JOIN kategori k USING(id_kategori) WHERE id_produk=?",'i',[(int)($_GET['id']??0)]));
head($p['nama']??'Produk'); if(!$p){echo "<p>Produk tidak ditemukan 🥺</p>";foot();exit;}?>
<div class="row g-4"><div class="col-md-5"><div class="card-cute"><?=img($p,'big')?></div></div>
<div class="col-md-7"><span class="chip"><?=e($p['nama_kategori'])?></span> <span class="chip">🏪 <?=e($p['nama_toko'])?></span>
<h2 class="mt-2"><?=e($p['nama'])?></h2><h3 class="price"><?=rp($p['harga'])?></h3><p><?=nl2br(e($p['deskripsi']))?></p><p>Stok: <b><?=$p['stok']?></b></p>
<?php if($p['stok']>0):?><form method="post" action="keranjang.php" class="d-flex gap-2" style="max-width:300px"><input type="hidden" name="aksi" value="tambah"><input type="hidden" name="id" value="<?=$p['id_produk']?>">
<input type="number" name="qty" value="1" min="1" max="<?=$p['stok']?>" class="form-control" style="width:90px"><button class="btn btn-pink flex-fill">Masukkan Keranjang 🛒</button></form><?php else:?><p class="text-danger">Stok habis 😢</p><?php endif;?>
<a href="index.php" class="btn btn-outline-pink mt-3">← Kembali</a></div></div><?php foot();
