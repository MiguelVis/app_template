<?php
  
	// ------------------------
	// AppTemplate: Nodes Table
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
	require_once(dirname(__FILE__) . '/../../actions/get_nodes.php');
	
	require_once(dirname(__FILE__) . '/../libs/populate_users.php');
	
	$table_cfg = array(
		'id' => 'nodes',
		'columns' => array(
			array('title' => tr('Id'), 'sortBy' => 'id'),
			array('title' => tr('Name'), 'sortBy' => 'name'),
			array('title' => tr('Enabled')),
			array('title' => tr('Actions'))
		),
		'rows' => array(
		)
	);
	
	// Create table
	$table = new NiceTable($table_cfg);
	
	$table->setGetParams(array('action' => 'nodes'));
	
	// Get page length
	$page_length = $table->getPageLength();
	
	if($table->getSortBy() == '') {
		$table->setSortBy('id');
		$table->setSortOrder('asc');
	}
	
	// Read records
	$records = getNodes($table->getPage(), $page_length, $table->getSortBy(), $table->getSortOrder());
	
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
			$recs[$i]['name'],
			($recs[$i]['enabled'] > 0 ? '<i class="fa fa-check fa-fw w3-text-green"></i>' : '<i class="fa fa-times  fa-fw w3-text-red"></i>'),		
			NiceTable::drawIcon(NiceTable::ICON_INFO, 'rec_info(recs['.$i.'])').
				NiceTable::drawIcon(NiceTable::ICON_EDIT, 'rec_edit(recs['.$i.'])').
				NiceTable::drawIcon(NiceTable::ICON_DELETE, 'rec_delete(recs['.$i.'])').
				NiceTable::drawIcon(NiceTable::ICON_USERS, 'rec_users(recs['.$i.'])')
		);
	}
	
	// Set rows in table
	$table->setRows($rows);

	// Build array of records for JavaScript modals
?>
<script>
	var recs = <?php echo(json_encode($recs)); ?>;
</script>

  <header class="w3-container">
    <h5><b><i class="fa fa-cubes fa-fw"></i> <?php say('Nodes'); ?></b></h5>
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
        <h2><i class="fa fa-info"></i>&nbsp;&nbsp;<?php say('NodeInfo'); ?> &nbsp;|&nbsp; <span id="modal_info_id"></span></h2>
      </header>
	  
      <form class="w3-container" method="post" action="">
        <div class="w3-section">
		  <label><b><?php say('Name'); ?></b></label>
          <input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_info_name" disabled>
		  <label><b><?php say('URL'); ?></b></label>
          <input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_info_url" disabled>
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
        <h2><i class="fa fa-plus-square"></i>&nbsp;&nbsp;<?php say('AddNode'); ?></h2>
      </header>
	  
      <form class="w3-container" method="post" action="index.php?action=add_node">
        <div class="w3-section">
          <label><b><?php say('Name'); ?></b></label>
          <input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" name="node_name" required>
          <label><b><?php say('URL'); ?></b></label>
          <input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" name="node_url" required>
		  <label><b><?php say('Enabled'); ?></b></label>
		  <input class="w3-input w3-margin-bottom w3-check" type="checkbox" name="node_enabled" value="1" checked>
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
        <h2><i class="fa fa-pencil"></i>&nbsp;&nbsp;<?php say('EditNode'); ?> &nbsp;|&nbsp; <span id="modal_edit_id"></span></h2>
      </header>
	  
      <form class="w3-container" method="post" action="index.php?action=edit_node">
        <div class="w3-section">
		  <input class="" type="hidden" id="modal_edit_id_hidden" name="node_id" value="">
		
          <label><b><?php say('Name'); ?></b></label>
          <input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_edit_name" name="node_name" value="">
          <label><b><?php say('URL'); ?></b></label>
          <input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_edit_url" name="node_url" value="">
		  <label><b><?php say('Enabled'); ?></b></label>
		  <input class="w3-input w3-margin-bottom w3-check" type="checkbox" id="modal_edit_enabled" name="node_enabled">
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
        <h2><i class="fa fa-trash"></i>&nbsp;&nbsp;<?php say('DeleteNode'); ?> &nbsp;|&nbsp; <span id="modal_delete_id"></span></h2>
      </header>
	  
      <form class="w3-container" method="post" action="index.php?action=delete_node">
        <div class="w3-section">
			<input class="" type="hidden" id="modal_delete_id_hidden" name="node_id" value="">
			<p>
				<?php echo str_replace('*','<b><span id="modal_delete_show">?</span></b>', tr('AskDeleteNode')); ?>
			</p> 
			<hr>
          <button class="w3-btn w3-red" type="submit"><?php say('Delete'); ?></button>
		  <button class="w3-btn w3-gray" type="button" onclick="document.getElementById('modal_delete').style.display='none'"><?php say('Cancel'); ?></button>
        </div>
      </form>

	  </div>
  </div>
  
  <!-- ###################### MODAL: EDIT USERS ############################# -->
  
  <div id="modal_users" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom x-modal-large">
      <header class="w3-container w3-modal-header"> 
        <span onclick="document.getElementById('modal_users').style.display='none'" class="w3-closebtn">&times;</span>
        <h2><i class="fa fa-users"></i>&nbsp;&nbsp;<?php say('EditNodeUsers'); ?> &nbsp;|&nbsp; <span id="modal_users_id"></span></h2>
      </header>
	  
      <form class="w3-container" method="post" action="index.php?action=edit_node_users">
        <div class="w3-section">
		  <input class="" type="hidden" id="modal_users_id_hidden" name="node_id" value="">
		
          <label><b><?php say('Node'); ?></b></label>
          <input class="w3-input w3-margin-bottom w3-border" type="text" placeholder="" id="modal_users_node" value="" disabled>
          
		  
		  <div class="w3-row w3-border">
			<div class="w3-col m8 w3-margin-bottom w3-margin-top w3-padding-left w3-padding-right" id="modal_users_tags_content">
			</div>
			<div class="w3-col m4 w3-padding-left w3-padding-right">
				<select class="w3-input w3-border w3-margin-top w3-margin-bottom" id="modal_users_tags_selector">
					<?php populateUsers(); ?>
				</select>
				<button class="w3-btn w3-btn-block w3-blue w3-margin-bottom" type="button" onclick="addUserToNode();">
					<?php say('Add'); ?>
				</button>
				<button class="w3-btn w3-btn-block w3-blue w3-margin-bottom" type="button" onclick="addAllUsersToNode();">
					<?php say('AddAll'); ?>
				</button>
				<button class="w3-btn w3-btn-block w3-blue w3-margin-bottom" type="button" onclick="deleteAllUsersToNode();">
					<?php say('DeleteAll'); ?>
				</button>
			</div>
					
					
		</div>
		  
		  
		  
		  <hr>
          <button class="w3-btn w3-green" type="submit"><?php say('Update'); ?></button>
		  <button class="w3-btn w3-gray" type="button" onclick="document.getElementById('modal_users').style.display='none'"><?php say('Cancel'); ?></button>
        </div>
      </form>
    </div>
  </div>


<script>
	// Globals
	var modalUsersTags;
	
	// Init view
	function initSection() {
		
		//
	}
	
	// Record info
	function rec_info(rec) {
		document.getElementById("modal_info_id").innerHTML    = rec.id;
		
		document.getElementById("modal_info_name").value      = rec.name;
		document.getElementById("modal_info_url").value       = rec.url;
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
		document.getElementById("modal_edit_name").value      = rec.name;
		document.getElementById("modal_edit_url").value       = rec.url;
		document.getElementById("modal_edit_enabled").checked = rec.enabled > 0;
		
		document.getElementById('modal_edit').style.display = 'block';
	}
	
	// Delete record
	function rec_delete(rec) {
		document.getElementById("modal_delete_id").innerHTML       = rec.id;
		
		document.getElementById("modal_delete_id_hidden").value    = rec.id;
		document.getElementById("modal_delete_show").innerHTML     = rec.name;
		
		document.getElementById('modal_delete').style.display      = 'block';
	}
	
	// Edit node users
	function rec_users(rec) {
		modalUsersTags = new NiceTags("modal_users_tags_content", "users_ids", "modalUsersTags", "white", "blue");
		modalUsersTags.clear();
		
		for(var i = 0, k = rec.users_list.length; i < k; ++i) {
			modalUsersTags.add(rec.users_list[i].id, rec.users_list[i].name);
		}
		
		document.getElementById("modal_users_id").innerHTML       = rec.id;
		
		document.getElementById("modal_users_id_hidden").value = rec.id;
		document.getElementById("modal_users_node").value      = rec.name;
		
		document.getElementById('modal_users').style.display  = 'block';
	}
	
	// Add user
	function addUserToNode() {
		var selector = document.getElementById('modal_users_tags_selector');
		
		if(selector.value > 0) {		
			modalUsersTags.add(selector.value, selector.options[selector.selectedIndex].text);
		}
	}
	
	// Add all users to node
	function addAllUsersToNode() {
		var selOptions = document.getElementById('modal_users_tags_selector').options;
		
		for(var i = 0, k = selOptions.length; i < k; ++i) {
			if(selOptions[i].value > 0) {
				modalUsersTags.add(selOptions[i].value, selOptions[i].text);
			}
		}
	}
	
	// Remove all users to node
	function deleteAllUsersToNode() {
		modalUsersTags.clear();
	}
</script>