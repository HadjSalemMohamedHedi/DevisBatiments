<?php  include_once '../../includes/config.inc.php';
    if(!$_POST) {exit;}
	
	$fields = array(
	'titre_fr'=>array(
	'rule'=>'/.+/',
	'message'=>'',
	'value'=>' titre (fr) est obligatoire',
	'required'=>TRUE
	),
	'titre_en'=>array( 
	'rule'=>'/.+/',
	'message'=>'titre_en',
	'value'=>'', 
	'required'=>false
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
	if($_POST['action']=='add' )
	{
		
		
		if(empty($errors)) {
			
 			
			foreach ($_SESSION['icon-colonne'] as $img){
				if ($img!='-1'){
					$_POST['icon']=$img;
				}
			}
			
			
			$_POST['titre_fr']= addslashes ($_POST['titre_fr']);
			$_POST['titre_en']= addslashes ($_POST['titre_en']);
			
			if(!$db->insert('colonnes',$_POST)) 
			{
				$errors[] = "erreur";
			} else
			{
				$_SESSION['notification'] = array('type'=>'succes','msg'=>'Colonne ajoutée avec succès');
				echo '<div class="alert alert-success alert-dismissible fade in">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<strong>Success:</strong> Colonne ajoutée avec succès.</div>';
			}
		}
		else
		{
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
		
	 	if(empty($errors))
		{
			/* 	foreach ($_SESSION['icon-colonne'] as $img){
				if ($img!='-1'){
				$_POST['icon']=$img;
				}
			} */
			if (isset ($_SESSION['icon-colonne'][0])){
			if ($_SESSION['icon-colonne'][0] == -1){
				$_POST['icon']="";
				}else{
				$_POST['icon']=$_SESSION['icon-colonne'][0];
			}
			}
			$_POST['titre_fr']= addslashes ($_POST['titre_fr']);
			$_POST['titre_en']= addslashes ($_POST['titre_en']);
			
			if(!$db->update('colonnes',$_POST,$_POST['id'])) {
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