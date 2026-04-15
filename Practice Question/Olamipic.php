<?php
$image = imagecreate(331, 152);

// Background
$white = imagecolorallocate($image, 255, 255, 255);

// Colors
$blue = imagecolorallocate($image, 0, 0, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$red = imagecolorallocate($image, 255, 0, 0);
$yellow = imagecolorallocate($image, 255, 204, 0);
$green = imagecolorallocate($image, 0, 128, 0);

imageellipse($image, 70, 60, 80, 80, $blue);
imageellipse($image, 165, 60, 80, 80, $black);
imageellipse($image, 260, 60, 80, 80, $red);
imageellipse($image, 115, 100, 80, 80, $yellow);
imageellipse($image, 215, 100, 80, 80, $green);

// Output
header("Content-Type: image/png");
imagepng($image);
imagedestroy($image);
?>