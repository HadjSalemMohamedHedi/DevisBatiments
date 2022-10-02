<?php
	include_once '../includes/config.inc.php';
	
	$result = array("aaData"=>array());
	
	$filter = '';
	$deleted =(isset($_GET['trash']) && $_GET['trash']=='true')?1:0;
	$filter.='AND deleted='.$deleted;
	
	$rows = $db->get_rows("SELECT colonnes.* FROM colonnes WHERE 1 $filter");
	foreach($rows as $x=>$v):
	
	//print_debug($v);
	
	$action ='';
	if(isset($_GET['trash']) && $_GET['trash']=='true'){
		$action .= '<a href="manage-colonnes.php?trash=true&action=restore&id='.$v['id'].'" class="btn btn-success btn-icon btn-xs">Restaurer</a>';
		$action .= ' <button type="button" class="btn btn-danger btn-icon btn-xs" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Supprimer définitivement" data-placement="top" onclick="delTrash('.$v['id'].')"> <i class="fa fa-remove"></i></button>';
		
		}else{
		$action .= '<button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="Edit('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Modifier" data-placement="top"> <i class="fa fa-edit"></i></button>';
		$action .= ' <button type="button" class="btn btn-default navbar-btn btn-icon btn-xs" onclick="delItem('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Placer dans la corbeille " data-placement="top"> <i class="fa fa-trash"></i></button>';
	}
	
	$statut =  '<input type="checkbox" data-object="colonnes" value="'.$v['id'].'"';
	if($v['statut']==1){ $statut .= ' checked="" '; }
	$statut .= 'class="iswitch iswitch-md iswitch-primary">';
	
	if ($v['icon']=="") {
			$img="";
			}else{
			$img="<img style='width:auto; max-height: 40px; ' src='upload/".$v['icon']."' >";
		}
	
   
	
	
	 $colonnes_type = $db->get_row("SELECT colonnes_types.* FROM colonnes_types WHERE id=".$v['id_type']);
	$type=$colonnes_type['type'];
	
	$result["aaData"][]=array(
	"id"=>$img,
	"titre_fr"=>$v['titre_fr'],
	"titre_en"=>$v['titre_en'],
	'type'=>$type,
	'statut'=>$statut,
	'action'=>$action,
	);
	
	endforeach;
	
	echo json_encode($result,true);
?>