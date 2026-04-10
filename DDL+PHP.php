<?php
// STEP 1: CONNECT
$conn = mysqli_connect("localhost", "root", "");

// STEP 2: CREATE DATABASE
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS library_db");

// STEP 3: SELECT DATABASE
mysqli_select_db($conn, "library_db");

// STEP 4: CREATE TABLE
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS library (
    Book_id INT AUTO_INCREMENT PRIMARY KEY,
    Book_name VARCHAR(255),
    Author VARCHAR(255),
    Price FLOAT
)");

// STEP 5: ADD COLUMN (Publisher)
mysqli_query($conn, "ALTER TABLE library ADD Publisher VARCHAR(255)");

// STEP 6: RENAME TABLE
mysqli_query($conn, "RENAME TABLE library TO library_book");

// STEP 7: DELETE COLUMN (Price)
mysqli_query($conn, "ALTER TABLE library_book DROP COLUMN Price");

echo "All operations done successfully!";
?>