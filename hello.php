
<?php

class Dog
{
    function bark()
    {
        echo "Woof Woof";
    }
}
$german_shepherd = new Dog();
$german_shepherd->bark();
?>

<?php
class math
{
    function sum($a, $b)
    {
        echo $a + $b . PHP_EOL;
    }
}
$math1 = new math();
$math1->sum(2,3);
$math2 = new math();
$math2->sum(9,7);
?>

<?php
class student{
 public $name;
 public $roll;

 function display(){
    echo "Name: " . $this->name . PHP_EOL;
    echo "Roll: " . $this->roll . PHP_EOL;
 }
}
$s1=new student();
$s1->name="rahul";
$s1->roll=101;
$s1->display();
?>

// create a result management system or display result for the 5 students
<?php
class result{
    public $name;
    public $roll;
    public $marks;

    function display(){
        echo "Name: " . $this->name . PHP_EOL;
        echo "Roll: " . $this->roll . PHP_EOL;
        echo "Marks: " . $this->marks . PHP_EOL;
    }
}
$s1=new result();
$s1->name="rahul";
$s1->roll=101;
$s1->marks=90;
$s1->display();
?>



