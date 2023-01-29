<?php

    require_once '../sendmail/vendor/autoload.php';
    
    require "../setting/connect.php";
    require_once '../setting/functions.php';

    session_start();
    


    //tieng viet
    mysqli_set_charset($conn, "utf8");



    //get activation code
    if (!empty($_GET["activation"])) {
        $activation = $_GET["activation"];
    } 

    //set timezone in HoChiMinh
    date_default_timezone_set("Asia/Ho_Chi_Minh");  
    //get today subtract 15 minutes             
    $date = date("Y-m-d H:i:s");
    $time = strtotime($date);
    $time = $time - (15 * 60);
    $date = date("Y-m-d H:i:s", $time);



    try{
        if (isset($activation)) {
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE activation='$activation' ");
            if (mysqli_num_rows($sql) <= 0) {
                header("Location: ../sign-in-form.php");
            }

            while($row = mysqli_fetch_assoc($sql)) {
                if ($row["status"] == 1){
                    addpopup("ACCOUNT CREATED", "<p>YOUR ACCOUNT IS ALREADY ACTIVATED. PLEASE SIGN IN.</p>", "");

                    //already activated => redirect to sign-in-form.php with activation and email in url
                    header("Location: ../sign-in-form.php?activation=alreadyActivated&email=".$row['email']."");        
                    die();
                }
                else if($row["modified"] < $date) {
                    addpopup("ERROR", '<p>YOUR ACTIVATION EMAIL HAS EXPIRED</p><p>PLEASE PROVIDE YOUR ACCOUNT EMAIL ADDRESS AGAIN AT <b>ACTIVATE MY ACCOUNT</b> TO RECEIVE ANOTHER ACTIVATION EMAIL TO ACTIVATE YOUR ACCOUNT.', '');
                    header("Location: ../sign-in-form.php");
                    die();
                }
                else {
                    $sql2 = "UPDATE users SET status=1 WHERE activation='$activation'";
                    if (!mysqli_query($conn, $sql2)) {                 
                        redirectWithError("*An error occurred while trying to active your account");
                    } 
                    else {
                        addpopup("ACCOUNT CREATED", "<p>WELCOME TO DUONG THAC SI</p><p>YOUR ACCOUNT HAS SUCCESSFULLY BEEN CREATED.</p>", "");
                        
                        //success => redirect to sign-in-form.php with activation and email in url
                        header("Location: ../sign-in-form.php?activation=success&email=".$row['email']."");
                        die();
                    } 
                }
            }

            
        }  
    }
    catch (Exception $e) {
        redirectWithError("*An error occurred while trying to active your account");
    }



    mysqli_close($conn);
?>