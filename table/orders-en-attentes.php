<?php
	include_once '../includes/config.inc.php';
	
	$result = array("aaData"=>array());
 
	$rows = $db->get_rows("SELECT ordered_hx.* FROM ordered_hx WHERE deleted=0 and state = 'En préparation' ORDER BY id DESC");
	foreach($rows as $x=>$v):
	
	//print_debug($v);

	$tableau = '<button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="show_products('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Tableau du produit " data-placement="top"> <i class="fa fa-table"></i></button>';

	if ($v['state'] == 'En préparation') {
		$statut =  '<input type="checkbox" data-object="ordered_hx" value="'.$v['id'].'"';
		$statut .= 'class="iswitch iswitch-md iswitch-primary"><h4><small class="rouge">Changer en expédié</small></h4>';
	}else if ($v['state'] == 'Expédié') {
		$statut =  '<button type="button" class="btn btn-info navbar-btn  btn-icon btn-xs" data-toggle="modal" data-target="#modal-valid-commande" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Cliquer pour confirmer la livraison de la commande" data-placement="top" data-id="'.$v['id'].'">Confirmer la livraison</button>';
	}
	

	$action = '<a href="details-commande.php?id='.$v['id'].'" class="btn btn-default navbar-btn  btn-icon btn-xs" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Détails" data-placement="top"> <i class="fa fa-edit"></i></a>';

 	$client = $db->get_row("SELECT clients.* FROM clients where id=".$v['id_client']);

 
	$result["aaData"][]=array(
	'id' => '',
	'ref_commande'=>$v['ref_commande'],
	'client'=> "<span class='infos-client' onclick='detailsClient(".$client['id'].");'>".$client['firstName']." ".$client['lastName'],
	'tableau'=>$tableau,
	"date_create"=> date("d/m/Y", strtotime($v['date_create'])),
	'etat'=> ($v['etat'] == 'Payé') ? '<span class="badge badge-success">'.$v['etat'].'</span>' : '<span class="badge badge-danger">'.$v['etat'].'</span>',
	"total"=>$v['total'],
	'statut'=> ($v['state'] == 'En préparation') ? '<span class="badge badge-danger">'.$v['state'].'</span>' : '<span class="badge badge-warning">'.$v['state'].'</span>',
	'action'=>$statut,
	'details'=>$action,
	);

endforeach;

echo json_encode($result,true);


	
	// image produit
	/*$product_images = $db->get_rows("SELECT * FROM `product_images` WHERE `id_product` =".$v['id_product']);
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
	}*/


//$product = $db->get_row("SELECT * FROM `products` WHERE `id` =".$v['id_product']);
?>