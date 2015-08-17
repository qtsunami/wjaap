<?php
header('Content-Type:text/html;charset=utf-8');
function farsinum($str)
 {
   $ret = "";
   for ($i = 0; $i < strlen($str); ++$i) {
         $c = $str[$i];
         if( $c >= '0' && $c <= '9' )
                 $out .= pack("C*", 0xDB, 0xB0 + $c);
         else
                 $ret .= $c;
   }
   return $ret;
 } 

 print_r(farsinum('he12356llo Worlssd '));die;

// Strips the UTF-8 mark: (hex value: EF BB BF)
function trimUTF8BOM($data){ 
	return pack('CCC', 239, 187, 191);
    if(substr($data, 0, 3) == pack('CCC', 239, 187, 191)) {
         return substr($data, 3);
     }
     return $data;
 }


$data = 'abcdessdf';
var_dump(trimUTF8BOM($data));
die;
function microtime_float(){
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}
    $time_start = microtime_float();

die;
//IP

if (@$HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"])
{
	$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
}
elseif (@$HTTP_SERVER_VARS["HTTP_CLIENT_IP"])
{
	$ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
}
elseif (@$HTTP_SERVER_VARS["REMOTE_ADDR"])
{
	$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
}
elseif (getenv("HTTP_X_FORWARDED_FOR"))
{
	$ip = getenv("HTTP_X_FORWARDED_FOR");
}
elseif (getenv("HTTP_CLIENT_IP"))
{
	$ip = getenv("HTTP_CLIENT_IP");
}
elseif (getenv("REMOTE_ADDR"))
{
	$ip = getenv("REMOTE_ADDR");
}
else
{
	$ip = "Unknown";
}

echo $ip;die;

