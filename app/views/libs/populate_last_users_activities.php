<?php
  
	// ------------------------------------------
	// AppTemplate: Populate last user activities
	// ------------------------------------------

	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.

	function populateLastUsersActivities($howMany = 10) {
		
		//
		$output = '';
		
		//
		$logEntries = Log :: readLast($howMany, true);

		if($logEntries !== null) {
			for($i = 0; $i < count($logEntries); ++$i) {
				$logEntry = $logEntries[$i];
				
				switch($logEntry -> getType()) {
					case Log :: TYPE_LOGIN :
						$icon = 'sign-in';
						break;
					case Log :: TYPE_LOGOUT :
						$icon = 'sign-out';
						break;
					case Log :: TYPE_LOGNODE :
						$icon = 'plug';
						break;
					default :
						$icon = 'bolt';
						break;
						break;
				}
				
				$output .= '<i class="fa fa-' . $icon . ' fa-fw"></i><span style="font-family:monospace"> ' .
				     $logEntry -> getCreatedOn() . ' | </span>' . $logEntry -> getUserFullname();
					 
				if($logEntry -> getNodeId() !== null) {
					$output .= ' &#8674; <i class="fa fa-cube"></i> ' . $logEntry -> getNodeName();
				}

				if($i < count($logEntries) - 1) {
					$output .= '<br>';
				}
			}
		}
		
		return $output;
	}
?>