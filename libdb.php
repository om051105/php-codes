<?php
/**
 * Library Database Connection Script
 */
$host = "localhost";
$user = "root";
$pass = "";
// change this to your library database name
$db   = "library_db"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . " (Make sure 'library_db' exists!)");
}

echo "Successfully connected to the Library Database!";
?>