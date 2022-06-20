<?php
session_start();
include("config.php");
spl_autoload_register(function ($opinia) {
    include $opinia . '.php';
});

?>
<!DOCTYPE html>
<html lang="utf-8">
<head>

    <title> Sklep </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</head>

<body>
    <form>
        <div style="background-color: rgb(44,77,201)">
            <?php
            if (empty($_SESSION['login']))
            {
                echo'<a class="btn btn-dark" style="max-height: 30%;" href=login.php>login</a>
<a  href="shop.php" style="float: right"  class="btn btn-dark">Strona główna</a>';
            }
            else {
                $email = $_SESSION['login'];
                $connection = mysqli_connect('localhost','root','');
                $db = mysqli_select_db($connection,'projek');
                $query =" SELECT name FROM user_info where email like " .  "'$email'";
                $result = mysqli_query($connection,$query);
                $record = mysqli_fetch_assoc($result);
                echo '<h7><b> zalogowano jako:  ' .$record['name'].'</b></h7> <a class="btn btn-dark" href="wyloguj.php">wyloguj </a>
              <a  href="shop.php" style="float: right"  class="btn btn-dark">Strona główna</a>';
            }

            ?>
</form>


</div>
    <br>
    <h1 align="center">Detale Produktu</h1>
    <div>
<?php
    $connection = mysqli_connect('localhost','root','');
    $db = mysqli_select_db($connection,'projek');
    $id = $_GET['id'];
    $strona = "detail.php?id=$id";
    $query = " SELECT name,price,image,opisw,quantity,cenaw,id FROM products where id =  '$id' ";
    $result = mysqli_query($connection,$query);
    while ($record = mysqli_fetch_assoc($result)) {
        echo '
<div class="container">
<div class = "row " align="center" style="float: left; margin-left: 43px " >
 <div style="border: 1px solid #333; background-color:#f1f1f1; border-radius: 5px; padding: 16px; align= center;  max-height: 500px ; max-width: 300px; min-height: 500px; min-width: 300px; margin: 10px; "
    <h4 >' . $record['name'] . ' </h4>
    <h4 > cena: ' . $record['price'] . '</h4>
     <h4 >cena z dostawa: ' . $record['cenaw'] . ' </h4>
    <h4 > ilość: ' . $record['quantity'] . '</h4>
    <h4 > ' . $record['opisw'] . '</h4>
    <img class ="img-responsive" style="max-height: 200px; max-width: 200px; min-height:200px; min-width=:200px ; border: 1px solid #333; border-radius: 5px;"  src="' . $record['image'] . '">';
   if (!empty($_SESSION['login'])) {
       echo '<form method="post" action="shop.php">
             <input type="text" name="ilosc" class="form-control" value="1">
    <input type="hidden" name="hidden_name" value="' . $record['name'] . '">
    <input type="hidden" name="hidden_price" value="' . $record['cenaw'] . '">
        <input type="submit" name="add_to_cart"  style = "margin-top:5px; " class = "btn btn-dark" value ="Dodaj do koszyka">
        </form> 


    
    ';
   }
echo '        </div>
    </div>
    </div>
';
    }
$connection = mysqli_connect('localhost', 'root', '');
$db = mysqli_select_db($connection, 'projek');
$query = " SELECT name,opinia,ocena,id, id_products FROM opinion WHERE id_products = '$id' order by name";
$result = mysqli_query($connection, $query);
while ($record = mysqli_fetch_assoc($result)) {

    echo '<div class="container">
<div class = "row " align="center" style="float: left; margin-left: 43px " >
 <div style="border: 1px solid #333; background-color:#f1f1f1; border-radius: 5px; padding: 16px; align= center;  max-height: 170px ; max-width: 170px; min-height: 170px; min-width: 170px; margin: 10px; "
    <h6> '. $record['name'] . ' </h6>
    <h6> ocena '. $record['ocena'] .' </h6>
    <h6> '. $record['opinia'] . '</h6>';
    if ($_SESSION['admin'] == 2){
        echo '<h6> id: '.$record['id'].'</h6>';
    }
    echo '</div>
</div>
</div>';
}
?>
</form>
    <div  style=" clear: left; align-self: end;">
<form  method="post">
    <?php
    if(empty($_SESSION['login'])) {

       echo '<h4 align = "center" > login to post opinion </h4 >';
    }
    ?>
<div align="center">
    <input  name="opinion" required placeholder="napisz opinion" >
    <input type="number" name ="grade" required placeholder="ocena" min="1" max="5">
    <input type="submit" name="submit" class="btn btn-dark" <?php if (empty($_SESSION['login'])){ echo 'disabled';}?> value="Dodaj opinie">
</div>
    <?php
    if(!empty($_POST['submit'])){
        if($_POST['opinion']){
            $o = $_POST['opinion'];
            $connection = mysqli_connect('localhost','root','');
            $db = mysqli_select_db($connection,'projek');
            $query = " SELECT * FROM opinion where opinia = '$o'";
            print_r($query);
            $result = mysqli_query($connection,$query);
            $count = mysqli_num_rows($result);
            if ($count > 0){
                echo '<p>Taka sama opinia istnieje</p>';
            }
            else{
                $db = mysqli_select_db($connection,'projek');
                $query = " SELECT name FROM user_info where email = '$email' ";
                $result = mysqli_query($connection,$query);
                $record = mysqli_fetch_assoc($result);
                $o = new opinia($record['name'],$_POST["opinion"],$_POST['grade'],$_SESSION['login']);
                $o->dodawanie();
                header("location:$strona");
            }
        }
        else {
            echo '<p>wypełnij wszystkie luki</p>';
        }

    }

?>
</form>
    </div>
</div>
<form method="post">
    <?php
    if ($_SESSION['admin'] == 0) {
        echo"<p> </p>";
    }
    else if ($_SESSION['admin'] == 2){
        echo '<div  style=" clear: left; align-self: end;">
<h4 align="center">usuń opinie</h4>
<div align="center">
    <input  name="idu" required placeholder="podaj id" >
    <input type="submit" class="btn btn-danger" name="usun" value="usun">
    </div>
    </div>
             ';
        if (!empty($_POST['usun'])){
            $conn = mysqli_connect('localhost', 'root', '', 'projek') or die('connection failed');
            $db = mysqli_select_db($conn,'projek');
            if ($_POST['idu']){
                $idu = $_POST['idu'];
                $query = " DELETE FROM opinion WHERE id = '$idu'";
                $conn->query($query);
            }

        }
    }
    ?>
</form>


</body>
</html>
