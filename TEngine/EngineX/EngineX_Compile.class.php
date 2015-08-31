<?php
Class EngineX_Compile {

	//模板内容
	private $content = '';
	
	public function __construct($tpl_file){
		$this->content = file_get_contents($tpl_file);
	}
	
	
	public function parseVar(){
		$pattern = '/\{\$([\w\d]+)\}/';
		if(preg_match($pattern, $this->content)){
			$this->content = preg_replace($pattern, '<?php echo \$this->_tpl_var["$1"]; ?>', $this->content);
		}
	}

	//模板编译文件
	
	public function parse($parse_file){
		$this->parseVar();
		
		//编译完成后
		if(!file_put_contents($parse_file, $this->content)){
			exit("编译文件出错");
		}
	}


}