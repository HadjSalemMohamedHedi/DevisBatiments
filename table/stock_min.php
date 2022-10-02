<?php
	include_once '../includes/config.inc.php';
	
	$result = array("aaData"=>array());
 
	$rows = $db->get_rows("SELECT sous_products_table.* FROM sous_products_table WHERE statut = 1");
	foreach($rows as $x=>$v):
	

		if ($v["stock_min"] != 0) {
   			if($v["quantite"] <= $v["stock_min"]){ 

   				$result["aaData"][]=array(
					"code_article"=>$v['code_article'],
					"designation"=>$v['designation'],
					"quantite"=>$v['quantite'],
					"stock_min"=>$v['stock_min'],
					);

   			 }
   		}

	

endforeach;

echo json_encode($result,true);
?>