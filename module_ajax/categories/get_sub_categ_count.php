<?php
	include_once '../../includes/config.inc.php';
	
	$json = array();
	
 	if (isset($_GET['id_categ']))
	{
		
		$filter=" and id_categ=".$_GET['id_categ'];
		$query="SELECT sub_categ.* FROM sub_categ WHERE statut = 1 and deleted = 0 ".$filter;
		$product_list = $db->get_rows($query);
		$product_count= count($product_list);
		
		
		
		
		for ($k=1;$k<= ($product_count+ 1); $k++)
		{ 
			$json[$k][] = $k;
		}
		
		echo json_encode($json);
	} 
?>