<?php
    require "../setting/connect.php";
    require 'vendor/autoload.php';

    session_start();

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false || $_SESSION["role"] != "admin") {
        header("Location: ../sign-in-form.php");
        die();
    }
?>



<!DOCTYPE html>
<html lang="en">
    <?php
        $pagetitle = "ADMIN";
        include_once("../../include/head.php");
    ?>

    <body>

        <div class="container admin">

            <header>
                <div class="left-header">
                    <div class="logo">D</div><!--logo-->

                    <div class="menu">
                        <nav>
                            <ul>
                                <li class="tab-link active-menu"><ion-icon name="podium-outline"></ion-icon><span>Dashboard</span></li>
                                <li class="tab-link"><ion-icon name="shirt-outline"></ion-icon><span>Products</span></li>
                                <li class="tab-link"><ion-icon name="receipt-outline"></ion-icon><span>Orders</span></li>
                                <li class="tab-link"><ion-icon name="people-outline"></ion-icon><span>Users</span></li>
                                <li class="tab-link"><ion-icon name="square-outline"></ion-icon><span>Tables</span></li>
                            </ul>
                        </nav>
                    </div><!--menu-->

                </div><!--left-header-->
            </header>

            <div class="admin-main">
                <div class="top-menu">
                    <div class="menu-title">dashboard</div><!--dashboard-->

                    <div class="setting">
                        <ion-icon name="notifications-outline"></ion-icon>
                        <ion-icon name="mail-outline"></ion-icon>
                        <div>
                            <ion-icon class="admin-account" name="person-outline"></ion-icon>
                            <div class="account-panel">
                                <a href="php/submit/log-out.php">Log out</a>
                            </div>
                        </div>
                    </div>
                </div><!--top-menu-->





                <!-- dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard -->
                <div id="dashboard" class="tab-content dashboard-table">
                    <div class="chart">
                        <p class="chart-title">Views by Page Title</p>
                        <p class="chart-title">Last 7 days</p>
                        <div id="top_x_div" style="width: 600px; height: 400px;"></div>
                    </div><!--chart-->
                    
                    <table class="table-list">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Views</th>
                                <th>Users</th>
                                <th>New users</th>
                                <th>Events</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span>1</span>About DUONG THAC SI | DUONG THAC SI</td>
                                <td>191</td>
                                <td>1</td>
                                <td>0</td>
                                <td>555</td>
                            </tr>
                        
                            <tr>
                                <td><span>2</span>ADMIN | DUONG THAC SI</td>
                                <td>52</td>
                                <td>1</td>
                                <td>1</td>
                                <td>154</td>
                            </tr>
                        
                            <tr>
                                <td><span>3</span>DUONG THAC SI Official Store | DUONG THAC SI</td>
                                <td>6</td>
                                <td>2</td>
                                <td>2</td>
                                <td>21</td>
                            </tr>
                        
                            <tr>
                                <td><span>4</span>Men's Spring Summer 23 | DUONG THAC SI</td>
                                <td>2</td>
                                <td>1</td>
                                <td>0</td>
                                <td>5</td>
                            </tr>
                        
                            <tr>
                                <td><span>5</span>Rive Droite | DUONG THAC SI</td>
                                <td>1</td>
                                <td>1</td>
                                <td>0</td>
                                <td>2</td>
                            </tr> 
                        </tbody>
                    </table><!--table-list-->
                </div><!--dashboard-->





                <!-- products products products products products products products products products products products products products products products products products products products products -->
                <div id="products" class="tab-content"> 

                    <div class="option">
                        <div class="filter">
                            <span>View by Category</span>
                            <select name="filter-category" class="filter-products">
                                <option value="all">All</option>
                                <?php
                                    $result = mysqli_query($conn, "SELECT * FROM category");
                                    if(mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="'.$row["category"]. '">'.$row["category"]. '</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div><!--filter-->



                        <div class="search-add">
                            <div class="search">
                                <input id="products" type="text" name="search" placeholder="Search in table..">
                                <ion-icon name="search-outline"></ion-icon>
                            </div>
                            <div class="addnew addnewproduct">
                                <button class="addnew-button" id="addnewproduct-form"><ion-icon name="add-outline"></ion-icon>Add new item</button>
                                <div class="form-popup addnewproduct-form">
                                    <form action="" id="addnewproduct" class="add" enctype="multipart/form-data">
                                        <div class="form-row form-info">
                                            <ion-icon name="close-outline"></ion-icon>
                                            <h1>Add new product</h1>
                                            <p>FIELDS MARKED * ARE MANDATORY</p>
                                        </div><!--form-row form-info-->

                                        <div>
                                            <div class="form-row">
                                                <span>Category *</span>
                                                <select name="product_category">
                                                    <?php
                                                        $result = mysqli_query($conn, "SELECT * FROM category");
                                                        if(mysqli_num_rows($result) > 0) {
                                                            while($row = mysqli_fetch_assoc($result)) {
                                                                echo '<option value="'.$row["id"]. '">'.$row["category"]. '</option>';
                                                            }
                                                        }
                                                        else{
                                                            echo "Something went wrong!";
                                                        }
                                                    ?>
                                                </select>
                                                <div class="field-error"></div>
                                            </div><!--form-row-->
    
                                            <div class="form-row">
                                                <label for="">Product Name *</label>
                                                <input type="text" name="product_name" value="" required maxlength="200" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s0-9-]{1,200}$" data-error-parse="Only letters, numbers, hyphen (-) and whitespace( ) are allow in this field" data-error-missing="PLEASE FILL OUT PRODUCT NAME CORRECTLY IN THIS FIELD">
                                                <div class="field-error"></div>
                                            </div><!--form-row-->
                                                
                                            <div class="form-row">
                                                <label for="">Product Price*</label>
                                                <input type="number" name="product_price" value="" required maxlength="30" pattern="^[0-9]$" data-error-parse="Only numbers are allow in this field" data-error-missing="PLEASE FILL OUT PRODUCT PRICE CORRECTLY IN THIS FIELD">
                                                <div class="field-error"></div>
                                            </div><!--form-row-->

                                            <div class="form-row">
                                                <span>Size *</span>
                                                <select name="product_size">
                                                    <?php
                                                        $result = mysqli_query($conn, "SELECT * FROM size");
                                                        if(mysqli_num_rows($result) > 0) {
                                                            while($row = mysqli_fetch_assoc($result)) {
                                                                echo '<option value="'.$row["id"]. '">'.$row["size"]. '</option>';
                                                            }
                                                        }
                                                        else{
                                                            echo "Something went wrong!";
                                                        }
                                                    ?>
                                                </select>
                                                <div class="field-error"></div>
                                            </div><!--form-row-->
    
                                            <div class="form-row">
                                                <label for="">Product In stock *</label>
                                                <input type="number" name="product_instock" value="" required maxlength="30" pattern="^[0-9]$" data-error-parse="Only numbers are allow in this field" data-error-missing="PLEASE FILL OUT PRODUCT IN STOCK CORRECTLY IN THIS FIELD">
                                                <div class="field-error"></div>
                                            </div><!--form-row-->
                                        </div>

                                        <div>
                                            <div class="form-row">
                                                <label for="">Product DESCRIPTION</label>
                                                <textarea name="product_description" value="" maxlength="5000" pattern="" data-error-parse="" data-error-missing=""></textarea>
                                                <div class="field-error"></div>
                                            </div><!--form-row-->
    
                                            <div class="form-row">
                                                <label for="">Product DETAILS LIST (SEPARATE BY SEMICOLON AND SPACE (a; b))</label>
                                                <textarea name="product_detailslist" value="" maxlength="5000" pattern="" data-error-parse="" data-error-missing=""></textarea>
                                                <div class="field-error"></div>
                                            </div><!--form-row-->

                                            <div class="form-row">
                                                <label for="">Images *</label>
                                                <input type="file" name="fileToUpload[]" id="fileToUpload" multiple required>
                                                <div class="field-error"></div>
                                            </div><!--form-row-->
                                        </div>

                                        <div class="button-cancel-save">
                                            <button type="button" class="cancel">Cancel</button>
                                            <button type="button" class="send">Add</button>
                                        </div>
                                    </form>
                                </div><!--form-popup-->
                            </div><!--addnewproduct-->
                        </div><!--search-add-->
                    </div><!--option-->



                    <table class="table-list" id="products">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price ($)</th>
                                <th>Size</th>
                                <th>In stock</th>
                                <th>Description</th>
                                <th>Details list (Separate by comma)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="filter-products">
                            <?php
                                $result = mysqli_query($conn, "SELECT *, size.id AS size_id  FROM products, stock, category, size WHERE products.product_id=stock.product AND category.id=products.category AND size.id=stock.size ORDER BY product_id DESC");
                                if(mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $product_img = preg_replace("/\s/", "-", $row["product_name"]);
                                        echo '
                                            <tr class="'.$row["category"].'">
                                                <td id="item-id" item-id='.$row["product_id"].' size='.$row["size_id"].'>'.$row["product_id"].'</td>
                                                <td><img src="images/products/'.$product_img.'_1.png" alt=""></td>
                                                <td>'.$row["product_name"].'</td>
                                                <td>'.$row["product_price"].'</td>
                                                <td>'.$row["size"].'</td>
                                                <td>'.$row["in_stock"].'</td>
                                                <td>'.$row["product_description"].'</td>
                                                <td>'.$row["product_detailslist"].'</td>
                                                <td><span class="edit-product">Edit</span><span class="delete-product">Delete</span></td>
                                            </tr>
                                        ';
                                    }
                                }
                            ?>
                        </tbody>
                      </table><!--table-list-->

                </div><!--products-->





                <!-- orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders -->
                <div id="orders" class="tab-content">
                    <div class="option">
                        <div class="filter">
                            <span>View by Status</span>
                            <select name="filter-category" class="filter-order">
                                <option value="all">All</option>
                                <?php
                                    $result = mysqli_query($conn, "SELECT * FROM order_status");
                                    if(mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="'.$row["status"]. '">'.$row["status"]. '</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div><!--filter-->



                        <div class="search-add">
                            <div class="search">
                                <input id="orders" type="text" name="search" placeholder="Search in table..">
                                <ion-icon name="search-outline"></ion-icon>
                            </div>
                            <div class="addnew addneworder">
                                <button class="addnew-button" id="addneworder-form"><ion-icon name="add-outline"></ion-icon>Add new order</button>
                                <div class="form-popup addneworder-form">
                                    <form action="" id="addneworder" class="add">
                                        <div class="form-row form-info">
                                            <ion-icon name="close-outline"></ion-icon>
                                            <h1>Add new order</h1>
                                            <p>FIELDS MARKED * ARE MANDATORY</p>
                                        </div><!--form-row form-info-->

                                        <div>
                                            <div class="form-row">
                                                <label for="">Status *</label>
                                                <select name="order_status" required>
                                                <!-- <option value="" selected disabled hidden>Choose here</option> -->
                                                    <?php
                                                        $result = mysqli_query($conn, "SELECT * FROM order_status");
                                                        if(mysqli_num_rows($result) > 0) {
                                                            while($row = mysqli_fetch_assoc($result)) {
                                                                echo '<option value="'.$row["status"]. '">'.$row["status"]. '</option>';
                                                            }
                                                        }
                                                        else{
                                                            echo "Something went wrong!";
                                                        }
                                                    ?>
                                                </select>
                                                <label class="radio sendemail">
                                                    Send email
                                                    <input type="checkbox" name="sendemail" value="send" checked="" readonly="">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <div class="field-error"></div>
                                            </div><!--form-row-->
    
                                            <div class="form-row">
                                                <label for="">User's Email</label>
                                                <select name="order_useremail" id="">
                                                    <option value="none">None</option>
                                                    <?php
                                                        $result = mysqli_query($conn, "SELECT * FROM users WHERE role=0 AND status=1");
                                                        if(mysqli_num_rows($result) > 0) {
                                                            while($row = mysqli_fetch_assoc($result)) {
                                                                echo '<option value="'.$row["email"]. '">'.$row["email"]. '</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                                <div class="field-error"></div>
                                            </div><!--form-row-->

                                            <div class="form-row">
                                                <label for="">Address book</label>
                                                <select name="address_type">
                                                </select>
                                            </div><!--form-row-->

                                            <div class="form-row">
                                                <label for="">First name *</label>
                                                <input type="text" name="firstname" value="" required maxlength="30" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]{1,30}$" data-error-parse="Only letters and whitespaces are allow in this field" data-error-missing="PLEASE FILL OUT YOUR FIRST NAME CORRECTLY IN THIS FIELD">
                                                <div class="field-error"></div>
                                            </div><!--form-row-->
                                            
                                            <div class="form-row">
                                                <label for="">Last name *</label>
                                                <input type="text" name="lastname" value="" required maxlength="30" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]{1,30}$" data-error-parse="Only letters and whitespaces are allow in this field" data-error-missing="PLEASE FILL OUT YOUR LAST NAME CORRECTLY IN THIS FIELD">
                                                <div class="field-error"></div>
                                            </div><!--form-row-->
                                        
                                            <div class="form-row">
                                                <label for="">Email *</label>
                                                <input type="email" name="email" value="" required maxlength="128" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" data-error-parse="Invalid email format. Please try again, example &quot;john.smith@email.com&quot;." data-error-missing="PLEASE ADD YOUR EMAIL ADDRESS">
                                                <div class="field-error"></div>
                                            </div><!--form-row-->
                                            
                                            <div class="form-row">
                                                <label for="">Phone number *</label>
                                                <input type="tel" name="phonenumber" value="" required maxlength="12" pattern="^[0-9]{8,12}$" data-error-parse="Only numbers are allow in this field" data-error-missing="PLEASE FILL OUT YOUR PHONE NUMBER CORRECTLY IN THIS FIELD (AT LEAST 8 CHARACTERS AND NO MORE THAN 14 CHARACTERS)">
                                                <div class="field-error"></div>
                                            </div><!--form-row-->
                
                                            <div class="form-row">
                                                <label for="">Address *</label>
                                                <input type="text" name="address" value="" required maxlength="2000" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s0-9,./-]{10,2000}$" data-error-parse="Only letters, numbers, hyphen (-), whitespace( ), slash (/) and commas (,)  are allow in this field" data-error-missing="PLEASE FILL OUT YOUR ADDRESS CORRECTLY IN THIS FIELD">
                                                <div class="field-error"></div>
                                            </div><!--form-row-->
                                        </div>

                                        <div>
                                            <div class="form-row">
                                                <label for="">Message<br>LEAVE A MESSAGE FOR US. (MAX 1500 CHAR) *</label>
                                                <textarea name="message" required maxlength="1500" data-error-missing="Please insert a text in this field precising your request so that we can provide a relevant answer."></textarea>
                                                <div class="field-error"></div>
                                            </div><!--form-row-->

                                            <div class="form-row form-radio">
                                                <label for="">Payment Options</Address>*</label>

                                                <label class="radio">
                                                    COD
                                                    <input type="radio" name="paymentoptions" value="cod" checked readonly>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div><!--form-row-->

                                            <div class="form-row">
                                                <label for="">Item *</label>
                                                <select name="order_item" required>
                                                <?php
                                                    $result = mysqli_query($conn, "SELECT * FROM products, stock, category, size WHERE products.product_id=stock.product AND category.id=products.category AND size.id=stock.size ORDER BY product_id");
                                                    if(mysqli_num_rows($result) > 0) {
                                                        while($row = mysqli_fetch_assoc($result)) {
                                                            echo '
                                                                <option value=\'{"product_name":"'.$row["product_name"].'","product_price":"'.$row["product_price"].'", "size":"'.$row["size"].'", "in_stock":"'.$row["in_stock"].'"}\'>
                                                                    '.$row["product_id"].' | '.$row["product_name"].' | $'.$row["product_price"].' | '.$row["size"].'
                                                                </option>
                                                            ';
                                                        }
                                                    }
                                                    else{
                                                        echo "Something went wrong!";
                                                    }
                                                ?>
                                                </select>

                                                <select name="quantity[]" required>
                                                </select>

                                                <button type="button" class="add-item-button">Add</button>
                                                <button type="button" class="clear-item-button">Clear</button>
                                            </div><!--form-row-->

                                            <div class="item-list">
                                            </div><!--item-list-->

                                            <div class="addorder-total">
                                                Subtotal: $ <input name='subtotal' value='0' required readonly><br>
                                                Shipping: $ <input name='shipping' value='10' required readonly><br>
                                                Total: $ <input name='total' value='0' required readonly>
                                            </div>

                                        </div>

                                        <div class="button-cancel-save">
                                            <button type="button" class="cancel">Cancel</button>
                                            <button type="button" class="send">Add</button>
                                        </div>
                                    </form>
                                </div><!--form-popup-->
                            </div><!--addnewproduct-->
                        </div><!--search-add-->
                    </div><!--option-->



                    <table class="table-list" id="orders">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>User ID</th>
                                <th>Customer name</th>
                                <th>Email</th>
                                <th>Phone number</th>
                                <th>Order Item</th>
                                <th>Total</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="filter-order">
                            <?php
                                $result = mysqli_query($conn, "SELECT * FROM orders, customers, order_status WHERE orders.customer_id=customers.customer_id AND orders.status=order_status.status_id ");
                                if(mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo '
                                            <tr class="'.$row["status"].'">
                                                <td id="item-id" item-id='.$row["order_id"].' customer_id='.$row["customer_id"].' order_item_id='.$row["order_item_id"].'># '.$row["order_id"].'</td>
                                                <td>'.$row["user_id"].'</td>
                                                <td>'.$row["first_name"].' '.$row["last_name"].'</td>
                                                <td>'.$row["email"].'</td>
                                                <td>'.$row["phone_number"].'</td>
                                                <td>'.$row["order_item_id"].'</td>
                                                <td>'.$row["total"].'</td>
                                                <td>'.$row["created"].'</td>
                                                <td>'.$row["status"].'</td>
                                                <td><span class="edit-order">Edit</span><span class="delete-order">Delete</span></td>
                                            </tr>
                                        ';
                                    }
                                }
                            ?>
                        </tbody>
                    </table><!--table-list-->
                </div><!--orders-->





                <!-- users users users users users users users users users users users users users users users users users users users users users users users users users users -->
                <div id="users" class="tab-content">
                    <div class="option">
                        <div class="filter">
                            <span>View by role</span>
                            <select name="filter-category" class="filter-user">
                                <option value="all">All</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                            </select>
                        </div><!--filter-->



                        <div class="search-add">
                            <div class="search">
                                <input id="users" type="text" name="search" placeholder="Search in table..">
                                <ion-icon name="search-outline"></ion-icon>
                            </div>
                            <div class="addnew addnewuser">
                                <button class="addnew-button" id="addnewuser-form"><ion-icon name="add-outline"></ion-icon>Add new user</button>
                                <div class="form-popup addnewuser-form">
                                    <form action="" id="addnewuser" class="add">
                                        <div class="form-row form-info">
                                            <ion-icon name="close-outline"></ion-icon>
                                            <h1>Add new user</h1>
                                            <p>FIELDS MARKED * ARE MANDATORY</p>
                                        </div><!--form-row form-info-->

                                        <div>
                                            <div class="form-row">
                                                <label for="">Email *</label>
                                                <input type="email" name="email" required maxlength="128" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" data-error-parse="Invalid email format. Please try again, example &quot;john.smith@email.com&quot;." data-error-missing="PLEASE ADD YOUR EMAIL ADDRESS">
                                                <div class="field-error"></div>
                                            </div><!--form-row-->
                                                    
                                            <div class="form-row">
                                                <label for="">Password *</label>
                                                <input type="password" name="password" required maxlength="30" pattern="[a-zA-Z0-9]{6,30}" data-error-parse="Only letters and numbers are allow in this field" data-error-missing="PLEASE FILL OUT YOUR PASSWORD CORRECTLY IN THIS FIELD">
                                                <div class="field-error"></div>
                                            </div><!--form-row-->

                                            <div class="form-row">
                                                <label for="">Role *</label>
                                                <select name="role" required>
                                                    <option value="0">User</option>
                                                    <option value="1">Admin</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="form-row">
                                                <label for="">First name *</label>
                                                <input type="text" name="firstname" required maxlength="30" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]{1,30}$" data-error-parse="Only letters and whitespaces are allow in this field" data-error-missing="PLEASE FILL OUT YOUR FIRST NAME CORRECTLY IN THIS FIELD">
                                                <div class="field-error"></div>
                                            </div><!--form-row-->
                                            
                                            <div class="form-row">
                                                <label for="">Last name *</label>
                                                <input type="text" name="lastname" required maxlength="30" pattern="^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]{1,30}$" data-error-parse="Only letters and whitespaces are allow in this field" data-error-missing="PLEASE FILL OUT YOUR LAST NAME CORRECTLY IN THIS FIELD">
                                                <div class="field-error"></div>
                                            </div><!--form-row-->

                                            <div class="form-row">
                                                <label for="">Birthdate</label>
                                                <input type="date" name="birthdate" value="" maxlength="30" pattern="[0-9/]{6}" data-error-parse="Only numbers and slash are allow in this field" data-error-missing="PLEASE FILL OUT YOUR BIRTHDATE CORRECTLY IN THIS FIELD">
                                                <div class="field-error"></div>
                                            </div><!--form-row-->
                                        </div>

                                        <div class="button-cancel-save">
                                            <button type="button" class="cancel">Cancel</button>
                                            <button type="button" class="send">Add</button>
                                        </div>
                                    </form>
                                </div><!--form-popup-->
                            </div><!--addnewproduct-->
                        </div><!--search-add-->
                    </div><!--option-->



                    <table class="table-list" id="users">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>Birthdate</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="filter-user">
                            <?php
                                $result = mysqli_query($conn, "SELECT * FROM users");
                                if(mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo '
                                            <tr class="'.$row["role"].'">
                                                <td id="item-id" item-id='.$row["user_id"].'>'.$row["user_id"].'</td>
                                                <td>'.$row["email"].'</td>
                                                <td>'.$row["password"].'</td>
                                                <td>'.$row["first_name"].'</td>
                                                <td>'.$row["last_name"].'</td>
                                                <td>'.$row["birthdate"].'</td>
                                                <td>'.$row["created"].'</td>
                                                <td>'.$row["status"].'</td>
                                                <td>'.$row["role"].'</td>
                                                <td><span class="edit-user">Edit</span><span class="delete-user">Delete</span></td>
                                            </tr>
                                        ';
                                    }
                                }
                            ?>
                        </tbody>
                    </table><!--table-list-->
                </div><!--users-->





                <!-- tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables -->
                <div id="tables" class="tab-content">

                    <!-- address-type address-type address-type address-type address-type -->
                    <div class="tables-div">
                        <h2>ADDRESS TYPE</h2>

                        <div class="option">
                            <div class="filter">
                            </div><!--filter-->

                            <div class="search-add">
                                <div class="search">
                                    <input id="addresstypes" type="text" name="search" placeholder="Search in table..">
                                    <ion-icon name="search-outline"></ion-icon>
                                </div>
                                <div class="addnew addnewaddresstype">
                                    <button class="addnew-button" id="addnewaddresstype-form"><ion-icon name="add-outline"></ion-icon>Add new Address type</button>
                                    <div class="form-popup addnewaddresstype-form">
                                        <form action="" class="add" id="addnewaddresstype">
                                            <div class="form-row form-info">
                                                <ion-icon name="close-outline"></ion-icon>
                                                <h1>Add new address type</h1>
                                                <p>FIELDS MARKED * ARE MANDATORY</p>
                                            </div><!--form-row form-info-->

                                            <div>       
                                                <div class="form-row">
                                                    <label for="">Address type *</label>
                                                    <input type="text" name="addresstype" required maxlength="30" pattern="[a-zA-Z0-9]" data-error-parse="Only letters and numbers are allow in this field" data-error-missing="PLEASE FILL OUT ADDRESS TYPE CORRECTLY IN THIS FIELD">
                                                    <div class="field-error"></div>
                                                </div><!--form-row-->
                                            </div>

                                            <div>
                                            </div>

                                            <div class="button-cancel-save">
                                                <button type="button" class="cancel">Cancel</button>
                                                <button type="button" class="send">Add</button>
                                            </div>
                                        </form>
                                    </div><!--form-popup-->
                                </div><!--addnewproduct-->
                            </div><!--search-add-->
                        </div><!--option-->



                        <table class="table-list" id="addresstypes">
                            <thead>
                                <tr>
                                    <th>Address type ID</th>
                                    <th>Address type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="filter-addresstypes">
                                <?php
                                    $result = mysqli_query($conn, "SELECT * FROM address_type");
                                    if(mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '
                                                <tr class="'.$row["id"].'">
                                                    <td id="item-id" item-id='.$row["id"].'>'.$row["id"].'</td>
                                                    <td>'.$row["address_type"].'</td>
                                                    <td><span class="edit-addresstype">Edit</span><span class="delete-table">Delete</span></td>
                                            ';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table><!--table-list-->
                    </div><!--table-div-->



                    <!-- category category category category category category category -->
                    <div class="tables-div">
                        <h2>Category</h2>

                        <div class="option">
                            <div class="filter">
                            </div><!--filter-->

                            <div class="search-add">
                                <div class="search">
                                    <input id="categorys" type="text" name="search" placeholder="Search in table..">
                                    <ion-icon name="search-outline"></ion-icon>
                                </div>
                                <div class="addnew addnewcategory">
                                    <button class="addnew-button" id="addnewcategory-form"><ion-icon name="add-outline"></ion-icon>Add new Category</button>
                                    <div class="form-popup addnewcategory-form">
                                        <form action="" id="addnewcategory" class="add">
                                            <div class="form-row form-info">
                                                <ion-icon name="close-outline"></ion-icon>
                                                <h1>Add new category</h1>
                                                <p>FIELDS MARKED * ARE MANDATORY</p>
                                            </div><!--form-row form-info-->

                                            <div>       
                                                <div class="form-row">
                                                    <label for="">Category *</label>
                                                    <input type="text" name="category" required maxlength="30" pattern="[a-zA-Z0-9]" data-error-parse="Only letters and numbers are allow in this field" data-error-missing="PLEASE FILL OUT CATEGORY CORRECTLY IN THIS FIELD">
                                                    <div class="field-error"></div>
                                                </div><!--form-row-->
                                            </div>

                                            <div>
                                            </div>

                                            <div class="button-cancel-save">
                                                <button type="button" class="cancel">Cancel</button>
                                                <button type="button" class="send">Add</button>
                                            </div>
                                        </form>
                                    </div><!--form-popup-->
                                </div><!--addnewproduct-->
                            </div><!--search-add-->
                        </div><!--option-->



                        <table class="table-list" id="categorys">
                            <thead>
                                <tr>
                                    <th>Category ID</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="filter-categorys">
                                <?php
                                    $result = mysqli_query($conn, "SELECT * FROM category");
                                    if(mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '
                                                <tr class="'.$row["id"].'">
                                                    <td id="item-id" item-id='.$row["id"].'>'.$row["id"].'</td>
                                                    <td>'.$row["category"].'</td>
                                                    <td><span class="edit-category">Edit</span><span class="delete-table">Delete</span></td>
                                                </tr>
                                            ';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table><!--table-list-->
                    </div><!--table-div-->



                    <!-- order-status order-status order-status order-status order-status order-status -->
                    <div class="tables-div">
                        <h2>Order status</h2>

                        <div class="option">
                            <div class="filter">
                            </div><!--filter-->



                            <div class="search-add">
                                <div class="search">
                                    <input id="orderstatuss" type="text" name="search" placeholder="Search in table..">
                                    <ion-icon name="search-outline"></ion-icon>
                                </div>
                                <div class="addnew addneworderstatus">
                                    <button class="addnew-button" id="addneworderstatus-form"><ion-icon name="add-outline"></ion-icon>Add new Order status</button>
                                    <div class="form-popup addneworderstatus-form">
                                        <form action="" id="addneworderstatus" class="add">
                                            <div class="form-row form-info">
                                                <ion-icon name="close-outline"></ion-icon>
                                                <h1>Add new order status</h1>
                                                <p>FIELDS MARKED * ARE MANDATORY</p>
                                            </div><!--form-row form-info-->

                                            <div>       
                                                <div class="form-row">
                                                    <label for="">Order status *</label>
                                                    <input type="text" name="orderstatus" required maxlength="15" pattern="[a-zA-Z0-9]" data-error-parse="Only letters and numbers are allow in this field" data-error-missing="PLEASE FILL OUT ORDER STATUS CORRECTLY IN THIS FIELD">
                                                    <div class="field-error"></div>
                                                </div><!--form-row-->
                                            </div>

                                            <div>
                                            </div>

                                            <div class="button-cancel-save">
                                                <button type="button" class="cancel">Cancel</button>
                                                <button type="button" class="send">Add</button>
                                            </div>
                                        </form>
                                    </div><!--form-popup-->
                                </div><!--addnewproduct-->
                            </div><!--search-add-->
                        </div><!--option-->



                        <table class="table-list" id="orderstatuss">
                            <thead>
                                <tr>
                                    <th>Order status ID</th>
                                    <th>Order status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="filter-orderstatuss">
                                <?php
                                    $result = mysqli_query($conn, "SELECT * FROM order_status");
                                    if(mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '
                                                <tr class="'.$row["status_id"].'">
                                                    <td id="item-id" item-id='.$row["status_id"].'>'.$row["status_id"].'</td>
                                                    <td>'.$row["status"].'</td>
                                                    <td><span class="edit-orderstatus">Edit</span><span class="delete-table">Delete</span></td>
                                                </tr>
                                            ';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table><!--table-list-->
                    </div><!--table-div-->



                    <!-- size size size size size size size size size size size size size size size -->
                    <div class="tables-div">
                        <h2>Size</h2>

                        <div class="option">
                            <div class="filter">
                            </div><!--filter-->



                            <div class="search-add">
                                <div class="search">
                                    <input id="sizes" type="text" name="search" placeholder="Search in table..">
                                    <ion-icon name="search-outline"></ion-icon>
                                </div>
                                <div class="addnew addnewsize">
                                    <button class="addnew-button" id="addnewsize-form"><ion-icon name="add-outline"></ion-icon>Add new Size</button>
                                    <div class="form-popup addnewsize-form">
                                        <form action="" id="addnewsize" class="add">
                                            <div class="form-row form-info">
                                                <ion-icon name="close-outline"></ion-icon>
                                                <h1>Add new size</h1>
                                                <p>FIELDS MARKED * ARE MANDATORY</p>
                                            </div><!--form-row form-info-->

                                            <div>       
                                                <div class="form-row">
                                                    <label for="">Size *</label>
                                                    <input type="text" name="size" required maxlength="5" pattern="[a-zA-Z0-9]" data-error-parse="Only letters and numbers are allow in this field" data-error-missing="PLEASE FILL OUT SIZE CORRECTLY IN THIS FIELD">
                                                    <div class="field-error"></div>
                                                </div><!--form-row-->
                                            </div>

                                            <div>
                                            </div>

                                            <div class="button-cancel-save">
                                                <button type="button" class="cancel">Cancel</button>
                                                <button type="button" class="send">Add</button>
                                            </div>
                                        </form>
                                    </div><!--form-popup-->
                                </div><!--addnewproduct-->
                            </div><!--search-add-->
                        </div><!--option-->



                        <table class="table-list" id="sizes">
                            <thead>
                                <tr>
                                    <th>Size ID</th>
                                    <th>Size</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="filter-sizes">
                                <?php
                                    $result = mysqli_query($conn, "SELECT * FROM size");
                                    if(mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '
                                                <tr class="'.$row["id"].'">
                                                    <td id="item-id" item-id='.$row["id"].'>'.$row["id"].'</td>
                                                    <td>'.$row["size"].'</td>
                                                    <td><span class="edit-size">Edit</span><span class="delete-table">Delete</span></td>
                                                </tr>
                                            ';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table><!--table-list-->
                    </div><!--table-div-->

                </div><!--tables-->

            </div><!--admin-main-->



            <footer>
            </footer>

        </div><!--container admin-->
        


        <script type="text/javascript" src="js/admin.js"></script>
       
        <!--Google chart-->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                //dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard dashboard
                
                //chart chart chart chart chart chart chart chart chart chart chart chart chart chart chart
                google.charts.load('current', {'packages':['bar']});
                google.charts.setOnLoadCallback(drawStuff);

                function drawStuff() {
                    var data = google.visualization.arrayToDataTable([
                        ['Page Title', 'Views'],
                        ["About DUONG THAC SI | DUONG THAC SI", 191],
                        ["ADMIN | DUONG THAC SI", 52],
                        ["DUONG THAC SI Official Store | DUONG THAC SI", 6],
                    ]);

                    var options = {
                        width: 600,
                        height: 400,

                        legend: {
                            position: 'none'
                        },

                        chart: {
                            title: '',
                            subtitle: ''
                        },

                        axes: {
                            x: {
                                0: { side: 'bottom', label: ''} // Top x-axis.
                            },

                        },

                        hAxis: {
                            textStyle: {
                                color: 'black',  
                                fontSize: 8,
                                fontName: 'Helvetica_Bold', 
                            },
                        },

                        vAxis: {
                            textStyle: {
                                color: 'black',  
                                fontSize: 14,
                                fontName: 'Helvetica_Regular', 
                            }
                        },

                        bar: {
                            groupWidth: "40%"
                        },

                        colors: ['#000000'],
                    };


                    var chart = new google.charts.Bar(document.getElementById('top_x_div'));

                    // Convert the Classic options to Material options.
                    chart.draw(data, google.charts.Bar.convertOptions(options));
                };
                
                
                //table table table table table table table table table table table table
                $(".admin .dashboard-table .table-list td").hover(function() {
                    var index = parseInt($(this).index()) + 1;
                    $('.admin .dashboard-table .table-list td:nth-child(' + index + ')').css("background", "var(--white2)");
                    $(this).parent().css("background", "var(--white2)");
                    $(this).css("background", "#d9d9d9");
                }, function() {
                    var index = parseInt($(this).index()) + 1;
                    $('.admin .dashboard-table .table-list td:nth-child(' + index + ')').css("background", "none");
                    $(this).parent().css("background", "none");
                })

            })
        </script>
    
    </body>
</html>



<?php
    mysqli_close($conn);
?>