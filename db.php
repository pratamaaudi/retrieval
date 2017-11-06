<?php

$link = mysqli_connect("localhost", "root", "", "retrieval");
if(mysqli_connect_errno()) {
    echo "Connect Error: " . mysqli_connect_error();
    die("Connect Error: " . mysqli_connect_error());   
}
   

$link2 = mysqli_connect("localhost", "root", "", "retrieval2");
if(mysqli_connect_errno()) {
    echo "Connect Error: " . mysqli_connect_error();
    die("Connect Error: " . mysqli_connect_error());   
}

$link3 = mysqli_connect("localhost", "root", "", "retrieval2");
if(mysqli_connect_errno()) {
    echo "Connect Error: " . mysqli_connect_error();
    die("Connect Error: " . mysqli_connect_error());   
}
?>