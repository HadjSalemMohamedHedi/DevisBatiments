<?php
	 include_once '../../includes/config.inc.php';
	
	$json = array();
	
 	if (isset($_GET['id_categ']))
	{
		 $sub_categ_column = $db->get_rows('SELECT * FROM sub_categ where  sub_categ.deleted = 0 and sub_categ.statut=1 and id_categ ='.$_GET['id_categ']); 
			
			foreach ($sub_categ_column as $categ)
			{  
			$json[$categ['id']][] = $categ['titre_fr'];
		//	$json[] = $categ['title'];
			}
	
		echo json_encode($json);
	} 
?>