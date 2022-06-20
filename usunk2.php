<?php
session_start();
$email=$_SESSION['login'];
$connection = mysqli_connect('localhost','root','');
$db = mysqli_select_db($connection,'projek');
$query = " DELETE FROM user_info WHERE email = '$email' ";
$connection->query($query);
session_destroy();
header("location:shop.php");

?>
