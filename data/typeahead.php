<?php 
include_once '../includes/config.inc.php';
/**
 *	Example for custom autosuggestion templating
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

$db = db_connect();
$return = array();

if(isset($_REQUEST['q']) && strlen($_REQUEST['q']) > 0){
	
	$query = $_REQUEST['q'];

$clients = $db->get_rows("SELECT * FROM client_unique WHERE `email` LIKE '%$query%' AND client_unique.email!='' AND client_unique.active='1' AND client_unique.deleted='0'");
}
$client = array();
foreach($clients as $k=>$v){
	
	if(is_file(ROOT_WEB.'admin/upload_client_unique/'.$v['id_client'].'/thumbnail/'.$v['photo'])){
		
		$cover = ROOT_WEB_URL.'admin/upload_client_unique/'.$v['id_client'].'/thumbnail/'.$v['photo'];
		
	}else{
	
		$cover = ROOT_WEB_URL.'admin/upload_client_unique/empty-client.png';
	}
	
	$client['id_client']= $v['id_client'];
	$client['value']= $v['email'];
	$client['name']= $v['firstname'].' '.$v['lastname'];
	
	$client['firstname'] = $v['firstname'];
	$client['lastname'] = $v['lastname'];
	$client['cover']= $cover;
	$client['address']= $v['address'];
	$client['city']= $v['city'];
	$client['postcode']= $v['postcode'];
	$client['phone1']= $v['phone1'];
	$client['phone_mobile']= $v['phone_mobile'];
	
	array_push($return,$client);
	
}

shuffle($return);

echo json_encode($return);
exit;

	
	
	shuffle($oscar_movies);
	
	if(isset($_REQUEST['q']) && strlen($_REQUEST['q']) > 6)
		$oscar_movies = array();
	
	echo json_encode($oscar_movies);
	
	
	