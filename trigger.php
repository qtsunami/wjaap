<?php
// trigger_error 创建用户定义的错误信息
function error_handler($level, $message, $file, $line, $context) {
	if ($level === E_USER_ERROR || $level === E_USER_WARNING || $level == E_USER_NOTICE) {
		echo '<strong>Error:</strong>' . $message;
		return true;
	}
	return false;
}



function trigger_my_error($message, $level){
	$callee = next(debug_backtrace());
	trigger_error($message . 'in <strong>' . $callee['file'] . '</strong> on line <strong>' . $callee['line'] . '</strong>', $level);
}


set_error_handler('error_handler');


function abc($str)
{
	if (!is_string($str)) {
		trigger_my_error('abc() excepts paramter 1 to be a string', E_USER_ERROR);
	}

}


abc(18);
