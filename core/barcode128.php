<?php

class Barcode128{

    const STARTA = 103;
    const STARTB = 104;
    const STARTC = 105;
    const STOP = 106;

    private $unit_width = 1;
    private $is_set_height = false;
    private $width = -1;
    private $height = 35;
    private $quiet_zone = 6;
    private $font_height = 15;
    private $font_type = 4;
    private $color = 0x000000;
    private $bgcolor = 0xFFFFFF;
    private $image = null;
    private $codes = array("212222","222122","222221","121223","121322","131222","122213","122312","132212","221213","221312","231212","112232","122132","122231","113222","123122","123221","223211","221132","221231","213212","223112","312131","311222","321122","321221","312212","322112","322211","212123","212321","232121","111323","131123","131321","112313","132113","132311","211313","231113","231311","112133","112331","132131","113123","113321","133121","313121","211331","231131","213113","213311","213131","311123","311321","331121","312113","312311","332111","314111","221411","431111","111224","111422","121124","121421","141122","141221","112214","112412","122114","122411","142112","142211","241211","221114","413111","241112","134111","111242","121142","121241","114212","124112","124211","411212","421112","421211","212141","214121","412121","111143","111341","131141","114113","114311","411113","411311","113141","114131","311141","411131","211412","211214","211232","2331112");
    private $valid_code = -1;
    private $type ='B';
    private $start_codes =array('A'=>self::STARTA,'B'=>self::STARTB,'C'=>self::STARTC);
    private $code ='';
    private $bin_code ='';
    private $text ='';


    public function __construct($code = '', $text = '', $type = 'C')
    {
        $type = in_array($type, array('A', 'B', 'C')) ? $type : 'C';
        $this->setType($type);

        if ($code !== '') $this->setCode($code);
        if ($text !== '') $this->setText($text);
    }


    public function setUnitWidth($unit_width)
    {
        $this->unit_width = $unit_width;
        $this->quiet_zone = $this->unit_width * 6;
        $this->font_zone = $this->unit_width * 15;
        if (!$this->is_set_height) $this->height = $this->unit_width * 35;
    }

    public function setFontType($font_type)
    {
        $this->font_type = $font_type;
    }

    public function setBgcolor($bgcolor) 
    {
        $this->bgcolor = $bgcolor;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function setCode($code) 
    {
        if ($code != '') {
            $this->code = $code;
            if ($this->text == '') $this->text = $code;
        }

    }

    public function setText($text) 
    {
        $this->text = $text;
    }

    public function setType($type)
    {
        $this->type = $type;
    }


    public function setHeight($height) 
    {
        $this->height = $height;
        $this->is_set_height = true;
    }

    private function getValueFromChar($ch)
    {
        $val = ord($ch);
        try {
            switch ($this->type) {
                case 'A':
                    if ($val > 95) throw new Exception(' illegal barcode character '.$ch.' for code128A in '.__FILE__.' on line '.__LINE__);
                    if ($val < 32) {
                        $val += 64;
                    } else {
                        $val -= 32;
                    }
                    break;
                case 'B':
                    if ($val < 32 || $val > 127) {
                        throw new Exception(' illegal barcode character '.$ch.' for code128B in '.__FILE__.' on line '.__LINE__);
                    } else {
                        $val -= 32;
                    }

                    break;
                case 'C':
                    if (!is_numeric($ch) || (int)$ch < 0 || (int)$ch > 99 || strlen($ch) == 1) {
                        throw new Exception(' illegal barcode character '.$ch.' for code128C in '.__FILE__.' on line '.__LINE__);
                    } else {
                        $val = (int) $ch;
                    }
                    break;
                default:
                    break;
            }
        } catch(Exception $e) {
            echo $e->getMessage();die;
        }
        return $val;
    }

    private function parseCode()
    {
        $this->type=='C'?$step=2:$step=1;
        $val_sum = $this->start_codes[$this->type];
        $this->width = 35;
        $this->bin_code = $this->codes[$val_sum];

        for($i =0;$i<strlen($this->code);$i+=$step) {
            $this->width +=11;
            $ch = substr($this->code,$i,$step);
            $val = $this->getValueFromChar($ch);
            $val_sum += ($i/$step+1)*$val;
            $this->bin_code .= $this->codes[$val];
        }

        $this->width *=$this->unit_width;
        $val_sum = $val_sum%103;
        $this->valid_code = $val_sum;
        $this->bin_code .= $this->codes[$this->valid_code];
        $this->bin_code .= $this->codes[self::STOP];
    }

    public function getValidCode(){
        if ($this->valid_code == -1)
            $this->parseCode();
        return $this->valid_code;
    }
    public function getWidth()
    {
        if ($this->width ==-1)
            $this->parseCode();
        return $this->width;
    }

    public function getHeight()
    {
        if ($this->width ==-1)
            $this->parseCode();
        return $this->height;
    }


    public function createBarCode($image_type ='png',$file_name=null)
    {
        $this->parseCode();
        $this->image = imagecreate($this->width+2*$this->quiet_zone,$this->height + $this->font_height); 
        $this->bgcolor = imagecolorallocate($this->image,$this->bgcolor >> 16,($this->bgcolor >> 8)&0x00FF,$this->bgcolor & 0xFF);
        $this->color = imagecolorallocate($this->image,$this->color >> 16,($this->color >> 8)&0x00FF,$this->color & 0xFF);
        imagefilledrectangle($this->image, 0, 0, $this->width + 2*$this->quiet_zone,$this->height + $this->font_height, $this->bgcolor); 
        $sx = $this->quiet_zone;
        $sy =  -1;
        $fw = 10; //編號為2或3的字體的寬度為10，為4或5的字體寬度為11
        if ($this->font_type >3) {
            $sy++;
            $fw=11;
        }
        $ex = 0;
        $ey = $this->height  - 2;
        for($i=0;$i<strlen($this->bin_code);$i++) {
            $ex = $sx + $this->unit_width*(int) $this->bin_code{$i} -1;
            if ($i%2==0) ImageFilledRectangle($this->image, $sx, $sy, $ex,$ey, $this->color); 
            $sx =$ex + 1;
        }
        $t_num = strlen($this->text);
        $t_x = $this->width/$t_num;
        $t_sx = ($t_x -$fw)/2;        //目的为了使文字居中平均分布
        for($i=0;$i<$t_num;$i++) { 
            imagechar($this->image,$this->font_type,6*$this->unit_width +$t_sx +$i*$t_x,$this->height ,$this->text{$i},$this->color);
        }
        if (!$file_name) {
            header("Content-Type: image/".$image_type); 
        }  

        switch ($image_type) {
            case 'jpg':
            case 'jpeg':
                imagejpeg($this->image,$file_name);
                break;
            case 'png':
                imagepng($this->image,$file_name);
                break;
            case 'gif':
                imagegif($this->image,$file_name);
                break;
            default:
                imagepng($this->image,$file_name);
                break;
        }
    }


}

$code = '444004675119';
$text = '';
$type = 'C';
//输出条形码图片
$barcode = new Barcode128($code, $text, $type);//以get方式接收待处理编码、字符、方式
$barcode->setUnitWidth(2);//设置大小
$barcode->createBarCode();//画图







