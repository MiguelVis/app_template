<?php
  
	// ------------------------------------------
	// AppTemplate: Populate users in html select
	// ------------------------------------------

	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.

	function populateUsers($selectedId = null) {
		
		//
		$users = User :: readAll();
		
		//
		if($users !== null) {
			//
			echo('<option value="" '.($selectedId === null ? 'selected ' : '').'disabled>'.tr('SelectUser').'</option>');
			
			foreach($users as $user) {
				//
				$userId = $user -> getId();
				
				//
				echo('<option value="'.$userId.'"'.($userId == $selectedId ? ' selected' : '').'>'.$user -> getFullname().'</option>'."\n");
			}
		}
	}
?>