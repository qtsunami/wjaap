<?php

// Cwygh

$temp = "images/5344e43e625f894f070152ba.png";
$info = include 'core/Phpqrcode/qrlib.php';

$fileUrl = "http://manager.open.moxiu.net/package_beisi/5344e43e625f894f070152ba.apk";

$errorCorrectionLevel = 'L';
if (isset($_POST['level']) && in_array($_POST['level'], array('L','M','Q','H'))) {
    $errorCorrectionLevel = $_POST['level'];
}
$matrixPointSize = 4;
if (isset($_POST['size'])) {
    $matrixPointSize = min(max((int) $_POST['size'], 1), 10);
}   
QRcode::png($fileUrl, $temp, $errorCorrectionLevel, $matrixPointSize, 2); 
$content = base64_encode(file_get_contents($temp));
header('Content-Type: image/png');
echo file_get_contents($temp);
//unlink($temp);

