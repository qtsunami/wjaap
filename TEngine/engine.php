<?php
header("Content-type:text/html;charset=utf-8");


include "./EngineX/EngineX.class.php";
$simple = new EngineX();
// $simple->caching = true;

//定义变量

$web_name = 'Mini Template Test';
$author = 'Terry.xu';
$title = 'Look Here!This is a simple engine';
$content = '看看这里吧~~~';


$simple->assign('web_name', $web_name);
$simple->assign('author', $author);
$simple->assign('title', $title);
$simple->assign('content', $content);

$simple->display("test.tpl");
