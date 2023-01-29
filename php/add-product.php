<?php
    
    require "../setting/connect.php";

    session_start();



            //get value from select by post method from ajax
            if (isset($_POST["size"])) {
                $product_size = $_POST["size"];
            }
            else{ 
            }

            
            //get value from database
            if (isset($_POST["product_id"])) {
                $product_id = $_POST["product_id"];
            }
            else{
                $product_id = "";
            }

            //get value from database
            if (isset($_POST["product_name"])) {
                $product_name = $_POST["product_name"];
            }
            else{
                $product_name = "";
            }



            //get in_stock by name and size
            $result = mysqli_query($conn, "SELECT * FROM products, size, stock WHERE stock.product = products.product_id AND stock.size = size.id  AND size.size='$product_size' AND (product_id='$product_id' OR product_name='$product_name')");
            while($row = mysqli_fetch_assoc($result)) {
                echo $row["in_stock"];
            }
            
    mysqli_close($conn);
?>