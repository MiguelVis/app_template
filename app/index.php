<?php

	// ------------------------------------
	// AppTemplate: Application entry point
	// ------------------------------------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	define('APP_IS_RUNNING', true);

	require_once(dirname(__FILE__) . '/libs/includes.php');
	
	if(array_key_exists('login_username', $_POST) && array_key_exists('login_password', $_POST) && Session :: getSessionId() === null) {
		$username = trim($_POST['login_username']);
		$password = trim($_POST['login_password']);

		if($username !== '') {
			if(Session :: logIn($username, $password)) {
				if(APP_HAS_LOGS) {
					Log :: justWrite(Log :: TYPE_LOGIN);
				}
			}
		}
	}

	if(Session :: getSessionId() !== null) {
		
		if(isset($_REQUEST['action'])) {

			// Execute action
			switch($_REQUEST['action']) {
				
				// Session actions
				case 'logout' :
					if(APP_HAS_LOGS) {
						Log :: justWrite(Log :: TYPE_LOGOUT); // Write log before user really logouts because we'll have user_id == null
					}
					
					Session :: logOut();
					
					header('Location: index.php');
					break;
				
				// App actions
				case 'add_user' :
				case 'edit_user' :
				case 'delete_user' :
				case 'edit_user_nodes' :
					$app_action  = $_REQUEST['action'];
					$app_section = 'users';
					break;
				
				case 'add_node' :
				case 'edit_node' :
				case 'delete_node' :
				case 'edit_node_users' :
					$app_action  = $_REQUEST['action'];
					$app_section = 'nodes';
					break;
				
				case 'add_contact' :
					print_r($_POST);exit; ///////////////////////////
					
				// App sections
				case 'dashboard' :
				case 'users' :
				case 'dashboard2' : ///////////////////////////
				case 'contacts' : ////////////////////////////
				case 'nodes' :
					$app_section = $_REQUEST['action'];
					break;
				
				// Unknown
				default :
					break; // FIXME
			}
			
			// Perform an app action?
			if(isset($app_action)) {
				require_once(dirname(__FILE__) . '/actions/'.$app_action.'.php');
			}
			
			// Go to an app section?
			if(isset($app_section)) {
				require_once(dirname(__FILE__) . '/views/app.php');
			}
		}
		else {
			header('Location: index.php?action=dashboard');
		}
	}
	else {
		require_once(dirname(__FILE__) . '/views/login.php');
	}
?>