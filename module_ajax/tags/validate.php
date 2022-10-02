<?php  include_once '../../includes/config.inc.php';
    if(!$_POST) {exit;}
	
	$fields = array(
	'titre_fr'=>array(
	'rule'=>'/.+/',
	'message'=>'',
	'value'=>' username est obligatoire',
	'required'=>TRUE
	) 
	
	);
	
	$errors = array();
	foreach($fields as $k=>$v) {
		
		if(isset($_POST[$k])) {
			
			$required = (isset($v['required'])) ? (!empty($_POST[$k])) ? TRUE : $v['required']  : TRUE ;
			
			if(isset($v['rule']) && $required && !preg_match($v['rule'], $_POST[$k]) ) {
				
				if(isset($v['rule']) && !preg_match($v['rule'], $_POST[$k]) ) {
					
					if(isset($v['message']) && !empty($v['message'])) {
						$errors[] = $v['message'];
					}
				}
			}
			$fields[$k]['value'] = $_POST[$k];
		}
	}
	
	
	
	/*ajout*/
	if($_POST['action']=='add' ){
		
		
		
		
		
		if(empty($errors)) {
			$_POST["statut"]=1;
 			
			if(!$db->insert('tags',$_POST)) {
				$errors[] = "erreur";
				} else {
				$_SESSION['notification'] = array('type'=>'succes','msg'=>'tag ajouté avec succès');
				echo '<div class="alert alert-success alert-dismissible fade in">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<strong>Success:</strong> Tag ajouté avec succès.</div>';
			}
			}else{
			$msg='<div class="list-group-item list-group-item-danger">   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Erreur:</strong><br>';
			foreach($errors as $error):
			$msg.='- '.$error.'<br>';
			endforeach;
			$msg.='</div>';
			echo $msg;
			exit;	
		}
		
	}
	
	/*edit*/
	if($_POST['action']=='edit') {
		
		/*	$client = $db->get_rows("SELECT client.* FROM client WHERE id<>'".$_POST['id']."' AND client.email='".$fields['email']['value']."')");
			
			if(!empty($client)){
			$errors[] = "Utilisateur exist !!! ( verifier l'e-mail ou bien username )";
			}
		*/
		
		
		
	 	if(empty($errors))
		{
			if(!$db->update('tags',$_POST,$_POST['id'])) {
				echo  '<div class="list-group-item list-group-item-danger">save failed</div>';
				} else {
				echo '<div class="alert alert-success alert-dismissible fade in">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<strong>Success:</strong>Mise à jour effectué avec succès.</div>';
			}
			}else{
			$msg='<div class="list-group-item list-group-item-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Erreur:</strong><br>';
			foreach($errors as $error):
			$msg.='- '.$error.'<br>';
			endforeach;
			$msg.='</div>';
			echo $msg;
			exit;
		} 
	}
?>						