<?php  include_once '../../includes/config.inc.php';
	if(!$_POST) {exit;}
	
	$data = json_decode(stripslashes($_POST['data']));
	
	// echo $data[0][7][0]." ==> ".$data[0][7][1];
	 print_r($data); 
		 
	 //exit(); 
	
	/*ajout*/
	if($_POST['action']=='add' ){
		
 		$db->query("DELETE FROM `product_table_charge_fr` WHERE product_table_charge_fr.id_product = ".$_POST['id_product']);
		
		//foreach ($data as $d){	
		
		
		for($i=0;$i<count($data);$i++)
		{
			$product_table_charge_fr=array();
			$product_table_charge_fr['id_product']=$_POST['id_product'];
			$product_table_charge_fr['l_mm']=$data[$i][0][1];
			
			$product_table_charge_fr['charge_1']=$data[$i][1][1];
			$product_table_charge_fr['fleche_1']=$data[$i][2][1];
			
			$product_table_charge_fr['charge_2']=$data[$i][3][1];
			$product_table_charge_fr['fleche_2']=$data[$i][4][1];
			
			$product_table_charge_fr['charge_3']=$data[$i][5][1];
			$product_table_charge_fr['fleche_3']=$data[$i][6][1];
			
			$product_table_charge_fr['charge_4']=$data[$i][7][1];
			$product_table_charge_fr['fleche_4']=$data[$i][8][1];
			
 			$product_table_charge_fr['rang']=$i;
 			$product_table_charge_fr['statut']=1;
			$db->insert('product_table_charge_fr',$product_table_charge_fr) ;
			
		}
		/* */
		$_SESSION['notification'] = array('type'=>'succes','msg'=>'Mise à jour du tableau effectué avec succès');
		echo '<div class="alert alert-success alert-dismissible fade in">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		<strong>Success:</strong>Mise à jour du tableau effectué avec succès.</div>';
	}
	
	
	
	
?>																				