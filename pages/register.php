<?php
session_start();
include '../config/db.php';

$message = "";

// ✅ RESET SESSION WHEN PAGE FIRST LOADS (IMPORTANT FIX)
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    session_unset();
    session_destroy();
    session_start();
}

// STEP CONTROL
$step = 1;

// CHECK STEP
if(isset($_SESSION['otp_sent'])){
    $step = 2;
}
if(isset($_SESSION['otp_verified'])){
    $step = 3;
}

// SEND OTP
if(isset($_POST['send_otp'])){
    $mobile = $_POST['mobile'];

    if(!empty($mobile)){

        $otp = rand(1000,9999);

        $_SESSION['otp'] = $otp;
        $_SESSION['mobile'] = $mobile;
        $_SESSION['otp_sent'] = true;

        $message = "Your OTP (demo): " . $otp;
        $step = 2;

    } else {
        $message = "Enter mobile number!";
    }
}

// VERIFY OTP
if(isset($_POST['verify_otp'])){
    $otp_input = $_POST['otp'];

    if($otp_input == $_SESSION['otp']){
        $_SESSION['otp_verified'] = true;
        $message = "OTP Verified! Now complete registration.";
        $step = 3;
    } else {
        $message = "Invalid OTP!";
        $step = 2;
    }
}

// REGISTER
if(isset($_POST['register'])){

    if(isset($_SESSION['otp_verified'])){

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $mobile = $_SESSION['mobile'];

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // CHECK EXIST
        $check = $conn->query("SELECT * FROM users WHERE email='$email' OR mobile='$mobile'");

        if($check->num_rows > 0){

            $row = $check->fetch_assoc();

            if($row['email'] == $email){
                $message = "Email already exists!";
            } else {
                $message = "Mobile already registered!";
            }

        } else {

            $sql = "INSERT INTO users (name,email,mobile,password)
                    VALUES ('$name','$email','$mobile','$passwordHash')";

            if($conn->query($sql)){
                session_destroy();
                header("Location: login.php?success=1");
                exit();
            } else {
                $message = "Database Error!";
            }
        }

    } else {
        $message = "Verify OTP first!";
        $step = 2;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register - Hani Nursery</title>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: linear-gradient(to right, #2e7d32, #66bb6a);
}

.container {
    width: 350px;
    margin: 60px auto;
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    text-align: center;
}

h2 {
    color: #2e7d32;
}

input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 8px;
    border: 1px solid #ccc;
}

button {
    width: 100%;
    padding: 12px;
    background: #2e7d32;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}

button:hover {
    background: #1b5e20;
}

.msg {
    margin-bottom: 10px;
    color: red;
    font-weight: bold;
}
</style>
</head>

<body>

<div class="container">

<h2>🌿 Register</h2>

<?php if(!empty($message)) { ?>
<p class="msg"><?php echo $message; ?></p>
<?php } ?>

<!-- STEP 1 -->
<?php if($step == 1){ ?>
<form method="POST">
    <input type="text" name="mobile" placeholder="Enter Mobile Number" required>
    <button type="submit" name="send_otp">Send OTP</button>
</form>
<?php } ?>

<!-- STEP 2 -->
<?php if($step == 2){ ?>
<form method="POST">
    <input type="text" name="otp" placeholder="Enter OTP" required>
    <button type="submit" name="verify_otp">Verify OTP</button>
</form>
<?php } ?>

<!-- STEP 3 -->
<?php if($step == 3){ ?>
<form method="POST">
    <!-- ✅ ALL FIELDS EMPTY ALWAYS -->
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="password" name="password" placeholder="Create Password" required>
    <button type="submit" name="register">Register</button>
</form>
<?php } ?>

</div>

</body>
</html>