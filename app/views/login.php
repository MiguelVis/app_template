<?php

	// -----------------------
	// AppTemplate: User login
	// -----------------------
	
	// (c) 2017-2019 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU General Public License v3.
	
	if(!defined('APP_IS_RUNNING')) {
		exit;
	}
?>
<!DOCTYPE html>
<html>

	<head>
		<title><?php echo($CF['app_name']); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="vendor/w3css/w3.css">
		<link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
	</head>
	
	<body style="background: url('res/background.jpg') no-repeat center fixed; background-size: cover;">

		<div class="w3-container">
<p class="w3-center"><?php echo($CF['app_copyright']); ?></p>
		  <div id="id01" class="w3-modal" style="display:block">
			<div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:400px">
		  
			  <div class="w3-center">
				<br>
				<h2><?php say('Welcome'); ?></h2>
				<i class="fa fa-user-circle-o w3-xxxlarge w3-margin-top"></i>
			  </div>

			  <form class="w3-container" method="post" action="index.php">
				<div class="w3-section">
				  <label><b><?php say('Username'); ?></b></label>
				  <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="" name="login_username" required>
				  <label><b><?php say('Password'); ?></b></label>
				  <input class="w3-input w3-border" type="text" placeholder="" name="login_password" required>
				  <button class="w3-btn-block w3-green w3-section w3-padding" type="submit"><?php say('Login'); ?></button>
				  <!--<input class="w3-check w3-margin-top" type="checkbox" checked="checked"> Remember me-->
				</div>
			  </form>

			  <!--
			  <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
				<span class="w3-right w3-padding w3-hide-small">Forgot <a href="#">password?</a></span>
			  </div>
			  -->

			</div>
		  </div>
		</div>
            
	</body>
</html>