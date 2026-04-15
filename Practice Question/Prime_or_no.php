<?php
$result = "";

if (isset($_POST['submit'])) {
    $num = $_POST['num'];

    // Natural Check
    if ($num >= 1) {
        $result .= "$num is a Natural Number <br>";
    } else {
        $result .= "$num is NOT a Natural Number <br>";
    }

    // Prime Check
    $flag = 1;

    if ($num <= 1) {
        $result .= "$num is Not Prime";
    } else {
        for ($i = 2; $i < $num; $i++) {
            if ($num % $i == 0) {
                $flag = 0;
                break;
            }
        }

        if ($flag == 1) {
            $result .= "$num is Prime";
        } else {
            $result .= "$num is Not Prime";
        }
    }
}
?>

<html>

<body>

    <form method="POST">
        Enter Number: <input type="number" name="num">
        <input type="submit" name="submit" value="Check">
    </form>

    <br>

    <?php
    echo $result;
    ?>

</body>

</html>