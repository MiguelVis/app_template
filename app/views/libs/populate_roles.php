<?php
  
	// ------------------------------------------
	// AppTemplate: Populate roles in html select
	// ------------------------------------------

	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.

	function populateRoles($selectedId = null) {
		
		//
		$roles = Role :: readAll();
		
		//
		if($roles !== null) {
			//
			echo('<option value="" '.($selectedId === null ? 'selected ' : '').'disabled>'.tr('SelectRole').'</option>');
			
			foreach($roles as $role) {
				//
				$roleId = $role -> getId();
				
				//
				echo('<option value="'.$roleId.'"'.($roleId == $selectedId ? ' selected' : '').'>'.$role -> getName().'</option>'."\n");
			}
		}
	}
?>