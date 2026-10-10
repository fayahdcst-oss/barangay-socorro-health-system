<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/mail.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/phpmailer/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit("Invalid request.");
}

$email = trim($_POST['email'] ?? '');

if (empty($email)) {
    exit("Please enter your email.");
}

try {

    // Check if user exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if (!$stmt->fetch()) {
        exit("This email is not registered.");
    }

    // Generate OTP
    $otp = random_int(100000, 999999);

    // Expiration
    $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));
    
    // Delete previous OTP
    $delete = $pdo->prepare("DELETE FROM otps WHERE email=?");
    $delete->execute([$email]);

    // Save new OTP
    $insert = $pdo->prepare("
        INSERT INTO otps(email, otp_code, expires_at)
        VALUES(?,?,?)
    ");

    $insert->execute([
        $email,
        $otp,
        $expires
    ]);

    // ==========================
    // PHPMailer
    // ==========================

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->Username = MAIL_USERNAME;
    $mail->Password = MAIL_PASSWORD;

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->CharSet = 'UTF-8';

    $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
    $mail->addAddress($email);

    $mail->isHTML(true);

    $mail->Subject = 'Barangay Socorro Health Center OTP';

    $mail->Body = "
        <h2>Barangay Socorro Health Center</h2>

        <p>Your verification code is:</p>

        <h1 style='font-size:40px;'>$otp</h1>

        <p>This code will expire in 5 minutes.</p>

        <hr>

        <small>If you did not request this code, you may ignore this email.</small>
    ";

    $mail->AltBody = "Your OTP is: $otp";

    $mail->send();

    session_start();

$_SESSION['otp_email'] = $email;

header("Location: ../login.php?otp=1");
exit();

} catch (Exception $e) {

    echo "<h2>MAIL ERROR</h2>";
    echo "<pre>";
    echo $mail->ErrorInfo;
    echo "</pre>";

} catch (PDOException $e) {

    echo "<h2>DATABASE ERROR</h2>";
    echo "<pre>";
    echo $e->getMessage();
    echo "</pre>";
}