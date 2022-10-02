<?php  include_once '../../includes/config.inc.php';
    if(!$_POST) {exit;}
	
	$fields = array(
	'password'=>array( 
	'rule'=>'/.+/',
	'message'=>'password',
	'value'=>'', 
	'required'=>false
	),

	'activate'=>array( 
	'rule'=>'/.+/',
	'message'=>'activate',
	'value'=>'', 
	'required'=>false
	),
	'firstName'=>array( 
	'rule'=>'/.+/',
	'message'=>'firstName',
	'value'=>'', 
	'required'=>false
	),
	'lastname'=>array( 
	'rule'=>'/.+/',
	'message'=>'lastname',
	'value'=>'', 
	'required'=>false
	),
	'address'=>array(
	'rule'=>'/.+/',
	'message'=>'address',
	'value'=>'',
	'required'=>false
	),
	'adressliv'=>array(
	'rule'=>'/.+/',
	'message'=>'adressliv',
	'value'=>'',
	'required'=>false
	),
  'country'=>array(
  'rule'=>'/.+/',
  'message'=>'country',
  'value'=>'',
  'required'=>false
  ),
  'ville'=>array(
  'rule'=>'/.+/',
  'message'=>'ville',
  'value'=>'',
  'required'=>false
  ),
  'cplocalite'=>array(
  'rule'=>'/.+/',
  'message'=>'cplocalite',
  'value'=>'',
  'required'=>false
  ),
	'societe'=>array(
	'rule'=>'/.+/',
	'message'=>'societe',
	'value'=>'',
	'required'=>false
	),
	'activity'=>array(
	'rule'=>'/.+/',
	'message'=>'activity',
	'value'=>'',
	'required'=>false
	),'phone'=>array(
	'rule'=>'/.+/',
	'message'=>'phone',
	'value'=>'',
	'required'=>false
	),

	'email'=>array(
	'rule'=>"/^([a-z0-9\+_\-']+)(\.[a-z0-9\+_\-']+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",
	'message'=>'email',
	'value'=>'',
	'required'=>false
	),
	'change_pass'=>array(
	'rule'=>'/.+/',
	'message'=>'',
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
		

		
        $client = $db->get_rows("SELECT clients.* FROM clients WHERE clients.email='".$fields['email']['value']."'");
		
		if(!empty($client)){
			$errors[] = "Client exist déja !!! ( verifier l'e-mail )";
		}

		
		if(empty($errors)) {
			
			$_POST['password'] = md5($fields['password']['value'].SALT);
			
			if(!$db->insert('clients',$_POST)) {
				$errors[] = "erreur";
				} else {
					$_SESSION['notification'] = array('type'=>'succes','msg'=>'Client ajouté avec succès');
					echo '<div class="alert alert-success alert-dismissible fade in">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					<strong>Success:</strong> Client ajouté avec succès.</div>';

					$new_client = $db->get_row("SELECT clients.* FROM clients WHERE clients.email='".$fields['email']['value']."'");
				 

					send_mail_to_client( $new_client['email'], $new_client['firstName'], $new_client['lastName'], $fields['password']['value']);
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
	
	/*edit*/
	if($_POST['action']=='edit') {
		
		/*	$client = $db->get_rows("SELECT client.* FROM client WHERE id<>'".$_POST['id']."' AND client.email='".$fields['email']['value']."')");
			
			if(!empty($client)){
			$errors[] = "Utilisateur exist !!! ( verifier l'e-mail ou bien username )";
			}
		*/
	
		if (isset ($_POST['change_pass']))
		{
			 
			if(isset($_POST['password'])&&isset($_POST['cpassword']) && ($_POST['password']!="") ){
				
				if($fields['password']['value']!=$fields['cpassword']['value']){
					$errors[] = "Mots de passes ne correspondent pas";
					}else{
					$_POST['password'] = md5($_POST['cpassword'].SALT);
				}
				}else{
				unset($_POST['password']);
			} 
		}else{
		unset($_POST['password']);
		}
		
	 	if(empty($errors))
		{
			if(!$db->update('clients',$_POST,$_POST['id'])) {
				echo  '<div class="list-group-item list-group-item-danger">save failed</div>';
				} else {
				echo '<div class="alert alert-success alert-dismissible fade in">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<strong>Success:</strong>Mise à jour effectué avec succès.</div>';
			}
			}else{
			$msg='<div class="list-group-item list-group-item-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Erreur:</strong><br>';
			foreach($errors as $error):
			$msg.='- '.$error.'<br>';
			endforeach;
			$msg.='</div>';
		echo $msg;
		exit;
		} 
		}



function send_mail_to_client( $email, $nom, $prenom, $password ){

    ini_set( 'display_errors', 1 );
      error_reporting( E_ALL );

      $msg = '
  <html><head><meta content="exported via StampReady" name="sr_export"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"><link href="http://fonts.googleapis.com/css?family=Montserrat:400,500,300,600,700" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"><link href="https://fonts.googleapis.com/css?family=Condiment" rel="stylesheet"><style type="text/css">

  body{ margin:0; padding:0; -webkit-text-size-adjust: none; -ms-text-size-adjust: none; background:#f5f5f5;}

  span.preheader{display: none; font-size: 1px;}

  html { width: 100%; }

  table { border-spacing: 0; border-coll apse: collapse;}

  .ReadMsgBody { width: 100%; background-color: #FFFFFF; }

  .ExternalClass { width: 100%; background-color: #FFFFFF; }

  .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalCl ass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }

  a,a:hover { text-decoration:none; color:#FFF;}

  img { display: block !important; }

  table td { border-collapse: collapse; line-height: 20px;}


  @media only screen and (max-width:640px)

  {
    body {width:auto!important;}
    table [class=main] {width:85% !important;}
    table [class=full] {width:100% !important; margin:0px auto;}
    table [class=two-left-inner] {width:90% !important; margin:0px auto;}
    td[class="two-left"] { display: block; width: 100% !important; }
    table [class=menu-icon] { display:none;}
    img[class="image-full"] { width: 100% !important; }
    table[class=menu-icon] { display:none;}

  }

  @media only screen and (max-width:479px)
  {
    body {width:auto!important;}
    table [class=main] {width:93% !important;}
    table [class=full] {width:100% !important; margin:0px auto;}
    td[class="two-left"] { display: block; width: 100% !important; }
    table [class=two-left-inner] {width:90% !important; margin:0px auto;}
    table [class=menu-icon] { display:none;}
    img[class="image-full"] { width: 100% !important; }
    table[class=menu-icon] { display:none;}

  }

  </style></head><body>                                                                 
 

  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#d2d0d0" data-bgcolor="BodyBg" data-module="24-Work 2  List 1 part" style="background-color: #d2d0d0; position: relative; opacity: 1; top: 0px; left: 0px;">
  <tbody>
<tr height="50"></tr>
  <tr>
  <td align="center" valign="top">
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="m_1592553561989818029main" style="background: #d01033;height: 10px;">
    <tbody><tr></tr>
</tbody></table>

  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
  <tbody><tr>
  <td align="center" valign="top" bgcolor="#FFFFFF">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="full" style="height: 55px;">
  <tbody><tr>
   <td width="100" align="center" valign="top" style="background: #fff;padding: 10px 0;border: 1px solid #eee;">
  <a href="https://mb-hebergement.com/demo/hydrex/"><img src="https://mb-hebergement.com/demo/hydrex/images/icon-Hydrex-150px.png" alt=""></a>
  </td>
  </tr>
  </tbody></table>
  </td>
  </tr>
  </tbody></table>
  </td>
  </tr>
  </tbody></table>

 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#848282" data-bgcolor="BodyBg" data-module="02-Browser part" style="background-color: #d2d0d0;">
  <tbody>

  <tr>
  <td align="center" valign="top">
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
  <tbody><tr>
  <td align="left" valign="top" bgcolor="#ffffff">
  <table width="600" border="0" align="left" cellpadding="0" cellspacing="0" class="two-left-inner">
  <tbody><tr>
  <td height="25" align="left" valign="top" style="line-height:25px; font-size:25px;" bgcolor="#ffffff">
  &nbsp;                  </td>
  </tr>
   
  </tr>

  <tr>
    <td align="center" valign="top" bgcolor="#ffffff" style="font-family:Open Sans, sans-serif, Verdana; font-size:20px; font-weight:normal; color:#2b2a2a;">
    <multiline>
    <span>
     
    <blockquote>
      <b>Nouveau compte</b>
    </blockquote>
   
    </span>
    </multiline>
    </td>
  </tr>

 

 <tr>
       <td align="left" valign="top" bgcolor="#ffffff" style="font-family:Open Sans, sans-serif, Verdana; font-size:15px; font-weight:normal; color:#2b2a2a;">
      <multiline>
      <span>
       
        <blockquote>
        <b>Bonjour : </b>'.$nom.' '.$prenom.'
      </blockquote>
     
      </span>
      </multiline>
      </td>
  </tr>
 

 <tr>
      <td align="left" valign="top" bgcolor="#ffffff" style="font-family:Open Sans, sans-serif, Verdana; font-size:15px; font-weight:normal; color:#2b2a2a;">
      <multiline>
      <span>
       
        <blockquote>
        <p> Votre compte Hydrex a été créé. </p>
      </blockquote>
     
      </span>
      </multiline>
      </td>
</tr>

  <tr>
       <td align="left" valign="top" bgcolor="#ffffff" style="font-family:Open Sans, sans-serif, Verdana; font-size:15px; font-weight:normal; color:#2b2a2a;">
      <multiline>
      <span>
       
        <blockquote>
        <b>Login : </b>'.$email.'
      </blockquote>
     
      </span>
      </multiline>
      </td>
  </tr>

  <tr>
       <td align="left" valign="top" bgcolor="#ffffff" style="font-family:Open Sans, sans-serif, Verdana; font-size:15px; font-weight:normal; color:#2b2a2a;">
      <multiline>
      <span>
       
        <blockquote>
        <b>Mot de passe : </b>'.$password.'
      </blockquote>
     
      </span>
      </multiline>
      </td>
  </tr>

 


  <tr>
  <td bgcolor="#ffffff" height="25" align="center" valign="top" style="line-height:25px; font-size:25px;">&nbsp;</td>
  </tr>
  </tbody></table>
  </td>
  </tr>
  </tbody></table>
  </td>
  </tr>
  </tbody></table>
</td>
</tr>
 
</tbody></table></td>
</tr>
 
</tbody></table></td>
 
 </tr>
</tbody></table></td>
</tr>
</tbody></table></td>

</tr>

</tbody></table></td>
</tr>
</tbody></table></td>
</tr>
</tbody></table>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#848282" data-bgcolor="BodyBg" data-module="43-Copyright Part" style="background-color: #d2d0d0;">
  <tbody><tr>
  <td align="center" valign="top">
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
  <tbody><tr>



  <td align="center" valign="top" bgcolor="#f0f0f0" style="background: #f0f0f0">
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left-inner">
  <tbody><tr>
  <td height="25" colspan="3" align="center" valign="top" style="line-height:25px; font-size:25px;">&nbsp;</td>
  </tr>

  <tr>
  <td width="100%" align="left" valign="top" style="font-family:Open Sans,sans-serif,Verdana;font-size: 12px;font-weight:bold;color: #676767;padding-left:20px;text-align: center;" class="two-left">
  <span style="font-weight: normal;">
  Copyright © 2020 | 
  <a href="https://mb-hebergement.com/demo/hydrex/" style="color: #676767;text-decoration: none;">hydrex@hydrex.fr</a>
  </span>
  </td>
  </tr> 
 <tr>
  <td width="100%" align="left" valign="top" style="font-family:Open Sans,sans-serif,Verdana;font-size: 12px;font-weight:bold;color: #676767;padding-left:20px;text-align: center;" class="two-left">
   <span style="font-weight: normal;color: #676767;">Email : hydrex@hydrex.fr </span>
  </td>
  </tr>
   <tr>
  <td width="100%" align="left" valign="top" style="font-family:Open Sans,sans-serif,Verdana;font-size: 12px;font-weight:bold;color: #676767;padding-left:20px;text-align: center;" class="two-left">
  <span style="font-weight: normal;">Tél :+33 04 74 89 30 88</span>
  </td>
  </tr>
    <tr>
  <td width="100%" align="left" valign="top" style="font-family:Open Sans,sans-serif,Verdana;font-size: 12px;font-weight:bold;color: #676767;padding-left:20px;text-align: center;" class="two-left">
  <span style="font-weight: normal;">Fax :+33 04 74 89 30 65 </span>
  </td>
  </tr>  
  <tr>
  <td height="25" colspan="3" align="center" valign="top" style="line-height:25px; font-size:25px;">
  &nbsp;                  </td>
  </tr>
  </tbody>
  </table>
  </td>



  
  </tr>
  </tbody></table>
  </td>
  </tr>
    <tr height="50"></tr>
  </tbody></table>
  </body></html>';


  $subject = "Votre compte Hydrex";

  $from = "ghada.charef@mbdesign-tn.com";
  $headers  = 'MIME-Version: 1.0' . "\n"; 
  $headers .= 'From: Hydrex International <'.$from.'>' . "\n"; 
  $headers .= 'Content-type: text/html; charset=utf-8' ."\n";
  $headers .='Content-Transfer-Encoding: 8bit'; 

  mail($email,$subject,$msg, $headers);

}


		?>						