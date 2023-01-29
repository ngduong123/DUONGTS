<?php
    require "./setting/connect.php";

    session_start();
?>




<!DOCTYPE html>
<html lang="en">
    <?php
        $pagetitle = "About DUONG THAC SI";
        include_once("../include/head.php");
    ?>



    <body>
        <div class="container">
            <?php
                include_once("../include/header.php")
            ?>
            
            
            
            <div class="about-us-main">
            
                <div class="about-us-content1">
                    <div class="background-image">
                        <div class="caption">
                            <p class="title">About DUONG THAC SI</p>
                            <a class="button-link">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ullam aut itaque eum quasi officiis provident maxime eveniet autem repudiandae in illo consequuntur asperiores natus, voluptatibus tempore temporibus possimus corrupti cum?</a>
                        </div>
                    </div><!--background-image-->
                </div><!--about-us-content1-->
                
            </div><!--about-us-main-->
            
            
            
            <?php
                include_once("../include/footer.php");
            ?>
        </div><!--container-->
    </body>
</html>



<?php
    mysqli_close($conn);
?>