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

?>



<!DOCTYPE html>
<html lang="en">
    <?php
        $pagetitle = "Contact Us";
        include_once("../include/head.php");
    ?>


    <body>
        <div class="container">
            <?php
                include_once("../include/header.php")
            ?>
            
            
            
            <div class="contact-us-main">      
                <div class="form-wrapper">
                    <form action="php/submit/contact.php" method="POST">
                        <div class="form-row form-info">
                            <h1>Contact us</h1>
                            <p>OUR CUSTOMER SERVICE WILL ANSWER YOUR ENQUIRY AS QUICKLY AS POSSIBLE</p>
                            <p>FIELDS MARKED * ARE MANDATORY</p>
                            <div class="form-error"></div>
                        </div><!--form-row form-info-->

                        <div class="form-row">
                            <?php
                                if (!empty($success)) {
                            ?>
                            <div class="sendsuccess">Your email has been sent!!!</div>
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
                    
                        <div class="form-row">
                            <label for="">Topic *</label>
                            <select name="topic" required data-error-parse="Please choose a topic.">
                                <option selected hidden>Select a topic</option>
                                <option value="Product Information">Product information</option>
                                <option value="Online Purchase">Online Purchase</option>
                                <option value="Online Purchase">Other</option>
                            </select>
                            <div class="field-error"></div>
                        </div><!--form-row-->
                        
                        <div class="form-row">
                            <label for="">First name *</label>
                            <input type="text" name="firstname" required maxlength="30" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]{1,30}$" data-error-parse="Only letters and whitespaces are allow in this field" data-error-missing="PLEASE FILL OUT YOUR FIRST NAME CORRECTLY IN THIS FIELD">
                            <div class="field-error"></div>
                        </div><!--form-row-->
                        
                        <div class="form-row">
                            <label for="">Last name *</label>
                            <input type="text" name="lastname" required maxlength="50" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]{1,50}$" data-error-parse="Only letters and whitespaces are allow in this field" data-error-missing="PLEASE FILL OUT YOUR LAST NAME CORRECTLY IN THIS FIELD">
                            <div class="field-error"></div>
                        </div><!--form-row-->
                        
                        <div class="form-row">
                            <label for="">Email *</label>
                            <input type="email" name="email" required maxlength="128" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" data-error-parse="Invalid email format. Please try again, example &quot;john.smith@email.com&quot;." data-error-missing="PLEASE ADD YOUR EMAIL ADDRESS">
                            <div class="field-error"></div>
                        </div><!--form-row-->
                        
                        <div class="form-row">
                            <label for="">Message<br>LEAVE A MESSAGE FOR US. (MAX 1500 CHAR) *</label>
                            <textarea name="message" required maxlength="1500" data-error-missing="Please insert a text in this field precising your request so that we can provide a relevant answer."></textarea>
                            <div class="field-error"></div>
                        </div><!--form-row-->
                        
                        <button type="submit">Send</button>      
                    </form> 
                </div><!--form-wrapper--> 
            </div><!--contact-us-main-->
            
            
            
            <?php
                include_once("../include/footer.php");
            ?>
        </div><!--container-->
    </body>
</html>



<?php
    mysqli_close($conn);
?>
























