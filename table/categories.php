<?php
	include_once '../includes/config.inc.php';
	
	$result = array("aaData"=>array());
	
	$filter = '';
	$deleted =(isset($_GET['trash']) && $_GET['trash']=='true')?1:0;
	$filter.='AND deleted='.$deleted;
	
	if (isset($_GET['id_categ']) ){$filter.=" AND `id_categ` =".$_GET['id_categ'];}
	
	
	$rows = $db->get_rows("SELECT sub_categ.* FROM sub_categ WHERE 1 $filter");
	foreach($rows as $x=>$v):
	
	//print_debug($v);
	
	$action ='';
	if(isset($_GET['trash']) && $_GET['trash']=='true'){
		$action .= '<a href="manage-client.php?trash=true&action=restore&id='.$v['id'].'" class="btn btn-success btn-icon btn-xs">Restaurer</a>';
		$action .= ' <button type="button" class="btn btn-danger btn-icon btn-xs" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Supprimer définitivement" data-placement="top" onclick="delTrash('.$v['id'].')"> <i class="fa fa-remove"></i></button>';
		
		}else{
		$action .= '<button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="Edit('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Modifier" data-placement="top"> <i class="fa fa-edit"></i></button>';
		$action .= ' <button type="button" class="btn btn-default navbar-btn btn-icon btn-xs" onclick="delItem('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Archiver la catégorie " data-placement="top"> <i class="fa fa-trash"></i></button>';
	}
	
	$tableau = '<button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="edit_column_table('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Gerrer les colonnes des tableaux des produits pour cette catégorie" data-placement="top"> <i class="fa fa-table"></i></button>';

	$statut =  '<input type="checkbox" data-object="sub_categ" value="'.$v['id'].'"';
	if($v['statut']==1){ $statut .= ' checked="" '; }
	$statut .= 'class="iswitch iswitch-md iswitch-primary">';
	
	$result["aaData"][]=array(
	"id"=>$v['id'],
	"titre_fr"=>$v['titre_fr'],
	"titre_en"=>$v['titre_en'],
	"tableau"=>$tableau,
	
	'statut'=>$statut,
	'action'=>$action,
	);
	
	endforeach;
	
	echo json_encode($result,true);
?>