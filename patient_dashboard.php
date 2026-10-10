<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient'){
    header("Location: login.php");
    exit();
}

$name = $_SESSION['full_name'] ?? "Patient";
$patient_id = "P-" . $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html>
<head>

<title>Patient Portal - Barangay Socorro Health Center</title>

<link rel="stylesheet" href="assets/css/styles.css">

<style>

.app-screen{
    display:block !important;
    opacity:1 !important;
    visibility:visible !important;
}

.page{
    display:block !important;
}

</style>

</head>


<body>


<section class="app-screen active" id="role-patient">


<header class="app-topbar">


<div class="brand">

<img src="assets/images/logo.png" alt="Barangay Socorro Health Center logo">


<div>

<h2>
Barangay Socorro Health Center
</h2>

<p>
Patient portal
</p>

</div>


</div>



<div class="who">

<strong>
Hi, <?= htmlspecialchars($name) ?>
</strong>


<span>
Patient ID · <?= htmlspecialchars($patient_id) ?>
</span>


</div>


</header>





<div class="app-body">



<nav class="app-sidebar">


<a class="nav-item active" href="patient_dashboard.php">
Dashboard
</a>



<a class="nav-item" href="patient_appointment.php">
Book appointment
</a>



<a class="nav-item">
Medical records
</a>



<a class="nav-item">
Consultation summary
</a>



</nav>





<section class="app-main">



<div class="page active">





<div class="page-head">


<div>

<p class="section-label">
Today
</p>


<h3>
Good morning, <?= htmlspecialchars($name) ?>
</h3>


</div>



<button class="emergency-btn">
🚨 Emergency help
</button>


</div>





<div class="notification-strip">


<div class="notification-icon">
🔔
</div>



<div>


<strong>
No new notifications
</strong>


<p>
Appointment updates and health center announcements will appear here.
</p>


</div>



</div>







<div class="card consultation-highlight">



<div class="card-head">


<div>


<p class="section-label">
Latest consultation
</p>


<h4>
No consultation records yet
</h4>



</div>



<span class="mini-chip">
-
</span>



</div>



<p>
Your consultation information will appear here after your first completed appointment.
</p>



</div>









<div class="two-col">






<div class="card">



<div class="card-head">


<h4>
Upcoming appointments
</h4>



<span class="subtle">
0 scheduled
</span>



</div>



<p>
You currently have no upcoming appointments.
</p>



</div>










<div class="card accent-card">



<p class="section-label">
Quick actions
</p>



<h4>
Stay on top of your care
</h4>



<p>
Book a consultation or review your medical information.
</p>





<div class="button-row">



<a class="primary-btn" href="patient_appointment.php">
Start consultation
</a>




<a class="ghost-btn" href="patient_appointment.php">
Book an appointment
</a>



</div>



</div>






</div>






</div>



</section>



</div>



</section>




<script src="assets/js/app.js"></script>


</body>
</html>