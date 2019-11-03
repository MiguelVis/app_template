<?php
  
	// ----------------------
	// AppTemplate: Get Users
	// ----------------------

	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	//
	function getNodes($page, $pageLength, $sortBy, $sortOrder) {
		global $db;
		global $app_error;
		
		//
		$ret = '';
		
		// Read total # of records
		$numrecs = Node :: countAll();

		if($numrecs >= 0)
		{
			// Set pagination
			$offset = ($page > 0 ? ' offset '.($page * $pageLength).' ' : '');
			$limit  = ($pageLength > 0 ? ' limit '.$pageLength.' ' : '');
			
			// Read records
			$records = $db->getQuery('select * from nodes '.
								'order by '.$sortBy.' '.$sortOrder.$limit.$offset.';');
			// Check result
			if($records !== null) {
				for($i = 0; $i < count($records); ++$i) {
					$usersList = UsersNodes :: readUsersListByNodeId($records[$i]['id']);
					
					if($usersList !== null) {
						$records[$i]['users_list'] = $usersList;
					}
					else {
						$ret = 'CantReadUserNodeLinks';
						break;
					}
				}
			}
			else {
				$ret = 'CantReadNodes';
			}
			
			// -->
		}
		else {
			$ret = 'CantReadNodes';
		}

		// -->
		
		if($ret != '') {
			$app_error = $ret;
		}
		
		$ret = array(
			'total_recs' => ($ret == '' ? $numrecs : 0),
			'paged_recs' => ($ret == '' ? count($records) : 0),
			'recs' => ($ret == '' ? $records : array())
		);
		
		return $ret;
	}
?>