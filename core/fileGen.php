<?php

class fileGen {

	private $floder;

	protected function __construct(){
		
	}


	public static function single(){
		static $instance;
		return $instance ? $instance : (new self());
	}


	private function floder(){}


	public function detail($floder){
		
	}



	public function __destruct() {
		//print "Destroying " . $this->name . "\n";
	}

}