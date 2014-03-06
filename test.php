<?php


function microtime_float(){
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}
    $time_start = microtime_float();

echo $time_start;die;
echo date("Ymd");die;

echo date("Y-m-d H:i:s", $time_start);

	die;
	sleep(5);

$time_end = microtime_float();
$time = $time_end - $time_start;

echo "Did nothing in $time seconds\n";


//echo $time;die;
die;
//IP

if (@$HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"])
{
	$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
}
elseif (@$HTTP_SERVER_VARS["HTTP_CLIENT_IP"])
{
	$ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
}
elseif (@$HTTP_SERVER_VARS["REMOTE_ADDR"])
{
	$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
}
elseif (getenv("HTTP_X_FORWARDED_FOR"))
{
	$ip = getenv("HTTP_X_FORWARDED_FOR");
}
elseif (getenv("HTTP_CLIENT_IP"))
{
	$ip = getenv("HTTP_CLIENT_IP");
}
elseif (getenv("REMOTE_ADDR"))
{
	$ip = getenv("REMOTE_ADDR");
}
else
{
	$ip = "Unknown";
}

echo $ip;die;










die;

if(file_exists('./coco.txt')){
	unlink('./coco.txt');
}


for($i = 0; $i < 100000; $i ++){
	file_put_contents("coco.txt", $i+1 . '、' . rand(1000, 1000000) . "Hello World!\r\n", FILE_APPEND);
}


$str = file_get_contents("coco.txt");

$newArr = explode("\r\n", $str);

array_pop($newArr);
echo "<pre>";

print_r($newArr);die;


echo $str;die;


die;
for($i = 0; $i < 500; $i ++){
	file_put_contents("coco.txt", $i+1 . '、' . rand(1000, 1000000) . "Hello World!\r\n", FILE_APPEND);
}
