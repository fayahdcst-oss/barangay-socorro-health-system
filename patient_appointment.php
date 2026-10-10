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

<title>Book Appointment - Barangay Socorro Health Center</title>

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

.hidden{
    display:none;
}

.choice-card.selected{
    border:2px solid #2563eb;
}

.step{
    display:none;
}

.step.active{
    display:block;
}

</style>

</head>


<body>


<section class="app-screen active" id="role-patient">


<header class="app-topbar">


<div class="brand">

<img src="assets/images/logo.png">


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


<a class="nav-item" href="patient_dashboard.php">
Dashboard
</a>


<a class="nav-item active">
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
Appointment flow
</p>

<h3>
Book an appointment
</h3>

</div>


<div class="mini-chip">
Secure booking flow
</div>


</div>





<!-- STEP 1 -->

<div class="card step active" id="step1">


<div class="card-head">

<div>

<p class="section-label">
Step 1
</p>

<h4>
Choose appointment type
</h4>

</div>

</div>




<div class="grid-2">


<button 
type="button"
class="choice-card selected"
onclick="chooseType('face',this)"
>

<b>
Face-to-face visit
</b>

<span>
Visit the health center personally
</span>

</button>



<button 
type="button"
class="choice-card"
onclick="chooseType('online',this)"
>

<b>
Online consultation
</b>

<span>
Consult through video call
</span>

</button>


</div>




<div id="platformBox" class="hidden">


<br>

<h4>
Choose video platform
</h4>



<div class="grid-2">


<button 
type="button"
class="choice-card selected"
onclick="choosePlatform(this)"
>

<b>
Google Meet
</b>

<span>
Use Google Meet
</span>

</button>



<button 
type="button"
class="choice-card"
onclick="choosePlatform(this)"
>

<b>
Zoom
</b>

<span>
Use Zoom
</span>

</button>



</div>


</div>





<br>


<label>
Reason for visit
</label>


<textarea 
id="reason"
placeholder="Example: fever, cough, follow-up checkup">
</textarea>




<br><br>


<label>

<input type="checkbox" id="emergency">

I think this may be an emergency

</label>




<br><br>



<div class="button-row">


<button 
class="primary-btn"
onclick="nextStep(2)"
>

Continue

</button>


</div>



</div>
<!-- STEP 2 -->

<div class="card step" id="step2">

<div class="card-head">
<div>
<p class="section-label">Step 2</p>
<h4>What do you need help with?</h4>
</div>
</div>

<div class="grid-2">

<button type="button" class="choice-card selected" onclick="selectConcern(this)">
<b>General health concern</b>
<span>I'm not sure which service I need</span>
</button>

<button type="button" class="choice-card" onclick="selectConcern(this)">
<b>Follow-up</b>
<span>Review an existing condition</span>
</button>

<button type="button" class="choice-card" onclick="selectConcern(this)">
<b>Child health</b>
<span>For children or young patients</span>
</button>

<button type="button" class="choice-card" onclick="selectConcern(this)">
<b>Women's health</b>
<span>Reproductive health concern</span>
</button>

<button type="button" class="choice-card" onclick="selectConcern(this)">
<b>Skin concern</b>
<span>Rash, irritation, or skin issue</span>
</button>

<button type="button" class="choice-card" onclick="selectConcern(this)">
<b>Chronic condition</b>
<span>Ongoing care or medication review</span>
</button>

</div>

<div class="button-row">
<button class="ghost-btn" onclick="nextStep(1)">Back</button>
<button class="primary-btn" onclick="nextStep(3)">Continue</button>
</div>

</div>



<!-- STEP 3 -->

<div class="card step" id="step3">

<div class="card-head">
<div>
<p class="section-label">Step 3</p>
<h4>Select date and time</h4>
</div>
</div>


<label>Select appointment date</label>

<input type="date" id="appointmentDate">



<br><br>


<label>Available time</label>

<div class="grid-2">

<button type="button" class="choice-card selected" onclick="selectTime(this)">
<b>9:00 AM</b>
<span>Available</span>
</button>

<button type="button" class="choice-card" onclick="selectTime(this)">
<b>10:30 AM</b>
<span>Available</span>
</button>

<button type="button" class="choice-card" onclick="selectTime(this)">
<b>2:00 PM</b>
<span>Available</span>
</button>

<button type="button" class="choice-card" onclick="selectTime(this)">
<b>3:30 PM</b>
<span>Available</span>
</button>

</div>


<div class="button-row">
<button class="ghost-btn" onclick="nextStep(2)">Back</button>
<button class="primary-btn" onclick="nextStep(4)">Continue</button>
</div>


</div>

<!-- STEP 4 -->

<div class="card step" id="step4">

<div class="card-head">
<div>
<p class="section-label">Step 4</p>
<h4>Confirm appointment</h4>
</div>
</div>


<div class="card">

<p><b>Patient:</b> <?= htmlspecialchars($name) ?></p>

<p><b>Appointment type:</b> <span id="summaryType">Face-to-face</span></p>

<p><b>Concern:</b> <span id="summaryConcern">General health concern</span></p>

<p><b>Date:</b> <span id="summaryDate">Not selected</span></p>

<p><b>Time:</b> <span id="summaryTime">9:00 AM</span></p>

<p><b>Reason:</b> <span id="summaryReason">No reason provided</span></p>

</div>


<div class="button-row">

<button class="ghost-btn" onclick="nextStep(3)">
Back
</button>


<form action="save_appointment.php" method="POST">

<input type="hidden" name="consultation_type" id="formType">

<input type="hidden" name="service_type" id="formService">

<input type="hidden" name="appointment_date" id="formDate">

<input type="hidden" name="appointment_time" id="formTime">


<button type="button" class="primary-btn" onclick="prepareSubmit()">
Confirm booking
</button>

</form>

</div>


</div>


</div>

</section>

</div>

</section>


<script>

let appointmentType="Face-to-face";
let concern="General health concern";
let selectedTime="9:00 AM";


function nextStep(step){

document.querySelectorAll(".step").forEach(function(s){
    s.classList.remove("active");
});

document.getElementById("step"+step).classList.add("active");


if(step===4){

document.getElementById("summaryType").innerText = appointmentType;
document.getElementById("summaryConcern").innerText = concern;
document.getElementById("summaryDate").innerText =
document.getElementById("appointmentDate").value || "Not selected";

document.getElementById("summaryTime").innerText = selectedTime;

document.getElementById("summaryReason").innerText =
document.getElementById("reason").value || "No reason provided";

}

}


function chooseType(type,btn){

document.querySelectorAll("#step1 .choice-card").forEach(function(card){
    card.classList.remove("selected");
});

btn.classList.add("selected");

let platform=document.getElementById("platformBox");

if(type==="online"){

appointmentType="Online consultation";
platform.classList.remove("hidden");

}else{

appointmentType="Face-to-face";
platform.classList.add("hidden");

}

}


function choosePlatform(btn){

document.querySelectorAll("#platformBox .choice-card").forEach(function(card){
    card.classList.remove("selected");
});

btn.classList.add("selected");

}


function selectConcern(btn){

document.querySelectorAll("#step2 .choice-card").forEach(function(card){
    card.classList.remove("selected");
});

btn.classList.add("selected");

concern=btn.querySelector("b").innerText;

}


function selectTime(btn){

document.querySelectorAll("#step3 .choice-card").forEach(function(card){
    card.classList.remove("selected");
});

btn.classList.add("selected");

selectedTime=btn.querySelector("b").innerText;

}


function prepareSubmit(){

alert(
"Type: " + appointmentType +
"\nConcern: " + concern +
"\nDate: " + document.getElementById("appointmentDate").value +
"\nTime: " + selectedTime
);

document.getElementById("formType").value = appointmentType;
document.getElementById("formService").value = concern;
document.getElementById("formDate").value = document.getElementById("appointmentDate").value;
document.getElementById("formTime").value = selectedTime;

document.querySelector("form").submit();

}

alert(
"Appointment submitted successfully!\n\n"+
appointmentType+"\n"+
concern+"\n"+
selectedTime
);

}

</script>


<script src="assets/js/app.js"></script>

</body>
</html>