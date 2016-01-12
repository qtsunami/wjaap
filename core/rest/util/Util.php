<?php
namespace library\Rest\util;

class Util {


	public static function stripSlashesIfMagicQuotes ($rawData, $overrideStripSlashes = null)
	{
		$strip = is_null($overrideStripSlashes) ? get_magic_quotes_gpc() : $overrideStripSlashes;
		if ($strip) {
			return self::stripSlashes($rawData);
		}
		return $rawData;
	}



	protected static function stripSlashes($rawData) 
	{
		return is_array($rawData) ? array_map(array('self', 'stripSlashes'), $rawData) : stripSlashes($rawData);
	}





}

