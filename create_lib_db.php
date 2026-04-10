<?php
$conn = new mysqli("localhost", "root", "");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 1. Create the database
$sql = "CREATE DATABASE IF NOT EXISTS library_db";
if ($conn->query($sql) === TRUE) {
    echo "Database 'library_db' created successfully!<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// 2. Select the database
$conn->select_db("library_db");

// 3. Create a sample table
$table_sql = "CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100),
    year INT
)";

if ($conn->query($table_sql) === TRUE) {
    echo "Table 'books' created successfully!<br>";
    echo "<br><a href='libdb.php'>Now click here to test libdb.php</a>";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>