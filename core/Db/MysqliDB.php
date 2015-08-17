<?php

class MysqliDb {

	private $type ="Mysql";
	private $host;
	private $username;
	private $passwd;
	private $dbname;
	private $port;
	private $socket;

	private $prefix;
	private $charset;

	public $mysqli = null;

	public function __construct ($dbconfig = array()) {
		$this->_parseConfig($dbconfig);
		$this->connect();

	}

	/**
	 * [connect description]
	 * @return [type] [description]
	 */
	private function connect () {
		// mysqli_connect(self::HOST, self::USERNAME, self::PASSWD, self::DBNAME, self::PORT, self::SOCKET);
		try {
			$this->mysqli = new Mysqli($this->host, $this->username, $this->passwd, $this->dbname, $this->port, $this->socket);
			if ($this->mysqli->connect_error) {
				throw new Exception($this->mysqli->connect_error, $this->mysqli->connect_no);

			}
		} catch (Exception $e) {
			return $e->getCode();
		}

	}

	/**
	 * [_parseConfig 解析配置文件]
	 * @param  [type] $config [description]
	 * @return [type]         [description]
	 */
	private function _parseConfig ($config) {
		if (!empty($config)) {
			if (is_string($config)) {
				$config = parse_url($config);
				if (!$info) return false;
			}
			$config = array_change_key_case($config, CASE_LOWER);
			$this->host = $config['host'];
			$this->username = $config['username'];
			$this->passwd = $config['password'];
			$this->dbname = $config['database'];
			$this->port = $config['port'];
			$this->socket = isset($config['socket']) ? $config['socket'] : '';

			$this->charset = isset($config['charset']) ? $config['charset'] : 'utf8';
			$this->prefix = isset($config['prefix']) ? $config['prefix'] : '';
		}
	}

	/**
	 * [showTables 显示数据库的表名称]
	 * @param  string $match [检索字符串]
	 * @return [type]        [description]
	 */
	public function showTables ($match = "") {
		$sql = "SHOW TABLES";
		if ($match != "") $sql .= " LIKE '%{$match}%'";

		$result = $this->mysqli->query($sql);
		$tables = array();

		while ($fet = $result->fetch_array()) {
			$tables[] = $fet[0];
		}
		return $tables;
	}

	public function clientInfo () {
		return sprintf("Client library version: %s\n", $this->mysqli->client_info);
	}

	public function clientVersion () {
		return sprintf("Client library version: %d\n", $this->mysqli->client_version);
	}


	private function lastInsertId () {
		return $this->mysqli->insert_id;
	}

	public function __destruct () {
		$this->mysqli->close();
	}






}
