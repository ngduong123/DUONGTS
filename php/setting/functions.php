<?php

    function redirectWithError($error)
    {
        $_SESSION['error'] = $error;

        header('Location: '.$_SERVER['HTTP_REFERER']);
        echo "Error: ".$error;
        die();
    }

    function redirectSuccess()
    {
        $_SESSION['success'] = true;

        header('Location: '.$_SERVER['HTTP_REFERER']);
        echo "Your message was sent successfully!";
        die();
    }

    function addpopup($title, $text, $button){
        $_SESSION['title'] = $title;
        $_SESSION['text'] = $text;
        $_SESSION['button'] = $button;
    }

    function popup($title, $text, $button) {
        echo '
        <div class="pop-up">
            <div class="notification">
                <div class="notification-title">'.$title.'</div>
                <div class="notification-text">
                    '.$text.'
                </div>
                <div class="notification-button">
                    '.$button.'
                </div>
                
                <ion-icon name="close-outline" class="notification-close"></ion-icon>
            </div>
        </div><!--pop-up-->
        ';
    }



    //CHECK INPUT === CHECK INPUT === CHECK INPUT === CHECK INPUT === CHECK INPUT === CHECK INPUT === CHECK INPUT === CHECK INPUT === CHECK INPUT === CHECK INPUT === CHECK INPUT
    
    //check validation fullname vs name
    function checkname($checkname, $type) {
        if (!empty($checkname)) {          
            if (strlen($checkname) < 1 || strlen($checkname) > 30) {
                redirectWithError("*PLEASE FILL OUT YOUR ".$type." CORRECTLY IN ".$type." FIELD (AT LEAST 1 CHARACTERS AND NO MORE THAN 30 CHARACTERS)");
            }      
            else {
                if (preg_match("/[^a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]/", $checkname)) {
                    redirectWithError("*Only letters and whitespaces are allow in ".$type." field");
                }
            }
        }
        else {
            redirectWithError("*PLEASE FILL OUT YOUR ".$type."");
        } 
    }



    //check validation email
    function checkemail($checkemail) {
        if (!empty($checkemail)) {
            if (!filter_var($checkemail, FILTER_VALIDATE_EMAIL)) {
                redirectWithError("*Please enter a valid Email Address");
            }
        }
        else {
            redirectWithError("*PLEASE FILL OUT YOUR EMAIL ADDRESS");
        }
    }



    //check validation phonenumber
    function checkphonenumber($checkphonenumber) {
        if (!empty($checkphonenumber)) {                       
            if (strlen($checkphonenumber) < 8 || strlen($checkphonenumber) > 12) {
                redirectWithError("*PLEASE FILL OUT YOUR PHONE NUMBER CORRECTLY IN PHONE NUMBER FIELD (AT LEAST 8 CHARACTERS AND NO MORE THAN 14 CHARACTERS)");
            }
            else {                                   
                if (preg_match("/[^0-9]/", $checkphonenumber)) {
                    redirectWithError("*Only numbers are allow in Phone Number field");
                }
            }            
        }
        else {
            redirectWithError("*PLEASE FILL OUT YOUR PHONE NUMBER");
        }
    }



    //check validation address
    function checkaddress($checkaddress) {
        if (!empty($checkaddress)) {                       
            if (strlen($checkaddress) < 10 || strlen($checkaddress) > 2000) {
                redirectWithError("*PLEASE FILL OUT YOUR ADDRESS CORRECTLY IN ADDRESS FIELD (AT LEAST 10 CHARACTERS AND NO MORE THAN 2000 CHARACTERS)");
            }
            else {                                   
                if (preg_match("/[^a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s0-9\,\.\/\-]/", $checkaddress)) {
                    redirectWithError("*Only letters, numbers, hyphen (-), whitespace( ), slash (/) and commas (,)  are allow in Address field");
                }
            }            
        }
        else {
            redirectWithError("*PLEASE FILL OUT YOUR ADDRESS");
        }
    }



    //check validation message
    function checkmessage($checkmessage) {
        if (!empty($checkmessage)) {                       
            if (strlen($checkmessage) < 1 || strlen($checkmessage) > 1500) {
                redirectWithError("*PLEASE FILL OUT YOUR MESSAGE CORRECTLY IN MESSAGE FIELD (AT LEAST 10 CHARACTERS AND NO MORE THAN 1500 CHARACTERS)");
            }            
        }
        else {
            redirectWithError("*PLEASE FILL OUT YOUR MESSAGE");
        }
    }



    //check validation password
    function checkpassword($checkpassword) {
        if (!empty($checkpassword)) {                       
            if (strlen($checkpassword) < 6 || strlen($checkpassword) > 30) {
                redirectWithError("*PLEASE FILL OUT YOUR PASSWORD CORRECTLY IN PASSWORD FIELD (AT LEAST 6 CHARACTERS AND NO MORE THAN 30 CHARACTERS)");
            }
            else {                                   
                if (preg_match("/[^a-zA-Z0-9]/", $checkpassword)) {
                    redirectWithError("*Only letters and numbers are allow in Password field");
                }
            }            
        }
        else {
            redirectWithError("*PLEASE FILL OUT YOUR PASSWORD");
        }
    }

?>