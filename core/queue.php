<?php
/**
 * 数据结构与算法（PHP实现） - 队列（Queue）。
 * 
 * @author 创想编程（TOPPHP.ORG）
 * @copyright Copyright (c) 2013 创想编程（TOPPHP.ORG） All Rights Reserved
 * @license http://www.opensource.org/licenses/mit-license.php MIT LICENSE
 * @version 1.0.0 - Build20130607
 */
class Queue {
  /**
   * 队列。
   * 
   * @var array
   */
  private $queue;
 
  /**
   * 队列的长度。
   * 
   * @var integer
   */
  private $size;
 
  /**
   * 构造方法 - 初始化数据。
   */
  public function __construct() {
    $this->queue = array();
    $this->size = 0;
  }
 
  /**
   * 入队操作。
   * 
   * @param mixed $data 入队数据。
   * @return object 返回对象本身。
   */
  public function enqueue($data) {
    $this->queue[$this->size++] = $data;
 
    return $this;
  }
 
  /**
   * 出队操作。
   * 
   * @return mixed 空队列时返回FALSE，否则返回队头元素。
   */
  public function dequeue() {
    if (!$this->isEmpty()) {
      $this->size;
      $front = array_splice($this->queue, 0, 1);
 
      return $front[0];
    }
 
    return FALSE;
  }
 
  /**
   * 获取队列。
   * 
   * @return array 返回整个队列。
   */
  public function getQueue() {
    return $this->queue;
  }
 
  /**
   * 获取队头元素。
   * 
   * @return mixed 空队列时返回FALSE，否则返回队头元素。
   */
  public function getFront() {
    if (!$this->isEmpty()) {
      return $this->queue[0];
    }
 
    return FALSE;
  }
 
  /**
   * 获取队列的长度。
   * 
   * @return integer 返回队列的长度。
   */
  public function getSize() {
    return $this->size;
  }
 
  /**
   * 检测队列是否为空。
   * 
   * @return boolean 空队列则返回TRUE，否则返回FALSE。
   */
  public function isEmpty() {
    return 0 === $this->size;
  }
}
?>

18310513013
