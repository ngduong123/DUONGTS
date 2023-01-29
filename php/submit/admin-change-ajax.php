<?php
    require_once '../sendmail/vendor/autoload.php';
    
    require "../setting/connect.php";
    require_once '../setting/functions.php';

    session_start();


    
    if(isset($_POST["type"])) {

        //ORDERS - display address_book on change email
        if($_POST["type"] == "order_useremail") {
            //get value from select by post method from ajax
            if (isset($_POST["email"])) {
                $email = $_POST["email"];
            }

            //get info by address_type
            $result = mysqli_query($conn, "SELECT *, address_type.address_type AS address_type_type FROM users, address_book, address_type WHERE users.user_id=address_book.user_id AND address_type.id=address_book.address_type AND email='$email' ");
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="'.$row["address_type_type"]. '">'.$row["address_type_type"]. '</option>';
                }
            }
            else {
                echo "";
            }
        }

        //ORDER - display order
        if($_POST["type"] == "displayorders") {
            $result = mysqli_query($conn, "SELECT * FROM orders, customers, order_status WHERE orders.customer_id=customers.customer_id AND orders.status=order_status.status_id ");
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <tr class="'.$row["status"].'">
                            <td id="item-id" item-id='.$row["order_id"].' customer_id='.$row["customer_id"].' order_item_id='.$row["order_item_id"].'># '.$row["order_id"].'</td>
                            <td>'.$row["user_id"].'</td>
                            <td>'.$row["first_name"].' '.$row["last_name"].'</td>
                            <td>'.$row["email"].'</td>
                            <td>'.$row["phone_number"].'</td>
                            <td>'.$row["order_item_id"].'</td>
                            <td>'.$row["total"].'</td>
                            <td>'.$row["created"].'</td>
                            <td>'.$row["status"].'</td>
                            <td><span class="edit-order">Edit</span><span class="delete-order">Delete</span></td>
                        </tr>
                    ';
                }
            }
            else{
                echo "Something went wrong!";
            }
        }

        //ORDERS - delete order
        if($_POST["type"] == "deleteorder") {
            $order_id = $_POST["id"];
            $customer_id = $_POST["customer_id"];
            $order_item_id = $_POST["order_item_id"];

            //delete order
            $sql = "DELETE FROM orders WHERE order_id=$order_id";     
            if (!mysqli_query($conn, $sql)) {                 
                redirectWithError("*An error occurred while trying to delete this order");
            } 

            //delete customer
            $sql = "DELETE FROM customers WHERE customer_id=$customer_id";     
            if (!mysqli_query($conn, $sql)) {              
                redirectWithError("*An error occurred while trying to delete this customer");
            } 

            //delete order item
            $sql = "DELETE FROM order_item WHERE order_item_id=$order_item_id";     
            if (!mysqli_query($conn, $sql)) {               
                redirectWithError("*An error occurred while trying to delete this order item");
            }

        }

        //ORDERS - edit
        if($_POST["type"] == "editorder") {
            $order_id = $_POST["id"];

            $result = mysqli_query($conn, "SELECT * FROM orders, customers, order_status WHERE orders.customer_id=customers.customer_id AND orders.status=order_status.status_id AND order_id=$order_id");
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {

                    $order_item_id = $row["order_item_id"];
                    $result3 = mysqli_query($conn, "SELECT product_name, product_price, size, quantity FROM order_item, products, size WHERE order_item.product_id=products.product_id AND order_item.size_id=size.id AND order_item_id=$order_item_id");
                    $rows = array();
                    while($row3 = mysqli_fetch_assoc($result3)) {
                        $rows[] = $row3;
                    }

                    $order_item_list = json_encode($rows);


                    $user_email_id = $row["user_id"];
                    $result2 = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$user_email_id' "); 
                    if(mysqli_num_rows($result2) > 0) {
                        while($row2 = mysqli_fetch_assoc($result2)) {
                            $user_email = $row2["email"];
                        }
                    }
                    else {
                        $user_email = "none";
                    }

                    echo '
                        [
                            {
                                "user_email":"'.$user_email.'", 
                                "status":"'.$row["status"].'", 
                                "first_name":"'.$row['first_name'].'", 
                                "last_name":"'.$row['last_name'].'", 
                                "email":"'.$row['email'].'", 
                                "phone_number":"'.$row['phone_number'].'", 
                                "address":"'.$row['address'].'", 
                                "message":"'.$row['message'].'",
                                "subtotal":"'.$row["subtotal"].'",
                                "shipping":"'.$row["shipping"].'",
                                "total":"'.$row["total"].'"
                            },
                            '.$order_item_list.'
                        ]
                    ';
                }
            }
            else {
                redirectWithError("*Couldn't find this order");
            }
        }

        //ORDERS - update order
        if($_POST["type"] == "updateorder") {
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $email = $_POST["email"];
            $phonenumber = $_POST["phonenumber"];
            $address = $_POST["address"];
            $message = $_POST["message"];
            $payment_option = $_POST["paymentoptions"];
        
            $order_id = $_POST["id"];

            //get customer_id
            $result = mysqli_query($conn, "SELECT *, orders.customer_id AS customerid FROM orders, customers, order_status WHERE orders.customer_id=customers.customer_id AND orders.status=order_status.status_id AND order_id=$order_id");
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $customer_id = $row["customerid"];
                }
            }
            else {
                redirectWithError("*Couldn't find this order");
            }

            //update customers
            $sql = "UPDATE customers SET first_name='$firstname', last_name='$lastname', email='$email', phone_number='$phonenumber', address='$address' WHERE customer_id=$customer_id";     
            if (!mysqli_query($conn, $sql)) {                 
                redirectWithError("*An error occurred while trying to update order");
            } 

            //update order
            $order_status = $_POST["order_status"];

            $result6 = mysqli_query($conn, "SELECT * FROM order_status WHERE status='$order_status' ");
            while($row6 = mysqli_fetch_assoc($result6)) {
                $order_status_id = $row6["status_id"];
            }

            $sql2 = "UPDATE orders SET message='$message', status=$order_status_id WHERE order_id=$order_id";     
            if (!mysqli_query($conn, $sql2)) {                 
                redirectWithError("*An error occurred while trying to update order");
            } 


            //send mail
            if($order_status == "shipped") {
                $content = "YOUR ORDER IS ON ITS WAY";
                $text = '
                    <p>Good news - Your order is on its way to you!!!</p>
                    <p>Your order Number: #'.$order_id.'</p> <br>
                    <p>Please click on the link below to track your order:</p>
                    <a class="button-link" href="http://localhost/duong456.epizy.com/php/edit-account-form.php?action=orderhistory">Track my order</a>
                ';
            }
            elseif($order_status == "cancelled") {
                $content = "YOUR ORDER HAS BEEN CANCELLED";
                $text = '
                    <p>We\'re writing to let you know that yout order has been cancelled.</p>
                    <p>Your order Number: #'.$order_id.'</p> <br>
                    <p>Please click on the link below to track your order:</p>
                    <a class="button-link" href="http://localhost/duong456.epizy.com/php/edit-account-form.php?action=orderhistory">Track my order</a>
                ';
            }

            if(isset($_POST["sendemail"]) && $_POST["sendemail"] == "send" && ($order_status == "shipped" || $order_status == "cancelled")) {
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

                    $mail->Subject = $content;        

                    $mail->Body = 
                    '
                        <!DOCTYPE html> 
                        <html lang="en">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                                <title>'.$content.' | DUONG THAC SI</title>   
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
                                    <p>Dear '.$firstname.',</p> <br>
                                    '.$text.'
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
            }
        }





        //PRODUCT - display product
        if($_POST["type"] == "displayproducts") {
            $result = mysqli_query($conn, "SELECT *, size.id AS size_id FROM products, stock, category, size WHERE products.product_id=stock.product AND category.id=products.category AND size.id=stock.size ORDER BY product_id DESC");
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $product_img = preg_replace("/\s/", "-", $row["product_name"]);
                    echo '
                        <tr class="'.$row["category"].'">
                            <td id="item-id" item-id='.$row["product_id"].' size='.$row["size_id"].'>'.$row["product_id"].'</td>
                            <td><img src="images/products/'.$product_img.'_1.png" alt=""></td>
                            <td>'.$row["product_name"].'</td>
                            <td>$ '.$row["product_price"].'</td>
                            <td>'.$row["size"].'</td>
                            <td>'.$row["in_stock"].'</td>
                            <td>'.$row["product_description"].'</td>
                            <td>'.$row["product_detailslist"].'</td>
                            <td><span class="edit-product">Edit</span><span class="delete-product">Delete</span></td>
                        </tr>
                    ';
                }
            }
            else{
                echo "Something went wrong!";
            }
        }

        //PRODUCTS - add new product
        if($_POST["type"] == "addnewproduct") {
            $product_name = $_POST["product_name"];
            $product_price = $_POST["product_price"];
            $product_category = $_POST["product_category"];
            $product_size = $_POST["product_size"];
            $product_instock = $_POST["product_instock"];
            $product_description = $_POST["product_description"];
            $product_detailslist = $_POST["product_detailslist"];

            //get max product_id
            $result = mysqli_query($conn, "SELECT MAX(product_id) AS max_product_id FROM products");
            while($row = mysqli_fetch_assoc($result)) {
                if ($row["max_product_id"] == null){
                    $max_product_id = 1;
                }
                else {
                    $max_product_id = $row["max_product_id"] + 1;
                }
            }

            //get max stock_id
            $result = mysqli_query($conn, "SELECT MAX(id) AS max_stock_id FROM stock");
            while($row = mysqli_fetch_assoc($result)) {
                if ($row["max_stock_id"] == null){
                    $max_stock_id = 1;
                }
                else {
                    $max_stock_id = $row["max_stock_id"] + 1;
                }
            }


            //insert into products and stock
            $result2 = mysqli_query($conn, "SELECT * FROM products WHERE product_name='$product_name' ");
            
            //check if product is already in products
            if (mysqli_num_rows($result2) > 0) {
                //get product_id
                while($row2 = mysqli_fetch_assoc($result2)) {
                    $last_id = $row2["product_id"];
                }

                //check if product and size are already in stock
                $result3 = mysqli_query($conn, "SELECT * FROM stock WHERE product='$last_id' AND size=$product_size ");
                if(mysqli_num_rows($result3) > 0) {
                    while($row3 = mysqli_fetch_assoc($result3)) {
                        $product_instock_new = $row3["in_stock"];
                        $sql = "UPDATE stock SET in_stock=$product_instock_new + $product_instock WHERE product='$last_id' AND size=$product_size ";     
                        if (!mysqli_query($conn, $sql)) {                 
                            redirectWithError("*An error occurred while trying to add new product to database");
                        } 
                    }
                }
                else {
                    $sql = "INSERT INTO stock(id, product, size, in_stock) VALUES($max_stock_id, $last_id, $product_size, $product_instock )";     
                    if (!mysqli_query($conn, $sql)) {                 
                        redirectWithError("*An error occurred while trying to add new product to database");
                    } 
                }
                
            }
            else {
                $sql = "INSERT INTO products(product_id, product_name, product_price, category, product_description, product_detailslist) VALUES($max_product_id, '$product_name', $product_price, $product_category, '$product_description', '$product_detailslist' )";     
                if (!mysqli_query($conn, $sql)) {                 
                    redirectWithError("*An error occurred while trying to add new product to database");
                } 
                else {
                    //get product_id
                    $last_id = mysqli_insert_id($conn);
                    $sql = "INSERT INTO stock(id, product, size, in_stock) VALUES($max_stock_id, $last_id, $product_size, $product_instock )";     
                    if (!mysqli_query($conn, $sql)) {                 
                        redirectWithError("*An error occurred while trying to add new product to database");
                    } 
                    else {
                    } 
                } 
            }
            



            //UPLOAD IMAGES UPLOAD IMAGES UPLOAD IMAGES UPLOAD IMAGES UPLOAD IMAGES UPLOAD IMAGES UPLOAD IMAGES UPLOAD IMAGES
            //link to folder
            $target_dir = dirname(__FILE__)."/../../images/products/";

            foreach ($_FILES["fileToUpload"]["tmp_name"] as $key => $value) {
                //ten tam thoi, tao ngau nhien, VD: /tmp/php4tof1X
                $file_tmpname = $_FILES["fileToUpload"]["tmp_name"][$key];

                //img's name. Ex: shirt_1.png
                $image_num = $key + 1; 
                $img_name = preg_replace("/\s/", "-", $product_name)."_".$image_num.".png";

                // uploads/f1a.png
                //$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $target_file = $target_dir.basename($img_name);

                $uploadOk = 1;

                //return extension, VD: png
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    }
                    else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["fileToUpload"]["size"][$key] > 500000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.".$img_name;
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                }
                else {
                    if (move_uploaded_file($file_tmpname, $target_file)) {
                        echo "The file ". htmlspecialchars(basename($img_name)). " has been uploaded.";
                    }
                    else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
        }

        //PRODUCTS - delete product
        if($_POST["type"] == "deleteproduct") {
            $product_id = $_POST["id"];
            $size = $_POST["size"];

            //delete stock
            $sql = "DELETE FROM stock WHERE product=$product_id and size=$size";     
            if (!mysqli_query($conn, $sql)) {               
                redirectWithError("*An error occurred while trying to delete this product");
            } 

            //delete products
            $sql = "DELETE FROM products WHERE product_id=$product_id";     
            if (!mysqli_query($conn, $sql)) {           
                redirectWithError("*An error occurred while trying to delete this product");
            } 

        }

        //PRODUCT - edit
        if($_POST["type"] == "editproduct") {
            $product_id = $_POST["id"];
            $size = $_POST["size"];

            $result = mysqli_query($conn, "SELECT *, products.category AS product_category, stock.size AS product_size FROM products, stock, category, size WHERE products.product_id=stock.product AND category.id=products.category AND size.id=stock.size AND product_id=$product_id AND size.id=$size");
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '{"category":"'.$row["product_category"].'", "name":"'.$row['product_name'].'", "price":"'.$row['product_price'].'", "size":"'.$row['product_size'].'", "in_stock":"'.$row['in_stock'].'", "description":"'.$row['product_description'].'", "detailslist":"'.$row['product_detailslist'].'"}';
                }
            }
            else {
                redirectWithError("*Couldn't find this product");
            }
        }

        //PRODUCTS - update product
        if($_POST["type"] == "updateproduct") {
            $product_id = $_POST["id"];
            $product_price = $_POST["product_price"];
            $product_category = $_POST["product_category"];
            $product_size = $_POST["product_size"];
            $product_instock = $_POST["product_instock"];
            $product_description = $_POST["product_description"];
            $product_detailslist = $_POST["product_detailslist"];

            //update product in stock
            $sql = "UPDATE stock SET in_stock=$product_instock WHERE product=$product_id AND size=$product_size";     
            if (!mysqli_query($conn, $sql)) {                 
                redirectWithError("*An error occurred while trying to update product in stock");
            } 

            //update product in products
            $sql2 = "UPDATE products SET product_price=$product_price, category=$product_category, product_description='$product_description', product_detailslist='$product_detailslist' WHERE product_id=$product_id";     
            if (!mysqli_query($conn, $sql2)) {                 
                redirectWithError("*An error occurred while trying to update product in products");
            } 
        }






        //USERS - display user
        if($_POST["type"] == "displayusers") {
            $result = mysqli_query($conn, "SELECT * FROM users");
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <tr class="'.$row["role"].'">
                        <td id="item-id" item-id='.$row["user_id"].'>'.$row["user_id"].'</td>
                        <td>'.$row["email"].'</td>
                        <td>'.$row["password"].'</td>
                        <td>'.$row["first_name"].'</td>
                        <td>'.$row["last_name"].'</td>
                        <td>'.$row["birthdate"].'</td>
                        <td>'.$row["created"].'</td>
                        <td>'.$row["status"].'</td>
                        <td>'.$row["role"].'</td>
                        <td><span class="edit-user">Edit</span><span class="delete-user">Delete</span></td>
                    </tr>
                    ';
                }
            }
            else{
                echo "Something went wrong!";
            }
        }

        //USERS - delete order
        if($_POST["type"] == "deleteuser") {
            $user_id = $_POST["id"];

            //update user in order
            $sql = "UPDATE orders SET user_id=NULL WHERE user_id=$user_id";     
            if (!mysqli_query($conn, $sql)) {                 
                redirectWithError("*An error occurred while trying to update user in order");
            } 

            //delete addressbook
            $sql = "DELETE FROM address_book WHERE user_id=$user_id";     
            if (!mysqli_query($conn, $sql)) {                 
                redirectWithError("*An error occurred while trying to delete this address book");
            } 

            //delete user
            $sql = "DELETE FROM users WHERE user_id=$user_id";     
            if (!mysqli_query($conn, $sql)) {                 
                redirectWithError("*An error occurred while trying to delete this user");
            } 
        }

        //USERS - edit
        if($_POST["type"] == "edituser") {
            $user_id = $_POST["id"];

            $result = mysqli_query($conn, "SELECT * FROM users WHERE user_id=$user_id");
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '{
                        "email":"'.$row["email"].'", 
                        "password":"'.$row['password'].'", 
                        "first_name":"'.$row['first_name'].'", 
                        "last_name":"'.$row['last_name'].'", 
                        "birthdate":"'.$row['birthdate'].'",
                        "role":"'.$row["role"].'"
                    }';
                }
            }
            else {
                redirectWithError("*Couldn't find this user");
            }
        }

        //USERS - update user
        if($_POST["type"] == "updateuser") {
            $user_id = $_POST["id"];
            $password = $_POST["password"];
            $first_name = $_POST["firstname"];
            $last_name = $_POST["lastname"];
            $birthdate = date("Y-m-d", strtotime($_POST["birthdate"]));
            $role = $_POST["role"];
            
            //update user in users
            $sql = "UPDATE users SET password='$password', first_name='$first_name', last_name='$last_name', birthdate='$birthdate', role=$role WHERE user_id=$user_id";     
            if (!mysqli_query($conn, $sql)) {                 
                redirectWithError("*An error occurred while trying to update user");
            } 
        }





        //TABLES - ADDRESS_TYPE - display tables
        if($_POST["type"] == "displayaddresstypes") {
            $result = mysqli_query($conn, "SELECT * FROM address_type");
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <tr class="'.$row["id"].'">
                        <td id="item-id" item-id='.$row["id"].'>'.$row["id"].'</td>
                        <td>'.$row["address_type"].'</td>
                        <td><span class="edit-addresstype">Edit</span><span class="delete-table">Delete</span></td>
                    </tr>
                    ';
                }
            }
            else{
                echo "Something went wrong!";
            }
        }

        //TABLES - ADDRESS_TYPE - add new tables
        if($_POST["type"] == "addnewaddresstype") {
            $address_type = $_POST["addresstype"];

            //get max address type id
            $result = mysqli_query($conn, "SELECT MAX(id) AS max_addresstype_id FROM address_type");
            while($row = mysqli_fetch_assoc($result)) {
                if ($row["max_addresstype_id"] == null){
                    $max_addresstype_id = 1;
                }
                else {
                    $max_addresstype_id = $row["max_addresstype_id"] + 1;
                }
            }

            //insert into address_type
            $sql = "INSERT INTO address_type(id, address_type) VALUES($max_addresstype_id, '$address_type' )";     
            if (!mysqli_query($conn, $sql)) {                 
                redirectWithError("*An error occurred while trying to add new product to database");
            } 
            else {
            } 
        }

        //TABLE - ADDRESS_TYPE - edit addresstype
        if($_POST["type"] == "editaddresstype") {
            $id = $_POST["id"];

            $result = mysqli_query($conn, "SELECT * FROM address_type WHERE id=$id");
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '{
                        "addresstype":"'.$row["address_type"].'"
                    }';
                }
            }
            else {
                redirectWithError("*Couldn't find this address type");
            }
        }

        //TABLE - ADDRESS_TYPE - update addresstype
        if($_POST["type"] == "updateaddresstype") {
            $id = $_POST["id"];
            $addresstype = $_POST["addresstype"];

            //update addresstype in address_type
            $sql = "UPDATE address_type SET address_type='$addresstype' WHERE id=$id";     
            if (!mysqli_query($conn, $sql)) {                 
                redirectWithError("*An error occurred while trying to update this address type");
            } 
        }





        //TABLES - CATEGORY - display tables
        if($_POST["type"] == "displaycategorys") {
            $result = mysqli_query($conn, "SELECT * FROM category");
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <tr class="'.$row["id"].'">
                        <td id="item-id" item-id='.$row["id"].'>'.$row["id"].'</td>
                        <td>'.$row["category"].'</td>
                        <td><span class="edit-category">Edit</span><span class="delete-table">Delete</span></td>
                    </tr>
                    ';
                }
            }
            else{
                echo "Something went wrong!";
            }
        }

        //TABLES - CATEGORY - add new tables
        if($_POST["type"] == "addnewcategory") {
            $category = $_POST["category"];

            //get max address type id
            $result = mysqli_query($conn, "SELECT MAX(id) AS max_category_id FROM category");
            while($row = mysqli_fetch_assoc($result)) {
                if ($row["max_category_id"] == null){
                    $max_category_id = 1;
                }
                else {
                    $max_category_id = $row["max_category_id"] + 1;
                }
            }

            //insert into address_type
            $sql = "INSERT INTO category(id, category) VALUES($max_category_id, '$category' )";     
            if (!mysqli_query($conn, $sql)) {                 
                redirectWithError("*An error occurred while trying to add new product to database");
            } 
            else {
            } 
        }

        //TABLE - CATEGORY - edit category
        if($_POST["type"] == "editcategory") {
            $id = $_POST["id"];

            $result = mysqli_query($conn, "SELECT * FROM category WHERE id=$id");
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '{
                        "category":"'.$row["category"].'"
                    }';
                }
            }
            else {
                redirectWithError("*Couldn't find this category");
            }
        }

        //TABLE - CATEGORY - update category
        if($_POST["type"] == "updatecategory") {
            $id = $_POST["id"];
            $category = $_POST["category"];

            //update category in category
            $sql = "UPDATE category SET category='$category' WHERE id=$id";     
            if (!mysqli_query($conn, $sql)) {                 
                redirectWithError("*An error occurred while trying to update this category");
            } 
        }





        //TABLES - ORDERSTATUS - display tables
        if($_POST["type"] == "displayorderstatuss") {
            $result = mysqli_query($conn, "SELECT * FROM order_status");
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <tr class="'.$row["status_id"].'">
                        <td id="item-id" item-id='.$row["status_id"].'>'.$row["status_id"].'</td>
                        <td>'.$row["status"].'</td>
                        <td><span class="edit-orderstatus">Edit</span><span class="delete-table">Delete</span></td>
                    </tr>
                    ';
                }
            }
            else{
                echo "Something went wrong!";
            }
        }

        //TABLES - ORDERSTATUS - add new tables
        if($_POST["type"] == "addneworderstatus") {
            $orderstatus = $_POST["orderstatus"];

            //get max address type id
            $result = mysqli_query($conn, "SELECT MAX(status_id) AS max_orderstatus_id FROM order_status");
            while($row = mysqli_fetch_assoc($result)) {
                if ($row["max_orderstatus_id"] == null){
                    $max_orderstatus_id = 1;
                }
                else {
                    $max_orderstatus_id = $row["max_orderstatus_id"] + 1;
                }
            }

            //insert into address_type
            $sql = "INSERT INTO order_status(status_id, status) VALUES($max_orderstatus_id, '$orderstatus' )";     
            if (!mysqli_query($conn, $sql)) {                 
                redirectWithError("*An error occurred while trying to add new product to database");
            } 
            else {
            } 
        }

        //TABLES - ORDERSTATUS - edit orderstatus
        if($_POST["type"] == "editorderstatus") {
            $id = $_POST["id"];

            $result = mysqli_query($conn, "SELECT * FROM order_status WHERE status_id=$id");
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '{
                        "status":"'.$row["status"].'"
                    }';
                }
            }
            else {
                redirectWithError("*Couldn't find this category");
            }
        }

        //TABLES - ORDERSTATUS - update orderstatus
        if($_POST["type"] == "updateorderstatus") {
            $id = $_POST["id"];
            $orderstatus = $_POST["orderstatus"];

            //update category in category
            $sql = "UPDATE order_status SET status='$orderstatus' WHERE status_id=$id";     
            if (!mysqli_query($conn, $sql)) {                 
                redirectWithError("*An error occurred while trying to update this order status");
            } 
        }





        //TABLES - SIZE - display tables
        if($_POST["type"] == "displaysizes") {
            $result = mysqli_query($conn, "SELECT * FROM size");
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <tr class="'.$row["id"].'">
                        <td id="item-id" item-id='.$row["id"].'>'.$row["id"].'</td>
                        <td>'.$row["size"].'</td>
                        <td><span class="edit-size">Edit</span><span class="delete-table">Delete</span></td>
                    </tr>
                    ';
                }
            }
            else{
                echo "Something went wrong!";
            }
        }

        //TABLES - SIZE - add new tables
        if($_POST["type"] == "addnewsize") {
            $size = $_POST["size"];

            //get max address type id
            $result = mysqli_query($conn, "SELECT MAX(id) AS max_size_id FROM size");
            while($row = mysqli_fetch_assoc($result)) {
                if ($row["max_size_id"] == null){
                    $max_size_id = 1;
                }
                else {
                    $max_size_id = $row["max_size_id"] + 1;
                }
            }

            //insert into address_type
            $sql = "INSERT INTO size(id, size) VALUES($max_size_id, '$size' )";     
            if (!mysqli_query($conn, $sql)) {                 
                redirectWithError("*An error occurred while trying to add new product to database");
            } 
            else {
            } 
        }

        //TABLES - SIZE - edit size
        if($_POST["type"] == "editsize") {
            $id = $_POST["id"];

            $result = mysqli_query($conn, "SELECT * FROM size WHERE id=$id");
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '{
                        "size":"'.$row["size"].'"
                    }';
                }
            }
            else {
                redirectWithError("*Couldn't find this size");
            }
        }

        //TABLES - SIZE - update size
        if($_POST["type"] == "updatesize") {
            $id = $_POST["id"];
            $size = $_POST["size"];

            //update size in size
            $sql = "UPDATE size SET size='$size' WHERE id=$id";     
            if (!mysqli_query($conn, $sql)) {                 
                redirectWithError("*An error occurred while trying to update this size");
            } 
        }





        //DELETE TABLE
        if($_POST["type"] == "deletetable") {
            $id = $_POST["id"];
            $table = $_POST["table"];

            if($table == "addresstypes") {
                $table = "address_type";
                $row = "id";
            }
            else if($table == "categorys") {
                $table = "category";
                $row = "id";
            }
            else if($table == "orderstatuss") {
                $table = "order_status";
                $row = "status_id";
            }
            else if($table == "sizes") {
                $table = "size";
                $row = "id";
            }

            //delete user
            $sql = "DELETE FROM $table WHERE $row=$id";     
            if (!mysqli_query($conn, $sql)) {                 
                echo "Couldn't update";
            } 
            else {
                echo "Delete success";
            }
        }


    }
    else {
    }

            
         
    mysqli_close($conn);
?>