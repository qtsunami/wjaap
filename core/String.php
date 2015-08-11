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

    
    /**
     * randString 随机产生字符串， 可用来自动生成密码 
     * 默认长度6位 字母和数字混合   支持中文
     * @param int $len
     * @param string $type
     * @param string $addChars
     * @return void
     */
    public static function randString ($len = 6, $type = '', $addChars = '') {
        $str = '';
        switch ($type) {
            case 0: 
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
                break;
            case 1:
                $chars = str_repeat('0123456789', 3);
                break;
            case 2:
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
                break;
            case 3:
                $chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
                break;
            case 4:
                $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借" . $addChars;
                break;
            default :
                // 默认去掉容易混淆的字符oOLl和数字01，要添加请使用addChars参数
                $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz" . $addChars;
                break;

        }
        if ($len > 10) {
            $chars = $type == 1 ? str_repeat($chars, $len) : str_repeat($chars, 5);
        }
        if ($type != 4) {
            $chars = str_shuffle($chars);
            $str = substr($chars, 0, $len);
        } else {
            // 中文随机字
            for ($i = 0; $i < $len; $i ++){
                $str .= self::msubstr($chars, floor(mt_rand(0, mb_strlen($chars, 'utf-8') - 1)), 1, 'utf-8', false);
            }
        }
        return $str;
         
    }


    /**
     * buildConutRand 生成一定数量的随机数，并且不重复
     *
     * @param mixed $number
     * @param int $length
     * @param int $mode
     * @return void
     */
    public static function buildConutRand ($number, $length = 4, $mode = 1) {
        if ($mode == 1 && $length < strlen($number)) {
            // 不足以生成一定数量的不重复数字
            return false; 
        }
        $rand = array();
        for ($i = 0; $i < $number; $i ++) {
            $rand[] = self::randString($length, $mode); 
        }
        $unique = array_unique($rand);
        if (count ($unique) == count($rand)) {
            return $rand; 
        }

        $count = count($rand) - count(unique);
        for ($i = 0; $i < $count * 3; $i ++) {
            $rand[] = self::randString($length, $mode); 
        }
        $rand = array_slice(array_unique($rand), 0, $number);
        return $rand;
    }



    /**
     * buildFormatRand 带格式生成随机字符，支持批量生成
     *
     * @param mixed $format
     * @param int $number
     * @return void
     */
    public static function buildFormatRand ($format, $number = 1) {
        $str = array();
        $length = strlen($format);
        for ($j = 0; $j < $number; $j ++) {
            $strtemp = '';
            for ($i = 0; $i < $length; $i ++) {
                $char = substr($format, $i, 1);
                switch ($char) {
                    case "*": // 字母、数字混合
                        $strtemp .= String::randString(1);
                        break;
                    case "#": // 数字
                        $strtemp .= String::randString(1, 1);
                        break;
                    case "$": // 大写字母
                        $strtemp .= String::randString(1, 2);
                        break;
                    default:
                        $strtemp .= $char;
                        break;
                }
            }
            $str[] = $strtemp;
        }

        return $number == 1? $strtemp : $str;
    
    }


    /**
     * RandNumber 获取一定范围内的随机数字 位数不足补零
     *
     * @param mixed $min
     * @param mixed $max
     * @return void
     */
    public static function RandNumber ($min, $max) {
        return sprintf("%0" . strlen($max) . "d", mt_rand($min, $max)); 
    }

	/**
	 * 获取用户的真实IP
	 * 
	 * @return string
	 */
	public static function getRealAddr () {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	/**
	 * 阻止SQL注入
	 * @param string $input
	 * @return string
	 */
	public static function clean ($input) {
		if (is_array($input)) {
			foreach ($input as $key => $val) {
				$output[$key] = self::clean($val);
			}
		} else {
			$output = (string) $input;
			if (get_magic_quotes_gpc()) {
				$output = stripslashes($output);
			}
			$output = htmlentities($output, ENT_QUOTES, 'UTF-8');
		}
		return $output;
	}

	/**
	 * 检测用户位置
	 * @param string $ip
	 * @return string
	 */
	public static function detectCity ($ip) {
		$default = "UNKNOWN";
		$curlopt_useraget = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)";
		
		$url = "http://ipinfodb.com/ip_locator.php?ip=" . urlencode($ip);
		$ch = curl_init();

		$curl_opt = array(
			CURLOPT_FOLLOWLOCATION  => 1,
			CURLOPT_HEADER			=> 0,
			CURLOPT_RETURNTRANSFER  => 1,
			CURLOPT_USERAGENT		=> $curlopt_useragent,
			CURLOPT_URL				=> $url,
			CURLOPT_TIMEOUT			=> 1,
			CURLOPT_REFERER			=> 'http://' . $_SERVER['HTTP_HOST'],
		);

		curl_setopt_array($ch, $curl_opt);

		$content = curl_exce($ch);
		
		if (!is_null($curl_info)) {
			$curl_info = curl_getinfo($ch);
		}

		curl_close();

		if (preg_match('{<li>City : ([^<]*)</li>}i', $content, $regs)) {
			$city = $regs[1];
		}

		if (preg_match('{<li>State/Province : ([^<]*)</li>}i', $content, $regs)) {
			$state = $regs[1];
		}

		if ($city != '' && $state != '') {
			$location = $city . ',' . $state;
			return $location;
		} else {
			return $default;
		}

	}

	/**
	 * 获取Web页面源代码
	 * @param string $url
	 * @return string
	 */
	public static function displaySourceCode ($url) {
		$lines = file($url);
		$output = "";

		foreach ($lines as $line_num => $line) {
			$output .= "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br>\n";
		}

		return $output;
	}

	/*
	 * 确定任意图片的主导颜色
	 * @param string $url
	 * @return string
	 */
	public static function dominantColor ($image) {
		$color = array();
		$i = imagecreatefromjpeg($image);
		for ($x=0;$x<imagesx($i);$x++) {
			for ($y=0;$y<imagesy($i);$y++) {
				$rgb = imagecolorat($i,$x,$y);
				$r   = ($rgb >> 16) & 0xFF;
				$g   = ($rgb >>  & 0xFF;
				$b   = $rgb & 0xFF;
				$rTotal += $r;
				$gTotal += $g;
				$bTotal += $b;
				$total++;
			}
		}
		$color['r'] = round($rTotal/$total);
		$color['g'] = round($gTotal/$total);
		$color['b'] = round($bTotal/$total);
		return $color;
	}


	/*
	 * 解压文件
	 * 
	 * @return string
	 */
	public static function unzip ($location, $newLocation) {
		if(exec("unzip $location",$arr)){
			mkdir($newLocation);
			for($i = 1;$i< count($arr);$i++){
				$file = trim(preg_replace("~inflating: ~","",$arr[$i]));
				copy($location.'/'.$file,$newLocation.'/'.$file);
				unlink($location.'/'.$file);
			}
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/*
	 * 目录清单
	 * 
	 * @return string
	 */
	public static function listFiles ($dir) {
		if (is_dir($dir)) {
			if ($handle = opendir($dir)) {
				while (($file = readdir($handle)) !== false) {
					if ($file != "." && $file != ".." && $file != "Thumbs.db") {
						echo '<a target="_blank" href="' . $dir . $file . '">' . $file . '</a><br />' . PHP_EOL;
					}
				}
				closedir($handle);
			}
		}
	}


	/*
	 * 检测用户语言
	 * 
	 * @return string
	 */
	public static function getClientLanguage ($availableLanguages, $default = 'en') {
		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
			foreach ($langs as $value) {
				$choice = substr($value, 0, 2);
				if (in_array($choice, $availableLanguages)) {
					return $choice;
				}
			}
		}
		return $default;
	}


	/*
	 * 获取当前页面的URL
	 * 
	 * @return string
	 */
	public static function currentURL () {
		$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$valid_url = str_replace("&", "&amp;", $url);
		return $avlid_url;
	}


	/**
	 * 使用tinyurl 生成短网址
	 *
	 * @return string
	 */
	public static function getTinyUrl ($url) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURL_OPT_URL, 'http://tinyurl.com/api-create.php?url='.$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
		$data = curl_exec($ch);  
		curl_close($ch);  
		return $data;  
	}










}

// echo String::uuid();
echo String::keyGen();
