<?php
include_once 'header.php';
include_once 'header.tpl';
$language_file = $lang->getFileDir ( "speak_language.php" );
require_once ($language_file);

print_r($speak_language_message);
?>