<?php

	// --------------------------
	// AppTemplate: configuration
	// --------------------------
	
	// (c) 2017-2019 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
		
	// Report any error
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	define('APP_HAS_NODES', true);
	define('APP_HAS_LOGS', true);

	// Configuration
	global $CF;

	$CF = array();
	
	$CF['app_name']      = 'AppTemplate';
	$CF['app_version']   = '0.01';
	$CF['app_date']      = '21 Sep 2017';
	$CF['app_copyright'] = '&copy; 2017-2019 FloppySoftware.';
	$CF['app_language']  = 'en';
	
	$CF['db_server']     = 'localhost';
	$CF['db_name']       = 'app_template';
	$CF['db_user']       = 'root';
	$CF['db_password']   = '';
	
	$CF['user_session_time'] = '+1 day';
?>