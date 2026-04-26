<?php
include '../config.php';

// IMPORTANT: do NOT use session_start() here (already in config.php)

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    die("Invalid Order ID");
}

$order_id = $_GET['id'];

// GET ORDER
$order_q = mysqli_query($conn, "SELECT * FROM orders WHERE id='$order_id'");
$order = mysqli_fetch_assoc($order_q);

// GET ORDER ITEMS
$items_q = mysqli_query($conn, "SELECT * FROM order_items WHERE order_id='$order_id'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Order</title>

    <style>
        body{
            font-family:Arial;
            background:#f4f6f9;
        }

        .box{
            width:80%;
            margin:20px auto;
            background:white;
            padding:20px;
            border-radius:10px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th,td{
            padding:10px;
            border-bottom:1px solid #ddd;
            text-align:center;
        }

        th{
            background:#2e7d32;
            color:white;
        }

        .back{
            display:inline-block;
            margin-bottom:10px;
            background:#2e7d32;
            color:white;
            padding:8px 12px;
            text-decoration:none;
            border-radius:5px;
        }
    </style>
</head>

<body>

<div class="box">

<a href="orders.php" class="back">⬅ Back</a>

<h2>📦 Order #<?php echo $order_id; ?></h2>

<p><b>Total:</b> ₹<?php echo $order['total_amount'] ?? 0; ?></p>
<p><b>Status:</b> <?php echo $order['status'] ?? 'pending'; ?></p>

<hr>

<h3>Products</h3>

<table>
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Total</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($items_q)){

        $pid = $row['product_id'];

        // GET PRODUCT NAME FROM PRODUCTS TABLE
        $p = mysqli_query($conn, "SELECT name FROM products WHERE id='$pid'");
        $pdata = mysqli_fetch_assoc($p);
    ?>

    <tr>
        <td><?php echo $pdata['name'] ?? 'Unknown Product'; ?></td>
        <td>₹<?php echo $row['price']; ?></td>
        <td><?php echo $row['quantity']; ?></td>
        <td>₹<?php echo $row['price'] * $row['quantity']; ?></td>
    </tr>

    <?php } ?>

</table>

</div>

</body>
</html>