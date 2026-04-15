<?php
$image = imagecreate(450, 300);
// Colors
$orange = imagecolorallocate($image, 255, 153, 51);
$white = imagecolorallocate($image, 255, 255, 255);
$green = imagecolorallocate($image, 19, 136, 8);
$blue = imagecolorallocate($image, 0, 0, 128);

// Top (Orange)
imagefilledrectangle($image, 0, 0, 450, 100, $orange);

// Middle (White)
imagefilledrectangle($image, 0, 100, 450, 200, $white);

// Bottom (Green)
imagefilledrectangle($image, 0, 200, 450, 300, $green);

// Ashoka Chakra (circle)
imageellipse($image, 225, 150, 80, 80, $blue);

// Output
header("Content-Type: image/png");
imagepng($image);

// Destroy
imagedestroy($image);