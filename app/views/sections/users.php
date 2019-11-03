<?php
  
	// ------------------------
	// AppTemplate: Users Table
	// ------------------------

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
	require_once(dirname(__FILE__) . '/../libs/populate_nodes.php');
	
	
	$table_cfg = array(
		'id' => 'users',
		'columns' => array(
			array('title' => tr('Id'), 'sortBy' => 'id'),
			array('title' => tr('Username'), 'sortBy' => 'name'),
			array('title' => tr('Fullname'), 'sortBy' => 'fullname'),
			array('title' => tr('Role'), 'sortBy' => 'role'),
			array('title' => tr('Enabled')),
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
		$rows[$i] = array(
			$recs[$i]['id'],
			$recs[$i]['username'],
			$recs[$i]['fullname'],
			$recs[$i]['role'],
			($recs[$i]['enabled'] > 0 ? '<i class="fa fa-check fa-fw w3-text-green"></i>' : '<i class="fa fa-times  fa-fw w3-text-red"></i>'),
			NiceTable::drawIcon(NiceTable::ICON_INFO, 'rec_info(recs['.$i.'])').
				NiceTable::drawIcon(NiceTable::ICON_EDIT, 'rec_edit(recs['.$i.'])').
				NiceTable::drawIcon(NiceTable::ICON_DELETE, 'rec_delete(recs['.$i.'])').
				NiceTable::drawIcon(NiceTable::ICON_NODES, 'rec_nodes(recs['.$i.'])')
				);
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
    <div class="w3-modal-content w3-card-8 w3-animate-zoom x-modal-medium">
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
        <h2><i class="fa fa-plus-square"></i>&nbsp;&nbsp;<?php say('AddUser'); ?></h2>
      </header>
	  
      <form class="w3-container" method="post" action="index.php?action=add_user">
        <div class="w3-section">
          <label><b><?php say('Username'); ?></b></label>
          <input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" name="user_username" required>
          <label><b><?php say('Password'); ?></b></label>
          <input class="w3-input w3-margin-bottom w3-border" type="password" placeholder="" name="user_password" required>
		  <label><b><?php say('Fullname'); ?></b></label>
          <input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" name="user_fullname" required>
		  <label><b><?php say('Role'); ?></b></label>
		  <select class="w3-select w3-margin-bottom w3-border" name="user_role_id" required>
				<?php populateRoles(); ?>
		  </select>
		  <label><b><?php say('Enabled'); ?></b></label>
		  <input class="w3-input w3-margin-bottom w3-check" type="checkbox" name="user_enabled" value="1" checked>
		  <hr>
          <button class="w3-btn w3-green" type="submit"><?php say('Save'); ?></button>
		  <button class="w3-btn w3-gray" type="button" onclick="document.getElementById('modal_add').style.display='none'"><?php say('Cancel'); ?></button>
        </div>
      </form>
    </div>
  </div>
  
  <!-- ###################### MODAL: EDIT RECORD ############################# -->
  
  <div id="modal_edit" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom x-modal-medium">
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
    <div class="w3-modal-content w3-card-8 w3-animate-zoom x-modal-medium">
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

  <!-- ###################### MODAL: EDIT NODES ############################# -->
  
  <div id="modal_nodes" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom x-modal-large">
      <header class="w3-container w3-modal-header"> 
        <span onclick="document.getElementById('modal_nodes').style.display='none'" class="w3-closebtn">&times;</span>
        <h2><i class="fa fa-cubes"></i>&nbsp;&nbsp;<?php say('EditUserNodes'); ?> &nbsp;|&nbsp; <span id="modal_nodes_id"></span></h2>
      </header>
	  
      <form class="w3-container" method="post" action="index.php?action=edit_user_nodes">
        <div class="w3-section">
		  <input class="" type="hidden" id="modal_nodes_id_hidden" name="user_id" value="">
		
          <label><b><?php say('Username'); ?></b></label>
          <input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_nodes_username" value="" disabled>
          
		  
		  <div class="w3-row w3-border">
			<div class="w3-col m8 w3-margin-bottom w3-margin-top w3-padding-left w3-padding-right" id="modal_nodes_tags_content">
			<!--
				<span class="w3-tag w3-round w3-border w3-gray w3-small">Software&nbsp;<span class="w3-border-left x-clickable">&nbsp;<b>&times;</b></span></span>
				<span class="w3-tag w3-round w3-border w3-gray w3-small">Freelance&nbsp;<span class="w3-border-left x-clickable">&nbsp;<b>&times;</b></span></span>
				<span class="w3-tag w3-round w3-border w3-gray w3-small">PHP&nbsp;<span class="w3-border-left x-clickable">&nbsp;<b>&times;</b></span></span>
				<span class="w3-tag w3-round w3-border w3-gray w3-small">Linux&nbsp;<span class="w3-border-left x-clickable">&nbsp;<b>&times;</b></span></span>
			-->
			</div>
			<div class="w3-col m4 w3-padding-left w3-padding-right">
				<select class="w3-input w3-border w3-margin-top w3-margin-bottom" id="modal_nodes_tags_selector">
					<?php populateNodes(); ?>
				</select>
				<button class="w3-btn w3-btn-block w3-blue w3-margin-bottom" type="button" onclick="addNodeToUser();">
					<?php say('Add'); ?>
				</button>
				<button class="w3-btn w3-btn-block w3-blue w3-margin-bottom" type="button" onclick="addAllNodesToUser();">
					<?php say('AddAll'); ?>
				</button>
				<button class="w3-btn w3-btn-block w3-blue w3-margin-bottom" type="button" onclick="deleteAllNodesToUser();">
					<?php say('DeleteAll'); ?>
				</button>
			</div>
					
					
		</div>
		  
		  
		  
		  <hr>
          <button class="w3-btn w3-green" type="submit"><?php say('Update'); ?></button>
		  <button class="w3-btn w3-gray" type="button" onclick="document.getElementById('modal_nodes').style.display='none'"><?php say('Cancel'); ?></button>
        </div>
      </form>
    </div>
  </div>

<script>
	// Globals
	var modalNodesTags;
	
	// Init view
	function initSection() {
		
		//
	}
	
	// Record info
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
		document.getElementById('modal_add').style.display = 'block';
	}
	
	// Edit record
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
	
	// Delete record
	function rec_delete(rec) {
		document.getElementById("modal_delete_id").innerHTML       = rec.id;
		document.getElementById("modal_delete_id_hidden").value = rec.id;
		document.getElementById("modal_delete_show").innerHTML = rec.username;
		document.getElementById('modal_delete').style.display  = 'block';
	}
	
	// Edit user nodes
	function rec_nodes(rec) {
		modalNodesTags = new NiceTags("modal_nodes_tags_content", "nodes_ids", "modalNodesTags", "white", "blue");
		modalNodesTags.clear();
		
		for(var i = 0, k = rec.nodes_list.length; i < k; ++i) {
			modalNodesTags.add(rec.nodes_list[i].id, rec.nodes_list[i].name);
		}
		
		document.getElementById("modal_nodes_id").innerHTML       = rec.id;
		
		document.getElementById("modal_nodes_id_hidden").value = rec.id;
		document.getElementById("modal_nodes_username").value      = rec.username;
		
		document.getElementById('modal_nodes').style.display  = 'block';
	}
	
	// Add node
	function addNodeToUser() {
		var selector = document.getElementById('modal_nodes_tags_selector');
		
		if(selector.value > 0) {		
			modalNodesTags.add(selector.value, selector.options[selector.selectedIndex].text);
		}
	}
	
	// Add all nodes to user
	function addAllNodesToUser() {
		var selOptions = document.getElementById('modal_nodes_tags_selector').options;
		
		for(var i = 0, k = selOptions.length; i < k; ++i) {
			if(selOptions[i].value > 0) {
				modalNodesTags.add(selOptions[i].value, selOptions[i].text);
			}
		}
	}
	
	// Remove all nodes to user
	function deleteAllNodesToUser() {
		modalNodesTags.clear();
	}
</script>