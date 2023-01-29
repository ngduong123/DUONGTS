<?php
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
?>



<!DOCTYPE html>
<html lang="en">
    <?php
        $pagetitle = "Sign In";
        include_once("../include/head.php");
    ?>


    <body>
        <div class="container">
            <?php
                include_once("../include/header.php")
            ?>
            
            
            
            <div class="sign-in-main">    
                 
                <?php
                    if (isset($title) && isset($text) && isset($button)) {
                        popup($title, $text, $button);
                    }
                ?>       

                <div class="form-wrapper">
                    <form action="php/submit/sign-in.php" method="POST">
                        <div class="form-row form-info">
                            <h1>Sign in</h1>
                            <p>* REQUIRED FIELDS</p>
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
                            <label for="">Email *</label>
                            <input type="email" name="email" required maxlength="128" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" data-error-parse="Invalid email format. Please try again, example &quot;john.smith@email.com&quot;." data-error-missing="PLEASE ADD YOUR EMAIL ADDRESS">
                            <div class="field-error"></div>
                        </div><!--form-row-->
                        
                        <div class="form-row">
                            <label for="">Password *</label>
                            <input type="password" name="password" required maxlength="30" pattern="[a-zA-Z0-9]{6,30}" data-error-parse="Only letters and numbers are allow in this field" data-error-missing="PLEASE FILL OUT YOUR PASSWORD CORRECTLY IN THIS FIELD">
                            <div class="field-error"></div>
                        </div><!--form-row-->
                        
                        <div class="form-row forgot-password">
                            <a class="forgotpassword">Forgot password?</a>
                            <a class="activateaccount">Activate my account</a>
                        </div>
                        
                        <button type="submit">Sign in</button>
                        
                        <div class="form-row form-info">
                            <h1>Create an account</h1>
                            <div class="form-row"><p>&#9679; COMPLETE CHECKOUT MORE QUICKLY</p>
                            <p>&#9679; REVIEW ORDER INFORMATION AND TRACKING</p></div>
                            
                            <button><a href="php/register-form.php">Create an account</a></button>
                        </div><!--form-row form-info--> 
                    </form>
                </div><!--form-wrapper-->
            </div><!--sign-in-main-->
            
            
            
            <?php
                include_once("../include/footer.php");
            ?>
        </div><!--container-->
        <script>
            //set value for email input from email in url
            $('input[name="email"]').val("<?php if (isset($_GET["email"])) {echo $_GET['email'];} ?>");



            //activate my account
            $(".activateaccount").click(function(){
                $(".form-wrapper").prepend(`
                    <?php
                        popup("ACTIVATE MY ACCOUNT", '<p>PROVIDE YOUR ACCOUNT EMAIL ADDRESS TO RECEIVE AN ACTIVATION EMAIL TO ACTIVATE YOUR ACCOUNT.</p><form action="php/submit/register.php" method="POST"><div class="form-row"><label for="">Email *</label><input type="email" name="email" required maxlength="128" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" data-error-parse="Invalid email format. Please try again, example &quot;john.smith@email.com&quot;." data-error-missing="PLEASE ADD YOUR EMAIL ADDRESS"><div class="field-error"></div></div><!--form-row--></form>', '<button class="cancel">Cancel</button><button type=submit class="send">Send</button>');
                    ?>
                `);

                $('input[name="email"]').val("<?php if (isset($_GET["email"])) {echo $_GET['email'];} ?>");

            })



            //forgotpassword
            $(".forgotpassword").click(function(){
                $(".form-wrapper").prepend(`
                    <?php
                        popup("RESET MY PASSWORD", '<p>PLEASE, PROVIDE YOUR ACCOUNT EMAIL ADDRESS. WE WILL SEND YOU AN EMAIL WITH A RESET LINK.</p><form action="php/submit/reset-password.php" method="POST"><div class="form-row"><label for="">Email *</label><input type="email" name="email" required maxlength="128" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" data-error-parse="Invalid email format. Please try again, example &quot;john.smith@email.com&quot;." data-error-missing="PLEASE ADD YOUR EMAIL ADDRESS"><div class="field-error"></div></div><!--form-row--></form>', '<button class="cancel">Cancel</button><button type=submit class="send">Send</button>');
                    ?>
                `);

                $('input[name="email"]').val("<?php if (isset($_GET["email"])) {echo $_GET['email'];} ?>");

            })



            //click send
            $(".container").on("click", ".form-wrapper .notification .send", function(){
                // $('.notification form').submit();
                var email = $(".form-wrapper .notification input[name=email]").val();
                $.ajax({
                    url: "php/submit/register.php",
                    type: "post",
                    data: {email: email},
                    success: function (response) {
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            })
        </script>
    </body>
</html>



<?php
    mysqli_close($conn);
?>
























