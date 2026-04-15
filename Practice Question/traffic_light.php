<?php
$image = imagecreate(200, 600);

// Background color (FIRST)
$white = imagecolorallocate($image, 255, 255, 255);

// Other colors
$green = imagecolorallocate($image, 76, 153, 0);
$yellow = imagecolorallocate($image, 255, 255, 0);
$red = imagecolorallocate($image, 255, 0, 0);

// Circles
imagefilledellipse($image, 100, 100, 100, 100, $red);
imagefilledellipse($image, 100, 250, 100, 100, $yellow);
imagefilledellipse($image, 100, 400, 100, 100, $green);

// Output
header("Content-Type: image/png");
imagepng($image);

// Destroy
imagedestroy($image);
?>