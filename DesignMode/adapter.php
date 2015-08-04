<?php
// 适配目标
interface Target {

    public function simpleMethod1();
    public function simpleMethod2();

}


// 适配源
class Adaptee {
    public function simpleMethod1 () 
    {
        echo 'Adapter simpleMethod1' . PHP_EOL; 
    }
}


class Adaptee2 {
    public function simpleMethod1()
    {
        echo "Adapter simpleMethod1 with Adaptee2" . PHP_EOL; 
    }
}



// 适配器角色
class Adapter implements Target {

    private $adaptee;

    public function __construct(Adaptee2 $adaptee)
    {
        $this->adaptee = $adaptee; 
    }

    public function simpleMethod1()
    {
        echo $this->adaptee->simpleMethod1(); 
    }


    public function simpleMethod2()
    {
        echo "Adapter simpleMethod2" . PHP_EOL; 
    }


}




// 客户端请求
class Client {
    public static function main()
    {
        $adaptee = new Adaptee2();
        $adapter = new Adapter($adaptee);
        $adapter->simpleMethod1();
        $adapter->simpleMethod2();

      
    }

}

Client::main();







