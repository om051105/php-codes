<?php
class Animal
{
    function sound()
    {
        echo "Animal makes a sound<br>";
    }
}
class Dog extends Animal
{
    function bark()
    {
        echo "Dog barks<br>";
    }
}
class Puppy extends Dog
{
    function weep()
    {
        echo "Puppy weeps<br>";
    }
}
$puppy = new Puppy();

$puppy->sound();
$puppy->bark();
$puppy->weep();

?>