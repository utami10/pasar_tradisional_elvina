<?php
// Konfigurasi aplikasi. Tidak berisi password, aman untuk GitHub.
// Salin nilai dari panel InfinityFree. JANGAN upload kredensial asli ke GitHub (file ini di-.gitignore).
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
$B = basename(dirname($_SERVER['SCRIPT_NAME']))=='admin' ? '../' : '';
// Kredensial disimpan installer di koneksi.local.php (tidak ikut ke GitHub)
if(!file_exists(__DIR__.'/koneksi.local.php')){header('Location: '.$B.'install.php');exit;}
$cfg = require __DIR__.'/koneksi.local.php';
$db = mysqli_connect($cfg['host'],$cfg['user'],$cfg['pass'],$cfg['name']);
if(!$db) die('Koneksi gagal: '.mysqli_connect_error().'. Hapus file koneksi.local.php lalu buka install.php untuk mengisi ulang.');
mysqli_set_charset($db,'utf8mb4');
$B = basename(dirname($_SERVER['SCRIPT_NAME']))=='admin' ? '../' : '';
function e($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');}
function rp($n){return 'Rp '.number_format($n,0,',','.');}
function q($sql,$t='',$p=[]){global $db;$st=mysqli_prepare($db,$sql);if($p)mysqli_stmt_bind_param($st,$t,...$p);mysqli_stmt_execute($st);return mysqli_stmt_get_result($st);}
function all($r){return $r?mysqli_fetch_all($r,MYSQLI_ASSOC):[];}
function one($r){return $r?mysqli_fetch_assoc($r):null;}
function cart_count(){return array_sum($_SESSION['cart']??[]);}
function admin_only(){if(empty($_SESSION['admin'])){header('Location: login.php');exit;}}
function img($p,$cls=''){global $B;return $p['gambar']?"<img src='{$B}uploads/".e($p['gambar'])."' class='pimg $cls'>":"<div class='pimg emo $cls'>".e($p['emoji']?:'🎀')."</div>";}
function head($title){global $B;$adm=$B==='../';$c=cart_count();?>
<!DOCTYPE html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=e($title)?> · Toko Mungil</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
<link href="<?=$B?>style.css?v=<?=@filemtime(__DIR__.'/style.css')?>" rel="stylesheet">
<style>main>.row.text-center{margin-top:2.5rem!important}footer{margin-top:4rem!important}</style></head><body>
<nav class="navbar navbar-expand-md nav-cute"><div class="container">
<a class="navbar-brand" href="<?=$adm?'index.php':$B.'index.php'?>">🧸 Toko Mungil<?=$adm?' <small>admin</small>':''?></a>
<button class="navbar-toggler border-0" data-bs-toggle="collapse" data-bs-target="#m" aria-label="Menu"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="m"><ul class="navbar-nav ms-auto gap-md-2">
<?php if($adm&&!empty($_SESSION['admin'])):?>
<li><a class="nav-link" href="index.php">📊 Dashboard</a></li><li><a class="nav-link" href="pesanan.php">📦 Kelola Pesanan</a></li><li><a class="nav-link" href="produk.php">✏️ Kelola Produk</a></li><li><a class="nav-link" href="kategori.php">📂 Kategori</a></li><li><a class="nav-link" href="logout.php">👋 Keluar</a></li>
<?php elseif(!$adm):?>
<li><a class="nav-link" href="index.php">🏠 Beranda</a></li><li><a class="nav-link" href="status.php">🚚 Status Pesanan</a></li><li><a class="nav-link" href="keranjang.php">🛒 Keranjang <span class="badge rounded-pill bg-pink"><?=$c?></span></a></li><li><a class="nav-link" href="admin/login.php">🔑</a></li>
<?php endif;?></ul></div></div></nav><main class="container py-4">
<?php }
function foot(){echo '</main><footer class="text-center py-4 small text-muted">Toko Mungil by Elvina Utami</footer><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script></body></html>';}