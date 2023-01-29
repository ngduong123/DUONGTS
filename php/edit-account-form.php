<?php
    require_once './sendmail/vendor/autoload.php';
    
    require "./setting/connect.php";
    require_once './setting/functions.php';

    session_start();
    
    if (!empty($_SESSION['error'])) {
        $error = $_SESSION['error'];
        unset($_SESSION['error']);
    } 
    if (!empty($_SESSION['success'])) {
        $success = true;
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['title']) && isset($_SESSION['text']) && isset($_SESSION['button'])) {
        $title = $_SESSION['title'];
        unset($_SESSION['title']);
        $text = $_SESSION['text'];
        unset($_SESSION['text']);
        $button = $_SESSION['button'];
        unset($_SESSION['button']);
    } 



    //check log in
    if ($_SESSION["loggedin"] === false || !isset($_SESSION["loggedin"])) {
        header("Location: ./sign-in-form.php");
        die();
    }
    else {
        $email = $_SESSION["email"];
    }

    

    //get action parameter in url
    if (isset($_GET["action"])) {
        $action = $_GET["action"];
        if ($action == "editprofile") {
            $action_title = "<p>Edit Profile</p>";
        }
        else if ($action == "editpassword") {
            $action_title = "<p>Edit Password</p>";
        }
        else if ($action == "addressbook") {
            $action_title = "<p>Address Book</p>";
        }
        else if ($action == "addnewaddress") {
            $action_title = "<p>Add New Address</p>";
        }
        else if ($action == "editaddress") {
            $action_title = "<p>Edit Address</p>";
        }
        else if ($action == "deleteaddress") {
            $action_title = "<p>Delete Address</p>";
        }
        else if ($action == "orderhistory") {
            $action_title = "<p>Order History</p>";
        }
        else {
            addpopup("ERROR", "<p>Something went wrong.</p>", "");
            header("Location: ./account.php");
        }
    }
    else {
        addpopup("ERROR", "<p>Something went wrong.</p>", "");
        header("Location:   ./account.php");
    }

?>



<!DOCTYPE html>
<html lang="en">
    <?php
        $pagetitle = "Edit Account";
        include_once("../include/head.php");
    ?>



    <body>
        <div class="container">
            <?php
                include_once("../include/header.php")
            ?>
            
            
    
            <div class="edit-account-main account-main">  

                <?php
                    if (isset($title) && isset($text) && isset($button)) {
                        popup($title, $text, $button);
                    }
                ?>

                <div class="form-wrapper">
                    <div class="account-main-title">
                        <!-- title -->
                        <?php
                            if (!empty($action)) {
                                echo $action_title;
                            }
                        ?>
                        <p class="card-link cancel"><a>&lt; Back</a></p>
                    </div><!--account-main-title-->
                        
                        <!-- content -->
                        <?php
                            if (!empty($success)) {
                                $send = '<div class="form-row"><div class="sendsuccess">Your account has been updated!!!</div></div>';
                            }
                            if (!empty($error)) {
                                $send = '<div class="form-row"><div class="senderror">'.$error.'</div></div>';
                            }
                            else {
                                $send = "";
                            }



                            // edit profile
                            if (!empty($action) && $action == "editprofile") {
                                echo '<form action="php/submit/edit-account.php?action=editprofile" method="POST">'.$send;

                                $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' ");     
                                if (mysqli_num_rows($result) <= 0) {
                                    addpopup("ERROR", "<p>COULDN'T FIND YOUR ACCOUNT.</p>", "<button class='link'><a href='php/register-form.php'>CREATE AN ACCOUNT</a></button>");
                                    redirectWithError("");
                                }
                                else{
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo '
                                            <div class="edit-profile">
                                                <div class="form-row form-info">
                                                    <p>FIELDS MARKED * ARE MANDATORY</p>
                                                </div><!--form-row form-info-->
                    
                                                <div class="form-row">
                                                    <label for="">First name *</label>
                                                    <input type="text" name="firstname" value="'.$row["first_name"].'" required maxlength="30" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]{1,30}$" data-error-parse="Only letters and whitespaces are allow in this field" data-error-missing="PLEASE FILL OUT YOUR FIRST NAME CORRECTLY IN THIS FIELD">
                                                    <div class="field-error"></div>
                                                </div><!--form-row-->
                                                    
                                                <div class="form-row">
                                                    <label for="">Last name *</label>
                                                    <input type="text" name="lastname" value="'.$row["last_name"].'" required maxlength="50" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]{1,50}$" data-error-parse="Only letters and whitespaces are allow in this field" data-error-missing="PLEASE FILL OUT YOUR LAST NAME CORRECTLY IN THIS FIELD">
                                                    <div class="field-error"></div>
                                                </div><!--form-row-->
                                                    
                                                <div class="form-row">
                                                    <label for="">Birthdate</label>
                                                    <input type="date" name="birthdate" value="'.$row["birthdate"].'" maxlength="30" pattern="[0-9/]{6}" data-error-parse="Only numbers and slash are allow in this field" data-error-missing="PLEASE FILL OUT YOUR BIRTHDATE CORRECTLY IN THIS FIELD">
                                                    <div class="field-error"></div>
                                                </div><!--form-row-->
                    
                                                <div class="form-row">
                                                    <div class="card-group">
                                                        <p class="card-name">E-mail address *</p>
                                                        <p class="card-info">'.$email.'</p>
                                                    </div><!--card-group-->
                                                </div> 
                    
                                                <div class="button-cancel-save">
                                                    <button class="cancel">Cancel</button>
                                                    <button class="send">Save</button>
                                                </div>
                                            </div><!--edit-profile-->
                                        ';
                                    }
                                }
                            }


                            
                            // edit password
                            else if (!empty($action) && $action == "editpassword") {
                                echo '<form action="php/submit/edit-account.php?action=editpassword" method="POST">'.$send;

                                $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' ");     
                                if (mysqli_num_rows($result) <= 0) {
                                    addpopup("ERROR", "<p>COULDN'T FIND YOUR ACCOUNT.</p>", "<button class='link'><a href='php/register-form.php'>CREATE AN ACCOUNT</a></button>");
                                    redirectWithError("");
                                }
                                else{
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo '
                                            <div class="change-password">
                                                <div class="form-row form-info">
                                                    <p>FIELDS MARKED * ARE MANDATORY</p>
                                                </div><!--form-row form-info-->
                                            
                                                <div class="form-row">
                                                    <label for="">CURRENT PASSWORD *</label>
                                                    <input type="password" name="password" required maxlength="30" pattern="[a-zA-Z0-9]{6,30}" data-error-parse="Only letters and numbers are allow in this field" data-error-missing="PLEASE FILL OUT YOUR PASSWORD CORRECTLY IN THIS FIELD">
                                                    <div class="field-error"></div>
                                                </div><!--form-row-->

                                                <div class="form-row">
                                                    <label for="">NEW PASSWORD *</label>
                                                    <input type="password" name="newpassword" required maxlength="30" pattern="[a-zA-Z0-9]{6,30}" data-error-parse="Only letters and numbers are allow in this field" data-error-missing="PLEASE FILL OUT YOUR PASSWORD CORRECTLY IN THIS FIELD">
                                                    <div class="field-error"></div>
                                                </div><!--form-row-->

                                                <div class="button-cancel-save">
                                                    <button class="cancel">Cancel</button>
                                                    <button class="send">Save</button>
                                                </div>
                                            </div><!--change-password-->
                                        ';
                                    }
                                }
                            }



                            // view address book
                            else if (!empty($action) && $action == "addressbook") {
                                echo '<form action="php/submit/edit-account.php" method="POST">'.$send;
                                $result = mysqli_query($conn, "SELECT * FROM users, address_book, address_type WHERE users.user_id=address_book.user_id AND address_type.id=address_book.address_type AND email='$email' ");     
                                if (mysqli_num_rows($result) <= 0) {
                                    addpopup("ERROR", "<p>COULDN'T FIND YOUR ACCOUNT.</p>", "<button class='link'><a href='php/register-form.php'>CREATE AN ACCOUNT</a></button>");
                                    header("Location: ../account.php");
                                }
                                else{
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo '
                                        <div class="address-book">
                                            <div class="card">
                                                <div class="card-header">
                                                <p class="card-name">'.$row["address_type"].'</p> 
                                                    <p class="card-link">
                                                        <a href="php/edit-account-form.php?action=editaddress&address_type='.$row["address_type"].'">Edit Address</a>
                                                        <a class="deleteaddress" href="php/submit/edit-account.php?action=deleteaddress&address_type='.$row["address_type"].'">Delete</a>
                                                    </p>
                                                </div><!--card-header-->
            
                                                <div class="card-body">
                                                    <div class="card-group">
                                                        <p class="card-info">'.$row["first_name"].' '.$row["last_name"].'</p>
                                                        <p class="card-info">'.$row["phone_number"].'</p>
                                                        <p class="card-info">'.$row["address"].'</p>
                                                    </div><!--card-group-->
                                                </div><!--card-body-->
                                            </div><!--card-->
                                        ';
                                    }
                                    echo '
                                            <div class="button-cancel-save">
                                                <button class="send"><a href="php/edit-account-form.php?action=addnewaddress">Add new address</a></button>
                                            </div>
                                        </div><!--address-book-->
                                    ';
                                }   
                            }



                            // add new address or edit address
                            else if (!empty($action) && ($action == "addnewaddress" || $action == "editaddress")) {
                                if (isset($_GET["address_type"])) {
                                    //edit address
                                    $address_type = $_GET["address_type"];
                                    echo '<form action="php/submit/edit-account.php?action=editaddress&address_type='.$address_type.'" method="POST">'.$send;

                                    $result = mysqli_query($conn, "SELECT * FROM users, address_book, address_type WHERE users.user_id=address_book.user_id AND address_type.id=address_book.address_type AND email='$email' AND address_type.address_type='$address_type' ");     
                                    if (mysqli_num_rows($result) <= 0 || mysqli_num_rows($result) > 1) {
                                        addpopup("ERROR", "<p>COULDN'T FIND YOUR ACCOUNT.</p>", "<button class='link'><a href='php/register-form.php'>CREATE AN ACCOUNT</a></button>");
                                        header("Location: ../account.php");
                                    }
                                    else{
                                        while($row = mysqli_fetch_assoc($result)) {
                                            $firstname = $row["first_name"];
                                            $lastname = $row["last_name"];
                                            $phonenumber = $row["phone_number"];
                                            $address = $row["address"];
                                        }
                                    }

                                    $address_type_list = '<option value="'.$address_type.'">'.$address_type.'</option>';
                                }
                                else {
                                    //add new address
                                    echo '<form action="php/submit/edit-account.php?action=addnewaddress" method="POST">'.$send;

                                    $firstname = "";
                                    $lastname = "";
                                    $phonenumber = "";
                                    $address = "";

                                    $address_type_list = "";    
                                }

                                
                                
                                $result2 = mysqli_query($conn, "SELECT * FROM address_type"); 
                                
                                while($row2 = mysqli_fetch_assoc($result2)) {
                                    $result3 = mysqli_query($conn, "SELECT * FROM address_book, users WHERE address_book.user_id=users.user_id AND email='$email' AND address_book.address_type=".$row2['id']." ");
                                    if (mysqli_num_rows($result3) <= 0) {
                                        $address_type_list .= '<option value="'.$row2["address_type"].'">'.$row2["address_type"].'</option>';
                                    }
                                }
                                echo '
                                    <div class="add-new-address">
                                        <div class="form-row form-info">
                                            <p>FIELDS MARKED * ARE MANDATORY</p>
                                        </div><!--form-row form-info-->

                                        <div class="form-row">
                                            <label for="">First name*</label>
                                            <input type="text" name="firstname" value="'.$firstname.'" required maxlength="30" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]{1,30}$" data-error-parse="Only letters and whitespaces are allow in this field" data-error-missing="PLEASE FILL OUT YOUR FIRST NAME CORRECTLY IN THIS FIELD">
                                            <div class="field-error"></div>
                                        </div><!--form-row-->

                                        <div class="form-row">
                                            <label for="">Last name*</label>
                                            <input type="text" name="lastname" value="'.$lastname.'" required maxlength="30" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]{1,30}$" data-error-parse="Only letters and whitespaces are allow in this field" data-error-missing="PLEASE FILL OUT YOUR LAST NAME CORRECTLY IN THIS FIELD">
                                            <div class="field-error"></div>
                                        </div><!--form-row-->

                                        <div class="form-row">
                                            <label for="">Address type *</label>
                                            <select name="address_type">
                                                '.$address_type_list.'
                                            </select>
                                        </div><!--form-row-->

                                        <div class="form-row">
                                            <label for="">Phone number*</label>
                                            <input type="tel" name="phonenumber" value="'.$phonenumber.'" required maxlength="12" pattern="^[0-9]{8,12}$" data-error-parse="Only numbers are allow in this field" data-error-missing="PLEASE FILL OUT YOUR PHONE NUMBER CORRECTLY IN THIS FIELD (AT LEAST 8 CHARACTERS AND NO MORE THAN 14 CHARACTERS)">
                                            <div class="field-error"></div>
                                        </div><!--form-row-->

                                        <div class="form-row">
                                            <label for="">Address*</label>
                                            <input type="text" name="address" value="'.$address.'" required maxlength="2000" pattern="[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s0-9,./-]{10,2000}$" data-error-parse="Only letters, numbers, hyphen (-), whitespace( ), slash (/) and commas (,)  are allow in this field" data-error-missing="PLEASE FILL OUT YOUR ADDRESS CORRECTLY IN THIS FIELD">
                                            <div class="field-error"></div>
                                        </div><!--form-row-->

                                        <div class="button-cancel-save">
                                            <button class="cancel">Cancel</button>
                                            <button type=submit class="send">Save</button>
                                        </div>
                                    </div><!--add-new-address-->
                                '; 
                                
                            }



                            // order history
                            else if (!empty($action) && $action == "orderhistory") {
                                echo '<div class="orderhistory">';

                                $result = mysqli_query($conn, "SELECT *, order_status.status AS order_status FROM orders, users, customers, order_status WHERE users.user_id = orders.user_id AND orders.customer_id=customers.customer_id AND order_status.status_id=orders.status AND users.email='$email'  ORDER BY order_id DESC ");     
                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo '
                                            <div class="card">
                                                <div class="card-header">
                                                    <p class="card-title">Order ID: #'.$row["order_id"].'</p>
                                                    <p class="card-link">'.$row["order_status"].'</p>
                                                </div><!--card-header-->

                                                <div class="shipping-address-orderhistory">
                                                    <p class="card-link">Full name: '.$row["first_name"].' '.$row["last_name"].'</p>
                                                    <p class="card-link">Phone number: '.$row["phone_number"].'</p>
                                                    <p class="card-link">Address: '.$row["address"].'</p>
                                                    <p class="card-link">Full name: '.$row["payment_option"].'</p>
                                                    <p class="card-link">Created: '.date( "Y-m-d", strtotime($row["created"])).'</p>
                                                </div>
                                        ';

                                        $result2 = mysqli_query($conn, "SELECT * FROM order_item, products, size WHERE order_item.product_id=products.product_id AND order_item.size_id=size.id AND order_item_id=".$row['order_item_id']."");  
                                        while($row2 = mysqli_fetch_assoc($result2)) {
                                            $product_name = $row2["product_name"];
                                            $product_price = $row2["product_price"];
                                            $product_size = $row2["size"];
                                            $product_quantity = $row2["quantity"];
                                            
                                            $product_img = preg_replace('/\s/', "-", $product_name);
                                            
                                            echo '
                                                <a class="bag-item">
                                                    <img src="images/products/'.$product_img.'_1.png" alt="">
                                                    <div class="infor">
                                                        <p class="bag-item-name">'.$product_name.'</p>
                                                        <p class="bag-item-price">Price: $ '.$product_price.'</p>
                                                        <div class="select-size-quantity">
                                                            <p>Size:</p>
                                                            <p class="bag-item-size">'.$product_size.'</p>
                                                        </div><!--select-size-quantity-->
                                                        <div class="select-size-quantity">
                                                            <p>Quantity:</p>
                                                            <p class="bag-item-quantity">'.$product_quantity.'</p>
                                                            <select name="bag-item-quantity"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>
                                                        </div><!--select-size-quantity-->
                                                    </div><!--infor-->
                                                </a>
                                            ';
                                        }

                                        echo '<div class="order-total">Total: <span>$ '.$row["total"].'</span></div>';
                                        echo '</div><!--card-->';
                                    }
                                }
                                else {
                                    echo '<p class="card-info">Currently empty</p>';
                                }  

                                echo '</div><!--orderhistory-->';
                            }
                        ?>
                                
                    </form>
                </div><!--form-wrapper-->
            </div><!--edit-account-main-->

        <?php
            include_once("../include/footer.php");
        ?>
        </div><!--container-->


        
        <style>
            
        </style>

        <script>
            $(".edit-account-main .cancel").click(function(e){
                e.preventDefault();
                $(".form-wrapper").prepend(`
                    <?php
                        popup($action_title, '<p>ARE YOU SURE TO CANCEL? YOUR MODIFICATIONS WILL NOT BE SAVED.</p>', '<button class="cancel">Stay</button><button class="send" onClick="history.back()">Yes</button>');
                    ?>
                `);
            })



            //confirm delete_address
            $(".deleteaddress").click(function(e){
                //get address_type
                var address_type = $(this).closest(".card-header").find(".card-name").text();
                
                e.preventDefault();
                $(".form-wrapper").prepend(`
                    <?php
                        popup('DELETE ADDRESS', '<p>ARE YOU SURE TO DELETE THIS ADDRESS ?</p>', '<button class="cancel">Cancel</button><button class="send delete_address">Yes</button>');
                    ?>
                `);

                //redirect to edit-account.php with parameter
                $(".container").on("click", ".delete_address", function(){
                    location.href='submit/edit-account.php?action=deleteaddress&address_type=' + address_type;
                })
            })

        </script>
    </body>
</html>



<?php
    mysqli_close($conn);
?>