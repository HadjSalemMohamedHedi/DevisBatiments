<?php
	include_once '../includes/config.inc.php';
	
	$result = array("aaData"=>array());
	
	$filter = '';
	$deleted =(isset($_GET['trash']) && $_GET['trash']=='true')?1:0;
	$filter.='AND deleted='.$deleted;
	$rows = $db->get_rows("SELECT  residence_reservation.* FROM  residence_reservation WHERE 1 $filter");
	//$rows = $db->get_rows("SELECT client.* FROM client WHERE 1 $filter");
	foreach($rows as $x=>$v):
	
	//print_debug($v);
	
	$action ='';
	if(isset($_GET['trash']) && $_GET['trash']=='true'){
		$action .= '<a href="manage-residences.php?trash=true&action=restore&id='.$v['id'].'" class="btn btn-success btn-icon btn-xs">Restaurer</a>';
		$action .= ' <button type="button" class="btn btn-danger btn-icon btn-xs" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Supprimer définitivement" data-placement="top" onclick="delTrash('.$v['id'].')"> <i class="fa fa-remove"></i></button>';
		
		}else{
		$action .= ' <button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="Edit('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Modifier" data-placement="top"> <i class="fa fa-edit"></i></button>';
		/* $action .= ' <button type="button" class="btn btn-default navbar-btn btn-icon btn-xs" onclick="delItem('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Placer dans la corbeille " data-placement="top"> <i class="fa fa-trash"></i></button>'; */
	}
	$disabled_checkout="";
	$checkin =  '<input type="checkbox" data-object="checkin" value="'.$v['id'].'"';
	if($v['checkin']==1){  $checkin .= ' checked="" '; }else{$disabled_checkout="disabled";}
	$checkin .= 'class="iswitch iswitch-md iswitch-primary">';
	
	
	
	$checkout =  '<input  '.$disabled_checkout.' type="checkbox" data-object="checkout" value="'.$v['id'].'"';
	if($v['checkout']==1){ $checkout .= ' checked="" '; }
	$checkout .= 'class="iswitch iswitch-md iswitch-primary">';
	
	
	$payed =  '<input type="checkbox" data-object="payed" value="'.$v['id'].'"';
	if($v['payed']==1){ $payed .= ' checked="" '; }
	$payed .= 'class="iswitch iswitch-md iswitch-primary">';
	
	
	
		$date_debut_ = strtotime($v['date_debut']);
		$v['date_debut'] = date('d-m-Y',$date_debut_);
		
	$date_fin_ = strtotime($v['date_fin']);
		$v['date_fin'] = date('d-m-Y',$date_fin_);
	
	
	$residence_type = $db->get_row("SELECT residence_type.* FROM residence_type WHERE  residence_type.id=".$db->escape($v['id_residence_type']));
	$client = $db->get_row("SELECT client.* FROM client WHERE  client.id=".$db->escape($v['id_client']));
	
	$result["aaData"][]=array(
	"id"=>$v['id'],
	"residence_type"=>$residence_type['titre_fr'],
	"client"=>$client['lastname']." ".$client['firstname'],
	'date_debut'=>$v['date_debut'],
	'date_fin'=>$v['date_fin'],
	'prix'=>sprintf("%0.2F",($v['prix']))." DT",
	'payed'=>$payed,
	'checkin'=>$checkin,
	'checkout'=>$checkout,
	'action'=>$action,
	);
 
	
	
	endforeach;
	
	echo json_encode($result,true);
?>