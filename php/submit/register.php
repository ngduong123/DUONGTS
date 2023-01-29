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
    


    
    //date
    //set timezone in HoChiMinh
    date_default_timezone_set("Asia/Ho_Chi_Minh");               
    $date = date("Y-m-d H:i:s");



    //create activation code
    $activation = md5(uniqid(rand(), true));
    $_SESSION["activation"] = $activation;



    //DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK
    try {
        //if in register-form => add user to users table and send activation code
        if (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["password"])) {
            $firstname = $_POST["firstname"];
            checkname($firstname, "First Name");
    
            $lastname = $_POST["lastname"];
            checkname($lastname, "Last Name");
    
            $password = $_POST["password"];
            checkpassword($password);

            //INSERT INTO USERS
            //get max user_id
            $user_id = mysqli_query($conn, "SELECT MAX(user_id) AS max_user_id FROM users");
            while($row = mysqli_fetch_assoc($user_id)) {
                if ($row["max_user_id"] == null){
                    $max_user_id = 1;
                }
                else {
                    $max_user_id = $row["max_user_id"] + 1;
                }
            }

            $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' ");     
            if (mysqli_num_rows($result) > 0) {
                redirectWithError("*An account with that email already exists");
            }
            else{
                if(isset($_POST["role"])) {
                    $role = $_POST["role"];
                }
                else {
                    $role = 0;
                }

                $sql = "INSERT INTO users (user_id, email, password, first_name, last_name, created, activation, status, role, modified) VALUES($max_user_id, '$email', '$password', '$firstname', '$lastname', '$date', '$activation', 0, $role, '$date')";     
                if (!mysqli_query($conn, $sql)) {                 
                    redirectWithError("*An error occurred while trying to add your account to database");
                } 
            }

            //INSERT INTO ADDRESS_BOOK
            $sql = "INSERT INTO address_book (user_id, address_type, first_name, last_name, phone_number, address) VALUES($max_user_id, 1, '$firstname', '$lastname', '', 'Viet Nam')";     
            if (!mysqli_query($conn, $sql)) {                 
                redirectWithError("*An error occurred while trying to add your account to database");
            } 
        }
        else {
            //if in sign-in-form => send activation code
            $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' ");     
            if (mysqli_num_rows($result) <= 0) {
                addpopup("ERROR", "<p>COULDN'T FIND YOUR ACCOUNT.</p>", "<button class='link'><a href='php/register-form.php'>CREATE AN ACCOUNT</a></button>");
                redirectWithError("");
            }
            else{
                while($row = mysqli_fetch_assoc($result)) {
                    if ($row["status"] == 1) {
                        //if account is already activation
                        addpopup("ACCOUNT CREATED", "<p>YOUR ACCOUNT IS ALREADY ACTIVATED. PLEASE SIGN IN.</p>", "");
                        redirectWithError("");
                    }

                    $firstname = $row["first_name"];
                }

                //update activation code
                $sql = "UPDATE users SET activation='$activation'  WHERE email='$email' ";     
                if (!mysqli_query($conn, $sql)) {                 
                    addpopup("ERROR", "<p>AN ERROR OCCURRED WHILE TRYING TO CREATE YOUR ACTIVATION CODE.</p>", "");
                    redirectWithError("");
                } 
            }
        }
        
    }
    catch (Exception $e) {
        redirectWithError("*An error occurred while trying to create your account");
    }



    // SEND THE EMAIL
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = CONTACTFORM_PHPMAILER_DEBUG_LEVEL;
        $mail->isSMTP();
        $mail->Host = CONTACTFORM_SMTP_HOSTNAME;
        $mail->SMTPAuth = true;
        $mail->Username = CONTACTFORM_SMTP_USERNAME;
        $mail->Password = CONTACTFORM_SMTP_PASSWORD;
        $mail->SMTPSecure = CONTACTFORM_SMTP_ENCRYPTION;
        $mail->Port = CONTACTFORM_SMTP_PORT;

        // Recipients
        $mail->setFrom("no-reply@duong456.epizy.com", CONTACTFORM_FROM_NAME);//sender information
        $mail->addAddress($email);//receiver



        // Content    
        // To send HTML mail, the Content-type header must be set
        $mail->isHTML();
        $mail->Headers .= "MIME-Version: 1.0\r\n";
        $mail->Headers .= "Content-Type: text/html; charset=UTF-8\r\n"; 

        $mail->Subject = "WELCOME TO DUONG THAC SI";        

        $mail->Body = 
        '
            <!DOCTYPE html> 
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>ACTIVATE MY ACCOUNT | DUONG THAC SI</title>   
                    <!--font-->
                    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
                    <style>
                        
                        * { 
                            padding: 0;
                            margin: 0;
                            box-sizing: border-box;
                            font-family: "Roboto", sans-serif;
                        } 
            
                        body {
                            min-height: 100vh;
                            position: relative;
                        }
            
                        .container{
                            width: 100%;
                            max-width: 500px;
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%);
                            padding: 20px;
                            color: #000000; 
                            text-transform: uppercase;
                            font-size: 12px;
                        }
            
                        .container p{
                            margin-bottom: 3px;
                        }
            
                        .container a{
                            color: #000000;
                        }
            
                        .container .button-link{
                            display: block;
                            width: 100%;
                            margin: 20px 0 40px 0;
                            padding: 5px;
                            color: #ffffff;
                            background: #000000;
                            text-align: center;
                            text-decoration: none;
                        }
            
                        .container div{
                            margin-top: 20px;
                        }
            
                        .container div p{
                            margin-left: 15px;
                        }
            
                        .container div .title{
                            margin-left: 0;
                            margin-bottom: 5px;
                            font-weight: 600;
                        }
            
                        .container .bottom{
                            margin: 50px 0 30px 0;
                        }
            
                        .container .help{
                            font-size: 11px;
                            text-align: center;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <p>Dear '.$firstname.',</p>
                        <p>Thank you for creating your personal account on <a href="duong456.epizy.com">duong456.epizy.com</a>.</p>
                        <p>Please click on the link below to activate your account (expire in 15 minutes):</p>
                        <a class="button-link" href="localhost/duong456.epizy.com/php/submit/check-activation.php?activation='.$activation.'">Activate my account</a>
                        <p>Your DUONG THAC SI account gives you access to the following services:</p>
                        <div>
                            <p class="title">&#9679; Consult your order details</p>
                            <p>Access your orders details and history.</p>
                        </div>
                        <div>
                            <p class="title">&#9679; Update your personal data</p>
                        </div>
                        <div>
                            <p class="title">&#9679; Manage your address book and card wallet</p>
                            <p>Create and update your delivery addresses and payment methods for a faster checkout.</p>
                        </div>
                        
                        <p class="bottom">KIND REGARDS,<br>DUONG THAC SI CLIENT SERVICE</p>
                        <p class="help">May we help: <a href="mailto:56duong@gmail.com" target="_blank">56duong@gmail.com</a></p>
                    </div><!--container-->  
                </body>
            </html>
        ';
        $mail->send();



        //redirect to sign-in-form.php
        addpopup("REQUEST RECEIVED", "<p>THANK YOU FOR CREATING YOUR ACCOUNT. WE HAVE SENT YOU AN EMAIL WITH THE INFORMATION NEEDED TO CONFIRM YOUR ACCOUNT.</p><p>THE EMAIL MIGHT TAKE A COUPLE OF MINUTES TO REACH YOUR ACCOUNT. PLEASE CHECK YOUR JUNK MAIL TO ENSURE YOU RECEIVE IT.</p>", "");

        header("Location: ../sign-in-form.php?email=".$email."");
        die();

    }

    catch (Exception $e) {
        redirectWithError("*An error occurred while trying to send you an email.");
    }




    mysqli_close($conn);
?>