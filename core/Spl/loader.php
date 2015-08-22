<?php
/**
 * @var spl_autoload
 */
class classAutolader {

    private static $_extension = array();
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
     * [setExtension 注册并返回spl_autoload函数使用的默认文件扩展名]
     * @param array $extension [description]
     */
    public static function setExtension ($extension = array()) {
        if (empty($extension)) return false;
        $_extension = implode(',', $extension);
        // self::$_extension = $extension;
        return spl_autoload_extensions($_extension);
    }

    /**
     * [splClass 返回当前所有可用的 SPL 类的数组]
     * @return [type] [description]
     */
    public static function splClass () {
        return spl_classes();
    }


    public static function splFunction () {
        return spl_autoload_functions();
    }


}

classAutolader::registerAutoload();

$obj1 = new lib\A();

$obj1->test();


// classAutolader::unregisterAutolad();
// $obj2 = new lib\B();













 ?>
