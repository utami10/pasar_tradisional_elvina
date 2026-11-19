<?php require '../config.php';admin_only();$msg='';
if(isset($_GET['hapus'])){$id=(int)$_GET['hapus'];
 if(one(q("SELECT 1 x FROM detail_pesanan WHERE id_produk=? LIMIT 1",'i',[$id])))$msg='Produk sudah pernah dipesan, tidak bisa dihapus (stok bisa diset 0).';
 else{q("DELETE FROM produk WHERE id_produk=?",'i',[$id]);header('Location: produk.php');exit;}}
if($_SERVER['REQUEST_METHOD']=='POST'){$id=(int)$_POST['id'];$g=null;
 if(!empty($_FILES['gambar']['name'])&&preg_match('/\.(jpe?g|png|webp)$/i',$_FILES['gambar']['name'])&&$_FILES['gambar']['size']<2e6){$g=uniqid().'.'.pathinfo($_FILES['gambar']['name'],PATHINFO_EXTENSION);move_uploaded_file($_FILES['gambar']['tmp_name'],"../uploads/$g");}
 $d=[(int)$_POST['penjual'],(int)$_POST['kategori'],$_POST['nama'],$_POST['deskripsi'],(int)$_POST['harga'],(int)$_POST['stok'],$_POST['emoji']];
 if($id){q("UPDATE produk SET id_penjual=?,id_kategori=?,nama=?,deskripsi=?,harga=?,stok=?,emoji=? WHERE id_produk=?",'iissiisi',[...$d,$id]);if($g)q("UPDATE produk SET gambar=? WHERE id_produk=?",'si',[$g,$id]);}
 else q("INSERT INTO produk(id_penjual,id_kategori,nama,deskripsi,harga,stok,emoji,gambar) VALUES(?,?,?,?,?,?,?,?)",'iissiiss',[...$d,$g]);
 header('Location: produk.php');exit;}
head('Kelola Produk');$e=isset($_GET['edit'])?one(q("SELECT * FROM produk WHERE id_produk=?",'i',[(int)$_GET['edit']])):null;
$pj=all(q("SELECT * FROM penjual"));$kt=all(q("SELECT * FROM kategori"));$rows=all(q("SELECT p.*,t.nama_toko FROM produk p JOIN penjual t USING(id_penjual) ORDER BY id_produk DESC"));$v=fn($k)=>e($e[$k]??'');?>
<h3 class="mb-3">Kelola Produk</h3><?php if($msg)echo "<div class='alert alert-warning'>".e($msg)."</div>";?>
<form method="post" enctype="multipart/form-data" class="card-cute p-3 mb-4 row g-2"><input type="hidden" name="id" value="<?=$e['id_produk']??0?>">
<div class="col-md-4"><input name="nama" value="<?=$v('nama')?>" class="form-control" placeholder="Nama produk" required></div>
<div class="col-md-2"><input name="harga" type="number" value="<?=$v('harga')?>" class="form-control" placeholder="Harga" required></div><div class="col-md-2"><input name="stok" type="number" value="<?=$v('stok')?>" class="form-control" placeholder="Stok" required></div>
<div class="col-md-2"><select name="penjual" class="form-select"><?php foreach($pj as $x)echo "<option value='{$x['id_penjual']}' ".(($e['id_penjual']??0)==$x['id_penjual']?'selected':'').">".e($x['nama_toko'])."</option>";?></select></div>
<div class="col-md-4"><label class="small">Kategori</label><select name="kategori" class="form-select"><?php foreach($kt as $x)echo "<option value='{$x['id_kategori']}' ".(($e['id_kategori']??0)==$x['id_kategori']?'selected':'').">".e($x['nama_kategori'])."</option>";?></select></div>
<div class="col-md-8"><label class="small">Foto produk (opsional, maks 2 MB)</label><input type="file" name="gambar" class="form-control" accept="image/*"></div>
<div class="col-12"><label class="small">Deskripsi produk</label><textarea name="deskripsi" rows="4" class="form-control" placeholder="Tulis deskripsi produk di sini: bahan, ukuran, keunggulan, dll."><?=$v('deskripsi')?></textarea></div>
<div class="col-12"><button class="btn btn-pink"><?=$e?'Simpan Perubahan':'Tambah Produk'?> </button> <?php if($e)echo "<a href='produk.php' class='btn btn-outline-pink'>Batal</a>";?></div></form>
<div class="card-cute p-3 table-responsive"><table class="table align-middle mb-0"><tr><th></th><th>Nama</th><th>Toko</th><th>Harga</th><th>Stok</th><th></th></tr>
<?php foreach($rows as $p):?><tr><td style="width:70px"><?=img($p,'sm')?></td><td><?=e($p['nama'])?></td><td><?=e($p['nama_toko'])?></td><td><?=rp($p['harga'])?></td><td><?=$p['stok']?></td>
<td class="text-end"><a href="?edit=<?=$p['id_produk']?>" class="btn btn-sm btn-mint">✏️</a> <a href="?hapus=<?=$p['id_produk']?>" onclick="return confirm('Hapus produk?')" class="btn btn-sm btn-outline-danger">🗑️</a></td></tr><?php endforeach;?></table></div><?php foot();