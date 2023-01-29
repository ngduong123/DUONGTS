<?php
    require_once './sendmail/vendor/autoload.php';
    
    require "./setting/connect.php";
    require_once './setting/functions.php';

    

    session_start();

    //check log in
    if ($_SESSION["loggedin"] === false || !isset($_SESSION["loggedin"])) {
        header("Location: sign-in-form.php");
        die();
    }
    else {
        $email = $_SESSION["email"];
    }

    if (isset($_SESSION['title']) && isset($_SESSION['text']) && isset($_SESSION['button'])) {
        $title = $_SESSION['title'];
        unset($_SESSION['title']);
        $text = $_SESSION['text'];
        unset($_SESSION['text']);
        $button = $_SESSION['button'];
        unset($_SESSION['button']);
    } 
    
    if (!empty($_SESSION['error'])) {
        $error = $_SESSION['error'];
        unset($_SESSION['error']);
    } 
    if (!empty($_SESSION['success'])) {
        $success = true;
        unset($_SESSION['success']);
    }

?>



<!DOCTYPE html>
<html lang="en">
    <?php
        $pagetitle = "My Account";
        include_once("../include/head.php");
    ?>



    <body>
        <div class="container">
            <?php
                include_once("../include/header.php")
            ?>
            
            
    
            <div class="account-main">

                <?php
                    if (isset($title) && isset($text) && isset($button)) {
                        popup($title, $text, $button);
                    }

                    $result = mysqli_query($conn, "SELECT *, users.first_name AS users_first_name, users.last_name AS users_last_name FROM users, address_book, address_type WHERE users.user_id=address_book.user_id AND address_type.id=address_book.address_type AND address_type.address_type='home' AND email='$email' ");     
                    if (mysqli_num_rows($result) <= 0) {
                        
                        //addpopup("ERROR", "<p>COULDN'T FIND YOUR ACCOUNT.</p>", "<button class='link'><a href='php/register-form.php'>CREATE AN ACCOUNT</a></button>");
                        //header("Location: sign-in-form.php");
                        //die();
                    }
                    else{
                        while($row = mysqli_fetch_assoc($result)) {
                            $users_firstname = $row["users_first_name"];
                            $users_lastname = $row["users_last_name"];
                            $firstname = $row["first_name"];
                            $lastname = $row["last_name"];
                            $phonenumber = $row["phone_number"];
                            $address = $row["address"];
                        }
                    }
                ?>

                <div class="account-main-title">
                    <p>My Account</p>
                    <p class="card-link">Log out</p>
                </div>

                <div class="account-main-content">
                    <div class="card-col">

                        <div class="card">
                            <div class="card-header">
                                <p class="card-title">Profile</p>
                                <p class="card-link"><a href="php/edit-account-form.php?action=editprofile">Edit</a></p>
                            </div><!--card-header-->
    
                            <div class="card-body">
                                <div class="card-group">
                                    <p class="card-name">First name</p>
                                    <p class="card-info"><?php echo $users_firstname; ?></p>
                                </div><!--card-group-->
                                <div class="card-group">
                                    <p class="card-name">Last name</p>
                                    <p class="card-info"><?php echo $users_lastname; ?></p>
                                </div><!--card-group-->
                                <div class="card-group">
                                    <p class="card-name">E-mail address</p>
                                    <p class="card-info"><?php echo $email; ?></p>
                                </div><!--card-group--> 
                            </div><!--card-body-->
                        </div><!--card-->

                        <div class="card">
                            <div class="card-header">
                                <p class="card-title">Password</p>
                                <p class="card-link"><a href="php/edit-account-form.php?action=editpassword">Edit</a></p>
                            </div><!--card-header-->
    
                            <div class="card-body">
                                <div class="card-group">
                                    <p class="card-name">Your password</p>
                                    <p class="card-info">••••••••</p>
                                </div><!--card-group-->
                            </div><!--card-body-->
                        </div><!--card-->

                        <div class="card">
                            <div class="card-header">
                                <p class="card-title">Shipping Address</p>
                                <p class="card-link"><a href="php/edit-account-form.php?action=addressbook">View all</a></p>
                            </div><!--card-header-->
    
                            <div class="card-body">
                                <div class="card-group">
                                    <p class="card-name">DEFAULT ADDRESS (HOME)</p>
                                    <p class="card-info"><?php echo $firstname; ?></p>
                                    <p class="card-info"><?php echo $lastname; ?></p>
                                    <p class="card-info"><?php echo $phonenumber; ?></p>
                                    <p class="card-info"><?php echo $address; ?></p>
                                </div><!--card-group-->
                            </div><!--card-body-->
                        </div><!--card-->

                        <div class="card">
                            <div class="card-header">
                                <p class="card-title">Payment</p>
                                <!-- <p class="card-link"><a href="">Edit</a></p> -->
                            </div><!--card-header-->
    
                            <div class="card-body">
                                <div class="card-group">
                                    <!-- <p class="card-info">YOU CAN ADD OR EDIT YOUR PAYMENT METHODS DURING THE CHECKOUT PROCESS.</p> -->
                                    <p class="card-info">NOT AVAILABLE.</p>
                                </div><!--card-group--> 
                            </div><!--card-body-->
                        </div><!--card-->
                    </div><!--card-col-->

                    <div class="card-col">
                        <div class="card order-history">
                            <div class="card-header">
                                <p class="card-title">Order history</p>
                                <p class="card-link"><a href="php/edit-account-form.php?action=orderhistory">View all</a></p>
                            </div><!--card-header-->
    
                            <div class="card-body">
                            <?php
                                $result2 = mysqli_query($conn, "SELECT *, order_status.status AS order_status FROM orders, users, order_status WHERE users.user_id = orders.user_id AND order_status.status_id=orders.status AND email='$email' ORDER BY order_id DESC ");     
                                if (mysqli_num_rows($result2) > 0) {
                                    while($row2 = mysqli_fetch_assoc($result2)) {
                                        $result3 = mysqli_query($conn, "SELECT SUM(quantity) AS count_item FROM orders, users, order_item WHERE users.user_id = orders.user_id AND orders.order_item_id = order_item.order_item_id AND email='$email' AND order_id=".$row2['order_id']."");  
                                            while($row3 = mysqli_fetch_assoc($result3)) {
                                                $count_item = $row3["count_item"];
                                                $count_item .= ($count_item > 1) ? " items" : " item";
                                            }
                                        echo '
                                            <div class="card-group">
                                                <p class="card-info">#'.$row2["order_id"].'</p>
                                                <p class="card-info">'.$count_item.'</p>
                                                <p class="card-info">$ '.$row2["total"].'</p>
                                                <p class="card-info">'.date( "Y-m-d", strtotime($row2["created"])).'</p>
                                                <p class="card-info">'.$row2["order_status"].'</p>
                                            </div><!--card-group-->
                                        ';
                                    }
                                }
                                else {
                                    echo '<p class="card-info">Currently empty</p>';
                                }
                            ?>
                            </div><!--card-body-->
                        </div><!--card order-history-->
                    </div>
                </div><!--account-main-content-->
            </div><!--account-main-->

        <?php
            include_once("../include/footer.php");
        ?>
        </div><!--container-->


        
        <script>
        </script>
    </body>
</html>



<?php
    mysqli_close($conn);
?>