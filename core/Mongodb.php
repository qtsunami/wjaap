<?php

class Vf_Mongodb {
   	
	protected $mondb;

	protected $dbLink;

	protected $dbname;
	
	protected $tablename;
	protected $_defaultConfig = array(
		'host' => 'mongodb://127.0.0.1:27017?dbname=mx_ucenter',
		'option' => array(),
		'username' => '',
		'password' => ''
	);	
	protected function __construct($dns = array()){
		if(!extension_loaded('mongo')){
			exit("The Mongo extension is not loaded！");
		}	
		$config = $dns == '' ? $this->_defaultConfig : $dns;
		!isset($config['option']) && $config['option'] = array();
		//Server 准备	
		$vf = parse_url($config['host']);
		$dnsStr = 'mongodb://' . $vf['host'];
		$dnsStr = $dnsStr . ':' . $vf['port'];

		//解析其他参数
		parse_str($vf['query'], $option);
		if(!isset($option['dbname'])){
			exit("Sorry, the file of Mongodb config is error, dbname is not found!");	
		}
		$this->dbname = $option['dbname'];
		unset($option['dbname']);

        $option = array_merge($option, $config['option']);
        
		try{
			$this->mondb = new Mongo($dnsStr, $option);
			$this->dbLink = $this->mondb->selectDB($this->dbname);
			if(isset($config['username']) && isset($config['password'])){
				$this->dbLink->authenticate($config['username'], $config['password']);	
			}
			return true;	
		}catch(Exception $e){
			//抛出异常
			throw new Exception('MongoDb connect error!<br/>' . $e->getMessage(), $e->getCode());
		}
	} 



	public static function getInstance($dns = array()){
		static $_instance;
		return $_instance ? $_instance : (new self($dns));	
    }
		
	public function collection($tablename){
		return $this->dbLink->selectCollection($tablename);	
	}	
	
	/**
	 * getOne get a recode
	 *
	 * @params string $tablename 表名
	 * @params array() $query 查询条件
	 * @params array() $fields 获取的字段
	 *
	 * @return array()
	 */ 
	public function getOne($tablename, $query = array(), $fields = array()){
		return $this->collection($tablename)->findOne($query, $fields);	
	}

	/**
	 * getAll get All recode
	 *
	 * @params string $tablename 表名
	 * @params array() $query 查询条件
	 * @params array() $fields 获取的字段
	 *
	 * @return array()
	 */
	public function getAll($tablename, $query = array(), $fields = array()){
		$return = array();
		$cursor = $this->collection($tablename)->find($query, $fields);
		while($cursor->hasNext()){
			$return[] = $cursor->getNext();
		}
		return $return;	
	}


    public function insert($tablename, $data){
        return $this->collection($tablename)->insert($data); 
    }
    
    public function update($tablename, $query, $data, $upsert = false){
       return $this->collection($tablename)->update($query, $data, array('upsert' => $upsert)); 
    }


	/*
	public function __set($key, $value){
		$this->table = $this->dbLink->$value;
	}
	*/	
	/**
	 * __get 以__get为媒介获取表名(暂时这样写)
	 *
	 * @return 
	 * Object 
	 */
	/*
	public function __get($key){
		$this->tablename = $key;
		return $this;
	}
	 */

    
}
