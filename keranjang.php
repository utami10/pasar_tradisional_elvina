<?php require 'config.php';
if($_SERVER['REQUEST_METHOD']=='POST'){$id=(int)($_POST['id']??0);$a=$_POST['aksi']??'';
 if($a=='tambah'){$_SESSION['cart'][$id]=($_SESSION['cart'][$id]??0)+max(1,(int)($_POST['qty']??1));}
 if($a=='ubah'){$n=(int)$_POST['qty'];if($n>0)$_SESSION['cart'][$id]=$n;else unset($_SESSION['cart'][$id]);}
 if($a=='hapus')unset($_SESSION['cart'][$id]);
 header('Location: keranjang.php');exit;}
head('Keranjang');$items=[];$tot=0;
foreach($_SESSION['cart']??[] as $id=>$n){$p=one(q("SELECT * FROM produk WHERE id_produk=?",'i',[$id]));if($p){$p['n']=min($n,$p['stok']);$p['sub']=$p['n']*$p['harga'];$tot+=$p['sub'];$items[]=$p;}}?>
<h3 class="mb-3">🛒 Keranjang Belanja</h3>
<?php if(!$items):?><div class="card-cute p-5 text-center">Keranjangmu masih kosong 🥺<br><a href="index.php" class="btn btn-pink mt-3">Yuk belanja!</a></div><?php else:?>
<div class="row g-4"><div class="col-lg-7"><?php foreach($items as $p):?><div class="card-cute p-3 mb-3 d-flex flex-row align-items-center gap-3"><div style="width:60px"><?=img($p,'sm')?></div>
<div class="flex-grow-1"><b><?=e($p['nama'])?></b><div class="price"><?=rp($p['harga'])?></div></div>
<form method="post" class="d-flex gap-1"><input type="hidden" name="aksi" value="ubah"><input type="hidden" name="id" value="<?=$p['id_produk']?>"><input type="number" name="qty" value="<?=$p['n']?>" min="0" max="<?=$p['stok']?>" class="form-control form-control-sm" style="width:65px"><button class="btn btn-sm btn-mint">OK</button></form>
<form method="post"><input type="hidden" name="aksi" value="hapus"><input type="hidden" name="id" value="<?=$p['id_produk']?>"><button class="btn btn-sm">🗑️</button></form></div><?php endforeach;?></div>
<div class="col-lg-5"><form method="post" action="checkout.php" class="card-cute p-4"><h5>Data Pemesan 💌</h5>
<input name="nama" class="form-control mb-2" placeholder="Nama lengkap" required><input name="hp" class="form-control mb-2" placeholder="No. HP (untuk cek status)" required pattern="[0-9+]{8,15}"><textarea name="alamat" class="form-control mb-3" placeholder="Alamat lengkap" rows="3" required></textarea>
<div class="d-flex justify-content-between mb-3"><b>Total</b><b class="price"><?=rp($tot)?></b></div><button class="btn btn-pink w-100">Checkout Sekarang ✨</button></form></div></div><?php endif; foot();
