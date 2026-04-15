<?php
// Connect without DB
$conn = mysqli_connect("localhost", "root", "");

// Create Database
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS student_record1");

// Connect to DB
$conn = mysqli_connect("localhost", "root", "", "student_record1");

// Create Table
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    roll_number INT,
    name VARCHAR(50),
    course VARCHAR(50),
    marks INT
)");

// INSERT
if (isset($_POST['add'])) {
    mysqli_query($conn, "INSERT INTO student(roll_number,name,course,marks)
    VALUES('$_POST[roll_number]','$_POST[name]','$_POST[course]','$_POST[marks]')");
}

// DELETE
if (isset($_POST['delete'])) {
    mysqli_query($conn, "DELETE FROM student WHERE id='$_POST[id]'");
}

// UPDATE
if (isset($_POST['update'])) {
    mysqli_query($conn, "UPDATE student SET
    name='$_POST[name]',
    course='$_POST[course]',
    marks='$_POST[marks]'
    WHERE id='$_POST[id]'");
}
?>

<html>

<body>

    <h2>Add Student</h2>
    <form method="POST">
        Name: <input name="name"><br><br>
        Course: <input name="course"><br><br>
        Marks: <input type="number" name="marks"><br><br>
        <input type="submit" name="add" value="Add">
    </form>

    <hr>

    <h2>Student Records</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Course</th>
            <th>Marks</th>
            <th>Action</th>
        </tr>

        <?php
        $result = mysqli_query($conn, "SELECT * FROM student");

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
    <form method='POST'>
        <td>" . $row['id'] . "<input type='hidden' name='id' value='" . $row['id'] . "'></td>
        <td><input name='name' value='" . $row['name'] . "'></td>
        <td><input name='course' value='" . $row['course'] . "'></td>
        <td><input name='marks' value='" . $row['marks'] . "'></td>

        <td>
            <input type='submit' name='update' value='Update'>
            <input type='submit' name='delete' value='Delete'>
        </td>
    </form>
    </tr>";
        }
        ?>

    </table>

</body>

</html>