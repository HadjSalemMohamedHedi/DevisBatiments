<?php

function validate_user_add(){

global $fields;
global $lang; 	
global $errors;

		$fields = array(
		'username'=>array(
			'rule'=>'/.+/',
			'message'=>'',
			'value'=>'',
			'required'=>TRUE
		),
		'lastname'=>array(
			'rule'=>'/.+/',
			'message'=>'lastname',
			'value'=>'',
			'required'=>false
		),
		'firstname'=>array(
			'rule'=>'/.+/',
			'message'=>'firstname',
			'value'=>'',
			'required'=>false
		),
		'address'=>array(
			'rule'=>'/.+/',
			'message'=>'address',
			'value'=>'',
			'required'=>false
		),
		'email'=>array(
			'rule'=>"/^([a-z0-9\+_\-']+)(\.[a-z0-9\+_\-']+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",
			'message'=>'email',
			'value'=>'',
			'required'=>false
		),
		'role'=>array(
			'rule'=>'/.+/',
			'message'=>'classe',
			'value'=>'',
			'required'=>false
		),
		'password'=>array(
			'rule'=>'/.+/',
			'message'=>'pass',
			'value'=>'',
			'required'=>true
		),
		'cpassword'=>array(
			'rule'=>'/[0-9 +]/',
			'message'=>'cpass',
			'value'=>'',
			'required'=>true
		)
	);

	
	if($_POST) {

		$errors = array();
		foreach($fields as $k=>$v) {
			
			if(isset($_POST[$k])) {
				
				$required = (isset($v['required'])) ? (!empty($_POST[$k])) ? TRUE : $v['required']  : TRUE ;
				
				if(isset($v['rule']) && $required && !preg_match($v['rule'], $_POST[$k]) ) {
					
					if(isset($v['rule']) && !preg_match($v['rule'], $_POST[$k]) ) {
						
						if(isset($v['message']) && !empty($v['message'])) {
							$errors[] = $v['message'];
						}
					}
				}
		
			$fields[$k]['value'] = $_POST[$k];
			}
		}
		
		
		if($fields['password']['value']!=$fields['cpassword']['value']){
		   $errors[] = 'ADMIN_PASSWORD_NOT_MATCHED';
		}
		
		
		$db = db_connect();
		$users = $db->get_rows("SELECT users.* FROM users WHERE users.username='".$fields['username']['value']."'");
		
		if(!empty($users)){
		 $errors[] = 'ADMIN_USERNAME_EXIST';
		 $_SESSION['notification'] = array('type'=>'error','msg'=>'ADMIN_USERNAME_EXIST');
		}
		
		if(empty($errors)) {
			$db = db_connect();
			
			
			$_POST['password'] = md5($fields['cpassword']['value'].SALT);
			
			if(!$db->insert('users',$_POST)) {
				$errors[] = 'ADMIN_USERNAME_CREATE_FAILED';
				$_SESSION['notification'] = array('type'=>'error','msg'=>'ADMIN_USERNAME_CREATE_FAILED');
			} else {
				
				
				
				$_SESSION['notification'] = array('type'=>'succes','msg'=>'l\'utilisateur '.$fields['username']['value'].' a été sauvegardé avec succès');
				redirect(ROOT_URL.'gestion-compte.php');
			}
		}
	}
}

// validate user edit

function validate_user_edit(){

global $fields;
global $lang; 	
global $errors;
global $user;

	
	$fields = array(
		'username'=>array(
			'rule'=>'/.+/',
			'message'=>'',
			'value'=>'',
			'required'=>TRUE
		),
		'lastname'=>array(
			'rule'=>'/.+/',
			'message'=>'',
			'value'=>'',
			'required'=>false
		),
		'firstname'=>array(
			'rule'=>'/.+/',
			'message'=>'',
			'value'=>'',
			'required'=>false
		),
		'address'=>array(
			'rule'=>'/.+/',
			'message'=>'',
			'value'=>'',
			'required'=>false
		),
		'email'=>array(
			'rule'=>"/^([a-z0-9\+_\-']+)(\.[a-z0-9\+_\-']+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",
			'message'=>'',
			'value'=>'',
			'required'=>false
		),
		'classe'=>array(
			'rule'=>'/.+/',
			'message'=>'',
			'value'=>'',
			'required'=>false
		),
		'dpassword'=>array(
			'rule'=>'/.+/',
			'message'=>'',
			'value'=>'',
			'required'=>false
		),
		'cpassword'=>array(
			'rule'=>'/[0-9 +]/',
			'message'=>'',
			'value'=>'',
			'required'=>false
		)
	);

	
	if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
		$_SESSION['notification'] = array('type'=>'error','msg'=>'ADMIN_INVALID_ID');
		redirect(ROOT_URL.'gestion-compte.php ');
	}

	
	$db = db_connect();
	$user = $db->get_row("SELECT users.* FROM users WHERE users.id=".$db->escape($_GET['id']));
	if(empty($user)) {
		$_SESSION['notification'] = array('type'=>'error','msg'=>'ADMIN_INVALID_ID');
		redirect(ROOT_URL.'gestion-compte.php');
	}


	if($_POST) {
		$errors = array();
		foreach($fields as $k=>$v) {

			if(isset($_POST[$k])) {

				$required = (isset($v['required'])) ? (!empty($_POST[$k])) ? TRUE : $v['required']  : TRUE ;

				if(isset($v['rule']) && $required && !preg_match($v['rule'], $_POST[$k]) ) {

					if(isset($v['rule']) && !preg_match($v['rule'], $_POST[$k]) ) {

						if(isset($v['message']) && !empty($v['message'])) {
							$errors[] = $v['message'];
						}
					}
				}
			

			$fields[$k]['value'] = $_POST[$k];
			}
		}
		
		if($fields['dpassword']['value']!=$fields['cpassword']['value']){
		   $errors[] = 'ADMIN_PASSWORD_NOT_MATCHED';
		}
		

		
		if(empty($errors)) {
			// password encryption
			
			if(!empty($_POST['cpassword'])){
				$_POST['password'] = md5($fields['cpassword']['value'].SALT);
			}
			
			
			
				
			
			
			if(!$db->update('users',$_POST,$_GET['id'])) {
				$errors[] = 'ADMIN_USERNAME_EDIT_FAILED';
			} else {
				$_SESSION['notification'] = array('type'=>'succes','msg'=>'l\'utilisateur '.$fields['username']['value'].' a été sauvegardé avec succès');
				redirect(ROOT_URL.'gestion-compte.php');
			}
		}
	} else {
	
		foreach($fields as $k=>$v) {
			if(isset($user[$k])) {
				$fields[$k]['value'] = $user[$k];
			}
		}
	}

}
?>