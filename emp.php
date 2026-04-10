<?php
// Prevent mysqli from throwing unhandled exceptions
mysqli_report(MYSQLI_REPORT_OFF);
// ============================================================
//  UNIT IV — OOP DEMO (Class, Object, Constructor, Destructor,
//             Inheritance, Properties, Methods)
// ============================================================

// ── Base class (Unit IV: Declaring a Class) ─────────────────
class Person {
    public $name;       // property
    public $email;      // property

    // Constructor — runs automatically when object is created
    public function __construct($name, $email) {
        $this->name  = $name;
        $this->email = $email;
        // echo "Person object created<br>"; // uncomment to see it fire
    }

    // Method — accessing methods
    public function getInfo() {
        return "Name: {$this->name} | Email: {$this->email}";
    }

    // Destructor — runs automatically when object is destroyed
    public function __destruct() {
        // echo "Person object destroyed<br>"; // uncomment to see it fire
    }
}

// ── Derived class (Unit IV: Inheritance) ─────────────────────
class Employee extends Person {
    public $department;  // extra property
    public $salary;      // extra property

    // Constructor overrides parent and calls it
    public function __construct($name, $email, $department, $salary) {
        parent::__construct($name, $email); // call Person constructor
        $this->department = $department;
        $this->salary     = $salary;
    }

    // Extra method in child class
    public function getEmployeeInfo() {
        return $this->getInfo() .
               " | Dept: {$this->department}" .
               " | Salary: ₹{$this->salary}";
    }
}

// ── Creating objects & accessing properties/methods ──────────
$demo = new Employee("Om Joshi", "om@example.com", "IT", 25000);
// $demo->name, $demo->department  ← accessing properties
// $demo->getEmployeeInfo()        ← accessing method


// ============================================================
//  UNIT V — DATABASE OPERATIONS (mysqli)
// ============================================================

// ── 1. Connect to Database ───────────────────────────────────
$conn = @new mysqli("localhost", "root", "", "college");
$db_ok = true;

// ── 2. Check Connection ──────────────────────────────────────
if ($conn->connect_error) {
    // Try to create the database if not found
    $tmp = @new mysqli("localhost", "root", "");
    if (!$tmp->connect_error) {
        $tmp->query("CREATE DATABASE IF NOT EXISTS college");
        $tmp->query("USE college");
        $tmp->query("CREATE TABLE IF NOT EXISTS employee (
            id         INT AUTO_INCREMENT PRIMARY KEY,
            name       VARCHAR(100) NOT NULL,
            email      VARCHAR(100),
            department VARCHAR(50),
            salary     INT
        )");
        $tmp->close();
        // Reconnect
        $conn = new mysqli("localhost", "root", "", "college");
    } else {
        $db_ok = false;
        $message = "<p class='error'>❌ MySQL is not running. Please start XAMPP → Start Apache &amp; MySQL, then refresh this page.</p>";
    }
}

// Ensure table exists
$message = "";
if ($db_ok) {
    $conn->query("CREATE TABLE IF NOT EXISTS employee (
        id         INT AUTO_INCREMENT PRIMARY KEY,
        name       VARCHAR(100) NOT NULL,
        email      VARCHAR(100),
        department VARCHAR(50),
        salary     INT
    )");
}

// ── 3. Handle Form Actions ───────────────────────────────────

// INSERT
if ($db_ok && isset($_POST['action']) && $_POST['action'] === 'insert') {
    $name  = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $dept  = $conn->real_escape_string($_POST['department']);
    $sal   = (int)$_POST['salary'];

    $sql = "INSERT INTO employee (name, email, department, salary)
            VALUES ('$name', '$email', '$dept', $sal)";

    if ($conn->query($sql) === TRUE) {
        $message = "<p class='success'>✅ Employee added successfully! (ID: {$conn->insert_id})</p>";
    } else {
        $message = "<p class='error'>❌ Error: " . $conn->error . "</p>";
    }
}

// DELETE
if ($db_ok && isset($_GET['delete'])) {
    $id  = (int)$_GET['delete'];
    $sql = "DELETE FROM employee WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $message = "<p class='success'>🗑️ Employee deleted.</p>";
    }
}

// FETCH all records
$result = $db_ok ? $conn->query("SELECT * FROM employee") : false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management — PHP OOP + MySQL</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            min-height: 100vh;
            padding: 30px 20px;
        }
        h1 {
            text-align: center;
            font-size: 2rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }
        .subtitle {
            text-align: center;
            color: #94a3b8;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        /* OOP Demo Box */
        .oop-box {
            background: #1e293b;
            border-left: 4px solid #6366f1;
            border-radius: 10px;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto 30px;
        }
        .oop-box h2 { color: #a5b4fc; margin-bottom: 12px; font-size: 1rem; }
        .oop-box p  { color: #cbd5e1; font-size: 0.9rem; margin-bottom: 6px; }
        .badge {
            display: inline-block;
            background: #312e81;
            color: #c7d2fe;
            border-radius: 5px;
            padding: 2px 8px;
            font-size: 0.78rem;
            margin-right: 5px;
        }

        /* Form */
        .form-card {
            background: #1e293b;
            border-radius: 14px;
            padding: 28px;
            max-width: 800px;
            margin: 0 auto 30px;
        }
        .form-card h2 { color: #a5b4fc; margin-bottom: 20px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        label { display: block; font-size: 0.85rem; color: #94a3b8; margin-bottom: 5px; }
        input, select {
            width: 100%;
            padding: 10px 14px;
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 8px;
            color: #e2e8f0;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #6366f1;
        }
        .btn {
            margin-top: 20px;
            padding: 12px 30px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn:hover { opacity: 0.85; }

        /* Messages */
        .success { color: #4ade80; background: #052e16; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; }
        .error   { color: #f87171; background: #450a0a; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; }

        /* Table */
        .table-card {
            background: #1e293b;
            border-radius: 14px;
            padding: 28px;
            max-width: 800px;
            margin: 0 auto;
            overflow-x: auto;
        }
        .table-card h2 { color: #a5b4fc; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th {
            background: #0f172a;
            color: #818cf8;
            padding: 10px 14px;
            text-align: left;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        td { padding: 12px 14px; border-bottom: 1px solid #1e293b; color: #cbd5e1; font-size: 0.9rem; }
        tr:hover td { background: #0f172a; }
        .del-btn {
            color: #f87171;
            text-decoration: none;
            font-size: 0.85rem;
            padding: 4px 10px;
            border: 1px solid #f87171;
            border-radius: 5px;
            transition: background 0.2s;
        }
        .del-btn:hover { background: #f87171; color: #fff; }
        .empty { text-align: center; color: #64748b; padding: 30px; }
    </style>
</head>
<body>

<h1>🏢 Employee Management System</h1>
<p class="subtitle">Unit IV: OOP &nbsp;|&nbsp; Unit V: PHP + MySQL (mysqli)</p>

<!-- ═══════════════════════════════════════════════
     OOP DEMO SECTION (Unit IV)
════════════════════════════════════════════════ -->
<div class="oop-box">
    <h2>🔷 Unit IV — OOP Demo (Class / Object / Inheritance / Constructor)</h2>

    <?php
    // Accessing properties and methods of the Employee object
    echo "<p><span class='badge'>Object</span> \$demo = new Employee(...) created via <strong>__construct()</strong></p>";
    echo "<p><span class='badge'>Property</span> \$demo->name = <strong>{$demo->name}</strong></p>";
    echo "<p><span class='badge'>Property</span> \$demo->department = <strong>{$demo->department}</strong></p>";
    echo "<p><span class='badge'>Method</span> \$demo->getEmployeeInfo() → <strong>" . $demo->getEmployeeInfo() . "</strong></p>";
    echo "<p><span class='badge'>Inheritance</span> Employee <strong>extends</strong> Person — can use Person's getInfo() method.</p>";
    ?>
</div>

<!-- ═══════════════════════════════════════════════
     FORM — INSERT (Unit V: CRUD)
════════════════════════════════════════════════ -->
<div class="form-card">
    <h2>➕ Add New Employee</h2>

    <?php echo $message; ?>

    <form method="POST" action="">
        <input type="hidden" name="action" value="insert">
        <div class="grid-2">
            <div>
                <label>Full Name</label>
                <input type="text" name="name" placeholder="e.g. Rahul Sharma" required>
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" placeholder="e.g. rahul@example.com">
            </div>
            <div>
                <label>Department</label>
                <input type="text" name="department" placeholder="e.g. HR, IT, Finance">
            </div>
            <div>
                <label>Salary (₹)</label>
                <input type="number" name="salary" placeholder="e.g. 35000" min="0">
            </div>
        </div>
        <button class="btn" type="submit">💾 Add Employee</button>
    </form>
</div>

<!-- ═══════════════════════════════════════════════
     TABLE — DISPLAY (Unit V: SELECT)
════════════════════════════════════════════════ -->
<div class="table-card">
    <h2>📋 All Employees</h2>

    <?php if ($result && $result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Salary</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['department']) ?></td>
                <td>₹<?= number_format($row['salary']) ?></td>
                <td>
                    <a class="del-btn"
                       href="?delete=<?= $row['id'] ?>"
                       onclick="return confirm('Delete this employee?')">
                        🗑️ Delete
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p class="empty">No employees found. Add one above! 👆</p>
    <?php endif; ?>
</div>

<?php if ($db_ok) $conn->close(); ?>
</body>
</html>
