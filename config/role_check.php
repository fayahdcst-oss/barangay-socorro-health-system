<?php

require_once __DIR__ . "/auth.php";


function checkRole($allowedRole){

    if(!isset($_SESSION['role'])){

        header("Location: login.php");
        exit();

    }


    if($_SESSION['role'] !== $allowedRole){

        header("Location: login.php");
        exit();

    }

}

?>