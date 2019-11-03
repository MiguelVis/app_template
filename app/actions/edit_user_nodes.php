<?php

	// ------------------------------
	// AppTemplate: Update User Nodes
	// ------------------------------

	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	function editUserNodes() {
		global $db;
		
		//
		$ret  = '';
		
		if(array_key_exists('user_id', $_POST)) {

			$userId   = $_POST['user_id'];
			$nodesIds = (array_key_exists('nodes_ids', $_POST) ? $_POST['nodes_ids'] : array());
			
			//
			$nowNodesIds = UsersNodes :: readNodesIdsByUserId($userId);

			if($nowNodesIds !== null) {
				
				//
				if(count($nodesIds) > 0) {
					// Write new user / node relations
					if(count($nowNodesIds) > 0) {
						$nodesIdsToWrite  = array();
					
						foreach($nodesIds as $nodeId) {
							if(!in_array($nodeId, $nowNodesIds)) {
								$nodesIdsToWrite[] = $nodeId;
							}
						}
					}
					else {
						$nodesIdsToWrite = $nodesIds;
					}
					
					if(count($nodesIdsToWrite) > 0) {
						if(!UsersNodes :: writeNodesIdsByUserId($userId, $nodesIdsToWrite)) {
							$ret = 'CantAddUserNodeLink';
						}
					}
					
					// Delete old user / node relations
					if($ret == '' && count($nowNodesIds) > 0) {
						$nodesIdsToDelete = array();
						
						foreach($nowNodesIds as $nodeId) {
							if(!in_array($nodeId, $nodesIds)) {
								$nodesIdsToDelete[] = $nodeId;
							}
						}
						
						if(count($nodesIdsToDelete) > 0) {					
							if(!UsersNodes :: deleteNodesIdsByUserId($userId, $nodesIdsToDelete)) {
								$ret = 'CantDeleteUserNodeLink';
							}
						}
					}
				}
				else if(count($nowNodesIds) > 0) {
					// Delete all user / node relations
					if(!UsersNodes :: deleteAllNodesIdsByUserId($userId)) {
						$ret = 'CantDeleteUserNodeLink';
					}
					
					// -->
				}
				
				// -->
			}
			else {
				$ret = 'CantReadUserNodeLinks';
			}
				// -->
		}
		else {
			$ret = 'MissingParameters';
		}
		
		// -->
		
		return $ret;
	}
	
	//
	$ret = editUserNodes();
	
	if($ret != '') {
		$app_error = $ret;
	}
?>