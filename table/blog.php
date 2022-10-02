<?php
	include_once '../includes/config.inc.php';
	
	$result = array("aaData"=>array());


	$rows = $db->get_rows("SELECT * FROM actualites WHERE deleted = 0 and type ='Bloger' ");
	foreach($rows as $x=>$v):
	
	//print_debug($v);
	
	$action ='';
	if(isset($_GET['trash']) && $_GET['trash']=='true'){
		$action .= '<a href="manage-client.php?trash=true&action=restore&id='.$v['id'].'" class="btn btn-success btn-icon btn-xs">Restaurer</a>';
		$action .= ' <button type="button" class="btn btn-danger btn-icon btn-xs" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Supprimer définitivement" data-placement="top" onclick="delTrash('.$v['id'].')"> <i class="fa fa-remove"></i></button>';
		
		}else{
		$action .= '<button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="Edit('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Modifier" data-placement="top"" style="display:none"> <i class="fa fa-edit"></i></button>';
		$action .= ' <a type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" href="details-actualite?id='.$v['id'].'" rel="tooltip" data-animate=" animated tada" data-original-title="Détails de l\'actualité" data-placement="top"> <i class="fa fa-edit"></i></a>
		<button type="button" class="btn btn-default navbar-btn btn-icon btn-xs" onclick="delItem('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Archiver ce actualité " data-placement="top"> <i class="fa fa-trash"></i></button>';
	}
	
	$statut =  '<input type="checkbox" data-object="actualites" value="'.$v['id'].'"';
	if($v['status']==1){ $statut .= ' checked="" '; }
	$statut .= 'class="iswitch iswitch-md iswitch-primary">';
		
	// image actualite
	$actualite_images = $db->get_rows("SELECT * FROM `actualite_images` WHERE `id_actualite` =".$v['id']);

	//var_dump($actualite_images);

	if (count($actualite_images) > 0){
		$name_img = str_replace("images-actualites/".$v['id']."/", "images-actualites/".$v['id']."/s/50_", $actualite_images[0]['path']);
			$img="<img width=100 src='../../../".$name_img."' >";
	}else{
		$name_img="images-actualites/empty.png";
		$img="<img width=100 src='../../../".$name_img."' >";
	}


	$result["aaData"][]=array(
	"id"=>'',
	"titre"=>$v['titre_fr'],
	"date_debut"=>$v['date_debut'],
	"date_fin"=>$v['date_fin'],
	"date_fin"=>$v['date_fin'],
	"src_img"=>$img,
	"brev_description"=>$v['brev_description'],
	'status'=>$statut,
	'action'=>$action,
	);
	
	endforeach;
	
	echo json_encode($result,true);
?>