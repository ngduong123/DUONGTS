<?php
    require "./setting/connect.php";

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
        $pagetitle = "Create My DUONG THAC SI Account";
        include_once("../include/head.php");
    ?>



    <body>
        <div class="container">
            <?php
                include_once("../include/header.php")
            ?>



            <div class="register-main">     
                <div class="form-wrapper">
                    <form action="php/submit/register.php" method="POST">
                        <div class="form-row form-info">
                            <h1>Create an account</h1>
                            <p>&#9679; COMPLETE CHECKOUT MORE QUICKLY</p>
                            <p>&#9679; REVIEW ORDER INFORMATION AND TRACKING</p>
                        </div><!--form-row form-info-->

                        <div class="form-row">
                        <?php
                            if (!empty($success)) {
                        ?>
                        <div class="sendsuccess">Your account has been activated!!!</div>
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
                            <label for="">First name *</label>
                            <input type="text" name="firstname" required maxlength="30" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]{1,30}$" data-error-parse="Only letters and whitespaces are allow in this field" data-error-missing="PLEASE FILL OUT YOUR FIRST NAME CORRECTLY IN THIS FIELD">
                            <div class="field-error"></div>
                        </div><!--form-row-->
                        
                        <div class="form-row">
                            <label for="">Last name *</label>
                            <input type="text" name="lastname" required maxlength="30" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]{1,30}$" data-error-parse="Only letters and whitespaces are allow in this field" data-error-missing="PLEASE FILL OUT YOUR LAST NAME CORRECTLY IN THIS FIELD">
                            <div class="field-error"></div>
                        </div><!--form-row-->
                    
                        <div class="form-row">
                            <label for="">Email *</label>
                            <input type="email" name="email" required maxlength="128" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" data-error-parse="Invalid email format. Please try again, example &quot;john.smith@email.com&quot;." data-error-missing="PLEASE ADD YOUR EMAIL ADDRESS">
                            <div class="field-error"></div>
                        </div><!--form-row-->
                        
                        <div class="form-row">
                            <label for="">Password *</label>
                            <input type="password" name="password" required maxlength="30" pattern="[a-zA-Z0-9]{6,30}" data-error-parse="Only letters and numbers are allow in this field" data-error-missing="PLEASE FILL OUT YOUR PASSWORD CORRECTLY IN THIS FIELD">
                            <div class="field-error"></div>
                        </div><!--form-row-->
                        
                        <button type="submit">Create an account</button>
                        
                        <a href="php/sign-in-form.php">&lt; Back to Sign in</a> 
                    </form>
                </div><!--form-wrapper-->
            </div><!--sign-in-main-->
            
            
            
            <?php
                include_once("../include/footer.php");
            ?>
        </div><!--container-->
    </body>
</html>



<?php
    mysqli_close($conn);
?>
























