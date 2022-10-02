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
	
	
	

		
		/* echo $_POST['description_fr'];
		exit(); */
	
			
									/*ajout*/
			if($_POST['action']=='add' ){
							/************  Upload Fiche Technique   ***********/

						if(empty($errors)) {
			 
			$_POST['description_fr'] = addslashes($_POST['description_fr']); 
			$_POST['description_en'] = addslashes($_POST['description_en']);   
			$_POST['titre_fr'] = addslashes($_POST['titre_fr']);
			$_POST['titre_en'] = addslashes($_POST['titre_en']);
			$_POST['type'] = addslashes($_POST['type']);
			$_POST['promotion'] = addslashes($_POST['promotion']);
			$_POST['incont'] = addslashes($_POST['incont']);
			$_POST['deskotage'] = addslashes($_POST['desk']);
			$_POST['new'] = addslashes($_POST['new']); 
			$_POST['meta_product'] = addslashes($_POST['meta_desc_fr']);
			$_POST['meta_product_en'] = addslashes($_POST['meta_desc_en']);

			$_POST['statut'] = 1;
 
			
			$filter=" and id_sub_categ=".$_POST['id_sub_categ'];
			$query="SELECT products.* FROM products WHERE statut = 1 and deleted = 0 ".$filter;
			$product_list = $db->get_rows($query);
			$product_count= count($product_list);
			if($_POST['rang'] < $product_count + 1){
				$query="UPDATE products SET products.rang =products.rang + 1  WHERE statut = 1 and deleted = 0 AND products.rang >=".$_POST['rang']." ".$filter;
				$db->query($query); 
				
			}	
						
				$filename = $_FILES['file']['name'];
				// Location
				$location = 'fiches_technique/'.$filename;
				$response = 0;

				if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
				    $response = $location;  
				}

			/***********************/
			
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
				
				
				if($response !== 0 ){
				$_SESSION['notification'] = array('type'=>'succes','msg'=>'Produit ajouté avec succès');
				echo '<div class="alert alert-success alert-dismissible fade in">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<strong>Success:</strong> Produit ajouté avec succès.</div>';				
				}else{
				$_SESSION['notification'] = array('type'=>'succes','msg'=>'Produit ajouté avec succès');
				echo '<div class="alert alert-success alert-dismissible fade in">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<strong>Success:</strong> Produit ajouté avec succès, avec une erreur du téléchargement fiche technique.</div>';
				}
			}
		}

		else{
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
 
			$_POST['description_fr'] = addslashes($_POST['description_fr']); 
			$_POST['description_en'] = addslashes($_POST['description_en']);   
			$_POST['titre_fr'] = addslashes($_POST['titre_fr']);
			$_POST['titre_en'] = addslashes($_POST['titre_en']);
			$_POST['promotion'] = addslashes($_POST['promotion']);
			$_POST['type'] = addslashes($_POST['type']);
			$_POST['deskotage'] = addslashes($_POST['desk']);
			$_POST['incont'] = addslashes($_POST['incont']);
			$_POST['new'] = addslashes($_POST['new']);

			//$_POST['price'] = addslashes($_POST['price']);
			//$_POST['promo'] = addslashes($_POST['promo']);
			
			/********************/
			$old_rang=$_POST["old_rang"];
			$filter=" and id_sub_categ=".$_POST['id_sub_categ'];
			//$query="SELECT products.* FROM products WHERE statut = 1 and deleted = 0 and rang >=".$_POST["rang"]." and rang < ".$_POST["old_rang"]." ".$filter;
			
			if($_POST['rang'] < $old_rang ){
				$query="UPDATE products SET products.rang =products.rang + 1  WHERE statut = 1 and deleted = 0 and rang >=".$_POST["rang"]." and rang < ".$_POST["old_rang"]." ".$filter;
				$db->query($query); 
			}	
			
			if($_POST['rang'] > $old_rang ){
				$query="UPDATE products SET products.rang =products.rang - 1  WHERE statut = 1 and deleted = 0 and rang <=".$_POST["rang"]." and rang > ".$_POST["old_rang"]." ".$filter;
				$db->query($query); 
			}	
			
			/***********************/
			
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