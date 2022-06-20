<?php

class opinia {
    public $name;
    public $opinia;
    public $ocena;
    public $email;

    /**
     * @param $name
     * @param $opinia
     * @param $ocena
     * @param $email
     */
    public function __construct($name, $opinia, $ocena, $email)
    {
        $this->name = $name;
        $this->opinia = $opinia;
        $this->ocena = $ocena;
        $this->email = $email;
    }



public function dodawanie(){
    $conn = mysqli_connect('localhost', 'root', '', 'projek') or die('connection failed');
        $db = mysqli_select_db($conn,'projek');
    $id =$_GET['id'];
    $query = " INSERT INTO opinion (name,opinia,ocena,id_products,email) values ('$this->name','$this->opinia','$this->ocena','$id','$this->email')";
    $conn->query($query);

}


}
?>