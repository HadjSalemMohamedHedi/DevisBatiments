<?php
	include_once '../includes/config.inc.php';
	
	$result = array("aaData"=>array());
	
	$filter = '';
	$deleted =(isset($_GET['trash']) && $_GET['trash']=='true')?1:0;
	$filter.='AND deleted='.$deleted;
	
	if (isset($_GET['id_categ']) ){$filter.=" AND `id_categ` =".$_GET['id_categ'];}
	
	
	$rows = $db->get_rows("SELECT products.* FROM products WHERE 1 $filter");
	foreach($rows as $x=>$v):
	
	//print_debug($v);
	
	$action ='';
	if(isset($_GET['trash']) && $_GET['trash']=='true'){
		$action .= '<a href="manage-client.php?trash=true&action=restore&id='.$v['id'].'" class="btn btn-success btn-icon btn-xs">Restaurer</a>';
		$action .= ' <button type="button" class="btn btn-danger btn-icon btn-xs" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Supprimer définitivement" data-placement="top" onclick="delTrash('.$v['id'].')"> <i class="fa fa-remove"></i></button>';
		
		}else{
		$action .= '<button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="Edit('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Modifier" data-placement="top"> <i class="fa fa-edit"></i></button>';
		$action .= ' <button type="button" class="btn btn-default navbar-btn btn-icon btn-xs" onclick="delItem('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Archiver ce produit " data-placement="top"> <i class="fa fa-trash"></i></button>';
	}
	
	/*$tableau = '<button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="edit_table('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Description des produits" data-placement="top"> <i class="fa fa-table"></i></button>';*/
		$tableau = '<button style="color: #ec2227;" type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="edit_table_products('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Tableau des produits " data-placement="top"> <i class="fa fa-table"></i></button>';
	/*$tableau .= '<button style="color: #ec2227;" type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="select_table_charge('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Tableau des charges " data-placement="top"> <i class="fa fa-table"></i></button>';*/
	
	
	$statut =  '<input type="checkbox" data-object="products" value="'.$v['id'].'"';
	if($v['statut']==1){ $statut .= ' checked="" '; }
	$statut .= 'class="iswitch iswitch-md iswitch-primary">';
	
	
	// image produit
	$product_images = $db->get_rows("SELECT * FROM `product_images` WHERE `id_product` =".$v['id']);
	if (count($product_images) > 0){
		
		
		if (!file_exists('../../../'.$product_images[0]['name'])) {
			$name_img="images-products/empty.png";
			$img="<img width=100 src='upload/".$name_img."' >";
			}else{
			$name_img = str_replace("images-products/".$v['id']."/", "../../../images-products/".$v['id']."/s/50_", $product_images[0]['name']);
			
			$img="<img width=100 src='upload/".$name_img."' >";
		}
		
		
		}else{
		$name_img="images-products/empty.png";
		$img="<img width=100 src='upload/".$name_img."' >";
	}

//if (!file_exists($path)) {mkdir($path, 0777, true);}


//categorie  produit 
$sub_categ = $db->get_row("SELECT * FROM `sub_categ` WHERE `id` =".$v['id_sub_categ']);	

//gamme produit 
$categ = $db->get_row("SELECT * FROM `categ` WHERE `id` =".$sub_categ['id_categ']);

/*if($categ['titre_fr'] == 'Bandage et jersey'){
	$tableau .= '<button style="color: #ec2227;" type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="edit_table_charge('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Tableau des compositions " data-placement="top"> <i class="fa fa-table"></i></button>';
}*/

 $sous_products_table = $db->get_rows("SELECT sous_products_table.* FROM sous_products_table WHERE id_product =". $v['id']);


$result["aaData"][]=array(
//"code_produit"=>$sous_products_table[0]['code_article'],
"image"=>$img,
"categ"=>$categ['titre_fr'],
"sub_categ"=>$sub_categ['titre_fr'],
"titre_fr"=>$v['titre_fr'],
"unite_cond"=> $sous_products_table[0]['unite'],
"quantite"=> $sous_products_table[0]['quantite'],
"stock_min"=> $sous_products_table[0]['stock_min'],
'tableau'=>$tableau,
'statut'=>$statut,
'action'=>$action,
);

endforeach;

echo json_encode($result,true);
?>