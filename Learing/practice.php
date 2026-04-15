<?php
/**
 * ==========================================
 * PHP LEARNING PLAN - PHASE 1: PRACTICE
 * ==========================================
 * 
 * Here are some practice questions based on what we learned:
 * Variables, Math, Control Flow (If/Else), and Loops!
 * 
 * Each question has:
 * - The Problem Statement
 * - The Logic (How to think about the problem)
 * - The Solution (The actual PHP code)
 * ==========================================
 */

echo "<h1>PHP Basics: Practice Questions & Solutions</h1>";

// ==========================================
// QUESTION 1: Variables & Math
// ==========================================
echo "<h2>Question 1: Area of a Rectangle</h2>";
echo "<strong>Problem:</strong> Create variables for the length and width of a rectangle. Calculate its area and print the result.<br>";

/* 
 * LOGIC:
 * 1. The formula for the area of a rectangle is: Area = Length * Width.
 * 2. We need two variables to store the length and width values.
 * 3. We need a third variable to store the result of the multiplication.
 * 4. Finally, we use 'echo' to print the result to the screen.
 */


// SOLUTION:
$length = 10; // Assigning 10 to length
$width = 5;   // Assigning 5 to width
$area = $length * $width; // Multiplying them together

echo "<strong>Solution Output:</strong> The area of a rectangle with length $length and width $width is: $area <br>";


// ==========================================
// QUESTION 2: Control Flow (If/Else)
// ==========================================
echo "<h2>Question 2: Even or Odd Number</h2>";
echo "<strong>Problem:</strong> Given a number, check if it is Even or Odd and print a message.<br>";

/* 
 * LOGIC:
 * 1. An even number is any number that is exactly divisible by 2 (remainder is 0).
 * 2. We can use the modulo operator (%) to find the remainder of a division.
 * 3. If ($number % 2 == 0), then it's even.
 * 4. Else, it's odd.
 */

// SOLUTION:
$numberToCheck = 7; // You can change this number to test

if ($numberToCheck % 2 == 0) {
    echo "<strong>Solution Output:</strong> The number $numberToCheck is Even.<br>";
} else {
    echo "<strong>Solution Output:</strong> The number $numberToCheck is Odd.<br>";
}


$numberToCheck =3;

if($numberToCheck % 2==0){
    echo"<strong>soution output: </strong>the number $numberToCheck is even<br>";
}
else{
    echo"<strong> the output </strong>the number i$numbertocheck is odd.";
}

// ==========================================
// QUESTION 3: Loops (For Loop)
// ==========================================
echo "<h2>Question 3: Multiplication Table</h2>";
echo "<strong>Problem:</strong> Print the multiplication table for the number 5 (from 5 x 1 to 5 x 10).<br>";

/* 
 * LOGIC:
 * 1. We know we need to repeat an action 10 times (multiplying 5 by 1, then 2, then 3... up to 10).
 * 2. A 'for' loop is perfect for this because we know exactly how many times it should run.
 * 3. We set our loop counter ($i) to start at 1 and end at 10.
 * 4. Inside the loop, we multiply 5 by $i and print the result.
 */

// SOLUTION:
$tableNumber = 5;

echo "<strong>Solution Output:</strong><br>";
// Loop starts at $i = 1; runs as long as $i <= 10; increases $i by 1 each time
for ($i = 1; $i <= 10; $i++) {
    $result = $tableNumber * $i;
    echo "$tableNumber x $i = $result <br>";
}


// ==========================================
// QUESTION 4: Arrays & Foreach Loop
// ==========================================
echo "<h2>Question 4: Sum of an Array</h2>";
echo "<strong>Problem:</strong> Create an array of 5 numbers. Calculate the total sum of all the numbers in the array.<br>";

/* 
 * LOGIC:
 * 1. First, create an array holding multiple numbers.
 * 2. Create a variable called $totalSum and set it to 0 initially.
 * 3. A 'foreach' loop is the best way to go through every single item in an array one by one.
 * 4. As the loop goes through each number, add that number to $totalSum.
 */

// SOLUTION:
$numbersArray = array(10, 20, 30, 40, 50); // The array of numbers
$totalSum = 0; // Starting total is 0

foreach ($numbersArray as $singleNumber) {
    // Add the current number to the total sum
    $totalSum = $totalSum + $singleNumber; 
    // Shorthand notation for this is: $totalSum += $singleNumber;
}

echo "<strong>Solution Output:</strong> The total sum of the array is: $totalSum <br>";

?>
