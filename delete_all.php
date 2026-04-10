<?php
$conn = new mysqli("localhost", "root", "", "day1");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to delete all data from the table
$sql = "DELETE FROM student";

if ($conn->query($sql) === TRUE) {
    echo "<h1>All records deleted successfully!</h1>";
    echo "<a href='connect.php'>Go back to the form</a>";
} else {
    echo "Error deleting records: " . $conn->error;
}

$conn->close();
?>
