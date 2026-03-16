<?php 
class student{
    public $name;
    function __construct($n){
        $this->name = $n;
    }
    function display(){
        echo "Name: " . $this->name;
    }
}
$s1 = new student("Rahul");
$s1->display();
?>

