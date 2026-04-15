<?php
$conn = mysqli_connect("localhost", "root", "", "TCS");

// Check connection
if (!$conn) {
    die("Connection failed");
}

// Create Table
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS Employee2 (
    emp_id INT AUTO_INCREMENT PRIMARY KEY,
    field VARCHAR(50),
    name VARCHAR(50),
    department VARCHAR(50),
    salary INT,
    city VARCHAR(50)
)");

// INSERT
if (isset($_POST["submit"])) {
    $field = $_POST["field"];
    $name = $_POST["name"];
    $department = $_POST["department"];
    $salary = (int) $_POST["salary"]; // FIX
    $city = $_POST["city"];

    mysqli_query($conn, "INSERT INTO Employee2(field,name,department,salary,city)
    VALUES('$field','$name','$department','$salary','$city')");
}

// DELETE
if (isset($_POST["delete"])) {
    $id = $_POST["delete_id"];
    mysqli_query($conn, "DELETE FROM Employee2 WHERE emp_id='$id'");
}
?>

<html>

<body>

    <h2>Employee Form</h2>

    <form method="POST">
        Field: <input name="field"><br><br>
        Name: <input name="name"><br><br>
        Department: <input name="department"><br><br>
        Salary: <input type="number" name="salary"><br><br> <!-- FIX -->
        City: <input name="city"><br><br>
        <input type="submit" name="submit" value="Insert">
    </form>

    <hr>

    <h2>Delete Employee</h2>
    <form method="POST">
        Enter ID: <input name="delete_id">
        <input type="submit" name="delete" value="Delete">
    </form>

    <hr>

    <h2>Employee Records</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Field</th>
            <th>Name</th>
            <th>Department</th>
            <th>Salary</th>
            <th>City</th>
        </tr>

        <?php
        $result = mysqli_query($conn, "SELECT * FROM Employee2");

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
        <td>" . $row['emp_id'] . "</td>
        <td>" . $row['field'] . "</td>
        <td>" . $row['name'] . "</td>
        <td>" . $row['department'] . "</td>
        <td>" . $row['salary'] . "</td>
        <td>" . $row['city'] . "</td>
    </tr>";
        }
        ?>
    </table>
</body>

</html>