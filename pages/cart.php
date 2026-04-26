<?php
session_start();
include '../config/db.php';

/* ADD TO CART LOGIC (UNCHANGED) */
if(isset($_POST['product_id'])){

    $id = $_POST['product_id'];
    $qty = $_POST['qty'];

    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }

    if(isset($_SESSION['cart'][$id])){
        $_SESSION['cart'][$id] += $qty;
    } else {
        $_SESSION['cart'][$id] = $qty;
    }

    // ✅ AJAX RESPONSE ONLY NUMBER
    echo array_sum($_SESSION['cart']);
    exit;
}

/* HEADER LOAD ONLY NORMAL PAGE */
include '../includes/header.php';

$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
<title>Cart</title>

<style>
body {
    font-family: 'Segoe UI', Arial;
    background: #f5fff7;
    margin: 0;
}

/* BACK BUTTON */
.back-btn {
    padding:15px 30px;
}
.back-btn a {
    background:#2e7d32;
    color:white;
    padding:8px 15px;
    text-decoration:none;
    border-radius:6px;
}

/* TITLE */
h2 {
    text-align:center;
}

/* CART CONTAINER */
.cart-container {
    width: 80%;
    margin: 20px auto;
}

/* CARD */
.cart-item {
    display: flex;
    align-items: center;
    background: #fff;
    margin-bottom: 15px;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* IMAGE */
.cart-item img {
    width: 100px;
    height: 100px;
    border-radius: 10px;
    margin-right: 20px;
}

/* DETAILS */
.details {
    flex: 1;
}

.price {
    color: #2e7d32;
    font-weight: bold;
}

/* QTY BUTTONS */
.qty-box {
    display:flex;
    align-items:center;
    gap:10px;
}

.qty-box button {
    width:30px;
    height:30px;
    border:none;
    background:#2e7d32;
    color:white;
    font-size:18px;
    border-radius:5px;
    cursor:pointer;
}

/* REMOVE */
.remove-btn {
    background:red;
    color:white;
    border:none;
    padding:8px 12px;
    border-radius:6px;
    cursor:pointer;
}

/* TOTAL */
.total {
    text-align:right;
    font-size:20px;
    margin-top:20px;
    font-weight:bold;
}

/* CHECKOUT */
.checkout-full {
    margin-top:20px;
}
.checkout-full a {
    display:block;
    width:100%;
    text-align:center;
    background:#2e7d32;
    color:white;
    padding:15px;
    text-decoration:none;
    border-radius:8px;
    font-size:18px;
    font-weight:bold;
}
</style>

</head>
<body>

<!-- BACK BUTTON -->
<div class="back-btn">
    <a href="shop.php">⬅ Back to Shop</a>
</div>

<h2>🛒 Your Cart</h2>

<div class="cart-container">

<?php
$total = 0;

if(!empty($cart)){

foreach($cart as $id => $qty){

$res = $conn->query("SELECT * FROM products WHERE id=$id");
$row = $res->fetch_assoc();

$subtotal = $row['price'] * $qty;
$total += $subtotal;
?>

<div class="cart-item">

<img src="../uploads/<?php echo $row['image']; ?>">

<div class="details">
<h3><?php echo $row['name']; ?></h3>
<p class="price">₹<?php echo $row['price']; ?></p>

<form method="POST" action="update_cart.php" class="qty-box">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<button name="action" value="minus">−</button>
<span><?php echo $qty; ?></span>
<button name="action" value="plus">+</button>
</form>

<p>Total: ₹<?php echo $subtotal; ?></p>
</div>

<form method="POST" action="remove.php">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<button class="remove-btn">Remove</button>
</form>

</div>

<?php } ?>

<div class="total">
Grand Total: ₹<?php echo $total; ?>
</div>

<div class="checkout-full">
    <a href="checkout.php">Proceed to Checkout ➡</a>
</div>

<?php } else { ?>

<p style="text-align:center;">🪴 Your cart is empty</p>

<?php } ?>

</div>

<!-- SCROLL FIX (UNCHANGED) -->
<script>
document.querySelectorAll("form").forEach(form => {
    form.addEventListener("submit", function(){
        sessionStorage.setItem("scrollPos", window.scrollY);
    });
});

window.onload = function() {
    let pos = sessionStorage.getItem("scrollPos");
    if(pos !== null){
        window.scrollTo(0, pos);
        sessionStorage.removeItem("scrollPos");
    }
};
</script>

</body>
</html>