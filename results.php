<?php
/**
 * Student Result Management System (Pure PHP Version)
 */

class result {
    public $name;
    public $roll;
    public $marks;

    function display(){
        echo "Name: " . $this->name . PHP_EOL;
        echo "Roll: " . $this->roll . PHP_EOL;
        echo "Marks: " . $this->marks . PHP_EOL . PHP_EOL;
    }
}

// Data for 5 students
$students_data = [
    ["Rahul Kumar", 101, 90],
    ["Sneha Singh", 102, 95],
    ["Amit Sharma", 103, 75],
    ["Priya Verma", 104, 65],
    ["Vikram Raj", 105, 55]
];

echo "--- Student Result Records ---" . PHP_EOL . PHP_EOL;

foreach ($students_data as $data) {
    $student = new result();
    $student->name = $data[0];
    $student->roll = $data[1];
    $student->marks = $data[2];
    $student->display();
}
?>



