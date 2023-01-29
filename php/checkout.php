<?php
    require "./setting/connect.php";
    require "./setting/functions.php";

    session_start();
    
    if (!empty($_SESSION['error'])) {
        $error = $_SESSION['error'];
        unset($_SESSION['error']);
    } 
    if (!empty($_SESSION['success'])) {
        $success = true;
        unset($_SESSION['success']);
    }



    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        if(isset($_SESSION["email"])) {
            $email = $_SESSION["email"];

            $result = mysqli_query($conn, "SELECT * FROM users, address_book, address_type WHERE users.user_id=address_book.user_id AND address_type.id=address_book.address_type AND email='$email' AND address_type.address_type= 'home' ");     
            if (mysqli_num_rows($result) <= 0) {
                addpopup("ERROR", "<p>COULDN'T FIND YOUR ADDRESS.</p>", "");
                header("Location: account.php");
            }
            else{
                while($row = mysqli_fetch_assoc($result)) {
                    $firstname = $row["first_name"];
                    $lastname = $row["last_name"];
                    $phonenumber = $row["phone_number"];
                    $address = $row["address"];
                }
            }
        }
        else {
            addpopup("ERROR", "<p>COULDN'T PLACE ORDER BY ADMIN ACCOUNT.</p>", "");
            header("Location: sign-in-form.php");
        }
    }
    else {
        $email = "";
        $firstname = "";
        $lastname = "";
        $phonenumber = "";
        $address = "";
    }
?>



<!DOCTYPE html>
<html lang="en">
    <?php
        $pagetitle = "CHECKOUT";
        include_once("../include/head.php");
    ?>



    <body>
        <div class="container">
            <?php
                include_once("../include/header.php")
            ?>
            
            
    
            <div class="checkout-main bag-main">
                <div class="background-image">
                    <img src="images/backgrounds/background6.png" alt="">
                    <div class="caption">
                        <p class="title">CHECKOUT</p>
                    </div>
                </div><!--background-image-->

                <div class="form-wrapper">
                    <form  action="php/submit/place-order.php" method="POST">  
                        <div class="form">
                            <div class="form-row form-info">
                                <h1>Shipping Address</h1>
                                <p>&#9679; May we help: <a href="mailto:56duong@gmail.com" target="_blank">56duong@gmail.com</a></p>
                            </div><!--form-row form-info-->

                            <div class="form-row">
                            <?php
                                if (!empty($success)) {
                            ?>
                            <div class="sendsuccess">Your order has been sent!!!</div>
                            <?php
                                }
                            ?>
                            <?php
                                if (!empty($error)) {
                            ?>
                            <div class="senderror"><?= $error ?></div>
                            <?php
                                }
                            ?> 
                            </div>
                             

                            <?php
                                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                                    $address_type_list = "";

                                    $result2 = mysqli_query($conn, "SELECT *, address_type.address_type AS address_type_type FROM users, address_book, address_type WHERE users.user_id=address_book.user_id AND address_type.id=address_book.address_type AND email='$email' ");

                                    if (mysqli_num_rows($result2) > 0) {
                                        while($row2 = mysqli_fetch_assoc($result2)) {
                                            $address_type_list .= '<option value="'.$row2["address_type_type"].'">'.$row2["address_type_type"].'</option>';
                                        }
                                    }

                                    echo '
                                        <div class="form-row">
                                            <label for="">Address book *</label>
                                            <select name="address_type">
                                                '.$address_type_list.'
                                                <option value="addnewaddress">Add new address</option>
                                            </select>
                                        </div><!--form-row-->
                                    ';
                                }
                                echo '
                                    <div class="form-row">
                                        <label for="">First name *</label>
                                        <input type="text" name="firstname" value="'.$firstname.'" required maxlength="30" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]{1,30}$" data-error-parse="Only letters and whitespaces are allow in this field" data-error-missing="PLEASE FILL OUT YOUR FIRST NAME CORRECTLY IN THIS FIELD">
                                        <div class="field-error"></div>
                                    </div><!--form-row-->
                                    
                                    <div class="form-row">
                                        <label for="">Last name *</label>
                                        <input type="text" name="lastname" value="'.$lastname.'" required maxlength="30" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]{1,30}$" data-error-parse="Only letters and whitespaces are allow in this field" data-error-missing="PLEASE FILL OUT YOUR LAST NAME CORRECTLY IN THIS FIELD">
                                        <div class="field-error"></div>
                                    </div><!--form-row-->
                                
                                    <div class="form-row">
                                        <label for="">Email *</label>
                                        <input type="email" name="email" value="'.$email.'" required maxlength="128" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" data-error-parse="Invalid email format. Please try again, example &quot;john.smith@email.com&quot;." data-error-missing="PLEASE ADD YOUR EMAIL ADDRESS">
                                        <div class="field-error"></div>
                                    </div><!--form-row-->
                                    
                                    <div class="form-row">
                                        <label for="">Phone number *</label>
                                        <input type="tel" name="phonenumber" value="'.$phonenumber.'" required maxlength="12" pattern="^[0-9]{8,12}$" data-error-parse="Only numbers are allow in this field" data-error-missing="PLEASE FILL OUT YOUR PHONE NUMBER CORRECTLY IN THIS FIELD (AT LEAST 8 CHARACTERS AND NO MORE THAN 14 CHARACTERS)">
                                        <div class="field-error"></div>
                                    </div><!--form-row-->
        
                                    <div class="form-row">
                                        <label for="">Address *</label>
                                        <input type="text" name="address" value="'.$address.'" required maxlength="2000" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s0-9,./-]{10,2000}$" data-error-parse="Only letters, numbers, hyphen (-), whitespace( ), slash (/) and commas (,)  are allow in this field" data-error-missing="PLEASE FILL OUT YOUR ADDRESS CORRECTLY IN THIS FIELD">
                                        <div class="field-error"></div>
                                    </div><!--form-row-->
                                ';
                            ?>

                            <div class="form-row">
                                <label for="">Message<br>LEAVE A MESSAGE FOR US. (MAX 1500 CHAR) *</label>
                                <textarea name="message" required maxlength="1500" data-error-missing="Please insert a text in this field precising your request so that we can provide a relevant answer."></textarea>
                                <div class="field-error"></div>
                            </div><!--form-row-->

                            <div class="form-row form-radio">
                                <label for="">Payment Options</Address>*</label>

                                <label class="radio">
                                    COD
                                    <input type="radio" name="paymentoptions" value="cod" checked readonly>
                                    <span class="checkmark"></span>
                                </label>
                            </div><!--form-row-->

                            <button type="submit">Place order</button>
                            
                            <a href="php/bag.php" class="backtobag">&lt; Back to Bag</a> 
                        </div><!--form-->

                        <div class="panel">
                            <div class="bag-panel">
                                <p>Shopping Bag</p>   

                                <div class="bag-list">
                                </div><!--bag-list-->
                                
                                <div class="order-summary">
                                    <p>Order summary</p>
                                    <div class="subtotal">
                                        <p >Subtotal</p>
                                        <p><span class="subtotal-value"></span></p>
                                    </div>
                                    <div class="shipping">
                                        <p>Shipping</p>
                                        <p><span class="shipping-value">10</span></p>
                                    </div>
                                    <div class="total">
                                        <p>Total</p>
                                        <p><span class="total-value"></span></p>
                                    </div>
                                </div><!--order-summary-->             
                            </div><!--bag-panel-->
                        </div><!--panel-->
                        
                    </form>
                </div><!--form-wrapper-->



                


            </div><!--checkout-main-->

        <?php
            include_once("../include/footer.php");
        ?>
        </div><!--container-->


        
        <?php
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                echo '
                    <script>
                        $("form input").css("border-bottom", "0").attr("readonly", "readonly");
                        $("form label").css("margin-bottom", "5px");
                        $(".checkout-main select[name=\'address_type\']").change(function() {
                            var address_type = $(this).val();
                            var email = "'.$email.'";
                            var info;
            
                            if (address_type == "addnewaddress") {
                                location = "php/edit-account-form.php?action=addnewaddress";
                            }
            
                            $.ajax({
                                async : false, //this line make code can use address_type outside ajax
                                url: "php/submit/change-address-type.php",
                                type: "post",
                                data: {address_type: address_type, email: email},
                                success: function (response) {
                                    //get when ajax success
                                    info = JSON.parse(response);
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown);
                                }
                            });
            
                            $("form input[name=firstname]").val(info.firstname);
                            $("form input[name=lastname]").val(info.lastname);
                            $("form input[name=phonenumber]").val(info.phonenumber);
                            $("form input[name=address]").val(info.address);
                        });
                    </script>
                ';
            }
        ?>

    </body>

    <script>
        $(document).ready(function() { 
            //redirect if bag is empty
            if($(".checkout-main .bag-panel .bag-item").length ==  0) {
                location.href = "php/products.php";
            }
        })
    </script>
</html>



<?php
    mysqli_close($conn);
?>