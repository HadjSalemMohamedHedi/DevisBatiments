<?php

	// Loader - class and connection
	include('loader.php');
	$saved_event = 0;
	
	function getIdDay($date){
		 $week = array("Sun" => "7","Mon" => "1","Tue" => "2","Wed" => "3","Thu" => "4","Fri" => "5","Sat" => "6");
		 $today = date('D',strtotime($date));
		return $week[$today];
	}
	function getHoraire($id,$day=1){
	
		$sql=mysql_query("SELECT * FROM medecin_horaire WHERE id_medecin='$id' and id_day='$day' ")or die (mysql_error());
		if($find=mysql_fetch_assoc($sql)){	
			return $find;
		}else {
			false;
		}
		
	}
	function verifHoraire($id_medecin,$start,$end){
		
		$day = getIdDay(date('D',strtotime($end)));
		$start = date('H:i:s',strtotime($start));
		$end = date('H:i:s',strtotime($end));
		
		//$start = '12:30:00';
		//$end = '13:30:00';
		
		$sql=mysql_query("SELECT * FROM medecin_horaire WHERE id_medecin='$id_medecin' AND id_day='$day' AND (fin <= '$start'  AND debut_midi >= '$end')")or die (mysql_error());
		
		$num = mysql_num_rows($sql);
		
		
			if($num >0){
				return false;
			}else {
				return true;
			}
			
			
		
	}
	function verifDate($start,$end,$id_medecin,$active=false){
		
		
		$sql = "SELECT * FROM calendar where id_docteur='$id_medecin' AND (start >= '$start'  AND end <= '$end')";
		if($active){
			
		$sql .= " AND statut = '$active'";
			
		}
		$availabilitys = mysql_query($sql);
		$num = mysql_num_rows($availabilitys);
		
		
			if($num >0){
				return false;
			}else {
				return true;
			}
		
	}
	
	function verifDateDispo($start,$end,$id_medecin,$active=false){
		
		
		$sql = "SELECT * FROM calendar where id_docteur='$id_medecin' AND (start between '$start' AND '$end' OR end between '$start' AND '$end')";
		if($active){
			
		$sql .= " AND statut = '$active'";
			
		}
		$availabilitys = mysql_query($sql);
		$num = mysql_num_rows($availabilitys);
		
		
			if($num >0){
				return false;
			}else {
				return true;
			}
		
	}
	
	function delete($start,$end,$id_medecin){
		
		$sql = mysql_query("SELECT * FROM calendar where id_docteur='$id_medecin' AND (start between '$start' AND '$end' OR end between '$start' AND '$end')");
		
		while($find=mysql_fetch_array($sql)){
				$id = $find['id'];
			mysql_query("DELETE FROM calendar WHERE id='$id'");
			
			}
		
		
	}
	
	
	if(isset($_POST['delete'])){
		
		$deleted_event = 0;
		
		$id_medecin = $_POST['id_docteur'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];



		$heure_dep = $_POST['heure_dep'];
		$minute_dep = $_POST['minute_dep'];


		$heure_fin = $_POST['heure_fin'];
		$minute_fin = $_POST['minute_fin'];

		$start_time =date("H:i", strtotime($heure_dep."".$minute_dep));

		$end_time =date("H:i", strtotime($heure_fin."".$minute_fin));
		
		$start_dateTime = strtotime($start_date.' '.$start_time);
		
		$end_dateTime = strtotime($end_date.' '.$end_time);
		
		$start = date( 'Y-m-d H:i:s',$start_dateTime);
		$end = date( 'Y-m-d H:i:s',$end_dateTime);
		
		
		
		$sql = mysql_query("SELECT * FROM calendar where id_docteur='$id_medecin' AND start >= '$start'  AND end <= '$end' AND statut='0'");
		
		while($find=mysql_fetch_array($sql)){
			
			if($calendar->delete($find['id'])){
				$deleted_event++;
			}
			
		}
		
		if($deleted_event == 0){
			echo false;
		}else {
			echo true;
		}
		
	}
	

	if(!isset($_POST['fermer'])&&(!isset($_POST['open']))&&(!isset($_POST['delete']))){
	// Catch start, end and id from javascript
	$id_patient = $_POST['id_patient'];
	$id_docteur = $_POST['id_docteur'];
	$title = $_POST['title'];
	$description = $_POST['description'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['start_date'];




	$heure_dep = $_POST['heure_dep'];
	$minute_dep = $_POST['minute_dep'];

	$start_time =date("H:i", strtotime($heure_dep."".$minute_dep));



	$x = $_POST['end_time'];
	/*if(($x!="")&&($x!=0)){
 	$str=$start_time." +".$x." minutes";
 	}else*/{
 	$str=$start_time." +30 minutes";
 	}
	$end_time=date('H:i', strtotime($str));

	$color = $_POST['color'];
	$allDay = $_POST['allDay'];
	$url = $_POST['url'];
	$statut = $_POST['statut'];
	$source = $_POST['source'];
	if(empty($url)) 
	{
		$url = "?page=";
	}
	
		$start_dateTime = strtotime($start_date.' '.$start_time);
		$end_dateTime = strtotime($end_date.' '.$end_time);
		$start = date( 'Y-m-d H:i:s',$start_dateTime);
		$end = date( 'Y-m-d H:i:s',$end_dateTime);
		
		//delete($start,$end,$id_docteur);
	if(verifDateDispo($start,$end,$id_docteur,'1')){
		
		delete($start,$end,$id_docteur);
	echo $calendar->addEvent($title, $description, $start_date, $start_time, $end_date, $end_time, $color, $allDay, $url, $id_patient,$id_docteur,$source,$statut);
	
	}
	
	
	
	
	}else if(isset($_POST['fermer'])&&(!isset($_POST['open']))){

	// Catch start, end and id from javascript
	$id_patient = "";
	$id_docteur = $_POST['id_docteur'];
	$title ="Periode ferme";
	$description = "";
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];



	$heure_dep = $_POST['heure_dep'];
	$minute_dep = $_POST['minute_dep'];


	$heure_fin = $_POST['heure_fin'];
	$minute_fin = $_POST['minute_fin'];

	$start_time =date("H:i", strtotime($heure_dep."".$minute_dep));

	$end_time =date("H:i", strtotime($heure_fin."".$minute_fin));

	$color = "#ff0000";
	$allDay = "";
	$url = "";
	$statut = 3;
	$source = "";
	if(empty($url)) 
	{
		$url = "?page=";
	}
	
	echo $calendar->addEvent($title, $description, $start_date, $start_time, $end_date, $end_time, $color, $allDay, $url, $id_patient,$id_docteur,$source,$statut);
	}
	
	/*disponibilité*/
	
if(isset($_POST['open'])&&($_POST['open']=='open')){
	
	/*post*/
	
	/*if(isset($_POST['intervalle'])){
		$intervalle = $_POST['intervalle'];
	}else {
	
	$intervalle = '30';

	
	}*/
	
	$id_docteur = $_POST['id_docteur'];
	$title ="";
	$color = $_POST['color'];
	$url = "";
	if(empty($url)) 
	{
		$url = "?page=";
	}
	$statut = 0;
	$allDay = "";
	
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];



	$heure_dep = $_POST['heure_dep'];
	$minute_dep = $_POST['minute_dep'];


	$heure_fin = $_POST['heure_fin'];
	$minute_fin = $_POST['minute_fin'];
	

	$start_time =date("H:i", strtotime($heure_dep."".$minute_dep));

	$end_time =date("H:i", strtotime($heure_fin."".$minute_fin));
	
		$h_debut = $start_time;
		$h_fin = $end_time;

	/**/
	
	$intervalle =$_POST['end_time'];
	for($i = strtotime($start_date);$i <= strtotime($end_date);$i = strtotime( date( 'Y-m-d' , $i ) . ' +1 day' ) ){
		
	
	
		for($j = strtotime($h_debut);$j < strtotime($h_fin) ;$j = strtotime( date( 'H:i' , $j ) . ' +'.$intervalle.' minutes' ) ){
			
			$start_time = date( 'H:i',$j);
		$end_time = date( 'H:i',strtotime(date( 'H:i',$j). ' +'.$intervalle.' minutes'));
		
		$start_dateTime = strtotime(date( 'Y-m-d',$i).' '.$start_time);
		
		$end_dateTime = strtotime(date( 'Y-m-d',$i).' '.$end_time);
		$start = date( 'Y-m-d H:i:s',$start_dateTime);
		$end = date( 'Y-m-d H:i:s',$end_dateTime);
		
		
		
		if((verifDate($start,$end,$id_docteur))&& (verifHoraire($id_docteur,$start,$end)) &&($calendar->addEvent($title, '',  date( 'Y-m-d',$i), $start_time,  date( 'Y-m-d',$i), $end_time, $color, $allDay, $url, '',$id_docteur,'',$statut))){
			$saved_event ++;
		}
		
		
		
		}
	
	}
	
	if($saved_event>0){
	
	echo true;
	}else {
		echo false;
	}
	
}
?>