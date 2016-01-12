<?php
namespace library\Rest;
class Environment implements \ArrayAccess, \IteratorAggregate {
	
	/**
	 * @var array
	 */
	protected $properites;

	protected static $environment;

	/**
	 * [getInstance description]
	 * @param  boolean $refresh refresh 属性
	 * @return self::$environmnet;
	 */
	public static function getInstance($refresh = false)
	{
		if (is_null(self::$environment) || $refresh) {
			self::$environment = new self();
		}
		return self::$environment;
	}


	private function __construct($setting = null)
	{
		if ($setting) {
			$this->properites = $setting;
		} else {
			$env = array();
			// HTTP请求方法 及 远程IP地址
			$env['REQUEST_METHOD']   = $_SERVER['REQUEST_METHOD'];
			$env['REMOTE_ADDR']	 	 = $_SERVER['REMOTE_ADDR'];

			// 获取 服务端参数
			$script_name 			 = $_SERVER['SCRIPT_NAME'];
			$request_uri 			 = $_SERVER['REQUEST_URI'];
			$query_string 			 = $_SERVER['QUERY_STRING'];

			// 获取
			if (strpos($request_uri, $script_name) !== false) {
				$physical_path = $script_name;
			} else {
				$physical_path = str_replace('\\', '', dirname($script_name));
			}

			$env['SCRIPT_NAME'] 	 = rtrim($physical_path, '/');

			$env['PATH_INFO'] 		 = $request_uri;
			if (substr($request_uri, 0, strlen($physical_path)) == $physical_path) {
				$env['PATH_INFO']	 = substr($request_uri, strlen($physical_path));
			}
			$env['PATH_INFO']		 = str_replace('?' . $query_string, '', $env['PATH_INFO']);
			$env['PATH_INFO']		 = '/' . ltrim($env['PATH_INFO'], '/');

			// QUERY_STRING
			$env['QUERY_STRING']	 = $query_string;
			$env['SERVER_NAME']		 = $_SERVER['SERVER_NAME'];
			$env['SERVER_PORT']		 = isset($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : 80;

			// HTTP 请求header头
			$headers = Headers::extract($_SERVER);
			foreach ($headers as $key => $value) {
				$env[$key] = $value;
			}

			// 判断应用程序运行https 或者 http
			$env['URL_SCHEME'] 		 = empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off' ? 'http' : 'https';

			$raw_input 				 = @file_get_contents('php://input');
			if (!$raw_input) $raw_input = '';
			$env['input'] 			 = $raw_input;
			$env['errors'] 			 = @fopen('php://stderr', 'w');

			$this->properites 		 = $env;
		}
	}

	/**
	 * [hock 自定义SERVER信息]
	 * @param  array  $setting [description]
	 * @return [type]          [description]
	 */
	public static function hock($setting = array())
	{
		$default = array(
			'REQUEST_METHOD'    => 'GET',
			'SCRIPT_NAME'	 	=> '',
			'PATH_INFO'			=> '',
			'QUERY_STRING' 		=> '',
			'SERVER_NAME'		=> 'localhost',
			'SERVER_PORT'		=> 80,
			'ACCEPT'			=> 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
			'ACCEPT_LANGUAGE'	=> 'zh-CN,zh;q=0.8',
			'ACCEPT_CHARSET'	=> 'ISO-8859-1,utf-8;q=0.7,*;q=0.3',
			'USER_AGENT'		=> 'Yaf EM',
			'REMOTE_ADDR'		=> '127.0.0.1',
			'URL_SCHEME'		=> 'http',
			'input'				=> '',
			'errors' 			=> @fopen('php://stderr', 'w')
		);

		self::$environment = new self(array_merge($default, $setting));
		return self::$environment;
	}


	/**
	 * ArrayAccess::offsetExists()
	 * @param  [type] $offset [description]
	 * @return [type]         [description]
	 */
	public function offsetExists($offset)
	{
		return isset($this->properites[$offset]);
	}
	/**
	 * ArrayAccess::offsetGet()
	 * @param  [type] $offset [description]
	 * @return [type]         [description]
	 */
	public function offsetGet($offset)
	{
		return isset($this->properites[$offset]) ? $this->properites[$offset] : null;
	}

	/**
	 * ArrayAccess::offsetSet()
	 * @param  [type] $offset [description]
	 * @param  [type] $value  [description]
	 * @return [type]         [description]
	 */
	public function offsetSet($offset, $value)
	{
		$this->properites[$offset] = $value;
	}

	/**
	 * ArrayAccess::offsetUnset()
	 * @param  [type] $offset [description]
	 * @return [type]         [description]
	 */
	public function offsetUnset($offset) 
	{
		unset($this->properites[$offset]);
	}

	/**
	 * 返回一个迭代器
	 * @return [type] [description]
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->properites);
	}

}