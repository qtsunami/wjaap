<?php
class imageSet {
	//验证码
	public function verity($len = 4,$type = 'ALL') {
		$im = imagecreatetruecolor(80,30);
		$bgcolor = imagecolorallocate($im,192,192,192);
		imagefill($im,0,0,$bgcolor);
		$fontcolor = imagecolorallocate($im,111,116,241);
		$fontfile = './simkai.ttf';
		$start = $type == 'NUMBER' ? 52 : 0;
		$end = $type == 'LETTER' ? 51 : 61;
		$str_rand = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		for($i = 0; $i < $len; $i++) {
			$str .= $str_rand{mt_rand($start,$end)};
		}
		imagettftext($im,18,0,15,25,$fontcolor,$fontfile,$str);
		for($i = 0; $i < 200; $i++) {
			$pixelcolor = imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			imagesetpixel($im,mt_rand(1,119),mt_rand(1,39),$pixelcolor);
		}
		$linecolor = imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
		imageline($im,mt_rand(1,40),15,mt_rand(41,80),15,$linecolor);
		imageline($im,mt_rand(1,40),mt_rand(1,15),mt_rand(41,80),mt_rand(16,30),$linecolor);
		header('Content-Type:image/png');
		imagepng($im);
	}
	//图像缩略
	public function imageSave($source_path,$save_width,$save_height,$save_path = null) {
		$source_info = getimagesize($source_path);
		$source = $this->imageSize($source_info,$source_path);
		$source_file = $source['src_createfunc']($source_path);
		$src_width = $source_info[0];
		$src_height = $source_info[1];
		//根据提供的宽或高进行比例缩略
		if($save_width >= $save_height) {
			$save_height = $save_width * ($src_height/$src_width);
		}else if($save_width < $save_height) {
			$save_width = $save_height * ($src_width/$src_height);
		}
		$image_save = imagecreatetruecolor($save_width,$save_height);
		imagecopyresampled($image_save,$source_file,0,0,0,0,$save_width,$save_height,$src_width,$src_height);
		if($save_path == null) {
			header('Content-Type:' . $source_info['mime']);
			$source['src_loadfunc']($image_save);
		}else {
			$source['src_loadfunc']($image_save,$save_path);
		}
	}
	//文字水印 ????????????? 文字水印的位置
	public function textWater($image_path,$fontfile='simkai.ttf',$txt) {
		$source_info = getimagesize($image_path);
		$imageform = $this->imageSize($source_info,$image_path);
		$image = $imageform['src_createfunc']($image_path);
		$org_width = $source[0];
		$org_height = $source[1];
		$fontcolor = imagecolorallocate($image,26,136,136);
		imagettftext($image,18,0,mt_rand(20,800),30,$fontcolor,$fontfile,$txt);
		header('Content-Type:' . $source_info['mime']);
		$imageform['src_loadfunc']($image);
	}
	//图像水印
	public function imageWater($image_path,$water_path,$topath = null,$position) {
		
		$im = imagecreatetruecolor(308,256);

		$big_im = getimagesize($image_path);		
		$big = $this->imageSize($big_im,$image_path);
		$big_image = $big['src_createfunc']($image_path);
		
		$dst_x = 0;
		$dst_y = 0;
		imagecopymerge($im,$big_image,$dst_x,$dst_y,0,0,$big_im[0],$big_im[1],100);

		$small_im = getimagesize($water_path);
		$small = $this->imageSize($small_im,$water_path);
		$sml_image = $small['src_createfunc']($water_path);
		$dst_x1 = 154;
		$dst_y1 = 0;
		imagecopymerge($im,$sml_image,$dst_x1,$dst_y1,0,0,$small_im[0],$small_im[1],100);
		if($topath === null) {
			header('Content-Type:' . $im['mime']);
			$big['src_loadfunc']($im);
		}else {
			$big['src_loadfunc']($big_image,$topath);
		}
	}
	public function imageSize($type,$source_path) {
		switch($type['mime']) {
		case 'image/jpeg':
			$src_createfunc = 'imagecreatefromjpeg';
			$src_loadfunc = 'imagejpeg';
			break;
		case 'image/png':
			$src_createfunc = 'imagecreatefrompng';
			$src_loadfunc = 'imagepng';
			break;
		case 'image/gif':
			$src_createfunc = 'imagecreatefromgif';
			$src_loadfunc = 'imagegif';
			break;
		default:
			throw new Exception('文件类型不符合' . $source_path);
		}
		return array('src_createfunc' => $src_createfunc,
							'src_loadfunc' => $src_loadfunc);
	}
	public function position($big_im,$small_im,$position = 1) {
		switch($position) {
			case 1:
				$dst_x = 5;
				$dst_y = 5;
				break;
			case 2:
				$dst_x = ($big_im[0] - $small_im[0]) / 2;
				$dst_y = 5;
				break;
			case 3:
				$dst_x = $big_im[0] - $small_im[0] - 5;
				$dst_y = 5;
				break;
			case 4:
				$dst_x = 5;
				$dst_y = ($big_im[1] - $small_im[1]) / 2;
				break;
			case 5:
				$dst_x = ($big_im[0] - $small_im[0]) / 2;
				$dst_y = ($big_im[1] - $small_im[1]) / 2;
				break;
			case 6:
				$dst_x = $big_im[0] - $small_im[0] - 5;
				$dst_y = ($big_im[1] - $small_im[1]) / 2;
				break;
			case 7:
				$dst_x = 5;
				$dst_y = $big_im[1] - $small_im[1] - 5;
				break;
			case 8:
				$dst_x = ($big_im[0] - $small_im[0]) / 2;
				$dst_y = $big_im[1] - $small_im[1] - 5;
				break;
			case 9:
				$dst_x = $big_im[0] - $small_im[0] - 5;
				$dst_y = $big_im[1] - $small_im[1] - 5;
				break;
			default:$dst_x = 5; $dst_y = 5;
		}
		return array('dst_x' => $dst_x,'dst_y' => $dst_y);
	}
}
$image = new imageSet();
$image_path = 'http://mxss.imoxiu.com.dev.moxiu.net/preview/540d2e053b3763e515818a417bc5dbd6a02ad223/154';
$water_path = 'http://mxss.imoxiu.com.dev.moxiu.net/preview/557436b6c7355df6232c847624d38a5cee71490b/154';
$image->imageWater($image_path,$water_path,null,1);



die;
//$image->imageSave($image_path,102,80);
//$image->verity();
$image_path = 'images/hehe.jpg';
$txt = '从头再来，人定胜天';
$image->textWater($image_path,'simkai.ttf',$txt);

