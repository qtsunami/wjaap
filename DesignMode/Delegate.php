<?php

class CDDelegate {
    
    $cdList = array();
    public function __construct () {
    }

    public function addSong ($song) {
        $this->cdList[] = $song; 
    }

    public function play ($type, $song) {
        $obj = new $type;
        return $obj->playList($this->cdList, $song);
    }

}

class mp3 {  
    public function playList($list) {  
        return $list[$song];  
    }  
}  

class mp4 {  
    public function playList($list) {  
        return $list[$song];  
    }  
}  

$newCd = new CDDelegate();  
$newCd->addSong("1");  
$newCd->addSong("2");  
$newCd->addSong("3");  
$type = 'mp3';  
$oldCd->play('mp3', '1'); 

