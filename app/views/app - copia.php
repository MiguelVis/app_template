<?php

	// ------------------------------------
	// AppTemplate: Application entry point
	// ------------------------------------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	if(!defined('APP_IS_RUNNING')) {
		exit;
	}
	
	// On entry
	// $app_section = application section by name
	// $app_error   = error message
	
	// Plugins
	require_once __DIR__ . '/../vendor/nice_table/nice_table.php';
	require_once __DIR__ . '/../vendor/nice_graph/nice_graph.php';
	require_once __DIR__ . '/../vendor/nice_graph/nice_graph_category.php';
	require_once __DIR__ . '/../vendor/nice_graph/nice_graph_serie.php';

	// Load data from current logged user
	$user = User :: readById(Session :: getUserId());
	$user_fullname  = $user -> getFullname();
	$user_role  = Role :: readById($user -> getRoleId()) -> getName();
	
	//
	$app_menu = $app_section;
	
	switch($app_section) {
		case 'dashboard' :
				break;
		case 'users' :
		case 'nodes' :
				$app_menu = 'manage';
				break;
		default         :
				break; // FIXME
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo($CF['app_name']); ?></title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="vendor/w3css/w3.css">
		<link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="res/app.css">
		<style>
			html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
		</style>
	</head>
<body class="w3-light-grey" onload="initApp();">
	
<!-- Top container -->
<div class="w3-container w3-top w3-black w3-large w3-padding" style="z-index:4">
  <button class="w3-btn w3-hide-large w3-padding-0 w3-hover-text-green" onclick="w3_open();"><i class="fa fa-bars"></i></button>
  <b><?php echo($CF['app_name']); ?></b>
  <span class="w3-right">
  	<a href="#" class="w3-hover-none w3-hover-text-blue w3-show-inline-block" title="<?php say('AboutInfo'); ?>" onclick="show_info();">
		<i class="fa fa-question-circle"></i>
	</a>
	&nbsp;
	<a href="#" class="w3-hover-none w3-hover-text-red w3-show-inline-block" title="<?php say('Logout'); ?>" onclick="show_logout();">
		<i class="fa fa-power-off"></i>
	</a>
  </span>
</div>

<!-- Sidenav/menu -->
<nav class="w3-sidenav w3-collapse" style="z-index:3;width:250px;" id="mySidenav"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <!--img src="http://www.w3schools.com/w3images/avatar2.png" class="w3-circle w3-margin-right" style="width:46px"-->
	  <i class="fa fa-user-circle-o w3-xxxlarge w3-margin-right w3-text-black "></i>
    </div>
    <div class="w3-col s8">
      <strong><?php echo($user_fullname); ?></strong>
	  <br>
	  <?php echo($user_role); ?>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5><?php say('Menu'); ?></h5>
  </div>
  <!--a href="#" class="w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a-->
<?php

	// Abreviations for menus and sections
	$dm = $app_menu;
	$ds = $app_section;
	$dc = ' w3-green';

?>
	<a href="index.php?action=dashboard" class="w3-padding<?php if($ds == 'dashboard') echo($dc); ?>">
		<i class="fa fa-dashboard fa-fw"></i> <?php say('Dashboard'); ?>
	</a>
	

	<a href="index.php?action=dashboard2" class="w3-padding<?php if($ds == 'dashboard2') echo($dc); ?>">
		<i class="fa fa-dashboard fa-fw"></i> Dashboard2
	</a>
	<a href="index.php?action=contacts" class="w3-padding<?php if($ds == 'contacts') echo($dc); ?>">
		<i class="fa fa-users fa-fw"></i> Contacts
	</a>
	

<?php
	// Only ADMIN users can see MANAGE section ///////////////////////////////////////////////////////////////
	if($user_role == 'Admin') {
?>	
	<a href="#" class="w3-padding" onclick="show_hide_menu('menu_manage', 'menu_manage_symbol')">
		<i class="fa fa-cogs fa-fw"></i> <?php say('Manage'); ?>
		<span style="float:right" id="menu_manage_symbol">
			<i class="fa fa-chevron-down fa-fw"></i>
		</span>
	</a>

	<div style="display:<?php echo($dm == 'manage' ? 'block' : 'none');?>" id="menu_manage">
		<a href="index.php?action=nodes" class="w3-padding<?php if($ds == 'nodes') echo($dc); ?>">
			&nbsp;&nbsp;&nbsp;<i class="fa fa-cubes fa-fw"></i> <?php say('Nodes'); ?>
		</a>
		<a href="index.php?action=users" class="w3-padding<?php if($ds == 'users') echo($dc); ?>">
			&nbsp;&nbsp;&nbsp;<i class="fa fa-users fa-fw"></i> <?php say('Users'); ?>
		</a>
	</div>
<?php
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
  <br>
  <br>
</nav>

<!-- Overlay effect when opening sidenav on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:250px;margin-top:43px;">

  <!-- Section -->
  <div class="w3-margin-bottom">
  
<?php
	require_once(dirname(__FILE__) . '/sections/'.$app_section.'.php');
?> 
  
	</div>
  

	<!-- ################################################### -->

  <!-- Footer -->
  <footer class="w3-container w3-bottom w3-padding w3-gray">
	<?php echo($CF['app_copyright']); ?> <?php say('AllRightsReserved'); ?>
  </footer>
  
  <!-- ###################### MODAL: ERROR FROM ACTION ############################# -->

<?php
	if(isset($app_error)) {
?>
  <div id="modal_show_error" class="w3-modal" style="display: block">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container w3-modal-header"> 
        <span onclick="document.getElementById('modal_show_error').style.display='none'" class="w3-closebtn">&times;</span>
        <h2><?php say('Error'); ?></h2>
      </header>
	  
      <div class="w3-container">
        <div class="w3-section">

		  <p><?php say($app_error); ?></p>
		  
		  <hr>
		
		  <button class="w3-btn w3-green" onclick="document.getElementById('modal_show_error').style.display='none'"><?php say('Continue'); ?></button>
        </div>
      </div>
    </div>
  </div>
<?php
	}
?>

<!-- ###################### MODAL: APP INFORMATION ############################# -->

  <div id="modal_show_info" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom x-modal-medium">
      <header class="w3-container w3-modal-header"> 
        <span onclick="document.getElementById('modal_show_info').style.display='none'" class="w3-closebtn">&times;</span>
        <h2><i class="fa fa-question-circle"></i>&nbsp;&nbsp;<?php say('AboutInfo'); ?></h2>
      </header>
	  
      <div class="w3-container">
        <div class="w3-section">
			<div class="w3-container w3-row">
				 <div class="w3-col s2">
				   <i class="fa fa-money fa-4x" style="color:green; text-shadow: 1px 1px 1px black;"></i>
				 </div>
				 <div class="w3-col s10">
					<strong><?php echo($CF['app_name']); ?></strong> v<?php echo($CF['app_version']); ?>
					<br>
					<?php echo($CF['app_date']); ?>
					<br><br>
				    <?php say('AboutText'); ?>
				    <br><br>
					<a href="http://www.floppysoftware.es" target="_blank">http://www.floppysoftware.es</a>
					<br><br>
					<?php echo($CF['app_copyright']); ?> <?php say('AllRightsReserved'); ?>
				 </div>
			 </div>
		  <hr>
		  <button class="w3-btn w3-green" onclick="document.getElementById('modal_show_info').style.display='none'"><?php say('Continue'); ?></button>
        </div>
      </div>
    </div>
  </div>
  
<!-- ###################### MODAL: APP LOGOUT ############################# -->
  
  <div id="modal_logout" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom x-modal-medium">
      <header class="w3-container w3-modal-header"> 
        <span onclick="document.getElementById('modal_logout').style.display='none'" class="w3-closebtn">&times;</span>
        <h2><i class="fa fa-power-off"></i>&nbsp;&nbsp;<?php say('Logout'); ?></h2>
      </header>
	  
      <form class="w3-container" method="post" action="index.php?action=logout">
        <div class="w3-section">
			<p>
				<?php say('AskLogout'); ?>
			</p> 
			<hr>
          <button class="w3-btn w3-red" type="submit"><?php say('Logout'); ?></button>
		  <button class="w3-btn w3-green" type="button" onclick="document.getElementById('modal_logout').style.display='none'"><?php say('Cancel'); ?></button>
        </div>
      </form>

	  </div>
  </div>

  <!-- End page content -->
</div>

<script>
	// Init App
	function initApp() {
		initSection();
	}
	
	// Get the Sidenav
	var mySidenav = document.getElementById("mySidenav");

	// Get the DIV with overlay effect
	var overlayBg = document.getElementById("myOverlay");

	// Toggle between showing and hiding the sidenav, and add overlay effect
	function w3_open() {
		if (mySidenav.style.display === 'block') {
			mySidenav.style.display = 'none';
			overlayBg.style.display = "none";
		} else {
			mySidenav.style.display = 'block';
			overlayBg.style.display = "block";
		}
	}

	// Close the sidenav with the close button
/*
	function w3_close() {
		mySidenav.style.display = "none";
		overlayBg.style.display = "none";
	}
*/	

	// Show - hide a menu
	function show_hide_menu(menuId, symbId) {
		var sect = document.getElementById(menuId);
		var symb = document.getElementById(symbId);
		
		if(sect.style.display == "none") {
			sect.style.display = "block";
			symb.innerHTML = '<i class="fa fa-chevron-up fa-fw"></i>';
		}
		else {
			sect.style.display = "none";
			symb.innerHTML = '<i class="fa fa-chevron-down fa-fw"></i>';
		}
	}
	
	// Show information modal
	function show_info() {
		document.getElementById("modal_show_info").style.display = 'block';
	}
	
	// Show logout modal
	function show_logout() {
		document.getElementById("modal_logout").style.display = 'block';
	}
</script>

<script type='text/javascript' src="vendor/nice_table/nice_table.js"></script>
<script type='text/javascript' src='vendor/nice_tags/nice_tags.js'></script>

</body>
</html>
