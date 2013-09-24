<?php


echo date("Y-m-d H:i:s", 1374200233);die;

echo strtotime("2013-06-01");
echo "<hr>";
echo strtotime("2013-07-01");
echo "<hr>";
echo time();
die;




die;
$fp = opendir(__DIR__);

/* 这是正确地遍历目录方法 */
	while (false !== ($file = readdir($fp))) {
		echo "$file \r\n";
	}




die;
echo __DIR__;die;

die;
$mongo = new Mongo();
$db = $mongo->mx_theme;


$all = $db->theme_album->find(array("themenum"=>array('$gt'=>0)))->limit(100);

echo "<pre>";

foreach($all as $album){

	var_dump(is_array($album['theme_list']));die;
}



































//print_r((array)$all);die;
echo "<pre>";
print_r(iterator_to_array($all));die;



$al = $db->theme_album->count(array('uid'=>50045));

echo memory_get_usage().'<br>';

foreach( $all as $key=>$value){
	$st = array();
	$st['id'] = $value['_id'];
	$st['uid'] = $value['uid'];
	$sts[] = $st;
}
echo '<br>';
echo memory_get_usage() . '<br>';
unset($sts, $st, $all, $al);
echo memory_get_usage();
die;

echo microtime();
echo '<br>';
echo time();
die;


function microtime_float(){
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}
//$mongo = new Mongo("mongodb://127.0.0.1:27017?dbname=cnblog"); 
$mongo = new Mongo();
$db = $mongo->cnblog;
$id = array('_id'=>new MongoId('51b990a73ce5e0000b080437'));
//$all = $db->auth_user->findOne(array('username'=>'Joven'));
//$db->auth_user->update(array('username'=>'Joven_1'), array('username'=>'Joven_1' ,'num'=>1290, 'age'=>29, 'date'=>'20130708'), true);
//var_dump($all);
//die;
$start_time = microtime_float();
for($i = 1; $i <= 10000; $i ++){
	$user = array('username' => 'Joven_' . $i, 'num'=>mt_rand(10, 9000), 'age'=>mt_rand(18, 39), 'date'=>date("Ymd"), 'total'=>mt_rand(400, 655));
	$db->auth_user->insert($user);
}

$end_time = microtime_float();

echo "<pre>";
echo $end_time - $start_time;die;
print_r($user);


die;
$params = array();

$params['username'] = 'Joven';
$params['num'] = (double)1600;
$params['age'] = (double)24;


$db->auth_user->update(array('username'=>'Joven'), $params, true);

echo "Success";

die;
$start = microtime_float();

$a = iterator_to_array($all);

for($i = 0; $i < 10000; $i ++){
$end = microtime_float();
}




echo $end - $start;

die;

var_dump($all);
var_dump(empty($a));die;




/*
function microtime_float(){
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}
*/









die;
$db->auth_user->insert($id);

die;
$arr = array();
foreach($all as $key=>$value){
	//$arr['id'] = $value['_id'];
//	$arr['username'] = $value['username'];
//	$arr['second'] = $value['second'];
	if('51b990a75ce5e0000b000007' == $value['_id']){
		echo 111;die;
	}
}
print_r($all);die;






























die;
$arr = array('no'=>'你好','ko'=>'呵可');

echo json_encode($arr);



die;
echo 'Hello World';


echo '你好';


