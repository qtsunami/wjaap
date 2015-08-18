<?php
/**
 * @var spl_autoload
 */
class classAutolader {
    /**
     * [registerAutoload description]
     * @return [type] [description]
     */
    public static function registerAutoload () {
        return spl_autoload_register(array(__CLASS__, 'loader'));
    }


    public static function unregisterAutolad () {
        return spl_autoload_unregister(array(__CLASS__, 'loader'));
    }


    public static function loader($className) {
        include strtr($className, '_\\', '//') . '.class.php';
    }


    /**
     * [splClass 返回当前所有可用的 SPL 类的数组]
     * @return [type] [description]
     */
    public static function splClass () {
        return spl_classes();
    }


}

classAutolader::registerAutoload();

$obj1 = new lib\A();

$obj1->test();

classAutolader::unregisterAutolad();
$obj2 = new lib\B();













 ?>
