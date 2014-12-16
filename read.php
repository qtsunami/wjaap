<?php
include "./core/simple_html_dom.class.php";

$url = "http://sports.sohu.com/zhongchao.shtml";
$dom = new simple_html_dom();
$html = $dom->load(file_get_contents($url));

$res = $html->find("div#turnIDB div.turn");
# 积分榜
echo $res[0]->outertext;
# 射手榜
echo $res[1]->outertext;
