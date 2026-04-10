<?php
// STEP 1: CONNECT
$conn = mysqli_connect("localhost", "root", "");

if (!$conn) {
    die("Connection Failed");
}

// STEP 2: CREATE DATABASE
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS student_db");

// STEP 3: SELECT DATABASE
mysqli_select_db($conn, "student_db");

// STEP 4: CREATE TABLE
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    course VARCHAR(50),
    marks INT
)");

// STEP 5: INSERT DATA
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $course = $_POST['course'];
    $marks = $_POST['marks'];

    mysqli_query($conn, "INSERT INTO student (name, course, marks)
                         VALUES ('$name', '$course', '$marks')");

    echo "Data Inserted Successfully<br><br>";
}
?>

<!-- FORM -->
<form method="POST">
    Name: <input type="text" name="name"><br><br>
    Course: <input type="text" name="course"><br><br>
    Marks: <input type="number" name="marks"><br><br>
    <input type="submit" name="submit" value="Add Student">
</form>

<hr>

<h3>Student Records</h3>

<?php
// STEP 6: DISPLAY DATA
$result = mysqli_query($conn, "SELECT * FROM student");

while ($row = mysqli_fetch_assoc($result)) {
    echo "ID: " . $row['id'] . " | ";
    echo "Name: " . $row['name'] . " | ";
    echo "Course: " . $row['course'] . " | ";
    echo "Marks: " . $row['marks'] . "<br>";
}

// STEP 7: DROP TABLE (optional - only if needed)
// mysqli_query($conn, "DROP TABLE student");

mysqli_close($conn);
?>