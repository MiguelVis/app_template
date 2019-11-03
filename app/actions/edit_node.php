<?php

	// ------------------------
	// AppTemplate: Update Node
	// ------------------------

	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	function editNode() {
		global $db;
		
		//
		$ret  = '';
		
		if(array_key_exists('node_id', $_POST)
			&& array_key_exists('node_name', $_POST)
			&& array_key_exists('node_url', $_POST)) {

			$nodeId       = $_POST['node_id'];
			$nodeName     = $_POST['node_name'];
			$nodeURL      = $_POST['node_url'];
			$nodeEnabled  = array_key_exists('node_enabled', $_POST);
			
			// Avoid to store two nodes with the same name
			$node = Node :: readById($nodeId);
			
			if($node !== null) {
				//
				$node -> setURL($nodeURL);
				$node -> setEnabled($nodeEnabled);
				
				//
				if($nodeName !== $node -> getName()) {
					if(!Node :: existsByName($nodeName)) {
						$node -> setName($nodeName);
					}
					else {
						$ret = 'NodeAlreadyExists';
					}
				}
				
				if($ret == '') {
					if(!$node -> write()) {
						$ret = 'CantUpdateNode';
					}
				}
				
				// -->
			}
			else {
				$ret = 'NodeNotExists';
			}
		}
		else {
			$ret = 'MissingParameters';
		}
		
		// -->
		
		return $ret;
	}
	
	//
	$ret = editNode();
	
	if($ret != '') {
		$app_error = $ret;
	}
?>