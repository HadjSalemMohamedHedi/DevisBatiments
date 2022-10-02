<?php
	
	// Database Connection
	include('connection.php');
	
	// Calendar Class
	include('calendar.php');
	$cond=" calendar.statut > 0";
	

		if(isset($_GET['id_responsible'])&& is_numeric($_GET['id_responsible'])){
			$cond .= " AND id_responsible='".$_GET['id_responsible']."'";
		}
		if(isset($_GET['d_start'])&& strtotime($_GET["d_start"])){
			$start = date('Y-m-d H:i:s',strtotime($_GET["d_start"]));
			$cond .= " AND calendar.start >= '$start'";
		}if(isset($_GET['d_end'])&& strtotime($_GET["d_end"])){
			$start = date('Y-m-d H:i:s',strtotime($_GET["d_end"]));
			$cond .= " AND calendar.end <= '$start'";
		}
		
		$calendar = new calendar(DB_HOST, DB_USERNAME, DB_PASSWORD, DATABASE, TABLE, $cond);
	
	// Starts the Calendar Class @params 'DB Server', 'DB Username', 'DB Password', 'DB Name', 'Table Name'

	echo $calendar->json_transform(false);
		
?>