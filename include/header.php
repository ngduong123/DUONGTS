<header>
    <div class="logo">
        <a href=""><img src="images/logos/favicon96x96.png" alt=""></a>
    </div><!--logo-->
    <div class="menu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li class="small-menu"><a>Products</a>
                <ul>
                    <?php
                        $result = mysqli_query($conn, "SELECT * FROM category");
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo '<li><a href="php/products.php?category=' .$row["category"]. '">' .$row["category"]. '</a></li>';
                            }
                        }
                        else{
                            echo "Something went wrong!";
                        }
                    ?>
                    <li><a href="php/products.php">View all</a></li>
                </ul>
            </li>
            <li><a href="php/gallery.php">Gallery</a></li>
            <li><a href="php/about-us.php">About us</a></li>
            <li><a href="php/contact-us.php">Contact us</a></li>
        </ul>
    </div><!--menu-->
           
           
           
    <div class="setting">
              
        <div class="bag">
            <p>Bag <span class="bag-product-count"></span></p>
            <div class="bag-panel">
                      
                <p>Shopping Bag</p>
                       
                <div class="bag-list">
                </div><!--bag-list-->
                       
                <div class="order-summary">
                    <div class="subtotal">
                        <p>Subtotal</p>
                        <p>$ <span class="subtotal-value"></span></p>
                    </div>
                    <div class="checkout">
                        <a href="php/bag.php">Checkout</a>
                    </div>
                </div><!--order-summary-->
                       
            </div><!--bag-panel-->
        </div><!--bag-->
               
        <div class="account">
            <p>Account</p>
            <div class="account-panel">
                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) : ?>
                    <a href="php/account.php">My account</a>
                    <p>or</p>
                    <a href="php/submit/log-out.php">Log out</a>
                <?php else : ?>
                    <a href="php/sign-in-form.php">Log in</a>
                    <p>or</p>
                    <a href="php/register-form.php">Create my DUONG THAC SI account</a>
                <?php endif; ?>      
            </div>
        </div><!--account-->
               
        <div class="menu-icon">
            <p class="open-menu"><ion-icon name="menu-outline"></ion-icon></p>
            <p class="close-menu"><ion-icon name="close-outline"></ion-icon></p>
        </div>
    </div><!--setting-->
</header>