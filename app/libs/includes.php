<?php

	// ----------------------
	// AppTemplate: libraries
	// ----------------------
	
	// (c) 2017-2019 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	if(!defined('APP_IS_RUNNING')) {
		exit;
	}
	
	// Libraries
	require_once(dirname(__FILE__) . '/conf.php');
	require_once(dirname(__FILE__) . '/lang.php');
	require_once(dirname(__FILE__) . '/mysql_database.php');
	require_once(dirname(__FILE__) . '/session.php');
	require_once(dirname(__FILE__) . '/user.php');
	require_once(dirname(__FILE__) . '/role.php');
	require_once(dirname(__FILE__) . '/permission.php');
	
	if(APP_HAS_NODES) {
		require_once(dirname(__FILE__) . '/node.php');
		require_once(dirname(__FILE__) . '/users_nodes.php');
	}
	
	if(APP_HAS_LOGS) {
		require_once(dirname(__FILE__) . '/log.php');
	}
		
	// Database
	global $db;

	$db = new MySqlDataBase($CF['db_server'], $CF['db_user'], $CF['db_password'], $CF['db_name']);
	
	$db -> connect();

	////$db -> setQuery('SET NAMES "utf8";');
	
	// App
	global $app_error;
?>