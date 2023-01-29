<?php
    require "./setting/connect.php";
    require_once './sendmail/vendor/autoload.php';
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



    //get token code
    if (!isset($_GET["token"])) {
        header("Location: ./sign-in-form.php");
    } 
    else {
        $token = $_GET["token"];
    }

    try{
        if (isset($token)) {
            $result = mysqli_query($conn, "SELECT * FROM users WHERE token='$token' ");
            if (mysqli_num_rows($result) <= 0) {
                //if wrong token
                addpopup("RESET PASSWORD LINK EXPIRED", '<p>SORRY, THE RESET PASSWORD LINK YOU USED HAS EXPIRED. PLEASE INSERT YOUR EMAIL AGAIN SO THAT WE SEND YOU A NEW LINK.</p><form action="./submit/reset-password.php" method="POST"><div class="form-row"><label for="">Email *</label><input type="email" name="email" required maxlength="128" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" data-error-parse="Invalid email format. Please try again, example &quot;john.smith@email.com&quot;." data-error-missing="PLEASE ADD YOUR EMAIL ADDRESS"><div class="field-error"></div></div><!--form-row--></form>', '<button class="cancel">Cancel</button><button type=submit class="send">Send</button>');
                header("Location: ./sign-in-form.php");
            }
        }  
    }
    catch (Exception $e) {
        redirectWithError("*An error occurred while trying to reset your password");
    }

?>



<!DOCTYPE html>
<html lang="en">
    <?php
        $pagetitle = "Reset My Password";
        include_once("../include/head.php");
    ?>



    <body>
        <div class="container">
            <?php
                include_once("../include/header.php")
            ?>



            <div class="reset-password-main">     
                <div class="form-wrapper">
                    <form action="./submit/reset-password.php" method="POST">
                        <div class="form-row form-info">
                            <h1>Reset password</h1>
                            <p>FIELDS MARKED * ARE MANDATORY</p>
                        </div><!--form-row form-info-->

                        <div class="form-row">
                        <?php
                            if (!empty($success)) {
                        ?>
                        <div class="sendsuccess">Your password has been reset!!!</div>
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
                            <label for="">NEW PASSWORD *</label>
                            <input type="password" name="password" required maxlength="30" pattern="[a-zA-Z0-9]{6,30}" data-error-parse="Only letters and numbers are allow in this field" data-error-missing="PLEASE FILL OUT YOUR PASSWORD CORRECTLY IN THIS FIELD">
                            <div class="field-error"></div>
                        </div><!--form-row-->

                        <div class="form-row">
                            <label for="">CONFIRM NEW PASSWORD *</label>
                            <input type="password" name="confirmnewpassword" required maxlength="30" pattern="[a-zA-Z0-9]{6,30}" data-error-parse="PLEASE FILL OUT THE SAME PASSWORD AS ABOVE" data-error-missing="PLEASE FILL OUT THE SAME PASSWORD AS ABOVE">
                            <div class="field-error"></div>
                        </div><!--form-row-->

                        <div class="form-row">
                            <input type="hidden" name="token" value="<?php echo $token; ?>">
                        </div>
                        
                        <button type="submit">Save</button>
                        
                        <a href="php/sign-in-form.php">&lt; Back to Sign in</a> 
                    </form>
                </div><!--form-wrapper-->
            </div><!--reset-password-main-->
            
            
            
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
























