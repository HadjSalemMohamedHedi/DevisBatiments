<?php

	// Loader - class and connection
	include('loader.php');
	
	// Catch start, end and id from javascript

	if(!isset($_POST['fermer'])){
	$id = $_POST['id'];
	$event_title = $_POST['title_update'];
	$event_description = $_POST['description_update'];
	$id_patient = $_POST['id_patient'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['start_date'];
	$color = $_POST['color'];
	$allDay = $_POST['allDay'];
	$statut = $_POST['statut'];
	$source = $_POST['source'];


	$heure_dep=$_POST['heure_dep'];
	$minute_dep=$_POST['minute_dep'];
	$start_time =date("H:i", strtotime($heure_dep."".$minute_dep));

	$heure_fin=$_POST['heure_fin'];
	$minute_fin=$_POST['minute_fin'];
	$end_time =date("H:i", strtotime($heure_fin."".$minute_fin));



	if(isset($_POST['url_update'])) {
		$url = $_POST['url_update'];
	} else {
		$url = '?page=';	
	}
	
	if($calendar->updates($id, $event_title, $event_description, $url,$id_patient,$start_date,$start_time,$end_date,$end_time,$color,$allDay,$statut,$source) === true) {
		return true;	
	} else {
		return false;	
	}
}else{






	$id = $_POST['id'];
	$event_title = $_POST['title_update'];
	$event_description = "";
	$id_patient = $_POST['id_patient'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$color = $_POST['color'];
	$allDay = $_POST['allDay'];
	$statut = 3;
	$source = $_POST['source'];


	$heure_dep=$_POST['heure_dep'];
	$minute_dep=$_POST['minute_dep'];
	$start_time =date("H:i", strtotime($heure_dep."".$minute_dep));

	$heure_fin=$_POST['heure_fin'];
	$minute_fin=$_POST['minute_fin'];
	$end_time =date("H:i", strtotime($heure_fin."".$minute_fin));



	if(isset($_POST['url_update'])) {
		$url = $_POST['url_update'];
	} else {
		$url = '?page=';	
	}
	
	if($calendar->updates($id, $event_title, $event_description, $url,$id_patient,$start_date,$start_time,$end_date,$end_time,$color,$allDay,$statut,$source) === true) {
		return true;	
	} else {
		return false;	
	}



}

?>