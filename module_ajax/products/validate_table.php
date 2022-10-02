<?php  include_once '../../includes/config.inc.php';
	if(!$_POST) {exit;}
	
	$data = json_decode(stripslashes($_POST['data']));
	
 
	/*	echo "<pre>";
		print_r($data); 
		echo "</pre>";
	exit();	  
	
	/*ajout*/
	if($_POST['action']=='add' ){
	 
		$db->query("DELETE FROM `product_table_fr` WHERE product_table_fr.id_product = ".$_POST['id_product']);
		$db->query("DELETE FROM `product_column_table_fr` WHERE product_column_table_fr.id_product = ".$_POST['id_product']);
		
		//foreach ($data as $d){	
		
		 
		 for($i=0;$i<count($data);$i++)
		{
			for($j=0;$j<count($data[$i]);$j++)
			{
				  if($i == 0)
				{ // pour la première fois enregistrer les colonnes du tableau
					$product_column_table_fr=array();
					$product_column_table_fr['id_product']=$_POST['id_product'];
					$product_column_table_fr['id_column']=$data[$i][$j][0];
					$product_column_table_fr['rang']=$j;
					$product_column_table_fr['statut']=1;
					$db->insert('product_column_table_fr',$product_column_table_fr) ;
				}
				
				$product_table_fr=array();
				$product_table_fr['id_product']=$_POST['id_product'];
				$product_table_fr['id_column']=$data[$i][$j][0];
				$product_table_fr['value']= addslashes($data[$i][$j][1]);
				$product_table_fr['visible']= addslashes($data[$i][2][1]);
				$product_table_fr['rang']=$i;
				$product_table_fr['statut']=1;
				$db->insert('product_table_fr',$product_table_fr) ;
				
				
				
			}
		}
		/* */
		$_SESSION['notification'] = array('type'=>'succes','msg'=>'Mise à jour du tableau effectué avec succès');
		echo '<div class="alert alert-success alert-dismissible fade in">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		<strong>Success:</strong>Mise à jour du tableau effectué avec succès.</div>';
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
	
	
	
	
	
	
?>																				