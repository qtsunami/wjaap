<?php
/**
 * 注册模式
 */
class Registry {

    protected static $store = array();
    private static $_instance;

    private function __construct () {}
    public static function getInstance () {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function isValid ($key) {
        return array_key_exists($key, self::$store);
    }

    public function set ($key, $obj) {
        self::$store[$key] = $obj;
    }


    public function get ($key) {
        return self::$store[$key];
    }


    public function __clone () {
        trigger_error("Connot clone Object", E_USER_ERROR);
    }


}




class ConnectDB {
    private $host;
    private $username;
    private $password;

    private $conn;


    public function __construct($host, $username, $password){
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }

    public function getConnect() {
        return mysql_connect($this->host,$this->username,$this->password);
    }
}


$reg = Registry::getInstance();

$reg->set('db1', (new ConnectDB('localhost', 'root', ''))->getConnect());

print_r($reg->get('db1'));
