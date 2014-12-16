<?php
header('Content-Type:text/html;charset=utf8');
$initArray = array();


for($i = 0; $i < 10; $i ++) {
    $initArray[] = mt_rand(1, 100);
}

$initStart = implode(',', $initArray);
echo "初始化：" . $initStart . "<br>";

$endSort = quicksort($initArray);
$initend = implode(',', $endSort);

echo "排序后：" . $initend . "<br>";

function quicksort($arr) {
    $len = count($arr);
    if($len <= 1) return $arr;

    $leftArr = array();
    $rightArr = array();
    $midIndex = floor($len/2);
    $midValue = $arr[$midIndex];
    for ($i = 0; $i < $len; $i ++) {
        if($i == $midIndex) continue;

        if($arr[$i] < $midValue){
            $leftArr[] = $arr[$i];
        }else{
            $rightArr[] = $arr[$i];
        }
    }
    return array_merge(quicksort($leftArr), (array) $midValue, quicksort($rightArr));
}
