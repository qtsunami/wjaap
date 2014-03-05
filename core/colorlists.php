<?php

/*
 * PHP调用谷歌翻译
 * author:野草
 * date:2012/3/23
 * email:129@jinzhe.net
 * site:http://yckit.com
 */
function translate($text,$language='zh-cn|en'){
    if(empty($text))return false;
    @set_time_limit(0);
    $html = "";
    $ch=curl_init("http://translate.google.com/translate_t?langpair=".urlencode($language)."&text=".urlencode($text));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_HEADER, 0);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
    $html=curl_exec($ch);
    if(curl_errno($ch))$html = "";
    curl_close($ch);
    if(!empty($html)){
        $x=explode("</span></span></div></div>",$html);
        $x=explode("onmouseout=\"this.style.backgroundColor='#fff'\">",$x[0]);
        return $x[1];
    }else{
        return false;
    }
}
echo translate('大家好','zh-cn|en');






die;
$arr = array(
        array('ctime'=>'2013-10-30'),
        array('ctime'=>'2013-10-30'),
        array('ctime'=>'2013-10-30'),
        array('ctime'=>'2013-07-25'),
        array('ctime'=>'2013-07-25')
    );

$newArray = array();
foreach($arr as $value){
    $newArray[]= $value['ctime'];
}

var_dump(array_count_values($newArray));
die;
class MajorColor 
{ 
    //参考颜色 
    protected $_colors = null; 
     
    //容差 
    protected $_tolerance = 80; 
     
    //忽略的颜色 
    protected $_ignoreColors = array(); 
     
    //支持的图片类型 
    protected $_funcs = array('image/png' => 'imagecreatefrompng', 'image/jpeg' => 'imagecreatefromjpeg', 'image/gif' => 'imagecreatefromgif'); 
     
    public function __construct(array $colors = null) { 
        if(null !== $colors) { 
            $this->_colors = $colors; 
        } 
    } 
     
    public function setColors(array $colors) { 
        $this->_colors = $colors; 
    } 
     
    public function setTolerance($tolerance) { 
        $this->_tolerance = $tolerance; 
    } 
     
    public function setIgnoreColors($colors) { 
        $this->_ignoreColors = $colors; 
    } 
     
    public function _isValidColor($confVal, $val) { 
        if(is_array($confVal)) { 
            return $val >= $confVal[0] && $val <= $confVal[1]; 
        } else { 
            return $val >= $confVal - $this->_tolerance && $val <= $confVal + $this->_tolerance; 
        } 
    } 
     
    public function getOrderedColors($pic) { 
        $size = getimagesize($pic); 
        if(!$size) { 
            return false; 
        } 
         
        $width = $size[0]; 
        $height = $size[1]; 
        $mime = $size['mime']; 
        $func = isset($this->_funcs[$mime]) ? $this->_funcs[$mime] : null; 
        if(!$func) { 
            return false; 
        } 
         
        $im = $func($pic); 
        if(!$im) { 
            return false; 
        } 
 
        $total = $width * $height; 
        $nums = array(); 
        for($i = 0; $i < $width; $i++) { 
            for($m = 0; $m < $height; $m++) { 
                $color_index = imagecolorat($im, $i, $m); 
                $color_tran = imagecolorsforindex($im, $color_index); 
                $alpha = $color_tran['alpha']; 
                unset($color_tran['alpha']); 
                if(100 < $alpha || in_array($color_tran, $this->_ignoreColors)) { 
                    continue; 
                } 
 
                foreach ($this->_colors as $colorid => $color) { 
                    if($this->_isValidColor($color['red'], $color_tran['red']) 
                        && $this->_isValidColor($color['green'], $color_tran['green']) 
                        && $this->_isValidColor($color['blue'], $color_tran['blue']) 
                    ) { 
                        $nums[$colorid] = isset($nums[$colorid]) ? $nums[$colorid] + 1 : 1; 
                    } 
                } 
            } 
        } 
         
        imagedestroy($im); 
        arsort($nums); 
        return $nums; 
    } 
     
    public function getMajorColor($pic) { 
        $nums = $this->getOrderedColors($pic); 
        $keys = array_keys($nums); 
        return $keys[0]; 
    } 
} 






















die;
echo "<table border=1>";



echo "<tr>";

$red = 255; $green = 255; $blue = 255;

for($r = 100; $r <= 255; $r ++){
	for($g = 41; $g <= 50; $g ++){
		for($b = 31; $b <= 40; $b ++){
			if($b%10 == 0){
				echo "</tr><tr>";
			}
			echo "<td style='background-color:rgb($r,$g,$b)'>&nbsp;&nbsp;&nbsp;</td><td>rgb(" . $r . "," . $g . "," . $b . ")</td>";	
			
		}
	}
}

echo "<table>";

//red(rgb(0~100, 0~40, 0~40))



$file = 'butterfly.jpg';

$size = array(
    'width'  => 256,
    'height' => 100,
);

$image = new Imagick($file);

$histogram = array_fill_keys(range(0, 255), 0);

foreach ($image->getImageHistogram() as $pixel) {
    $rgb = $pixel->getColor();

    $histogram[$rgb['r']] += $pixel->getColorCount();
    $histogram[$rgb['g']] += $pixel->getColorCount();
    $histogram[$rgb['b']] += $pixel->getColorCount();
}

$max = max($histogram);

$threshold = ($image->getImageWidth() * $image->getImageHeight()) / 256 * 12;

if ($max > $threshold) {
    $max = $threshold;
}

$image = new Imagick();
$draw  = new ImagickDraw();

$image->newImage($size['width'], $size['height'], 'white');

foreach ($histogram as $x => $count) {
    if ($count == 0) {
        continue;
    }

    $draw->setStrokeColor('black');

    $height = min($count, $max) / $max * $size['height'];

    $draw->line($x, $size['height'], $x, $size['height'] - $height);

    $image->drawImage($draw);

    $draw->clear();
}

$image->setImageFormat('png');

$image->writeImage('histogram.png');