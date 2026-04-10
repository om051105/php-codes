<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "college";

$conn = mysqli_connect($host, $user, $pass, $db);

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    course VARCHAR(50),
    marks INT
)");

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $course = $_POST['course'];
    $marks = $_POST['marks'];
    mysqli_query($conn, "INSERT INTO student (name, course, marks)
    VALUES ('$name', '$course', '$marks')");
    echo "Data added";
}
?>
<html>

<body>
    <h2>Student Form</h2>
    <form method="post">
        Name: <input type="text" name="name"><br><br>
        Course: <input type="text" name="course"><br><br>
        Marks: <input type="number" name="marks"><br><br>
        <input type="submit" name="add" value="Add">
    </form>
</body>

</html>