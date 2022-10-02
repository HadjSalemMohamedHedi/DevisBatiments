<?php
	include_once '../includes/config.inc.php';
	
	$result = array("aaData"=>array());
	
	$filter = '';
	$deleted =(isset($_GET['trash']) && $_GET['trash']=='true')?1:0;
	$filter.='AND deleted='.$deleted;
	$rows = $db->get_rows("SELECT  residence_type.* FROM  residence_type WHERE 1 $filter");
	//$rows = $db->get_rows("SELECT client.* FROM client WHERE 1 $filter");
	foreach($rows as $x=>$v):
	
	//print_debug($v);
	
	$action ='';
	if(isset($_GET['trash']) && $_GET['trash']=='true'){
		$action .= '<a href="manage-residences.php?trash=true&action=restore&id='.$v['id'].'" class="btn btn-success btn-icon btn-xs">Restaurer</a>';
		$action .= ' <button type="button" class="btn btn-danger btn-icon btn-xs" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Supprimer définitivement" data-placement="top" onclick="delTrash('.$v['id'].')"> <i class="fa fa-remove"></i></button>';
		
		}else{
		$action .= '<button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="Edit_Prix('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Gerrer les prix" data-placement="top"> <i class="fa fa-usd"></i></button>';
		$action .= ' <button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="Edit('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Modifier" data-placement="top"> <i class="fa fa-edit"></i></button>';
		$action .= ' <button type="button" class="btn btn-default navbar-btn btn-icon btn-xs" onclick="delItem('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Placer dans la corbeille " data-placement="top"> <i class="fa fa-trash"></i></button>';
	}
	
	$statut =  '<input type="checkbox" data-object="residence_type" value="'.$v['id'].'"';
	if($v['statut']==1){ $statut .= ' checked="" '; }
	$statut .= 'class="iswitch iswitch-md iswitch-primary">';
	
	if(($v['img']!="")) {$src_img=$v['img'];}else{$src_img="assets/images/no-img.png";}
	
			$action_nbr_chambre = ' <button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="Edit_Chambre('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Gerrer les chambres" data-placement="top"> <i class="fa fa-edit"></i></button>';

	
	
	$result["aaData"][]=array(
	"id"=>$v['id'],
	"image"=>'<img class="img-responsive" src="'.$src_img.'" alt="" style=" width: 120px;">',
	"type"=>$v['titre_fr'],
	'nombre'=>$v['nb_chambre_total']." ".$action_nbr_chambre,
	'adulte'=>$v['max_adults'],
	'enfant'=>$v['max_child'],
	'statut'=>$statut,
	'action'=>$action,
	);

	endforeach;
	
	echo json_encode($result,true);
?>