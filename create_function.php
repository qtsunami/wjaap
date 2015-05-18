<?php
/**
 *
 * 去除数组元素空格元素
 */


$testArr = array(' String', 'Value ', ' letter ', 'Abc');

print_r($testArr);

array_walk($testArr, create_function('&$value', '$value = trim($value);'));

print_r($testArr);

