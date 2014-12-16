<?php
include_once 'header.php';
include_once 'header.tpl';
$language_file=$lang->getFileDir("language.php");
include($language_file);
?>
<script language="javascript">
var domain="<?php echo $lang->getDomain();?>";
var cur_language="<?php echo $current_language;?>";
function change_language(lan)
{
	alert("lan");
    setCookie("lang",lan,1,"/",domain,false);
	 if(cur_language==lan)
	 {
		 return ;
	 }
	 <?php if(!$_POST){ ?>
	 document.location.reload();
	 <?php } ?>
}

// writeCookie("myCookie", "my name", 24);

// Stores the string "my name" in the cookie "myCookie" which expires after 24 hours.


function setCookie( name, value, expires, path, domain, secure ) {

	var today = new Date();
	
	today.setTime( today.getTime() );
	
	if ( expires ) {
	
	expires = expires * 1000 * 60 * 60 * 24;
	
	}
	
	var expires_date = new Date( today.getTime() + (expires) );
	
	document.cookie = name+'='+escape( value ) +
	
	( ( expires ) ? ';expires='+expires_date.toGMTString() : '' ) + //expires.toGMTString()
	
	( ( path ) ? ';path=' + path : '' ) +
	
	( ( domain ) ? ';domain=' + domain : '' ) +
	
	( ( secure ) ? ';secure' : '' );

}


</script>
<ul>
 <?php
foreach($languages as $key=>$value)
{
  echo '<li><a href="javascript://" onclick="change_language(\'',$key,'\')"';
   echo '>',$language_message[$languages[$key]["name"]],' <img src="images/',$languages[$key]["image"],'" border="0"/></a></li>';
}
?>
</ul>