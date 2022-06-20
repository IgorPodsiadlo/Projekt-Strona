<?php
session_start();
include("config.php");
spl_autoload_register(function ($product) {
    include $product . '.php';
});
if (empty($_SESSION['admin'])){
    $_SESSION['admin'] = 0;
}
if(isset($_POST['add_to_cart']))
{
    if(isset($_SESSION['shopping_cart']))
    {
        $item_array_id = array_column($_SESSION['shopping_cart'],'item_id');
        if(!in_array($_GET['id'],$item_array_id))
        {
$count = count($_SESSION['shopping_cart']);
$item_array = array(
    'item_id' => $_GET['id'],
    'item_name' => $_POST['hidden_name'],
    'item_price' => $_POST['hidden_price'],
    'item_quantity' => $_POST['ilosc']

               );
              $_SESSION['shopping_cart'] [$count] = $item_array;
        }
        else{
            echo '<script>alert("Dodano już ten produkt")</script>';


        }

    }
    else{
        $item_array = array(
                'item_id' => $_GET['id'],
            'item_name' => $_POST['hidden_name'],
            'item_price' => $_POST['hidden_price'],
            'item_quantity' => $_POST['ilosc']
        );
        $_SESSION['shopping_cart'] [0] = $item_array;
    }
}

?>
<!DOCTYPE html>
<html lang="utf-8">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src = "funkcje.js"></script>


    <title> Sklep </title>

</head>

<body>

<form>
    <div style="background-color: rgb(44,77,201)">
<?php
if (empty($_SESSION['login']))
{
    echo'<a class="btn btn-dark" style="max-height: 30%;" href=login.php>login</a>
 <input type="button" value="koszyk" class="btn btn-dark" style="float: right" onclick= display()> ';
}
else {
    $a = "zaloguj sie";
    $email = $_SESSION['login'];
    $connection = mysqli_connect('localhost','root','');
    $db = mysqli_select_db($connection,'projek');
    $query =" SELECT name FROM user_info where email like " .  "'$email'";
    $result = mysqli_query($connection,$query);
    $record = mysqli_fetch_assoc($result);
    echo '<h7><b> zalogowano jako:  ' .$record['name'].'</b></h7> 
<a class="btn btn-dark" href="wyloguj.php">wyloguj </a> ';
         echo  '<a  href="koszyk.php" style="float: right"  class="btn btn-dark">koszyk</a>
<a  href="profil.php" style="float: right"  class="btn btn-dark">profil</a>
';

}

?>
    </div>
    </div>
    <br>
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" align="center" data-interval="3000">
        <div class="carousel-inner">
            <div  class="carousel-item active">
    <img class="d-block w-80" src="img/banner.png" >
        </div>
            <div class="carousel-item">
        <img class="d-block w-90" src="img/baner2.jpg" style="max-height: 600px" >
    </div>
        </div>
    </div>
</form>
<h1 align="center">Sklep</h1>
<form method="post">

    <select class = "form-control" style=" max-width: 100px; max-height: 40px; margin-left: 47%; " name="kind">
        <option value="bluza">bluza</option>
        <option value="T-shirt">T-shirt</option>
        <option value="marynarka">marynarka</option>
        <option value="buty">buty</option>
        <option value="cenaw">Cena wysyłki malejąco</option>
        <option value="cena">Cena malejąco</option>
        <option value="wszystko">wszystko</option>
        <input type="submit"  class="btn btn-dark" style="margin-left: 48%; max-height: 10%; " name="filtr" value="filtruj">
    </select>
</form>

</div>

<form method="post" action="" enctype="multipart/form-data">

<?php
$connection = mysqli_connect('localhost','root','');
$db = mysqli_select_db($connection,'projek');
if(isset($_POST['kind'])) {


   
     if ($_POST['kind'] != "wszystko" && $_POST['kind'] != "cenaw" && $_POST['kind'] != "cena" ) {
        $kind = $_POST['kind'];
        $query = " SELECT name,price,image,opis,quantity,id,cenaw FROM products where kind = '$kind'  ORDER BY name ";
    }
    elseif ($_POST['kind'] == "wszystko") {
        $query = ' SELECT name,price,image,opis,quantity,id,cenaw FROM products ORDER BY name ';
    }
    else if ($_POST['kind'] == "cenaw"){
        $query = "SELECT name,price,image,opis,quantity,id,cenaw FROM products ORDER BY cenaw desc ";

    }
    else if ($_POST['kind'] == "cena"){
        $query = "SELECT name,price,image,opis,quantity,id,cenaw FROM products ORDER BY price desc ";
    }
}
else{
    $query = ' SELECT name,price,image,opis,quantity,id,cenaw FROM products ORDER BY name ';
}
$result = mysqli_query($connection,$query);
$count = 0;

while ($record = mysqli_fetch_assoc($result)) {
    $ile = $record['quantity'];

    echo '
<div class="container" >
<div class = "row-4" align="center" style="float: left ; margin-left: 40px " >
 <div style="border: 1px solid #333; background-color:#f1f1f1; border-radius: 5px; padding: 16px; align= center;  max-height: 600px ; max-width: 300px; min-height: 550px; min-width: 300px; margin: 10px; "
    
    <h4 >' . $record['name'] . ' </h4>
    <h4 > cena: ' . $record['price'] . '</h4>
     <h4 >cena z dostawa: ' . $record['cenaw'] . ' </h4>
    <h4 > ilość: ' . $record['quantity'] . '</h4>
    
    ';
    if ($_SESSION['admin'] == 2) {
        echo '<a class="btn btn-danger"   href=delete.php?id=' . $record['id'] . '>Usun</a>
        <a class="btn btn-danger"  href=edit.php?id=' . $record['id'] . '>edytuj</a>';
    } else {

    }
    echo ' <a href=detail.php?id=' . $record['id'] . '>
    <img class ="img-responsive" style="max-height: 200px; max-width: 200px; min-height:200px; min-width=:200px ; border: 1px solid #333; border-radius: 5px;"  src="' . $record['image'] . '">
    </a>
     <h4 >' . $record['opis'] . '</h4> ';
    if (!empty($_SESSION['login']) ){
        if($record['quantity'] != 0){
        echo '     <form method="post" action="shop.php?action=add&id= '. $record['id'].'" >
             <input type="number" name="ilosc" class="form-control" value="1" max="'.$ile.'">
    <input type="hidden" name="hidden_name" value="'. $record['name'].'">
    <input type="hidden" name="hidden_price" value="'. $record['cenaw'].'">
    <input type="submit" name="add_to_cart"  style = "margin-top:5px; " class = "btn btn-dark" value ="Dodaj do koszyka">
    </form> 
     ';}}
    echo '</div>
</div>
</div>';

}
?>

</form>
<form  method="post">
    <div style="clear: left; align-self: end ">
    <?php
    if ($_SESSION['admin'] == 0) {
    echo"<p> </p>";
    }

    else if ($_SESSION['admin'] == 2){
    echo '<h1 align="center">dodaj produkt</h1>
<div align="center">
    <input   name="name" required placeholder="nazwa" >
    <input  name="price" required placeholder="cena" >
    <input  name="image" required placeholder="img" >
    <input  name="opis" required placeholder="opis " >
    <input  name="quantity" required placeholder="ilosc" >
    <input  name="opisw" required placeholder="opis długi" >
    <input  name="cenaw" required placeholder="cena wysylka" >
    <input  name="kind" required placeholder="rodzaj" >
    <input type="submit" name="submit" class="btn btn-danger"  value="dodaj produkt">
    </div>';

    if(!empty($_POST['submit'])){
        if($_POST['name'] && $_POST['price'] && $_POST['image'] && $_POST['opis'] && $_POST['quantity'] && $_POST['opisw'] && $_POST['cenaw'] && $_POST['kind'] ){

            $n = $_POST['name'];
            $connection = mysqli_connect('localhost','root','');
            $db = mysqli_select_db($connection,'projek');
            $query = " SELECT * FROM products where name = '$n'";
            $result = mysqli_query($connection,$query);
            $count = mysqli_num_rows($result);
            if ($count > 0){
                echo '<p align="center">Taki produkt istnieje</p>';
            }
            else{
                $o = new product($_POST['name'],$_POST["price"],$_POST['image'],$_POST['opis'],$_POST['quantity'],$_POST['opisw'],$_POST['cenaw'],$_POST['kind']);
                $o->addp();
            }
        }

    }
}
    ?>
    </div>
</form>


</body>
</html>

