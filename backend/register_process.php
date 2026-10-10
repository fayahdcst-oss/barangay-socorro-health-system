<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../register.php");
    exit();
}

$full_name = trim($_POST["full_name"]);
$email = trim($_POST["email"]);
$password = $_POST["password"];
$phone = trim($_POST["phone"]);
$role = "patient";

if (empty($full_name) || empty($email) || empty($password)) {
    die("Please complete all required fields.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address.");
}

try {

    // Check existing email
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);

    if ($check->fetch()) {
        die("
            <h3>Email already registered.</h3>
            <a href='../register.php'>Go Back</a>
        ");
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $insert = $pdo->prepare("
        INSERT INTO users
        (full_name,email,password_hash,role,phone)
        VALUES
        (?,?,?,?,?)
    ");

    $insert->execute([
        $full_name,
        $email,
        $password_hash,
        $role,
        $phone
    ]);

    echo "
    <h2>Registration Successful!</h2>

    <p>Welcome, <strong>$full_name</strong>.</p>

    <a href='../index.html'>Go to Homepage</a>
    ";

} catch(PDOException $e){
    die("Database Error: ".$e->getMessage());
}