<?php
  
	// --------------------------------
	// AppTemplate: Modal forms helpers
	// --------------------------------

	// (c) 2017-2019 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.

	function modalStart($id, $faIcon, $title, $size) {
?>
	<div id="modal_<?php echo($id); ?>" class="w3-modal">
		<div class="w3-modal-content w3-card-8 w3-animate-zoom x-modal-<?php echo($size); ?>">
			<header class="w3-container w3-modal-header"> 
				<span onclick="document.getElementById('modal_<?php echo($id); ?>').style.display='none'" class="w3-closebtn">&times;</span>
				<h2><i class="fa fa-<?php echo($faIcon); ?>"></i>&nbsp;&nbsp;<?php echo($title); ?></h2>
			</header>
<?php
	}
	
	function modalEnd() {
?>
		</div>
	</div>

<?php
	}
?>