<?php
    require_once __DIR__."/config.php";

    //connect
    $sqlservername = SQLSERVERNAME;
    $sqlusername = SQLUSERNAME;
    $sqlpassword = SQLPASSWORD;
    $sqldatabase = SQLDATABASE;

    //creat connection
    //$conn = mysqli_connect($sqlservername, $sqlusername, $sqlpassword, $sqldatabase);

    $conn = mysqli_connect("127.0.0.1:3307", "root", "", "duong456.epizy.com");

    //check connection
    if(!$conn) {
        die("Connection failed: " .mysqli_connect_error());
    }
?>