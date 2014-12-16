<?php
ini_set('display_errors', "on");
error_reporting(E_ALL);

class RedisDb extends Redis {
	
	/**
	 * 对象变量
	 */
	private static $_instance;
	
	/**
	 * 本想利用单例模式,extends Redis后，不允许私有化构造函数
	 */
	public function __construct($dsn) {
		$server = parse_url($dsn);
		$query = array();
		if (isset($server['query'])) {
			parse_str($server['query'], $query);
		}
		$timeout = isset($query['timeout']) ? $query['timeout'] : 60;
		
		if (isset($query['persist']) && $query['persist']) {
			$this->pconnect($server['host'], $server['port'], $timeout, $q['persist']);
		} else {
			$this->connect($server['host'], $server['port'], $timeout);
		}
	}
	
	public static function getInstance($dsn = null) {
		if (!$dsn) return null;
		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self($dsn);
		}
		return self::$_instance;
	}
	
}

$dsn = 'tcp://127.0.0.1:6379?timeout=20';
$redis = RedisDb::getInstance($dsn);

# 随机获取一个key
# $key = $redis->randomKey();
# 获取key的value
# $value = $redis->get($key);
# $redis->delete('test');
# echo $key . ":" . $value;

$redis->lPush('test', 'A-A');
$redis->lPush('test', 'B-B');
$redis->lPush('test', 'C-C');

echo $redis->get('test');



