<?php
  
	// ---------------------------------------------
	// AppTemplate: Create list widget for dashboard
	// ---------------------------------------------

	// (c) 2017-2019 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	global $appWidgetListJs;
	
	$appWidgetListJs = false;

	function widgetList($id, $faIcon, $title, $contents) {
		global $appWidgetListJs;
?>
	<div class="w3-half w3-margin-bottom">
	  <div class="w3-container w3-white w3-padding-16">
		<i class="fa fa-<?php echo($faIcon); ?> fa-fw"></i>&nbsp;&nbsp;<strong><?php echo($title); ?></strong>
		<span class="w3-right w3-text-gray">
			<i class="fa fa-chevron-up fa-fw x-clickable" onclick="widgetListToggle('<?php echo($id); ?>');" id="widget_list_<?php echo($id); ?>_toggle"></i>
		</span>
	  </div>
	  <div class="w3-container w3-white w3-padding-16 w3-border-top" id="widget_list_<?php echo($id); ?>_contents">
		<?php echo($contents); ?>
	  </div>
	</div>
<?php
		if(!$appWidgetListJs) {
			$appWidgetListJs = true;
?>			
	<script>
		function widgetListToggle(id) {
			var toggle = document.getElementById('widget_list_' + id + '_toggle');
			var contents = document.getElementById('widget_list_' + id + '_contents');
			
			if(contents.style.display == "none") {
				contents.style.display = "block";
				toggle.classList.remove("fa-chevron-down");
				toggle.classList.add("fa-chevron-up");
			}
			else {
				contents.style.display = "none";
				toggle.classList.remove("fa-chevron-up");
				toggle.classList.add("fa-chevron-down");
			}
		}
	</script>
<?php
		}
	}
?>