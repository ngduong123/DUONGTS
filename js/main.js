$(document).ready(function() { 

    //pop-up
    $(".container").on("click", ".notification-close, .notification .cancel", function(){
        $(".pop-up").css("display", "none");
    })

    
    
    /*HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADERHEADER HEADER HEADER*/
    /*HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADERHEADER HEADER HEADER*/
    /*HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADER HEADERHEADER HEADER HEADER*/
    
    //header add background-color on scroll down or click
    $(window).scroll(function() {
        if ($(window).scrollTop()) {
            $("header").css("background", "var(--black)");
        }
        else{
            $("header").css("background", "linear-gradient(to bottom, rgba(0, 0, 0, 0.8), rgba(30, 30, 30, 0))"); 
        } 
    });
    
    $("header").click(function() {
        $("header").css("background", "var(--black)");
    })
    
    

    //open menu
    $(".open-menu").click(function() {
        $(".menu").css("right", "0");
        $(".open-menu").css("display", "none");
        $(".close-menu").css("display", "block");
    });
    
    
    
    //close menu
    $(".close-menu").click(function() {
        $(".menu").css("right", "-100%");
        $(".close-menu").css("display", "none");
        $(".open-menu").css("display", "block");
    });
    
    
    
    //open small menu
    $(".small-menu>a").click(function() {
        $(".small-menu ul").slideToggle(250);
    });
    
    

    //open account panel
    $(".account>p").click(function() {
        $(".account-panel").slideToggle(150);
    });
    
    
    
    //open bag panel
    $(".bag>p").click(function() {
        $(".setting .bag-panel").slideToggle(200);
    });

    
    
    //function click outside and close
    function clickOutsideClose(ele1, ele2) {
        $(document).mouseup(function(e) {
            if (!$(ele1).is(e.target) && $(ele1).has(e.target).length === 0) {
                $(ele2).hide();
            }
        });
    }
    
    
    
    //click outside header and close small-menu, account-panel, bag
    $(document).mouseup(function(e) {
        clickOutsideClose(".small-menu", ".small-menu ul");
        clickOutsideClose(".account", ".account-panel");
        clickOutsideClose(".bag", ".setting .bag-panel");
    });
    
    
    
    /*BAG BAG BAG BAG BAG BAG BAG BAG BAG BAG BAG BAG BAG BAG BAG BAG BAG BAG BAG BAG*/
    
    //function count product in bag and check bag empty
    function bagProductCount() {
        //$(".bag-product-count").text("(" + $(".bag-panel .bag-item").length +")");
        var countProduct = 0;
        $(".setting .bag-panel .bag-item-quantity").each(function() {
            countProduct += parseInt($(this).text());
        }); 
        
        //check bag empty
        if ($(".bag-panel .bag-item").length > 0) {
            $(".bag-list .empty-bag").css("display", "none");
        }
        else{
            $(".bag-list").html("<p class='empty-bag'>Currently empty</p>");
        }
        
        $(".bag-product-count").text("(" + countProduct + ")");
    }
    
    
    
    //function subtotal
    function subtotal() {
        var subtotal = 0;
        $(".setting .bag-panel .bag-item-price").each(function() {
            // replace \D: not a number   \s: white space
            subtotal += parseInt($(this).text().replace(/[^0-9]/g, "")) * parseInt($(this).closest(".infor").find(".bag-item-quantity").text());
        });
        $(".subtotal-value").text(subtotal);
    }
    
    
    
    //function total
    function total() {
        $(".total-value").text(parseInt($(".bag-main .subtotal-value").text()) + parseInt($(".shipping-value").text()));
    }
    

    
    //set html .bag-list when user visit page first time
    $(".bag .bag-list").html(localStorage.getItem("htmlBagList"));
    
    
    
    //count product when user visit page first time
    bagProductCount();
    
    
    
    //calculate subtotal when user visit page first time
    subtotal();
    
    
    
    //calculate total when user visit page first time
    total();
    
    
    
    //function check select size
    var selectSize = true;
    function checkSelectSize() {
        if (!selectSize) {
            $(".product-size .error").text("Please select a size.")
            $(".product-size .error").css("display", "block");
            $(".productdetail-main .product-size select").addClass("select-error");
        }
        else{
            $(".product-size .error").css("display", "none");
            $(".productdetail-main .product-size select").removeClass("select-error");
        }
    }
    

    
    //check when value of select has been change
    $(".product-size select[name=size]").change(function() {
        if ($(this).val().toLowerCase() != "select size") {
        selectSize = true;
        }
        else {
            selectSize = false;
        }
        checkSelectSize();
    });


    
    //add to bag
    $(".add-product").click(function() {
        var img = $(".big-image img:nth(0)").attr("src");
        var name = $(".product-infor .name").text(); 
        var price = $(".product-infor .price").text();
        var size = $(".product-infor select[name=size]").val();
        var htmlBagList = $(".bag-panel .bag-list").html();

        //check if user hasn't chosen size yet
        //$.isNumeric check if value is numeric
        if (size.toLowerCase() == "select size") {
            selectSize = false;
            //display error when click add if user hasn't chosen size yet
            checkSelectSize();
        }
        else{
            //get in_stock value
            in_stock = localStorage.getItem("in_stock");

            //if in bag > in_stock => display error
            if (parseInt($(".bag-item:contains(" + name + ")").filter($(".bag-item:contains(" + $(".product-infor select[name=size]").val() + ")")).find(".bag-item-quantity").text()) > in_stock - 1) {
                $(".product-size .error").text("Currently not available.");
                $(".product-size .error").css("display", "block");
                $(".productdetail-main .product-size select").addClass("select-error");
            }
            else{
                $(".product-size .error").css("display", "none");
                $(".productdetail-main .product-size select").removeClass("select-error");
            
                //add link to .bag-item
                //alert('http://foo.com/bar/image/abc&jpg'.split('/').pop().split('&').shift()); //get text from last / to &
                var product_id = window.location.href.substring(window.location.href.lastIndexOf("-") + 1); //get product_id in url
                var product_link = name.replace(/\s/g, "-"); //change space to - in name

                //check if this product is already in cart
                //name is not already in cart or same name but different size => add product and open bag-panel
                if (htmlBagList.indexOf(name) == -1 || (htmlBagList.indexOf(name) != -1 && $(".bag-item:contains(" + name + ")").filter($(".bag-item:contains(" + size + ")")).find(".bag-item-size").text() != size)) {
                    $(".bag-list").prepend(
                    `   <a href="php/productdetail.php?productname=${product_link}-${product_id}" class="bag-item">
                            <img src="${img}" alt="">
                            <div class="infor">
                                <p class="bag-item-name">${name}</p>
                                <p class="bag-item-price">Price: ${price}</p>
                                <div class="select-size-quantity">
                                    <p>Size:</p>
                                    <p class="bag-item-size">${size}</p>
                                </div><!--select-size-quantity-->
                                <div class="select-size-quantity">
                                    <p>Quantity:</p>
                                    <p class="bag-item-quantity">1</p>
                                    <select name="bag-item-quantity">
                                    </select>
                                </div><!--select-size-quantity-->
                            </div><!--infor-->
                            <p class="delete-item"><span>&#10005;</span><span>Remove</span></p>
                        </a><!--bag-item--> `
                    );
                }
                //already in cart, same name and same size => quantity + 1
                else {   
                    $(".bag-item:contains(" + name + ")").filter($(".bag-item:contains(" + size + ")")).find(".bag-item-quantity").text(parseInt($(".bag-item:contains(" + name + ")").filter($(".bag-item:contains(" + size + ")")).find(".bag-item-quantity").text()) + 1);
                }
                
                //scroll to top and open bag panel
                $(".bag-list").animate({scrollTop : 0});
                $(".bag-panel").slideDown(400).delay(1500).slideUp(200);
                
                //count product after add
                bagProductCount();
                
                //calculate subtotal when user visit page first time
                subtotal();
                
                //calculate total when user visit page first time
                total();
                
                //save html after add
                localStorage.setItem("htmlBagList", $(".bag-list").html());
            }
        }
    });
    
    
    
    //delete item in bag
    $(".bag-list").on("click", ".delete-item", function(event) {
        //prevent redirect
        event.preventDefault();
        //remove .bag-item contain its text
        $(".bag-item").remove(":contains(" + $(this).closest('.bag-item').text() + ")");
        
        //count product after delete
        bagProductCount();
        
        //calculate subtotal when user visit page first time
        subtotal();
        
        //calculate total when user visit page first time
        total();
        
        //save html after delete
        localStorage.setItem("htmlBagList", $(".bag-list").html());
    });
    
    
    

    
    
    /*MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN*/
    /*MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN*/
    /*MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN MAIN*/
    
    /*productdetail productdetail productdetail productdetail productdetail productdetail productdetail productdetail productdetail productdetail productdetail productdetail*/
    /*click and open image*/
    function imagePopup(img) {
        $(img).click(function() {
            $(".open-image-box").css("display", "block");
            $(".open-image-box img").attr("src", $(this).attr("src"));
        });
    }
    
    
    
    /*open image in productdetail*/
    imagePopup(".productdetail-main .big-image img");
    imagePopup(".productdetail-main .product-size img");
    
    
    
    /*close image-box*/
    $(".close-image-box").click(function() {
        $(".open-image-box").css("display", "none");
    });
    
    
    
    /*size guide*/
    $(".size-guide").click(function() {
        $(".size-guide-image").slideToggle();
    });
    
    
    
    
    
    //bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag bag
    //select quantity form p.bag-item-quantity
    $(".bag-main .select-size-quantity select[name=bag-item-quantity]").each(function() {
            $(this).val($(this).closest(".bag-item").find(".bag-item-quantity").text());
    }); 
    
    
    
    //prevent redirect
    $(".select-size-quantity select[name=bag-item-quantity]").click(function(event) {
        event.preventDefault();
    });
    
    
    
    //change quantity in bag page will change in bag
    $(".bag-main .select-size-quantity select[name=bag-item-quantity]").change(function() {
        $(".bag-item:contains("+ $(this).closest(".bag-item").text() +")").find($(".bag-item-quantity")).text($(this).val());
        
        //count product after delete
        bagProductCount();
        
        //calculate subtotal when user visit page first time
        subtotal();
        
        //calculate total when user visit page first time
        total();
        
        //save html after delete
        localStorage.setItem("htmlBagList", $(".bag-list").html());
    });
    
    
    
    
    
    //contact us contact us contact us contact us contact us contact us contact us contact us contact us contact us contact us contact us contact us contact us 
    
    function checkField(e, condition) {
        if(e.val().length === 0) {
            e.next(".field-error").text(e.attr("data-error-missing")).show();
        }
        else{
            e.next(".field-error").hide();
            if(condition.test(e.val())) {           
                e.next(".field-error").hide();
            }
            else{
                e.next(".field-error").text(e.attr("data-error-parse")).show();
            }
        }  
    }
    

    
    //data-error-parse
    var topic = /[^select\sa\stopic]/i;
    
    var firstname = lastname = /^[\sa-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]+$/;
    
    var email = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
    
    var message = /(.*)/;
    
    var password = newpassword = /^[a-zA-Z0-9]+$/;

    var phonenumber = /^[0-9]+$/;

    var address = /^[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ0-9\s\-\,\.\/]+$/;

    var address_type = /(.*)/;

    var product_category = /[^select\scategory]/i;

    var product_id = /^[a-zA-Z0-9]+$/;

    var product_price = product_instock = order_id = /^[0-9]+$/;

    var product_name = /[a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ0-9\s\-]+$/;

    var product_description = product_detailslist = /(.*)/;


        
    //live check validation
    $(".container").on("blur keyup change", "form input:not([name=confirmnewpassword], [type=date], [type=checkbox], [type=radio], [type=file], [name=addresstype], [name=category], [name=orderstatus], [name=size]), textarea, form:not('.add') select", function() {
        checkField($(this), eval($(this).attr("name")));
    });

    
    
    //check validation on submit
    $("form").submit(function(e) {
        
        //display error
        
        $("form").find(".field-error").prev().each(function() {
            checkField($(this), eval($(this).attr("name")));
        });
             

        //if there is any error, stop submit
        if($(this).find(".field-error").is(":visible")) {
            e.preventDefault();
        }    

    });





    //checkout checkout checkout checkout checkout checkout checkout checkout checkout checkout checkout checkout checkout checkout checkout checkout checkout checkout

    //display html of .checkout-main.bag-main .bag-list
    $(".checkout-main .bag-panel .bag-list").html(localStorage.getItem("htmlBagList"));

    //remove attr href
    $(".checkout-main a.bag-item").removeAttr("href");

    

    //(name) add input into p
    $(".checkout-main .bag-item").each(function() {
        $(this).find(".bag-item-name").html("<input name='name[]' value='" + $(this).find(".bag-item-name").text() + "' readonly>");
    });

    //(price)
    $(".checkout-main .bag-item").each(function() {
        //get text from last " " => Example: Price: $480 => 480
        var price = $(this).find(".bag-item-price").text().substring($(this).find(".bag-item-price").text().lastIndexOf(" ") + 1);
        $(this).find(".bag-item-price").text("");
        $(this).find(".bag-item-price").html("Price: $ <input name='price[]' value='" + price + "' readonly>");
    });

    //(size)
    $(".checkout-main .bag-item").each(function() {
        $(this).find(".bag-item-size").html("<input name=size[] value='" + $(this).find(".bag-item-size").text() + "' readonly>");
    });

    //(quantity)
    $(".checkout-main .bag-item").each(function() {
        $(this).find(".bag-item-quantity").html("<input name=quantity[] value='" + $(this).find(".bag-item-quantity").text() + "' readonly>");
    });

    //subtotal
    $(".checkout-main .subtotal-value").html("<input name='subtotal' value='$ " + $(".checkout-main .subtotal-value").text() + "' readonly>");

    //shipping
    $(".checkout-main .shipping-value").html("<input name='shipping' value='$ " + $(".checkout-main .shipping-value").text() + "' readonly>");

    //total
    $(".checkout-main .total-value").html("<input name='total' value='$ " + $(".checkout-main .total-value").text() + "' readonly>");
    




    //register-form register-form register-form register-form register-form register-form register-form register-form register-form register-form register-form register-form
    $(".container").on("blur keyup change", ".reset-password-main input[name=confirmnewpassword], .reset-password-main input[name=password]", function() {
        var password = $("input[name=password]");
        var newpassword = $("input[name=confirmnewpassword]");

        //if newpassword null
        if(newpassword.val().length === 0) {
            newpassword.next(".field-error").text(newpassword.attr("data-error-missing")).show();
        }
        else{
            //if newpassword and password don't match
            newpassword.next(".field-error").hide();
            if(newpassword.val() === password.val()) {           
                newpassword.next(".field-error").hide();
            }
            else{
                newpassword.next(".field-error").text(newpassword.attr("data-error-parse")).show();
            }
        }  
    });





    //mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23 mss23
    //slider scroll click
    $(".next").click(function() {
        var width = $(".slider").width() / 5 * 2;
        if (window.matchMedia('(max-width: 1024px)').matches) {
            var width = $(".slider").width() / 2;
        }
        
        $(this).closest(".button-slider").prev().animate( { scrollLeft: '+='+width }, 800);
    });

    $(".prev").click(function() {
        var width = $(".slider").width() / 5 * 2;
        if (window.matchMedia('(max-width: 1024px)').matches) {
            var width = $(".slider").width() / 2;
        }
        
        $(this).closest(".button-slider").prev().animate( { scrollLeft: '-='+width }, 800);
    });





    //admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin admin adminadmin admin admin admin admin admin admin admin adminadmin admin admin admin admin admin   
    $(".admin-account").click(function() {
        //open account panel
        $(".account-panel").slideToggle(150);
    })

})



















