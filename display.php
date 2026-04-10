<?php
$conn = new mysqli("localhost", "root", "", "day1");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all students
$sql = "SELECT roll, name FROM student";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<body>
    <h1>Student List</h1>
    <table border="1" cellpadding="10">
        <tr>
            <th>Roll</th>
            <th>Name</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["roll"] . "</td>
                        <td>" . $row["name"] . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No students found</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="connect.php">Add New Student</a>
</body>
</html>

<?php
$conn->close();
?>
