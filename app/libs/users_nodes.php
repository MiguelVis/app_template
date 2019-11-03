<?php

	// ----------------
	// UsersNodes Class
	// ----------------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	// Revisions:
	
	// 04 Dec 2017 : mgl : Start.
	
	class UsersNodes {
	
		// Constructor
		private function __construct() {
			//
		}
		
		// Destructor
		private function __destruct() {
			//
		}
		
		// Private methods ////////////////////////////////////////////////////////
				
		// Public methods: getters ////////////////////////////////////////////////
				
		// Public methods: setters ////////////////////////////////////////////////
				
		// Public methods: other //////////////////////////////////////////////////
		
		public static function readUsersIdsByNodeId($nodeId) {
			global $db;
			
			//
			$qr = $db -> selectQueryByColumn(
				'users_nodes',
				null,
				'node_id',
				$nodeId
			);
			
			if($qr !== null) {
				
				$usersIds = array();
				
				if(count($qr) > 0) {			
					foreach($qr as $r) {
						$usersIds[] = $r['user_id'];
					}
				}
				
				return $usersIds;
			}
			
			//
			return null;
		}
		
		public static function readUsersListByNodeId($nodeId) {
			global $db;

			//
			$qr = $db->getQuery('select u.id, u.fullname from users_nodes as un join users as u on un.user_id = u.id where un.node_id = "' . $nodeId . '";');

			if($qr !== null) {

				$usersList = array();
				
				if(count($qr) > 0) {
					foreach($qr as $r) {
						$usersList[] = array(
							'id'   => $r['id'],
							'name' => $r['fullname']
						);
					}
				}
				
				return $usersList;
			}
			
			//
			return null;
		}
		
		public static function readNodesIdsByUserId($userId) {
			global $db;
			
			//
			$qr = $db -> selectQueryByColumn(
				'users_nodes',
				null,
				'user_id',
				$userId
			);
			
			if($qr !== null) {
				
				$nodesIds = array();
				
				if(count($qr) > 0) {			
					foreach($qr as $r) {
						$nodesIds[] = $r['node_id'];
					}
				}
				
				return $nodesIds;
			}
			
			//
			return null;
		}
		
		public static function readNodesListByUserId($userId) {
			global $db;

			//
			$qr = $db->getQuery('select n.id, n.name from users_nodes as un join nodes as n on un.node_id = n.id where un.user_id = "' . $userId . '";');

			if($qr !== null) {

				$nodesList = array();
				
				if(count($qr) > 0) {
					foreach($qr as $r) {
						$nodesList[] = array(
							'id'   => $r['id'],
							'name' => $r['name']
						);
					}
				}
				
				return $nodesList;
			}
			
			//
			return null;
		}
		
		public static function writeUserIdNodeId($userId, $nodeId) {
			global $db;
			
			//
			$qr = $db -> insertQuery(
				'users_nodes',
				array(
					'user_id' => $userId,
					'node_id' => $nodeId
				)
			);
			
			//
			if($qr > 0) {
				
				// Success
				return true;
			}
			
			// Failure
			return false;
		}
		
		public static function writeNodesIdsByUserId($userId, $nodesIds) {
			foreach($nodesIds as $nodeId) {
				if(!self :: writeUserIdNodeId($userId, $nodeId)) {
					// Failure
					return false;
				}
			}
			
			// Success
			return true;
		}
		
		public static function writeUsersIdsByNodeId($nodeId, $usersIds) {
			foreach($usersIds as $userId) {
				if(!self :: writeUserIdNodeId($userId, $nodeId)) {
					// Failure
					return false;
				}
			}
			
			// Success
			return true;
		}	
		
		public static function deleteUserIdNodeId($userId, $nodeId) {
			global $db;
			
			//
			$qr = $db -> setQuery('delete from users_nodes where user_id = "' . $userId . '" and node_id = "' . $nodeId . '";');
			
			if($qr !== null && count($qr) > 0) {
				//
				return true;
			}
			
			//
			return false;
		}
		
		public static function deleteUsersIdsByNodeId($nodeId, $usersIds) {
			foreach($usersIds as $userId) {
				if(!self :: deleteUserIdNodeId($userId, $nodeId)) {
					// Failure
					return false;
				}
			}
			
			// Success
			return true;
		}
		
		public static function deleteNodesIdsByUserId($userId, $nodesIds) {
			foreach($nodesIds as $nodeId) {
				if(!self :: deleteUserIdNodeId($userId, $nodeId)) {
					// Failure
					return false;
				}
			}
			
			// Success
			return true;
		}
		
		public static function deleteAllNodesIdsByUserId($userId) {
			global $db;
			
			//
			$qr = $db -> deleteQueryByColumn('users_nodes', 'user_id',	$userId);
			
			if($qr !== null && count($qr) > 0) {
				//
				return true;
			}
			
			//
			return false;
		}
		
		public static function deleteAllUsersIdsByNodeId($nodeId) {
			global $db;
			
			//
			$qr = $db -> deleteQueryByColumn('users_nodes', 'node_id',	$nodeId);
			
			if($qr !== null && count($qr) > 0) {
				//
				return true;
			}
			
			//
			return false;
		}
		

	}

?>