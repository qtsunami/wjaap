<?php
header('Content-type: text/html; charset=utf-8');
require "core\Mongodb.php";
$dbm = array(
		'host' => 'mongodb://127.0.0.1:27017,127.0.0.1:27018?dbname=tf_article',
		'option' => array('connect'=>true, 'timeout'=>10)
);
$db = Vf_MongoDB::getInstance($dbm);

for($j = 4; $j >= 1; $j --){
    $date = date('Y-m-d', strtotime("-$j day"));
    for($i = 10001; $i < 10999; $i ++){
        $query['_id'] = $i;
        $params = array('$set' => array('recode.'.$date => mt_rand(100, 500)));
        //$db->insert('user_credits', $params);
        $db->update('user_credits', $query, $params, true);
    }
}



