<?php

header('Content-Type: application/json');
include_once '../includes/config.inc.php';


require('../includes/UploadHandler.php');

//if(!$_GET)exit;

global $id_product;
global $id_image;


$db = db_connect();


if(isset($_GET['ac']) && $_GET['ac']='remove-attach' && isset($_GET['id_image']) && is_numeric($_GET['id_image']) ){
	
	$image = $db->get_row("SELECT * FROM `image` WHERE image.id_image='".$_GET['id_image']."'");
	
	$id_image = $image['id_image'];
	
	
	
	if(is_file(ROOT.'files/'.$image['id_product'].'/'.$image['name'])){
		
		unlink(ROOT.'files/'.$image['id_product'].'/big/'.$image['name']);
			unlink(ROOT.'files/'.$image['id_product'].'/medium/'.$image['name']);
					unlink(ROOT.'files/'.$image['id_product'].'/thumbnail/'.$image['name']);
						unlink(ROOT.'files/'.$image['id_product'].'/'.$image['name']);
	
	
	if(!$db->delete2('image','id_image',$id_image)){
		$return = array('result'=>'error');
	}else{
		$return = array('result'=>'success');
		
	}
	
	}else{
		//$return = array('result'=>'error');	
	}
	
	echo json_encode($return);exit;
	
}else if(isset($_GET['id_product']) && is_numeric($_GET['id_product'])){
	
	
			
			$row = $db->get_row("SELECT * FROM `image` WHERE image.id_product='".$_GET['id_product']."'");
			
			$id_product = $_GET['id_product'];
			
			//if($_FILES && $_FILES['file']['error'] != 4) {
		
					$id_image = nextIdImg();
					$upload_handler = new UploadHandler();
					
			//	}
		
		
				
			
			 
		}
		
