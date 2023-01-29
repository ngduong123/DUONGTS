<?php
    require "./php/setting/connect.php";

    session_start();
?>



<!DOCTYPE html>
<html lang="en">
    <?php
        $pagetitle = "DUONG THAC SI Official Store";
        include_once("./include/head.php");
    ?>



    <body>
        <div class="container">
            <?php
                include_once("./include/header.php")
            ?>
            
            
            
            <div class="index-main">
                <div class="background-image">
                    <img src="images/more/mss23_1.png" alt="">
                    <div class="caption">
                        <p class="title">MEN'S SPRING SUMMER 23</p>
                        <a href="php/mss23.php" class="button-link">View the collection</a>
                    </div>
                </div>

                <div class="background-image">
                    <picture>
                        <source media="(max-width: 768px)" srcset="images/more/rive_droite_2.png">
                        <img src="images/more/rive_droite_1.png">
                    </picture>
                    <div class="caption">
                        <p class="title">08.19.22<br>SPILL TAB</p>
                        <a href="php/rive-droite.php" class="button-link">View</a>
                    </div>
                </div>

                <!-- <div class="slideshow">
                    <div class="background-image">
                        <picture>
                            <source media="(max-width: 767px)" srcset="images/backgrounds/background1-small.png">
                            <img src="images/backgrounds/background1.png">
                        </picture>
                        <div class="caption">
                            <p class="title">Shirts</p>
                            <a href="" class="button-link">Shop now</a>
                        </div>
                    </div>
                    <div class="background-image">
                        <picture>
                            <source media="(max-width: 767px)" srcset="images/backgrounds/background2-small.png">
                            <img src="images/backgrounds/background2.png">
                        </picture>
                        <div class="caption">
                            <p class="title">Pants</p>
                            <a href="" class="button-link">Shop now</a>
                        </div>
                    </div>
                    <div class="background-image">
                        <picture>
                            <source media="(max-width: 767px)" srcset="images/backgrounds/background3-small.png">
                            <img src="images/backgrounds/background3.png">
                        </picture>
                        <div class="caption">
                            <p class="title">Shoes</p>
                            <a href="" class="button-link">Shop now</a>
                        </div>
                    </div>
                    <div class="background-image">
                        <picture>
                            <source media="(max-width: 767px)" srcset="images/backgrounds/background4-small.png">
                            <img src="images/backgrounds/background4.png">
                        </picture>
                        <div class="caption">
                            <p class="title">Bags</p>
                            <a href="" class="button-link">Shop now</a>
                        </div>
                    </div>
                </div> -->
            </div><!--index-main-->
            
            
            
            <?php
                include_once("./include/footer.php");
            ?>
        </div><!--container-->
    </body>
</html>



<?php
    mysqli_close($conn);
?>
























