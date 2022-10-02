<?php
include_once '../includes/config.inc.php';

$result = array("aaData"=>array());
$filter = '';
	
if(isset($_GET['id_user'])){
	$filter.= " AND id_user ='".$db->escape($_GET['id_user'])."'";
}
//	$aColumns = array('id_invoice','date','date_echeance','name_client','mode_paiement','num_invoice','id_client','password','name_client','invoice_aquittee');
	$aColumns = array('id_tracing','id_user','id_object','type','object','sql_execute','created');
	
	//$aColumns = array('id_invoice','date','date_echeance');
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "id_tracing";
	
	/* DB table to use */
	$sTable = "tracing";
	
	
	/* 
		* Local functions
	*/
	function fatal_error ( $sErrorMessage = '' )
	{
		header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
		die( $sErrorMessage );
	}
	/* 
		* Paging
	*/
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
		intval( $_GET['iDisplayLength'] );
	}
	
	/*
		* Ordering
	*/
	$sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= "$sTable.`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
				($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	/* 
		* Filtering
		* NOTE this does not match the built-in DataTables filtering which does it
		* word by word on any field. It's possible to do here, but concerned about efficiency
		* on very large tables, and MySQL's regex functionality is very limited
	*/
		$sWhere = "";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		$sWhere .= " WHERE ( users.firstname LIKE '%".$db->escape( strtoupper($_GET['sSearch'] ))."%'  OR  users.firstname LIKE '%".$db->escape( ($_GET['sSearch'] ))."%'  OR ";
  
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" )
			{
				$sWhere .= "$sTable.`".$aColumns[$i]."` LIKE '%".$db->escape( $_GET['sSearch'] )."%' OR ";
			}
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}

	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= "$sTable.`".$aColumns[$i]."` LIKE '%".$db->escape($_GET['sSearch_'.$i])."%' ";
		}
	}
	
	/*
		* SQL queries
		* Get data to display
	*/
	$sQuery = "
	SELECT SQL_CALC_FOUND_ROWS $sTable.`".str_replace(" , ", " ", implode("`,$sTable.`", $aColumns))."`
	FROM   $sTable
	INNER JOIN users on $sTable.id_user=users.id
	$sWhere
	$sOrder
	$sLimit
	";
	
	$rResult = $db->get_rows($sQuery);
	
	/*******************************/
	$sQuery_2 = "
	SELECT SQL_CALC_FOUND_ROWS $sTable.`".str_replace(" , ", " ", implode("`, $sTable.`", $aColumns))."`
	FROM   $sTable
	INNER JOIN users on $sTable.id_user=users.id
	$sWhere
	"; 
	$rResult_2 = $db->get_rows($sQuery_2);
	/*********************************/
	
	
	/* Data set length after filtering */
	$sQuery = "
	SELECT FOUND_ROWS()
	";
	
	$aResultFilterTotal = $db->get_rows($sQuery);
	// $aResultFilterTotal[0]=count($rResult);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	//$iFilteredTotal=count($rResult);
	
	/* Total data set length */
	$sQuery = "
	SELECT *
	FROM   $sTable
	";
	
	$aResultTotal = $db->get_rows($sQuery);
	$iTotal = count($aResultTotal);
	
	/*
		* Output
	*/
	$output = array(
	"sEcho" => intval($_GET['sEcho']),
	"iTotalRecords" => $iTotal,
	"iTotalDisplayRecords" => count($rResult_2),
	"aaData" => array()
	);
$tracing = $db->get_rows("SELECT $sTable.*,users.firstname,users.lastname,users.classe FROM tracing 
    INNER JOIN users on $sTable.id_user=users.id
    $sWhere
	$sOrder
	$sLimit");


foreach($tracing as $x=>$v):

//print_debug($v);
$type='';
switch ($v['type']) {
					case 'INSERT':
						$type= "Insertion";
						break;
					case 'UPDATE':
						$type= "Modification";
						break;
					case 'DELETE':
						$type= "Suppression";
						break;
				}
				//$user=getUser($v['id_user']);
				switch($v['classe']):
					case 1 : $user_classe= "Administrateur"; break;
					case 2 : $user_classe=  "Collaborateur"; break;
					case 3 : $user_classe=  "Commercial"; break;
					case 4 : $user_classe=  "Responsable"; break;
					default:$user_classe= "CaptiveCallCenter";
				  endswitch;
$output["aaData"][]=array(
						   "id"=>$v['id_tracing'],
						   "type"=>$type,
						   'object'=> $v['object'],
						   'created'=>customdate($v['created'],$lang_default['id_lang'],true,true),
						   "id_user"=>'<b>'.$user_classe.'</b> :<br> '.$v['firstname'].' '.$v['lastname'],
						   "sql_execute"=> substr(wordwrap($v['sql_execute'], 60, "<br />\n",true),0,150)
							 );

endforeach;

echo json_encode($output,true);
?>
