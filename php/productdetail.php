<?php
    require "./setting/connect.php";

    session_start();
?>



<!DOCTYPE html>
<html lang="en">
    <?php
        $pagetitle = "Product Detail";
        include_once("../include/head.php");
    ?>



    <body>
        <div class="container">
            <?php
                include_once("../include/header.php")
            ?>
            
            
            
            <div class="productdetail-main">
                <?php
                    //get product_id in url
                    $product_id = substr($_GET["productname"], strrpos($_GET["productname"], '-') + 1);

                    //get product_name by product_id and chang " " to "-"
                    $result = mysqli_query($conn, "SELECT * FROM products WHERE product_id='$product_id'");
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $product_name = preg_replace("/\s/", "-", $row["product_name"]);
                        }
                    }
                    else{
                        echo "Something went wrong!";
                    }

                    $imagelist = "";
                    //find images with specified name ($productname*)
                    $images = glob("../images/products/" .$product_name. "*");

                    //loop through images
                    foreach($images as $image) {
                        $imagelist .= '<img src="images/' .$image. '" alt="">';
                    }



                    //display images
                    echo '
                        <div class="product-image">
                            <div class="small-image">
                            ' .$imagelist. '
                            </div>
                            <div class="big-image">
                            ' .$imagelist. '
                            </div>               
                        </div><!--product-image-->
                    ';
                ?>

                <div class="product-infor">
                    <?php
                        $result = mysqli_query($conn, "SELECT * FROM products WHERE product_id='$product_id'");
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                
                                //product description
                                //get product_detailslist in database and split ,\s into an array
                                $product_detailslist_array = explode('; ', $row["product_detailslist"]);
                                $product_detailslists = "";
                                
                                foreach($product_detailslist_array as $product_detailslist) {
                                    $product_detailslists .= '<li>&#9679; ' .$product_detailslist. '</li>';
                                }

                                echo ' 
                                    <p class="name">' .$row["product_name"]. '</p>
                                    <p class="price">$ ' .$row["product_price"]. '</p>
                                    <div class="product-detail">             
                                        <div class="product-description">
                                            <p>' .$row["product_description"]. '</p>
                                            <ul>
                                                ' .$product_detailslists. '
                                            </ul>
                                        </div><!--product-description-->
                                ';
                            }
                        }
                        else {
                            echo "Something went wrong!";
                        }
                    ?>
                            <div class="product-size">                         
                                <p class="product-infor-title">Size:</p>
                                <select name="size">
                                    <option selected>Select size</option>
                                    <?php
                                        $result = mysqli_query($conn, "SELECT size.size FROM products, size, stock WHERE stock.product = products.product_id AND stock.size = size.id AND product_id='$product_id' AND in_stock > 0");
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '
                                                <option value="' .$row["size"]. '">' .$row["size"]. '</option>
                                            ';
                                        }
                                    ?>
                                </select>
                                <p class="error"></p>
                                <p class="size-guide">View size guide</p>
                                <img src="images/more/size-guide.png" alt="" class="size-guide-image">
                            </div><!--product-size-->             
                        <button class="add-product">Add to shopping bag</button>
                    </div><!--product-detail-->
                </div><!--product-infor-->
            </div><!--productdetail-main-->
    

            
            <?php
                include_once("../include/footer.php");
            ?>
        </div><!--container-->        



        <script>
            //get product_id in url (get text from last -)
            var product_id = window.location.href.substring(window.location.href.lastIndexOf("-") + 1);

            //get live value from select by ajax without reloading the page on change select box
            $(".product-size select[name=size]").change(function() {
                //Example:size=M
                var size = $(this).val();

                $.ajax({
                    url: "php/submit/add-product.php",
                    type: "post",
                    data: {size: size, product_id: product_id},
                    success: function (response) {
                        //update in_stock when ajax success
                        var in_stock = response;
                        localStorage.setItem("in_stock", in_stock); 
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });

            });

        </script>



    </body>
</html>



<?php
    mysqli_close($conn);
?>
























