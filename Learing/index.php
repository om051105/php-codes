<?php
/**
 * ==========================================
 * PHP LEARNING PLAN - PHASE 1 & 2: BASICS
 * ==========================================
 * 
 * Welcome to PHP! This file is your interactive textbook.
 * 
 * INTRODUCTION TO PHP:
 * 1. What does PHP do? 
 *    PHP (Hypertext Preprocessor) is a server-side scripting language. 
 *    It runs on the web server, generates HTML, and sends it to the client's browser.
 *    It can interact with databases, handle forms, and manage sessions.
 * 
 * 2. Evolution of PHP:
 *    Created by Rasmus Lerdorf in 1994, it started as a simple set of CGI binaries in C. 
 *    Now, it's a fully-featured, object-oriented language (PHP 8+) powering much of the web.
 * 
 * 3. Widespread Use:
 *    PHP powers CMS platforms like WordPress, e-commerce sites like Magento, and 
 *    frameworks like Laravel. Over 70% of websites with a known server-side language use PHP.
 * 
 * 4. Installing PHP:
 *    Usually installed via XAMPP, WAMP, or standalone binaries on Windows. 
 *    Since you are editing this, you likely have an environment ready!
 * 
 * ==========================================
 * LANGUAGE BASICS 
 * ==========================================
 */

// 1. EMBEDDING PHP IN WEB PAGES
// PHP files can contain normal HTML. PHP code is enclosed in <?php ... ? > tags.
// The server executes the PHP and outputs the resulting text/HTML.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Basics Tutorial</title>
</head>
<body>
    <h1>Welcome to PHP Learning!</h1>
    
    <?php
    // 2. LEXICAL STRUCTURES
    // Lexical structure refers to the basic rules of the language.
    // - Statements are terminated with a semicolon (;).
    // - Whitespace (spaces, tabs, newlines) is generally ignored.
    // - PHP is case-sensitive for variable names ($Name is different from $name), 
    //   but NOT for keywords (if, IF, If are the same) or function names.

    /* 
       This is a multi-line comment.
       It's great for explaining complex logic over several lines.
    */
    
    echo "<p>This is printed using PHP's <strong>echo</strong> statement.</p>";


    // 3. DATA TYPES AND VARIABLES
    // Variables in PHP always start with a dollar sign ($).
    // PHP is loosely typed, meaning you don't declare the data type explicitly.

    $greeting = "Hello, learner!";     // String (Text)
    $age = 25;                         // Integer (Whole number)
    $price = 19.99;                    // Float / Double (Decimal number)
    $isLearning = true;                // Boolean (true or false)
    $colors = array("Red", "Green");   // Array (List of items)
    $nothing = null;                   // Null (Represents a variable with no value)

    // Let's use these variables within double quotes (String Interpolation)
    echo "<h3>Variables Output:</h3>";
    echo "<p>$greeting I am $age years old. The price is $price.</p>";

    // You can also concatenate (join) strings using a dot (.)
    echo "<p>" . "Boolean values print as 1 for true: " . $isLearning . "</p>";


    // 4. CONTROL FLOW (if, else, switch)
    // Control flow allows your program to make decisions.
    echo "<h3>Control Flow:</h3>";

    // If-Else Statement
    if ($age >= 18) {
        // This block runs if the condition in the parentheses is true
        echo "<p>Status: You are an adult.</p>";
    } else {
        // This block runs if the condition is false
        echo "<p>Status: You are a minor.</p>";
    }

    // Switch Statement (useful for checking a single variable against many values)
    $dayOfWeek = "Monday";
    switch ($dayOfWeek) {
        case "Monday":
            echo "<p>Today is Monday, let's learn PHP!</p>";
            break; // Stops checking further cases
        case "Friday":
            echo "<p>It's Friday, almost the weekend!</p>";
            break;
        default:
            // Runs if no other case matches
            echo "<p>It's just another day.</p>";
            break;
    }


    // 5. LOOPS (while, do-while, for, foreach)
    // Loops repeat a block of code Multiple times.
    echo "<h3>Loops:</h3>";

    // For Loop: Best when you know exactly how many times to loop.
    // (Initialization; Condition; Increment/Decrement)
    echo "<h4>For Loop (Counting to 3):</h4>";
    echo "<ul>";
    for ($i = 1; $i <= 3; $i++) {
        echo "<li>Iteration number: $i</li>";
    }
    echo "</ul>";

    // While Loop: Best when you want to loop as long as a condition is true.
    echo "<h4>While Loop:</h4>";
    $counter = 3;
    while ($counter > 0) {
        echo "<p>Countdown: $counter...</p>";
        $counter--; // Decrease by 1
    }
    echo "<p>Liftoff! 🚀</p>";

    // Foreach Loop: Specifically designed for iterating over Arrays.
    echo "<h4>Foreach Loop (Iterating over an array):</h4>";
    $fruits = ["Apple", "Banana", "Cherry"]; // Modern syntax for arrays
    
    echo "<ol>";
    foreach ($fruits as $fruit) {
        // This runs once for every item in the $fruits array
        echo "<li>$fruit</li>";
    }
    echo "</ol>";

    ?>
    
</body>
</html>