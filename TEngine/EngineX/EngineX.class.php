<?php
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if(!defined('APP_PATH')){
	define('APP_PATH', dirname(__FILE__));
}

/**
 * EngineX 简易模板引擎
 *
 */
Class EngineX {
	//模板文件
	public $template_dir = 'templates';
	//编译文件
	public $compile_dir =  'templates_c';
	//缓存文件
	public $cache_dir =  'cache';
	//模板变量
	public $_var_tpl = array();
	
	public $caching = false;
	
	public function __construct(){
		//检测各文件夹是否创建
		$this->_checkDir();
	}
	
	/**
	 * @var assign 页面赋值
	 */	
	public function assign($tpl_var, $var = null){
		if(isset($tpl_var) && !empty($tpl_var)){
			$this->_tpl_var[$tpl_var] = $var;
		}else{
			exit("Error:变量未设置");
		}
	}
	
	/**
	 * @var 显示页面
	 */	
	public function display($file){
		$tpl_file = $this->template_dir . DS . $file;

		if(!file_exists($tpl_file)){
			exit("Error:模板文件不存在，请创建！");
		}
		
		//编译文件
		$parse_file = $this->compile_dir . DS . md5($file) . $file . '.php';
		
		//只有当编译文件不存在或模板文件修改过的，才重新编译
		if(!file_exists($parse) || filemtime($parse_file) < filemtime($tpl_file)){
			include "EngineX_Compile.class.php";
			$compile = new EngineX_Compile($tpl_file);
			$compile->parse($parse_file);
		}
		//开启缓存才加载缓存文件，否则加载编译文件
		if($this->caching){
			//缓存文件
			$cache_file = $this->cache_dir . DS . md5($file) . $file . '.html';
			//当缓存文件不存在，或者编译文件发生过修改的重新生成缓存文件
			if(!file_exists($cache_file) || filemtime($cache_file) < filemtime($parse_file)){
				//引入编译文件
				include $parse_file;
				//缓存内容
				$content = ob_get_clean();
				//生成缓存文件
				if(!file_put_contents($cache_file, $content)){
					exit('缓存文件生成出错！');
				}
			}
			include $cache_file;
		}else{
			include $parse_file;
		}
		
	}
	
	
	
	private function _checkDir(){
		if(!is_dir($this->template_dir)){
			exit("模板文件templates不存在！请创建！");
		}
		if(!is_dir($this->compile_dir)){
			exit("模板文件templates_c不存在！请创建！");
		}
		if(!is_dir($this->cache_dir)){
			exit("模板文件cache不存在！请创建！");
		}
	}
}
