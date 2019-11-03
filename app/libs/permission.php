<?php

	// ----------------
	// Permission Class
	// ----------------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	// Revisions:
	
	// 29 Sep 2017 : mgl : Start.
	
	class Permission {
		// Properties
		private $p_id;
		private $p_name;
	
		// Constructor
		public function __construct() {
			//
		}
		
		// Destructor
		public function __destruct() {
			//
		}
		
		// Private methods ////////////////////////////////////////////////////////
		
		private static function arrToPermission($arr) {
			//
			$perm = new Permission();
			
			//
			$perm -> setId($arr['id']);
			$perm -> setName($arr['name']);
			
			//
			return $perm;
		}
		
		// Public methods: getters ////////////////////////////////////////////////
		
		public function getId() {
			//
			return $this -> p_id;
		}
		
		public function getName() {
			//
			return $this -> p_name;
		}
		
		// Public methods: setters ////////////////////////////////////////////////
		
		public function setId($id) {
			//
			return $this -> p_id = $id;
		}
		
		public function setName($name) {
			//
			return $this -> p_name = $name;
		}
		
		// Public methods: other //////////////////////////////////////////////////
		
		public static function readById($id) {
			global $db;
			
			//
			$qr = $db -> selectQueryByColumn(
				'permissions',
				null,
				'id',
				$id
			);
			
			if($qr !== null && count($qr) > 0) {
				//
				return self :: arrToPermission($qr[0]);
			}
			
			//
			return null;
		}
		
		public static function readAll() {
			global $db;
			
			//
			$qr = $db -> selectQuery(
				'permissions',
				null
			);
			
			if($qr !== null) {
				//
				$perms = array();
				
				for($i = 0; $i < count($qr); ++$i) {
					$perms[] = self :: arrToPermission($qr[$i]);
				}
				
				//
				return $perms;
			}
			
			//
			return null;
		}
		
		public function write() {
			//
		}

	}

?>