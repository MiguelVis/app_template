<?php

	// ---------
	// Log Class
	// ---------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	// Revisions:
	
	// 04 Dec 2017 : mgl : Start.
	
	class Log {
		// Constants
		const TYPE_LOGIN   = 1;
		const TYPE_LOGOUT  = 2;
		const TYPE_LOGNODE = 3;
		
		// Properties
		private $p_id;
		private $p_type;
		private $p_node_id;
		private $p_created_on;
		private $p_created_by_user_id;
		
		// Pseudo properties on full queries
		private $p_node_name;
		private $p_username;
		private $p_user_fullname;
	
		// Constructor
		public function __construct($type = null, $nodeId = null) {
			//
			$this -> p_type    = $type;
			$this -> p_node_id = $nodeId;
		}
		
		// Destructor
		public function __destruct() {
			//
		}
		
		// Private methods ////////////////////////////////////////////////////////
		
		private static function arrToLog($arr) {
			//
			$log = new Log();
			
			//
			$log -> p_id = $arr['id'];
			$log -> p_type = $arr['type'];
			$log -> p_node_id = $arr['node_id'];
			$log -> p_created_on = $arr['created_on'];
			$log -> p_created_by_user_id = $arr['created_by_user_id'];
			
			//
			if(isset($arr['node_name']))     $log -> p_node_name = $arr['node_name'];
			if(isset($arr['username']))      $log -> p_username = $arr['username'];
			if(isset($arr['user_fullname'])) $log -> p_user_fullname = $arr['user_fullname'];

			//
			return $log;
		}
		
		// Public methods: getters ////////////////////////////////////////////////
		
		public function getId() {
			//
			return $this -> p_id;
		}
		
		public function getType() {
			//
			return $this -> p_type;
		}
		
		public function getNodeId() {
			//
			return $this -> p_node_id;
		}
		
		public function getCreatedOn() {
			//
			return $this -> p_created_on;
		}
		
		public function getCreatedByUserId() {
			//
			return $this -> p_created_by_user_id;
		}
		
		public function getNodeName() {
			//
			return $this -> p_node_name;
		}
		
		public function getUsername() {
			//
			return $this -> p_username;
		}
		
		public function getUserFullname() {
			//
			return $this -> p_user_fullname;
		}
		
		
		// Public methods: setters ////////////////////////////////////////////////
		
		public function setType($type) {
			//
			return $this -> p_type = $type;
		}
		
		public function setNodeId($nodeId) {
			//
			return $this -> p_node_id = $nodeId;
		}
		
		// Public methods: other //////////////////////////////////////////////////
		
		public function toArray() {
			//
			$arr = array();
			
			//
			$arr['id'] = $this -> p_id;
			$arr['type'] = $this -> p_type;
			$arr['node_id'] = $this -> p_node_id;
			$arr['created_on'] = $this -> p_created_on;
			$arr['created_by_user_id'] = $this -> p_created_by_user_id;
			
			$arr['node_name'] = $this -> p_node_name;
			$arr['username'] = $this -> p_username;
			$arr['user_fullname'] = $this -> p_user_fullname;

			//
			return $arr;
		}
		
		public static function readById($id) {
			global $db;
			
			//
			$qr = $db -> selectQueryByColumn(
				'logs',
				null,
				'id',
				$id
			);
			
			if($qr !== null && count($qr) > 0) {
				//
				return self :: arrToLog($qr[0]);
			}
			
			//
			return null;
		}
			
		public static function readAll() {
			global $db;
			
			//
			$qr = $db -> selectQuery(
				'logs',
				null
			);
			
			if($qr !== null) {
				//
				$logs = array();
				
				for($i = 0; $i < count($qr); ++$i) {
					$logs[] = self :: arrToLog($qr[$i]);
				}
				
				//
				return $logs;
			}
			
			//
			return null;
		}
		
		public static function readLast($howMany, $full = false) {
			global $db;
			
			if($full) {
				$sql = 'select l.*, n.name as node_name, u.username as username, u.fullname as user_fullname '.
				       'from logs as l left join nodes as n on l.node_id = n.id join users as u on l.created_by_user_id = u.id '.
					   'order by created_on desc limit ' . $howMany . ';';
			}
			else {
				$sql = 'select * from logs order by created_on desc limit ' . $howMany . ';';
			}
			
			$qr = $db -> getQuery($sql);
	
			if($qr !== null) {
				//
				$logs = array();
				
				for($i = 0; $i < count($qr); ++$i) {
					$logs[] = self :: arrToLog($qr[$i]);
				}
				
				//
				return $logs;
			}
			
			//
			return null;
		}
		
		public static function countAll() {
			global $db;
			
			//
			$qr = $db -> countQuery(
				'logs'
			);
			
			//
			return $qr;
		}
		
		public function write() {
			global $db;
			
			//
			if($this -> p_type !== null) {
				
				//
				$now    = Date('Y-m-d H:i:s');
				$userId = Session :: getUserId();
				
				//
				$data   = array(
					'type' => $this -> p_type,
					'node_id' => $this -> p_node_id,
					'created_on' => $now,
					'created_by_user_id' => $userId
				);

				//
				$qr = $db -> insertQuery('logs', $data);
				
				//
				if($qr > 0) {
					//
					$this -> p_id = $db -> getLastInsertId();
					
					// Success			
					return true;
				}
			}

			// Failure
			return false;
		}
		
		public static function justWrite($type, $nodeId = null) {
			$log = new Log($type, $nodeId);
			
			return $log -> write();
		}
		
		public static function deleteById($id) {
			global $db;
			
			//
			$qr = $db -> deleteQueryByColumn('logs', 'id',	$id);
			
			if($qr !== null && count($qr) > 0) {
				//
				return true;
			}
			
			//
			return false;
		}

	}

?>