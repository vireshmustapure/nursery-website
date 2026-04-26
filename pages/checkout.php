<?php
session_start();
include('../config/db.php');
include('../includes/header.php');

if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
    echo "<h3 style='text-align:center;'>🛒 Your cart is empty</h3>";
    exit();
}
?>

<div style="width:80%; margin:auto; margin-top:30px; display:flex; gap:30px;">

    <!-- LEFT SIDE FORM -->
    <div style="flex:1; background:white; padding:20px; border-radius:10px; box-shadow:0 0 10px #ccc;">

        <h2>📦 Delivery Address</h2>

        <form method="POST" action="place_order.php">

            <div style="display:flex; gap:10px;">
                <input type="text" name="name" placeholder="Full Name" required style="flex:1; padding:10px;">
                <input type="text" name="phone" placeholder="Mobile Number" required style="flex:1; padding:10px;">
            </div><br>

            <div style="display:flex; gap:10px;">
                <input type="text" name="pincode" placeholder="Pincode" required style="flex:1; padding:10px;">
                <input type="text" name="state" placeholder="State" required style="flex:1; padding:10px;">
            </div><br>

            <div style="display:flex; gap:10px;">
                <input type="text" name="city" placeholder="City" required style="flex:1; padding:10px;">
                <input type="text" name="landmark" placeholder="Landmark (Optional)" style="flex:1; padding:10px;">
            </div><br>

            <textarea name="address" placeholder="House No, Building, Street, Area" required 
            style="width:100%; padding:10px;"></textarea><br><br>

            <!-- ADDRESS TYPE -->
            <label><b>Address Type:</b></label><br>
            <input type="radio" name="type" value="Home" checked> Home
            <input type="radio" name="type" value="Work"> Work
            <br><br>

            <!-- PAYMENT METHOD -->
            <h3>💳 Payment Method</h3>

            <label>
                <input type="radio" name="payment" value="COD" checked>
                Cash on Delivery
            </label><br>

            <label>
                <input type="radio" name="payment" value="ONLINE">
                Online Payment (Demo)
            </label>

            <br><br>

            <button style="background:#fb641b; color:white; padding:12px 20px; border:none; border-radius:5px; cursor:pointer;">
                Save & Deliver Here
            </button>

        </form>

    </div>

    <!-- RIGHT SIDE SUMMARY -->
    <div style="width:300px; background:white; padding:20px; border-radius:10px; box-shadow:0 0 10px #ccc;">

        <h3>🛒 Order Summary</h3>

        <?php
        $total = 0;

        foreach($_SESSION['cart'] as $id => $qty){

            $res = $conn->query("SELECT * FROM products WHERE id=$id");
            $row = $res->fetch_assoc();

            if(!$row) continue;

            $subtotal = $row['price'] * $qty;
            $total += $subtotal;
        ?>

        <div style="margin-bottom:10px;">
            <?php echo $row['name']; ?> × <?php echo $qty; ?><br>
            ₹<?php echo $subtotal; ?>
        </div>

        <?php } ?>

        <hr>
        <h3 style="color:green;">Total: ₹<?php echo $total; ?></h3>

    </div>

</div>