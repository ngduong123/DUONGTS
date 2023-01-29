<?php
    session_start();
    
    if (!empty($_SESSION['text'])) {
        $text = $_SESSION['text'];
        unset($_SESSION['text']);
    } 
?>



<!DOCTYPE html> 
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>SUCCESS | DUONG THAC SI</title>
        
        <meta name="description" content="Discover DUONG THAC SI official online store. Explore the products of shirts, pants, shoes, bags for men.">
        <meta name="keywords" content="DUONG THAC SI">
        <meta name="author" content="DUONG THAC SI">
        <meta name="format-detection" content="telephone=no">
        
        <meta name="robots" content="index, follow">
        <meta name="apple-mobile-web-app-capable" content="yes">
        
        <meta property="fb:app_id" content="100014422207169">
        <meta property="og:title" content="<?php echo $pagetitle ?> | DUONG THAC SI">
        <meta property="og:description" content="Discover DUONG THAC SI official online store. Explore the products of shirts, pants, shoes, bags for men." />
        <!--<meta property="og:url" content="">-->
        <meta property="og:site_name" content="DUONG THAC SI">
        <meta property="og:type" content="website">
        
        <link rel="shortcut icon" href="../images/logos/favicon48x48.png">
        
        <link rel="icon" type="image/png" href="../../images/logos/favicon32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="../../images/logos/favicon48x48.png" sizes="48x48">
        <link rel="icon" type="image/png" href="../../images/logos/favicon96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="../../images/logos/favicon128x128.png" sizes="128x128">
        <link rel="icon" type="image/png" href="../../images/logos/favicon196x196.png" sizes="196x196">
        
        <meta name="apple-mobile-web-app-title" content="DUONG THAC SI">   
        <link rel="apple-touch-icon" sizes="120x120" href="../../images/logos/favicon120x120.png">
        <link rel="apple-touch-icon" sizes="180x180" href="../../images/logos/favicon180x180.png">
        
        <!--css-->
        <link rel="stylesheet" href="../../css/style.css">
        <!--Jquery-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="../../js/main.js"></script>
        <!--font-->
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        <!-- ion-icon -->
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        
        <style>

            * { 
                padding: 0;
                margin: 0;
                box-sizing: border-box;
                font-family: 'Roboto', sans-serif;
            } 

            .container{
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                min-width: 100vw;
                min-height: 100vh;
                padding: 10px;
                color: #ffffff;
                background: linear-gradient(#125b50, #066163);
                font-size: 13px;
                font-weight: 300;
                text-align: center;
                text-transform: uppercase;
            }

            .container p{
                margin-bottom: 10px;
            }

            .container a{
                color: #ffffff;
                font-size: 13px;
            }

            .container a:hover{
                text-decoration: none;
            }

            @media(max-width: 480px){
                .container{
                    font-size: 12px;
                }

                .container a{
                    color: #ffffff;
                    font-size: 11px;
                }

                .container p{
                    margin-bottom: 15px;
                }
            }
     
        </style>
    </head>
    <body>
        <div class="container">
        <?php
            if (!empty($text)) {
        ?>
        <div class="text"><?= $text ?></div>
        <?php
            }
        ?> 
        </div><!--container-->  
    </body>
</html>