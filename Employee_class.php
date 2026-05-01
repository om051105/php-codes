<?php
class employee
{
    public $name;
    public $salary;
    public $department;

    function __construct($name, $salary, $department)
    {
        $this->name = $name;
        $this->salary = $salary;
        $this->department = $department;
    }

    function display()
    {
        echo "<br><b>Employee Details</b><br>";
        echo "Name: " . $this->name . "<br>";
        echo "Salary: " . $this->salary . "<br>";
        echo "Department: " . $this->department . "<br>";
    }

    function Cal_annual_salary()
    {
        return $this->salary * 12;
    }
    function Cal_tax()
    {
        return $this->salary * 0.2;
    }
}
?>

<form method="POST">
    Name: <input type="text" name="name" required><br><br>
    Salary: <input type="number" name="salary" required><br><br>
    Department: <input type="text" name="department" required><br><br>
    Tax:<input type="number" name="tax" required><br><br>
    <input type="submit" name="submit" value="Show Result">
</form>

<?php
if (isset($_POST['submit'])) {
    $n = $_POST['name'];
    $s = $_POST['salary'];
    $d = $_POST['department'];
    $t = $_POST['tax'];

    $emp = new employee($n, $s, $d);
    $emp->display();
    echo "Annual Salary: " . $emp->Cal_annual_salary() . "<br>";
    echo "Tax: " . $emp->Cal_tax() . "<br>";
}
?>