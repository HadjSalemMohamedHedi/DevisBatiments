<?php
	// Database Connection
	include('connection.php');
	
	// Calendar Class
	include('calendar.php');
	$cond=" id!=0";
	
	if($_SESSION['User']['classe']=='4'){
	$cond.=" AND id_responsible='".$_SESSION['User']['id']."'";
	}

    if($_SESSION['User']['classe']=='2'){
	$cond.=" AND id_contributor='".$_SESSION['User']['id']."'";
		}	
	
	if(isset($_GET['id_commercial'])&& is_numeric($_GET['id_commercial'])){
		
		$cond .= " AND id_commercial='".$_GET['id_commercial']."'";
		
	}
	
	if(isset($_GET['id_responsible'])&& is_numeric($_GET['id_responsible'])){
		
		$cond .= " AND id_responsible='".$_GET['id_responsible']."'";
		
	}
	
	
	if(isset($_GET['statut']) && is_numeric($_GET['statut'])){
		
		$cond .= " AND statut='".$_GET['statut']."'";
		
	}
		
	if($_SESSION['User']['classe']=='3'){
	$cond =" id!=0 AND id_commercial='".$_SESSION['User']['id']."'";
	}	
		
		
		
		$calendar = new calendar(DB_HOST, DB_USERNAME, DB_PASSWORD, DATABASE, TABLE, $cond);
	
	// Starts the Calendar Class @params 'DB Server', 'DB Username', 'DB Password', 'DB Name', 'Table Name'
	
	
	echo $calendar->json_transform(false);
		
?>