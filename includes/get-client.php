<?php
	
	include_once './config.inc.php';
	
	
	
	
	
	
	$json = array();
	
 	//if (isset($_GET['id_client']))
	{
		$client = $db->get_row('SELECT * FROM client where id ='.$_GET['id_client']);
		
		
	 	$json['username'] = $client['username'];
		/*$json['password'] = $client['password'];*/
		$json['lastname'] = $client['lastname'];
	 	$json['firstname'] = $client['firstname'];
	 	$json['statut'] = $client['statut'];
	 	$json['adresse'] = $client['adresse'];
	 	$json['zip_code'] = $client['zip_code'];
	 	$json['zip_code'] = $client['zip_code'];
	 	$json['city'] = $client['city'];
	 	$json['phone'] = $client['phone'];
	 	$json['mobile'] = $client['mobile'];
	 	$json['email'] = $client['email'];
	 	$json['id_country'] = $client['id_country'];
	 	$json['date_birth'] = $client['date_birth'];
		
		echo json_encode($json);
	} 
	
?>