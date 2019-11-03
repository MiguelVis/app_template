<?php

	// ----------
	// Node Class
	// ----------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	// Revisions:
	
	// 03 Dec 2017 : mgl : Start.
	
	class Node {
		// Properties
		private $p_id;
		private $p_name;
		private $p_url;
		private $p_enabled;
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
		
		private static function arrToNode($arr) {
			//
			$user = new Node();
			
			//
			$user -> p_id = $arr['id'];
			$user -> setName($arr['name']);
			$user -> setURL($arr['url']);
			$user -> setEnabled($arr['enabled'] > 0 ? true : false);
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
		
		public function getName() {
			//
			return $this -> p_name;
		}
		
		public function getURL() {
			//
			return $this -> p_url;
		}

		public function getEnabled() {
			//
			return $this -> p_enabled;
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
		
		public function setName($name) {
			//
			return $this -> p_name = $name;
		}
		
		public function setURL($url) {
			//
			return $this -> p_url = $url;
		}

		public function setEnabled($enabled) {
			//
			return $this -> p_enabled = $enabled;
		}
		
		// Public methods: other //////////////////////////////////////////////////
		
		public function toArray() {
			//
			$arr = array();
			
			//
			$arr['id'] = $this -> p_id;
			$arr['name'] = $this -> p_name;
			$arr['url'] = $this -> p_url;
			$arr['enabled'] = $this -> p_enabled;
			$arr['created_on'] = $this -> p_created_on;
			$arr['created_by_user_id'] = $this -> p_created_by_user_id;
			$arr['updated_on'] = $this -> p_updated_on;
			$arr['updated_by_user_id'] = $this -> p_updated_by_user_id;

			//
			return $arr;
		}
		
		public static function existsByName($name) {
			global $db;
			
			//
			$qr = $db -> countQueryByColumn('nodes', 'name', $name);

			//
			return $qr > 0;
		}
		
		public static function readById($id) {
			global $db;
			
			//
			$qr = $db -> selectQueryByColumn(
				'nodes',
				null,
				'id',
				$id
			);
			
			if($qr !== null && count($qr) > 0) {
				//
				return self :: arrToNode($qr[0]);
			}
			
			//
			return null;
		}
		
		public static function readAll() {
			global $db;
			
			//
			$qr = $db -> selectQuery(
				'nodes',
				null
			);
			
			if($qr !== null) {
				//
				$nodes = array();
				
				for($i = 0; $i < count($qr); ++$i) {
					$nodes[] = self :: arrToNode($qr[$i]);
				}
				
				//
				return $nodes;
			}
			
			//
			return null;
		}
		
		public static function countAll() {
			global $db;
			
			//
			$qr = $db -> countQuery(
				'nodes'
			);
			
			//
			return $qr;
		}
		
		public function write() {
			global $db;
			
			//
			if($this -> p_name !== null && $this -> p_url !== null && $this -> p_enabled !== null) {
				
				//
				$now    = Date('Y-m-d H:i:s');
				$userId = Session :: getUserId();
				
				// Common data
				$data   = array(
					'name' => $this -> p_name,
					'url' => $this -> p_url,
					'enabled' => $this -> p_enabled ? 1 : 0,
				);
				
				//
				if($this -> p_id === null) {
					// Insert
					$data['created_on'] = $now;
					$data['created_by_user_id'] = $userId;
					
					//
					$qr = $db -> insertQuery('nodes', $data);
					
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
						
					$qr = $db -> updateQueryByColumn('nodes', $data, 'id', $this -> p_id);
					
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
			$qr = $db -> deleteQueryByColumn('nodes', 'id',	$id);
			
			if($qr !== null && count($qr) > 0) {
				//
				return true;
			}
			
			//
			return false;
		}
	}

?>