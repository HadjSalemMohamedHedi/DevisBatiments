<?php 
	 
	include_once '../../includes/config.inc.php';
	
	die();
	$categs = $db->get_rows("SELECT categ.* FROM categ WHERE categ.deleted = 0 and categ.statut=1");
	
	foreach ($categs as $categ){
		
		$id_categ=$categ['id'];
		$titre_categ=$categ['titre_fr'];
 		$sub_categs = $db->get_rows("SELECT sub_categ.* FROM sub_categ WHERE sub_categ.deleted = 0 and sub_categ.statut=1 and id_categ=".$id_categ);
		$rang=1;
		foreach ($sub_categs as $sub_categ)
		{
			 
			/* $filter=" and id_sub_categ=".$sub_categ['id'];
			$query="SELECT products.* FROM products WHERE statut = 1 and deleted = 0 ".$filter;
			
			$product_list = $db->get_rows($query); */
 			
			
			
 			
			$query="UPDATE `sub_categ` SET `rang`=".$rang." WHERE `id`=".$sub_categ['id'];
			$db->query($query);
			$rang++;
			echo "<br>".$query."<br>--------------<br>";
			
		 
			
			
			
			
		/* 	$rang=1;
			foreach ($product_list as $product){
			
			$query="UPDATE `products` SET `rang`=".$rang." WHERE `id`=".$product['id'];
			$db->query($query);
			$rang++;
			echo "<br>".$query."<br>--------------<br>";
			
			} */
 
		}
		
	}
?>