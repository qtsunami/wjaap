<?php
header('Content-type: text/html; charset=utf-8');
require "core\Mongodb.php";
$dbm = array(
		'host' => 'mongodb://127.0.0.1:27017?dbname=mx_ucenter',
		'option' => array('connect'=>true, 'timeout'=>10)
);
$db = Vf_MongoDB::getInstance($dbm);
for($i = 1; $i < 100000; $i++){
    $data = array('username'=>'UnitTest_'.$i);
    $data['age'] = rand(20, 48);
    $data['is_share'] = rand(0,1);
    $data['ctime'] = time();
    $db->insert('user_profile', $data);
}


