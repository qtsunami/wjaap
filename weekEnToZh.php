<?php


function weekEnToZh ($stamptime) {
    $week_en = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'); 
    $week_zh = array('周一', '周二', '周三', '周四', '周五', '周六', '周日'); 
    return str_replace($week_en, $week_zh, date('Y年m月d日 l H:i', (int) $stamptime)); 
}


