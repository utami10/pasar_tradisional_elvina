<?php require '../config.php';admin_only();$msg='';
if(isset($_GET['hapus'])){$id=(int)$_GET['hapus'];
 if(one(q("SELECT 1 x FROM produk WHERE id_kategori=? LIMIT 1",'i',[$id])))$msg='Kategori masih dipakai produk, pindahkan atau hapus produknya dulu.';
 else{q("DELETE FROM kategori WHERE id_kategori=?",'i',[$id]);header('Location: kategori.php');exit;}}
if($_SERVER['REQUEST_METHOD']=='POST'){$id=(int)$_POST['id'];$n=trim($_POST['nama']);
 if($n!==''){if($id)q("UPDATE kategori SET nama_kategori=? WHERE id_kategori=?",'si',[$n,$id]);else q("INSERT INTO kategori(nama_kategori) VALUES(?)",'s',[$n]);}
 header('Location: kategori.php');exit;}
head('Kelola Kategori');$e=isset($_GET['edit'])?one(q("SELECT * FROM kategori WHERE id_kategori=?",'i',[(int)$_GET['edit']])):null;
$rows=all(q("SELECT k.*,(SELECT COUNT(*) FROM produk p WHERE p.id_kategori=k.id_kategori) jml FROM kategori k ORDER BY nama_kategori"));?>
<h3 class="mb-3">📂 Kelola Kategori</h3><?php if($msg)echo "<div class='alert alert-warning'>".e($msg)."</div>";?>
<form method="post" class="card-cute p-3 mb-4 d-flex gap-2 flex-wrap"><input type="hidden" name="id" value="<?=$e['id_kategori']??0?>">
<input name="nama" value="<?=e($e['nama_kategori']??'')?>" class="form-control flex-grow-1" style="min-width:220px;width:auto" placeholder="Nama kategori, mis. Pakaian" required>
<button class="btn btn-pink"><?=$e?'Simpan Perubahan':'Tambah Kategori'?> 💖</button><?php if($e)echo "<a href='kategori.php' class='btn btn-outline-pink'>Batal</a>";?></form>
<div class="card-cute p-3"><table class="table align-middle mb-0"><tr><th>Nama Kategori</th><th>Jumlah Produk</th><th></th></tr>
<?php foreach($rows as $k):?><tr><td><?=e($k['nama_kategori'])?></td><td><?=$k['jml']?></td><td class="text-end"><a href="?edit=<?=$k['id_kategori']?>" class="btn btn-sm btn-mint">✏️</a> <a href="?hapus=<?=$k['id_kategori']?>" onclick="return confirm('Hapus kategori?')" class="btn btn-sm btn-outline-danger">🗑️</a></td></tr><?php endforeach;?></table></div><?php foot();
