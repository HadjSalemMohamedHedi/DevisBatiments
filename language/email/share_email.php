<?php include_once '../includes/config.inc.php';

$_POST['id_email'] = '3';

$_POST['id_client'] = '1';
$_POST['comment'] = '';

$company = $db->get_row("SELECT * FROM company WHERE company.id_company='1'");

if(is_file(ROOT_WEB."admin/upload_company/".$company['id_company']."/medium/".$company['logo'])){
	
	$logo = ROOT_WEB_URL."admin/upload_company/".$company['id_company']."/medium/".$company['logo'];
}else{
	$logo = ROOT_WEB_URL."admin/upload_company/cabinet.png";
}

$email = $db->get_row("SELECT email.* FROM email WHERE email.id_email='".$db->escape($_POST['id_email'])."'");
	
	$client = $db->get_row("SELECT * FROM client WHERE client.id_client='".$db->escape($_POST['id_client'])."'");
	
	$documents = $db->get_rows("SELECT * FROM document WHERE id_email='".$db->escape($_POST['id_email'])."'");
	
	$SAMAGROUP = $db->get_row("SELECT SAMAGROUP.* FROM SAMAGROUP WHERE SAMAGROUP.id='1'");
	
	
	$files = "";
	 $i=0;
	 $d = '';
		foreach($documents as $k=>$v):
		 	$i++;
            $files .='<tr><th scope="row">'.$i.'</th><td>'.$v['file'].'</td>';
          	$files .='<td>'.human_filesize(filesize(ROOT.$v['path'])).'</td>';
          	$files .='<td><a href="'.ROOT_URL.$v['path'].'" target="_blank"><img src="'.ROOT_URL.'assets/images/icon4.png" /></a></td></tr>';
			if($i>1){$d.=',';}$d.=base64_encode($v['path']);
            endforeach;
	
$time = time();
				$hash = md5('bc8b3b8f729c633fe4131a09e60503ec'.$time);
	
				$lien = ROOT_URL."file.php?d=".$d."&t=".$time."&h=".$hash."&id_lawyer=".$_SESSION['User']['id_avocat']."&id_company=".$_SESSION['User']['id_company'];
				
				$link = '<img src="'.ROOT_URL.'assets/images/icon4.png" style="vertical-align:middle !important;">&nbsp;<a href="'.$lien.'" style="color:#ff7a0d !important; font-weight:bold;top:-10px; ">Télécharger</a>';


$a='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<meta name="format-detection" content="telephone=no" />
<title>SAMAGROUP</title>
<style type="text/css">

	a{
		color:#ff7a0d !important;
	}
	td{border-collapse:collapse;}
	
	.date							{color:#eeeeee;	font-family:Arial, Tahoma, Verdana, sans-serif;     			 font-size:13px;  font-weight:lighter;padding:0; margin:0; text-align:right; 	 line-height:150%;	letter-spacing:0; }
	.iphoneAvoidAutoLinkHackDate2	{color:#eeeeee; text-decoration: none; pointer-events: none;}

	.menuTD						{color:#6e777e; font-family:Arial, Tahoma, Verdana, sans-serif;     			 font-size:13px;  font-weight:bold;  padding:0; margin:0; text-align:right;  line-height:150%;	letter-spacing:0; }
	.menuTDLink					{color:#6e777e;  text-decoration:none; outline:none;}	
	
	
	.announcementTextTD			{color:#ff7a0d; 	font-family:Arial, Tahoma, Verdana, sans-serif;     			 font-size:17px;  font-weight:bold;   padding:0; margin:0; text-align:left;   line-height:130%;	letter-spacing:0;}
	.announcementTextTDLink		{color:#ff7a0d !important;  text-decoration:none; outline:none;}	
	
	.introTextTD						{color:#6e777e; font-family:Arial, Tahoma, Verdana, sans-serif;     			font-size:13px;  font-weight:lighter; padding:0; margin:0; text-align:left; line-height:165%; letter-spacing:0;}
	.introTextTDLink					{color:#ff7a0d;  text-decoration:none; outline:none;  font-weight:bold;}	
	.introTextHeaderTD				{color:#43494e; font-family:Arial, Tahoma, Verdana, sans-serif;     			font-size:20px;  font-weight:lighter; padding:0; margin:0; text-align:left; line-height:160%; letter-spacing:0;}
	
	.sectionsSeperatorTextTD			{color:#ff7a0d;	 font-family:Arial, Tahoma, Verdana, sans-serif;     		 font-size:13px;  font-weight:bold;   padding:0; margin:0; text-align:left; line-height:160%; letter-spacing:0; }
	.sectionsSeperatorTextTDLink		{color:#ffffff;  text-decoration:none; outline:none;  font-weight:bold;}	
	
	
	.sectionsHeaderTD				{color:#43494e; font-family:Arial, Tahoma, Verdana, sans-serif;      		font-size:20px; font-weight:lighter;   	padding:0; margin:0; text-align:left;  line-height:140%;   letter-spacing:0; }
	.sectionsHeaderTDLink			{color:#ff7a0d;  text-decoration:none; outline:none;}
	.sectionRegularInfoTextTD		{color:#6e777e; font-family:Arial, Tahoma, Verdana, sans-serif;  			font-size:13px;  font-weight:lighter;   padding:0; margin:0; text-align:left;       line-height:165%;  letter-spacing:0;}
	.sectionRegularInfoTextTDLink	{color:#ff7a0d;   text-decoration:none; outline:none;   font-weight:bold;  }	
	.headerAndTextSeperatorLine 	{border-bottom-style:solid; border-bottom-color:#e5e5e5; border-bottom-width:1px; font-size:0; line-height:0;}
	.moduleSeperatorLine			{border-top-style:solid;       border-top-color:#e5e5e5;      border-top-width:1px;}
	
	.buttonsAndImagesLink			{color:#bbbbbb; text-decoration:none; outline:none;}	
	.table280Button,	
	.table280Squareimage, 
	.table280Rectangleimage3, 
	.table280Rectangleimage2, 
	.table280Rectangleimage,
	.pictureAlternativeTextTD			{color:#bbbbbb; font-family:sans-serif;  font-size:10px; 	padding:0; margin:0;}
		
	.finalWords						{color:#eeeeee; font-family:Arial, Tahoma, Verdana, sans-serif;      		font-size:18px; font-weight:lighter;   	padding:0; margin:0; text-align:center;  line-height:150%;   letter-spacing:0;}	
	.iphoneAvoidAutoLinkHackDate	{color:#ff0000; text-decoration: none; pointer-events: none;}
	.adressOrAnyOtherTD			{color:#ffffff; font-family:Arial, Tahoma, Verdana, sans-serif; 				font-size:13px;  font-weight:lighter; 	  padding:0; margin:0; text-align:center; line-height:200%;  letter-spacing:0;}
	.adressOrAnyOtherTDLink			{color:#ffffff;  text-decoration:none; outline:none;}
	
	.mailingOptionsTD				{color:#ffffff; font-family:Arial, Tahoma, Verdana, sans-serif; 				font-size:13px;  font-weight:lighter; 	  padding:0; margin:0; text-align:center; line-height:200%;  letter-spacing:0;}
	.mailingOptionsTDLink			{color:#ffffff;  text-decoration:none;  outline:none;	   font-weight:bold; }
	
	.copyrightCompanyTD			{color:#ffffff; font-family:Arial, Tahoma, Verdana, sans-serif; 			font-size:13px;  font-weight:lighter; 	  padding:0; margin:0; text-align:center; line-height:200%;  letter-spacing:0;}	
	.copyrightCompanyTDLink		{color:#ff7a0d;  text-decoration:none;  outline:none;	   font-weight:bold; }
	
	.ReadMsgBody{width: 100%;}
	.ExternalClass{width: 100%;}
	body{-webkit-text-size-adjust:100%;  -ms-text-size-adjust:100%;  -webkit-font-smoothing:antialiased; margin:0 !important;   padding:0 !important;   width:100% !important; }
	
<!---->		
.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 20px;
}
.table > thead > tr > th,
.table > tbody > tr > th,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > tbody > tr > td,
.table > tfoot > tr > td {
  padding: 8px;
  line-height: 1.42857143;
  vertical-align: top;
  border-top: 1px solid #ddd !important;
}
.table > thead > tr > th {
  vertical-align: bottom !important;
  border-bottom: 2px solid #ddd !important;
}
.table > caption + thead > tr:first-child > th,
.table > colgroup + thead > tr:first-child > th,
.table > thead:first-child > tr:first-child > th,
.table > caption + thead > tr:first-child > td,
.table > colgroup + thead > tr:first-child > td,
.table > thead:first-child > tr:first-child > td {
  border-top: 0 !important;
}
.table > tbody + tbody {
  border-top: 2px solid #ddd !important;
}
.table .table {
  background-color: #fff;
}
.table-condensed > thead > tr > th,
.table-condensed > tbody > tr > th,
.table-condensed > tfoot > tr > th,
.table-condensed > thead > tr > td,
.table-condensed > tbody > tr > td,
.table-condensed > tfoot > tr > td {
  padding: 5px !important;
}
.table-bordered {
  border: 1px solid #ddd !important;
}
.table-bordered > thead > tr > th,
.table-bordered > tbody > tr > th,
.table-bordered > tfoot > tr > th,
.table-bordered > thead > tr > td,
.table-bordered > tbody > tr > td,
.table-bordered > tfoot > tr > td {
  border: 1px solid #ddd !important;
}
.table-bordered > thead > tr > th,
.table-bordered > thead > tr > td {
  border-bottom-width: 2px !important;
}
.table-striped > tbody > tr:nth-child(odd) {
  background-color: #f9f9f9 !important;
}
.table-hover > tbody > tr:hover {
  background-color: #f5f5f5 !important;
}
table col[class*="col-"] {
  position: static;
  display: table-column;
  float: none;
}
table td[class*="col-"],
table th[class*="col-"] {
  position: static;
  display: table-cell;
  float: none;
}
.table > thead > tr > td.active,
.table > tbody > tr > td.active,
.table > tfoot > tr > td.active,
.table > thead > tr > th.active,
.table > tbody > tr > th.active,
.table > tfoot > tr > th.active,
.table > thead > tr.active > td,
.table > tbody > tr.active > td,
.table > tfoot > tr.active > td,
.table > thead > tr.active > th,
.table > tbody > tr.active > th,
.table > tfoot > tr.active > th {
  background-color: #f5f5f5;
}
.table-hover > tbody > tr > td.active:hover,
.table-hover > tbody > tr > th.active:hover,
.table-hover > tbody > tr.active:hover > td,
.table-hover > tbody > tr:hover > .active,
.table-hover > tbody > tr.active:hover > th {
  background-color: #e8e8e8;
}
.table > thead > tr > td.success,
.table > tbody > tr > td.success,
.table > tfoot > tr > td.success,
.table > thead > tr > th.success,
.table > tbody > tr > th.success,
.table > tfoot > tr > th.success,
.table > thead > tr.success > td,
.table > tbody > tr.success > td,
.table > tfoot > tr.success > td,
.table > thead > tr.success > th,
.table > tbody > tr.success > th,
.table > tfoot > tr.success > th {
  background-color: #dff0d8;
}
.table-hover > tbody > tr > td.success:hover,
.table-hover > tbody > tr > th.success:hover,
.table-hover > tbody > tr.success:hover > td,
.table-hover > tbody > tr:hover > .success,
.table-hover > tbody > tr.success:hover > th {
  background-color: #d0e9c6 !important;
}
.table > thead > tr > td.info,
.table > tbody > tr > td.info,
.table > tfoot > tr > td.info,
.table > thead > tr > th.info,
.table > tbody > tr > th.info,
.table > tfoot > tr > th.info,
.table > thead > tr.info > td,
.table > tbody > tr.info > td,
.table > tfoot > tr.info > td,
.table > thead > tr.info > th,
.table > tbody > tr.info > th,
.table > tfoot > tr.info > th {
  background-color: #d9edf7 !important;
}
.table-hover > tbody > tr > td.info:hover,
.table-hover > tbody > tr > th.info:hover,
.table-hover > tbody > tr.info:hover > td,
.table-hover > tbody > tr:hover > .info,
.table-hover > tbody > tr.info:hover > th {
  background-color: #c4e3f3 !important;
}
.table > thead > tr > td.warning,
.table > tbody > tr > td.warning,
.table > tfoot > tr > td.warning,
.table > thead > tr > th.warning,

.table > tbody > tr > th.warning,
.table > tfoot > tr > th.warning,
.table > thead > tr.warning > td,
.table > tbody > tr.warning > td,
.table > tfoot > tr.warning > td,
.table > thead > tr.warning > th,
.table > tbody > tr.warning > th,
.table > tfoot > tr.warning > th {
  background-color: #fcf8e3 !important;
}
.table-hover > tbody > tr > td.warning:hover,
.table-hover > tbody > tr > th.warning:hover,
.table-hover > tbody > tr.warning:hover > td,
.table-hover > tbody > tr:hover > .warning,
.table-hover > tbody > tr.warning:hover > th {
  background-color: #faf2cc !important;
}
.table > thead > tr > td.danger,
.table > tbody > tr > td.danger,
.table > tfoot > tr > td.danger,
.table > thead > tr > th.danger,
.table > tbody > tr > th.danger,
.table > tfoot > tr > th.danger,
.table > thead > tr.danger > td,
.table > tbody > tr.danger > td,
.table > tfoot > tr.danger > td,
.table > thead > tr.danger > th,
.table > tbody > tr.danger > th,
.table > tfoot > tr.danger > th {
  background-color: #f2dede !important;
}
.table-hover > tbody > tr > td.danger:hover,
.table-hover > tbody > tr > th.danger:hover,
.table-hover > tbody > tr.danger:hover > td,
.table-hover > tbody > tr:hover > .danger,
.table-hover > tbody > tr.danger:hover > th {
  background-color: #ebcccc!important;
}
.table-responsive {
  min-height: .01%;
  overflow-x: auto;
}

<!---->
@media only screen and (max-width: 599px) 
		   {
		body{min-width:100% !important;}  
		
		table[class=table600LogoAndMenuContainer]	{width:420px !important;}
		table[class=table600Logo]  					{width:420px !important; border-bottom-style:solid !important; border-bottom-color:#e5e5e5 !important; border-bottom-width:1px !important;}
		table[class=table600Logo] img 				{margin:0 auto 0 auto !important;}
		table[class=table600Menu]					{width:420px !important;}
		table[class=table600Menu] td					{height:20px !important;}
		table[class=table600Menu] .menuTD			{text-align:center !important; }
		
		table[class=table600] 						{width:420px !important;}
		table[class=table600AnnouncementText] 		{width:420px !important;}
		table[class=tableTextDateSection]			{width:420px !important;}
		td[class=logoMargin]							{height:8px !important;}
		td[class=logoMargin2]						{height:6px !important;}
		
		table[class=image600] img 					{width:420px !important; height:auto !important;}
		
		table[class=table280]						{width:420px !important;}
		td[class=table280Button] img					{margin:0 auto 0 auto !important;}
		td[class=table280Squareimage] img			{width:280px !important; height:auto !important; margin:30px auto 0 auto !important;}
		td[class=table280Rectangleimage] img		{width:280px !important; height:auto !important; margin:0 auto 0 auto !important;}
		td[class=table280Rectangleimage2] img		{width:280px !important; height:auto !important; margin:35px auto 0 auto !important;}
		td[class=table280Rectangleimage3] img		{width:280px !important; height:auto !important; margin:0 auto 15px auto !important;}
		
		table[class=table280Withicon]				{width:420px !important;}
		table[class=table280Withicon] .sectionsHeaderTD{width:355px !important; text-align:left !important; font-size:20px !important;}
		
		table[class=table280Withicon2]				{width:420px !important; margin:35px auto 0 auto !important;}
		table[class=table280Withicon2] .sectionsHeaderTD{width:355px !important; text-align:left !important; font-size:20px !important;}
		
		td[class=announcementTextTD]				{text-align:center !important; font-weight:bold !important; font-size:17px !important;}
		td[class=introTextTD]						{text-align:center !important; font-size:13px !important;}
		td[class=introTextHeaderTD]					{text-align:center !important; font-size:20px !important;}
		td[class=sectionsSeperatorTextTD]			{text-align:center !important; font-weight:bold !important;}
		td[class=date]								{text-align:center !important;}
		
		td[class=sectionsHeaderTD] 					{font-size:20px !important; text-align:center !important;}
		td[class=sectionRegularInfoTextTD] 			{font-size:13px !important; text-align:left !important;}
		
		td[class=finalWords] 							{font-size:18px !important; text-align:center !important; }
		
		table[class=eraseForMobile] 					{width:0 !important; display:none !important;}
		table[class=eraseForMobile2] 				{height:0 !important; width:0 !important; display:none !important;}
		}
		


@media only screen and (max-width: 479px) 
		   {
		body{min-width:100% !important;} 
		
		table[class=table600LogoAndMenuContainer]	{width:280px !important;}
		table[class=table600Logo]  					{width:280px !important; border-bottom-style:solid !important; border-bottom-color:#e5e5e5 !important; border-bottom-width:1px !important;}
		table[class=table600Logo] img 				{margin:0 auto 0 auto !important;}
		table[class=table600Menu]					{width:280px !important;}
		table[class=table600Menu] td					{height:20px !important;}
		table[class=table600Menu] .menuTD			{text-align:center !important;}
		
		table[class=table600] 						{width:280px !important;}
		table[class=table600AnnouncementText] 		{width:280px !important;}
		table[class=tableTextDateSection] 			{width:280px !important;}
		td[class=logoMargin]							{height:8px !important;}
		td[class=logoMargin2]						{height:6px !important;}
		
		table[class=image600] img 					{width:280px !important; height:auto !important;}
		
		table[class=table280]						{width:280px !important;}
		td[class=table280Button] img					{margin:0 auto 0 auto !important;}
		td[class=table280Squareimage] img			{width:280px !important; height:auto !important; margin:30px auto 0 auto !important;}
		td[class=table280Rectangleimage] img		{width:280px !important; height:auto !important; margin:0 auto 0 auto !important;}
		td[class=table280Rectangleimage2] img		{width:280px !important; height:auto !important; margin:35px auto 0 auto !important;}
		td[class=table280Rectangleimage3] img		{width:280px !important; height:auto !important; margin:0 auto 15px auto !important;}
		
		table[class=table280Withicon]				{width:280px !important;}
		table[class=table280Withicon] .sectionsHeaderTD{width:215px !important; text-align:left !important; font-size:18px !important;}
		
		table[class=table280Withicon2]				{width:280px !important; margin:35px auto 0 auto !important;}
		table[class=table280Withicon2] .sectionsHeaderTD{width:215px !important; text-align:left !important; font-size:18px !important;}
		
		td[class=announcementTextTD]				{text-align:center !important; font-weight:bold !important; font-size:17px !important;}
		td[class=introTextTD]						{text-align:center !important; font-size:14px !important;}
		td[class=introTextHeaderTD]					{text-align:center !important; font-size:18px !important;}
		td[class=sectionsSeperatorTextTD]			{text-align:center !important; font-weight:bold !important;}
		td[class=date]								{text-align:center !important;}
		
		td[class=sectionsHeaderTD] 					{font-size:18px !important; text-align:center !important; }
		td[class=sectionRegularInfoTextTD] 			{font-size:14px !important;}
		
		td[class=finalWords] 							{font-size:18px !important; text-align:center !important; }
		
		table[class=eraseForMobile] 					{width:0; display:none !important;}
		table[class=eraseForMobile2] 				{height:0 !important; width:0 !important; display:none !important;}
		   }


</style>
</head>
<body style="background-color:#f4f4f4; margin:0; padding:0;">
<center>
     
      <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff">
		<tr bgcolor="#ffffff">
			<td valign="top" align="center" bgcolor="#ffffff">  
                        <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="table600LogoAndMenuContainer">
                        	<tr bgcolor="#ffffff">
                                    <td valign="top" bgcolor="#ffffff"> 
                                    	<table width="200" align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="table600Logo">
                                                <tr bgcolor="#ffffff">
                                                	
                                                  <td valign="middle" align="left" bgcolor="#ffffff" class="pictureAlternativeTextTD"><a href="#" target="_blank" class="buttonsAndImagesLink"><img src="'.$logo.'" style="display:block;" alt="IMAGE HERE" border="0" align="top" hspace="0" vspace="0"/></a></td>
                                                	
                                                </tr>
							</table></td>
                              </tr>
				</table>
            	</td>
		</tr>
	</table>  	
      <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e" style="color:#ff7a0d !important;">
		<tr bgcolor="#43494e">
			<td valign="top" align="center" bgcolor="#43494e">
                        <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e" class="table600">
 					<tr bgcolor="#43494e">
						<td valign="top" align="center" height="15" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>                                         	
					<tr bgcolor="#43494e">
						<td valign="top" bgcolor="#43494e">
							<table width="300" align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e" class="table600AnnouncementText" style="color:#ff7a0d !important;">
								<tr bgcolor="#43494e">
									<td valign="top" align="center" height="0" bgcolor="#43494e" style="font-size:0; line-height:0;" class="logoMargin2">&nbsp;</td>
								</tr>
								<tr bgcolor="#43494e">
                                                																	
									<td valign="middle" align="center" height="20" bgcolor="#43494e" style="display:none !important;" class="announcementTextTD">Date:</td>
									
                                                </tr>
								<tr bgcolor="#43494e">
									<td valign="top" align="center" height="0" bgcolor="#43494e" style="font-size:0; line-height:0;" class="logoMargin">&nbsp;</td>
								</tr>
							</table>
							<table width="282" align="right" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e" class="tableTextDateSection" style="color:#ff7a0d !important;">
								<tr bgcolor="#43494e">
                                                																		
									<td valign="middle" align="center" height="20" bgcolor="#43494e" class="date" style="color:#ff7a0d !important; font-weight:bold;">'.customdate($email['date'],$lang_default['id_lang'],false,true).'</td>
									
                                                </tr>
								<tr bgcolor="#43494e">
									<td valign="top" align="center" height="0" bgcolor="#43494e" style="font-size:0; line-height:0;" class="logoMargin2">&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr bgcolor="#43494e">
						<td valign="top" align="center" height="15" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
				</table>      
			</td>
		</tr>
	</table>
      
      
 <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#f4f4f4" class="moduleSeperatorLine">
		<tr valign="top">
			<td valign="top" align="center" bgcolor="#f4f4f4">                 



                        <table width="280" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#f4f4f4" class="eraseForMobile2">
                        	<tr>
                              	<td valign="middle" height="10" align="center" bgcolor="#f4f4f4" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
				</table>
                        
                       
                        <table width="600" align="center" cellpadding="0" cellspacing="0" bgcolor="#f4f4f4" border="0" class="table600">
                        	<tr>
                              	
                                    <td style="text-align:left;" valign="middle" align="center" height="10" bgcolor="#f4f4f4" class="sectionsHeaderTD">Bonjour,<br />
Maître '.$_SESSION['User']['firstname'].' '.$_SESSION['User']['lastname'].' vous a partagé l\'email suivant:</td>
                                    
                          </tr>
                          <tr>
                              	
                                    <td style="text-align:left;" valign="middle" align="center" height="10" bgcolor="#f4f4f4" class="sectionsHeaderTD">'.$_POST['comment'].'</td>
                                    
                          </tr>
                          
                          <tr>
                              	
                                    <td style="text-align:left;" valign="middle" align="center" height="10" bgcolor="#f4f4f4" class="sectionsHeaderTD"><h3>Contenu de l\'email:</h3></td>
                                    
                          </tr>
                          
                        	<tr>
                              	
                                    <td style="text-align:left;" valign="middle" align="center" height="10" bgcolor="#f4f4f4" class="sectionsHeaderTD">'.$email['subject'].'</td>
                                    
                          </tr>
                        </table>
                        
              <table width="600" align="center" cellpadding="0" cellspacing="0" bgcolor="#f4f4f4" border="0" class="table600">
                        	<tr>			
                              																																															
                                    <td style="text-align:left;" valign="middle" align="center" bgcolor="#f4f4f4" height="10" class="sectionRegularInfoTextTD">'.$email['message'].'</td>
                              	
                </tr>
              </table>
                        <!--================== End of the section ================-->
                        <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#f4f4f4" class="table600">
                        	<tr>
                              	<td valign="middle" height="30" align="center" bgcolor="#f4f4f4" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
				</table>
                        <table width="280" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#f4f4f4" class="eraseForMobile2">
                        	<tr>
                              	<td valign="middle" height="10" align="center" bgcolor="#f4f4f4" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
				</table>
          </td>
		</tr>
  </table>
    
    
    <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e" style="color:#ff7a0d !important;">
		<tr bgcolor="#43494e">
			<td valign="top" align="center" bgcolor="#43494e">
                        <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e" class="table600">
 					<tr bgcolor="#43494e">
						<td valign="top" align="center" height="15" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>                                         	
					<tr bgcolor="#43494e">
						<td valign="top" bgcolor="#43494e">
							<table width="300" align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e" class="table600AnnouncementText" style="color:#ff7a0d !important;">
								<tr bgcolor="#43494e">
									<td valign="top" align="center" height="0" bgcolor="#43494e" style="font-size:0; line-height:0;" class="logoMargin2">&nbsp;</td>
								</tr>
								<tr bgcolor="#43494e">
                                                																	
									<td valign="middle" align="center" height="20" bgcolor="#43494e"  class="announcementTextTD" style="color:#ff7a0d !important; font-weight:bold; text-align:left !important;">Pièces jointes</td>
									
                                                </tr>
								<tr bgcolor="#43494e">
									<td valign="top" align="center" height="0" bgcolor="#43494e" style="font-size:0; line-height:0;" class="logoMargin">&nbsp;</td>
								</tr>
							</table>
							<table width="282" align="right" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e" class="tableTextDateSection" style="color:#ff7a0d !important;">
								<tr bgcolor="#43494e">
                                                																		
									<td valign="middle" align="center" height="20" bgcolor="#43494e" class="date" >'.$link.'</td>
									
                                                </tr>
								<tr bgcolor="#43494e">
									<td valign="top" align="center" height="0" bgcolor="#43494e" style="font-size:0; line-height:0;" class="logoMargin2">&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr bgcolor="#43494e">
						<td valign="top" align="center" height="15" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
				</table>      
			</td>
		</tr>
	</table>
      
    
    
    
   	
      
      
  <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="moduleSeperatorLine">
		<tr>
			<td valign="top" align="center" bgcolor="#ffffff"> 
                  	<table width="280" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="eraseForMobile2">
                        	<tr>
                              	<td valign="middle" height="10" align="center" bgcolor="#ffffff" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
				</table>
				<table width="600" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="table600">
					<tr>
						<td valign="top" align="center" height="20" bgcolor="#ffffff" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
                              <tr>			
                              																																													
                                    <td valign="middle" align="center" bgcolor="#ffffff" height="10" class="introTextTD">
                                    
                                    <table class="table table-hover" style="width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th style="text-align:left;">Fichier</th>
                                                                                <th style="text-align:left;">Taille</th>
                                                                                <th><!--<i class="fa fa-cloud-download icon-sm"></i>--></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>'.$files.'</tbody>
                                      </table>
                                    
                                    
                                    </td>
                              	
                              </tr>
                              
					<tr>
						<td valign="top" align="center" height="20" bgcolor="#ffffff" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
				</table>
                        <table width="280" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="eraseForMobile2">
                        	<tr>
                              	<td valign="middle" height="10" align="center" bgcolor="#ffffff" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
  </table>
  <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e">
		<tr>
			<td valign="top" align="center" bgcolor="#43494e"> 
				<table width="600" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e" class="table600" style="color:#ff7a0d !important;">
					<tr>
						<td valign="top" align="center" height="15" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
					
					<tr>
						<td valign="top" align="center" height="15" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
    
    <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="moduleSeperatorLine">
		<tr>
			<td valign="top" align="center" bgcolor="#ffffff"> 
                  	<table width="280" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="eraseForMobile2">
                        	<tr>
                              	<td valign="middle" height="10" align="center" bgcolor="#ffffff" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
				</table>
				<table width="600" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="table600">
					<tr>
						<td valign="top" align="center" height="20" bgcolor="#ffffff" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
                              <tr>			
                              																																													
                                    <td valign="middle" align="center" bgcolor="#ffffff" height="10" class="introTextTD">
                                    
                                    Cordialement,
                                    
                                    
                                    </td>
                              	
                              </tr>
                              
					<tr>
						<td valign="top" align="center" height="20" bgcolor="#ffffff" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
				</table>
                        <table width="280" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="eraseForMobile2">
                        	<tr>
                              	<td valign="middle" height="10" align="center" bgcolor="#ffffff" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
  </table>
      
      
	
	<!---->
    <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e">
      	<tr>
			<td valign="bottom" align="center" bgcolor="#43494e">
                  	<table width="280" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e" class="eraseForMobile2">
                        	<tr>
                              	<td valign="middle" height="10" align="center" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
				</table>
				<table width="600" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e" class="table600">
					<tr>
						<td valign="top" align="center" height="30" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
					<tr>
						
						<td valign="middle" align="center" height="10" bgcolor="#43494e" class="adressOrAnyOtherTD"><a href="#" target="_blank" class="adressOrAnyOtherTDLink" style="color:#ff7a0d !important;">'.$company['email'].'</a>
					  </td>	
						
					</tr>
					<tr>
                              	<!--============= FINAL WORDS , FOOTER SLOGAN , CALL TO ACTION ================-->
						<td valign="middle" align="center" height="20" bgcolor="#43494e" class="finalWords" style="color:#FFF !important;">'.$company['address'].', '.$company['postcode'].' '.$company['city'].'<br> Tel : '.$company['phone_mobile'].' / '.$company['phone'].'</td>
						<!--========================== End of the section ========================-->
                              </tr>
					<tr>
						<td valign="top" align="center" height="24" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
				</table>
                        
			</td>
		</tr>
	</table>
    <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ff7a0d">
		<tr>
			<td valign="middle" align="center" height="50">
				<table width="600" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ff7a0d" class="table600">
					<tr>
						<td valign="top" align="center" bgcolor="#ff7a0d"> 
							
							<table width="50" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ff7a0d">
								<tr>
									
									<td valign="top" align="center" height="42" bgcolor="#ff7a0d"><a href="#" target="_blank" class="buttonsAndImagesLink"><img src="'.ROOT_URL.'assets/images/socialFacebook.jpg" style="display:block;" alt="" border="0" align="top" hspace="0" vspace="0" width="42" height="42"/></a></td>
                                                     
                                                      <td valign="top" align="center" height="42" bgcolor="#ff7a0d"><a href="#" target="_blank" class="buttonsAndImagesLink"><img src="'.ROOT_URL.'assets/images/socialTwitter.jpg" style="display:block;" alt="" border="0" align="top" hspace="0" vspace="0" width="42" height="42"/></a></td>
                                                      
                                                      <td valign="top" align="center" height="42" bgcolor="#ff7a0d"><a href="#" target="_blank" class="buttonsAndImagesLink"><img src="'.ROOT_URL.'assets/images/socialLinkedin.jpg" style="display:block;" alt="" border="0" align="top" hspace="0" vspace="0" width="42" height="42"/></a></td>
                                                     
                                                       <td valign="top" align="center" height="42" bgcolor="#ff7a0d"><a href="#" target="_blank" class="buttonsAndImagesLink"><img src="'.ROOT_URL.'assets/images/socialVimeo.jpg" style="display:block;" alt="" border="0" align="top" hspace="0" vspace="0" width="42" height="42"/></a></td>
                                                      
                                                      <td valign="top" align="center" height="42" bgcolor="#ff7a0d"><a href="#" target="_blank" class="buttonsAndImagesLink"><img src="'.ROOT_URL.'assets/images/socialPinterest.jpg" style="display:block;" alt="" border="0" align="top" hspace="0" vspace="0" width="42" height="42"/></a></td>
                                                      
                                                      <td valign="top" align="center" height="42" bgcolor="#ff7a0d"><a href="#" target="_blank" class="buttonsAndImagesLink"><img src="'.ROOT_URL.'assets/images/socialGoogle.jpg" style="display:block;" alt="" border="0" align="top" hspace="0" vspace="0" width="42" height="42"/></a></td>
                                                    
								</tr>
							</table>
							
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
    <!---->        
	<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#43494e">
		<tr>
			<td valign="top" align="center" height="15" bgcolor="#43494e">
				<table align="center" width="600" cellpadding="0" cellspacing="0" style="color:#FFF !important;" bgcolor="#43494e" border="0" class="table600">
                	<tr>
						<td valign="top" align="center" height="30" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>
					</tr>
					<tr>
						
						<td valign="middle" align="center" height="10" bgcolor="#43494e" class="adressOrAnyOtherTD"><a href="#" target="_blank" class="adressOrAnyOtherTDLink" style="color:#ff7a0d !important;">'.$SAMAGROUP['email'].'</a>
					  </td>	
						
					</tr>
					
					<tr>
						
						<td valign="middle" align="center" height="10" bgcolor="#43494e" class="mailingOptionsTD">'.$SAMAGROUP['address'].', '.$SAMAGROUP['postcode'].' '.$SAMAGROUP['city'].' Tel : '.$SAMAGROUP['phone_mobile'].' / '.$SAMAGROUP['phone'].'</td>
						
					</tr>
                              <tr>
						<td valign="middle" align="center" height="3" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>	
					</tr>
					
                              <tr>
							  
						<td valign="middle" width="50%" align="center" height="10" bgcolor="#43494e" class="copyrightCompanyTD"><img src="'.ROOT_URL.'assets/images/logo-footer.png"></td>
						</tr>
						<tr>
						
						<td valign="middle" width="50%" align="center" height="10" bgcolor="#43494e" class="copyrightCompanyTD">&copy; Copyright <a href="http://www.SAMAGROUP.be" target="_blank" class="copyrightCompanyTDLink" style="color:#ff7a0d !important;">SAMAGROUP</a> 2015</td>
						
					</tr>
					
					
				</table>
			</td>
		</tr>
		<tr>
			<td valign="top" align="center" height="35" bgcolor="#43494e" style="font-size:0; line-height:0;">&nbsp;</td>
		</tr>
	</table>   
     
</center>
</body>
</html>';

echo $a;

?>

