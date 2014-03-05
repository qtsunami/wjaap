<?php

/*
$html = file_get_contents('http://www.sina.com.cn');
 
$dom = new DOMDocument();
@$dom->loadHTML($html);
 
// grab all the on the page
$xpath = new DOMXPath($dom);
$hrefs = $xpath->evaluate("/html/body//a");


for ($i = 0; $i < $hrefs->length; $i++) {
       $href = $hrefs->item($i);
       $url = $href->getAttribute('href');
       if(!preg_match('/http:\/\//', $url)) continue;
       echo $url.'<br />';
}
*/

function getHrefByUrl($url = ''){
	if(!$url) return false;

	$html = file_get_contents($url);

	$dom = new DOMDocument();
	@$dom->loadHTML($html);

	$xpath = new DOMXPath($dom);
	$hrefs = $xpath->evaluate("/html/body//a");

	$collection = array();
	$count = $hrefs->length;

	for($i = 0; $i < $count; $i ++){
		$href = $hrefs->item($i);
		$coll = $href->getAttribute('href');
		if(!preg_match('/http:\/\//', $coll)) continue;
		$collection[] = $coll;
	}

	return $collection;
}


echo "<pre>";
$result = getHrefByUrl("http://www.sina.com.cn");
print_r($result);