<?php

class Vrm {

	protected $profile;

	protected $redirectAttr = array(
			'id' => 'int',
			'title' => 'string',
			'desc' => 'string',
			'status' => 'boolean',
			'ctime' => 'int',
			'thmuns' => 'int'
		);
	protected $attr;

	public $thmnums = 1;


	public function __construct($profile){

		if(is_numeric($profile)){
			$this->profile = (int)$profile;
		}

		$this->attr = array_keys($this->redirectAttr);
	}




	public function Test(){

		return "Vrm::Test";
	}


	public function __get($key){
		return "Vrm::" . $key;
	}

	public function sanitizing($value){
		return filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
	}

	public function filter($key, $filter = FILTER_DEFAULT, $options = null, $type = null)
    {  /**
         * 简化正则的调用
         */
        if ($filter == FILTER_VALIDATE_REGEXP && is_string($options)) {
            $options = array('options' => array('regexp' => $options));
        }
        if (isset($this->rawData[$key]) && $type === null) {
            return filter_var($this->rawData[$key], $filter, $options);
         } else {    
            return filter_input($type, $key, $filter, $options);
         }
    }


    public function __set($key, $value){
    	$this->thmnums++;
    }

    public function __destruct(){
    	echo "Game::Over!";
    }
}



$vrm = new Vrm(223);

echo "<pre>";
$vrm->thmnums++;
echo $vrm->thmnums;