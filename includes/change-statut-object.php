<?php

include_once './config.inc.php';
if(isset($_GET['object'])&& $_GET['object']!=='' &&  isset($_GET['id'])&& is_numeric($_GET['id'])){
	

	$object = $db->get_row("SELECT * FROM ".$_GET['object']." WHERE  id='".$_GET['id']."'");
	
 
	if( $_GET['object'] == 'clients'){

    if($object['status']==0){$active = 1;}else{$active = 0;}

		if(!$db->update($_GET['object'],array('status'=>$active, 'activate'=>$active),$_GET['id'])){
			echo 'error';
		}else{
			echo 'success';
			send_mail_to_client($object['email'],$object['lastName'],$object['firstName']);
		}
	}else{
    echo "stat";
    if($object['statut']==0){$active = 1;}else{$active = 0;}

		if(!$db->update($_GET['object'],array('statut'=>$active),$_GET['id'])){
			echo 'error';
		}else{
			echo 'success';
		}
	}

	
}



function send_mail_to_client( $email, $nom, $prenom){

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
  <a href="https://hydrex-international.com"><img src="https://hydrex-international.com/assets/img/icon-Hydrex-150px.png" alt=""></a>
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
      <b>Inscription validée </b>
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
        <b>Bonjour '.$nom.' '.$prenom.', </b>
      </blockquote>
     
      </span>
      </multiline>
      </td>
  </tr>
 

 <tr style="display: none">
      <td align="left" valign="top" bgcolor="#ffffff" style="font-family:Open Sans, sans-serif, Verdana; font-size:15px; font-weight:normal; color:#2b2a2a;">
      <multiline>
      <span>
       
        <blockquote>
        	<h1 style="font-size: 24px;margin: 0;color: #333;text-align: center;">Ravis de vous avoir parmi nous !</h1>

		<p style="text-align: justify;color:#333;font-weight:100;margin: 40px 20px;margin-left: 0;"">
			 Votre compte à été validé.<br/><br/> Vous pouvez composer votre propre kit à partir de votre espace client.</p>
      </blockquote>
     
      </span>
      </multiline>
      </td>
</tr>

 
  <tr>
      <td align="left" valign="top" bgcolor="#ffffff" style="font-family:Open Sans, sans-serif, Verdana; font-size:15px; font-weight:normal; color:#2b2a2a;    text-align: center;    padding: 25px;">
      <multiline>
      <span>
       
      <a href="http://hydrex-international.com/mon-espace" class="btn btn-envoie" style="background: #e30613;color: #fff;padding: 15px;text-decoration: none;" target="_blank">Se connecter</a>
     
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
  <a href="https://hydrex-international.com" style="color: #676767;text-decoration: none;">hydrex@hydrex.fr</a>
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


  $subject = "Inscription validée";

  $from = "hydrex@hydrex.fr";
  $headers  = 'MIME-Version: 1.0' . "\n"; 
  $headers .= 'From: Hydrex International <'.$from.'>' . "\n"; 
  $headers .= 'Content-type: text/html; charset=utf-8' ."\n";
  $headers .='Content-Transfer-Encoding: 8bit'; 

  mail($email,$subject,$msg, $headers);

}
?>