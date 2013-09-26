<?php
/**
 * @desc 在这犯了个错，本来循环每次想替换<!--replace-->，结果习惯使然，
 * 用了原字符串的变量接收了，结果导致再第二次执行时<!--replace-->已经没有，每次执行的替换语句都是第一次执行出来的结果
 * 所以要用不同于原字符串的变量去接收
 */

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