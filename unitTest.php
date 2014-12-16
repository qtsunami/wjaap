<?php
header('Content-type: text/html; charset=utf-8');
require "core\Mongodb.php";
$dbm = array(
		'host' => 'mongodb://127.0.0.1:27017,127.0.0.1:27018?dbname=mx_ucenter',
		'option' => array('connect'=>true, 'timeout'=>10)
);
$db = Vf_MongoDB::getInstance($dbm);
$query = array('date' => date('Y-m'));
$collection = 'user_day_recode';
$result = $db->getAll($collection, $query);

$dataKey = array('积分', '首个主题', 'Mo友', '评论', '分享', '四星以上主题');

$today = new DateTime(date('Y-m-d'));
$Ma = new DateTime('2014-03-03');
$intval = $today->diff($Ma);
$diff = $intval->format("%a");

//$today = date('Y-m-d', strtotime('-1 day'));
$total = array();
for($i = 1; $i <= $diff; $i ++){
    $today = date('Y-m-d', strtotime("-$i day"));
    $dataCollection = array(
		'tcredits' => 0,
		'first' => 0,
		'monum' => 0,
		'cmtnums' => 0,
		'sharenums' => 0,
		'thmnums' => 0
    );
    foreach($result as $key=>$value){
        $info = $value['recode'][$today];
        if(!isset($info)) continue;
        isset($info['tcredits']) && $dataCollection['tcredits'] += $info['tcredits'];
        isset($info['sharenums']) && $dataCollection['sharenums'] += $info['sharenums'];
        isset($info['cmtnums']) && $dataCollection['cmtnums'] += $info['cmtnums'];
        isset($info['thmnums']) && $dataCollection['thmnums'] += $info['thmnums'];
        isset($info['monum']) && $dataCollection['monum'] += $info['monum'];
        isset($info['first']) && $dataCollection['first'] += $info['first'];
    }
    //$result1 = array_combine($dataKey, $dataCollection);
    $result1 = $dataCollection;
    //var_dump($result1);die;
    array_unshift($result1, $today);
    $total[] = $result1;
}
//echo "<pre>";
//print_r($total);
//die;
echo "<table border=1 style='border-spacing:0;border:1px solid #eee'>";
echo "<tr>";
echo "<th>日期</th>";
echo "<th>总积分</th>";
echo "<th>首次发布主题</th>";
echo "<th>Mo友</th>";
echo "<th>评论数</th>";
echo "<th>分享数</th>";
echo "<th>四星主题以上数量</th>";

echo "<tr>";
foreach($total as $k=>$v){
    echo "<tr>";
    echo "<td>{$v[0]}</td><td>{$v['tcredits']}</td><td>{$v['first']}</td><td>{$v['monum']}</td>"; 
    echo "<td>{$v['cmtnums']}</td><td>{$v['sharenums']}</td><td>{$v['thmnums']}</td>"; 
    echo "</tr>";   
}

echo "</table>";


