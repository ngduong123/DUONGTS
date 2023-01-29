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



    //from reset-password-form
    if (isset($_POST["token"])) {
        //reset password
        $token = $_POST["token"];
        $newpassword = $_POST["newpassword"];

        try {
            $sql2 = "UPDATE users SET password='$newpassword' WHERE token='$token'";     
            if (!mysqli_query($conn, $sql2)) {                 
                redirectWithError("*An error occurred while trying to reset your password");
            } 
            else {
                //get email
                $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE token='$token' ");
                if(mysqli_num_rows($sql3) > 0) {
                    while($row = mysqli_fetch_assoc($sql3)) {
                        $email = $row["email"];
                    }
                }
                else{
                    //couldn't find account
                    addpopup("ERROR", "<p>COULDN'T FIND YOUR ACCOUNT.</p>", "<button class='link'><a href='php/register-form.php'>CREATE AN ACCOUNT</a></button>");

                    header("Location: ../sign-in-form.php?email=".$email."");
                    die();
                }

                //update success
                header("Location: ../sign-in-form.php?email=".$email."");
                die();
            }
        }
        catch (Exception $e) {
            redirectWithError("*An error occurred while trying reset your password");
        } 
    }
    //from sign-in-form
    else {
        $email = $_POST["email"];

        //send link reset password
        //create token code
        $token = md5(uniqid(rand(), true));
        $_SESSION["token"] = $token;



        //DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK
        try {
            //insert token into users
            $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' ");     
            if (mysqli_num_rows($result) <= 0) {
                redirectWithError("*COULDN'T FIND YOUR ACCOUNT.");
            }
            else{
                while($row = mysqli_fetch_assoc($result)) {
                    $firstname = $row["first_name"];
                }
                
                $sql = "UPDATE users SET token='$token' WHERE email='$email'";     
                if (!mysqli_query($conn, $sql)) {                 
                    redirectWithError("*An error occurred while trying to reset your password");
                } 
            }
        }
        catch (Exception $e) {
            redirectWithError("*An error occurred while trying to reset your password");
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

            $mail->Subject = "YOUR ACCOUNT PASSWORD RESET REQUEST";        

            $mail->Body = 
            '
                <!DOCTYPE html> 
                <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta http-equiv="X-UA-Compatible" content="ie=edge">
                        <title>RESET MY PASSWORD | DUONG THAC SI</title>   
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
                
                            .container div p{
                                margin-left: 15px;
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
                            <p>We have received your request to reset your password.</p>
                            <p>Please proceed with the update by clicking <a href="localhost/duong456.epizy.com/php/reset-password-form.php?token='.$token.'">HERE</a></p>
                            <p>If you have not requested a password reset, please contact our <a href="localhost/duong456.epizy.com/php/contact-us.php">Client Service</a></p>
                            
                            <p class="bottom">KIND REGARDS,<br>DUONG THAC SI CLIENT SERVICE</p>
                            <p class="help">May we help: <a href="mailto:56duong@gmail.com" target="_blank">56duong@gmail.com</a></p>
                        </div><!--container-->  
                    </body>
                </html>
            ';
            $mail->send();



            //redirect to sign-in-form.php
            addpopup("E-MAIL SENT", "<p>THANK YOU FOR SUBMITTING YOUR EMAIL ADDRESS.</p><p> IF YOU ALREADY HAVE AN ACCOUNT, YOU WILL RECEIVE IN FEW MINUTES AN EMAIL WITH THE INFORMATION NEEDED TO RESET YOUR PASSWORD.</p><p>PLEASE CHECK YOUR SPAM TO ENSURE YOU RECEIVED IT.</p>", "");

            header("Location: ../sign-in-form.php?email=".$email."");
            die();

        }

        catch (Exception $e) {
            redirectWithError("*An error occurred while trying reset your password");
        }
    }
    


    mysqli_close($conn);
?>