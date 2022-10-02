
<?php
	
	include_once './config.inc.php';
	if(isset($_GET['object'])&& $_GET['object']!=='' &&  isset($_GET['id'])&& is_numeric($_GET['id'])){
		
		
		$object = $db->get_row("SELECT * FROM residence_reservation WHERE  id='".$_GET['id']."'");
		
		if ($_GET['object'] == "payed"){
			if($object['payed']==0){$payed = 1;}else{$payed = 0;}
			
			
			if(!$db->update("residence_reservation",array('payed'=>$payed),$_GET['id'])){
				
				echo 'error';
				
				}else{
				
				echo 'success';
				
			}
			
			} 
	}
?>