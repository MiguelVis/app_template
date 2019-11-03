<?php
  
	// ------------------------------------------------
	// AppTemplate: Create counter widget for dashboard
	// ------------------------------------------------

	// (c) 2017-2019 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.

	function widgetCounter($id, $faIcon, $title, $counter, $bgColor, $tip = null, $target = null) {
		$classClickable = '';
		$onClick = '';
		$attrTitle = '';
		
		if($tip !== null) {
			$attrTitle = 'title="' . $tip . '"';
		}
		
		if($target !== null) {
			$classClickable = 'x-clickable';
			$onClick = 'onclick="javascript:window.location.href=\'' . $target .'\'";';
		}
?>
	<div class="w3-quarter w3-margin-bottom <?php echo($classClickable);?>" <?php echo($onClick . ' ' . $attrTitle);?>>
	  <div class="w3-container w3-<?php echo($bgColor); ?> w3-text-white w3-padding-16 w3-round-large">
		<div class="w3-left w3-text-black"><i class="fa fa-<?php echo($faIcon); ?> w3-xxxlarge"></i></div>
		<div class="w3-right">
		  <h3 id="<?php echo('widget_counter_' . $id . '_value'); ?>"><?php echo($counter >= 0 ? $counter : tr('NotAvailable')); ?></h3>
		</div>
		<div class="w3-clear"></div>
		<h4><?php echo($title); ?></h4>
	  </div>
	</div>
<?php
	}
?>