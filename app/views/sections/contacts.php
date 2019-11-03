<?php
  
	// ---------------------------
	// AppTemplate: Contacts Table
	// ---------------------------

	// (c) 2017-2019 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	if(!defined('APP_IS_RUNNING')) {
		exit;
	}

	// Dependencies
	require_once(dirname(__FILE__) . '/../../actions/get_users.php');
	
	require_once(dirname(__FILE__) . '/../libs/populate_roles.php');
	
	$table_cfg = array(
		'id' => 'users',
		'columns' => array(
			array('title' => tr('Id'), 'sortBy' => 'id'),
			array('title' => tr('Username'), 'sortBy' => 'name'),
			array('title' => tr('Fullname'), 'sortBy' => 'fullname'),
			array('title' => tr('Role'), 'sortBy' => 'role'),
			array('title' => tr('Actions'))
		),
		'rows' => array(
		)
	);
	
	// Create table
	$table = new NiceTable($table_cfg);
	
	$table->setGetParams(array('action' => 'users'));
	
	// Get page length
	$page_length = $table->getPageLength();
	
	if($table->getSortBy() == '') {
		$table->setSortBy('id');
		$table->setSortOrder('asc');
	}
	
	// Read records
	$records = getUsers($table->getPage(), $page_length, $table->getSortBy(), $table->getSortOrder());
	
	$total_recs = $records['total_recs'];
	$paged_recs = $records['paged_recs'];
	$recs       = $records['recs'];

	// Set # of pages in table
	$table->setPages(floor(($total_recs + $page_length - 1) / $page_length));
	
	// Build rows for table
	$rows = array();
	
	for($i = 0; $i < count($recs); ++$i) {
		$rows[$i] = array($recs[$i]['id'], $recs[$i]['username'], $recs[$i]['fullname'], $recs[$i]['role'],		
				NiceTable::drawIcon(NiceTable::ICON_INFO,   'rec_info(recs['.$i.'])').
				NiceTable::drawIcon(NiceTable::ICON_EDIT,   'rec_edit(recs['.$i.'])').
				NiceTable::drawIcon(NiceTable::ICON_DELETE, 'rec_delete(recs['.$i.'])'));
	}
	
	// Set rows in table
	$table->setRows($rows);

	// Build array of records for JavaScript modals  -- FIXME -- función PHP???
?>
<script>
	var recs = <?php echo(json_encode($recs)); ?>;
</script>

  <header class="w3-container">
    <h5><b><i class="fa fa-users fa-fw"></i> <?php say('Users'); ?></b></h5>
	<hr class="w3-border-gray">
  </header>

  <div class="w3-container">
	<div class="w3-right">
		<button class="w3-btn w3-small w3-green" onclick="rec_add();">
			<i class="fa fa-plus-square w3-text-black"></i>&nbsp;&nbsp;<?php say('Add'); ?>
		</button>
	</div>
	
	<br><br>
  
<?php
	$table->draw();
?>
	

  </div>
  
  <!-- ###################### MODAL: RECORD INFO ############################# -->
  
  <div id="modal_info" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container w3-modal-header"> 
        <span onclick="document.getElementById('modal_info').style.display='none'" class="w3-closebtn">&times;</span>
        <h2><i class="fa fa-info"></i>&nbsp;&nbsp;<?php say('UserInfo'); ?> &nbsp;|&nbsp; <span id="modal_info_id"></span></h2>
      </header>
	  
      <form class="w3-container" method="post" action="">
        <div class="w3-section">
		  <label><b><?php say('Username'); ?></b></label>
          <input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_info_username" disabled>
		  <label><b><?php say('Fullname'); ?></b></label>
          <input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_info_fullname" disabled>
		  <label><b><?php say('Role'); ?></b></label>
		  <input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_info_role" disabled>
		  <label><b><?php say('Enabled'); ?></b></label>
		  <input class="w3-input w3-margin-bottom w3-check" type="checkbox" id="modal_info_enabled" disabled>
		  <hr>
		  <button class="w3-btn w3-green" type="button" onclick="document.getElementById('modal_info').style.display='none'"><?php say('Continue'); ?></button>
        </div>
      </form>
    </div>
  </div>
  
  <!-- ###################### MODAL: ADD RECORD ############################# -->
  
  <div id="modal_add" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom x-modal-medium">
	
      <header class="w3-container w3-modal-header"> 
        <span onclick="document.getElementById('modal_add').style.display='none'" class="w3-closebtn">&times;</span>
        <h2><i class="fa fa-plus-square"></i>&nbsp;&nbsp;Add contact</h2>
      </header>
	  
	  <div class="w3-container">
			
      <form class="" method="post" action="index.php?action=add_contact">
        <div class="w3-section">
		
			<div class="w3-row">
				<div class="w3-col m5">
					<label><b>Type</b></label>
					<select class="w3-select w3-margin-bottom w3-border" id="modal_add_genre_id" name="book_genre_id" required>
						<option id="Organization">Organization</option>
						<option id="People">People</option>
					</select>
				</div>
				<div class="w3-col m1 w3-hide-small">
					&nbsp;
				</div>
				<div class="w3-col m6">
					<label><b>Title</b></label>
					<select class="w3-select w3-margin-bottom w3-border" id="modal_add_title_id" name="book_genre_id" required style="font-family:monospace;">
						<option id="Mr">Mr</option>
						<option id="Mrs">Mrs</option>
					</select>
				</div>		
			</div>
			
			<div class="w3-row">
				<div class="w3-col m5">
					<label><b>Name</b></label>
					<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title1" required>
				</div>
				<div class="w3-col m1 w3-hide-small">
					&nbsp;
				</div>
				<div class="w3-col m6">
					<label><b>Surname</b></label>
					<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title2" required>
				</div>		
			</div>
			
			<!-- Tabbed pages -->
		
			<div class="w3-bar">
				<button class="w3-bar-item w3-button w3-border-top w3-border-left tabs_add_contact" onclick="selectTab(this, 'tabs_add_contact', 'sectAddContactAddress')">Address</button>
				<button class="w3-bar-item w3-button w3-border-top w3-border-left w3-border-bottom tabs_add_contact" onclick="selectTab(this, 'tabs_add_contact', 'sectAddContactURLs')">URLs</button>
				<button class="w3-bar-item w3-button w3-border-top w3-border-left w3-border-right w3-border-bottom tabs_add_contact" onclick="selectTab(this, 'tabs_add_contact', 'sectAddContactTags')">Tags</button>
				<div class="w3-rest w3-padding w3-border-bottom x-tab-rest">&nbsp;</div>
			</div>
			 
			<div class="w3-container w3-margin-bottom w3-border-left w3-border-right w3-border-bottom tabs_add_contact" id="sectAddContactAddress">
				<div class="w3-row w3-margin-top">
					<div class="w3-col m12">
						<label><b>Address</b></label>
						<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title3">
					</div>
				</div>
				
				<div class="w3-row">
					<div class="w3-col m5">
						<label><b>City</b></label>
						<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title4">
					</div>
					<div class="w3-col m1 w3-hide-small">
						&nbsp;
					</div>
					<div class="w3-col m6">
						<label><b>ZIP code</b></label>
						<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title5">
					</div>		
				</div>
				
				<div class="w3-row">
					<div class="w3-col m5">
						<label><b>State</b></label>
						<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title6">
					</div>
					<div class="w3-col m1 w3-hide-small">
						&nbsp;
					</div>
					<div class="w3-col m6">
						<label><b>Country</b></label>
						<select class="w3-select w3-margin-bottom w3-border" id="modal_add_genre_id" name="book_genre_id" style="font-family:monospace;">
							<option id="Germany">Germany</option>
							<option id="UnitedStatesOfAmerica">United States of America</option>
							<option id="Spain">Spain</option>
						</select>
					</div>		
				</div>
				
				<div class="w3-row">
					<div class="w3-col m5">
						<label><b>Phone</b></label>
						<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title7">
					</div>
					<div class="w3-col m1 w3-hide-small">
						&nbsp;
					</div>
					<div class="w3-col m6">
						<label><b>Email</b></label>
						<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title8">
					</div>		
				</div>
			</div>
	
			<div class="w3-container w3-margin-bottom w3-border-left w3-border-right w3-border-bottom tabs_add_contact" id="sectAddContactURLs" style="display:none;">
				<div class="w3-row w3-margin-top">
					<div class="w3-col m3">
						<label><b>URL type</b></label>
						<select class="w3-select w3-margin-bottom w3-border" id="modal_add_genre_id" name="book_genre_id" style="font-family:monospace;">
							<option id="Website">Website</option>
							<option id="Facebook">Facebook</option>
							<option id="Twitter">Twitter</option>
							<option id="LinkedIn">LinkedIn</option>
						</select>
					</div>
					<div class="w3-col m1 w3-hide-small">
						&nbsp;
					</div>
					<div class="w3-col m8">
						<label><b>URL</b></label>
						<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title9">
					</div>		
				</div>

			</div>
			
			<div class="w3-container w3-margin-bottom w3-border-left w3-border-right w3-border-bottom tabs_add_contact" id="sectAddContactTags" style="display:none;">
				<div class="w3-row w3-margin-top">
					<div class="w3-col m8 w3-margin-bottom" id="modal_add_tags_content">
					<!--
						<span class="w3-tag w3-round w3-border w3-gray w3-small">Software&nbsp;<span class="w3-border-left x-clickable">&nbsp;<b>&times;</b></span></span>
						<span class="w3-tag w3-round w3-border w3-gray w3-small">Freelance&nbsp;<span class="w3-border-left x-clickable">&nbsp;<b>&times;</b></span></span>
						<span class="w3-tag w3-round w3-border w3-gray w3-small">PHP&nbsp;<span class="w3-border-left x-clickable">&nbsp;<b>&times;</b></span></span>
						<span class="w3-tag w3-round w3-border w3-gray w3-small">Linux&nbsp;<span class="w3-border-left x-clickable">&nbsp;<b>&times;</b></span></span>
					-->
					</div>
					<div class="w3-col m4">
						<div class="w3-col s10">
							<select class="w3-input w3-border" id="modal_add_tag_selector">
								<option value="" selected disabled>Select a tag</option>
								<option value="Facebook">Facebook</option>
								<option value="Twitter">Twitter</option>
								<option value="LinkedIn">LinkedIn</option>
								<option value="Instagram">Instagram</option>
								<option value="Hangouts">Hangouts</option>
								<option value="Google+">Google+</option>
							</select>
						</div>
						<div class="w3-col s2 w3-margin-bottom w3-center">
							<!--button class="w3-btn w3-btn-block w3-blue" type="button" onclick="modalAddNewTag(document.getElementById('modal_add_tag_selector').value);">
								<i class="fa fa-plus-circle"></i>
							</button-->
							<i class="fa fa-check-square fa-2x x-clickable"
							onclick="addTagToContact();"></i>
						</div>
						<div class="w3-col s10">
							<input class="w3-input w3-border" type="text" placeholder="" id="modal_add_tag_input">
						</div>
						<div class="w3-col s2 w3-margin-bottom w3-center">
							<i class="fa fa-check-square fa-2x x-clickable"
							onclick="addNewTagToContact();"></i>
						</div>
					</div>
					
					
				</div>

			</div>

			<button class="w3-btn w3-green" type="submit"><?php say('Save'); ?></button>
			<button class="w3-btn w3-gray" type="button" onclick="document.getElementById('modal_add').style.display='none'"><?php say('Cancel'); ?></button>
		</div>
	</form>
	  
	  </div>
	  
    </div>
  </div>
  
  <!--div id="modal_add" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container w3-modal-header"> 
        <span onclick="document.getElementById('modal_add').style.display='none'" class="w3-closebtn">&times;</span>
        <h2><i class="fa fa-plus-square"></i>&nbsp;&nbsp;Add contact</h2>
      </header>
	  
	  <div class="w3-container">
	  
	  
	<div class="w3-bar w3-white w3-padding-top w3-border-bottom">
		<button class="w3-bar-item w3-button tablink w3-red" onclick="openCity('tabLondon','London')" id="tabLondon">Address</button>
			<button class="w3-bar-item w3-button tablink" onclick="openCity('tabParis','Paris')" id="tabParis">Address</button>
			<button class="w3-bar-item w3-button tablink" onclick="openCity('tabTokyo','Tokyo')" id="tabTokyo">+Info</button>
		  </div>
			
      <form class="" method="post" action="index.php?action=add_contact">
        <div class="w3-section">
		
		
		
			
			 
			
		<div id="London" class="city">
		
			<div class="w3-row">
				<div class="w3-col m5">
					<label><b>Type</b></label>
					<select class="w3-select w3-margin-bottom w3-border" id="modal_add_genre_id" name="book_genre_id" required>
						<option id="Organization">Organization</option>
						<option id="People">People</option>
					</select>
				</div>
				<div class="w3-col m1 w3-hide-small">
					&nbsp;
				</div>
				<div class="w3-col m6">
					<label><b>Gender</b></label>
					<select class="w3-select w3-margin-bottom w3-border" id="modal_add_genre_id" name="book_genre_id" required style="font-family:monospace;">
						<option id="Male">&#9794; Male</option>
						<option id="Female">&#9792; Female</option>
						<option id="Unknown">? Unknown</option>
					</select>
				</div>		
			</div>
			
			<div class="w3-row">
				<div class="w3-col m5">
					<label><b>Name</b></label>
					<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title1" required>
				</div>
				<div class="w3-col m1 w3-hide-small">
					&nbsp;
				</div>
				<div class="w3-col m6">
					<label><b>Surname</b></label>
					<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title2" required>
				</div>		
			</div>
		</div>
		<div id="Paris" class="city" style="display:none">
			
			
			<div class="w3-row">
				<div class="w3-col m12">
					<label><b>Address</b></label>
					<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title3" required>
				</div>
			</div>
			
			<div class="w3-row">
				<div class="w3-col m5">
					<label><b>City</b></label>
					<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title4" required>
				</div>
				<div class="w3-col m1 w3-hide-small">
					&nbsp;
				</div>
				<div class="w3-col m6">
					<label><b>ZIP code</b></label>
					<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title5" required>
				</div>		
			</div>
			
			<div class="w3-row">
				<div class="w3-col m5">
					<label><b>State</b></label>
					<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title6" required>
				</div>
				<div class="w3-col m1 w3-hide-small">
					&nbsp;
				</div>
				<div class="w3-col m6">
					<label><b>Country</b></label>
					<select class="w3-select w3-margin-bottom w3-border" id="modal_add_genre_id" name="book_genre_id" required style="font-family:monospace;">
						<option id="Germany">Germany</option>
						<option id="UnitedStatesOfAmerica">United States of America</option>
						<option id="Spain">Spain</option>
					</select>
				</div>		
			</div>
			
			<div class="w3-row">
				<div class="w3-col m5">
					<label><b>Phone</b></label>
					<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title7" required>
				</div>
				<div class="w3-col m1 w3-hide-small">
					&nbsp;
				</div>
				<div class="w3-col m6">
					<label><b>Email</b></label>
					<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title8" required>
				</div>		
			</div>
		</div>
		 <div id="Tokyo" class="city" style="display:none">
			
		
			<div class="w3-row">
				<div class="w3-col m3">
					<label><b>URL type</b></label>
					<select class="w3-select w3-margin-bottom w3-border" id="modal_add_genre_id" name="book_genre_id" required style="font-family:monospace;">
						<option id="Website">Website</option>
						<option id="Facebook">Facebook</option>
						<option id="Twitter">Twitter</option>
						<option id="LinkedIn">LinkedIn</option>
					</select>
				</div>
				<div class="w3-col m1 w3-hide-small">
					&nbsp;
				</div>
				<div class="w3-col m8">
					<label><b>URL</b></label>
					<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title9" required>
				</div>		
			</div>
			
			<div class="w3-row">
				<div class="w3-col m3">
					<label><b>URL type</b></label>
					<select class="w3-select w3-margin-bottom w3-border" id="modal_add_genre_id" name="book_genre_id" required style="font-family:monospace;">
						<option id="Website">Website</option>
						<option id="Facebook">Facebook</option>
						<option id="Twitter">Twitter</option>
						<option id="LinkedIn">LinkedIn</option>
					</select>
				</div>
				<div class="w3-col m1 w3-hide-small">
					&nbsp;
				</div>
				<div class="w3-col m8">
					<label><b>URL</b></label>
					<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title10" required>
				</div>		
			</div>
			
			<div class="w3-row">
				<div class="w3-col m3">
					<label><b>URL type</b></label>
					<select class="w3-select w3-margin-bottom w3-border" id="modal_add_genre_id" name="book_genre_id" required style="font-family:monospace;">
						<option id="Website">Website</option>
						<option id="Facebook">Facebook</option>
						<option id="Twitter">Twitter</option>
						<option id="LinkedIn">LinkedIn</option>
					</select>
				</div>
				<div class="w3-col m1 w3-hide-small">
					&nbsp;
				</div>
				<div class="w3-col m8">
					<label><b>URL</b></label>
					<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title11" required>
				</div>		
			</div>
			
			<div class="w3-row">
				<div class="w3-col m3">
					<label><b>URL type</b></label>
					<select class="w3-select w3-margin-bottom w3-border" id="modal_add_genre_id" name="book_genre_id" required style="font-family:monospace;">
						<option id="Website">Website</option>
						<option id="Facebook">Facebook</option>
						<option id="Twitter">Twitter</option>
						<option id="LinkedIn">LinkedIn</option>
					</select>
				</div>
				<div class="w3-col m1 w3-hide-small">
					&nbsp;
				</div>
				<div class="w3-col m8">
					<label><b>URL</b></label>
					<input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_add_title" name="book_title12" required>
				</div>		
			</div>

		  
</div>
			<hr>
          <button class="w3-btn w3-green" type="submit"><?php say('Save'); ?></button>
		  <button class="w3-btn w3-green" type="button" onclick="document.getElementById('modal_add').style.display='none'"><?php say('Cancel'); ?></button>		  
        </div>
      </form>
	  
	  </div>
	  
    </div>
  </div-->
  
  <!-- ###################### MODAL: EDIT RECORD ############################# -->
  
  <div id="modal_edit" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container w3-modal-header"> 
        <span onclick="document.getElementById('modal_edit').style.display='none'" class="w3-closebtn">&times;</span>
        <h2><i class="fa fa-pencil"></i>&nbsp;&nbsp;<?php say('EditUser'); ?> &nbsp;|&nbsp; <span id="modal_edit_id"></span></h2>
      </header>
	  
      <form class="w3-container" method="post" action="index.php?action=edit_user">
        <div class="w3-section">
		  <input class="" type="hidden" id="modal_edit_id_hidden" name="user_id" value="">
		
          <label><b><?php say('Username'); ?></b></label>
          <input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_edit_username" name="user_username" value="">
          <label><b><?php say('Password'); ?></b></label>
          <input class="w3-input w3-margin-bottom w3-border" type="password" placeholder="" id="modal_edit_password" name="user_password" value="">
		  <label><b><?php say('Fullname'); ?></b></label>
          <input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_edit_fullname" name="user_fullname" value="" required>
		  <label><b><?php say('Role'); ?></b></label>
		  <select class="w3-select w3-margin-bottom w3-border" id="modal_edit_role_id" name="user_role_id" required>
				<?php populateRoles(); ?>
		  </select>
		  <label><b><?php say('Enabled'); ?></b></label>
		  <input class="w3-input w3-margin-bottom w3-check" type="checkbox" id="modal_edit_enabled" name="user_enabled">
		  <hr>
          <button class="w3-btn w3-green" type="submit"><?php say('Update'); ?></button>
		  <button class="w3-btn w3-gray" type="button" onclick="document.getElementById('modal_edit').style.display='none'"><?php say('Cancel'); ?></button>
        </div>
      </form>
    </div>
  </div>
  
   <!-- ###################### MODAL: DELETE RECORD ############################# -->
  
  <div id="modal_delete" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container w3-modal-header"> 
        <span onclick="document.getElementById('modal_delete').style.display='none'" class="w3-closebtn">&times;</span>
        <h2><i class="fa fa-trash"></i>&nbsp;&nbsp;<?php say('DeleteUser'); ?> &nbsp;|&nbsp; <span id="modal_delete_id"></span></h2>
      </header>
	  
      <form class="w3-container" method="post" action="index.php?action=delete_user">
        <div class="w3-section">
			<input class="" type="hidden" id="modal_delete_id_hidden" name="user_id" value="">
			<p>
				<?php echo str_replace('*','<b><span id="modal_delete_show">?</span></b>', tr('AskDeleteUser')); ?>
			</p> 
			<hr>
          <button class="w3-btn w3-red" type="submit"><?php say('Delete'); ?></button>
		  <button class="w3-btn w3-gray" type="button" onclick="document.getElementById('modal_delete').style.display='none'"><?php say('Cancel'); ?></button>
        </div>
      </form>

	  </div>
  </div>


<script>
	// Globals
	var modalAddTags;
	
	// Init view
	function initSection() {
		
		//
	}
	
	// Show - hide a tabbed content
	function selectTab(elem, className, sectId) {

		var i, x;

		x = document.getElementsByClassName(className);

		for (i = 0; i < x.length; i++) {
			if(x[i].tagName == "BUTTON") {
				//x[i].className = x[i].className.replace(" w3-white", " w3-gray");
				x[i].className = x[i].className.replace(" w3-border-bottom", "");
				x[i].className += " w3-border-bottom";
			}
			else {
				x[i].style.display = "none";
			}
		}

		//elem.className = elem.className.replace(" w3-gray", " w3-white");
		elem.className = elem.className.replace(" w3-border-bottom", "");
		document.getElementById(sectId).style.display = "block";
		
		event.preventDefault();
	}	

	// Modal Info Record
	function rec_info(rec) {
		document.getElementById("modal_info_id").innerHTML  = rec.id;
		document.getElementById("modal_info_username").value    = rec.username;
		document.getElementById("modal_info_fullname").value    = rec.fullname;
		document.getElementById("modal_info_role").value = rec.role;
		document.getElementById("modal_info_enabled").checked = rec.enabled > 0;
		document.getElementById('modal_info').style.display = 'block';
	}
	
	// Modal Add Record
	function rec_add() {
		modalAddTags = new NiceTags("modal_add_tags_content", "modal_add_tags", "modalAddTags", "white", "blue");
		modalAddTags.clear();

		document.getElementById('modal_add').style.display = 'block';
	}
	
	// Modal Edit Record
	function rec_edit(rec) {
		document.getElementById("modal_edit_id").innerHTML    = rec.id;
		document.getElementById("modal_edit_id_hidden").value = rec.id;
		document.getElementById("modal_edit_username").value      = rec.username;
		document.getElementById("modal_edit_password").value  = rec.password;
		document.getElementById("modal_edit_fullname").value      = rec.fullname;
		document.getElementById("modal_edit_role_id").value = rec.role_id;
		document.getElementById("modal_edit_enabled").checked = rec.enabled > 0;
		document.getElementById('modal_edit').style.display = 'block';
	}
	
	// Modal Delete Record
	function rec_delete(rec) {
		document.getElementById("modal_delete_id").innerHTML       = rec.id;
		document.getElementById("modal_delete_id_hidden").value = rec.id;
		document.getElementById("modal_delete_show").innerHTML = rec.username;
		document.getElementById('modal_delete').style.display  = 'block';
	}
	
	//
	function addTagToContact() {
		modalAddTags.add(document.getElementById('modal_add_tag_selector').value, document.getElementById('modal_add_tag_selector').value); // FIXME
	}
	
	function addNewTagToContact() {
		modalAddTags.add(document.getElementById('modal_add_tag_input').value, document.getElementById('modal_add_tag_input').value); // FIXME
	}
</script>