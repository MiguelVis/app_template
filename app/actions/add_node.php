<?php

	// ---------------------
	// AppTemplate: Add Node
	// ---------------------

	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	function addNode() {
		global $db;
		
		//
		$ret  = '';
		
		if(array_key_exists('node_name', $_POST)
			&& array_key_exists('node_url', $_POST)) {
				
			$nodeName     = $_POST['node_name'];
			$nodeURL      = $_POST['node_url'];
			$nodeEnabled  = array_key_exists('node_enabled', $_POST);
			
			// Check if record already exists
			if(!Node :: existsByName($nodeName)) {
				// Add node
				$node = new Node();
				
				$node -> setName($nodeName);
				$node -> setURL($nodeURL);
				$node -> setEnabled($nodeEnabled);
	
				if(!$node -> write()) {
					$ret = 'CantAddNode';
				}

				// -->
			}
			else {
				$ret = 'NodeAlreadyExists';
			}
		}
		else {
			$ret = 'MissingParameters';
		}
		
		// -->
		
		return $ret;
	}
	
	//
	$ret = addNode();
	
	if($ret != '') {
		$app_error = $ret;
	}
?>