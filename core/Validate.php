<?php

class Validate {

    public static function isEmail ($email) {
        $pattern = '/^[a-z\p{L}0-9!#$%&\'*+\/=?^`{}|~_-]+[.a-z\p{L}0-9!#$%&\'*+\/=?^`{}|~_-]*@[a-z\p{L}0-9]+[._a-z\p{L}0-9-]*\.[a-z0-9]+$/ui';

        if (defined ('PREG_BAD_UTF8_OFFSET')) {
            $pattern = preg_replace('/\\\[px]\{[a-z]\}{1,2}|(\/[a-z]*)u([a-z]*)$/i', "$1$2", $pattern); 
        }

        return !empty($email) && preg_match($pattern, $email);
    }

    public static function isPhone ($phone) {
        return preg_match("/^1[3578][0-9]{9}$/", $phone);
    }


    public static function isChinese ($data) {
        return preg_match("/^[\x{4e00}-\x{9fa5}a-zA-Z_]$/u", $data);
    }

    /**
     * 是否是md5密文
     * @param string $md5
     * @return bool
    */
    public static function isMd5($md5) {
        return preg_match('/^[a-f0-9A-F]{32}$/', $md5);
    }
    /**
     * 是否是Sha1密文
     * @param string $sha1
     * @return bool
    */
    public static function isSha1($sha1) {
        return preg_match('/^[a-fA-F0-9]{40}$/', $sha1);
    }

    public static function isCleanHtml($html) {
        $events = 'onmousedown|onmousemove|onmmouseup|onmouseover|onmouseout|onload|onunload|onfocus|onblur|onchange';
        $events .= '|onsubmit|ondblclick|onclick|onkeydown|onkeyup|onkeypress|onmouseenter|onmouseleave|onerror|onselect|onreset|onabort|ondragdrop|onresize|onactivate|onafterprint|onmoveend';
        $events .= '|onafterupdate|onbeforeactivate|onbeforecopy|onbeforecut|onbeforedeactivate|onbeforeeditfocus|onbeforepaste|onbeforeprint|onbeforeunload|onbeforeupdate|onmove';
        $events .= '|onbounce|oncellchange|oncontextmenu|oncontrolselect|oncopy|oncut|ondataavailable|ondatasetchanged|ondatasetcomplete|ondeactivate|ondrag|ondragend|ondragenter|onmousewheel';
        $events .= '|ondragleave|ondragover|ondragstart|ondrop|onerrorupdate|onfilterchange|onfinish|onfocusin|onfocusout|onhashchange|onhelp|oninput|onlosecapture|onmessage|onmouseup|onmovestart';
        $events .= '|onoffline|ononline|onpaste|onpropertychange|onreadystatechange|onresizeend|onresizestart|onrowenter|onrowexit|onrowsdelete|onrowsinserted|onscroll|onsearch|onselectionchange';
        $events .= '|onselectstart|onstart|onstop';

        return (!preg_match('/<[ \t\n]*script/ims', $html) && !preg_match('/(' . $events . ')[ \t\n]*=/ims', $html) && !preg_match('/.*script\:/ims', $html) && !preg_match('/<[ \t\n]*i?frame/ims', $html));
    }
	
	/**
	 * 验证邮箱地址是否有效
	 * @param String $email
	 * @return bool
	 */
	public static function isValidEmail ($email) {
		$check = false;
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$check = true;
		}
		return $check;
	}



	/**
	 * 验证URL是否有效
	 * @param String $url
	 * @return bool
	 */
	public static function isValidURL ($url) {
		$check = false;
		if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
			$check = true;
		}
		retirm $check;
	}



}



