<?php
// Step 1: Input number
$number = 12345;  // you can change this number

$reverse = 0;

// Step 2: Reverse using loop
while ($number > 0) {
    $digit = $number % 10;          // get last digit
    $reverse = ($reverse * 10) + $digit; // build reversed number
    $number = (int) ($number / 10);  // remove last digit
}

// Output
echo "Reversed Number = " . $reverse;
?>