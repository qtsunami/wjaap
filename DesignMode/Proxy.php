<?php
// 代理模式
interface Proxy {
    public function request();
    public function display();
}



class RestSubject {

    public function request () {
        echo "Here is Request!<br>";
    }


    public function display () {
        echo "Here is display!<br>";
    }
}



class ProxySubject {
    private $_subject;
    public function __construct () {
        $this->_subject = new RestSubject();
    }

    public function request () {
        return $this->_subject->request();
    }

    public function display () {
        return $this->_subject->display();
    }
}

$proxy = new ProxySubject();

$proxy->request();
$proxy->display();



?>
