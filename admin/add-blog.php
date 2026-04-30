<?php
session_start();
include '../config/db.php';

// MESSAGE VARIABLE
$msg = "";

// FORM SUBMIT
if(isset($_POST['submit'])){

    $title = $_POST['title'];
    $content = $_POST['content'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    // UPLOAD IMAGE
    move_uploaded_file($tmp, "../uploads/".$image);

    // INSERT INTO DATABASE
    $insert = mysqli_query($conn,"
        INSERT INTO blogs(title, content, image)
        VALUES('$title','$content','$image')
    ");

    if($insert){
        $msg = "Blog added successfully ✅";
    }else{
        $msg = "Error adding blog ❌";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Blog</title>

<style>
body{
    font-family: Arial;
    background:#eef7ee;
    padding:30px;
}

/* CARD */
.container{
    max-width:600px;
    margin:auto;
    background:#fff;
    padding:30px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
    color:#2e7d32;
}

/* INPUT */
input, textarea{
    width:100%;
    padding:12px;
    margin-top:10px;
    border-radius:8px;
    border:1px solid #ccc;
}

textarea{
    height:120px;
}

/* BUTTON */
button{
    margin-top:15px;
    width:100%;
    padding:12px;
    background:#2e7d32;
    color:white;
    border:none;
    border-radius:10px;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#1b5e20;
}

/* MESSAGE */
.msg{
    background:#d4edda;
    color:#155724;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
    text-align:center;
    font-weight:bold;
}
</style>
</head>

<body>

<div class="container">

<h2>🌿 Add New Blog</h2>

<!-- SUCCESS MESSAGE -->
<?php if($msg!=""){ ?>
    <div class="msg"><?php echo $msg; ?></div>
<?php } ?>

<form method="POST" enctype="multipart/form-data">

<label>Title</label>
<input type="text" name="title" required>

<label>Content</label>
<textarea name="content" required></textarea>

<label>Image</label>
<input type="file" name="image" required>

<button name="submit">Add Blog</button>

</form>

</div>

</body>
</html>