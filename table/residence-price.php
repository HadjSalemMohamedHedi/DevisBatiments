<?php
	include_once '../includes/config.inc.php';
	
	$result = array("aaData"=>array());
	
	$filter = '';
	$deleted =(isset($_GET['trash']) && $_GET['trash']=='true')?1:0;
	$filter.='AND deleted='.$deleted;
	
	
	
	if (isset ($_GET['id_residence'])){
	$filter.=' AND id_residence='.$_GET['id_residence'];
	}
	
	$rows = $db->get_rows("SELECT residence_prix.* FROM  residence_prix WHERE 1 $filter");
 	foreach($rows as $x=>$v):
	
 	 $date_debut_ = strtotime($v['periode_de']);
		$v['periode_de'] = date('d/m/Y',$date_debut_);
		
	$date_debut_ = strtotime($v['periode_a']);
		$v['periode_a'] = date('d/m/Y',$date_debut_);
		
	$action ='';
	if(isset($_GET['trash']) && $_GET['trash']=='true'){
		$action .= '<a href="manage-residences.php?trash=true&action=restore&id='.$v['id'].'" class="btn btn-success btn-icon btn-xs">Restaurer</a>';
		$action .= ' <button type="button" class="btn btn-danger btn-icon btn-xs" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Supprimer définitivement" data-placement="top" onclick="delTrash('.$v['id'].')"> <i class="fa fa-remove"></i></button>';
		
		}else{
 		$action .= ' <button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="Edit('.$v['id'].',\''.$v['periode_de'].'\',\''.$v['periode_a'].'\')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Modifier" data-placement="top"> <i class="fa fa-edit"></i></button>';
	if ($v['type'] != 'standard'){	
		$action .= ' <button type="button" class="btn btn-default navbar-btn btn-icon btn-xs" onclick="delItem('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Placer dans la corbeille " data-placement="top"> <i class="fa fa-trash"></i></button>';
	}
	}
	
	
	$statut =  '<input type="checkbox" data-object="residence_prix"  value="'.$v['id'].'"';
	if($v['statut']==1){ $statut .= ' checked="" '; }
	$statut .= 'class="iswitch iswitch-md iswitch-primary">';
	
/* 	$date_debut_ = strtotime($v['periode_de']);
		$v['periode_de'] = date('d-m-Y',$date_debut_);
		
	$date_debut_ = strtotime($v['periode_a']);
		$v['periode_a'] = date('d-m-Y',$date_debut_);
	 */
	
 	$periode="De ".$v['periode_de']." à ".$v['periode_a'];
	
	if ($v['type'] == 'standard'){
	$periode="Prix Standard";
	$statut="Par default";
	}
	
	
	
	$result["aaData"][]=array(
	"id"=>$periode,
	 
	 
	 "lun"=>sprintf("%0.2F",($v['prix_lun'])),
	"mar"=>sprintf("%0.2F",($v['prix_mar'])),
	'mer'=>sprintf("%0.2F",($v['prix_mer'])),
	'jeu'=>sprintf("%0.2F",($v['prix_jeu'])),
	'ven'=>sprintf("%0.2F",($v['prix_ven'])),
	'sam'=>sprintf("%0.2F",($v['prix_sam'])),
	'dim'=>sprintf("%0.2F",($v['prix_dim'])),
	'statut'=>$statut,
	'action'=>$action,
	);

	endforeach;
	
	echo json_encode($result,true);
?>