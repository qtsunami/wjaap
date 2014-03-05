<?php

class String {

	public $opertal = false;
	protected function __construct(){
		
	}

	public static function getInstance(){
		static $instance;
		return $instance ? $instance : ($instance = new self());
	}

	/**
	 * repeat 重复string字符串count次
	 * @param string $string 
	 * @param int $count 重复次数
	 * @return string
	 * @date 2013-11-19
	 * @author 
	 */
	public function repeat($string = null, $count = 5){
		return str_repeat($string, $count);
	}
	/**
	 * randomnum 获取随机数
	 * @param int $length 随机数的长度
	 * @param boolean $open 是否允许以0开始，默认允许
	 * @return string
	 * @date 2013-11-19
	 * @author 
	 */
	public function randomnum($length = 4, $open = true){
		$random = range(0, 9);
		shuffle($random);
		$output = '';
		for($i = 0; $i < $length; $i ++){
			$output .= $random[mt_rand(0, 9)];
		}
		if(!$open && $output{0} == 0){

			$output{0} = mt_rand(1,9);
		}

		return $output;
	}



}