<?php

Class String {

    
    /**
     * uuid 生成UUID  单机使用
     *
     * @return void
     */
    public static function uuid () {
        $charid = md5(uniqid(mt_rand(), true)); 
        $hyphen = chr(45); // "-"
        $uuid = chr(123) // "{"
                .substr($charid, 0, 8) . $hyphen
                .substr($charid, 8, 4) . $hyphen
                .substr($charid,12, 4) . $hyphen
                .substr($charid,16, 4) . $hyphen
                .substr($charid,20,12)
                .chr(125); // "}"

        return $uuid;
    }


    /**
     * keyGen 生成uuid主键
     *
     * @return void
     */
    public static function keyGen () {
        return str_replace('-', '', substr(String::uuid(), 1, -1));
    }

    
    /**
     * isUtf8 检查字符串是否是utf8编码
     *
     * @param mixed $str
     * @return void
     */
    public static function isUtf8 ($str) {
        $c = 0; $b = 0;
        $bits = 0;
        $len = strlen($str);
        for ($i = 0; $i < $len; $i ++) {
            $c = ord($str[$i]);
            if ($c > 128) {
                if ($c >= 254) return false;
                elseif ($c >= 252) $bits = 6;
                elseif ($c >= 248) $bits = 5;
                elseif ($c >= 240) $bits = 4;
                elseif ($c >= 224) $bits = 3;
                elseif ($c >= 192) $bits = 2;
                else return false;
                if (($i + $bits) > $len) return false;
                while ($bits > 1) {
                    $i ++;
                    $b = ord($str[$i]);
                    if ($b < 128 || $b > 191) return false;
                    $bits --;
                }
            }
        }
        return true;
    } 


    /**
     * msubstr 字符串截取，支持中文和其他编码
     *
     * @param mixed $str 需要转换的字符串
     * @param int $start 开始位置
     * @param mixed $length 截取长度
     * @param string $charset 编码格式
     * @param mixed $suffix 截断显示字符
     * @return void
     */
    public static function msubstr ($str, $start = 0, $length, $charset="utf-8", $suffix = true) {
        if (function_exists('mb_substr')) {
            $slice = mb_substr($str, $start, $length, $charset);
        } elseif (function_exists('iconv_substr')) {
            $slice = iconv_substr($str, $start, $length, $charset); 
        } else {
            $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
            preg_match_all($re[$charset], $str, $match);
            $slice = join("",array_slice($match[0], $start, $length));
        }
        return $suffix ? $slice . '...' : $slice;
    }

    
    public static function randString ($len = 6, $type = '', $addChars = '') {
    
    }





















}

// echo String::uuid();
echo String::keyGen();
