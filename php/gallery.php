<?php
    require "./setting/connect.php";

    session_start();
?>



<!DOCTYPE html>
<html lang="en">
    <?php
        $pagetitle = "Gallery";
        include_once("../include/head.php");
    ?>


    <body>
        <div class="container">
            <?php
                include_once("../include/header.php")
            ?>
            
            

            <div class="gallery-main">
                <p class="title">Gallery</p>           
                <div class="gallery">
                    <?php
                        $imagelist = "";
                        //find images with specified name ($gallery*)
                        $images = glob("../images/more/gallery*");
    
                        //loop through images
                        foreach($images as $image) {
                            $imagelist .= '<div class="gallery-item"><img src="images/' .$image. '" alt=""></div>';
                            // $imagelist .= '<div class="gallery-item"><img src="' .$image. '" alt=""></div>';
                        }

                        echo $imagelist;
                    ?>
                    
                </div><!--gallery-->       
            </div><!--gallery-main-->
            
            
            
            <?php
                include_once("../include/footer.php");
            ?>
        </div><!--container-->
    </body>
</html>
























