<?php
include_once '../includes/config.inc.php';

$result = array("aaData"=>array());
$filter = '';

if(isset($_GET['trash']) && $_GET['trash']=='true'){
	$deleted = 1;
}else{
	$deleted = 0;
}
$filter.='AND  deleted='.$deleted;
/*search*/
if(isset($_GET['firstname'])){
	$filter.= " AND client.firstname LIKE '%".$db->escape($_GET['firstname'])."%'";
}if(isset($_GET['lastname'])){
	$filter.= " AND client.firstname LIKE '%".$db->escape($_GET['firstname'])."%'";
}if(isset($_GET['id_title'])){
	$filter.= " AND client.id_title='".$db->escape($_GET['id_title'])."'";
}if(isset($_GET['name2'])){
	$filter.= " AND client.name2 LIKE '%".$db->escape($_GET['name2'])."%'";
}if(isset($_GET['id_contact_type'])){
	$filter.= " AND client.id_contact_type='".$db->escape($_GET['id_contact_type'])."'";
}if(isset($_GET['address'])){
	$filter.= " AND client.address LIKE '%".$db->escape($_GET['address'])."%'";
}if(isset($_GET['postcode'])){
	$filter.= " AND client.postcode LIKE '%".$db->escape($_GET['postcode'])."%'";
}if(isset($_GET['locality'])){
	$filter.= " AND client.locality LIKE '%".$db->escape($_GET['locality'])."%'";
}if(isset($_GET['id_country'])){
	$filter.= " AND client.id_country='".$db->escape($_GET['id_country'])."'";
}if(isset($_GET['id_currency'])){
	$filter.= " AND client.id_currency='".$db->escape($_GET['id_currency'])."'";
}if(isset($_GET['id_lang'])){
	$filter.= " AND client.id_lang='".$db->escape($_GET['id_lang'])."'";
}if(isset($_GET['id_manager'])){
	$filter.= " AND client.id_manager='".$db->escape($_GET['id_manager'])."'";
}

/*AND client.id_avocat='".$_SESSION['User']['id_avocat']."'*/

$users = $db->get_rows("SELECT users.* FROM users WHERE users.classe='2' $filter");


foreach($users as $x=>$v):

//print_debug($v);

$action ='';
if(isset($_GET['trash']) && $_GET['trash']=='true'){
	$action .= '<a href="manage-client.php?trash=true&action=restore&id='.$v['id'].'" class="btn btn-success btn-icon btn-xs">Restaurer</a>';
	$action .= ' <button type="button" class="btn btn-danger btn-icon btn-xs" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Supprimer définitivement" data-placement="top" onclick="delTrash('.$v['id'].')"> <i class="fa fa-remove"></i></button>';

}else{
$action .= '<button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="Editusers('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Modifier" data-placement="top"> <i class="fa fa-edit"></i></button>';
$action .= ' <button type="button" class="btn btn-default navbar-btn btn-icon btn-xs" onclick="delItem('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Placer dans la corbeille " data-placement="top"> <i class="fa fa-trash"></i></button>';
}

$address = $v['address'].' '.$v['postcode'].' ,';
$phone = '';


$statut =  '<input type="checkbox" data-object="users" value="'.$v['id'].'"';
 if($v['status']==1){ $statut .= ' checked="" '; }
$statut .= 'class="iswitch iswitch-md iswitch-primary">';


if($v['phone']!==''){$phone .= '<strong>Tel: </strong>'.$v['phone'];}



							 $result["aaData"][]=array("id"=>$v['id'],
							 "firstname"=>$v['firstname'],
							 "lastname"=>$v['lastname'],
							 "username"=>$v['username'],
							 'phone'=>$v['phone'],
							 'email'=>$v['email'],
							 'action'=>$action,
							 'address'=> $v['address'],
							 'postcode'=> $v['postcode'],
							 'color'=>$v['color'],
							
						     'created'=>customdate($v['created'],$lang_default['id_lang'],false,true),
							 'status'=>$statut,
							 'action'=>$action,
							 
							 );

endforeach;

echo json_encode($result,true);
?>
