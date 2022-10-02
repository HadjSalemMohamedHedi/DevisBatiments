<?php  include_once './config.inc.php';
    if(!$_POST) {exit;}
	
	$fields = array(
		'username'=>array(
			'rule'=>'/.+/',
			'message'=>'',
			'value'=>' username est obligatoire',
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
		'postcode'=>array(
			'rule'=>'/.+/',
			'message'=>'address',
			'value'=>'',
			'required'=>false
		),'phone'=>array(
			'rule'=>'/.+/',
			'message'=>'address',
			'value'=>'',
			'required'=>false
		),'id_country'=>array(
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
		'classe'=>array(
			'rule'=>'/.+/',
			'message'=>'classe',
			'value'=>'',
			'required'=>false
		),
		'password'=>array(
			'rule'=>'/.+/',
			'message'=>'pass',
			'value'=>'',
			'required'=>false
		),
		'cpassword'=>array(
			'rule'=>'/[0-9 +]/',
			'message'=>'cpass',
			'value'=>'',
			'required'=>false
		)
	);
	
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
	
	
	
	
	/*ajout*/
	if($_POST['action']=='add' ){
		
		if($fields['password']['value']!=$fields['cpassword']['value']){
		   $errors[] = "Mots de passes ne correspondent pas";
		}
        $users = $db->get_rows("SELECT users.* FROM users WHERE users.username='".$fields['username']['value']."' OR users.email='".$fields['email']['value']."'");
		
		if(!empty($users)){
		 $errors[] = "Utilisateur exist !!! ( verifier l'e-mail ou bien username )";
		}
		
		
		if(empty($errors)) {
		
			
			if($_SESSION['User']['classe']=='2')$_POST['id_contributor']=$_SESSION['User']['id'];
			if($_SESSION['User']['classe']=='4'):
			   $_POST['id_responsible']=$_SESSION['User']['id'];
			   $_POST['id_contributor']=getIDContributorFromCom($_SESSION['User']['id']);
			endif;
			$_POST['password'] = md5($fields['cpassword']['value'].SALT);
			
			if(!$db->insert('users',$_POST)) {
				$errors[] = "erreur";
			} else {
				$_SESSION['notification'] = array('type'=>'succes','msg'=>'Employé ajouté avec succès');
			echo '<div class="alert alert-success alert-dismissible fade in">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Success:</strong> Employé ajouté avec succès.</div>';
			}
		/*verif mail*/
	
		
		
		}else{
			$msg='<div class="list-group-item list-group-item-danger">   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Erreur:</strong><br>';
			foreach($errors as $error):
			$msg.='- '.$error.'<br>';
			endforeach;
			$msg.='</div>';
			echo $msg;
			exit;	
		}
		
	}
	
	/*edit*/
	if($_POST['action']=='edit') {
		
	    $users = $db->get_rows("SELECT users.* FROM users WHERE id<>'".$_POST['id']."' AND (users.username='".$fields['username']['value']."' OR users.email='".$fields['email']['value']."')");
		
		if(!empty($users)){
		 $errors[] = "Utilisateur exist !!! ( verifier l'e-mail ou bien username )";
		}
		
		if(isset($_POST['password'])&&isset($_POST['cpassword']) && ($_POST['password']!="") ){
				$_POST['password'] = md5($_POST['cpassword'].SALT);
			}else{
				unset($_POST['password']);
				
				}
	
	if(empty($errors)) {
		if(!$db->update('users',$_POST,$_POST['id'])) {
			echo  '<div class="list-group-item list-group-item-danger">save failed</div>';
			} else {
			

			/*****************************************/
			echo '<div class="alert alert-success alert-dismissible fade in">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<strong>Success:</strong>Mise à jour effectué avec succès.</div>';
	 	}
	 }else{
			$msg='<div class="list-group-item list-group-item-danger">   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Erreur:</strong><br>';
			foreach($errors as $error):
			$msg.='- '.$error.'<br>';
			endforeach;
			$msg.='</div>';
			echo $msg;
			exit;	
		}	
	}
?>