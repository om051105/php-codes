<?php
$conn = mysqli_connect("localhost", "root", "", "library1");

// RESET TABLE (optional but best for now)
mysqli_query($conn, "DROP TABLE IF EXISTS student");

// CREATE TABLE
mysqli_query($conn, "CREATE TABLE student(
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(50),
sem VARCHAR(20),
email VARCHAR(50)
)");

// INSERT
if (isset($_POST['submit'])) {
    mysqli_query($conn, "INSERT INTO student(name, sem, email)
    VALUES('$_POST[name]','$_POST[sem]','$_POST[email]')");
}

// DELETE
if (isset($_POST['delete'])) {
    mysqli_query($conn, "DELETE FROM student WHERE id='$_POST[delete_id]'");
}

// DISPLAY
$result = mysqli_query($conn, "SELECT * FROM student");

echo "<h3>Students:</h3>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "$row[id] | $row[name] | $row[sem] | $row[email] <br>";
}
?>

<html>

<body>

    <form method="POST">
        Name: <input name="name"><br>
        Sem: <input name="sem"><br>
        Email: <input name="email"><br>
        <input type="submit" name="submit" value="Insert">
    </form>

    <br>

    <form method="POST">
        ID: <input name="delete_id"><br>
        <input type="submit" name="delete" value="Delete">
    </form>

</body>

</html>