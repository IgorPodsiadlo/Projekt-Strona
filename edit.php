<?php
session_start();
$id = $_GET['id'];
$connection = mysqli_connect('localhost','root','');
$db = mysqli_select_db($connection,'projek');
$query = " SELECT name,price,image,opis,quantity,id,cenaw,opisw,kind FROM products where id = '$id' ";
$result = mysqli_query($connection,$query);
$record = mysqli_fetch_assoc($result)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>edytuj</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</head>
<body>
<div>    <?php
    echo '
<div class="form-control" style="align-content: center">
<form method="post" action="">
<input  name="name" value="'.$record['name'].'" >
    <input  name="price"  value="'.$record['price'].'">
    <input  name="image" value="'.$record['image'].'" >
    <input  name="opis" value="'.$record['opis'].'" >
    <input  name="quantity" value="'.$record['quantity'].'" >
    <input  name="opisw" value="'.$record['opisw'].'" >
    <input  name="cenaw" value="'.$record['cenaw'].'" >
    <input  name="kind" value="'.$record['kind'].'" >
<input type="submit" class="btn btn-dark" name="edit" value="edit">
</form>
</div>';
    if(isset($_POST['edit'])){
        $n = $_POST['name'];
        $p = $_POST['price'];
        $i = $_POST['image'];
        $o = $_POST['opis'];
        $q = $_POST['quantity'];
        $ow = $_POST['opisw'];
        $pw = $_POST['cenaw'];
        $k = $_POST['kind'];
        $db = mysqli_select_db($connection,'projek');
        $query = " UPDATE  products SET name = '$n',price ='$p' ,image = '$i',opis = '$o' ,quantity = '$q',opisw = '$ow',cenaw = '$pw', kind = '$k' where id = '$id' ";
        $connection->query($query);
        header('location:shop.php');

    }

    ?>
</div>
</body>
</html>
