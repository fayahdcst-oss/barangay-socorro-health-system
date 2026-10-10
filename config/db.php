<?php

$host = 'localhost';
$db_name = 'barangay_socorro_health';
$username = 'root';
$password = '';

try {

    date_default_timezone_set('Asia/Manila');


    $pdo = new PDO(
        "mysql:host=$host;dbname=$db_name;charset=utf8mb4",
        $username,
        $password
    );


    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);



    // Make MySQL follow Philippines timezone
    $pdo->exec("SET time_zone = '+08:00'");


} catch (PDOException $e) {

    die("Database Connection Failed: " . $e->getMessage());

}

?>