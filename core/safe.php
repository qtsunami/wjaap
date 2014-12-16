<?php
header("Content-Type:text/html;charset=utf-8");
Class Encrypt{

	public $letter = 'abcdefghijklmnopqrstuvwxyz';

	public $default = 'zyxwvutsrqponmlkjihgfedcba';
	public function __construct(){}


	public function textual($report){
		if(!$report) return '';
		$new_report = '';
		$len = strlen($report);
		for($i = 0; $i < $len; $i ++){
			$point = strpos($this->letter, $report{$i});
			$new_report .= $this->default{$point};
		}

		return $new_report;
	}


	public function letterAscii($report){
		if (!$report) return array();
		$new_report = array();
		$len = strlen($report);
		for ($i = 0; $i < $len; $i ++){
			$new_report[$i] = ord($report{$i});
		}
		return $new_report;
	}

}


$encrypt = new Encrypt();
$report = 'abcdefg';
$new_report = $encrypt->textual($report);

echo "原文是：" . $report;
echo "<br>密文是：" . $new_report . "<br>";

$ord = $encrypt->letterAscii($report);

echo "<pre>";print_r($ord);
