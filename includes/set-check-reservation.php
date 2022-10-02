<?php
	
	include_once './config.inc.php';
	if(isset($_GET['object'])&& $_GET['object']!=='' &&  isset($_GET['id'])&& is_numeric($_GET['id'])){
		
		
		$object = $db->get_row("SELECT * FROM residence_reservation WHERE  id='".$_GET['id']."'");
		
		if ($_GET['object'] == "checkin"){
			if($object['checkin']==0){$checkin = 1;$active=1;}else{$checkin = 0;$active=0;}
			
			
			if(!$db->update("residence_reservation",array('checkin'=>$checkin,'active'=>$active),$_GET['id'])){
				
				echo 'error';
				
				}else{
				
				echo 'success';
				
			}
			
			}else 	if ($_GET['object'] == "checkout"){
			
			if($object['checkout']==0){$checkout = 1;$active=0;}else{$checkout = 0;$active=1;}
			
			
			if(!$db->update("residence_reservation",array('checkout'=>$checkout,'active'=>$active),$_GET['id'])){
				
				echo 'error';
				
				}else{
				
				echo 'success';
				
			}
			
		}
		
		
		else	if ($_GET['object'] == "payed"){
			if($object['payed']==0){$payed = 1;}else{$payed = 0;}
			
			
			if(!$db->update("residence_reservation",array('payed'=>$payed),$_GET['id'])){
				
				echo 'error';
				
				}else{
				
				echo 'success';
				
			}
			
		} 
		
		
		
		
	}
?>