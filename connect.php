<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "day1";
$conn = new mysqli($host, $user, $pass, $db);

if ($_POST) {
    $roll = $_POST['roll'];
    $name = $_POST['name'];
    $query = "INSERT INTO student (roll, name) VALUES ('$roll', '$name')";

    $conn->query($query);
    echo "added";
}
?>
<form method="post">
    Roll: <input name="roll"><br>
    Name: <input name="name">
    <input type="submit" value="Add">
</form>
