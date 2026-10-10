<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


if ($_SESSION['role'] !== 'nurse') {
    die("Access Denied.");
}

?>


<!DOCTYPE html>
<html>

<head>

<title>Nurse Dashboard</title>

<style>

body{
    font-family:Arial;
    background:#f4f6f9;
    margin:40px;
}


.card{

    max-width:700px;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 5px 15px #ccc;

}


h1{
    color:#fd7e14;
}


.info{
    margin:15px 0;
    font-size:18px;
}


.logout{

    display:inline-block;
    margin-top:20px;
    background:#dc3545;
    color:white;
    padding:10px 20px;
    text-decoration:none;
    border-radius:6px;

}


</style>


</head>


<body>


<div class="card">


<h1>
Nurse Dashboard
</h1>


<div class="info">
<strong>ID:</strong>
<?php echo htmlspecialchars($_SESSION['user_id']); ?>
</div>


<div class="info">
<strong>Name:</strong>
<?php echo htmlspecialchars($_SESSION['full_name']); ?>
</div>


<div class="info">
<strong>Email:</strong>
<?php echo htmlspecialchars($_SESSION['email']); ?>
</div>


<div class="info">
<strong>Role:</strong>
<?php echo htmlspecialchars($_SESSION['role']); ?>
</div>


<a class="logout" href="backend/logout.php">
Logout
</a>


</div>


</body>
</html>