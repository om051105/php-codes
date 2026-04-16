<?php
session_start();

/*
|--------------------------------------------------------------------------
| PHP GRAPHICS ENGINE (GD Library)
|--------------------------------------------------------------------------
*/
if (isset($_GET['draw_badge'])) {
    $type = $_GET['type'] ?? 'lost';
    $text = strtoupper($type);
    $scale = isset($_GET['scale']) ? (float) $_GET['scale'] : 1.0;

    // 1. Creating the image (drawing a canvas)
    $img = imagecreatetruecolor(120, 30);

    // 2. Color handling
    $white = imagecolorallocate($img, 255, 255, 255);
    $red = imagecolorallocate($img, 220, 53, 69);
    $green = imagecolorallocate($img, 40, 167, 69);
    $bg_color = ($type == 'lost') ? $red : $green;

    // 3. Drawing a filled rectangle
    imagefilledrectangle($img, 0, 0, 120, 30, $bg_color);

    // 4. Writing text on the image
    imagestring($img, 4, 15, 7, $text, $white);

    // 5. Scaling the image (Demonstration)
    if ($scale != 1.0) {
        $new_w = 120 * $scale;
        $new_h = 30 * $scale;
        $img = imagescale($img, $new_w, $new_h);
    }

    // 6. Output the image as PNG
    header('Content-Type: image/png');
    imagepng($img);
    imagedestroy($img);
    exit;
}

/*
|--------------------------------------------------------------------------
| Lost and Found Portal - SINGLE FILE CONFIGURATION
|--------------------------------------------------------------------------
*/

// 1. DATABASE CONFIGURATION (XAMPP Default)
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "lostfound_db";

class Item
{
    public $name;
    public $category;
    public $location;

    public function __construct($name, $category, $location)
    {
        $this->name = $name;
        $this->category = $category;
        $this->location = $location;
    }

    public function getShortLabel()
    {
        return $this->name . " - " . $this->category;
    }

    public function __destruct()
    {
    }
}

function connectDatabase($host, $user, $pass, $db)
{
    $conn = mysqli_connect($host, $user, $pass);

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS $db");
    mysqli_select_db($conn, $db);

    return $conn;
}

function createTables($conn)
{
    mysqli_query(
        $conn,
        "CREATE TABLE IF NOT EXISTS users (
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(50),
password VARCHAR(50),
email VARCHAR(100)
)"
    );

    mysqli_query(
        $conn,
        "CREATE TABLE IF NOT EXISTS items (
id INT AUTO_INCREMENT PRIMARY KEY,
type ENUM('lost','found'),
item_name VARCHAR(100),
description TEXT,
location VARCHAR(100),
category VARCHAR(50),
reported_by VARCHAR(50),
reported_on DATE
)"
    );
}

function createDefaultAdmin($conn)
{
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='admin'");
    if (!mysqli_num_rows($check)) {
        mysqli_query($conn, "INSERT INTO users (username, password, email) VALUES ('admin', 'admin123', 'admin@college.com')");
    }
}

function getCategories()
{
    return ["Electronics", "Wallet/Purse", "Books", "Keys", "Bag", "Other"];
}

function getNavigationLinks()
{
    return [
        "dashboard" => "Home"
    ];
}

function cleanText($conn, $text)
{
    $text = trim($text);
    return mysqli_real_escape_string($conn, $text);
}

function makeTitle($page)
{
    $page = str_replace("_", " ", $page);
    return ucwords($page);
}

function loginUser($conn, $username, $password)
{
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    return mysqli_query($conn, $query);
}

function registerUser($conn, $email, $username, $password)
{
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

    if (mysqli_num_rows($check)) {
        return false;
    }

    mysqli_query(
        $conn,
        "INSERT INTO users (username, password, email)
VALUES ('$username', '$password', '$email')"
    );

    return true;
}

function reportItem($conn, $type, $item_name, $description, $location, $category, $reported_by)
{
    $today = date("Y-m-d");

    mysqli_query(
        $conn,
        "INSERT INTO items (type, item_name, description, location, category, reported_by, reported_on)
VALUES ('$type', '$item_name', '$description', '$location', '$category', '$reported_by', '$today')"
    );
}

function countItemsByType($conn, $type = "")
{
    if ($type == "") {
        $query = "SELECT COUNT(*) AS total FROM items";
    } else {
        $query = "SELECT COUNT(*) AS total FROM items WHERE type='$type'";
    }

    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["total"];
}

function fetchAllItems($conn)
{
    return mysqli_query($conn, "SELECT * FROM items ORDER BY reported_on DESC, id DESC");
}

function buildOptions($items)
{
    $html = "";

    foreach ($items as $item) {
        $html .= "<option value='" . $item . "'>" . $item . "</option>";
    }

    return $html;
}

$conn = connectDatabase($db_host, $db_user, $db_pass, $db_name);
createTables($conn);
createDefaultAdmin($conn);

$categories = getCategories();
$nav_links = getNavigationLinks();
$category_options = buildOptions($categories);

$page = $_GET["page"] ?? "login";
$message = "";
$username = $_SESSION["username"] ?? null;
$page_heading = makeTitle($page);

if ($page == "logout") {
    session_destroy();
    header("Location: ?page=login");
    exit;
}

if ($username && $page == "login") {
    $page = "dashboard";
    $page_heading = makeTitle($page);
}

if (!$username && in_array($page, ["dashboard", "report_lost", "report_found", "view"])) {
    $page = "login";
    $page_heading = makeTitle($page);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($page == "login") {
        $input_username = cleanText($conn, $_POST["username"]);
        $input_password = cleanText($conn, $_POST["password"]);

        $result = loginUser($conn, $input_username, $input_password);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION["username"] = $input_username;
            header("Location: ?page=dashboard");
            exit;
        } else {
            $message = "<p class='error-box'>Wrong username or password.</p>";
        }
    }

    if ($page == "register") {
        $email = cleanText($conn, $_POST["email"]);
        $new_username = cleanText($conn, $_POST["username"]);
        $new_password = cleanText($conn, $_POST["password"]);

        if (registerUser($conn, $email, $new_username, $new_password)) {
            $message = "<p class='success-box'>Registration successful. <a href='?page=login'>Login now</a></p>";
        } else {
            $message = "<p class='error-box'>Username already exists.</p>";
        }
    }

    if ($page == "report_lost" || $page == "report_found") {
        $type = str_replace("report_", "", $page);
        $item_name = cleanText($conn, $_POST["item_name"]);
        $description = cleanText($conn, $_POST["description"]);
        $location = cleanText($conn, $_POST["location"]);
        $category = cleanText($conn, $_POST["category"]);

        $item_object = new Item($item_name, $category, $location);
        $item_label = $item_object->getShortLabel();

        reportItem($conn, $type, $item_name, $description, $location, $category, $username);

        $message = "<p class='success-box'>Report submitted for: " . $item_label . ". <a href='?page=view'>View all items</a>
</p>";
    }
}

$total_items = countItemsByType($conn);
$lost_items = countItemsByType($conn, "lost");
$found_items = countItemsByType($conn, "found");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Lost and Found Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
        }

        nav {
            background: #333;
            color: #fff;
            padding: 15px;
            display: flex;
            justify-content: space-between;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 15px;
        }

        .wrapper {
            max-width: 900px;
            margin: 20px auto;
            padding: 0 10px;
        }

        .box {
            background: #fff;
            padding: 25px;
            margin: 40px auto;
            max-width: 500px;
            border: 1px solid #ddd;
        }

        .stat-box,
        .card {
            background: #fff;
            padding: 25px;
            border: 1px solid #ddd;
            flex: 1;
            text-align: center;
            text-decoration: none;
            color: #333;
            transition: 0.3s;
        }

        .card:hover {
            border-color: #007bff;
            background: #fcfcfc;
            transform: translateY(-3px);
        }

        .card b {
            display: block;
            font-size: 18px;
            color: #007bff;
            margin-bottom: 8px;
        }

        .btn-green-text {
            color: #28a745 !important;
        }

        .btn-purple-text {
            color: #6f42c1 !important;
        }

        .row {
            display: flex;
            gap: 15px;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f8f8f8;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            color: #fff;
            cursor: pointer;
        }

        .badge-lost {
            color: #d9534f;
            font-weight: bold;
        }

        .badge-found {
            color: #5cb85c;
            font-weight: bold;
        }

        .btn-blue {
            background: #007bff;
        }

        .btn-green {
            background: #28a745;
        }

        .btn-red {
            background: #dc3545;
        }

        .error-box {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
        }

        .badge-img {
            height: 25px;
            vertical-align: middle;
            border-radius: 4px;
        }

        .graphics-demo {
            background: #fff;
            padding: 20px;
            margin-top: 30px;
            border-top: 2px solid #007bff;
        }

        @media (max-width: 600px) {
            .row {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <?php if ($username): ?>
        <nav>
            <b>Lost and Found Portal</b>
            <div>
                <?php foreach ($nav_links as $link_page => $link_text): ?>
                    <a href="?page=<?= $link_page ?>"><?= $link_text ?></a>
                <?php endforeach; ?>
                <a href="?page=logout" class="logout-btn">Logout</a>
            </div>
        </nav>
    <?php endif; ?>

    <?php if ($page == "login"): ?>
        <div class="box">
            <h2>Lost and Found Portal</h2>
            <p>Login to your account</p>
            <?= $message ?>

            <form method="POST">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter username" required>

                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password" required>

                <button class="btn-blue">Login</button>
            </form>

            <br>
            <small>
                <a href="?page=register">No account? Register</a>
            </small>
        </div>

    <?php elseif ($page == "register"): ?>
        <div class="box">
            <h2><?= $page_heading ?></h2>
            <p>Create a new user account.</p>
            <?= $message ?>

            <form method="POST">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter email" required>

                <label>Username</label>
                <input type="text" name="username" placeholder="Choose username" required>

                <label>Password</label>
                <input type="password" name="password" placeholder="Choose password" required>

                <button class="btn-green">Register</button>
            </form>

            <br>
            <small><a href="?page=login">Already have an account?</a></small>
        </div>

    <?php elseif ($page == "dashboard"): ?>
        <div class="wrapper">
            <div class="heading">
                <h2>Welcome, <?= $username ?>!</h2>
                <p class="muted">Manage lost and found items.</p>
            </div>

            <div class="row">
                <div class="stat-box">
                    <b style="color:#0288d1"><?= $total_items ?></b>
                    <small>Total Items</small>
                </div>
                <div class="stat-box">
                    <b style="color:#e74c3c"><?= $lost_items ?></b>
                    <small>Lost Items</small>
                </div>
                <div class="stat-box">
                    <b style="color:#27ae60"><?= $found_items ?></b>
                    <small>Found Items</small>
                </div>
            </div>

            <div class="row">
                <a href="?page=report_lost" class="card">
                    <b>Report Lost Item</b>
                </a>
                <a href="?page=report_found" class="card">
                    <b class="btn-green-text">Report Found Item</b>
                </a>
                <a href="?page=view" class="card">
                    <b class="btn-purple-text">View All Items</b>
                </a>
            </div>
        </div>

    <?php elseif ($page == "report_lost" || $page == "report_found"): ?>
        <?php
        $title = ($page == "report_lost") ? "Report Lost Item" : "Report Found Item";
        $button_class = ($page == "report_lost") ? "btn-red" : "btn-green";
        ?>

        <div class="box" style="max-width:520px;">
            <h2><?= $title ?></h2>
            <p>Fill in details of the item</p>
            <?= $message ?>

            <form method="POST">
                <label>Item Name</label>
                <input type="text" name="item_name" placeholder="Example: Black Wallet" required>

                <label>Category</label>
                <select name="category">
                    <?= $category_options ?>
                </select>

                <label>Location</label>
                <input type="text" name="location" placeholder="Example: Library" required>

                <label>Description</label>
                <textarea name="description" placeholder="Write a short description"></textarea>

                <button class="<?= $button_class ?>">Submit Report</button>
            </form>
        </div>

    <?php elseif ($page == "view"): ?>
        <div class="wrapper">
            <div class="heading">
                <h2><?= $page_heading ?></h2>
                <p class="muted">View all reported items.</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Reported By</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $items_result = fetchAllItems($conn);
                    $count = 1;

                    if (mysqli_num_rows($items_result) > 0) {
                        while ($row = mysqli_fetch_assoc($items_result)) {
                            $badge_url = "?draw_badge=1&type=" . $row["type"];
                            echo "<tr>";
                            echo "<td>" . $count . "</td>";
                            echo "<td><img src='$badge_url' class='badge-img' alt='Badge'></td>";
                            echo "<td><b>" . $row["item_name"] . "</b><br><small class='muted'>" . $row["description"] . "</small></td>";
                            echo "<td>" . $row["category"] . "</td>";
                            echo "<td>" . $row["location"] . "</td>";
                            echo "<td>" . $row["reported_by"] . "</td>";
                            echo "<td>" . $row["reported_on"] . "</td>";
                            echo "</tr>";
                            $count++;
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center;padding:25px;color:#777;'>No items reported yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php endif; ?>

</body>

</html>