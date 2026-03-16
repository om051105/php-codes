<?php
class Rectangle {
    public $length;
    public $width;
    function __construct($l, $w){
        $this->length = $l;
        $this->width = $w;
    }
    function area(){
        $a = $this->length * $this->width;
        echo "Area of Rectangle: " . $a;
    }
}
$r1 = new Rectangle(10, 5);
$r1->area();
?>