<?php
// STEP 1: CONNECT TO MYSQL
$conn = new mysqli("localhost", "root", "");

// CHECK CONNECTION
if ($conn->connect_error) {
    die("Connection Failed");
}

// STEP 2: CREATE DATABASE
$conn->query("CREATE DATABASE IF NOT EXISTS company");

// SELECT DATABASE
$conn->select_db("company");

// STEP 3: CREATE TABLE
$conn->query("CREATE TABLE IF NOT EXISTS employee (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    department VARCHAR(50),
    salary INT
)");

// STEP 4: INSERT DATA
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $dept = $_POST['department'];
    $salary = $_POST['salary'];

    $conn->query("INSERT INTO employee (name, department, salary)
                  VALUES ('$name', '$dept', '$salary')");

    echo "Data Inserted Successfully<br><br>";
}
?>

<!-- FORM -->
<form method="POST">
    Name: <input type="text" name="name"><br><br>
    Department: <input type="text" name="department"><br><br>
    Salary: <input type="number" name="salary"><br><br>
    <input type="submit" name="submit" value="Add Employee">
</form>
$conn->close();
?>