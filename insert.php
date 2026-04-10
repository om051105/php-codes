<?php
$localhost = "localhost";
$username = "root";
$password = "";
$dbname = "company";

// Connect
$conn = mysqli_connect($localhost, $username, $password);

if (!$conn) {
    die("Connection failed");
}

// Create DB
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS company");

// Select DB
mysqli_select_db($conn, $dbname);

// Create Table
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS employee(
    emp_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    department VARCHAR(50) NOT NULL,
    salary DECIMAL(10,2) NOT NULL
)");

// INSERT DATA
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $department = $_POST['department'];
    $salary = $_POST['salary'];

    $sql = "INSERT INTO employee(name,department,salary)
          VALUES('$name','$department','$salary')";
    echo "data added";
}
?>

<!-- FORM -->
<h2>Add Employee</h2>
<form method="POST">
    Name: <input type="text" name="name" required><br><br>
    Department: <input type="text" name="department" required><br><br>
    Salary: <input type="number" name="salary" required><br><br>
    <input type="submit" name="submit" value="Add Employee">
</form>

<hr>

<!-- DISPLAY DATA -->
<h2>Employee List</h2>
<?php
$result = mysqli_query($conn, "SELECT * FROM employee");
echo "<table border='1'>
        <tr>
            <th>Emp ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Salary</th>
        </tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['emp_id'] . "</td>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['department'] . "</td>";
    echo "<td>" . $row['salary'] . "</td>";
    echo "</tr><br>";
}
?>