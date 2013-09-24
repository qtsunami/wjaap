<?php

$val['mobile'] = "15210075857";
if ($val['mobile'] && preg_match('/^(((13[0-9]{1})|159|147|((15|18)[0-9]{1}))+\d{8})$/', $val['mobile'])) {
	echo "Ok!Yes";exit();
}


echo "No!";die;


$test = $_GET['imsrc'] && !in_array($_GET['imsrc'], array(91, 123, 345)) ?:123;



echo $test;