<?php

	// ------------------------
	// AppTemplate: Delete Node
	// ------------------------

	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	function deleteNode() {
		global $db;
		
		//
		$ret  = '';
		
		if(array_key_exists('node_id', $_POST)) {
				
			$nodeId = $_POST['node_id'];
			
			//
			if(!NOde :: deleteById($nodeId)) {
					$ret = 'CantDeleteNode';
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
	$ret = deleteNode();
	
	if($ret != '') {
		$app_error = $ret;
	}
?>