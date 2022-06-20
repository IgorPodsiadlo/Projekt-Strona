<?php
session_start();
include("config.php");
$connection = mysqli_connect('localhost','root','');
$db = mysqli_select_db($connection,'projek');
$query = ' SELECT name,price,image,opis,quantity,id,cenaw FROM products ORDER BY name ';
$result = mysqli_query($connection,$query);
$record = mysqli_fetch_assoc($result);
if(isset($_GET["action"]))
{
    if($_GET["action"] == "delete")
    {
        foreach($_SESSION["shopping_cart"] as $keys => $record)
        {
            if($record["item_id"] == $_GET["id"])
            {
                unset($_SESSION["shopping_cart"][$keys]);
                echo '<script>alert("Usunięto produkt")</script>';
                echo '<script>window.location="koszyk.php"</script>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Koszyk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<form>
    <div style="background-color: rgb(44,77,201)">
        <?php

            $a = "zaloguj sie";
            $email = $_SESSION['login'];
            $connection = mysqli_connect('localhost','root','');
            $db = mysqli_select_db($connection,'projek');
            $query =" SELECT name FROM user_info where email like " .  "'$email'";
            $result = mysqli_query($connection,$query);
            $record = mysqli_fetch_assoc($result);
            echo '<h7><b> zalogowano jako:  ' .$record['name'].'</b></h7> <a class="btn btn-dark" href="wyloguj.php">wyloguj </a> ';
            echo  '<a  href="shop.php" style="float: right"  class="btn btn-dark">Strona główna</a>';

        ?>

    </div>
</form>
<br />
<div class="container"  >
<br />
<h3 align="center">Twoje zamówienie</h3>
<br/>
    <div class="table-responsive">
<table class="table table-bordered" >
    <tr>
        <th width="40%">Nazwa produktu</th>
        <th width="10%">Ilośc</th>
        <th width="20%">Nazwa</th>
        <th width="15%">Cena</th>
        <th width="5%">Całość</th>
    </tr>
    <?php
    if(!empty($_SESSION['shopping_cart']))
    {
        $total = 0;
        foreach ($_SESSION['shopping_cart'] as $keys => $record){





    ?>
    <tr>
        <td ><?php echo $record["item_name"] ?></td>
        <td ><?php echo $record["item_quantity"] ?></td>
        <td ><?php echo $record["item_name"] ?></td>
        <td ><?php echo $record["item_price"] ?></td>
        <td ><?php echo number_format($record['item_quantity'] * $record['item_price'],2,'.',''); ?></td>
        <td ><a href="koszyk.php?action=delete&id=<?php echo  $record['item_id'];?>"><span class="text-danger">usun</span></a> </td>
    </tr>
    <?php
    $total = $total + ($record['item_quantity'] * $record['item_price']);
            $_SESSION['cena'] = number_format($total, 2,'.','');
        }
    ?>
    <tr>
        <td colspan="3" align="right" >Całość</td>
        <td align="right" >  <?php echo number_format($total,2,'.',''); ?>zł</td>
    </tr>
    <?php
    }
    ?>
</table>
    </div>
</div>
    <br/>
    <form  method="post" action="" align="center" >

        metoda dostawy: <select   style="max-width: 100px; max-height: 40px;"   name="dostawa" >
            <option value="kurier">kurier</option>
            <option value="paczkomat">paczkomat</option>
        </select>
        metoda płatności: <select style="max-width: 100px; max-height: 40px;  " name="płatność">
            <option value="blik">blik</option>
            <option value="przelew">przelew</option>
        </select>
<br style="clear: left"/>
        <input name="name" placeholder="podaj imię odbiorcy" required>
        <input name="nazwisko" placeholder="podaj nazwisko odbiorcy" required>
        <input name="tele"  placeholder="Nr telefonu"  pattern="+48\d{9}" required>
        <input name="ulica" placeholder="Nazwa ulicy" required>
        <input name="nrd" placeholder="numer domu" required>
        <input name="miasto" placeholder="miasto" required>
        <input name="kodp" placeholder="kod pocztowy"required pattern="[0-9]{2}-[0-9]{3}">
        <input type="submit" name="dalej" class="btn btn-dark" value="Prześlij">
        <?php
        if (isset($_POST['dalej'])){
            $da = $_POST['dostawa'];
            $p = $_POST['płatność'];
            $n = $_POST['name'];
            $na = $_POST['nazwisko'];
            $em = $_SESSION['login'];
            $t = $_POST['tele'];
            $u = $_POST['ulica'];
            $nrd = $_POST["nrd"];
            $m = $_POST['miasto'];
            $kp = $_POST['kodp'];
            $tz = $_SESSION['cena'];
            $connection = mysqli_connect('localhost', 'root', '');
            $db = mysqli_select_db($connection, 'projek');
            $query1 = " INSERT INTO orders ( sposob_dostaw, metoda_platnsci, imie, nazwisko, email, nr_tel, koszt_zamowinia, data_zamowienia, ulica, nrdomu, miasto, kodpocztowy) VALUES ('$da','$p','$n','$na','$em','$t','$tz',current_date ,'$u','$nrd','$m','$kp')";
            $connection->query($query1);
            unset($_SESSION['shopping_cart']);
            header("location:shop.php");
            $il = $record['item_quantity'];
            $na = $record["item_name"];
            $query2 = " UPDATE products set quantity = quantity - '$il' where name = '$na' ";
           $connection->query($query2);
        }
        ?>

    </form>
</body>
</html>
