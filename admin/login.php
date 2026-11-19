<?php require '../config.php';$err='';
if($_SERVER['REQUEST_METHOD']=='POST'){$a=one(q("SELECT * FROM admin WHERE username=? AND password=?",'ss',[$_POST['u'],hash('sha256',$_POST['p'])]));
 if($a){$_SESSION['admin']=$a['username'];header('Location: index.php');exit;}$err='Username / password salah 🥺';}
head('Login Admin');?>
<form method="post" class="card-cute p-4 mx-auto" style="max-width:380px"><h4 class="text-center">Login Admin</h4><?php if($err)echo "<div class='alert alert-danger'>$err</div>";?>
<input name="u" class="form-control mb-2" placeholder="Username" required><input name="p" type="password" class="form-control mb-3" placeholder="Password" required><button class="btn btn-pink w-100">Masuk</button></form><?php foot();
