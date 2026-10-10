<?php

session_start();

require_once __DIR__ . '/../config/db.php';


if($_SERVER['REQUEST_METHOD'] !== 'POST'){

    header("Location: ../login.php");
    exit();

}



$otp = trim($_POST['otp'] ?? "");

$email = $_SESSION['otp_email'] ?? "";



if(empty($email)){

    $_SESSION['login_error'] = "OTP session expired.";
    header("Location: ../login.php");
    exit();

}



if(empty($otp)){

    $_SESSION['login_error'] = "Please enter OTP.";
    header("Location: ../login.php?otp=1");
    exit();

}



try{


    $stmt = $pdo->prepare("
        SELECT *
        FROM otps
        WHERE email = ?
        AND otp_code = ?
        AND expires_at > NOW()
    ");


    $stmt->execute([
        $email,
        $otp
    ]);


    $otpData = $stmt->fetch(PDO::FETCH_ASSOC);



    if(!$otpData){

        $_SESSION['login_error'] = "Invalid or expired OTP.";
        header("Location: ../login.php?otp=1");
        exit();

    }




    $userQuery = $pdo->prepare("
        SELECT *
        FROM users
        WHERE email = ?
    ");


    $userQuery->execute([$email]);


    $user = $userQuery->fetch(PDO::FETCH_ASSOC);



    if(!$user){

        $_SESSION['login_error'] = "User not found.";
        header("Location: ../login.php");
        exit();

    }





    // CREATE LOGIN SESSION

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];



    // DELETE OTP

    $delete = $pdo->prepare("
        DELETE FROM otps
        WHERE email = ?
    ");

    $delete->execute([$email]);



    unset($_SESSION['otp_email']);




    // REDIRECT

    if($user['role'] == "patient"){

        header("Location: ../patient_dashboard.php");

    }
    elseif($user['role'] == "doctor"){

        header("Location: ../doctor_dashboard.php");

    }
    elseif($user['role'] == "nurse"){

        header("Location: ../nurse_dashboard.php");

    }
    elseif($user['role'] == "admin"){

        header("Location: ../admin_dashboard.php");

    }
    else{

        header("Location: ../login.php");

    }


    exit();



}catch(PDOException $e){

    echo "DATABASE ERROR: ".$e->getMessage();

}

?>