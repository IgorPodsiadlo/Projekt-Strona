<?php
session_start();
include("config.php");



if(isset($_POST['submit'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));


    $select = mysqli_query($conn, "SELECT * FROM `user_info` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if(mysqli_num_rows($select) > 0){
        $row = mysqli_fetch_assoc($select);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['login'] = $_POST['email'];
        $query = " SELECT isadmin FROM user_info where email = '$email'";
        $result = mysqli_query($conn,$query);
        $record = mysqli_fetch_assoc($result);
        if ( $record['isadmin'] == '1'){
            $_SESSION['admin'] = "2" ;
        }
        else {
            $_SESSION['admin'] = 0;
        }
        header('location:shop.php');
    }else{
        $message[] = 'incorrect password or email!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<body>
<form>
<?php
if(isset($message)){
    foreach($message as $message){
        echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
    }
}
?>
</form>

<div style="padding: 100px 800px 10px;">
    <form class="bs-example bs-example-form align-content-center" role="form" action="login.php" method="post">

        <div class="input-group input-group-sm">
        <input class="form-control" id="form2Example1" type="email" name="email" required placeholder="email" >
        </div>
        <div class="input-group input-group-sm">
        <input class="form-control" id="form2Example2" type="password" name="password" required placeholder="Hasło" >
        </div>
        <div class="container ">
            <div class="col-md-12 text-center">
        <input class="btn btn-primary btn-sm mb-4 align-self-center" type="submit" name="submit"  value="Zaloguj">
            </div>
        </div>
        <div class="container " >
            <div class="col-md-12 text-center">
        <p>Nie masz konta ? </p>
        <a class=" btn btn-primary btn-sm mb-4" href="register.php">Stwórz konto</a>
            </div>
        </div>

</div>
    </form>



</body>
</html>