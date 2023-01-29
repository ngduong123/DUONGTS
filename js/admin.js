$(document).ready(function() { 
    function addAndDisplay(a) {
        var data = $(".addnew"+a+" .add").serialize() + "&type=addnew"+a;

        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: data,
            success: function (response) {
                $.ajax({
                    async : false, //this line make code can use var outside ajax
                    url: "php/submit/admin-change-ajax.php",
                    type: "post",
                    data: {type: "display"+a+"s"},
                    success: function (response) {
                        //update html
                        $("#"+a+"s tbody.filter-"+a+"s").html(response)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });

                //close form
                $(".form-popup").css("display", "none");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function displayTable(a) {
        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: {type: "display"+a+"s"},
            success: function (response) {
                //update html
                $("#"+a+"s tbody.filter-"+a).html(response)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function displayTableWithoutS(a) {
        $.ajax({
                async : false, //this line make code can use var outside ajax
                url: "php/submit/admin-change-ajax.php",
                type: "post",
                data: {type: "display"+a+"s"},
                success: function (response) {
                    //update html
                    $("#"+a+"s tbody.filter-"+a+"s").html(response)
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
    }



    $(".tab-link").click(function() {
        //display none all .tab-content
        $(".tab-content").each(function() {
            $(".tab-content").css("display", "none");
        })

        //remove .active-menu from all .tab-link
        $(".tab-link").each(function() {
            $(".tab-link").removeClass("active-menu");
        })

        //add .active-menu to .tab-link is clicked
        $(this).addClass("active-menu");

        //display content in tab-content
        var tab_content = $(this).text().toLocaleLowerCase();
        $("#"+tab_content).css("display", "block");

        //change menu title
        $(".menu-title").text(tab_content);
    })



    //search
    //id input = id table
    $(".tab-content input[name=search]").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        var type = $(this).attr("id");

        $(".tab-content table#"+type+" tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    //filter
    $("select[name=filter-category]").change(function(){
        var type = $(this).attr("class");
        var filtercategory = $(this).val();

        if(filtercategory == "all") {
            $("."+type+" tr").css("display", "table-row");
        }
        else {
            $("."+type+" tr").css("display", "none");
            $("."+type+" tr").filter("."+filtercategory).css("display", "table-row");
        }
    })



    //display add-form
    $(".addnew-button").click(function(){
        var form = $(this).attr("id");
        $("."+form).css("display", "block");
    })

    $(".add ion-icon, .button-cancel-save .cancel").click(function(){
        $(".form-popup").css("display", "none");
        $(this).closest("form")[0].reset();
        $(this).closest("form").find(".field-error").css("display", "none");
    })

    //edit - display form
    $(".container").on("click", ".edit-product, .edit-order, .edit-user", function() {
        $(this).closest(".tab-content").find(".form-popup").css("display", "block");
    })

    $(".container").on("click", ".edit-addresstype, .edit-category, .edit-orderstatus, .edit-size", function() {
        $(this).closest(".tables-div").find(".form-popup").css("display", "block");
    })





    //products products products products products products products products products products products products products products products products products
    //add new product
    $(".addnewproduct .add").on("click", ".send", function(e) {
        e.preventDefault();
        var data = $(".addnewproduct .add").serialize() + "&type=addnewproduct";
        var formData = new FormData(document.getElementById("addnewproduct"));
        formData.append('type', "addnewproduct");
        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            //data: data,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $.ajax({
                    async : false, //this line make code can use var outside ajax
                    url: "php/submit/admin-change-ajax.php",
                    type: "post",
                    data: {type: "displayproducts"},
                    success: function (response) {
                        //update html
                        $("#products tbody.filter-products").html(response)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });

                //close form
                $(".form-popup").css("display", "none");
                //alert(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    })

    //delete product
    $(".container").on("click", ".delete-product", function() {
        var id = $(this).closest("tr").find("#item-id").attr("item-id");
        var size = $(this).closest("tr").find("#item-id").attr("size");

        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: {type: "deleteproduct", id: id, size: size},
            success: function (response) {
                $.ajax({
                    async : false, //this line make code can use var outside ajax
                    url: "php/submit/admin-change-ajax.php",
                    type: "post",
                    data: {type: "displayproducts"},
                    success: function (response) {
                        //update html
                        $("#products tbody.filter-products").html(response)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    })

    var id = "";
    //edit product
    $(".container").on("click", ".edit-product", function() {
        id = $(this).closest("tr").find("#item-id").attr("item-id");
        var size = $(this).closest("tr").find("#item-id").attr("size");
        var info;

        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: {type: "editproduct", id: id, size: size},
            success: function (response) {
                info = JSON.parse(response);

                $.ajax({
                    async : false, //this line make code can use var outside ajax
                    url: "php/submit/admin-change-ajax.php",
                    type: "post",
                    data: {type: "displayproducts"},
                    success: function (response) {
                        //update html
                        $("#products tbody.filter-products").html(response)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                })
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        })

        //value in field
        $("form#addnewproduct select[name=product_category]").val(info.category);
        $("form#addnewproduct input[name=product_name]").val(info.name).attr("readonly", "readonly");
        $("form#addnewproduct input[name=product_price]").val(info.price);
        $("form#addnewproduct select[name=product_size]").val(info.size).attr("style", "pointer-events: none;"); 
        $("form#addnewproduct input[name=product_instock]").val(info.in_stock);
        $("form#addnewproduct textarea[name=product_description]").val(info.description);
        $("form#addnewproduct textarea[name=product_detailslist]").val(info.detailslist);
        $("form#addnewproduct input[type=file]").css("display", "none");
        $("form#addnewproduct button.send").attr("class", "save").text("save");

        $("form#addnewproduct.add ion-icon, form#addnewproduct .button-cancel-save .cancel").click(function(){
            $("form#addnewproduct input[name=product_name]").attr("readonly", false);
            $("form#addnewproduct select[name=product_size]").attr("style", "pointer-events: auto;"); 
            $("form#addnewproduct input[type=file]").css("display", "block");
            $("form#addnewproduct button.save").attr("class", "send").text("add");
        })
    })

    //product - update
    $(".container").on("click", "#addnewproduct .button-cancel-save .save", function() {
        var formData = new FormData(document.getElementById("addnewproduct"));

        formData.append('type', "updateproduct");
        formData.append('id', id);
        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $.ajax({
                    async : false, //this line make code can use var outside ajax
                    url: "php/submit/admin-change-ajax.php",
                    type: "post",
                    data: {type: "displayproducts"},
                    success: function (response) {
                        //update html
                        $("#products tbody.filter-products").html(response)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

        $('form#addnewproduct')[0].reset();
        $("form#addnewproduct input[name=product_name]").attr("readonly", false);
        $("form#addnewproduct select[name=product_size]").attr("style", "pointer-events: auto;"); 
        $("form#addnewproduct input[type=file]").css("display", "block");
        $("form#addnewproduct button.save").attr("class", "send").text("add");

        //close form
        $(".form-popup").css("display", "none");
    })



    //orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders orders
    //ajax add new order
    //change user's email and display address_book
    $(".addneworder-form select[name=order_useremail]").change(function() {
        $(".addneworder-form div:nth-child(2) input:not([name=order_id])").val("");
        if($(this).val() == "none") {
            $(".addneworder-form input:not('.addorder-total input, .item-list input')").css("border-bottom", "1px solid #000").attr("readonly", false);
        }
        else {
            $(".addneworder-form input").css("border-bottom", "0").attr("readonly", "readonly");
        }

        var type = $(this).attr("name");
        var email = $(this).val();
        var address_book;

        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: {type: type, email: email},
            success: function (response) {
                //get when ajax success
                //info = JSON.parse(response); //JSON.parse() convert text into object
                address_book = response;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

        //change user's address book
        $("select[name=address_type]").html(address_book);

        //change user's info
        $(".addneworder-form select[name='address_type']").change(function() {
            var address_type = $(this).val();
            var email = $(".addneworder-form select[name=order_useremail]").val();
            var info;

            $.ajax({
                async : false, //this line make code can use var outside ajax
                url: "php/submit/change-address-type.php",
                type: "post",
                data: {address_type: address_type, email: email},
                success: function (response) {
                    //get when ajax success
                    info = JSON.parse(response); //JSON.parse() convert text into object

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });

            $(".addneworder-form input[name=firstname]").val(info.firstname);
            $(".addneworder-form input[name=lastname]").val(info.lastname);
            $(".addneworder-form input[name=email]").val(email);
            $(".addneworder-form input[name=phonenumber]").val(info.phonenumber);
            $(".addneworder-form input[name=address]").val(info.address);
        });

    })



    //add item
    $(".addneworder-form select[name=order_item]").change(function() {
        var item_list = JSON.parse($(this).val());

        var quantity = "";
        for(let i = 1; i <= parseInt(item_list.in_stock); i++){
            quantity += '<option value="' + i + '">' + i + '</option>';
        }

        //set html for select, option = in_stock
        $(".addneworder-form").find("select[name='quantity[]']").html(quantity);
    });

    function admin_subtotal() {
        var subtotal = 0;
        $(".item-list div input[name='price[]']").each(function() {
            subtotal += parseInt($(this).val() * $(this).closest("div").find("input[name='quantity[]']").val());
        });
        $("input[name=subtotal]").val(subtotal);
    }

    function admin_total() {
        $("input[name=total]").val(parseInt($("input[name=subtotal]").val()) + parseInt($("input[name=shipping]").val()));
    }

    //add item in item-list
    $(".addneworder-form button.add-item-button").click(function(){
        var item_list = JSON.parse($(".addneworder-form select[name=order_item]").val());
        var quantity = $("select[name='quantity[]']").val();

        if(quantity != null) {
            var name = item_list.product_name;
            var price = item_list.product_price;
            var size = item_list.size;

            $(".addneworder-form .item-list").append(`<div><input type="text" name="name[]" value="${name}" readonly required><input type="text" name="price[]" value="${price}" readonly required><input type="text" name="size[]" value="${size}" readonly required><input type="number" name="quantity[]" value="${quantity}" readonly required><p class="delete-item"><span>&#10005;</span><span>Remove</span></p></div>`);
            admin_subtotal();
            admin_total();
        }
    })

    //delete item in item-list
    $(".container .item-list").on("click", ".delete-item", function(){
        //remove .bag-item contain its text
        $(this).closest("div").remove(":contains(" + $(this).closest('div').text() + ")");

        admin_subtotal();
        admin_total();
    })

    $(".addneworder-form button.clear-item-button").click(function(){
        $(".addneworder-form .item-list").html("");
        admin_subtotal();
        admin_total();
    });





    //add new order
    $(".container").on("click", "form#addneworder button.send", function(e) {
        e.preventDefault();
        var data = $(".addneworder .add").serialize();

        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/place-order.php",
            type: "post",
            data: data,
            success: function (response) {
                displayTable("order");

                //close form
                $(".form-popup").css("display", "none");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    })

    //delete order
    $(".container").on("click", ".delete-order", function(){
        var id = $(this).closest("tr").find("#item-id").attr("item-id");
        var customer_id = $(this).closest("tr").find("#item-id").attr("customer_id");
        var order_item_id = $(this).closest("tr").find("#item-id").attr("order_item_id");

        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: {type: "deleteorder", id: id, customer_id: customer_id, order_item_id: order_item_id},
            success: function (response) {
                displayTable("order");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    })

    var id = "";
    //edit order
    $(".container").on("click", ".edit-order", function() {
        id = $(this).closest("tr").find("#item-id").attr("item-id");

        var info;

        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: {type: "editorder", id: id},
            success: function (response) {
                info = JSON.parse(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

        for(var i = 0; i < info[1].length; i++){
            $(".addneworder-form .item-list").append(`
                <div>
                    <input type="text" name="name[]" value="${info[1][i].product_name}" readonly="" required="">
                    <input type="text" name="price[]" value="${info[1][i].product_price}" readonly="" required="">
                    <input type="text" name="size[]" value="${info[1][i].size}" readonly="" required="">
                    <input type="number" name="quantity[]" value="${info[1][i].quantity}" readonly="" required="">
                    <p class="delete-item"><span>&#10005;</span><span>Remove</span></p>
                </div>
            `);
        }

        //value in field
        $("form#addneworder input[name=subtotal]").val(info[0].subtotal);
        $("form#addneworder input[name=shipping]").val(info[0].shipping);
        $("form#addneworder input[name=total]").val(info[0].total);

        $("form#addneworder select[name=order_useremail]").val(info[0].user_email).attr("style", "pointer-events: none;");
        $("form#addneworder select[name=order_status]").val(info[0].status); 
        $("form#addneworder input[name=firstname]").val(info[0].first_name);
        $("form#addneworder input[name=lastname]").val(info[0].last_name);
        $("form#addneworder input[name=email]").val(info[0].email);
        $("form#addneworder input[name=phonenumber]").val(info[0].phone_number);
        $("form#addneworder input[name=address]").val(info[0].address);
        $("form#addneworder textarea[name=message]").val(info[0].message);

        $("form#addneworder div .form-row:nth-child(3) select, form#addneworder div .form-row:nth-child(3) button").css("display", "none");
        $("form#addneworder .item-list .delete-item").css("display", "none");
        $("form#addneworder .sendemail").css("display", "inline-block");
        $("form#addneworder button.send").attr("class", "save").text("save");

        $("form#addneworder.add ion-icon, form#addneworder .button-cancel-save .cancel").click(function(){
            $("form#addneworder select[name=order_useremail]").attr("style", "pointer-events: auto;");
            $("form#addneworder .item-list").html("");

            $("form#addneworder div .form-row:nth-child(3) select, form#addneworder div .form-row:nth-child(3) button").css("display", "inline-block");
            $("form#addneworder .item-list .delete-item").css("display", "block");
            $("form#addneworder .sendemail").css("display", "none");
            $("form#addneworder button.save").attr("class", "send").text("add");
        })    
    })

    //update - order
    $(".container").on("click", "#addneworder .button-cancel-save .save", function() {
        var formData = new FormData(document.getElementById("addneworder"));

        formData.append('type', "updateorder");
        formData.append('id', id);
        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                displayTable("order");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

        $('form#addneworder')[0].reset();
        $("form#addneworder select[name=order_useremail]").attr("style", "pointer-events: auto;");
        $("form#addneworder .item-list").html("");
        $("form#addneworder .sendemail").css("display", "none");
        $("form#addneworder button.send").attr("class", "send").text("add");

        //close form
        $(".form-popup").css("display", "none");
    })





    //users users users users users users users users users users users users users users users users users users users users users users users users users users users users users users users users
    //add new user
    $(".addnewuser .add").on("click", ".send", function() {
        var data = $(".addnewuser .add").serialize();

        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/register.php",
            type: "post",
            data: data,
            success: function (response) {
                displayTable("user");

                //close form
                $(".form-popup").css("display", "none");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    })

    //delete user
    $(".container").on("click", ".delete-user", function(){
        var id = $(this).closest("tr").find("#item-id").attr("item-id");

        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: {type: "deleteuser", id: id},
            success: function (response) {
                displayTable("user");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    })

    var id = "";
    //edit user
    $(".container").on("click", ".edit-user", function() {
        id = $(this).closest("tr").find("#item-id").attr("item-id");
        var info;

        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: {type: "edituser", id: id},
            success: function (response) {
                info = JSON.parse(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        })

        //value in field
        $("form#addnewuser input[name=email]").val(info.email).attr("readonly", "readonly");
        $("form#addnewuser input[name=password]").val(info.password);
        $("form#addnewuser select[name=role]").val(info.role);
        $("form#addnewuser input[name=firstname]").val(info.first_name);
        $("form#addnewuser input[name=lastname]").val(info.last_name);
        $("form#addnewuser input[name=birthdate]").val(info.birthdate);
        $("form#addnewuser button.send").attr("class", "save").text("save");

        $("form#addnewuser.add ion-icon, form#addnewuser .button-cancel-save .cancel").click(function(){
            $("form#addnewuser input[name=email]").attr("readonly", false);
            $("form#addnewuser button.save").attr("class", "send").text("add");
        })
    })


    //user - update
    $(".container").on("click", "#addnewuser .button-cancel-save .save", function() {
        var formData = new FormData(document.getElementById("addnewuser"));

        formData.append('type', "updateuser");
        formData.append('id', id);
        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                displayTable("user");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

        $('form#addnewuser')[0].reset();
        $("form#addnewuser input[name=email]").attr("readonly", false);
        $("form#addnewuser button.save").attr("class", "send").text("add");

        //close form
        $(".form-popup").css("display", "none");
    })





    //tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables tables
    //add new addresstype
    $(".addnewaddresstype .add").on("click", ".send", function(e) {
        e.preventDefault();
        addAndDisplay("addresstype");
    })

    //edit addresstype
    $(".container").on("click", ".edit-addresstype", function() {
        id = $(this).closest("tr").find("#item-id").attr("item-id");
        var info;

        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: {type: "editaddresstype", id: id},
            success: function (response) {
                info = JSON.parse(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        })

        //value in field
        $("form#addnewaddresstype input[name=addresstype]").val(info.addresstype);
        $("form#addnewaddresstype button.send").attr("class", "save").text("save");

        $("form#addnewaddresstype.add ion-icon, form#addnewaddresstype .button-cancel-save .cancel").click(function(){
            $("form#addnewaddresstype button.save").attr("class", "send").text("add");
        })
    })

    //update addresstype
    $(".container").on("click", "#addnewaddresstype .button-cancel-save .save", function() {
        var formData = new FormData(document.getElementById("addnewaddresstype"));

        formData.append('type', "updateaddresstype");
        formData.append('id', id);
        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                displayTableWithoutS("addresstype");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

        $('form#addnewaddresstype')[0].reset();
        $("form#addnewaddresstype button.save").attr("class", "send").text("add");

        //close form
        $(".form-popup").css("display", "none");
    })



    //add new category
    $(".addnewcategory .add").on("click", ".send", function(e) {
        e.preventDefault();
        addAndDisplay("category");
    })

    //edit category
    $(".container").on("click", ".edit-category", function() {
        id = $(this).closest("tr").find("#item-id").attr("item-id");
        var info;

        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: {type: "editcategory", id: id},
            success: function (response) {
                info = JSON.parse(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        })

        //value in field
        $("form#addnewcategory input[name=category]").val(info.category);
        $("form#addnewcategory button.send").attr("class", "save").text("save");

        $("form#addnewcategory.add ion-icon, form#addnewcategory .button-cancel-save .cancel").click(function(){
            $("form#addnewcategory button.save").attr("class", "send").text("add");
        })
    })

    //update category
    $(".container").on("click", "#addnewcategory .button-cancel-save .save", function() {
        var formData = new FormData(document.getElementById("addnewcategory"));

        formData.append('type', "updatecategory");
        formData.append('id', id);
        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                displayTableWithoutS("category");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

        $('form#addnewcategory')[0].reset();
        $("form#addnewcategory button.save").attr("class", "send").text("add");

        //close form
        $(".form-popup").css("display", "none");
    })



    //add new orderstatus
    $(".addneworderstatus .add").on("click", ".send", function(e) {
        e.preventDefault();
        addAndDisplay("orderstatus");
    })

    //edit orderstatus
    $(".container").on("click", ".edit-orderstatus", function() {
        id = $(this).closest("tr").find("#item-id").attr("item-id");
        var info;

        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: {type: "editorderstatus", id: id},
            success: function (response) {
                info = JSON.parse(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        })

        //value in field
        $("form#addneworderstatus input[name=orderstatus]").val(info.status);
        $("form#addneworderstatus button.send").attr("class", "save").text("save");

        $("form#addneworderstatus.add ion-icon, form#addneworderstatus .button-cancel-save .cancel").click(function(){
            $("form#addneworderstatus button.save").attr("class", "send").text("add");
        })
    })

    //update orderstatus
    $(".container").on("click", "#addneworderstatus .button-cancel-save .save", function() {
        var formData = new FormData(document.getElementById("addneworderstatus"));

        formData.append('type', "updateorderstatus");
        formData.append('id', id);
        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                displayTableWithoutS("orderstatus");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

        $('form#addneworderstatus')[0].reset();
        $("form#addneworderstatus button.save").attr("class", "send").text("add");

        //close form
        $(".form-popup").css("display", "none");
    })



    //add new size
    $(".addnewsize .add").on("click", ".send", function(e) {
        e.preventDefault();
        addAndDisplay("size");
    })

    //edit size
    $(".container").on("click", ".edit-size", function() {
        id = $(this).closest("tr").find("#item-id").attr("item-id");
        var info;

        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: {type: "editsize", id: id},
            success: function (response) {
                info = JSON.parse(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        })

        //value in field
        $("form#addnewsize input[name=size]").val(info.size);
        $("form#addnewsize button.send").attr("class", "save").text("save");

        $("form#addnewsize.add ion-icon, form#addnewsize .button-cancel-save .cancel").click(function(){
            $("form#addnewsize button.save").attr("class", "send").text("add");
        })
    })

    //update size
    $(".container").on("click", "#addnewsize .button-cancel-save .save", function() {
        var formData = new FormData(document.getElementById("addnewsize"));

        formData.append('type', "updatesize");
        formData.append('id', id);
        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                displayTableWithoutS("size");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

        $('form#addnewsize')[0].reset();
        $("form#addnewsize button.save").attr("class", "send").text("add");

        //close form
        $(".form-popup").css("display", "none");
    })



    //delete table
    $(".container").on("click", ".delete-table", function(){
        var id = $(this).closest("tr").find("#item-id").attr("item-id");
        var table = $(this).closest("table").attr("id");

        $.ajax({
            async : false, //this line make code can use var outside ajax
            url: "php/submit/admin-change-ajax.php",
            type: "post",
            data: {type: "deletetable", id: id, table: table},
            success: function (response) {
                console.log(response);
                displayTableWithoutS("addresstype");
                displayTableWithoutS("category");
                displayTableWithoutS("orderstatus");
                displayTableWithoutS("size");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    })
})