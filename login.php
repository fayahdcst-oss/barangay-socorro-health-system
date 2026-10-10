<?php

session_start();

$message = "";

if(isset($_SESSION['login_error'])){
    $message = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}


$otp_sent = isset($_GET['otp']) && $_GET['otp'] == 1;


?>


<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
Barangay Socorro Health Center
</title>


<link rel="stylesheet" href="assets/css/styles.css">


</head>


<body>


<div class="shell">


<div class="app-screen active">


<div class="split">



<!-- LEFT PANEL -->

<section class="hero-panel">


<div>


<div class="hero-top">


<div class="brand-mark">

<img src="assets/images/logo.png" alt="Barangay Socorro Logo">

</div>



<nav class="hero-nav">

<a class="active">
Health Center
</a>

<a>
Appointments
</a>

<a>
Records
</a>

</nav>


</div>




<div style="margin-top:35px">


<div class="eyebrow">
Barangay Socorro Health Center
</div>



<h1>
Better health,
closer to home.
</h1>



<p class="hero-copy">

A secure digital healthcare system connecting
patients, doctors, nurses, and administrators.

</p>




<div class="hero-stats">


<div>

<span>
24/7
</span>

<small>
Health Access
</small>

</div>



<div>

<span>
4
</span>

<small>
User Roles
</small>

</div>



<div>

<span>
OTP
</span>

<small>
Secure Login
</small>

</div>



</div>


</div>


</div>




<div class="hero-image-card photo-1">


<div class="hero-image-overlay"></div>


<div class="hero-image-caption">


<strong>
Barangay Socorro Health Center
</strong>


<span>
Providing accessible and secure community healthcare.
</span>


</div>


</div>



</section>





<!-- LOGIN PANEL -->

<section class="login-panel">



<div class="top-row">


<div>

<div class="eyebrow">
Secure Portal
</div>


<h2>
Welcome back
</h2>


</div>



<div class="mini-chip">
OTP Protected
</div>



</div>





<div class="login-card">



<?php if($message != ""): ?>


<div class="info-banner">

<strong>
Notice
</strong>

<?php echo htmlspecialchars($message); ?>


</div>


<?php endif; ?>





<?php if(!$otp_sent): ?>



<form action="backend/send_otp.php" method="POST">



<label>
Email Address
</label>


<input
type="email"
name="email"
placeholder="Enter your registered email"
required>




<div class="button-row">


<button 
type="submit"
class="primary-btn">

Send OTP

</button>


</div>



</form>



<?php else: ?>



<div class="otp-sent-note">

<span>
✓
</span>


OTP sent successfully.
Please check your email.

</div>





<form action="backend/verify_otp.php" method="POST">



<label>
Enter OTP Code
</label>


<input
type="text"
name="otp"
maxlength="6"
placeholder="Enter 6-digit OTP"
required>




<div class="button-row">


<button
type="submit"
class="primary-btn">

Verify OTP

</button>



<a href="login.php" class="ghost-btn">

Change Email

</a>



</div>


</form>




<?php endif; ?>




</div>




<div class="login-trust-row">


<span>
🔒 Secure Authentication
</span>


<span>
📧 Email OTP
</span>


<span>
🏥 Health Records
</span>



</div>



</section>




</div>




<div class="prototype-footer">

Barangay Socorro Health Center System

</div>




</div>


</div>


</body>

</html>