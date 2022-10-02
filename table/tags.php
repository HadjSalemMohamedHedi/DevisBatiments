<?php
	include_once '../includes/config.inc.php';
	
	$result = array("aaData"=>array());
	
	$filter = '';
	$deleted =(isset($_GET['trash']) && $_GET['trash']=='true')?1:0;
	$filter.='AND deleted='.$deleted;
	
	$rows = $db->get_rows("SELECT tags.* FROM tags WHERE 1 $filter  ");
	$total_nbr = $db->get_row("SELECT SUM(nbr) as total FROM tags WHERE 1   ");
	$total=$total_nbr['total'];
	
	
	foreach($rows as $x=>$v):
	
	//print_debug($v);
	
	$action ='';
	if(isset($_GET['trash']) && $_GET['trash']=='true'){
		$action .= '<a href="manage-tags.php?trash=true&action=restore&id='.$v['id'].'" class="btn btn-success btn-icon btn-xs">Restaurer</a>';
		$action .= ' <button type="button" class="btn btn-danger btn-icon btn-xs" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Supprimer définitivement" data-placement="top" onclick="delTrash('.$v['id'].')"> <i class="fa fa-remove"></i></button>';
		
		}else{
		$action .= '<button type="button" class="btn btn-default navbar-btn  btn-icon btn-xs" data-toggle="modal" onclick="Edit('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Modifier" data-placement="top"> <i class="fa fa-edit"></i></button>';
		$action .= ' <button type="button" class="btn btn-default navbar-btn btn-icon btn-xs" onclick="delItem('.$v['id'].')" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Archiver " data-placement="top"> <i class="fa fa-trash"></i></button>';
	}
	
	$statut =  '<input type="checkbox" data-object="tags" value="'.$v['id'].'"';
	if($v['statut']==1){ $statut .= ' checked="" '; }
	$statut .= 'class="iswitch iswitch-md iswitch-primary">';
	
	
	$percent= round ( ($v['nbr'] / $total) * 100 ) ;
	
	$progress='
	   <div class="progress">
                                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percent.'%">
                                                
                                            </div>
                                        </div> 
					
	';
	
	$result["aaData"][]=array(
	"id"=>$v['id'],
	"titre_fr"=>$v['titre_fr'],
	"nbr"=>$progress,
	'statut'=>$statut,
	'action'=>$action,
	);
	
	endforeach;
	
	echo json_encode($result,true);
?>