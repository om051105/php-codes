<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>

    <style>
        body {
            font-family: Arial;
            background-color: #1e1212;
            padding: 20px;
        }

        h1 {
            color: red;
            text-align: center;
        }

        /* CENTER FORM */
        form {
            background-color: white;
            padding: 20px;
            max-width: 800px;
            margin: 50px auto;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

<h1>Student Registration Form</h1>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $phone  = $_POST['phone'];
    $course = $_POST['course'];

    echo "<h2 style='color:white; text-align:center;'>Registration Successful!</h2>";
    echo "<p style='color:white; text-align:center;'>Name: $name</p>";
    echo "<p style='color:white; text-align:center;'>Email: $email</p>";
    echo "<p style='color:white; text-align:center;'>Phone: $phone</p>";
    echo "<p style='color:white; text-align:center;'>Course: $course</p>";
} else {
?>

<form method="POST">
    <label>Name:</label>
    <input type="text" name="name" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Phone:</label>
    <input type="text" name="phone" required>

    <label>Course:</label>
    <select name="course" required>
        <option value="">Select Course</option>
        <option value="PHP">PHP</option>
        <option value="Python">Python</option>
        <option value="Java">Java</option>
    </select>

    <button type="submit">Register</button>
</form>

<?php } ?>

</body>
</html>
