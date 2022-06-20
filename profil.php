<?php
session_start();
include "config.php";
$db = mysqli_select_db($conn,'projek');

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
<br/>
<form>
    <?php
    $query = " SELECT * FROM orders where email = '$email '";
    $result = mysqli_query($conn,$query);
    while ($record = mysqli_fetch_assoc($result)) {
        echo '
<div class="container">
    <div class = "row " align="center" style="float: left; margin-left: 43px " >
        <div style="border: 1px solid #333; background-color:#f1f1f1; border-radius: 5px; padding: 16px; align= center;  max-height: 700px ; max-width: 300px; min-height: 700px; min-width: 300px; margin: 10px; "
        <h4></h4>
        <h4 > Metoda dostawy: '  . $record['sposob_dostaw'] . ' </h4>
        <h4 > Metoda płatności:  ' . $record['metoda_platnsci'] . '</h4>
        <h4 > Imie odbiorcy:  ' . $record['imie'] . ' </h4>
        <h4 > Nazwisko odbiorcy:  ' . $record['nazwisko'] . '</h4>
         <h4 > Email:  ' . $record['email'] . '</h4>
          <h4 > Telefon:  ' . $record['nr_tel'] . '</h4>
           <h4 > Data zamowienia:  ' . $record['data_zamowienia'] . '</h4>
            <h4 > Koszt zamowienia:  ' . $record['koszt_zamowinia'] . '</h4>
             <h4 > Nazwa ulica:  ' . $record['ulica'] . '</h4>
              <h4 > Nr domu:  ' . $record['nrdomu'] . '</h4>
               <h4 > Miasto:  ' . $record['miasto'] . '</h4>
                <h4 > Kod pocztowy:  ' . $record['kodpocztowy'] . '</h4>

        </div>
        </div>
        </div>
        ';
    }
    $query2 = "SELECT * FROM opinion where email = '$email'";
    $result1 = mysqli_query($conn,$query2);
     while ($record1 = mysqli_fetch_assoc($result1)){
         echo '

    <div class = "row " align="center" style="float: left; margin-left: 43px " >
        <div style="border: 1px solid #333; background-color:#f1f1f1; border-radius: 5px; padding: 16px; align= center;  max-height: 700px ; max-width: 300px; min-height: 200px; min-width: 300px; margin: 10px; "
         <h6> Twoja opinia </h6>
         <h6> '. $record1['name'] . ' </h6>
    <h6> ocena '. $record1['ocena'] .' </h6>
    <h6> '. $record1['opinia'] . '</h6>
         </div>
        
         ';
     }


    ?>
</form>
<div >
<?php
$query = " SELECT * FROM user_info where email = '$email' ";
$result = mysqli_query($connection,$query);
$record = mysqli_fetch_assoc($result);
echo '
<form method="post" action="" >
<div class="fixed-bottom">
<input type="text" name="name" value="'.$record['name'].' " >
<input type="email" name="email" value="'.$record['email'].'" >
<input type="submit" class="btn btn-dark" name="edit" value="edytuj">
<a href="usunk.php" class="btn btn-danger" s >Usuń konto</a>
</div>
';
if (isset($_POST['edit'])){
    $n = $_POST['name'];
    $e = $_POST['email'];
    $query = " UPDATE  user_info SET name = '$n', email = '$e' where email = '$email' ";
    $query3 =   "UPDATE opinion   SET name = '$n' , email = '$e'where  email = '$email'";
    $connection->query($query);
    $connection->query($query3);
    header('location:shop.php');

}

?>





</body>
</html>