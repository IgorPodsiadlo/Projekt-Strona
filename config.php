<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
$_SERVER['local'] = "http://localhost:63342/untitled1/projekt/";
$conn = mysqli_connect('localhost', 'root', '', 'projek') or die('connection failed');
?>