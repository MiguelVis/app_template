<?php

	// ------------------------
	// AppTemplate: Update User
	// ------------------------

	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	function editUser() {
		global $db;
		
		//
		$ret  = '';
		
		if(array_key_exists('user_id', $_POST)
			&& array_key_exists('user_username', $_POST)
			&& array_key_exists('user_password', $_POST)
			&& array_key_exists('user_fullname', $_POST)
			&& array_key_exists('user_role_id', $_POST)) {

			$userId       = $_POST['user_id'];
			$userUsername = $_POST['user_username'];
			$userPassword = $_POST['user_password'];
			$userFullname = $_POST['user_fullname'];
			$userRoleId   = $_POST['user_role_id'];
			$userEnabled  = array_key_exists('user_enabled', $_POST);
			
			// Avoid to store two users with the same username
			$user = User :: readById($userId);
			
			if($user !== null) {
				//
				$user -> setPassword($userPassword);
				$user -> setFullname($userFullname);
				$user -> setRoleId($userRoleId);
				$user -> setEnabled($userEnabled);
				
				//
				if($userUsername !== $user -> getUsername()) {
					if(!User :: existsByUsername($userUsername)) {
						$user -> setUsername($userUsername);
					}
					else {
						$ret = 'UserAlreadyExists';
					}
				}
				
				if($ret == '') {
					if(!$user -> write()) {
						$ret = 'CantUpdateUser';
					}
				}
				
				// -->
			}
			else {
				$ret = 'UserNotExists';
			}
		}
		else {
			$ret = 'MissingParameters';
		}
		
		// -->
		
		return $ret;
	}
	
	//
	$ret = editUser();
	
	if($ret != '') {
		$app_error = $ret;
	}
?>