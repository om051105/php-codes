<?php

class Vehicle
{
    public $name;
    public $speed;

    function __construct($name, $speed)
    {
        $this->name = $name;
        $this->speed = $speed;
    }

    function display()
    {
        echo "Vehicle: " . $this->name . "<br>";
        echo "Speed: " . $this->speed . " km/h<br><br>";
    }
}
class Car extends Vehicle
{
    function carType()
    {
        echo "This is a Car<br>";
    }
}
class Bus extends Vehicle
{
    function busType()
    {
        echo "This is a Bus<br>";
    }
}
$car = new Car("Car", 120);
$bus = new Bus("Bus", 80);

echo "Vehicle Details";

$car->display();
$bus->display();
?>