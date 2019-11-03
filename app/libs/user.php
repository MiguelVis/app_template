<?php

	// ----------
	// User Class
	// ----------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	// Revisions:
	
	// 29 Sep 2017 : mgl : Start.
	
	class User {
		// Properties
		private $p_id;
		private $p_username;
		private $p_password;
		private $p_fullname;
		private $p_enabled;
		private $p_role_id;
		private $p_login_session;
		private $p_login_expiration;
		private $p_logged_on;
		private $p_created_on;
		private $p_created_by_user_id;
		private $p_updated_on;
		private $p_updated_by_user_id;
	
		// Constructor
		public function __construct() {
			//
		}
		
		// Destructor
		public function __destruct() {
			//
		}
		
		// Private methods ////////////////////////////////////////////////////////
		
		private static function arrToUser($arr) {
			//
			$user = new User();
			
			//
			$user -> p_id = $arr['id'];
			$user -> setUsername($arr['username']);
			$user -> setPassword($arr['password']);
			$user -> setFullname($arr['fullname']);
			$user -> setEnabled($arr['enabled'] > 0 ? true : false);
			$user -> setRoleId($arr['role_id']);
			$user -> p_login_session = $arr['login_session'];
			$user -> p_login_expiration = $arr['login_expiration'];
			$user -> p_logged_on = $arr['logged_on'];
			$user -> p_created_on = $arr['created_on'];
			$user -> p_created_by_user_id = $arr['created_by_user_id'];
			$user -> p_updated_on = $arr['updated_on'];
			$user -> p_updated_by_user_id = $arr['updated_by_user_id'];

			//
			return $user;
		}
		
		// Public methods: getters ////////////////////////////////////////////////
		
		public function getId() {
			//
			return $this -> p_id;
		}
		
		public function getUsername() {
			//
			return $this -> p_username;
		}
		
		public function getPassword() {
			//
			return $this -> p_password;
		}
		
		public function getFullname() {
			//
			return $this -> p_fullname;
		}
			
		public function getEnabled() {
			//
			return $this -> p_enabled;
		}
		
		public function getRoleId() {
			//
			return $this -> p_role_id;
		}
		
		public function getLoggedOn() {
			//
			return $this -> p_logged_on;
		}
		
		public function getCreatedOn() {
			//
			return $this -> p_created_on;
		}
		
		public function getCreatedByUserId() {
			//
			return $this -> p_created_by_user_id;
		}
		
		public function getUpdatedOn() {
			//
			return $this -> p_updated_on;
		}
		
		public function getUpdatedByUserId() {
			//
			return $this -> p_updated_by_user_id;
		}
		
		// Public methods: setters ////////////////////////////////////////////////
		
		public function setUsername($username) {
			//
			return $this -> p_username = $username;
		}
		
		public function setPassword($password) {
			//
			return $this -> p_password = $password;
		}
		
		public function setFullname($fullname) {
			//
			return $this -> p_fullname = $fullname;
		}
		
		public function setEnabled($enabled) {
			//
			return $this -> p_enabled = $enabled;
		}
		
		public function setRoleId($id) {
			//
			return $this -> p_role_id = $id;
		}
		
		// Public methods: other //////////////////////////////////////////////////
		
		public function toArray() {
			//
			$arr = array();
			
			//
			$arr['id'] = $this -> p_id;
			$arr['username'] = $this -> p_username;
			//$arr['password'] = $this -> p_password;
			$arr['fullname'] = $this -> p_fullname;
			$arr['enabled'] = $this -> p_enabled;
			$arr['role_id'] = $this -> p_role_id;
			$arr['logged_on'] = $this -> p_logged_on;
			$arr['created_on'] = $this -> p_created_on;
			$arr['created_by_user_id'] = $this -> p_created_by_user_id;
			$arr['updated_on'] = $this -> p_updated_on;
			$arr['updated_by_user_id'] = $this -> p_updated_by_user_id;

			//
			return $arr;
		}
		
		public static function existsByUsername($username) {
			global $db;
			
			//
			$qr = $db -> countQueryByColumn('users', 'username', $username);

			//
			return $qr > 0;
		}
		
		public static function readById($id) {
			global $db;
			
			//
			$qr = $db -> selectQueryByColumn(
				'users',
				null,
				'id',
				$id
			);
			
			if($qr !== null && count($qr) > 0) {
				//
				return self :: arrToUser($qr[0]);
			}
			
			//
			return null;
		}
			
		public static function readAll() {
			global $db;
			
			//
			$qr = $db -> selectQuery(
				'users',
				null
			);
			
			if($qr !== null) {
				//
				$users = array();
				
				for($i = 0; $i < count($qr); ++$i) {
					$users[] = self :: arrToUser($qr[$i]);
				}
				
				//
				return $users;
			}
			
			//
			return null;
		}
		
		public static function countAll() {
			global $db;
			
			//
			$qr = $db -> countQuery(
				'users'
			);
			
			//
			return $qr;
		}
		
		public function write() {
			global $db;
			
			//
			if($this -> p_username !== null && $this -> p_password !== null && $this -> p_role_id !== null) {
				
				//
				$now    = Date('Y-m-d H:i:s');
				$userId = Session :: getUserId();
				
				// Common data
				$data   = array(
					'username' => $this -> p_username,
					'password' => $this -> p_password,
					'fullname' => $this -> p_fullname,
					'enabled' => $this -> p_enabled ? 1 : 0,
					'role_id' => $this -> p_role_id
				);
				
				//
				if($this -> p_id === null) {
					// Insert
					$data['created_on'] = $now;
					$data['created_by_user_id'] = $userId;
					
					//
					$qr = $db -> insertQuery('users', $data);
					
					//
					if($qr > 0) {
						//
						$this -> p_id = $db -> getLastInsertId();
						
						// Success
						return true;
					}
				}
				else {
					// Update
					$data['updated_on'] = $now;
					$data['updated_by_user_id'] = $userId;
						
					$qr = $db -> updateQueryByColumn('users', $data, 'id', $this -> p_id);
					
					//
					if($qr > 0) {
						
						// Success
						return true;
					}
				}
			}
			
			// Failure
			return false;
		}
		
		public static function deleteById($id) {
			global $db;
			
			//
			$qr = $db -> deleteQueryByColumn('users', 'id',	$id);
			
			if($qr !== null && count($qr) > 0) {
				//
				return true;
			}
			
			//
			return false;
		}

	}

?>