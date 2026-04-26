<?php
$conn = mysqli_connect("localhost","root","","nursery");

if(!$conn){
    die("Database connection failed");
}

session_start();
?>