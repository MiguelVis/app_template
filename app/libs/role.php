<?php

	// ----------
	// Role Class
	// ----------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	// Revisions:
	
	// 29 Sep 2017 : mgl : Start.
	
	class Role {
		// Properties
		private $p_id;
		private $p_name;
	
		// Constructor
		public function __construct($id = null, $name = null) {
			//
			$this -> p_id = $id;
			$this -> p_name = $name;
		}
		
		// Destructor
		public function __destruct() {
			//
		}
		
		// Private methods ////////////////////////////////////////////////////////
		
		private static function arrToRole($arr) {
			//
			$role = new Role();
			
			//
			$role -> setId($arr['id']);
			$role -> setName($arr['name']);
			
			//
			return $role;
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
				'roles',
				null,
				'id',
				$id
			);
			
			if($qr !== null && count($qr) > 0) {
				//
				return self :: arrToRole($qr[0]);
			}
			
			//
			return null;
		}
		
		public static function readAll() {
			global $db;
			
			//
			$qr = $db -> selectQuery(
				'roles',
				null
			);
			
			if($qr !== null) {
				//
				$roles = array();
				
				for($i = 0; $i < count($qr); ++$i) {
					$roles[] = self :: arrToRole($qr[$i]);
				}
				
				//
				return $roles;
			}
			
			//
			return null;
		}
		
		public function write() {
			//
		}

	}

?>