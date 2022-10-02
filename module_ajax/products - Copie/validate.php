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
	if($_POST['action']=='add' ){
		
		
		if(empty($errors)) {
			
 			
			if(!$db->insert('products',$_POST)) {
				$errors[] = "erreur";
				} else {
				
				$id_product=$db->get_insert_id();
				
				foreach ($_SESSION['images-product'] as $img){
					if ($img!='-1'){
						$product_images=array();
						$product_images['id_product']=$id_product;
						$product_images['name']=$img;
						$product_images['statut']=1;
						$db->insert('product_images',$product_images);
					}
				}
				
				$_SESSION['notification'] = array('type'=>'succes','msg'=>'Produit ajouté avec succès');
				echo '<div class="alert alert-success alert-dismissible fade in">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<strong>Success:</strong> Produit ajouté avec succès.</div>';
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
		
	 	if(empty($errors))
		{
			if(!$db->update('products',$_POST,$_POST['id'])) {
				echo  '<div class="list-group-item list-group-item-danger">save failed</div>';
				} else {
				$id_product=$_POST['id'];
				$db->query("delete from product_images where id_product = ".$id_product);
				
				foreach ($_SESSION['images-product'] as $img)
				{
					if ($img!='-1'){
						$product_images=array();
						$product_images['id_product']=$id_product;
						$product_images['name']=$img;
						$product_images['statut']=1;
						$db->insert('product_images',$product_images);
					}
				 }
				
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
	
	/*edit_column_table*/
	if($_POST['action']=='edit_column_table') {
		
		if(empty($errors)) {
			
 			$id_sub_categ=$_POST['id_sub_categ'];
			$db->query('DELETE FROM `sub_categ_column` WHERE  `id_sub_categ`='.$id_sub_categ);
 			$colones=$_POST['colonnes'];
			foreach($colones as $colone){
			$sub_categ_column=array();
			$sub_categ_column['id_sub_categ']=$id_sub_categ;
			$sub_categ_column['id_colonnes']=$colone;
			$db->insert('sub_categ_column',$sub_categ_column);
			}
			
			echo '<div class="alert alert-success alert-dismissible fade in">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Success:</strong> Mise à jour effectuée avec succès.</div>';
			
			
			/* 	if(!$db->insert('sub_categ_column',$_POST)) {
			$errors[] = "erreur";
			} else {
			$_SESSION['notification'] = array('type'=>'succes','msg'=>'Mise à jour avec succès');
			echo '<div class="alert alert-success alert-dismissible fade in">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Success:</strong> Catégorie ajoutée avec succès.</div>';
			}
			}else{
			$msg='<div class="list-group-item list-group-item-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Erreur:</strong><br>';
			foreach($errors as $error):
			$msg.='- '.$error.'<br>';
			endforeach;
			$msg.='</div>';
			echo $msg;
			exit;	
			} */
			
			}
			}
			
			
			
			?>																		