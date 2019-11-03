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
	require_once(dirname(__FILE__) . '/../libs/widget_counter.php');
	require_once(dirname(__FILE__) . '/../libs/widget_list.php');
	require_once(dirname(__FILE__) . '/../libs/populate_last_users_activities.php');
?>

<header class="w3-container">
	<h5><b><i class="fa fa-dashboard fa-fw"></i> <?php say('Dashboard'); ?></b></h5>
	<hr class="w3-border-gray">
</header>


<div class="w3-row-padding">

<?php	
	widgetCounter('nodes', 'cubes', tr('Nodes'), Node :: countAll(), 'red', tr('NumberOfNodes'), 'index.php?action=nodes');
	widgetCounter('users', 'users', tr('Users'), User :: countAll(), 'blue', tr('NumberOfUsers'), 'index.php?action=users');
	widgetCounter('logins', 'sign-in', tr('Logins'), -1, 'orange');
	widgetCounter('blabla', 'plug', tr('DrConnections'), -1, 'teal');
?>	
	
	<div style="clear:both;"></div>
	
<?php
	widgetList('last_users_activities1', 'users', tr('LastUsersActivities'), populateLastUsersActivities());
	widgetList('last_users_activities2', 'users', tr('LastUsersActivities'), populateLastUsersActivities());
?>
	
	<div style="clear:both;"></div>
	
	<div class="w3-half">
	  <div class="w3-container w3-blue w3-padding">
		<div class="">
			<i class="fa fa-envelope fa-fw"></i>&nbsp;&nbsp;Last messages
			<span class="w3-right w3-badge w3-red">8</span>
		</div>
	  </div>
	  <div class="w3-container w3-white w3-padding-16">
		<strong>Lydia</strong><span class="w3-right">5m ago</span><br>
		Please, confirm if you have received the schedule for the new project. Thanks!
		<hr>
		<strong>John</strong><span class="w3-right">5m ago</span><br>
		What about you, looser?
		<hr>
		<strong>Gerald</strong><span class="w3-right">5m ago</span><br>
		Coffee at 12h o'clock?
		<hr>
		<strong>Ann</strong><span class="w3-right">5m ago</span><br>
		Please, confirm date for new meeting about new team members. Thanks.
		<hr>
		<button class="w3-btn w3-green">More</button>
	  </div>
	</div>
	
	<div class="w3-half">
	  <div class="w3-container w3-blue w3-padding">
		<div class="">
			<i class="fa fa-tasks fa-fw"></i>&nbsp;&nbsp;My tasks
			<span class="w3-right w3-badge w3-red">5</span>
		</div>
	  </div>
	  <div class="w3-container w3-white w3-padding-16">
		<i class="fa fa-check-square fa-fw"></i> Read document for new project
		<hr>
		<i class="fa fa-square-o fa-fw"></i> Create presentation for the boss
		<hr>
		<i class="fa fa-check-square fa-fw"></i> Buy a sandwich
		<hr>
		<i class="fa fa-square-o fa-fw"></i> Have a chat with John about his behaviour
		<hr>
		<i class="fa fa-square-o fa-fw"></i> Check date for new meeting
		<hr>
		<button class="w3-btn w3-green">Add</button>
	  </div>
	</div>
	
	<div style="clear:both; padding-top:16px"></div>
	
	<div class="w3-half">
	  <div class="w3-container w3-blue w3-padding">
		<div class="">
			<i class="fa fa-line-chart fa-fw"></i>&nbsp;&nbsp;Year sales
		</div>
	  </div>
	  <div class="w3-container w3-white w3-padding-16">
		1st term<span class="w3-right">25%</span>
		<div class="w3-grey">
			<div class="w3-container w3-center w3-green" style="width:25%">&nbsp;</div>
		</div>
		2nd term<span class="w3-right">35%</span>
		<div class="w3-grey">
			<div class="w3-container w3-center w3-green" style="width:35%">&nbsp;</div>
		</div>
		3rd term<span class="w3-right">30%</span>
		<div class="w3-grey">
			<div class="w3-container w3-center w3-green" style="width:30%">&nbsp;</div>
		</div>
		4th term<span class="w3-right">10%</span>
		<div class="w3-grey">
			<div class="w3-container w3-center w3-green" style="width:10%">&nbsp;</div>
		</div>
	  </div>
	</div>
	
	<div style="clear:both; padding-top:16px"></div>
	
	<div class="w3-half">
	  <div class="w3-container w3-blue w3-padding-16">
		<i class="fa fa-envelope fa-fw"></i>&nbsp;&nbsp;<strong>Last messages</strong>&nbsp;
		<span class="w3-badge w3-red">8</span>
		<span class="w3-right w3-text-gray">
			<i class="fa fa-chevron-up fa-fw th-fa-clickable" onclick="show_hide_widget('last_messages', 'last_messages_up_down');" id="last_messages_up_down"></i>
			<i class="fa fa-times fa-fw th-fa-clickable"></i>
		</span>
	  </div>
	  <div class="w3-container w3-white w3-padding-16 w3-border-top" id="last_messages">
		<strong>Lydia</strong><span class="w3-right">5m ago</span><br>
		Please, confirm if you have received the schedule for the new project. Thanks!
		<hr>
		<strong>John</strong><span class="w3-right">5m ago</span><br>
		What about you, looser?
		<hr>
		<strong>Gerald</strong><span class="w3-right">5m ago</span><br>
		Coffee at 12h o'clock?
		<hr>
		<strong>Ann</strong><span class="w3-right">5m ago</span><br>
		Please, confirm date for new meeting about new team members. Thanks.
		<hr>
		<button class="w3-btn w3-green">More</button>
	  </div>
	</div>
	
	<div class="w3-half">
	  <div class="w3-container w3-white w3-padding-16">
		<i class="fa fa-tasks fa-fw"></i>&nbsp;&nbsp;<strong>My tasks</strong>&nbsp;
		<span class="w3-badge w3-red">5</span>
		<span class="w3-right w3-text-gray">
			<i class="fa fa-chevron-up fa-fw th-fa-clickable" onclick="show_hide_widget('my_tasks', 'my_tasks_up_down');" id="my_tasks_up_down"></i>
			<i class="fa fa-times fa-fw th-fa-clickable"></i>
		</span>
	  </div>
	  <div class="w3-container w3-white w3-padding-16 w3-border-top" id="my_tasks">
		<i class="fa fa-check-square fa-fw"></i> Read document for new project
		<hr>
		<i class="fa fa-square-o fa-fw"></i> Create presentation for the boss
		<hr>
		<i class="fa fa-check-square fa-fw"></i> Buy a sandwich
		<hr>
		<i class="fa fa-square-o fa-fw"></i> Have a chat with John about his behaviour
		<hr>
		<i class="fa fa-square-o fa-fw"></i> Check date for new meeting
		<hr>
		<button class="w3-btn w3-green theme">Add</button>
	  </div>
	</div>
	
	<div style="clear:both; padding-top:16px"></div>
	
	<div class="w3-half">
	  <div class="w3-container w3-white w3-padding-16">
		<i class="fa fa-line-chart fa-fw"></i>&nbsp;&nbsp;<strong>Year sales</strong>
		<span class="w3-right w3-text-gray">
			<i class="fa fa-chevron-up fa-fw"></i>
			<i class="fa fa-times fa-fw"></i>
		</span>
	  </div>
	  <div class="w3-container w3-white w3-padding-16 w3-border-top">
		1st term<span class="w3-right">25%</span>
		<div class="w3-grey w3-round">
			<div class="w3-container w3-center w3-green w3-round" style="width:25%">&nbsp;</div>
		</div>
		2nd term<span class="w3-right">35%</span>
		<div class="w3-grey w3-round">
			<div class="w3-container w3-center w3-green w3-round" style="width:35%">&nbsp;</div>
		</div>
		3rd term<span class="w3-right">30%</span>
		<div class="w3-grey w3-round">
			<div class="w3-container w3-center w3-green w3-round" style="width:30%">&nbsp;</div>
		</div>
		4th term<span class="w3-right">10%</span>
		<div class="w3-grey w3-round">
			<div class="w3-container w3-center w3-green w3-round" style="width:10%">&nbsp;</div>
		</div>
	  </div>
	</div>
	
	<div class="w3-half">
	  <div class="w3-container w3-white w3-padding-16">
		<i class="fa fa-calendar fa-fw"></i>&nbsp;&nbsp;<strong>Calendar for today</strong>
		<span class="w3-right w3-text-gray">
			<i class="fa fa-chevron-up fa-fw"></i>
			<i class="fa fa-times fa-fw"></i>
		</span>
	  </div>
	  <div class="w3-container w3-white w3-padding-16 w3-border-top">
		<i class="fa fa-bath fa-fw"></i><span style="font-family:monospace">&nbsp;06:00&nbsp;-&nbsp;</span>Have a bath.
		<hr>
		<i class="fa fa-coffee fa-fw"></i><span style="font-family:monospace">&nbsp;06:30&nbsp;-&nbsp;</span>Have breakfast.
		<hr>
		<i class="fa fa-money fa-fw"></i><span style="font-family:monospace">&nbsp;10:30&nbsp;-&nbsp;</span>Get some pocket money for the lunch.
		<hr>
		<i class="fa fa-phone fa-fw"></i><span style="font-family:monospace">&nbsp;17:15&nbsp;-&nbsp;</span>Call Elvis.
		<hr>
		<button class="w3-btn w3-green th-w3-btn-primary">Add</button>
	  </div>
	</div>
	
	<div style="clear:both; padding-top:16px"></div>
	
	<div class="w3-half">
	  <div class="w3-container w3-white w3-padding-16">
		<i class="fa fa-user fa-fw"></i>&nbsp;&nbsp;<strong>Last user logins</strong>
		<span class="w3-right w3-text-gray">
			<i class="fa fa-chevron-up fa-fw"></i>
			<i class="fa fa-times fa-fw"></i>
		</span>
	  </div>
	  <div class="w3-container w3-white w3-padding-16 w3-border-top">
		<i class="fa fa-sign-in fa-fw"></i><span style="font-family:monospace">&nbsp;06:00&nbsp;-&nbsp;</span>John Doe.
		<br>
		<i class="fa fa-sign-in fa-fw"></i><span style="font-family:monospace">&nbsp;06:30&nbsp;-&nbsp;</span>Marie Smith.
		<br>
		<i class="fa fa-sign-in fa-fw"></i><span style="font-family:monospace">&nbsp;10:30&nbsp;-&nbsp;</span>Gertrude Smith.
	  </div>
	</div>
	
	<div style="clear:both; padding-top:16px"></div>
	
	<!-- Opportunity cards, Odoo / OpenERP style -->
	
	<div class="w3-container">
      <h5><strong>Odoo / OpenERP style</strong></h5>
	</div>
	
	<div class="w3-quarter">
	  <div class="w3-container w3-brown w3-padding-16 w3-round">
		<strong>New</strong>
		<span class="w3-right">
			<i class="fa fa-plus fa-fw th-fa-clickable"></i>
		</span>
		<p></p>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-green"></i>
				<i class="fa fa-circle fa-fw w3-text-blue"></i>
			</div>
			<strong>Maybe a project about schools</strong>
			<br>
			24.000 &euro;
			<br>
			<span class="w3-text-red">12 Oct 2017 : Email</span>
			<br>
			<i class="fa fa-star fa-fw w3-text-yellow"></i><i class="fa fa-star fa-fw w3-text-yellow"></i><i class="fa fa-star-o fa-fw"></i>
			<span class="w3-right w3-text-gray">
				John
			</span>
		</div>
		<br>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-red"></i>
			</div>
			<strong>Maybe a project about schools</strong>
			<br>
			24.000 &euro;
			<br>
			<span class="w3-text-red">12 Oct 2017 : Email</span>
			<br>
			<i class="fa fa-star fa-fw w3-text-yellow"></i><i class="fa fa-star fa-fw w3-text-yellow"></i><i class="fa fa-star-o fa-fw"></i>
			<span class="w3-right w3-text-gray">
				John
			</span>
		</div>
	  </div>
	</div>
	
	<div class="w3-quarter">
	  <div class="w3-container w3-brown w3-padding-16 w3-round">
		<strong>Qualification</strong>
		<span class="w3-right">
			<i class="fa fa-plus fa-fw th-fa-clickable"></i>
		</span>
	    <p></p>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-red"></i>
			</div>
			<strong>Maybe a project about schools</strong>
			<br>
			24.000 &euro;
			<br>
			<span class="w3-text-red">12 Oct 2017 : Email</span>
			<br>
			<i class="fa fa-star fa-fw w3-text-yellow"></i><i class="fa fa-star fa-fw w3-text-yellow"></i><i class="fa fa-star-o fa-fw"></i>
			<span class="w3-right w3-text-gray">
				John
			</span>
		</div>
	  </div>
	</div>
	
	<div class="w3-quarter">
	  <div class="w3-container w3-brown w3-padding-16 w3-round">
		<strong>Proposition</strong>
		<span class="w3-right">
			<i class="fa fa-plus fa-fw th-fa-clickable"></i>
		</span>
	    <p></p>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-green"></i>
				<i class="fa fa-circle fa-fw w3-text-blue"></i>
			</div>
			<strong>Maybe a project about schools</strong>
			<br>
			24.000 &euro;
			<br>
			<span class="w3-text-red">12 Oct 2017 : Email</span>
			<br>
			<i class="fa fa-star fa-fw w3-text-yellow"></i><i class="fa fa-star fa-fw w3-text-yellow"></i><i class="fa fa-star-o fa-fw"></i>
			<span class="w3-right w3-text-gray">
				John
			</span>
		</div>
		<br>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-red"></i>
			</div>
			<strong>Maybe a project about schools</strong>
			<br>
			24.000 &euro;
			<br>
			<span class="w3-text-red">12 Oct 2017 : Email</span>
			<br>
			<i class="fa fa-star fa-fw w3-text-yellow"></i><i class="fa fa-star fa-fw w3-text-yellow"></i><i class="fa fa-star-o fa-fw"></i>
			<span class="w3-right w3-text-gray">
				John
			</span>
		</div>
		<br>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-green"></i>
				<i class="fa fa-circle fa-fw w3-text-blue"></i>
			</div>
			<strong>Maybe a project about schools</strong>
			<br>
			24.000 &euro;
			<br>
			<span class="w3-text-red">12 Oct 2017 : Email</span>
			<br>
			<i class="fa fa-star fa-fw w3-text-yellow"></i><i class="fa fa-star fa-fw w3-text-yellow"></i><i class="fa fa-star-o fa-fw"></i>
			<span class="w3-right w3-text-gray">
				John
			</span>
		</div>
	  </div>
	</div>
	
	<div class="w3-quarter">
	  <div class="w3-container w3-brown w3-padding-16 w3-round">
		<strong>Won</strong>
		<span class="w3-right">
			<i class="fa fa-plus fa-fw th-fa-clickable"></i>
		</span>
		<p></p>
	  	<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-red"></i>
			</div>
			<strong>Maybe a project about schools</strong>
			<br>
			24.000 &euro;
			<br>
			<span class="w3-text-red">12 Oct 2017 : Email</span>
			<br>
			<i class="fa fa-star fa-fw w3-text-yellow"></i><i class="fa fa-star fa-fw w3-text-yellow"></i><i class="fa fa-star-o fa-fw"></i>
			<span class="w3-right w3-text-gray">
				John
			</span>
		</div>
	  </div>
	</div>
	
	<div style="clear:both; padding-top:16px"></div>
	
	<!-- Project cards, Trello style -->
	
	<div class="w3-container">
		<h5>
			<strong>Trello cards style</strong>
			<span class="w3-right">
				<i class="fa fa-arrow-circle-left fa-fw w3-text-gray" id="trello_left"></i>
				<i class="fa fa-arrow-circle-right fa-fw th-fa-clickable w3-text-black" id="trello_right" onclick="trello_right();"></i>
			</span>
		</h5>
	</div>
	
	<div class="w3-quarter" id="trello_today">
	  <div class="w3-container w3-gray w3-padding-16 w3-round">
		<strong>Today</strong>
		<span class="w3-right">
			<i class="fa fa-ellipsis-h fa-fw th-fa-clickable"></i>
		</span>
		<p></p>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-green"></i>
				<i class="fa fa-circle fa-fw w3-text-blue"></i>
			</div>
			<strong>Write the article for IT News</strong>
			<br>
			<i class="fa fa-comment-o fa-fw"></i> 2
			<i class="fa fa-envelope-o fa-fw"></i> 1
		</div>
		<br>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-red"></i>
			</div>
			<strong>Wash the car</strong>
			<br>
			<i class="fa fa-envelope-o fa-fw"></i> 3
		</div>
		<br>
		Add a card...
	  </div>
	</div>
	
	<div class="w3-quarter">
	  <div class="w3-container w3-gray w3-padding-16 w3-round">
		<strong>Tomorrow</strong>
		<span class="w3-right">
			<i class="fa fa-ellipsis-h fa-fw th-fa-clickable"></i>
		</span>
		<p></p>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-green"></i>
				<i class="fa fa-circle fa-fw w3-text-blue"></i>
			</div>
			<strong>Write the article for IT News</strong>
			<br>
			<i class="fa fa-comment-o fa-fw"></i> 2
			<i class="fa fa-envelope-o fa-fw"></i> 1
		</div>
		<br>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-red"></i>
			</div>
			<strong>Wash the car</strong>
			<br>
			<i class="fa fa-envelope-o fa-fw"></i> 3
		</div>
		<br>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-green"></i>
				<i class="fa fa-circle fa-fw w3-text-blue"></i>
			</div>
			<strong>Write the article for IT News</strong>
			<br>
			<i class="fa fa-comment-o fa-fw"></i> 2
			<i class="fa fa-envelope-o fa-fw"></i> 1
		</div>
		<br>
		Add a card...
	  </div>
	</div>
	
	<div class="w3-quarter">
	  <div class="w3-container w3-gray w3-padding-16 w3-round">
		<strong>This week</strong>
		<span class="w3-right">
			<i class="fa fa-ellipsis-h fa-fw th-fa-clickable"></i>
		</span>
		<p></p>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-green"></i>
				<i class="fa fa-circle fa-fw w3-text-blue"></i>
			</div>
			<strong>Write the article for IT News</strong>
			<br>
			<i class="fa fa-comment-o fa-fw"></i> 2
			<i class="fa fa-envelope-o fa-fw"></i> 1
		</div>
		<br>
		Add a card...
	  </div>
	</div>
	
	<div class="w3-quarter">
	  <div class="w3-container w3-gray w3-padding-16 w3-round">
		<strong>One day</strong>
		<span class="w3-right">
			<i class="fa fa-ellipsis-h fa-fw th-fa-clickable"></i>
		</span>
		<p></p>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-green"></i>
				<i class="fa fa-circle fa-fw w3-text-blue"></i>
			</div>
			<strong>Write the article for IT News</strong>
			<br>
			<i class="fa fa-comment-o fa-fw"></i> 2
			<i class="fa fa-envelope-o fa-fw"></i> 1
		</div>
		<br>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-red"></i>
			</div>
			<strong>Wash the car</strong>
			<br>
			<i class="fa fa-envelope-o fa-fw"></i> 3
		</div>
		<br>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-green"></i>
				<i class="fa fa-circle fa-fw w3-text-blue"></i>
			</div>
			<strong>Write the article for IT News</strong>
			<br>
			<i class="fa fa-comment-o fa-fw"></i> 2
			<i class="fa fa-envelope-o fa-fw"></i> 1
		</div>
		<br>
		Add a card...
	  </div>
	</div>
	
	<div class="w3-quarter" id="trello_never" style="display:none">
	  <div class="w3-container w3-gray w3-padding-16 w3-round">
		<strong>Never</strong>
		<span class="w3-right">
			<i class="fa fa-ellipsis-h fa-fw th-fa-clickable"></i>
		</span>
		<p></p>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-green"></i>
				<i class="fa fa-circle fa-fw w3-text-blue"></i>
			</div>
			<strong>Write the article for IT News</strong>
			<br>
			<i class="fa fa-comment-o fa-fw"></i> 2
			<i class="fa fa-envelope-o fa-fw"></i> 1
		</div>
		<br>
		<div class="w3-container w3-white w3-padding-16 w3-round">
			<div>
				<i class="fa fa-circle fa-fw w3-text-red"></i>
			</div>
			<strong>Wash the car</strong>
			<br>
			<i class="fa fa-envelope-o fa-fw"></i> 3
		</div>
		<br>
		Add a card...
	  </div>
	</div>
	
	<div style="clear:both; padding-top:16px"></div>
	
	<div class="w3-half">
	  <div class="w3-container w3-white w3-padding-16">
		<i class="fa fa-line-chart fa-fw"></i>&nbsp;&nbsp;<strong>Year sales by genre</strong>
		<span class="w3-right w3-text-gray">
			<i class="fa fa-chevron-up fa-fw"></i>
			<i class="fa fa-times fa-fw"></i>
		</span>
	  </div>
	  <div class="w3-container w3-white w3-padding-16 w3-border-top">
<?php
	$graph = new NiceGraph();
	
	$graph -> setSeries(
		array(
			new NiceGraphSerie('Men', 'blue', 12),
			new NiceGraphSerie('Women', 'red', 14),
			new NiceGraphSerie('N/A', 'yellow', 18),
		)
	);
	//$graph -> setShowValues(false);
	//$graph -> setFontFamily('Monospace');
	$graph -> setFontSize('1.5em');
	$graph -> setBarWidth(30);
	$graph -> setBarRadius(6);
	
	$view = $graph -> drawHorizontal();
	
	echo $view;
?>
	  </div>
	</div>
	
	<div class="w3-half">
	  <div class="w3-container w3-white w3-padding-16">
		<i class="fa fa-line-chart fa-fw"></i>&nbsp;&nbsp;<strong>1st term sales by genre</strong>
		<span class="w3-right w3-text-gray">
			<i class="fa fa-chevron-up fa-fw"></i>
			<i class="fa fa-times fa-fw"></i>
		</span>
	  </div>
	  <div class="w3-container w3-white w3-padding-16 w3-border-top">
<?php
	$graph = new NiceGraph();
	
	$graph -> setCategories(
		array(
			new NiceGraphCategory('January'),
			new NiceGraphCategory('February'),
			new NiceGraphCategory('March')
		)
	);
	
	$graph -> setSeries(
		array(
			new NiceGraphSerie('Men', 'blue', array(12, 14, 15)),
			new NiceGraphSerie('Women', 'red', array(14, 11, 16)),
			new NiceGraphSerie('N/A', 'yellow', array(18, 16, 13)),
		)
	);
	//$graph -> setShowValues(false);
	//$graph -> setFontFamily('Monospace');
	$graph -> setBarWidth(30);
	$graph -> setBarRightRadius(8);
	$graph -> setCategoryRadius(4);
	
	$view = $graph -> drawHorizontal();
	
	echo $view;		
?>
	  </div>
	</div>
	
	<div style="clear:both; padding-top:16px"></div>
	
	<br>
	<br>
	
</div>

<script>
	// Init view
	function initSection() {
		
		//
	}
	
	function trello_left() {
		var arrowLeft  = document.getElementById('trello_left');
		var arrowRight = document.getElementById('trello_right');
		
		arrowLeft.classList.remove("th-fa-clickable");
		arrowLeft.classList.remove("w3-text-black");
		arrowLeft.classList.add("w3-text-gray");
		arrowLeft.onclick = null;
		
		arrowRight.classList.add("th-fa-clickable");
		arrowRight.classList.remove("w3-text-gray");
		arrowRight.classList.add("w3-text-black");
		arrowRight.onclick = trello_right;
		
		var trelloToday  = document.getElementById('trello_today');
		var trelloNever = document.getElementById('trello_never');
		
		trelloNever.style.display = "none";
		trelloToday.style.display = "block";
	}

	function trello_right() {
		var arrowLeft  = document.getElementById('trello_left');
		var arrowRight = document.getElementById('trello_right');
		
		arrowRight.classList.remove("th-fa-clickable");
		arrowRight.classList.remove("w3-text-black");
		arrowRight.classList.add("w3-text-gray");
		arrowRight.onclick = null;
		
		arrowLeft.classList.add("th-fa-clickable");
		arrowLeft.classList.remove("w3-text-gray");
		arrowLeft.classList.add("w3-text-black");
		arrowLeft.onclick = trello_left;
		
		var trelloToday  = document.getElementById('trello_today');
		var trelloNever = document.getElementById('trello_never');
		
		trelloToday.style.display = "none";
		trelloNever.style.display = "block";
	}


</script>
 

