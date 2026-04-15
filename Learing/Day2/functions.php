<?php
/**
 * ==========================================
 * PHP LEARNING PLAN - PHASE 2: FUNCTIONS
 * ==========================================
 * 
 * Functions are blocks of reusable code. Instead of writing the same 
 * code over and over, you write a function once and "call" it whenever you need it.
 * 
 * Topics covered:
 * 1. Built-in Functions
 * 2. User-Defined Functions (Defining & Calling)
 * 3. Managing Parameters (Arguments)
 * 4. Return Values
 * 5. Variable Functions
 * 6. Anonymous Functions (Closures)
 * ==========================================
 */

echo "<h1>PHP Phase 2: Functions</h1>";

// ==========================================
// 1. BUILT-IN FUNCTIONS
// ==========================================
// PHP comes with thousands of built-in functions ready to use.
// You don't have to define these; just call them!
echo "<h2>1. Built-in Functions</h2>";

$sampleString = "hello world";
echo "Original String: $sampleString <br>";

// Built-in function: strtoupper() - Converts a string to uppercase
$upperString = strtoupper($sampleString);
echo "Uppercase (using strtoupper): <strong>$upperString</strong> <br>";

// Built-in function: strlen() - Returns the length (number of characters) of a string
$length = strlen($sampleString);
echo "String Length (using strlen): <strong>$length</strong> characters <br>";


// ==========================================
// 2 & 3. USER-DEFINED FUNCTIONS & PARAMETERS
// ==========================================
// Now let's create our own functions using the 'function' keyword.
echo "<h2>2 & 3. User-Defined Functions & Parameters</h2>";

/* 
 * A simple function that takes NO parameters.
 * DEFINING the function:
 */
function sayHello() {
    echo "Hello! This is a simple user-defined function.<br>";
}

// CALLING the function:
sayHello(); 


/* 
 * A function that takes ONE parameter ($name).
 * Defining it with a parameter allows it to be dynamic!
 */
function greetUser($name) {
    echo "Welcome back, <strong>$name</strong>!<br>";
}

// Calling the function and passing an "argument" (the actual value)
greetUser("Alice");
greetUser("Bob");

/* 
 * A function with MULTIPLE parameters and a DEFAULT value.
 * If we don't pass a 3rd argument, it defaults to "!".
 */
function createGreeting($name, $timeOfDay, $punctuation = "!") {
    echo "Good $timeOfDay, $name$punctuation<br>";
}

createGreeting("Charlie", "Morning"); // Uses default "!"
createGreeting("Dave", "Evening", "?"); // Overrides default with "?"


// ==========================================
// 4. FUNCTIONS WITH RETURN VALUES
// ==========================================
// Often, we don't want a function to print (echo) the result directly.
// Instead, we want it to calculate something and RETURN the value so we can use it later.
echo "<h2>4. Functions with Return Values</h2>";

function addNumbers($num1, $num2) {
    $sum = $num1 + $num2;
    return $sum; // Hands the result back to the code that called it
}

// We call the function and SAVE the returned value into a variable
$total = addNumbers(10, 15);
echo "The total sum returned by the function is: <strong>$total</strong><br>";

// We can also use it directly inside an echo or another calculation
echo "50 + 25 = <strong>" . addNumbers(50, 25) . "</strong><br>";


// ==========================================
// 5. VARIABLE FUNCTIONS
// ==========================================
// In PHP, if you append parentheses () to a variable, PHP will look for a 
// function whose name matches the STRING inside the variable, and execute it!
echo "<h2>5. Variable Functions</h2>";

function shakeHands() {
    echo "🤝 Handshake executed via a variable function!<br>";
}

$myAction = "shakeHands"; // The variable holds the NAME of the function as a string

// By adding (), PHP dynamically calls the shakeHands() function!
$myAction(); 


// ==========================================
// 6. ANONYMOUS FUNCTIONS (Closures)
// ==========================================
// Anonymous functions are functions that have NO NAME.
// They are often stored in variables or passed directly into other functions.
echo "<h2>6. Anonymous Functions</h2>";

// Defining an anonymous function and storing it in a variable ($multiply)
$multiply = function($a, $b) {
    return $a * $b;
}; // Notice the semicolon here! It's required because this is an assignment statement.

// Calling the anonymous function using the variable
$resultMultiplication = $multiply(4, 5);
echo "Result of anonymous function (4 * 5): <strong>$resultMultiplication</strong><br>";


/* 
 * REAL-WORLD USE CASE FOR ANONYMOUS FUNCTIONS:
 * Passing them into built-in functions like array_map()
 */
$numbers = [1, 2, 3, 4, 5];

// array_map applies our anonymous function to EVERY item in the array
$squaredNumbers = array_map(function($n) {
    return $n * $n; // Square the number
}, $numbers);

echo "Squaring an array using an anonymous function inside array_map():<br>";
// print_r is a built-in function to quickly print out an Array in a readable format
echo "<pre>";
print_r($squaredNumbers);
echo "</pre>";

?>
