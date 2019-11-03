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
	function getUsers($page, $pageLength, $sortBy, $sortOrder) {
		global $db;
		global $app_error;
		
		//
		$ret = '';
		
		// Read total # of records
		$numrecs = User :: countAll();

		if($numrecs >= 0)
		{
			// Set pagination
			$offset = ($page > 0 ? ' offset '.($page * $pageLength).' ' : '');
			$limit  = ($pageLength > 0 ? ' limit '.$pageLength.' ' : '');
			
			// Read records
			$records = $db->getQuery('select u.*, r.name as role from users as u join roles as r on u.role_id = r.id '.
								'order by '.$sortBy.' '.$sortOrder.$limit.$offset.';');
			// Check result
			if($records !== null) {
				//
				if(APP_HAS_NODES) {
					for($i = 0; $i < count($records); ++$i) {
						$nodesList = UsersNodes :: readNodesListByUserId($records[$i]['id']);
						
						if($nodesList !== null) {
							$records[$i]['nodes_list'] = $nodesList;
						}
						else {
							$ret = 'CantReadUserNodeLinks';
							break;
						}
					}
				}
			}
			else {
				$ret = 'CantReadUsers';
			}
			
			// -->
		}
		else {
			$ret = 'CantReadUsers';
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