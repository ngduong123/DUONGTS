<?php

    require_once '../sendmail/vendor/autoload.php';
    
    require "../setting/connect.php";
    require_once '../setting/functions.php';

    session_start();
    


    //tieng viet
    mysqli_set_charset($conn, "utf8");



    //Basic check to make sure the form was submitted.
    // if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    //     redirectWithError("The form must be submitted with POST data.");
    // }



    //check log in
    if ($_SESSION["loggedin"] === false || !isset($_SESSION["loggedin"])) {
        header("Location: ../sign-in-form.php");
        die();
    }
    else {
        $email = $_SESSION["email"];
        checkemail($email);
    }



    if (isset($_GET["action"])) {
        $action = $_GET["action"];
    }
    else {
        header("Location: ../account.php");
    }




    $update_type = "";
    


    



    //DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK
    try {

        switch ($action) {
            //EDIT PROFILE EDIT PROFILE EDIT PROFILE EDIT PROFILE EDIT PROFILE
            case "editprofile":
                $firstname = $_POST["firstname"];
                checkname($firstname, "First Name");

                $lastname = $_POST["lastname"];
                checkname($lastname, "Last Name");
                
                if (!empty($_POST["birthdate"])) {
                    $birthdate = '"'.date("Y-m-d", strtotime($_POST["birthdate"])).'"';
                }
                else {
                    $birthdate = "NULL";
                }

                //update profile
                $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' ");     
                if (mysqli_num_rows($result) <= 0) {
                    addpopup("ERROR", "<p>COULDN'T FIND YOUR ACCOUNT.</p>", "<button class='link'><a href='php/register-form.php'>CREATE AN ACCOUNT</a></button>");
                    header("Location: ../account.php");
                }
                else{
                    $sql = "UPDATE users SET first_name='$firstname', last_name='$lastname', birthdate=$birthdate WHERE email='$email' ";     
                    if (!mysqli_query($conn, $sql)) {                 
                        addpopup("ERROR", "<p>AN ERROR OCCURRED WHILE TRYING TO UPDATE YOUR ACCOUNT.</p>", "");
                        header("Location: ../account.php");
                    } 
                    else {
                        addpopup("SUCCESS", "<p>YOUR ACCOUNT HAS BEEN UPDATED.</p>", "");
                        header("Location: ../account.php");
                    }
                }

                $update_type = "Profile details";

            break;



            //EDIT PASSWORD EDIT PASSWORD EDIT PASSWORD EDIT PASSWORD EDIT PASSWORD
            case "editpassword":
                $password = $_POST["password"];
                checkpassword($password);

                $newpassword = $_POST["newpassword"];
                checkpassword($newpassword);

                $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' ");     
                if (mysqli_num_rows($result) <= 0) {
                    addpopup("ERROR", "<p>COULDN'T FIND YOUR ACCOUNT.</p>", "<button class='link'><a href='php/register-form.php'>CREATE AN ACCOUNT</a></button>");
                    header("Location: ../account.php");
                }
                else{
                    while($row = mysqli_fetch_assoc($result)) {
                        if ($password != $row["password"]) {
                            redirectWithError("*WRONG PASSWORD - PLEASE TRY AGAIN");
                        }
                        else {
                            $sql = "UPDATE users SET password='$newpassword' WHERE email='$email' ";     
                            if (!mysqli_query($conn, $sql)) {                 
                                addpopup("ERROR", "<p>AN ERROR OCCURRED WHILE TRYING TO UPDATE YOUR ACCOUNT.</p>", "");
                                header("Location: ../account.php");
                            } 
                            else {
                                addpopup("SUCCESS", "<p>YOUR ACCOUNT HAS BEEN UPDATED.</p>", "");
                                header("Location: ../account.php");
                            }
                        }
                    }
                }  

                $update_type = "Password details";

            break;



            //EDIT ADDRESS EDIT ADDRESS EDIT ADDRESS EDIT ADDRESS EDIT ADDRESS
            case "editaddress":
                //get address_type in url
                if (isset($_GET["address_type"])) {
                    $address_type_in_url = $_GET["address_type"];
                    $result3 = mysqli_query($conn, "SELECT * FROM address_type WHERE address_type='$address_type_in_url' ");     
                    if (mysqli_num_rows($result3) <= 0) {
                        addpopup("ERROR", "<p>COULDN'T FIND THIS ADDRESS TYPE.</p>", "");
                        header("Location: ../account.php");
                    }
                    else {
                        //change address_type_in_url to address_type_in_url_id
                        while($row3 = mysqli_fetch_assoc($result3)) {
                            $address_type_in_url_id = $row3["id"];
                        }
                    }
                }
                else {
                    header("Location: ../account.php");
                }



                $firstname = $_POST["firstname"];
                checkname($firstname, "First Name");
        
                $lastname = $_POST["lastname"];
                checkname($lastname, "Last Name");

                $phonenumber = $_POST["phonenumber"];
                checkphonenumber($phonenumber);

                $address = $_POST["address"];
                checkaddress($address);



                $address_type = $_POST["address_type"];
                $result2 = mysqli_query($conn, "SELECT * FROM address_type WHERE address_type='$address_type' ");     
                if (mysqli_num_rows($result2) <= 0) {
                    addpopup("ERROR", "<p>COULDN'T FIND THIS ADDRESS TYPE.</p>", "");
                    header("Location: ../account.php");
                }
                else {
                    //change address_type to address_type_id
                    while($row2 = mysqli_fetch_assoc($result2)) {
                        $address_type_id = $row2["id"];
                    }
                }

                

                //update profile
                $result = mysqli_query($conn, "SELECT * FROM users, address_book WHERE users.user_id=address_book.user_id AND email='$email' AND address_book.address_type=$address_type_in_url_id ");     
                //couldn't find this email with this address
                if (mysqli_num_rows($result) <= 0) {
                    addpopup("ERROR", "<p>COULDN'T FIND YOUR ADDRESS.</p>", "");
                    header("Location: ../account.php");
                }
                else{
                    //get user_id by email
                    while($row = mysqli_fetch_assoc($result)) {
                        $user_id = $row["user_id"];
                    }

                    //update address_book
                    $sql = "UPDATE address_book SET address_type=$address_type_id, first_name='$firstname', last_name='$lastname', phone_number='$phonenumber', address='$address' WHERE user_id=$user_id AND address_type=$address_type_in_url_id ";     
                    if (!mysqli_query($conn, $sql)) {                 
                        addpopup("ERROR", "<p>AN ERROR OCCURRED WHILE TRYING TO UPDATE YOUR ACCOUNT.</p>", "");
                        header("Location: ../account.php");
                    } 
                    else {
                        addpopup("SUCCESS", "<p>YOUR ACCOUNT HAS BEEN UPDATED.</p>", "");
                        header("Location: ../edit-account-form.php?action=addressbook");
                    }
                }

                $update_type = "Address details";

            break;



            //DELETE ADDRESS DELETE ADDRESS DELETE ADDRESS DELETE ADDRESS DELETE ADDRESS
            case "deleteaddress":
                   
                //get address_type in url
                if (isset($_GET["address_type"])) {
                    $address_type_in_url = $_GET["address_type"];
                    $result = mysqli_query($conn, "SELECT * FROM address_type WHERE address_type='$address_type_in_url' ");     
                    if (mysqli_num_rows($result) <= 0) {
                        addpopup("ERROR", "<p>COULDN'T FIND THIS ADDRESS TYPE.</p>", "");
                        header("Location: ../account.php");
                    }
                    else {
                        //change address_type_in_url to address_type_in_url_id
                        while($row = mysqli_fetch_assoc($result)) {
                            $address_type_in_url_id = $row["id"];
                        }
                    }
                }
                else {
                    header("Location: ../account.php");
                }

                //update profile
                $result2 = mysqli_query($conn, "SELECT * FROM users, address_book WHERE users.user_id=address_book.user_id AND email='$email' AND address_book.address_type=$address_type_in_url_id ");     
                //couldn't find this email with this address
                if (mysqli_num_rows($result2) <= 0) {
                    addpopup("ERROR", "<p>COULDN'T FIND YOUR ADDRESS.</p>", "");
                    header("Location: ../account.php");
                }
                else{
                    //get user_id by email
                    while($row2 = mysqli_fetch_assoc($result2)) {
                        $user_id = $row2["user_id"];
                    }

                    //delete address in address_book
                    $sql = "DELETE FROM address_book WHERE user_id=$user_id AND address_type=$address_type_in_url_id";     
                    if (!mysqli_query($conn, $sql)) {                 
                        addpopup("ERROR", "<p>AN ERROR OCCURRED WHILE TRYING TO UPDATE YOUR ACCOUNT.</p>", "");
                        header("Location: ../account.php");
                    } 
                    else {
                        addpopup("SUCCESS", "<p>YOUR ACCOUNT HAS BEEN UPDATED.</p>", "");
                        header("Location: ../edit-account-form.php?action=addressbook");
                    }
                }

                $update_type = "Address details";

            break;



            //ADD NEW ADDRESS ADD NEW ADDRESS ADD NEW ADDRESS ADD NEW ADDRESS ADD NEW ADDRESS
            case "addnewaddress":

                $address_type = $_POST["address_type"];
                
                //get address_type_available
                $address_type_list_available = "";
                $result = mysqli_query($conn, "SELECT * FROM address_type");         
                while($row = mysqli_fetch_assoc($result)) {
                    $result2 = mysqli_query($conn, "SELECT * FROM address_book, users WHERE address_book.user_id=users.user_id AND email='$email' AND address_book.address_type=".$row['id']." ");
                    if (mysqli_num_rows($result2) <= 0) {
                        $address_type_list_available .= $row["address_type"]." ";
                    }
                }

                //check address_type
                if (!preg_match("/$address_type/i", $address_type_list_available)) {
                    // if address_type already use
                    redirectWithError("*Your account with that Address type already exists");
                }
                else {
                    // get address_type_id by address_type
                    $result3 = mysqli_query($conn, "SELECT * FROM address_type WHERE address_type='$address_type' ");     
                    if (mysqli_num_rows($result3) <= 0) {
                        redirectWithError("*COULDN'T FIND THIS ADDRESS TYPE");
                    }
                    else {
                        while($row3 = mysqli_fetch_assoc($result3)) {
                            $address_type_id = $row3["id"];
                        }
                    }
                }



                $firstname = $_POST["firstname"];
                checkname($firstname, "First Name");
        
                $lastname = $_POST["lastname"];
                checkname($lastname, "Last Name");
                
                $phonenumber = $_POST["phonenumber"];
                checkphonenumber($phonenumber);

                $address = $_POST["address"];
                checkaddress($address);



                //add new address
                $result4 = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' ");     
                if (mysqli_num_rows($result4) <= 0) {
                    addpopup("ERROR", "<p>COULDN'T FIND YOUR ACCOUNT.</p>", "<button class='link'><a href='php/register-form.php'>CREATE AN ACCOUNT</a></button>");
                    header("Location: ../account.php");
                }
                else{
                    while($row4 = mysqli_fetch_assoc($result4)) {
                        //get user_id
                        $user_id = $row4["user_id"];

                        //add to address_book
                        $sql = "INSERT INTO address_book (user_id, address_type, first_name, last_name, phone_number, address) VALUES($user_id, $address_type_id, '$firstname', '$lastname', '$phonenumber', '$address')";     
                        if (!mysqli_query($conn, $sql)) {                 
                            addpopup("ERROR", "<p>AN ERROR OCCURRED WHILE TRYING TO UPDATE YOUR ACCOUNT.</p>", "");
                            header("Location: ../account.php");
                        }  
                        else {
                            addpopup("SUCCESS", "<p>YOUR ACCOUNT HAS BEEN UPDATED.</p>", "");
                            header("Location: ../edit-account-form.php?action=addressbook");
                        }
                    }
                } 

                $update_type = "Address details";

            break;



            
            default:
                addpopup("ERROR", "<p>Something went wrong.</p>", "");
                header("Location: ../account.php");
                
        }
        
    }
    catch (Exception $e) {
        redirectWithError("*An error occurred while trying to update your account");
    }



    //SEND THE EMAIL
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

        $mail->Subject = "YOUR PERSONAL INFORMATION HAVE BEEN UPDATED";        

        $mail->Body = 
        '
            <!DOCTYPE html> 
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>YOUR PERSONAL INFORMATION HAVE BEEN UPDATED | DUONG THAC SI</title>   
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
                        <p>Hi there,</p>
                        <p>WE CONFIRM THAT YOUR FOLLOWING <a href="duong456.epizy.com/php/account.php">PERSONAL ACCOUNT</a> INFORMATION HAVE BEEN UPDATED SUCCESSFULLY:</p>
                        <div>
                            <p class="title">&#9679; '.$update_type.'</p>
                        </div>
                        
                        <p class="bottom">KIND REGARDS,<br>DUONG THAC SI CLIENT SERVICE</p>
                        <p class="help">May we help: <a href="mailto:56duong@gmail.com" target="_blank">56duong@gmail.com</a></p>
                    </div><!--container-->  
                </body>
            </html>
        ';
        $mail->send();  
    }

    catch (Exception $e) {
        redirectWithError("*An error occurred while trying to send you an email.");
    }




    mysqli_close($conn);
?>