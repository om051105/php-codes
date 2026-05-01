<?php
class Student
{
    public $name;
    public $marks;
    public $roll_no;

    function __construct($name, $marks, $roll_no)
    {
        $this->name = $name;
        $this->marks = $marks;
        $this->roll_no = $roll_no;
    }

    function cal_grade()
    {
        if ($this->marks >= 90)
            return "A";
        elseif ($this->marks >= 75)
            return "B";
        elseif ($this->marks >= 50)
            return "C";
        else
            return "Fail";
    }

    function display()
    {
        echo "<br>Result</strong><br>";
        echo "Name: " . $this->name . "<br>";
        echo "Roll No: " . $this->roll_no . "<br>";
        echo "Marks: " . $this->marks . "<br>";
        echo "Grade: " . $this->cal_grade() . "<br>";
    }
}
?>

<form method="POST">
    Name: <input type="text" name="name" required><br><br>
    Roll No: <input type="number" name="roll" required><br><br>
    Marks: <input type="number" name="marks" required><br><br>
    <input type="submit" name="submit" value="Show Result">
</form>

<?php
if (isset($_POST['submit'])) {
    $n = $_POST['name'];
    $r = $_POST['roll'];
    $m = $_POST['marks'];

    $student = new Student($n, $m, $r);
    $student->display();
}
?>