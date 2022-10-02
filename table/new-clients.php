<?php
	include_once '../includes/config.inc.php';
	
	$result = array("aaData"=>array());
	
	//$filter = '';
	//$deleted =(isset($_GET['trash']) && $_GET['trash']=='true')?1:0;
	//$filter.='AND deleted='.$deleted;
	//$rows = $db->get_rows("SELECT clients.* FROM clients  WHERE id NOT IN (SELECT id_client FROM demandes) and  deleted != 'deleted' ");

	
	$rows = $db->get_rows("SELECT clients.* FROM clients WHERE deleted != 'deleted' and activate = 0");
	foreach($rows as $x=>$v):
	
	//print_debug($v);
	
	$action ='';
	if(isset($_GET['trash']) && $_GET['trash']=='true'){
		$action .= '<a href="manage-client.php?trash=true&action=restore&id='.$v['id'].'" class="btn btn-success btn-icon btn-xs">Restaurer</a>';
		$action .= ' <button type="button" class="btn btn-danger btn-icon btn-xs" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Supprimer définitivement" data-placement="top" onclick="delTrash('.$v['id'].')"> <i class="fa fa-remove"></i></button>';
		
		}else{
		$action .= '<button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="Edit('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Modifier" data-placement="top" style="display:none;"> <i class="fa fa-edit"></i></button>';
		$action .= ' <a type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" href="details-client?id='.$v['id'].'" rel="tooltip" data-animate=" animated tada" data-original-title="Détails de la demande" data-placement="top"> <i class="fa fa-info-circle"></i></a>
		<button type="button" class="btn btn-default navbar-btn btn-icon btn-xs" onclick="delItem('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Placer dans la corbeille " data-placement="top"> <i class="fa fa-trash"></i></button>
			';
	}
	
	$statut =  '<input type="checkbox" data-object="clients" value="'.$v['id'].'"';
	if($v['status'] == 1){ $statut .= ' checked="" '; }
	$statut .= 'class="iswitch iswitch-md iswitch-primary">';
		
	$adresseliv = "";
	if($v['adressliv'] != ""){
		$adresseliv = " <h6><b>Adresse de livraison: </b> </h6>".$v['adressliv'] ;
	}

	$result["aaData"][]=array(
	"id"=>'',
	"full_name"=>$v['firstName']." ".$v['lastName'],
	"email"=>$v['email'],
	"adresse"=>$v['address'].$adresseliv,
	"activity"=>$v['activity'],
	"societe"=>$v['societe'],
	'contact'=>$v['phone'],
	'statut'=>$statut,
	'action'=>$action,
	);
	
	endforeach;
	
	echo json_encode($result,true);
?>