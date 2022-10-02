<?php
	
	include_once './config.inc.php';
	if(isset($_GET['object'])&& $_GET['object']!=='' &&  isset($_GET['id'])&& is_numeric($_GET['id'])){
		
		
		$object = $db->get_row("SELECT * FROM ".$_GET['object']." WHERE  id='".$_GET['id']."'");
		
		
		if($object['statut']==0){$active = 1;}else{$active = 0;}
		
		
		if(!$db->update($_GET['object'],array('statut'=>$active),$_GET['id'])){
			
			echo 'error';
			
			}else{
			echo 'success';
			if ($active == 1){
			increment_count_room($_GET['id_residence']);
			}else{
			decrement_count_room($_GET['id_residence']);
			}
		}
	}
	
	

	
?>