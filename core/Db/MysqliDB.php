<?php

class MysqliDb {

	const TYPE ="Mysql";
	const HOST;
	const USERNAME;
	const PASSWD;
	const DBNAME;
	const PORT;
	const SOCKET;

	const PREFIX;
	const CHARSET;

	public $mysqli = null;

	public function __construct ($dbconfig = array()) {
		self::_parseConfig($dbconfig);
		$this->connect();
	
	}

	/**
	 * [connect description]
	 * @return [type] [description]
	 */
	private function connect () {
		// mysqli_connect(self::HOST, self::USERNAME, self::PASSWD, self::DBNAME, self::PORT, self::SOCKET);
		try {
			$this->mysqli = new Mysqli(self::HOST, self::USERNAME, self::PASSWD, self::DBNAME, self::PORT, self::SOCKET)
			if ($this->mysqli->connect_error) {
				throw new Exception($this->mysqli->connect_error, $this->mysqli->connect_no);
				
			}
		} catch (Exception $e) {
			return $e->getCode();
		}
		
	}


	private static function _parseConfig ($config) {
		if (!empty($config)) {
			if (is_string($config)) {
				$config = parse_url($config);
				if (!$info) return false;
			}
			$config = array_change_key_case($config, CASE_LOWER);
			self::HOST = $config['host'];
			self::USERNAME = $config['username'];
			self::PASSWD = $config['password'];
			self::DBNAME = $config['database'];
			self::PORT = $config['port'];
			self::SOCKET = isset($config['socket']) ? $config['socket'] : '';

			self::CHARSET = isset($config['charset']) ? $config['charset'] : 'utf8';
			self::PREFIX = isset($config['prefix']) ? $config['prefix'] : '';
		}
	}










}
