<?php
include '../config/db.php';

$id = $_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM blogs WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

$title = $_POST['title'];
$content = $_POST['content'];

if($_FILES['image']['name']){
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "../uploads/".$image);

    mysqli_query($conn,"UPDATE blogs SET 
    title='$title',
    content='$content',
    image='$image'
    WHERE id=$id");
}else{
    mysqli_query($conn,"UPDATE blogs SET 
    title='$title',
    content='$content'
    WHERE id=$id");
}

echo "Updated Successfully!";
}
?>

<h2>Edit Blog</h2>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" value="<?php echo $row['title']; ?>"><br><br>

    <textarea name="content"><?php echo $row['content']; ?></textarea><br><br>

    <img src="../uploads/<?php echo $row['image']; ?>" width="100"><br><br>

    <input type="file" name="image"><br><br>

    <button type="submit" name="update">Update</button>
</form>