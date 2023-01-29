<?php

    require_once '../sendmail/vendor/autoload.php';
    
    require "../setting/connect.php";
    require_once '../setting/functions.php';

    session_start();
    


    //tieng viet
    mysqli_set_charset($conn, "utf8");
    


    //DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK
    try {
        $_SESSION['loggedin'] = false;
        unset($_SESSION["email"]);
        unset($_SESSION["role"]);
        header("Location: ../sign-in-form.php");
    }
    catch (Exception $e) {
        redirectWithError("*An error occurred while trying to log out your account");
    }

?>