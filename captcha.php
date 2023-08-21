<?php

session_start();

$length_of_string = 5;

// random alphanum for captcha
$captcha = substr(bin2hex(random_bytes($length_of_string)), 0, $length_of_string);
  
// The captcha will be stored
// for the session
$_SESSION["captcha"] = $captcha; 

$ih = 50;
$iw = 30;
  
// 50x24 standard captcha image
$im = imagecreatetruecolor($ih, $iw); 
 
// random fg color
$fg = imagecolorallocate($im, rand(0, 70), rand(0, 70), rand(0, 70));
 
// random fbg color
$bg = imagecolorallocate($im, rand(185, 255), rand(185, 255), rand(185, 255));
  
// image color fill
imagefill($im, 0, 0, $bg);
  
// Print the captcha text in the image
// with random position & size
imagestring($im, rand(3, 5), rand(0, 7), rand(0, 7),  $captcha, $fg);

// VERY IMPORTANT: Prevent any Browser Cache!!
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
  
// The PHP-file will be rendered as image
header('Content-type: image/png');
  
// Finally output the captcha as
// PNG image the browser
imagepng($im);
 
// Free memory
imagedestroy($im);
