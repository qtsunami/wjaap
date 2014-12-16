<?php
header("Content-type: text/html; charset=utf-8");
//引用ip库的文件
include_once('iplimit.class.php');
$iplimit = new iplimit;

//$userip = $_SERVER['HTTP_X_FORWARDED_FOR'];  //网站通过squid等反向代理的情况下使用，否则使用$_SERVER['REMOTE_ADDR']，最完美的办法是使用$iplimit->GetIP()
$userip = $iplimit->GetIP();
$userip = '127.0.0.1';
if($iplimit->setup($userip)){
	echo "国内ip\n";
}else{  
	echo "国外ip\n";
}﻿
?>