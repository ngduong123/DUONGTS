<footer>
    <div>
        <?php
            $result = mysqli_query($conn, "SELECT * FROM category");
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<a href="php/products.php?category=' .$row["category"]. '">' .$row["category"]. '</a>';
                }
            }
        ?>
        <a href="php/products.php">View all</a>
    </div>
    <div>
        <a href="">FAQ</a>
        <a href="php/account.php">My account</a>
    </div>              
    <div>
        <a href="mailto:56duong@gmail.com" target="_blank">56duong@gmail.com</a>
    </div>
    <div>
        <a href="https://www.facebook.com/nguyenduong071203" target="_blank">Facebook</a>
        <a href="https://instagram.com/nguyenduong_07" target="_blank">Instagram</a>
    </div>
</footer>