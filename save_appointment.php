<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

session_start();
require_once "config/db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role']!="patient"){
    header("Location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"]!="POST"){
    header("Location: patient_appointment.php");
    exit();
}

$patient_id=$_SESSION['user_id'];
$consultation_type=trim($_POST['consultation_type']);
$service_type=trim($_POST['service_type']);
$appointment_date=$_POST['appointment_date'];
$appointment_time=$_POST['appointment_time'];
$reason=trim($_POST['reason']);

if(
empty($consultation_type) ||
empty($service_type) ||
empty($appointment_date) ||
empty($appointment_time) ||
empty($reason)
){
die("Please complete all appointment information.");
}


/* CHECK IF SLOT IS ALREADY TAKEN */

$check=$pdo->prepare("
SELECT id
FROM appointments
WHERE appointment_date=?
AND appointment_time=?
AND status!='Cancelled'
LIMIT 1
");

$check->execute([
$appointment_date,
$appointment_time
]);

if($check->fetch()){

echo "<script>
alert('Sorry, this appointment slot is already booked.');
window.history.back();
</script>";

exit();

}


/* SAVE APPOINTMENT */

$insert=$pdo->prepare("
INSERT INTO appointments
(
patient_id,
doctor_id,
service_type,
consultation_type,
appointment_date,
appointment_time,
reason,
status,
meeting_url
)
VALUES
(
?,
NULL,
?,
?,
?,
?,
?,
'Pending',
NULL
)
");

$insert->execute([
$patient_id,
$service_type,
$consultation_type,
$appointment_date,
$appointment_time,
$reason
]);

echo "<script>
alert('Appointment booked successfully!');
window.location='patient_dashboard.php';
</script>";

?>