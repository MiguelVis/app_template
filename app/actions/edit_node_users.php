<?php

	// ------------------------------
	// AppTemplate: Update Node Users
	// ------------------------------

	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	function editNodeUsers() {
		global $db;
		
		//
		$ret  = '';
		
		if(array_key_exists('node_id', $_POST)) {

			$nodeId   = $_POST['node_id'];
			$usersIds = (array_key_exists('users_ids', $_POST) ? $_POST['users_ids'] : array());
			
			//
			$nowUsersIds = UsersNodes :: readUsersIdsByNodeId($nodeId);

			if($nowUsersIds !== null) {
				
				//
				if(count($usersIds) > 0) {
					// Write new user / node relations
					if(count($nowUsersIds) > 0) {
						$usersIdsToWrite  = array();
					
						foreach($usersIds as $userId) {
							if(!in_array($userId, $nowUsersIds)) {
								$usersIdsToWrite[] = $userId;
							}
						}
					}
					else {
						$usersIdsToWrite = $usersIds;
					}
					
					if(count($usersIdsToWrite) > 0) {
						if(!UsersNodes :: writeUsersIdsByNodeId($nodeId, $usersIdsToWrite)) {
							$ret = 'CantAddUserNodeLink';
						}
					}
					
					// Delete old user / node relations
					if($ret == '' && count($nowUsersIds) > 0) {
						$usersIdsToDelete = array();
						
						foreach($nowUsersIds as $userId) {
							if(!in_array($userId, $usersIds)) {
								$usersIdsToDelete[] = $userId;
							}
						}
						
						if(count($usersIdsToDelete) > 0) {					
							if(!UsersNodes :: deleteUsersIdsByNodeId($nodeId, $usersIdsToDelete)) {
								$ret = 'CantDeleteUserNodeLink';
							}
						}
					}
				}
				else if(count($nowUsersIds) > 0) {
					// Delete all user / node relations
					if(!UsersNodes :: deleteAllUsersIdsByNodeId($nodeId)) {
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
	$ret = editNodeUsers();
	
	if($ret != '') {
		$app_error = $ret;
	}
?>