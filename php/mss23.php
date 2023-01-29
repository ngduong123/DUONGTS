<?php
    require "./setting/connect.php";

    session_start();
?>



<!DOCTYPE html>
<html lang="en">
    <?php
        $pagetitle = "Men's Spring Summer 23";
        include_once("../include/head.php");
    ?>


    <body>
        <div class="container">
            <?php
                include_once("../include/header.php")
            ?>
            
            
            
            <div class="index-main mss23-main">
                <div class="background-image">
                    <img src="images/more/mss23_2.png" alt="">
                    <div class="caption">
                        <p class="title">MEN'S<br>SPRING SUMMER 23</p>
                        <a href="https://www.youtube.com/watch?v=AxHmR6kEL4k" class="button-link" target="blank">Watch on youtube</a>
                    </div>
                </div>

                <div class="mss23-content">
                    <div class="slider">
                        <?php
                            $imagelist = "";
                            //find images with specified name ($gallery*)
                            $images = glob("../images/more/mss23_collection_*");
        
                            //loop through images
                            foreach($images as $image) {
                                $imagelist .= '<div class="slider-item"><img src="images/' .$image. '" alt=""></div>';
                                // $imagelist .= '<div class="gallery-item"><img src="' .$image. '" alt=""></div>';
                            }

                            echo $imagelist;
                        ?>
                    </div><!--slider-->
                    <div class="button-slider">
                        <p class="prev">Prev</p>
                        <p class="next">Next</p>
                    </div><!--button-slider-->

                    <div class="img-2">
                        <img src="images/more/mss23_3.png" alt="">
                        <img src="images/more/mss23_4.png" alt="">
                    </div>

                    <div class="img-1">
                        <img src="images/more/mss23_5.png" alt="">
                    </div>

                    <div class="background-image">
                        <img src="images/more/mss23.gif" alt="">
                        <div class="caption">
                        </div>
                    </div>

                    <div class="img-2">
                        <img src="images/more/mss23_6.png" alt="">
                        <img src="images/more/mss23_7.png" alt="">
                    </div>

                    <div class="img-1">
                        <img src="images/more/mss23_8.png" alt="">
                    </div>

                    <div class="slider">
                        <?php
                            $imagelist = "";
                            //find images with specified name ($gallery*)
                            $images = glob("../images/more/mss23_photocall_*");
        
                            //loop through images
                            foreach($images as $image) {
                                $imagelist .= '<div class="slider-item"><img src="images/' .$image. '" alt=""></div>';
                                // $imagelist .= '<div class="gallery-item"><img src="' .$image. '" alt=""></div>';
                            }

                            echo $imagelist;
                        ?>
                    </div><!--slider-->
                    <div class="button-slider">
                        <p class="prev">Prev</p>
                        <p class="next">Next</p>
                    </div><!--button-slider-->

                    <div class="img-2">
                        <img src="images/more/mss23_9.png" alt="">
                        <img src="images/more/mss23_10.png" alt="">
                    </div>

                    <div class="img-1">
                        <img src="images/more/mss23_11.png" alt="">
                    </div>

                    <div class="background-image">
                        <img src="images/more/mss23_12.png" alt="">
                        <div class="caption">
                            <p class="title">PHOTOCALL</p>
                            <a href="https://www.youtube.com/watch?v=UkvvU1IoIOY" class="button-link" target="blank">Watch the film</a>
                        </div>
                    </div>
                </div><!--mss23-content-->
            </div><!--index-main-->
            
            
            
            <?php
                include_once("../include/footer.php");
            ?>
        </div><!--container-->
    </body>
</html>



<?php
    mysqli_close($conn);
?>
























