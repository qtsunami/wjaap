<?php


class Singleton {

	// 保存类实例在此属性中
	private static $_instance;

	// 构造方法要声明为private，防止直接实例化对象
	private function __construct(){}



	public static function getInstance () {
		if (!self::$_instance instanceof self) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}


	// 阻止用户复制对象实例
	public function __clone () {
		trigger_error("Clone is not allow！", E_USER_ERROR);
	}


	public function test () {
		echo "test:test";
	}

}


$single = Singleton::getInstance();

$single->test();