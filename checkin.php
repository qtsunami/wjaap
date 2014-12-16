<?php
header('Content-type: text/html; charset=utf-8');
require "core\Mongodb.php";
$dbm = array(
		'host' => 'mongodb://127.0.0.1:27017,127.0.0.1:27018?dbname=tf_article',
		'option' => array('connect'=>true, 'timeout'=>10)
);
$db = Vf_MongoDB::getInstance($dbm);

if(isset($_GET['act']) && isset($_GET['id'])){
    $tdy = date('Y-m-d');
    $ldy = date('Y-m-d', strtotime('-4 day'));
    $query['_id'] = (int)$_GET['id'];
    $params = array(
        '$inc' => array('recode.' . $tdy=>(int)$_GET['act']),
        '$unset' => array('recode.' . $ldy => 1) 
    );
    $res = $db->collection('user_credits')->update($query, $params, array('upsert'=>true));
    header("Location:./checkin.php");
}

$count = $db->collection('user_credits')->count();

$curpage = $_GET['page'] ? $_GET['page'] : 1;
$totalpage = ceil($count/10);
$prevpage = max(1, $curpage - 1);
$nextpage = min($curpage + 1, $totalpage);
$skip = $prevpage * 10;
$yesDay = date('Y-m-d', strtotime('-1 day'));
//$vf = $db->collection('user_credits')->count();
$query = array();
$field = array('recode');
$topTen = $db->collection('user_credits')->find()->skip($skip)->limit(10)->sort(array('recode.'.$yesDay =>-1));

$stf = "<table border=1 style='width:400px;margin-top:30px;margin-left:200px;' cellspacing=0>";
$stf .= "<tr><th>ID</th><th>Date</th><th>Credits</th><th>Action</th><th>DayNums</th></tr>";
foreach($topTen as $val){
    $stf .= "<tr>";
    $stf .= "<td>{$val['_id']}</td>";
    $stf .= "<td>$yesDay</td>"; 
    $stf .= "<td>{$val['recode'][$yesDay]}</td>"; 
    $stf .= "<td><a href='checkin.php?id={$val['_id']}&act=10'>加十分</a></td>";
    $stf .= "<td>" . count($val['recode']) . "</td>"; 
    $stf .= "</tr>";
}

$stf .= "<tr><td colspan=5><a href='checkin.php?page=$prevpage'>上一页</a>|<a href='checkin.php?page=$nextpage'>下一页</a>  共{$totalpage}页  当前第{$curpage}页</td></tr>";
$stf .= "</table>";

echo $stf;


