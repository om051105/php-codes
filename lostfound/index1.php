<?php
session_start();

// Connect DB
$conn = mysqli_connect("localhost", "root", "");
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS lostfound_db");
mysqli_select_db($conn, "lostfound_db");

// Tables
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50),
    email VARCHAR(100)
)");

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS items(
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('lost','found'),
    item_name VARCHAR(100),
    description TEXT,
    location VARCHAR(100),
    category VARCHAR(50),
    reported_by VARCHAR(50),
    reported_on DATE
)");

// Default admin
$res = mysqli_query($conn, "SELECT * FROM users WHERE username='admin'");
if (mysqli_num_rows($res) == 0) {
    mysqli_query($conn, "INSERT INTO users VALUES(NULL,'admin','admin123','admin@college.com')");
}

// Variables
$page = $_GET['page'] ?? 'login';
$user = $_SESSION['username'] ?? null;
$msg = "";

// Logout
if ($page == 'logout') {
    session_destroy();
    header("Location:?page=login");
    exit;
}

// Page control
if ($user && $page == 'login')
    $page = 'dashboard';
if (!$user && in_array($page, ['dashboard', 'report_lost', 'report_found', 'view']))
    $page = 'login';

// Form handling
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Login
    if ($page == 'login') {
        $q = "SELECT * FROM users WHERE username='{$_POST['username']}' 
              AND password='{$_POST['password']}'";
        $r = mysqli_query($conn, $q);

        if (mysqli_num_rows($r)) {
            $_SESSION['username'] = $_POST['username'];
            header("Location:?page=dashboard");
        } else
            $msg = "Wrong login!";
    }

    // Register
    if ($page == 'register') {
        $u = $_POST['username'];
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$u'");

        if (mysqli_num_rows($check)) {
            $msg = "Username exists!";
        } else {
            mysqli_query($conn, "INSERT INTO users VALUES(NULL,'$u','{$_POST['password']}','{$_POST['email']}')");
            $msg = "Registered!";
        }
    }

    // Report item
    if ($page == 'report_lost' || $page == 'report_found') {
        $type = ($page == 'report_lost') ? 'lost' : 'found';

        mysqli_query($conn, "INSERT INTO items VALUES(NULL,'$type',
            '{$_POST['item_name']}','{$_POST['description']}',
            '{$_POST['location']}','{$_POST['category']}',
            '$user','" . date('Y-m-d') . "')");

        $msg = "Item reported!";
    }
}
?>