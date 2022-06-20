<?php
session_start();
$id = $_GET['id'];

    $connection = mysqli_connect('localhost','root','');
    $db = mysqli_select_db($connection,'projek');
    $query = " DELETE FROM products WHERE id = '$id'";
    $connection->query($query);
    header("location:shop.php");

?>