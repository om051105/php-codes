<?php
session_start();
$conn = mysqli_connect("localhost","root","");
mysqli_query($conn,"CREATE DATABASE IF NOT EXISTS lostfound_db");
mysqli_select_db($conn,"lostfound_db");
mysqli_query($conn,"CREATE TABLE IF NOT EXISTS users(id INT AUTO_INCREMENT PRIMARY KEY,username VARCHAR(50),password VARCHAR(50),email VARCHAR(100))");
mysqli_query($conn,"CREATE TABLE IF NOT EXISTS items(id INT AUTO_INCREMENT PRIMARY KEY,type ENUM('lost','found'),item_name VARCHAR(100),description TEXT,location VARCHAR(100),category VARCHAR(50),reported_by VARCHAR(50),reported_on DATE)");
if(!mysqli_num_rows(mysqli_query($conn,"SELECT*FROM users WHERE username='admin'")))
    mysqli_query($conn,"INSERT INTO users VALUES(NULL,'admin','admin123','admin@college.com')");

$p   = $_GET['page'] ?? 'login';
$msg = "";
$u   = $_SESSION['username'] ?? null;

if($p=='logout'){ session_destroy(); header("Location:?page=login"); exit; }
if($u && $p=='login') $p='dashboard';
if(!$u && in_array($p,['dashboard','report_lost','report_found','view'])) $p='login';

if($_SERVER['REQUEST_METHOD']=='POST'){
    if($p=='login'){
        $r=mysqli_query($conn,"SELECT*FROM users WHERE username='{$_POST['username']}' AND password='{$_POST['password']}'");
        if(mysqli_num_rows($r)){$_SESSION['username']=$_POST['username'];header("Location:?page=dashboard");exit;}
        else $msg="<p class=e>Wrong username or password.</p>";
    }
    if($p=='register'){
        if(mysqli_num_rows(mysqli_query($conn,"SELECT*FROM users WHERE username='{$_POST['username']}'")))
            $msg="<p class=e>Username taken.</p>";
        else{ mysqli_query($conn,"INSERT INTO users VALUES(NULL,'{$_POST['username']}','{$_POST['password']}','{$_POST['email']}')"); $msg="<p class=s>Registered! <a href='?page=login'>Login</a></p>"; }
    }
    if($p=='report_lost'||$p=='report_found'){
        $type=str_replace('report_','',$p);
        mysqli_query($conn,"INSERT INTO items VALUES(NULL,'$type','{$_POST['item_name']}','{$_POST['description']}','{$_POST['location']}','{$_POST['category']}','$u','".date('Y-m-d')."')");
        $msg="<p class=s>Reported! <a href='?page=view'>View all</a></p>";
    }
}

$cats="<option>Electronics</option><option>Wallet/Purse</option><option>Books</option><option>Keys</option><option>Bag</option><option>Other</option>";
?>
<!DOCTYPE html><html><head><title>Lost & Found</title><style>
*{box-sizing:border-box;margin:0;padding:0;font-family:Arial,sans-serif}
body{background:#eef2f7}
nav{background:#1a1a2e;padding:13px 25px;display:flex;justify-content:space-between;align-items:center;color:white}
nav a{color:#ccc;text-decoration:none;margin-left:14px;font-size:14px}
nav a:hover{color:white}
.lo{background:#e74c3c;color:white!important;padding:5px 13px;border-radius:5px}
.box{background:white;max-width:420px;margin:55px auto;padding:32px;border-radius:12px;box-shadow:0 4px 14px rgba(0,0,0,.1)}
.box h2{margin-bottom:4px;color:#1a1a2e} .box p{color:#888;font-size:13px;margin-bottom:18px}
label{font-size:13px;font-weight:bold;color:#444;display:block;margin-bottom:4px}
input,select,textarea{width:100%;padding:10px;border:1px solid #ddd;border-radius:7px;font-size:14px;margin-bottom:13px;font-family:Arial}
textarea{height:75px;resize:vertical}
button{width:100%;padding:12px;border:none;border-radius:7px;color:white;font-size:15px;cursor:pointer}
.bl{background:#0288d1} .gr{background:#27ae60} .rd{background:#e74c3c}
button:hover{opacity:.88}
.e{background:#ffe0e0;color:#e74c3c;padding:9px;border-radius:7px;margin-bottom:12px;font-size:13px}
.s{background:#e0f9e0;color:#27ae60;padding:9px;border-radius:7px;margin-bottom:12px;font-size:13px}
.wrap{max-width:900px;margin:35px auto;padding:0 18px}
.row{display:flex;gap:18px;margin:18px 0}
.stat{flex:1;background:white;padding:22px;border-radius:10px;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,.07)}
.stat b{font-size:34px} .stat small{color:#888;font-size:13px;display:block}
.card{flex:1;background:white;border-radius:10px;padding:25px 18px;text-align:center;text-decoration:none;color:#1a1a2e;box-shadow:0 2px 8px rgba(0,0,0,.07);border:2px solid #eee}
.card:hover{border-color:#0288d1} .card b{display:block;margin-bottom:5px} .card small{color:#888;font-size:12px}
table{width:100%;border-collapse:collapse;background:white;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.07)}
th{background:#1a1a2e;color:white;padding:12px 13px;text-align:left;font-size:13px}
td{padding:11px 13px;border-bottom:1px solid #f0f0f0;font-size:14px}
.bl2{background:#ffe0e0;color:#e74c3c;padding:3px 9px;border-radius:12px;font-size:12px;font-weight:bold}
.gr2{background:#e0f9e0;color:#27ae60;padding:3px 9px;border-radius:12px;font-size:12px;font-weight:bold}
</style></head><body>

<?php if($u): ?>
<nav><b>Lost & Found Portal</b><div>
    <a href="?page=dashboard">Home</a>
    <a href="?page=report_lost">Report Lost</a>
    <a href="?page=report_found">Report Found</a>
    <a href="?page=view">View Items</a>
    <a href="?page=logout" class=lo>Logout</a>
</div></nav>
<?php endif; ?>

<?php if($p=='login'): ?>
<div class=box><h2>Lost & Found Portal</h2><p>Login to your account</p>
<?=$msg?>
<form method=POST>
<label>Username</label><input name=username placeholder="Username" required>
<label>Password</label><input type=password name=password placeholder="Password" required>
<button class=bl>Login</button>
</form><br><small><a href="?page=register">No account? Register</a> &nbsp;|&nbsp; Demo: admin / admin123</small>
</div>

<?php elseif($p=='register'): ?>
<div class=box><h2>Register</h2><p>Create a new account</p>
<?=$msg?>
<form method=POST>
<label>Email</label><input type=email name=email placeholder="Email" required>
<label>Username</label><input name=username placeholder="Username" required>
<label>Password</label><input type=password name=password placeholder="Password" required>
<button class=gr>Register</button>
</form><br><small><a href="?page=login">Already have an account?</a></small>
</div>

<?php elseif($p=='dashboard'):
    $t=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*)c FROM items"))['c'];
    $l=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*)c FROM items WHERE type='lost'"))['c'];
    $f=mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*)c FROM items WHERE type='found'"))['c'];
?>
<div class=wrap><h2>Welcome, <?=$u?>!</h2><p style="color:#888">Manage lost and found items.</p>
<div class=row>
    <div class=stat><b style="color:#0288d1"><?=$t?></b><small>Total Items</small></div>
    <div class=stat><b style="color:#e74c3c"><?=$l?></b><small>Lost Items</small></div>
    <div class=stat><b style="color:#27ae60"><?=$f?></b><small>Found Items</small></div>
</div>
<div class=row>
    <a href="?page=report_lost"  class=card><b>Report Lost Item</b><small>I lost something</small></a>
    <a href="?page=report_found" class=card><b>Report Found Item</b><small>I found something</small></a>
    <a href="?page=view"         class=card><b>View All Items</b><small>Browse all reports</small></a>
</div></div>

<?php elseif($p=='report_lost'||$p=='report_found'):
    $type = ($p=='report_lost') ? 'Lost' : 'Found';
    $col  = ($p=='report_lost') ? 'rd'   : 'gr';
?>
<div class=box style="max-width:520px"><h2 style="color:<?=$p=='report_lost'?'#e74c3c':'#27ae60'?>">Report <?=$type?> Item</h2>
<p>Fill in details of the item</p><?=$msg?>
<form method=POST style="text-align:left">
<label>Item Name</label><input name=item_name placeholder="e.g. Black Wallet" required>
<label>Category</label><select name=category><?=$cats?></select>
<label>Location</label><input name=location placeholder="e.g. Library, Canteen" required>
<label>Description</label><textarea name=description placeholder="Describe the item..."></textarea>
<button class=<?=$col?>>Submit <?=$type?> Report</button>
</form></div>

<?php elseif($p=='view'): ?>
<div class=wrap><h2>All Reported Items</h2>
<table><thead><tr><th>#</th><th>Type</th><th>Item</th><th>Category</th><th>Location</th><th>By</th><th>Date</th></tr></thead><tbody>
<?php
$r=mysqli_query($conn,"SELECT*FROM items ORDER BY reported_on DESC");
$i=1;
if(mysqli_num_rows($r)):while($row=mysqli_fetch_assoc($r)):
    $b=$row['type']=='lost'?"<span class=bl2>Lost</span>":"<span class=gr2>Found</span>";
    echo "<tr><td>$i</td><td>$b</td><td><b>{$row['item_name']}</b><br><small style='color:#aaa'>{$row['description']}</small></td><td>{$row['category']}</td><td>{$row['location']}</td><td>{$row['reported_by']}</td><td>{$row['reported_on']}</td></tr>";
    $i++;
endwhile;else: echo "<tr><td colspan=7 style='text-align:center;padding:25px;color:#aaa'>No items yet.</td></tr>";
endif;?>
</tbody></table></div>

<?php endif;?>
</body></html>
