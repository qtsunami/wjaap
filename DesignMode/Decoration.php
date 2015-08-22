<?php
/**
 * @var 装饰器模式
 * 装饰者模式动态地将责任附加到对象上。
 * 解决的问题：
 * 一、类数量爆炸时，有助于维护
 * 二、整个设计灵活度提升
 * 三、基类新加入的功能可用于子类
 */
abstract class Beverage {
    public $_name;

    abstract public function cost ();
}


/**
 * 被装饰者类
 */
class Coffee extends Beverage {
    public $price = 1.00;
    public function __construct () {
        $this->_name = "Coffee";
    }
    public function cost () {
        return $this->price;
    }
    public function setPrice ($price) {
        $this->price = $price;
    }
}


// 以下三个类是装饰者相关类
class CondimentDecorator extends Beverage {
    public function __construct () {
        $this->_name = 'Condiment';
    }

    public function cost () {
        // return 0.1;
    }

    public function setPrice ($price) {
        $this->price = $price;
    }

}

class Milk extends CondimentDecorator {
    public $_beverage;
    public $price = 0.2;
    public function __construct ($beverage) {
        $this->_name = "Milk";
        if ($beverage instanceof Beverage) {
            $this->_beverage = $beverage;
        } else {
            exit("Failure");
        }
    }

    public function cost () {
        return $this->_beverage->cost() + $this->price;
    }
}


class Sugar extends CondimentDecorator {
    public $_beverage;
    public $price = 0.3;
    public function __construct ($beverage) {
        $this->_name = "Sugar";
        if ($beverage instanceof Beverage) {
            $this->_beverage = $beverage;
        } else {
            exit("Failure");
        }
    }

    public function cost () {
        return $this->_beverage->cost() + $this->price;
    }
}



// First, i get a cut of Coffee
$coffee = new Coffee();
// $coffee->setPrice(1.2);

// Second, i want take sugar in my coffee;
$coffee = new Sugar($coffee);
// $coffee->setPrice(0.3);

// Last, i want take some milk in my coffee;
$coffee = new Milk($coffee);
// $coffee->setPrice(0.4);

// Now , Let's pay the bill;
$pay = $coffee->cost();

echo $pay;
