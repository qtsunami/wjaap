<?php

include_once "./core/String.php";

$obj = String::getInstance();
$str = 'every day!';
$newStr = $obj->randomnum(4, false);
echo $newStr;
$newStr{0} = 9;
echo "<br>";
echo $newStr;