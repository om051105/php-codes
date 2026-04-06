<?php
$host = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, "test"); // no variable used

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE BCA (roll INT(2), name VARCHAR(10))";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
}
else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>