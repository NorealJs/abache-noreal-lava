<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Users · Student Portal</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


<style>

*,
*::before,
*::after{
    box-sizing:border-box;
    margin:0;
    padding:0;
}


:root{

    --primary:#3b82f6;
    --primary-dark:#2563eb;

    --bg:#0a0a0b;
    --bg2:#111113;
    --card:#131315;

    --text:#f4f4f5;
    --muted:#71717a;

    --border:rgba(255,255,255,.06);

    --glow:rgba(59,130,246,.25);

    --font:'Inter',sans-serif;
}



body{

    font-family:var(--font);
    background:var(--bg);
    color:var(--text);

    min-height:100vh;
    padding:2rem;

    position:relative;

}



body::before{

    content:"";

    position:fixed;
    inset:0;

    background-image:
    linear-gradient(var(--border) 1px,transparent 1px),
    linear-gradient(90deg,var(--border) 1px,transparent 1px);

    background-size:60px 60px;

    mask-image:
    radial-gradient(circle at center,black,transparent 80%);

}



.orb{

    position:fixed;
    border-radius:50%;
    filter:blur(120px);

}



.orb1{

    width:500px;
    height:500px;

    right:-150px;
    top:-150px;

    background:rgba(59,130,246,.15);

}


.orb2{

    width:400px;
    height:400px;

    left:-150px;
    bottom:-150px;

    background:rgba(59,130,246,.08);

}



/* NAV */

nav{

    position:relative;
    z-index:5;

    background:var(--bg2);

    border:1px solid var(--border);

    border-radius:12px;

    padding:.5rem;

    display:flex;

    gap:.5rem;

    justify-content:center;

    max-width:500px;

    margin:auto;

    margin-bottom:2rem;

}


nav a{

    text-decoration:none;

    color:var(--muted);

    padding:.6rem 1.3rem;

    border-radius:8px;

    font-size:.85rem;

    transition:.2s;

}


nav a:hover{

    color:white;
    background:#18181b;

}


nav .active{

    background:var(--primary);

    color:white;

    box-shadow:0 0 25px var(--glow);

}



/* HEADER */


.header{

    position:relative;
    z-index:2;

    max-width:1100px;

    margin:auto;

    margin-bottom:2rem;

}



.header h1{

    font-size:2rem;

    font-weight:800;

}


.highlight{

    color:var(--primary);

}


.header p{

    color:var(--muted);

    margin-top:.5rem;

}



/* USERS GRID */


.container{

    position:relative;
    z-index:2;

    max-width:1100px;

    margin:auto;

}


.grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(280px,1fr));

    gap:1.5rem;

}



/* USER CARD */


.user-card{


    background:var(--card);

    border:1px solid var(--border);

    border-radius:16px;

    padding:1.7rem;

    transition:.25s;

    box-shadow:
    0 20px 60px rgba(0,0,0,.4);

    position:relative;

    overflow:hidden;

}



.user-card::before{


    content:"";

    position:absolute;

    top:0;
    left:0;
    right:0;

    height:2px;

    background:linear-gradient(
        90deg,
        transparent,
        var(--primary),
        transparent
    );


}



.user-card:hover{

    transform:translateY(-5px);

    border-color:rgba(59,130,246,.3);

}




.avatar{


    width:60px;

    height:60px;

    border-radius:50%;

    background:
    rgba(59,130,246,.15);


    border:1px solid rgba(59,130,246,.3);


    color:var(--primary);


    display:flex;

    justify-content:center;

    align-items:center;


    font-size:1.5rem;

    font-weight:800;

    margin-bottom:1rem;


}



.name{

    font-size:1.1rem;

    font-weight:700;

}



.role{

    display:inline-block;

    margin-top:.5rem;

    padding:.25rem .8rem;

    border-radius:20px;

    background:rgba(59,130,246,.1);

    color:#93c5fd;

    font-size:.7rem;

}



.info{

    margin-top:1rem;

    color:var(--muted);

    font-size:.85rem;

}


.info i{

    width:20px;

}




.status{

    margin-top:1rem;

    display:flex;

    align-items:center;

    gap:.5rem;

    font-size:.8rem;

}



.dot{

    width:8px;

    height:8px;

    border-radius:50%;

    background:#22c55e;

    box-shadow:0 0 10px #22c55e;

}


.pending{

    background:#facc15;

}



.inactive{

    background:#ef4444;

}



/* EMPTY */


.empty{

    text-align:center;

    padding:4rem;

    background:var(--card);

    border-radius:16px;

    color:var(--muted);

}



</style>

</head>



<body>


<div class="orb orb1"></div>
<div class="orb orb2"></div>



<nav>

<a href="<?= site_url('student'); ?>">
🏠 Home
</a>

<a href="#" class="active">
👥 Users
</a>

</nav>



<div class="header">

<h1>
User <span class="highlight">Directory</span>
</h1>

<p>
Manage registered users inside the academic portal.
Total Records:
<?= isset($users) ? count($users) : 0 ?>
</p>

</div>



<div class="container">


<?php if(!empty($users)): ?>


<div class="grid">


<?php foreach($users as $user): ?>


<div class="user-card">


<div class="avatar">

<?= strtoupper(substr($user['name'] ?? 'U',0,1)); ?>

</div>



<div class="name">

<?= htmlspecialchars($user['name'] ?? 'Unnamed'); ?>

</div>


<span class="role">

<i class="fa-solid fa-user"></i>

<?= htmlspecialchars($user['role'] ?? 'member'); ?>

</span>



<div class="info">

<p>
<i class="fa-solid fa-envelope"></i>

<?= htmlspecialchars($user['email'] ?? '-'); ?>

</p>


<p>

<i class="fa-solid fa-calendar"></i>

<?= $user['joined'] ?? 'Recently Joined'; ?>

</p>


<p>

<i class="fa-solid fa-id-card"></i>

#<?= htmlspecialchars($user['id'] ?? '000'); ?>

</p>


</div>



<div class="status">


<span class="dot 
<?= 
($user['status'] ?? 'active') == 'pending'
?'pending':
(($user['status'] ?? '')=='inactive'
?'inactive':'')
?>">
</span>


<?= ucfirst($user['status'] ?? 'active'); ?>


</div>



</div>


<?php endforeach; ?>


</div>



<?php else: ?>


<div class="empty">

<i class="fa-solid fa-folder-open fa-3x"></i>

<h3>No users found</h3>

<p>The directory is currently empty.</p>

</div>


<?php endif; ?>


</div>


</body>
</html>