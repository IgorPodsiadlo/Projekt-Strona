<?php
class product{
    public  $name;
    public  $price ;
    public $image;
    public $opis;
    public $quantity;
    public $opisw;
    public  $cenaw;
    public $kind;

    public function __construct($name, float $price, $image, $opis, $quantity, $opisw, $cenaw, $kind)
    {
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
        $this->opis = $opis;
        $this->quantity = $quantity;
        $this->opisw = $opisw;
        $this->cenaw = $cenaw;
        $this->kind = $kind;
    }
    public function addp() {
        $conn = mysqli_connect('localhost', 'root', '', 'projek') or die('connection failed');
        $db = mysqli_select_db($conn,'projek');
        $query = " INSERT INTO products (name,price,image,opis,quantity,opisw,cenaw,kind) values ('$this->name','$this->price','$this->image','$this->opis','$this->quantity','$this->opisw','$this->cenaw','$this->kind')";
        $conn->query($query);


    }


}