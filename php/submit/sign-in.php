<?php

    require_once '../sendmail/vendor/autoload.php';
    
    require "../setting/connect.php";
    require_once '../setting/functions.php';

    session_start();
    


    //tieng viet
    mysqli_set_charset($conn, "utf8");



    // Basic check to make sure the form was submitted.
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        redirectWithError("The form must be submitted with POST data.");
    }
    


    $email = $_POST["email"];
    checkemail($email);

    $password = $_POST["password"];
    checkpassword($password);
    


    //DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK
    try {
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' ");
        if(mysqli_num_rows($sql) > 0) {
            while($row = mysqli_fetch_assoc($sql)) {
                if ($row["status"] == 0) {
                    //hasn't activated
                    redirectWithError("*Your account has to be activated before you can sign in. We have sent you an activation link to your email address. Please check your junk mail to ensure you receive it");
                }
                else {
                    if ($password == $row["password"]){
                        //sign-in
                        $_SESSION["loggedin"] = true;
                        $_SESSION["email"] = $email;

                        if ($row["role"] == 1) {
                            $_SESSION["role"] = "admin";
                            header("Location: ../admin/admin.php");
                            die();
                        }
                        else {
                            $_SESSION["role"] = "user";
                            header("Location: ../../index.php");
                            die();
                        }
                    }
                    else {
                        //wrong password
                        redirectWithError("*INVALID LOGIN OR PASSWORD. REMEMBER THAT PASSWORD IS CASE-SENSITIVE. PLEASE TRY AGAIN.");
                    }
                }
                
            }
        }
        else{
            //couldn't find account
            redirectWithError("*COULDN'T FIND YOUR ACCOUNT. PLEASE CREATE YOUR ACCOUNT <a href='php/register-form.php'>HERE</a>");
        }
        
    }
    catch (Exception $e) {
        redirectWithError("*An error occurred while trying to sign in to your account.");
    }




    mysqli_close($conn);
?>