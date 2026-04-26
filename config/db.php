<?php
$conn = new mysqli("localhost", "root", "", "nursery");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>