<?php

	// ---------------------
	// AppTemplate: Language
	// ---------------------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.

	//
	global $LG;
	
	switch($CF['app_language']) {
		case 'es' : // Spanish
			require_once(dirname(__FILE__) . '/lang_es.php');
			break;
		case 'en' : // English
		default   :
			require_once(dirname(__FILE__) . '/lang_en.php');
			break;
	}

	//
	function tr($item)
	{
		global $LG;
		
		return array_key_exists($item, $LG) ? $LG[$item] : '[Item missing in language]';
	}
	
	//
	function say($item)
	{
		echo(tr($item));
	}

?>