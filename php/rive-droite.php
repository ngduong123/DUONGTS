<?php
    require "./setting/connect.php";

    session_start();
?>



<!DOCTYPE html>
<html lang="en">
    <?php
        $pagetitle = "Rive Droite";
        include_once("../include/head.php");
    ?>


    <body>
        <div class="container">
            <?php
                include_once("../include/header.php")
            ?>
            
            
            
            <div class="rive-droite-main">
                <div class="rdevent">
                    <div class="rdevent-media">
                        <img src="images/more/rive_droite.gif" alt="">
                        <!--   -->
                    </div>
                    <div class="rdevent-description">
                        <div class="rdevent-title">
                            <h2>08.19.22<br>SPILL TAB</h2>
                            <p>LIVE SESSIONS</p>
                            <p>AT SAINT LAURENT RIVE DROITE</p>
                        </div>
                        <div class="rdevent-text">
                            <p>THE COLLABORATION WITH EMERGING MUSICAL TALENTS AS PART OF THE "LIVE SESSIONS" SERIES AT SAINT LAURENT RIVE DROITE CONTINUES THIS TIME IN LOS ANGELES. ANTHONY VACCARELLO INVITED SPILL TAB TO PERFORM LIVE ON THE ROOFTOPS OF LOS ANGELES.</p>
                            <p>SPILL TAB IS A FRENCH-KOREAN SINGER, SONGWRITER AND MUSICIAN BASED IN LOS ANGELES. SPILL TAB HAS ONLY TWO EPS TO ITS REPERTOIRE, "OATMILK" AND “BONNIE” AND THE SINGLE "COTTON CANDY" HAS ALREADY BEEN LISTENED TO OVER 12 MILLION TIMES ON SPOTIFY ALONE.</p>
                            <p>THIS ARTIST EMBODIES THIS NEW GENERATION OF INDEPENDENT MUSICIANS WHO CREATE MUSIC IN THEIR APARTMENT WITH LITTLE MEANS AND WHO QUICKLY FIND SUCCESS, ESPECIALLY THANKS TO SOCIAL. HER UNIVERSE IS "LO-FI", THAT IS TO SAY A STRIPPED-DOWN PRODUCTION MADE WITH THE BARE MINIMUM. IT IS IMPERFECT, RAW AND SINCERE.</p>
                        </div>
                    </div>
                </div>
            </div><!--rive-droite-main-->
            
            
            
            <?php
                include_once("../include/footer.php");
            ?>
        </div><!--container-->
    </body>
</html>



<?php
    mysqli_close($conn);
?>
























