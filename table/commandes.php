<?php
	include_once '../includes/config.inc.php';
	
	$result = array("aaData"=>array());
	
	$filter = '';
	$deleted =(isset($_GET['trash']) && $_GET['trash']=='true')?1:0;
	$filter.='AND deleted='.$deleted;
	
	if (isset($_GET['id_categ']) ){$filter.=" AND `id_categ` =".$_GET['id_categ'];}
	
	
	$rows = $db->get_rows("SELECT commandes.* FROM commandes WHERE 1 $filter");
	foreach($rows as $x=>$v):
	
	//print_debug($v);
 
	$action ='';
	if(isset($_GET['trash']) && $_GET['trash']=='true'){
		$action .= '<a href="manage-client.php?trash=true&action=restore&id='.$v['id'].'" class="btn btn-success btn-icon btn-xs">Restaurer</a>';
		$action .= ' <button type="button" class="btn btn-danger btn-icon btn-xs" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Supprimer définitivement" data-placement="top" onclick="delTrash('.$v['id'].')"> <i class="fa fa-remove"></i></button>';
		
		}else{
		$action .= '<button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="Edit('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Modifier" data-placement="top"> <i class="fa fa-edit"></i></button>';
		$action .= ' <button type="button" class="btn btn-default navbar-btn btn-icon btn-xs" onclick="delItem('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Placer dans la corbeille " data-placement="top"> <i class="fa fa-trash"></i></button>';
	}
	
	$tableau = '<button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="edit_table('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Tableau du produit " data-placement="top"> <i class="fa fa-table"></i></button>';

	$statut =  '<input type="checkbox" data-object="commandes" value="'.$v['id'].'"';
	if($v['statut']==1){ $statut .= ' checked="" '; }
	$statut .= 'class="iswitch iswitch-md iswitch-primary">';
	
	
	// image produit
	$product_images = $db->get_rows("SELECT * FROM `product_images` WHERE `id_product` =".$v['id_product']);
	if (count($product_images) > 0){
		
		
		if (!file_exists('../upload/'.$product_images[0]['name'])) {
			$name_img="images-products/empty.png";
			$img="<img width=100 src='upload/".$name_img."' >";
			}else{
			$name_img = str_replace("images-products/".$v['id']."/", "images-products/".$v['id']."/s/50_", $product_images[0]['name']);
			
			$img="<img width=100 src='upload/".$name_img."' >";
		}
		
		
		}else{
		$name_img="images-products/empty.png";
		$img="<img width=100 src='upload/".$name_img."' >";
	}

//if (!file_exists($path)) {mkdir($path, 0777, true);}
$product = $db->get_row("SELECT * FROM `products` WHERE `id` =".$v['id_product']);

//categorie  produit 
$sub_categ = $db->get_row("SELECT * FROM `sub_categ` WHERE `id` =".$product['id_sub_categ']);	

//gamme produit 
$categ = $db->get_row("SELECT * FROM `categ` WHERE `id` =".$sub_categ['id_categ']);

	$result["aaData"][]=array(
	"Ref"=>$v['Ref'],
	'tableau'=>$tableau,
	"image"=>$img,
	"categ"=>$categ['titre_fr'],
	"sub_categ"=>$sub_categ['titre_fr'],
	"titre_fr"=>$product['titre_fr'],
	'quantite'=>$v['quantite'],
	'prix'=>$v['prix'].' ‎€',
	'statut'=>$statut,
	'action'=>$action,
	);

endforeach;

echo json_encode($result,true);
?>