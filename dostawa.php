<?php
session_start();
$d = $_POST['dostawa'];
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
$query1 = " INSERT INTO orders ( sposob_dostaw, metoda_platnsci, imie, nazwisko, email, nr_tel, koszt_zamowinia, data_zamowienia, ulica, nrdomu, miasto, kodpocztowy) VALUES ('$d','$p','$n','$na','$em','$t','$tz',current_date ,'$u','$nrd','$m','$kp')";
$connection->query($query1);
header("location:shop.php");
?>