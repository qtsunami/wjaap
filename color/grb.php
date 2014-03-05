<?php
$i = imagecreatefromjpeg("../white001.jpg");

for ($x=0;$x<imagesx($i);$x++) {
    for ($y=0;$y<imagesy($i);$y++) {
        $rgb = imagecolorat($i,$x,$y);
        $r   = ($rgb >> 16) & 0xFF;
        $g   = ($rgb >> 8) & 0xFF;
        $b   = $rgb & 0xFF;

        $rTotal += $r;
        $gTotal += $g;
        $bTotal += $b;
        $total++;
    }
}

$rAverage = round($rTotal/$total);
$gAverage = round($gTotal/$total);
$bAverage = round($bTotal/$total);

echo "<div style='background-color:rgb($rAverage, $gAverage, $bAverage); width:20px; height:20px;'></div>";




die;
function rgb2hsv($r, $g, $b){


}






die;











header('Content-type: image/jpeg');

$image = new Imagick('xiaoshi.jpg');

$image->adaptiveBlurImage(5,3);
//$image = file_get_contents('xiaoshi.jpg');
echo $image;



die;
$average = new Imagick("xiaoshi.jpg");
echo "<pre>";
print_r($average);die;



$str = '';



/*
$average->quantizeImage( 10, Imagick::COLORSPACE_RGB, 0, false, false );

$average->uniqueImageColors();

function GetImagesColor( Imagick $im ){

    $colorarr = array();

    $it = $im->getPixelIterator();

    $it->resetIterator();

    while( $row = $it->getNextIteratorRow() ){

        foreach ( $row as $pixel ){

            $colorarr[] = $pixel->getColor();

        }

    }

    return $colorarr;

}

$colorarr = GetImagesColor($average);

foreach($colorarr as $val){

    echo "<div style='background-color: rgb({$val['r']},{$val['g']},{$val['b']});width:50px;height:50px;float:left;'></div>";

}
*/