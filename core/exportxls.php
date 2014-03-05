<?php
//Xls应用
class ExportXls{

    /**
     *
     * @describe 导出Excel
     * @param $data array() 导出的数据
     * @param $title array() 各数据标题
     * @param $filename string 文件名
     */
    public function exports($data = array(), $title = array(), $filename = "exports"){
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");  
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=iconv("UTF-8", "GB2312",$v);
            }
            $title= implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data)){
            foreach($data as $key=>$val){
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key]=implode("\t", $data[$key]);
                
            }
            echo implode("\n",$data);
        }
    }
}


$connect = mysql_connect('localhost', 'root', '123456') or die('Connect Failed!');

mysql_select_db('spider', $connect) or die ('Can\'t use foo : ' . mysql_error());
mysql_query("set names utf8");

$sql = "select * from zzcms_botlist";
$result = mysql_query($sql);

$data = array();
while($res = mysql_fetch_assoc($result)){
    $data[] = $res;
}
$excel = new ExportXls();

$title = array('id', 'name', 'age');
$excel->exports($data, $title, 'reports');

