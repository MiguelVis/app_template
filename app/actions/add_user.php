<?php

	// ---------------------
	// AppTemplate: Add User
	// ---------------------

	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	function addUser() {
		global $db;
		
		//
		$ret  = '';
		
		if(array_key_exists('user_username', $_POST)
			&& array_key_exists('user_password', $_POST)
			&& array_key_exists('user_fullname', $_POST)
			&& array_key_exists('user_role_id', $_POST)) {
				
			$userUsername = $_POST['user_username'];
			$userPassword = $_POST['user_password'];
			$userFullname = $_POST['user_fullname'];
			$userRoleId   = $_POST['user_role_id'];
			$userEnabled  = array_key_exists('user_enabled', $_POST);
			
			// Check if record already exists
			if(!User :: existsByUsername($userUsername)) {
				// Add user
				$user = new User();
				
				$user -> setUsername($userUsername);
				$user -> setPassword($userPassword);
				$user -> setFullname($userFullname);
				$user -> setRoleId($userRoleId);
				$user -> setEnabled($userEnabled);
	
				if(!$user -> write()) {
					$ret = 'CantAddUser';
				}

				// -->
			}
			else {
				$ret = 'UserAlreadyExists';
			}
		}
		else {
			$ret = 'MissingParameters';
		}
		
		// -->
		
		return $ret;
	}
	
	//
	$ret = addUser();
	
	if($ret != '') {
		$app_error = $ret;
	}
?>