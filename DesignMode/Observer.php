<?php
// 观察者模式
/**
 *  @var 观察者模式为我们提供了避免组件之间紧密耦合的另一种方法。
 *  @var 该模式原理 ：一个对象通过添加一个方法（该方法允许另一个对象，即观察者注册自己）使本身变得可观察。
 *  当可观察的对象更改时，它会将消息发送到已注册的观察者。这些观察者使用该信息执行的操作与可观察者的对象无关。
 */


/**
 * 简单示例：系统中的用户列表
 * 下列代码中显示一个用户列表，添加用户时，它将发送出一条消息。添加用户时，通过发送消息的日志观察者可观察此列表。
 */
interface IObserver {
    public function onChanged ($sender, $args);
}

/**
 * IObservable 接口定义可以被观察的对象
 */
interface IObservable {
    public function addObserver($observer);
}

/**
 * @var 实现IObservable 接口，将本身注册为可观察
 */
class UserList implements IObservable {
    private $_observers = array();
    public function addCustomer ($name) {
        foreach ($this->_observers as $key => $obs) {
            $obs->onChanged($this, $name);
        }
    }

    public function addObserver ($observer) {
        $this->_observers[] = $observer;
    }


}


class UserListLogger implements IObserver {
    public function onChanged ($sender, $args) {
        echo "'$args' added to user list<br>";
    }
}

$ul = new UserList();
$ul->addObserver(new UserListLogger());
$ul->addCustomer("Jack");
