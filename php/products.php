<?php
    require "./setting/connect.php";

    session_start();
?>



<!DOCTYPE html>
<html lang="en">
    <?php
        $pagetitle = "All Products";
        include_once("../include/head.php");
    ?>



    <body>
        <div class="container">
            <?php
                include_once("../include/header.php")
            ?>
            
            
            
            <div class="products-main">
                <div class="products-content1">
                    <div class="background-image">
                        <img src="images/backgrounds/background7.png" alt="">
                        <div class="caption">
                            <?php
                                //if have category in url => display product by category
                                //if not => display all
                                if(isset($_GET["category"])){
                                    $category = $_GET["category"];
                                    $result = mysqli_query($conn, "SELECT * FROM products, category WHERE products.category = category.id AND category.category='$category'");
                                }
                                else{
                                    $category = "All products";
                                    $result = mysqli_query($conn, "SELECT * FROM products, category WHERE products.category = category.id");
                                }
                            ?>
                            <p class="title"><?php echo $category; ?></p>
                        </div>
                    </div><!--background-image-->
                </div><!--products-content1-->
                
                <div class="product-grid">
                    
                    <?php
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                //check if in_stock == 0 => don't display
                                $product_id = $row['product_id'];
                                $total_in_stock = 0;
                                $result2 = mysqli_query($conn, "SELECT * FROM stock WHERE product='$product_id'");
                                while($row2 = mysqli_fetch_assoc($result2)) {
                                    $total_in_stock += $row2["in_stock"]; //calculate total in_stock
                                }

                                if ($total_in_stock > 0) {
                                    $product_name = preg_replace("/\s/", "-", $row["product_name"]);
                                        echo '
                                        <a href="php/productdetail.php?productname=' .$product_name. '-' .$row["product_id"]. '">
                                            <div class="product-item">
                                                <img src="images/products/' .$product_name. '_1.png" alt="">
                                                <p class="product-name">' .$row["product_name"]. '</p>
                                                <p class="product-price">$ ' .$row["product_price"]. '</p>
                                            </div><!--product-item-->
                                        </a>
                                        ';
                                }
                            }
                        }
                        else {
                            echo "We sold out!";
                        }
                    ?>
                </div><!--product-grid-->   
            </div><!--products-main-->
            
            
            
            <?php
                include_once("../include/footer.php");
            ?>
        </div><!--container-->
    </body>
</html>



<?php
    mysqli_close($conn);
?>
























