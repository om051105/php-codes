<?php
function checkevenodd($num)
{
    if ($num % 2 == 0) {
        return "EVEN";
    } else {
        return "ODD";
    }
}

$number = 8;  //my input number 
$result = checkevenodd($number);
echo "the number $number is $result.";//result
?>