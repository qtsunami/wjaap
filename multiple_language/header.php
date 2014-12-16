<?php
include_once (dirname ( __FILE__ ) . "/include/language.php");
$lang = new Language ( );
//print_r($lang->language_area);
$current_language = getCurrentLanguage ();
//print_r($current_language);
function getCurrentLanguage() {
	global $lang, $languages;
	if (array_key_exists ( $lang->language_area, $languages )) {
		return $lang->language_area;
	} else if (array_key_exists ( $lang->language_country, $languages )) {
		return $lang->language_country;
	} else {
		return "en";
	}

}
?>