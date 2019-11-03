<?php

	// -------------
	// Session Class
	// -------------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	// Revisions:
	
	// 28 Sep 2017 : mgl : Start.
	
	class Session {
		// Properties
		private static $p_session_id;
		private static $p_user_id;
		private static $p_expiration_date;
		
		private static $i_secret = 'TheSecret';
	
		// Constructor
		private function __construct() {
			//
		}
		
		// Destructor
		private function __destruct() {
			//
		}
		
		// Private methods ////////////////////////////////////////////////////////
		
		public static function check() {
			global $db;
			
			// Check relogin
			if(self :: $p_session_id === null || self :: $p_user_id === null || self :: $p_expiration_date === null) {
				
				session_start();
				
				if(isset($_SESSION['session_id'], $_SESSION['user_id'], $_SESSION['expiration_date'])) {
					self :: $p_session_id = $_SESSION['session_id'];
					self :: $p_user_id = $_SESSION['user_id'];
					self :: $p_expiration_date = $_SESSION['expiration_date'];
				}
			}
			
			//
			if(self :: $p_session_id !== null && self :: $p_user_id !== null && self :: $p_expiration_date !== null) {
				// Check if session has expired or user is disabled
				$qr = $db -> selectQueryByColumn('users', array('enabled', 'login_session', 'login_expiration'), 'id', self :: $p_user_id);
				
				if($qr !== null && count($qr) > 0) {
					$r = $qr[0];
					
					// Check session id, session expiration date and if user is enabled
					if($r['enabled'] > 0 &&
					   $r['login_session'] == md5(self :: $p_session_id . self :: $p_user_id . self :: $i_secret) &&
					   $r['login_expiration'] > Date('Y-m-d H:i:s')) {

						// Success
						return true;
					}
				}
			}
			
			// Force logout
			self :: logOut();
	
			// Failure
			return false;			
		}
		
		// Public methods: getters /////////////////////////////////////////////
		
		public static function getSessionId() {
			//
			self :: check();
			
			//
			return self :: $p_session_id;
		}
		
		public static function getUserId() {
			//
			self :: check();
			
			//
			return self :: $p_user_id;
		}
		
		// Public methods: other /////////////////////////////////////////////
		
		public static function logIn($username, $password) {
			global $db;
			global $CF;
			
			// Logout first
			self :: logOut();

			//
			$qr = $db -> selectQueryByColumn('users', array('id', 'password', 'enabled'), 'username', $username);

			if($qr !== null && count($qr) > 0) {
				$r = $qr[0];
						
				// Check password and if enabled
				if($r['enabled'] > 0 && $r['password'] == $password) {
					// Start session
					session_start();
					session_regenerate_id();
					
					//
					self :: $p_session_id = session_id();
					self :: $p_user_id = $r['id'];
					self :: $p_expiration_date = Date('Y-m-d H:i:s', strtotime($CF['user_session_time']));
					
					//
					$_SESSION['session_id'] = self :: $p_session_id;
					$_SESSION['user_id'] = self :: $p_user_id;
					$_SESSION['expiration_date'] = self :: $p_expiration_date;
					
					// Update session in database
					$qr = $db -> updateQueryByColumn(
						'users',
						array(
							'login_session' => md5(self :: $p_session_id . self :: $p_user_id . self :: $i_secret),
							'logged_on' => Date('Y-m-d H:i:s'),
							'login_expiration' => self :: $p_expiration_date,
						),
						'id',
						self :: $p_user_id
					);

					if($qr > 0) {
						// Success
						return true;
					}
				}
			}
			
			// Force logout
			self :: logOut();
			
			// Failure
			return false;
		}
		
		public static function logOut() {
			global $db;
			
			// Logout if there is a logged user
			if(self :: $p_session_id !== null || session_id() !== '') {
				// Delete session in database
				$qr = $db -> updateQueryByColumn(
					'users',
					array(
						'login_session' => '',
						'login_expiration' => '0000-00-00 00:00:00'
					),
					'id',
					self :: $p_user_id
				);
				
				// Reset attributes
				self :: $p_session_id = null;
				self :: $p_user_id = null;
				self :: $p_expiration_date = null;
				
				// Destroy session
				if(session_id() !== '') {
					session_unset();
					session_destroy();
				}
			}
			
			// Success
			return true;				
		}
	
	}

?>