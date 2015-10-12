<?php
header('Content-Type:text/html;charset=utf8');
require_once "core/PHPExcel/PHPExcel.php";



echo youdao('very nice app but when I am clearing ram original theme displaying', 'en|zh-cn');

die;

echo "<pre>";
$pattern = '/[\x{4e00}-\x{9fa5}]+/u'; 
$data = readExcel('', 'import.xlsx');
foreach($data as $v){
    if(!preg_match($pattern, $v[0])){
        $newData[] = youdao($v[0], 'en|zh-cn');        
    }else{
        $newData[] = $v[0];
    }
}


function readExcel($path = '', $filename){
    //转码上传名称
    $local_name = iconv("UTF-8", "gb2312", $filename);
    $PHPReader = new PHPExcel_Reader_Excel2007();
    if (!$PHPReader->canRead($path . $local_name)) {
        $PHPReader = new PHPExcel_Reader_Excel5();
        if (!$PHPReader->canRead($path . $local_name)) {
            echo 'no Excel';
            return;
        }
    }
    //载入文件 
    $PHPExcel = $PHPReader->load($path . $local_name);
    $sheet = $PHPExcel->getActiveSheet();
    $allCol=PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn());
    $allRow=$sheet->getHighestRow();

    for($col=1; $col<=$allRow;$col++){
        for ($row=0;$row<$allCol;$row++){
            $data[$col][] = $sheet->getCellByColumnAndRow($row,$col)->getValue()."   ";
        }
    }
    //去掉数组的第一个元素
    array_shift($data);
    return $data;
}
function youdao ($text) {
    if(empty($text))return false;
    $text = urlencode($text);
    //$doctype = "xml|json|jsonp";
    $url = "http://fanyi.youdao.com/openapi.do?keyfrom=mx2014com&key=2086412533&type=data&doctype=json&version=1.1&q=" . $text;
    $info = file_get_contents($url);
    $info = json_decode($info);
    $info = $info->translation;
    return $info[0];
}

