<?php
function fact($n)
{
    if ($n == 0 || $n == 1)
        return 1;
    else
        return $n * fact($n - 1);
}
$num = 5;
echo "factorial is " . fact($num);
?>