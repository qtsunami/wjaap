<?php
phpinfo();

die;
header('Content-type: image/jpeg');

$image = new Imagick('../xiaoshi.jpg');


var_dump($image);die;
$image->adaptiveBlurImage(5,3);
//$image = file_get_contents('xiaoshi.jpg');
echo $image;



die;
