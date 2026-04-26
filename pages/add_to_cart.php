<?php
session_start();

// get data from form
$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];

// create cart if not exists
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

// add item
if(isset($_SESSION['cart'][$id])){
    $_SESSION['cart'][$id]['qty'] += 1;
} else {
    $_SESSION['cart'][$id] = [
        "name" => $name,
        "price" => $price,
        "qty" => 1
    ];
}

// redirect back to shop page
header("Location: shop.php");
exit();
?>