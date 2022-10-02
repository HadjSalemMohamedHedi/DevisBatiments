<?php  include_once '../../includes/config.inc.php';
	if(!$_POST) {exit;}
	
	$data = json_decode(stripslashes($_POST['data']));
	
	// echo $data[0][7][0]." ==> ".$data[0][7][1];
	// print_r($data); 
		 
	 //exit(); 
	 	/*ajout*/

$count=0;
$action='add';

$product_table_rows_fr = $db->get_rows("SELECT  sous_products_table.* FROM sous_products_table WHERE statut = 1 and id_product = ".$_POST['id_product']." order by rang");

$count=count($product_table_rows_fr);

if($count>5550){
	$action="edit";
}


	if($action=='add' ){
		
 		$db->query("update sous_products_table set statut=0 WHERE sous_products_table.id_product = '".$_POST['id_product']."'");
		
		//foreach ($data as $d){	
		
		
		for($i=0;$i<count($data);$i++)
		{
			$product_table_charge_fr=array();

			$ShowCode=1;
			$product_table_rows_fr = $db->get_rows("SELECT  sous_products_table.* FROM sous_products_table WHERE code_article = '".addslashes($data[$i][0][1])."'");
			foreach ($product_table_rows_fr as $product_table_rows){
				if(($product_table_rows['showSousProduct']==0) || ($product_table_rows['showSousProduct'])==1 )
			$ShowCode=$product_table_rows['showSousProduct'];
			}

			$product_table_charge_fr['id_product']=$_POST['id_product'];
			$product_table_charge_fr['code_article']=$data[$i][0][1];
			
			$product_table_charge_fr['designation']=addslashes($data[$i][1][1]);
			$product_table_charge_fr['prix']=$data[$i][2][1];
			
			$product_table_charge_fr['tva']=$data[$i][3][1];
			
			$product_table_charge_fr['remise']=$data[$i][4][1];
			$product_table_charge_fr['unite']=$data[$i][5][1];
			
			$product_table_charge_fr['quantite']=$data[$i][6][1];
			$product_table_charge_fr['stock_min']=$data[$i][7][1];
			
 			$product_table_charge_fr['rang']=$i;
 			$product_table_charge_fr['statut']=1;

 			$product_table_charge_fr['showSousProduct']=$ShowCode;



 			$remise = $data[$i][3][1];
 			$prix = $data[$i][2][1];
 			if ($data[$i][3][1] != "") {
 				$promo_nb =  explode('%', $remise);
 				$prix_nb =  explode('€', $prix);
 				$final_price = str_replace(',', '.',  $prix_nb['0']);
 				$price_promo = ($final_price /100)*$promo_nb['0'] ; 
 				$gh_promo = $final_price -  $price_promo;
 				$product_table_charge_fr['prix_final'] = number_format($gh_promo, 2, '.', ' ');
 			}else{
 				$prix_nb =  explode('€', $prix);
 				$product_table_charge_fr['prix_final'] = str_replace(',', '.',  $prix_nb['0']);
 			}

 			$db->query("delete from sous_products_table WHERE code_article = '".addslashes($data[$i][0][1])."'");
			$db->insert('sous_products_table',$product_table_charge_fr) ;
			
		}
		/* */
		$_SESSION['notification'] = array('type'=>'succes','msg'=>'Mise à jour du tableau effectué avec succès');
		echo '<div class="alert alert-success alert-dismissible fade in">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		<strong>Success:</strong>Mise à jour du tableau effectué avec succès.</div>';
	}else{
$i=0;
		
 		foreach ($product_table_rows_fr as $product_table_rows){

 			//for($i=0;$i<count($data);$i++)
 			while ($i<=count($data)) 
 			
				{
					$product_table_charge_fr=array();
					$product_table_charge_fr['id_product']=$_POST['id_product'];
					$product_table_charge_fr['code_article']=$data[$i][0][1];
					
					$product_table_charge_fr['designation']=addslashes($data[$i][1][1]);
					$product_table_charge_fr['prix']=$data[$i][2][1];
					
					$product_table_charge_fr['remise']=$data[$i][3][1];
					$product_table_charge_fr['unite']=$data[$i][4][1];
					
					$product_table_charge_fr['quantite']=$data[$i][5][1];
					$product_table_charge_fr['stock_min']=$data[$i][6][1];

		 			$product_table_charge_fr['rang']=$i;
		 			$product_table_charge_fr['statut']=1;
		 			$product_table_charge_fr['showSousProduct']=$product_table_rows['showSousProduct'];



		 			$remise = $data[$i][3][1];
		 			$prix = $data[$i][2][1];
		 			if ($data[$i][3][1] != "") {
		 				$promo_nb =  explode('%', $remise);
		 				$prix_nb =  explode('€', $prix);
		 				$final_price = str_replace(',', '.',  $prix_nb['0']);
		 				$price_promo = ($final_price /100)*$promo_nb['0'] ; 
		 				$gh_promo = $final_price -  $price_promo;
		 				$product_table_charge_fr['prix_final'] = number_format($gh_promo, 2, '.', ' ');
		 			}else{
		 				$prix_nb =  explode('€', $prix);
		 				$product_table_charge_fr['prix_final'] = str_replace(',', '.',  $prix_nb['0']);
		 			}

					echo $product_table_rows['id']." | ".$data[$i][0][1]."<br>";
					$i+=1;
//$db->update('sous_products_table',$product_table_charge_fr,$product_table_rows['id']) ;	
					
				}



		
		}
$_SESSION['notification'] = array('type'=>'succes','msg'=>'Mise à jour du tableau effectué avec succès');
		echo '<div class="alert alert-success alert-dismissible fade in">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		<strong>Success:</strong>Mise à jour du tableau effectué avec succès.</div>';
	}
	
	
	
	
?>																				