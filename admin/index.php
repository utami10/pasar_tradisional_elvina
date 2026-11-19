<?php require '../config.php';admin_only();head('Dashboard');
$c=fn($w)=>one(q("SELECT COUNT(*) n FROM pesanan $w"))['n'];?>
<h3 class="mb-3">📊 Dashboard Admin</h3><div class="row g-3 text-center">
<?php foreach([['⏳','Perlu Konfirmasi',$c("WHERE status='Menunggu Konfirmasi'"),'pesanan.php?s=Menunggu+Konfirmasi'],['📦','Semua Pesanan',$c(''),'pesanan.php'],['🛍️','Produk',one(q("SELECT COUNT(*) n FROM produk"))['n'],'produk.php'],['💰','Omzet (selesai)',rp(one(q("SELECT IFNULL(SUM(total),0) n FROM pesanan WHERE status='Selesai'"))['n']),'pesanan.php?s=Selesai']] as [$i,$l,$v,$u]):?>
<div class="col-6 col-md-3"><a href="<?=$u?>" class="card-cute d-block p-4 text-decoration-none" style="color:inherit"><div style="font-size:40px"><?=$i?></div><div class="fs-4 price"><?=$v?></div><small><?=$l?></small></a></div><?php endforeach;?></div><?php foot();
