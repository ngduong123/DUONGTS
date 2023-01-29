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

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phonenumber = $_POST["phonenumber"];
    $address = $_POST["address"];
    $message = $_POST["message"];
    $payment_option = $_POST["paymentoptions"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $size = $_POST["size"];
    $quantity = $_POST["quantity"];
    $subtotal = preg_replace('/[^0-9.]+/', '', $_POST["subtotal"]);
    $shipping = preg_replace('/[^0-9.]+/', '', $_POST["shipping"]);
    $total = preg_replace('/[^0-9.]+/', '', $_POST["total"]);


    
    //date
    //set timezone in HoChiMinh
    date_default_timezone_set("Asia/Ho_Chi_Minh");               
    $date = date("Y-m-d H:i:s");



    //CHECK VALIDATION === CHECK VALIDATION === CHECK VALIDATION === CHECK VALIDATION === CHECK VALIDATION === CHECK VALIDATION === CHECK VALIDATION === CHECK VALIDATION 
    //check if product is out of stock
    foreach($name as $index => $item) {
        //get product_size_name and product_quantity from form 
        $product_quantity = $quantity[$index];
        $product_size_name = $size[$index];

        $check_in_stock = mysqli_query($conn, "SELECT * FROM products, size, stock WHERE products.product_id = stock.product AND size.id = stock.size AND products.product_name = '$item' AND size.size='$product_size_name' ");     
        if (mysqli_num_rows($check_in_stock) > 0) {
            while($row = mysqli_fetch_assoc($check_in_stock)) {                
                //check in_stock (in_stock - quantity)
                $product_in_stock_check = $row["in_stock"] - $product_quantity; echo $product_in_stock_check;
                if ($product_in_stock_check < 0) {
                    redirectWithError("*These products are out of stock");
                }
            }
        }
    }



    checkname($firstname, "First Name");
    checkname($lastname, "Last Name");
    checkemail($email);
    checkphonenumber($phonenumber);
    checkaddress($address);
    checkmessage($message);

    



    //DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK === DO TASK
    try {
        //INSERT INTO ORDER_ITEM AND UPDATE IN_STOCK
        //get max order_item_id
        $order_item_id = mysqli_query($conn, "SELECT MAX(order_item_id) AS max_order_item_id FROM order_item");
        while($row = mysqli_fetch_assoc($order_item_id)) {
            if ($row["max_order_item_id"] == null){
                $max_order_item_id = 1;
            }
            else {
                $max_order_item_id = $row["max_order_item_id"] + 1;
            }
        }



        //loop through $name
        foreach($name as $index => $item) { 
            //get product_size_name and product_quantity from form 
            $product_quantity = $quantity[$index];
            $product_size_name = $size[$index];

            //find product in database and add to order_item 
            $result = mysqli_query($conn, "SELECT * FROM products, size, stock WHERE products.product_id = stock.product AND size.id = stock.size AND products.product_name = '$item' AND size.size='$product_size_name' ");     
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $product_id = $row["product_id"]; //get product_id from database
                    $product_size_id = $row["size"]; //get product_size_id from database                   



                    //update in_stock (in_stock - quantity)
                    $product_in_stock = $row["in_stock"] - $product_quantity;
                    $sql3 = "UPDATE stock SET in_stock = $product_in_stock WHERE product = '$product_id' AND size = $product_size_id";
                    if (!mysqli_query($conn, $sql3)) {                 
                        redirectWithError("*An error occurred while trying to calculate your order-item in_stock in database");
                    } 
                    else {
                    }



                    //insert into order_item
                    $sql2 = "INSERT INTO order_item (order_item_id, product_id, size_id, quantity) VALUES($max_order_item_id, '$product_id', $product_size_id, $product_quantity )";   
                    if (!mysqli_query($conn, $sql2)) {                 
                        redirectWithError("*An error occurred while trying to add your order_item to database");
                    } 
                    else {
                    }   
                }
            }   
            else {
                redirectWithError("*An error occurred while trying to find this product in database");
            }               
        }



        //INSERT INTO CUSTOMER
        //get max customer_id
        $customer_id = mysqli_query($conn, "SELECT MAX(customer_id) AS max_customer_id FROM customers");
        while($row = mysqli_fetch_assoc($customer_id)) {
            if ($row["max_customer_id"] == null){
                $max_customer_id = 1;
            }
            else {
                $max_customer_id = $row["max_customer_id"] + 1;
            }
        }

        $sql = "INSERT INTO customers (customer_id, first_name, last_name, email, phone_number, address) VALUES($max_customer_id, '$firstname', '$lastname', '$email', '$phonenumber', '$address' )";     
        if (!mysqli_query($conn, $sql)) {                 
            redirectWithError("*An error occurred while trying to add your address to database");
        } 
        else {
        } 



        //INSERT INTO ORDERS
        //get max order_id
        $order_id = mysqli_query($conn, "SELECT MAX(order_id) AS max_order_id FROM orders");
        while($row = mysqli_fetch_assoc($order_id)) {
            if ($row["max_order_id"] == null){
                $max_order_id = 1;
            }
            else {
                $max_order_id = $row["max_order_id"] + 1;
            }
        }

        //check log in
        if ($_SESSION["loggedin"] === true && $_SESSION["role"] == "user") {
            $user_email = $_SESSION["email"];
            $result5 = mysqli_query($conn, "SELECT * FROM users WHERE email='$user_email' "); 
            while($row5 = mysqli_fetch_assoc($result5)) {
                //get user_id
                $user_email_id = $row5["user_id"];
            }
        }
        elseif(isset($_POST["order_useremail"]) && $_POST["order_useremail"] != "none") {
            $user_email = $_POST["order_useremail"];
            $result5 = mysqli_query($conn, "SELECT * FROM users WHERE email='$user_email' "); 
            while($row5 = mysqli_fetch_assoc($result5)) {
                //get user_id
                $user_email_id = $row5["user_id"];
            }
        }
        else {
            $user_email_id = "NULL";
        }


        $order_status_id = 1;
        if(isset($_POST["order_status"])) {
            $order_status = $_POST["order_status"];

            $result6 = mysqli_query($conn, "SELECT * FROM order_status WHERE status='$order_status' ");
            while($row6 = mysqli_fetch_assoc($result6)) {
                $order_status_id = $row6["status_id"];
            }
        }

        $sql4 = "INSERT INTO orders (order_id, user_id, customer_id, order_item_id, message, payment_option, subtotal, shipping, total, created, status) VALUES($max_order_id, $user_email_id, $max_customer_id, $max_order_item_id, '$message', '$payment_option', $subtotal, $shipping, $total, '$date', $order_status_id )";     
        if (!mysqli_query($conn, $sql4)) {                 
            redirectWithError("*An error occurred while trying to add your order to database");
        } 
        else {
        } 

    }   
    catch (Exception $e) {
        redirectWithError("*An error occurred while trying to create your order");
    }
                  




    //set .bag-list in email
    $order_list = "";
    //loop through $name
    foreach($name as $index => $product_name) { 
        //get product_size_name and product_quantity from form 
        $product_img = preg_replace("/\s/", "-", $product_name);
        $product_quantity = $quantity[$index];
        $product_size = $size[$index];
        $product_price = $price[$index];  
        
        $order_list .= '
            <a class="bag-item">
                <img src="http://duong456.epizy.com/images/products/'.$product_img.'_1.png" alt="">
                <div class="infor">
                    <p class="bag-item-name">'.$product_name.'</p>
                    <p class="bag-item-price">Price: '.$product_price.'</p>
                    <div class="select-size-quantity">
                        <p>Size:</p>
                        <p class="bag-item-size">'.$product_size.'</p>
                    </div><!--select-size-quantity-->
                    <div class="select-size-quantity">
                        <p>Quantity:</p>
                        <p class="bag-item-quantity">'.$product_quantity.'</p>
                    </div><!--select-size-quantity-->
                </div><!--infor-->
            </a><!--bag-item-->
        ';
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

        $mail->Subject = "ORDER CONFIRMATION DETAILS";        

        $mail->Body = 
        '
            <!DOCTYPE html> 
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>PLACE ORDER | DUONG THAC SI</title>   
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
                            position: relative;
                        }
            
                        .container{
                            width: 100%;
                            max-width: 500px;
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%);
                            padding: 25px 15px 15px 15px;
                            background: #f2f2f2;
                        }
            
                        .header{
                            margin-bottom: 30px;
                            text-align: center;
                            text-transform: uppercase;
                        }
            
                        .header p{
                            margin: 10px;
                            font-size: 12px;
                        }
            
                        .header .title{
                            margin: 0;
                            padding-top: 5px;
                        }
            
                        .shipping-address{
                            padding-bottom: 5px;
                        }
            
                        .shipping-address,
                        .bag-list{
                            margin-bottom: 10px;
                        }
            
                        .title{ 
                            margin-bottom: 5px;
                            padding-top: 45px;
                            font-size: 14px;
                            font-weight: 500;
                            text-transform: uppercase;
                        }
            
                        .shipping-address .first{
                            padding-top: 0;
                        }
            
                        .shipping-address p:not(:first-child){
                            font-size: 13px;
                            font-weight: 300;
                            line-height: 20px;
                        }
                                
                        .container>div{
                            overflow-x: hidden;
                        }
            
                        .bag-list a{
                            text-decoration: none;
                        }
            
                        .bag-item{
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            padding: 15px;
                            border-bottom: 1px solid #e0e0e0;
                        }
            
                        .bag-item:last-child{
                            border-bottom: none;
                        }
            
                        .bag-item img{
                            width: 70px;
                        }
            
                        .infor{
                            width: 100%;
                            margin: 0 10px;
                            color: #777777;
                            font-weight: 400;
                            text-transform: uppercase;
                        }
            
                        .infor .bag-item-name{
                            margin-bottom: 10px;
                            color: #000000;
                            font-size: 12px;
                        }
            
                        .infor .bag-item-price{
                            margin-bottom: 3px;
                            font-size: 11px;
                        }
            
                        .select-size-quantity{
                            display: flex;
                            justify-content: flex-start;
                            align-items: center;
                            margin-bottom: 3px;
                            font-size: 11px;
                        }
            
                        .select-size-quantity p{
                            margin-right: 5px;
                        }
            
                        .order-summary{
                            width: fit-content;
                            margin: auto;
                        }
            
                        .order-summary .title{
                            margin-bottom: 10px;
                            text-align: center;
                        }
            
                        .table{
                            display: table-row;
                            font-size: 12px;
                            font-weight: 300;
                            text-transform: uppercase;
                        }
            
                        .row{
                            display: table-row;
                        }
            
                        .col{
                            display: table-cell;
                            padding: 5px 20px;
                        }
            
                        .col.right{
                            font-size: 15px;
                            text-align: right;
                        }
            
                        .last{
                            font-size: 22px !important;
                            font-weight: 400;
                        }
            
                        .help{
                            margin-top: 50px;
                            font-size: 12px;
                            font-weight: 500;
                            text-align: center;
                            text-transform: uppercase;
                        }
            
                        .help a{
                            color: #000000;
                        }
                
                    </style>
                </head>
                <body>
                    <div class="container">  
                    <div class="header">
                        <h2>Thank you for your order!</h2>
                        <p>Dear '.$firstname.', Thank you for shopping with duong456.epizy.com.</p>
                        <p>We will call you shortly to confirm your order.</p> 
                        <p class="title">Order Number: '.$max_order_id.'</p>
                        <p class="title">Order Date: '.$date.'</p>
                    </div><!--header-->
            
                        <div class="shipping-address">
                            <p class="title first">Shipping address</p>
                            <p>'.$firstname.' '.$lastname.'</p>
                            <p>'.$phonenumber.'</p>
                            <p>'.$address.'</p>
                            <p>'.$message.'</p>
                        </div><!--shipping-address-->
                            
                        <div class="bag-list">
                            <p class="title">YOUR SELECTIONS</p>
                            '.$order_list.'
                        </div><!--bag-list-->  
            
                        <div class="order-summary">
                            <p class="title">Order summary</p>
                            <div class="table">
                                <div class="row">
                                    <div class="col">Subtotal:</div>
                                    <div class="col right">$ '.$subtotal.'</div>
                                </div>
                                <div class="row">
                                    <div class="col">Shipping ('.$payment_option.'):</div>
                                    <div class="col right">$ '.$shipping.'</div>
                                </div>
                                <div class="row">
                                    <div class="col">Total:</div>
                                    <div class="col right last">$ '.$total.'</div>
                                </div>
                            </div>
                        </div><!--order-summary--> 
            
                        <p class="help">May we help: <a href="mailto:56duong@gmail.com" target="_blank">56duong@gmail.com</a></p>
            
                    </div><!--container-->  
                </body>
            </html>
        ';
        $mail->send();





        //email to owner
        //notification to owner
        $mail->clearAllRecipients();
        $mail->addAddress("56duong@gmail.com");//owner
        $mail->Subject = "NEW ORDER FORM CUSTOMER";        

        $mail->Body = 
        '
            <!DOCTYPE html> 
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>PLACE ORDER | DUONG THAC SI</title>   
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
                            position: relative;
                        }
            
                        .container{
                            width: 100%;
                            max-width: 500px;
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%);
                            padding: 25px 15px 15px 15px;
                            background: #f2f2f2;
                        }
            
                        .header{
                            margin-bottom: 30px;
                            text-align: center;
                            text-transform: uppercase;
                        }
            
                        .header p{
                            margin: 10px;
                            font-size: 12px;
                        }
            
                        .header .title{
                            margin: 0;
                            padding-top: 5px;
                        }
            
                        .shipping-address{
                            padding-bottom: 5px;
                        }
            
                        .shipping-address,
                        .bag-list{
                            margin-bottom: 10px;
                        }
            
                        .title{ 
                            margin-bottom: 5px;
                            padding-top: 45px;
                            font-size: 14px;
                            font-weight: 500;
                            text-transform: uppercase;
                        }
            
                        .shipping-address .first{
                            padding-top: 0;
                        }
            
                        .shipping-address p:not(:first-child){
                            font-size: 13px;
                            font-weight: 300;
                            line-height: 20px;
                        }
                                
                        .container>div{
                            overflow-x: hidden;
                        }
            
                        .bag-list a{
                            text-decoration: none;
                        }
            
                        .bag-item{
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            padding: 15px;
                            border-bottom: 1px solid #e0e0e0;
                        }
            
                        .bag-item:last-child{
                            border-bottom: none;
                        }
            
                        .bag-item img{
                            width: 70px;
                        }
            
                        .infor{
                            width: 100%;
                            margin: 0 10px;
                            color: #777777;
                            font-weight: 400;
                            text-transform: uppercase;
                        }
            
                        .infor .bag-item-name{
                            margin-bottom: 10px;
                            color: #000000;
                            font-size: 12px;
                        }
            
                        .infor .bag-item-price{
                            margin-bottom: 3px;
                            font-size: 11px;
                        }
            
                        .select-size-quantity{
                            display: flex;
                            justify-content: flex-start;
                            align-items: center;
                            margin-bottom: 3px;
                            font-size: 11px;
                        }
            
                        .select-size-quantity p{
                            margin-right: 5px;
                        }
            
                        .order-summary{
                            width: fit-content;
                            margin: auto;
                        }
            
                        .order-summary .title{
                            margin-bottom: 10px;
                            text-align: center;
                        }
            
                        .table{
                            display: table-row;
                            font-size: 12px;
                            font-weight: 300;
                            text-transform: uppercase;
                        }
            
                        .row{
                            display: table-row;
                        }
            
                        .col{
                            display: table-cell;
                            padding: 5px 20px;
                        }
            
                        .col.right{
                            font-size: 15px;
                            text-align: right;
                        }
            
                        .last{
                            font-size: 22px !important;
                            font-weight: 400;
                        }
            
                        .help{
                            margin-top: 50px;
                            font-size: 12px;
                            font-weight: 500;
                            text-align: center;
                            text-transform: uppercase;
                        }
            
                        .help a{
                            color: #000000;
                        }
                
                    </style>
                </head>
                <body>
                    <div class="container">  
                    <div class="header">
                        <h2>New order from customer</h2>
                        <p class="title">Order Number: '.$max_order_id.'</p>
                        <p class="title">Order Date: '.$date.'</p>
                    </div><!--header-->
            
                        <div class="shipping-address">
                            <p class="title first">Shipping address</p>
                            <p>'.$firstname.' '.$lastname.'</p>
                            <p>'.$phonenumber.'</p>
                            <p>'.$address.'</p>
                            <p>'.$message.'</p>
                        </div><!--shipping-address-->
                            
                        <div class="bag-list">
                            <p class="title">THEIR SELECTIONS</p>
                            '.$order_list.'
                        </div><!--bag-list-->  
            
                        <div class="order-summary">
                            <p class="title">Order summary</p>
                            <div class="table">
                                <div class="row">
                                    <div class="col">Subtotal:</div>
                                    <div class="col right">$ '.$subtotal.'</div>
                                </div>
                                <div class="row">
                                    <div class="col">Shipping ('.$payment_option.'):</div>
                                    <div class="col right">$ '.$shipping.'</div>
                                </div>
                                <div class="row">
                                    <div class="col">Total:</div>
                                    <div class="col right last">$ '.$total.'</div>
                                </div>
                            </div>
                        </div><!--order-summary--> 
            
                    </div><!--container-->  
                </body>
            </html>
        ';
        $mail->send();


        
        $_SESSION['text'] = "<p>Your order was placed successfully!</p><p>We have sent the order confirmation details to $email</p><p>We will call you shortly to confirm your order.</p><a href='../products.php'>Continue shopping</a>";
        header("Location: success.php");
        die();

    }//try

    catch (Exception $e) {
        redirectWithError("*An error occurred while trying to send your order: ".$mail->ErrorInfo);
    }



    mysqli_close($conn);



?>