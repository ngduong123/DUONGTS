<?php
    require "./setting/connect.php";

    session_start();
?>



<!DOCTYPE html>
<html lang="en">
    <?php
        $pagetitle = "BAG";
        include_once("../include/head.php");
    ?>



    <body>
        <div class="container">
            <?php
                include_once("../include/header.php")
            ?>
            
            
    
            <div class="bag-main">
                <div class="background-image">
                    <img src="images/backgrounds/background6.png" alt="">
                    <div class="caption">
                        <p class="title">Shopping bag</p>
                    </div>
                </div><!--background-image-->

                <div class="bag-panel">
                    <p>Shopping Bag</p>   

                    <div class="bag-list">
                    </div><!--bag-list-->
                    
                    <div class="order-summary">
                        <p>Order summary</p>
                        <div class="subtotal">
                            <p >Subtotal</p>
                            <p>$ <span class="subtotal-value"></span></p>
                        </div>
                        <div class="shipping">
                            <p>Shipping</p>
                            <p>$ <span class="shipping-value">10</span></p>
                        </div>
                        <div class="total">
                            <p>Total</p>
                            <p>$ <span class="total-value"></span></p>
                        </div>
                        <div class="checkout">
                            <a href="php/checkout.php">Checkout</a>
                        </div>
                    </div><!--order-summary-->             
                </div><!--bag-panel-->
            </div><!--bag-main-->
            
            
            
            <?php
                include_once("../include/footer.php");
            ?>
        </div><!--container-->



        <script>
            //display html of .bag-main .bag-list
            $(".bag-main .bag-list").html(localStorage.getItem("htmlBagList"));

            //loop through every product in .bag-main .bag-list
            $(".bag-main .bag-item").each(function() {
                //get name anf size of every product
                var size = $(this).find(".bag-item-size").text();
                var product_name = $(this).find(".bag-item-name").text();

                //get in_stock value of each product
                var in_stock; //declare in_stock to use outside ajax
                $.ajax({
                    async : false, //this line make code can use in_stock outside ajax
                    url: "php/submit/add-product.php",
                    type: "post",
                    data: {size: size, product_name: product_name},
                    success: function (response) {
                        //update in_stock when ajax success
                        in_stock = response;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });

                //loop through in_stock and display option
                var quantity = "";
                for(let i = 1; i <= parseInt(in_stock); i++){
                    quantity += '<option value="' + i + '">' + i + '</option>';
                }

                //set html for select, option = in_stock
                $(this).find("select[name='bag-item-quantity']").html(quantity);
            }); 

            //save html with quantity option when user visit page
            localStorage.setItem("htmlBagList", $(".bag-main .bag-list").html());

        </script>

    </body>
</html>



<?php
    mysqli_close($conn);
?>