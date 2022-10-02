<?php
	include_once '../includes/config.inc.php';
	
	$result = array("aaData"=>array());
	
	$filter = '';
	$deleted =(isset($_GET['trash']) && $_GET['trash']=='true')?1:0;
	$filter.='AND deleted='.$deleted;
	$today=date("Y-m-d");
	$rows = $db->get_rows("SELECT  residence_reservation.* FROM  residence_reservation WHERE date_debut='".$today."' $filter");
	//$rows = $db->get_rows("SELECT client.* FROM client WHERE 1 $filter");
	foreach($rows as $x=>$v):
	
	//print_debug($v);
	
	$action ='';

	
	$action .= ' <button type="button" style="    background: green;color:white;" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="checkin('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Modifier" data-placement="top">CHECK IN</button>';

	
	
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
	
	$date_fin_ = strtotime($v['date_reservation']);
		$v['date_reservation'] = date('d-m-Y',$date_fin_);
	
	
	$residence_type = $db->get_row("SELECT residence_type.* FROM residence_type WHERE  residence_type.id=".$db->escape($v['id_residence_type']));
	$client = $db->get_row("SELECT client.* FROM client WHERE  client.id=".$db->escape($v['id_client']));
	
	$paied="";
	$paied="<i class='fa fa-check' style='color:green'></i>"; // si la réservation a été payée
	
	
	$result["aaData"][]=array(
	"ref"=>$v['ref'],
	"client"=>$client['lastname']." ".$client['firstname'],
	'date_debut'=>$v['date_debut'],
	'date_fin'=>$v['date_fin'],
		'prix'=>sprintf("%0.2F",($v['prix']))." DT ".$paied,
	'action'=>$action,
	);
 
	
	
	endforeach;
	
	echo json_encode($result,true);
?>