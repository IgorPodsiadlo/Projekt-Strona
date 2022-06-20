<?php
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
    header("location:shop.php");
