<?php

$str = "所谓-56256@moxiu.net";

$result = preg_match('/moxiu\.net/', $str);


var_dump($result);





die;
#NO.1

/**
 *	fopen 中文名字file，转码
 */
$pathname = './中文试试.txt';
$pathname = iconv("UTF-8", "gb2312", $pathname);
$handle = fopen($pathname, 'r');
$data = '';
while(!feof($handle)){
	$data.=fread($handle, 1024);
}


echo $pathname = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $data);
die;

$array = array(array('主题管家项目组', '下载转化率≥运营实际完成比例+20%,完成图标套数≥14套','下载转化率≥40%,完成图标套数≥14套'));

//$array[0][2] = '下载转化率≥运营实际完成比例+<em>20%</em>,完成图标套数≥<em>14</em>套';

foreach($array as $key=>&$value){
	//$value[1] = str_replace('+20%', '<em>+20%</em>', $value[1]);

	$value[1] = preg_replace('/(\d+%?)/', '<em>$1</em>', $value[1]);
}

echo $array[0][1];
