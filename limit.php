<?php
$strCtrl = '因为你删除的是整个标签的数据，而不是某个分类标签的某个字段。<!--replace-->';

$loopRe = array('test1', 'test2', 'test3', 'test4');

$loopNum = count($loopRe);

for($i = 0; $i < $loopNum; $i ++){
	$strMx = '';
	$strMx = str_replace("<!--replace-->","<span color='red'>".$loopRe[$i]."<span>",$strCtrl);

	echo $strMx . "<br>";
}

echo "Game Over!";
die;
/**
 * 测试手机验证正则
 */
$val['mobile'] = "15210075857";
if ($val['mobile'] && preg_match('/^(((13[0-9]{1})|159|147|((15|18)[0-9]{1}))+\d{8})$/', $val['mobile'])) {
	echo "Ok!Yes";exit();
}


echo "No!";die;


$test = $_GET['imsrc'] && !in_array($_GET['imsrc'], array(91, 123, 345)) ?:123;



echo $test;
