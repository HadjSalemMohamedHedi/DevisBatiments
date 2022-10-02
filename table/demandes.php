<?
	include_once '../includes/config.inc.php';
	
	$result = array("aaData"=>array());
	
	$filter = '';
	$deleted =(isset($_GET['trash']) && $_GET['trash']=='true')?1:0;
	$filter.='AND deleted='.$deleted;
	
	if (isset($_GET['id_categ']) ){$filter.=" AND `id_categ` =".$_GET['id_categ'];}
	
	
	$rows = $db->get_rows("SELECT demandes.* FROM demandes where statut != 'deleted' " );
	foreach($rows as $x=>$v):
	
	$client = $db->get_row("SELECT clients.* FROM clients where id=".$v['id_client']);

	//print_debug($v);
 
	$action ='';
	if(isset($_GET['trash']) && $_GET['trash']=='true'){
		$action .= '<a href="manage-client.php?trash=true&action=restore&id='.$v['id'].'" class="btn btn-success btn-icon btn-xs">Restaurer</a>';
		$action .= ' <button type="button" class="btn btn-danger btn-icon btn-xs" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Supprimer définitivement" data-placement="top" onclick="delTrash('.$v['id'].')"> <i class="fa fa-remove"></i></button>';
		
		}else{
		$action .= '<a type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" href="details-commande?id='.$v['id'].'" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Détails de la commande" data-placement="top"> <i class="fa fa-info-circle"></i></a>';
		
		$action .= ' <button type="button" class="btn btn-default navbar-btn btn-icon btn-xs" onclick="delItem('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Placer dans la corbeille " data-placement="top"> <i class="fa fa-trash"></i></button>';
	}
	
	$tableau = '<button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="edit_table('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Composants" data-placement="top"> <i class="fa fa-table"></i></button>';

	if($v['statut']== 'validé'){
	 	$statut = '<span class="badge badge-success">Traitée</span>'; 
	}else{
			$statut =  '<input type="checkbox" data-object="demandes" value="'.$v['id'].'"';
 		$statut .= 'class="iswitch iswitch-md iswitch-primary" onclick="valider_demande(\''.$v['id'].'\');" id="input--'.$v['id'].'">';	
	}


	$result["aaData"][]=array(
	'client'=> "<span class='infos-client' onclick='detailsClient(".$client['id'].");'>".$client['firstName']." ".$client['lastName'],
	"Ref"=>$v['ref'],
	'tableau'=>$tableau,
	"titre_fr"=>$v['titre'],
	"emballage"=>$v['emballage'],
	'statut'=>$statut,
	'action'=>$action,
	);

endforeach;

echo json_encode($result,true);
?>