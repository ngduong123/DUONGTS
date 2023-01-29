<?php
    
    require "../setting/connect.php";
    require_once '../setting/functions.php';

    session_start();



            //get value from select by post method from ajax
            if (isset($_POST["address_type"])) {
                $address_type = $_POST["address_type"];
            }
            
            if (isset($_POST["email"])) {
                $email = $_POST["email"];
            }



            //get info by address_type
            $result = mysqli_query($conn, "SELECT *, address_type.address_type AS address_type_type FROM users, address_book, address_type WHERE users.user_id=address_book.user_id AND address_type.id=address_book.address_type AND email='$email' AND address_type.address_type='$address_type' ");
            
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '{"firstname":"'.$row['first_name'].'", "lastname":"'.$row['last_name'].'", "phonenumber":"'.$row['phone_number'].'", "address":"'.$row['address'].'"}';
                }
            }
            else {
                redirectWithError("*Couldn't find this address book");
            }
?>