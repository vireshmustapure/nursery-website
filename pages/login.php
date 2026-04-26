<?php
session_start();
include '../config/db.php';

$message = "";

// SUCCESS MESSAGE AFTER PASSWORD RESET
if(isset($_GET['success'])){
    $message = "Password updated successfully! Please login.";
}

// LOGIN PROCESS
if(isset($_POST['login'])){
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE mobile='$mobile'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])){
            $_SESSION['user'] = $user['name'];
            header("Location: ../index.php");
            exit();
        } else {
            $message = "Wrong password!";
        }
    } else {
        $message = "Mobile not registered!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>
body {
    margin:0;
    font-family:Arial;
    background:url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6') no-repeat center/cover;
}

body::before {
    content:"";
    position:fixed;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.5);
    z-index:-1;
}

.container {
    width:350px;
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(12px);
    padding:25px;
    justify-content:center;
    border-radius:15px;
    text-align:center;
    color:white;
        position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

}

/* inputs */
input {
    width:100%;
    padding:12px;
    margin:10px 0;
    border:none;
    border-radius:8px;
    background:rgba(255,255,255,0.2);
    color:white;
}

input::placeholder {
    color:#eee;
}

/* password */
.password-box {
    position:relative;
}

.password-box span {
    position:absolute;
    right:10px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
}

/* button */
button {
    width:100%;
    padding:12px;
    background:#2e7d32;
    color:white;
    border:none;
    border-radius:8px;
}

/* links */
a {
    color:#a5d6a7;
    display:block;
    margin-top:8px;
    text-decoration:none;
}

.msg {
    color:#ffcccb;
}
</style>
</head>

<body>

<div class="container" style="margin-top:50px; background:rgba(255,255,255,0.1);
">

<h2>🌿 Login</h2>

<?php if($message!="") echo "<p class='msg'>$message</p>"; ?>

<form method="POST" autocomplete="off">

<input type="text" name="mobile" placeholder="Mobile Number" autocomplete="off" required>

<div class="password-box">
<input type="password" id="pass" name="password" placeholder="Password" required>
<span onclick="toggle()">👁</span>
</div>

<button name="login">Login</button>

</form>

<a href="forgot_password.php">Forgot Password?</a>
<a href="register.php">Create Account</a>

</div>

<script>
function toggle(){
    var p = document.getElementById("pass");
    p.type = (p.type === "password") ? "text" : "password";
}
</script>

</body>
</html>