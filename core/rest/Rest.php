<?php
namespace library\Rest;
use library\Rest\lib\Request;
use library\Rest\lib\Response;

class Rest {


    protected $_method = '';

    protected $_type = '';

    protected $allowMethod = array('get', 'post', 'put', 'delete');

    protected $_defaultMethod = 'get';

    protected $allowType = array('html', 'xml', 'json', 'rss');

    protected $statusCode = 0;

    protected $errMessage = '';

    protected $allowOutputType = array(
        'xml'  => 'application/xml',
        'json' => 'application/json',
        'html' => 'text/html'
    );

    protected $request;

    public function __construct ()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if (!in_array($method, $this->allowMethod)) {
            $method = $this->_defaultMethod;
        }
        $this->_method = $method;

        // $env = Environment::getInstance();
        $attrs = array();
        $query = (new \Yaf\Request\Http())->getQuery();
        $request = (new \Yaf\Request\Http())->getPost();
        $cookie = (new \Yaf\Request\Http())->getCookie();
        $content = file_get_contents('php://input');
        $files = (new \Yaf\Request\Http())->getFiles();
        $server = (new \Yaf\Request\Http())->getServer();
        $this->request = new Request($query, $request, $attrs, $cookie, $files, $server, $content);
    }
    
    /**
     * [processRequest 处理Request]
     * @return [type] [description]
     */
    public function buildRequest()
    {
        // 验证签名
        // $signature_verify = $this->_checkSignature();
        // if ($signature_verify) {
        //     $this->statusCode = 401;
        //     $this->errMessage = "签名错误！";
        //     // file_put_contents('/tmp/signature.log', '签名验证失败', FILE_APPEND);
        //     return false;
        // }
        $this->request->setMethod($this->_method);
        return $this->request;

    }


    public function isMethod($method)
    {
        return $this->request->isMethod($method);
    }


    /**
     * [sendResponse description]
     * @param  integer $status [description]
     * @param  array   $body   [description]
     * @param  array   $header array('Content-Type'=>'applicaton/json')
     * @return [type]          [description]
     */
    public function sendResponse($status = 200, $body = array(), $header = array())
    {
        $response_data = array();
        $status_header = 'HTTP/1.1 ' . $status . ' ' . Rest::getStatusCodeMessage($status);
        header($status_header);
        if (empty($header)) {
            header('Content-Type: application/json');
        }

        foreach ($header as $key => $value) {
            header(ucwords($key) . ':' . $value);
        }

        $body = is_array($body) ? $body : array($body);
        
        $response_data['code'] = $status;
        $response_data['message'] = Rest::getStatusCodeMessage($status);
        if ($status === 200) {
            $response_data['data'] = $body;
        }

        echo json_encode($response_data);die;
    }
    

        
    public function getStatusCodeMessage($status)
    {
        $codes = Array(
                100 => 'Continue',
                101 => 'Switching Protocols',
                200 => 'OK',
                201 => 'Created',
                202 => 'Accepted',
                203 => 'Non-Authoritative Information',
                204 => 'No Content',
                205 => 'Reset Content',
                206 => 'Partial Content',
                300 => 'Multiple Choices',
                301 => 'Moved Permanently',
                302 => 'Found',
                303 => 'See Other',
                304 => 'Not Modified',
                305 => 'Use Proxy',
                306 => '(Unused)',
                307 => 'Temporary Redirect',
                400 => 'Bad Request',
                401 => 'Unauthorized',
                402 => 'Payment Required',
                403 => 'Forbidden',
                404 => 'Not Found',
                405 => 'Method Not Allowed',
                406 => 'Not Acceptable',
                407 => 'Proxy Authentication Required',
                408 => 'Request Timeout',
                409 => 'Conflict',
                410 => 'Gone',
                411 => 'Length Required',
                412 => 'Precondition Failed',
                413 => 'Request Entity Too Large',
                414 => 'Request-URI Too Long',
                415 => 'Unsupported Media Type',
                416 => 'Requested Range Not Satisfiable',
                417 => 'Expectation Failed',
                500 => 'Internal Server Error',
                501 => 'Not Implemented',
                502 => 'Bad Gateway',
                503 => 'Service Unavailable',
                504 => 'Gateway Timeout',
                505 => 'HTTP Version Not Supported'
        ); 

        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    /**
     * [_checkSignature 验证签名]
     * @return [type] [description]
     */
    private function _checkSignature()
    {
        // 获取Headers
        $headers = $this->request->getHeaders();
        // 获取Signature
        if (isset($headers['http-authorization']) && $headers['http-authorization'] != "") {
            $signature = $this->_buildSignature($headers);
            if ($signature == $headers['http-authorization']) {
                return true;
            }
            return false;
        }
        return false;
    }


    /**
     * [_buildSignature 根据Header获取认证签名]
     * @param  [type] $headers      [description]
     * @param  [type] $em_access_id [description]
     * @return [type]               [description]
     */
    private function _buildSignature ($headers)
    {
        // 根据签名获取ACCESSID
        $signature = $headers['http-authorization'];
        $signature = trim(strstr($signature, ' '));
        $em_access_id = substr($signature, 0, strpos($signature, ':'));
        // 签名串
        $string_to_sign = "";
        $string_to_sign .= $this->_method . "\n";

        foreach ($headers as $header_key => $header_value) {
            $header_key = strtolower($header_key);
            if ($header_key === 'content-md5' || $header_key === 'content-type' || $header_key === 'date') {
                $string_to_sign .= $header_value . "\n";
            }
        }
        // 根据em_access_id 获取em_secret_key
        $em_secret_key = $this->_getSecretKeyById($em_access_id);
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $em_secret_key, true));

        $signature_start = "EM " . $em_access_id . ":";
        return $signature_start . $signature;
    }


    /**
     * [_getSecretKeyById 获取SecretKey]
     * @param  [type] $em_access_id [description]
     * @return [type]               [description]
     */
    private function _getSecretKeyById ($em_access_id) 
    {
        if (NULL == $em_access_id) {
            return false;
        }
        // 临时 access_id和access_key   AKIAIOSFODNN7EXAMPLE:wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY
        // 获取access_key
        $access_key = 'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY';
        return $access_key;

    }

}



