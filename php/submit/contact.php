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

    $topic = $_POST["topic"];

    $firstname = $_POST["firstname"];
    checkname($firstname, "First Name");

    $lastname = $_POST["lastname"];
    checkname($lastname, "Last Name");
    
    $email = $_POST["email"];
    checkemail($email);

    $message = $_POST["message"];
    


    
    //date
    //set timezone in HoChiMinh
    date_default_timezone_set("Asia/Ho_Chi_Minh");               
    $date = date("Y-m-d H:i:s");



    //create activation code
    $activation = md5(uniqid(rand(), true));
    $_SESSION["activation"] = $activation;



    //DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK

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
        $mail->setFrom("customer@duong456.epizy.com");//sender information
        $mail->addAddress("56duong@gmail.com");//receiver



        // Content    
        // To send HTML mail, the Content-type header must be set
        $mail->isHTML();
        $mail->Headers .= "MIME-Version: 1.0\r\n";
        $mail->Headers .= "Content-Type: text/html; charset=UTF-8\r\n"; 

        $mail->Subject = "CONTACT FROM CUSTOMER";        

        $mail->Body = 
        '
            <!DOCTYPE html> 
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>CONTACT FROM CUSTOMER | DUONG THAC SI</title>   
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
                        <p>From '.$firstname.' '.$lastname.',</p>
                        <p>TOPIC: '.$topic.'</p>
                        <p>Email: <a href = "mailto: '.$email.'">'.$email.'</a></p>
                        <p>Message: '.$message.'</p>
                    </div><!--container-->  
                </body>
            </html>
        ';
        $mail->send();



        $_SESSION['text'] = "<p><b>THANK YOU</b></p><p>THANK YOU FOR CONTACTING US.</p><p>YOUR MESSAGE HAS BEEN SUCCESSFULLY SENT.</p>";
        header("Location: success.php");
        die();

    }

    catch (Exception $e) {
        redirectWithError("*An error occurred while trying to send you an email.");
    }




    mysqli_close($conn);
?>