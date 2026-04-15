<?php
$image = imagecreate(500, 600);

$orange = imagecolorallocate($image, 255, 128, 0);
$white = imagecolorallocate($image, 255, 255, 255);
$green = imagecolorallocate($image, 76, 153, 0);
$blue = imagecolorallocate($image, 0, 0, 255);

// Flag strips
imagefilledrectangle($image, 0, 0, 500, 200, $orange);
imagefilledrectangle($image, 0, 200, 500, 400, $white);
imagefilledrectangle($image, 0, 400, 500, 600, $green);

// 
imagefilledellipse($image, 250, 300, 100, 100, $blue);

// Output
header("Content-Type: image/png");
imagepng($image);

// Destroy
imagedestroy($image);
?>