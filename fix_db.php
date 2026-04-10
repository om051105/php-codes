<?php
$conn = new mysqli("localhost", "root", "", "day1");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to fix the table structure
$sql = "ALTER TABLE student 
        MODIFY roll VARCHAR(20), 
        MODIFY name VARCHAR(50)";

if ($conn->query($sql) === TRUE) {
    echo "<h1>Database structure fixed successfully!</h1>";
    echo "<p>Now your 'roll' can be long and your 'name' can be text.</p>";
    echo "<a href='connect.php'>Go back to the form</a>";
}
else {
    echo "Error fixing database: " . $conn->error;
}

$conn->close();
?>

$fix_sql = "ALTER TABLE student MODIFY roll VARCHAR(20), MODIFY name VARCHAR(50)";
$conn->query($fix_sql);

