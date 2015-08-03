<?php
 /**
 * 输出供Ajax所调用的页面返回信息
 *
 * 返回json数据,供前台ajax调用
 *
 * @param string $info 返回信息, 默认为空
 *
 * @return string
 */
function alert($info = null) {

	$result            = array();
	$result['error']   = 1;
	$result['message'] = !is_null($info) ? $info : '';

	//设置页面编码
	header("Content-Type:text/html; charset=utf-8");

	exit(json_encode($result));
}

/**
 * 用CURL模拟提交数据
 *
 * @param string $url        post所要提交的网址
 * @param array  $data       所要提交的数据
 * @param string $proxy      代理设置
 * @param integer $expire    所用的时间限制
 *
 * @return string
 */
function postRequest($url, $data = array(), $proxy = null, $expire = 30) {

	//参数分析
	if (!$url || !is_array($data)) {
		return false;
	}

	//分析是否开启SSL加密
	$ssl = strtolower(substr($url, 0, 8)) == 'https://' ? true : false;

	//读取网址内容
	$ch = curl_init();

	//设置代理
	if (!$proxy) {
		curl_setopt ($ch, CURLOPT_PROXY, $proxy);
	}

	curl_setopt($ch, CURLOPT_URL, $url);

	if ($ssl) {
		// 对认证证书来源的检查
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		// 从证书中检查SSL加密算法是否存在
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
	}

	//设置浏览器
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_HEADER, 0);

	//发送一个常规的Post请求
	curl_setopt($ch, CURLOPT_POST, true);
	//Post提交的数据包
	curl_setopt($ch,  CURLOPT_POSTFIELDS, $data);

	//使用自动跳转
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, $expire);

	$content = curl_exec($ch);
	curl_close($ch);

	return $content;
}

//定义上传文件所允许的属性
$allowExtArray = array('.jpg', '.gif', '.png', '.jpeg');
$allowMaxSize  = 1024*1024*2;
//上传图片接口
$ApiUrl    = 'http://www.example.com/upload.php';
//图片地址
$urlArray  = array(
    'http://n1.example.com'
);

//当上传文件为空时则返回
if (!isset($_FILES['imgFile']) || !$_FILES['imgFile']) {
	return false;
}

//显示错误提示
if (!empty($_FILES['imgFile']['error'])) {
	switch($_FILES['imgFile']['error']){
		case '1':
			$error = '超过php.ini允许的大小。';
			break;
		case '2':
			$error = '超过表单允许的大小。';
			break;
		case '3':
			$error = '图片只有部分被上传。';
			break;
		case '4':
			$error = '请选择图片。';
			break;
		case '6':
			$error = '找不到临时目录。';
			break;
		case '7':
			$error = '写文件到硬盘出错。';
			break;
		case '8':
			$error = 'File upload stopped by extension。';
			break;
		case '999':
		default:
			$error = '未知错误。';
	}
	alert($error);
}

$fileName     = $_FILES['imgFile']['name'];
$tmpFile      = $_FILES['imgFile']['tmp_name'];
$fileSize     = $_FILES['imgFile']['size'];

if (!$fileName) {
	alert('请选择所要上传的文件!');
}
//判断文件格式
$fileExtName   = strtolower(strrchr($fileName, '.'));
if (!in_array($fileExtName, $allowExtArray)) {
	alert('对不起，上传文件格式错误！只允许上传图片');
}
if ($fileSize > $allowMaxSize) {
	alert('对不起，上传文件大小超过限制。');;
}

//检查是否已上传
if (@is_uploaded_file($tmpFile) === false) {
	alert("上传失败。");
}

$serverTempFile = sys_get_temp_dir() . '/' . md5(uniqid());

if (move_uploaded_file($tmpFile, $serverTempFile) === false) {
	alert("上传文件失败。");
}

$fileData  = array(
		'type' => 'preview',
		'file' => '@' . $serverTempFile
);

$result    = postRequest($ApiUrl, $fileData);
$result    = unserialize($result);

unlink($serverTempFile);
if ($result['code'] != 200) {
	alert('对不起，图片上传失败！');
}

$imageUrl = $urlArray[array_rand($urlArray)] . '/' . $result['data'];

//设置页面编码
header("Content-Type:text/html; charset=utf-8");

exit(json_encode(array('error' => 0, 'url' => $imageUrl)));
