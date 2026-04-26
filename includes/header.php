<?php
// CART COUNT
$count = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $count = array_sum($_SESSION['cart']);
}
?>

<div style="
    background:#1b5e20;
    padding:15px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-family:'Segoe UI',sans-serif;
    box-shadow:0 2px 10px rgba(0,0,0,0.2);
">

    <!-- LEFT SIDE -->
    <div style="display:flex; align-items:center; gap:10px;">
        <a href="/nursery/index.php" style="text-decoration:none; color:white; display:flex; align-items:center;">
            <img src="/nursery/assets/images/logo.png" style="width:42px; height:42px; border-radius:50%; margin-right:10px;">
            <h2 style="margin:0; font-size:22px; font-weight:700; color:white;">
                🌿 Hani Nursery and Gardening
            </h2>
        </a>
    </div>

    <!-- RIGHT SIDE -->
    <div style="display:flex; align-items:center; gap:30px;">

        <!-- CART -->
        <a href="/nursery/pages/cart.php" style="
            color:white;
            text-decoration:none;
            font-size:18px;
            font-weight:700;
            display:flex;
            align-items:center;
            gap:6px;
        ">
            🛒 Cart (<span id="cart-count"><?php echo $count; ?></span>)
        </a>

        <!-- LOGIN -->
        <?php if(isset($_SESSION['user'])){ ?>
            <span style="color:white; font-weight:600;">
                👤 <?php echo htmlspecialchars($_SESSION['user']); ?>
            </span>
            <a href="/nursery/logout.php" style="color:white; font-weight:600; text-decoration:none;">Logout</a>
        <?php } else { ?>
            <a href="/nursery/pages/login.php" style="
                color:white;
                text-decoration:none;
                font-size:18px;
                font-weight:700;
                display:flex;
                align-items:center;
                gap:6px;
            ">
                👤 Login
            </a>
        <?php } ?>

    </div>

</div>