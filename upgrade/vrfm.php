<?php


$myfile = $_FILES;

$data = $_POST;
$strage = "./Images/";

$newfile = str_shuffle(time()) . "." . $data['extension'];

$result = move_uploaded_file($myfile['file']['tmp_name'], $strage . $newfile);

if($result){
	file_put_contents('./url.txt', "Success!\r\n", FILE_APPEND);
}else{
	file_put_contents('./url.txt', "Failor!\r\n", FILE_APPEND);
}