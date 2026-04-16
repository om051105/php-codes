<?php
session_start();

/*
|--------------------------------------------------------------------------
| Database setup
|--------------------------------------------------------------------------
| This project uses a very simple MySQL setup so beginners can understand
| how the connection, database, and tables are created.
*/
$conn = mysqli_connect("localhost", "root", "");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS lostfound_db");
mysqli_select_db($conn, "lostfound_db");

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

// Create a demo admin account if it does not exist.
$admin_check = mysqli_query($conn, "SELECT * FROM users WHERE username='admin'");
if (!mysqli_num_rows($admin_check)) {
    mysqli_query(
        $conn,
        "INSERT INTO users (username, password, email)
         VALUES ('admin', 'admin123', 'admin@college.com')"
    );
}

/*
|--------------------------------------------------------------------------
| Page and session values
|--------------------------------------------------------------------------
*/
$page = $_GET["page"] ?? "login";
$message = "";
$username = $_SESSION["username"] ?? null;

/*
|--------------------------------------------------------------------------
| Simple page protection
|--------------------------------------------------------------------------
*/
if ($page == "logout") {
    session_destroy();
    header("Location: ?page=login");
    exit;
}

if ($username && $page == "login") {
    $page = "dashboard";
}

if (
    !$username &&
    in_array($page, ["dashboard", "report_lost", "report_found", "view"])
) {
    $page = "login";
}

/*
|--------------------------------------------------------------------------
| Form handling
|--------------------------------------------------------------------------
*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($page == "login") {
        $input_username = $_POST["username"];
        $input_password = $_POST["password"];

        $login_query = "SELECT * FROM users
                        WHERE username='$input_username'
                        AND password='$input_password'";
        $result = mysqli_query($conn, $login_query);

        if (mysqli_num_rows($result)) {
            $_SESSION["username"] = $input_username;
            header("Location: ?page=dashboard");
            exit;
        } else {
            $message = "<p class='error-box'>Wrong username or password.</p>";
        }
    }

    if ($page == "register") {
        $email = $_POST["email"];
        $new_username = $_POST["username"];
        $new_password = $_POST["password"];

        $check_user = mysqli_query(
            $conn,
            "SELECT * FROM users WHERE username='$new_username'"
        );

        if (mysqli_num_rows($check_user)) {
            $message = "<p class='error-box'>Username already exists.</p>";
        } else {
            mysqli_query(
                $conn,
                "INSERT INTO users (username, password, email)
                 VALUES ('$new_username', '$new_password', '$email')"
            );
            $message = "<p class='success-box'>Registered successfully. <a href='?page=login'>Login here</a></p>";
        }
    }

    if ($page == "report_lost" || $page == "report_found") {
        $type = str_replace("report_", "", $page);
        $item_name = $_POST["item_name"];
        $description = $_POST["description"];
        $location = $_POST["location"];
        $category = $_POST["category"];
        $today = date("Y-m-d");

        mysqli_query(
            $conn,
            "INSERT INTO items (type, item_name, description, location, category, reported_by, reported_on)
             VALUES ('$type', '$item_name', '$description', '$location', '$category', '$username', '$today')"
        );

        $message = "<p class='success-box'>Item reported successfully. <a href='?page=view'>View all items</a></p>";
    }
}

/*
|--------------------------------------------------------------------------
| Dropdown options
|--------------------------------------------------------------------------
*/
$categories = "
    <option>Electronics</option>
    <option>Wallet/Purse</option>
    <option>Books</option>
    <option>Keys</option>
    <option>Bag</option>
    <option>Other</option>
";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Lost and Found Portal</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #eef2f7;
        }

        nav {
            background: #1a1a2e;
            color: white;
            padding: 14px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: #d4d4d4;
            text-decoration: none;
            margin-left: 14px;
            font-size: 14px;
        }

        nav a:hover {
            color: white;
        }

        .logout-btn {
            background: #e74c3c;
            color: white !important;
            padding: 6px 12px;
            border-radius: 5px;
        }

        .box {
            background: white;
            max-width: 450px;
            margin: 55px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
        }

        .box h2 {
            color: #1a1a2e;
            margin-bottom: 6px;
        }

        .box p {
            color: #777;
            font-size: 13px;
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
            font-weight: bold;
            color: #444;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 14px;
            border: 1px solid #ddd;
            border-radius: 7px;
            font-size: 14px;
        }

        textarea {
            min-height: 80px;
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 7px;
            color: white;
            font-size: 15px;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9;
        }

        .btn-blue {
            background: #0288d1;
        }

        .btn-green {
            background: #27ae60;
        }

        .btn-red {
            background: #e74c3c;
        }

        .error-box {
            background: #ffe0e0;
            color: #e74c3c;
            padding: 10px;
            border-radius: 7px;
            margin-bottom: 12px;
            font-size: 13px;
        }

        .success-box {
            background: #e0f9e0;
            color: #27ae60;
            padding: 10px;
            border-radius: 7px;
            margin-bottom: 12px;
            font-size: 13px;
        }

        .wrapper {
            max-width: 950px;
            margin: 35px auto;
            padding: 0 18px;
        }

        .row {
            display: flex;
            gap: 18px;
            margin: 18px 0;
        }

        .stat-box {
            flex: 1;
            background: white;
            padding: 22px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
        }

        .stat-box b {
            font-size: 34px;
        }

        .stat-box small {
            display: block;
            color: #888;
            font-size: 13px;
        }

        .card {
            flex: 1;
            background: white;
            border-radius: 10px;
            padding: 25px 18px;
            text-align: center;
            text-decoration: none;
            color: #1a1a2e;
            border: 2px solid #eee;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
        }

        .card:hover {
            border-color: #0288d1;
        }

        .card b {
            display: block;
            margin-bottom: 5px;
        }

        .card small {
            color: #888;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
        }

        th {
            background: #1a1a2e;
            color: white;
            padding: 12px 13px;
            text-align: left;
            font-size: 13px;
        }

        td {
            padding: 11px 13px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            vertical-align: top;
        }

        .badge-lost {
            background: #ffe0e0;
            color: #e74c3c;
            padding: 3px 9px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-found {
            background: #e0f9e0;
            color: #27ae60;
            padding: 3px 9px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .muted {
            color: #888;
        }

        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            .row {
                flex-direction: column;
            }

            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>

    <?php if ($username): ?>
        <nav>
            <b>Lost and Found Portal</b>
            <div>
                <a href="?page=dashboard">Home</a>
                <a href="?page=report_lost">Report Lost</a>
                <a href="?page=report_found">Report Found</a>
                <a href="?page=view">View Items</a>
                <a href="?page=logout" class="logout-btn">Logout</a>
            </div>
        </nav>
    <?php endif; ?>

    <?php if ($page == "login"): ?>
        <div class="box">
            <h2>Lost and Found Portal</h2>
            <p>Login to continue</p>
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
                |
                Demo login: admin / admin123
            </small>
        </div>

    <?php elseif ($page == "register"): ?>
        <div class="box">
            <h2>Create Account</h2>
            <p>Register a new user</p>
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
        <?php
        $total_items = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM items"))["total"];
        $lost_items = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM items WHERE type='lost'"))["total"];
        $found_items = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM items WHERE type='found'"))["total"];
        ?>

        <div class="wrapper">
            <h2>Welcome, <?= $username ?>!</h2>
            <p class="muted">Manage lost and found reports here.</p>

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
                    <small>I lost something</small>
                </a>
                <a href="?page=report_found" class="card">
                    <b>Report Found Item</b>
                    <small>I found something</small>
                </a>
                <a href="?page=view" class="card">
                    <b>View All Items</b>
                    <small>Check every report</small>
                </a>
            </div>
        </div>

    <?php elseif ($page == "report_lost" || $page == "report_found"): ?>
        <?php
        $title = ($page == "report_lost") ? "Report Lost Item" : "Report Found Item";
        $button_class = ($page == "report_lost") ? "btn-red" : "btn-green";
        $button_text = ($page == "report_lost") ? "Submit Lost Report" : "Submit Found Report";
        $title_color = ($page == "report_lost") ? "#e74c3c" : "#27ae60";
        ?>

        <div class="box" style="max-width:520px;">
            <h2 style="color:<?= $title_color ?>;"><?= $title ?></h2>
            <p>Fill in the item details</p>
            <?= $message ?>

            <form method="POST">
                <label>Item Name</label>
                <input type="text" name="item_name" placeholder="Example: Black Wallet" required>

                <label>Category</label>
                <select name="category">
                    <?= $categories ?>
                </select>

                <label>Location</label>
                <input type="text" name="location" placeholder="Example: Library or Canteen" required>

                <label>Description</label>
                <textarea name="description" placeholder="Write a short description of the item"></textarea>

                <button class="<?= $button_class ?>"><?= $button_text ?></button>
            </form>
        </div>

    <?php elseif ($page == "view"): ?>
        <div class="wrapper">
            <h2>All Reported Items</h2>
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
                    $items_result = mysqli_query($conn, "SELECT * FROM items ORDER BY reported_on DESC");
                    $count = 1;

                    if (mysqli_num_rows($items_result)) {
                        while ($row = mysqli_fetch_assoc($items_result)) {
                            $badge = $row["type"] == "lost"
                                ? "<span class='badge-lost'>Lost</span>"
                                : "<span class='badge-found'>Found</span>";

                            echo "<tr>";
                            echo "<td>" . $count . "</td>";
                            echo "<td>" . $badge . "</td>";
                            echo "<td><b>" . $row["item_name"] . "</b><br><small style='color:#999;'>" . $row["description"] . "</small></td>";
                            echo "<td>" . $row["category"] . "</td>";
                            echo "<td>" . $row["location"] . "</td>";
                            echo "<td>" . $row["reported_by"] . "</td>";
                            echo "<td>" . $row["reported_on"] . "</td>";
                            echo "</tr>";
                            $count++;
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center;padding:25px;color:#999;'>No items reported yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</body>

</html>