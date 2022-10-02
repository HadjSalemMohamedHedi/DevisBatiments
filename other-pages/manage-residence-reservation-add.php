<?php
	include_once './includes/config.inc.php';
 	
	// Authenticate user login
	auth();
	
	
	$residence_dispo=array();
	if (isset ($_POST['add_reservation'])){
		
		$nbr_enfant=$_POST['nbr_enfant'];
		$nbr_adulte=$_POST['nbr_adulte'];
		$nbr_chambr=$_POST['nbr_chambr'];
		
		$intervalle_date=$_POST['intervalle_date'];
		$pieces = explode(" ==> ", $intervalle_date);
		
			$_POST['periode_de'] = str_replace("/", "-", $pieces[0]);
			$_POST['periode_a'] = str_replace("/", "-", $pieces[1]);
		
	/* 	$_POST['periode_de']= $pieces[0];
		$_POST['periode_a']= $pieces[1]; */
		
		$date_debut_ = strtotime($_POST['periode_de']);
		$periode_de = date('Y-m-d',$date_debut_);
		
		$date_debut_ = strtotime($_POST['periode_a']);
		$periode_a = date('Y-m-d',$date_debut_);
		
		 
		
		$date1 = strtotime($periode_de);
		$date2 = strtotime($periode_a);
		$nbJoursTimestamp = $date2 - $date1;
		$nbJours = $nbJoursTimestamp/86400; // 86 400 = 60*60*24
		
		//$nbJours+=1;
		$nuit="nuit";
		if ($nbJours>1){
		$nuit.="s";
		}
		
		
		/**************************************************************/
		
		
		/***************************************************************/
		
		if (isset( $_POST['id_specific_residence'])){
 			$residence_type = $db->get_rows("SELECT residence_type.* FROM residence_type where statut=1 and id=".$_POST['id_specific_residence']);
			}else{
			$residence_type = $db->get_rows("SELECT residence_type.* FROM residence_type where statut=1");
		}
		
		
		
		foreach ($residence_type as $res) {
			
			
			
			$id_res=$res['id'];
			
			$residence_reservation = $db->get_rows("SELECT residence_reservation.* FROM residence_reservation  
			
			WHERE (
			residence_reservation.id_residence_type = ".$id_res." and residence_reservation.active = 1 and (
			('".$periode_de."'  between residence_reservation.date_debut and residence_reservation.date_fin ) OR 
			('".$periode_a."'  between residence_reservation.date_debut and residence_reservation.date_fin )
			))"
			);
			
			
			
			
			
			$nbr_reservation_active= count ($residence_reservation);
			
			
			if ($nbr_reservation_active < $res['nb_chambre_total']) {
				$res_item=array();
				$res_item['id']=$id_res;
				$res_item['nbr_chambre_disponible']=$res['nb_chambre_total'] - $nbr_reservation_active;
				
				$residence_dispo[]=$res_item;
			}
			
			
		}
		/*	
			echo "<pre>";
			print_r($residence_dispo);
			echo "<pre>";
			
			echo "<br>";
			echo $periode_de;
			echo "<br>";
			echo $periode_a; 
		die(); */
	}
	
	
?>

<!DOCTYPE html>
<html class=" ">
	<head>
		<!-- 
			* @Package: Ultra Admin - Responsive Theme
			* @Subpackage: Bootstrap
			* @Version: 1.0
			* This file is part of Ultra Admin Theme.
		-->
		<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
		<meta charset="utf-8" />
		<title>SIBEC Fixation & Supportage</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta content="" name="description" />
		<meta content="" name="author" />
		
		<link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />    <!-- Favicon -->
		<link rel="apple-touch-icon-precomposed" href="assets/images/apple-touch-icon-57-precomposed.png">	<!-- For iPhone -->
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/apple-touch-icon-114-precomposed.png">    <!-- For iPhone 4 Retina display -->
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/apple-touch-icon-72-precomposed.png">    <!-- For iPad -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/apple-touch-icon-144-precomposed.png">    <!-- For iPad Retina display -->
		
		
		
		
		<!-- CORE CSS FRAMEWORK - START -->
		<link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		<link href="assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
		<link href="assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
		<!-- CORE CSS FRAMEWORK - END -->
		
		<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
		<link href="assets/plugins/jquery-ui/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/datepicker/css/datepicker.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/daterangepicker/css/daterangepicker-bs3.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/timepicker/css/timepicker.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/datetimepicker/css/datetimepicker.min.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/ios-switch/css/switch.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/select2/select2.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/typeahead/css/typeahead.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/multi-select/css/multi-select.css" rel="stylesheet" type="text/css" media="screen"/>        
		<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 
		<link href="assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" media="screen"/>        
		<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 
		
		
		<!-- CORE CSS TEMPLATE - START -->
		<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
		<link href="assets/css/responsive.css" rel="stylesheet" type="text/css"/>
		<!-- CORE CSS TEMPLATE - END -->
		<style>
			.lawyer_list{
			display:none;
			}
		</style>
	</head>
	<!-- END HEAD -->
	
	<!-- BEGIN BODY -->
	<body class=" ">
		<!-- START TOPBAR -->
		<?php include ROOT."includes/navbar.php"; ?>
		<!-- END TOPBAR -->
		<!-- START CONTAINER -->
		<div class="page-container row-fluid">
			
			<!-- SIDEBAR - START -->
			<?php include ROOT."includes/sidebar.php"; ?>
			<!--  SIDEBAR - END -->
			<!-- START CONTENT -->
			<section id="main-content" class=" ">
				<section class="wrapper" style='margin-top:60px;display:inline-block;width:100%;padding:15px 0 0 15px;'>
					<?php $msg='<div class="list-group-item list-group-item-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Erreur:</strong><br>';
						if(isset($errors)) {
							foreach($errors as $error):
							$msg.='- '.$error.'<br>';
							endforeach;
							$msg.='</div>'; 
							echo $msg;
						}
						$msg='<div class="list-group-item list-group-item-success "><button type="button" class="close" data-dismiss="alert" aria-label="Close"></button> ';
						if(isset($success)) {
							foreach($success as $success):
							$msg.='- '.$success.'<br>';
							endforeach;
							$msg.='</div>'; 
							echo $msg;
						}
						
					?>
					
					<div class="col-lg-12 col-md-12 col-sm-12">
						<h2 class="title pull-left">Nouvelle réservation</h2>
						
						
						
						
						<section class="box ">
							<header class="panel_header">
								<div class="actions panel_actions pull-right">
									<i class="box_toggle fa fa-chevron-down"></i>
									<!--	<i class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></i>
									<i class="box_close fa fa-times"></i>-->
								</div>
							</header>
							<div class="content-body" style="display: block;">    <div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="row"  style="margin-bottom:2%;" >
										
										
										
										<form class="form-inline" method="post">
											
											<input type="hidden" name="add_reservation" value="add">
											
											
											<div class="form-group" style="width: 25%;margin-left:2%;">
												<label>Intervalle de date </label>
												<input type="text"  required style="width: 90%;"  id="daterange-2" name="intervalle_date" class="form-control daterange" data-format="DD-MM-YYYY" data-start-date="<?php echo date('d-m-Y',strtotime("+0 day", time())) ?>" data-end-date="<?php echo date('d-m-Y',strtotime("+1 day", time())) ?>" data-separator=" ==> "  value="<?php if (isset ($_POST['intervalle_date'])) {echo $_POST['intervalle_date'] ;}?>" >
											</div>
											
											
											<div class="form-group" style="width: 10%;margin-left:2%;">
												<label>Chambres </label>
												<select name="nbr_chambr" class="form-control m-bot15" style="display: block;width: 85%;">
													<option value="--">--</option>
 													<option value="1" <?php if ((isset ($_POST['nbr_chambr'])) and ($_POST['nbr_chambr']=='1') ) {echo "selected";}?>>1</option>
													<option value="2" <?php if ((isset ($_POST['nbr_chambr'])) and ($_POST['nbr_chambr']=='2') ) {echo "selected";}?>>2</option>
													<option value="3" <?php if ((isset ($_POST['nbr_chambr'])) and ($_POST['nbr_chambr']=='3') ) {echo "selected";}?>>3</option>
													<option value="4" <?php if ((isset ($_POST['nbr_chambr'])) and ($_POST['nbr_chambr']=='4') ) {echo "selected";}?>>4</option>
													<option value="5" <?php if ((isset ($_POST['nbr_chambr'])) and ($_POST['nbr_chambr']=='5') ) {echo "selected";}?>>5</option>
												</select>								
											</div>
											
											
											<div class="form-group" style="width: 10%;margin-left:2%;">
												<label>Adultes </label>
												<select name="nbr_adulte" class="form-control m-bot15" style="display: block;width: 85%;">
													<option value="--">--</option>
 													<option value="1" <?php if ((isset ($_POST['nbr_adulte'])) and ($_POST['nbr_adulte']=='1') ) {echo "selected";}?>>1</option>
													<option value="2" <?php if ((isset ($_POST['nbr_adulte'])) and ($_POST['nbr_adulte']=='2') ) {echo "selected";}?>>2</option>
													<option value="3" <?php if ((isset ($_POST['nbr_adulte'])) and ($_POST['nbr_adulte']=='3') ) {echo "selected";}?>>3</option>
													<option value="4" <?php if ((isset ($_POST['nbr_adulte'])) and ($_POST['nbr_adulte']=='4') ) {echo "selected";}?>>4</option>
													<option value="5" <?php if ((isset ($_POST['nbr_adulte'])) and ($_POST['nbr_adulte']=='5') ) {echo "selected";}?>>5</option>
												</select>								
											</div>
											<div class="form-group" style="width: 10%;margin-left:2%;">
												<label>Enfants </label>
												<select name="nbr_enfant" class="form-control m-bot15" style="display: block;width: 85%;">
													<option value="--">--</option>
													<option value="0" <?php if ((isset ($_POST['nbr_enfant'])) and ($_POST['nbr_enfant']=='0') ) {echo "selected";}?>>0</option>
													<option value="1" <?php if ((isset ($_POST['nbr_enfant'])) and ($_POST['nbr_enfant']=='1') ) {echo "selected";}?>>1</option>
													<option value="2" <?php if ((isset ($_POST['nbr_enfant'])) and ($_POST['nbr_enfant']=='2') ) {echo "selected";}?>>2</option>
													<option value="3" <?php if ((isset ($_POST['nbr_enfant'])) and ($_POST['nbr_enfant']=='3') ) {echo "selected";}?>>3</option>
													<option value="4" <?php if ((isset ($_POST['nbr_enfant'])) and ($_POST['nbr_enfant']=='4') ) {echo "selected";}?>>4</option>
													<option value="5" <?php if ((isset ($_POST['nbr_enfant'])) and ($_POST['nbr_enfant']=='5') ) {echo "selected";}?>>5</option>
												</select>								
											</div>
											<div class="form-group" style="width: 10%;margin-left:2%;">
												<label>&nbsp; </label>
												<button type="submit" class="btn btn-purple">Voir les disponibilités</button>					
											</div>
											<div class="form-group" style="width: 10%;margin-left:7%;">
												<label>&nbsp; </label>
												<a href="manage-residence-disponibilite-calendar.php" style="margin-left:2%;" class="btn btn-primary">Afficher la calendrier</a>					
											</div>
										</form>
										
									</div>
									
									<input type="hidden" id="nbr_chambr" value="<?php echo $nbr_chambr;?>">
									<input type="hidden" id="nbr_adulte" value="<?php echo $nbr_adulte;?>">
									<input type="hidden" id="nbr_enfant" value="<?php echo $nbr_enfant;?>">
									<input type="hidden" id="date_debut" value="<?php echo $periode_de;?>">
									<input type="hidden" id="date_fin" value="<?php echo $periode_a;?>">
									
									
									<div class="content-body">    <div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12">
											
											<div class="row">
												
												<?php foreach ($residence_dispo as $res) {
													$residence = $db->get_row("SELECT residence_type.* FROM residence_type where id=".$res['id']);
													if(($residence['img']!="")) {$src_img=$residence['img'];}else{$src_img="assets/images/no-img.png";}
													$enfant=true;
													$adulte=true;
													$chambr=true;
													
													
													if ($nbr_enfant != "--" ){
														if ($residence['max_child'] < $nbr_enfant) {
															$enfant=false;
														}
													} 
													if ($nbr_adulte != "--" ){
														if ($residence['max_adults'] < $nbr_adulte) {
															$adulte=false;
														}
													} 
													if ($nbr_chambr != "--" ){
														if ($residence['chambre'] < $nbr_chambr) {
															$chambr=false;
														}
													} 
													if ( ($enfant) && ($adulte) && ($chambr) ) {
														
														
														$residence_prix = $db->get_row("SELECT residence_prix.* FROM residence_prix WHERE  residence_prix.type= 'personalise' and  residence_prix.id_residence=".$db->escape($res['id'])."
														and ('".$periode_de."' >= periode_de )
														and ('".$periode_a."' <= periode_a )
														and statut = 1
														");
														
														if (empty($residence_prix)){
															$residence_prix = $db->get_row("SELECT residence_prix.* FROM residence_prix WHERE  residence_prix.type= 'standard' and  residence_prix.id_residence=".$db->escape($res['id']));
														}
														
														$prix_lun=$residence_prix['prix_lun'];
														$prix_mar=$residence_prix['prix_mar'];
														$prix_mer=$residence_prix['prix_mer'];
														$prix_jeu=$residence_prix['prix_jeu'];
														$prix_ven=$residence_prix['prix_ven'];
														$prix_sam=$residence_prix['prix_sam'];
														$prix_dim=$residence_prix['prix_dim'];
														
														
														$total_price=get_price_per_period_and_type($periode_de,$periode_a,$res['id']);
														
														
													?>
													
													
													<div class="search_result">
													 	
														<input type="hidden" id="prix_lundi_<?php echo $residence['id'];?>" value="<?php echo $prix_lun;?>">
														<input type="hidden" id="prix_mardi_<?php echo $residence['id'];?>" value="<?php echo $prix_mar;?>">
														<input type="hidden" id="prix_mercredi_<?php echo $residence['id'];?>" value="<?php echo $prix_mer;?>">
														<input type="hidden" id="prix_jeudi_<?php echo $residence['id'];?>" value="<?php echo $prix_jeu;?>">
														<input type="hidden" id="prix_vendredi_<?php echo $residence['id'];?>" value="<?php echo $prix_ven;?>">
														<input type="hidden" id="prix_samedi_<?php echo $residence['id'];?>" value="<?php echo $prix_sam;?>">
														<input type="hidden" id="prix_dimanche_<?php echo $residence['id'];?>" value="<?php echo $prix_dim;?>">
														
														<input type="hidden" id="nbr_chambre_disponible<?php echo $residence['id'];?>" value="<?php echo $res['nbr_chambre_disponible'];?>">
														
														
														<div class="pull-left col-sm-3 col-xs-3"><img class="img-responsive" src="<?php echo $src_img;?>"></div>
														<div class="pull-left col-sm-9 col-xs-9">
															<h4><a href="#"><?php echo $residence['titre_fr'];?></a></h4>
															<span class="team-member-edit"><?php echo $res['nbr_chambre_disponible'];?> chambres disponibles</span>
															<span style=" display:block" class="team-member-edit"><?php echo sprintf("%0.2F",($total_price)); ?> DT pour <?php echo $nbJours." ".$nuit;?> </span>
															<div class="timings"> 
																<ul class="list-inline list-unstyled">
																	
																	<li  ><span class="temp" style="  font-size: 13px;color: #32323a;">Prix par jours : </span><span class="temp" style="display: block;font-size: 10px;">&nbsp;</span></li>
																	<li class="inviewport animated animated-delay-600ms visible rollIn"><span class="temp" style=" font-size: 12px;">Lun</span> <span class="temp" style="display: block;font-size: 10px;"><?php echo sprintf("%0.2F",($prix_lun)); ?> DT</span></li>     
																	<li class="inviewport animated animated-delay-800ms visible rollIn"><span class="temp" style=" font-size: 12px;">Mar</span> <span class="temp" style="display: block;font-size: 10px;"><?php echo sprintf("%0.2F",($prix_mar)); ?> DT</span></li>
																	<li class="inviewport animated animated-delay-1000ms visible rollIn"><span class="temp" style=" font-size: 12px;">Mer</span> <span class="temp" style="display: block;font-size: 10px;"><?php echo sprintf("%0.2F",($prix_mer)); ?> DT</span></li>
																	<li class="inviewport animated animated-delay-1200ms visible rollIn"><span class="temp" style=" font-size: 12px;">Jeu</span> <span class="temp" style="display: block;font-size: 10px;"><?php echo sprintf("%0.2F",($prix_jeu)); ?> DT</span></li>
																	<li class="inviewport animated animated-delay-1400ms visible rollIn"><span class="temp" style=" font-size: 12px;">Ven</span> <span class="temp" style="display: block;font-size: 10px;"><?php echo sprintf("%0.2F",($prix_ven)); ?> DT</span></li>
																	<li class="inviewport animated animated-delay-1800ms visible rollIn"><span class="temp" style=" font-size: 12px;">Sam</span> <span class="temp" style="display: block;font-size: 10px;"><?php echo sprintf("%0.2F",($prix_sam)); ?> DT</span></li>
																	<li class="inviewport animated animated-delay-2000ms visible rollIn"><span class="temp" style=" font-size: 12px;">Dim</span> <span class="temp" style="display: block;font-size: 10px;"><?php echo sprintf("%0.2F",($prix_dim)); ?> DT</span></li>
																	
																	
																</ul>
															</div>
															<button type="submit"  onclick="CreateReservation(<?php echo $residence['id'];?>);" class="btn btn-primary pull-right">Réserver</button>
															
														</div>
													<?php } }?>
													
													
												</div>
												
											</div>
										</div>
									</div>
									
									</div>
								</div>
							</div>
							</section>
							
						</div>
						<!---->
						
						
					</section>
				</section>
				<!-- END CONTENT -->
				
				
				
				<div class="chatapi-windows ">
					
					
				</div>    </div>
				<!-- END CONTAINER -->
				<!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->
				
				<div class="modal fade ultraModal-add" id="ultraModal-add">
					<div class="modal-dialog animated zoomIn">
						<div class="modal-content">
							
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Réservation | Client </h4>
							</div>
							
							<div class="modal-body" > loading... </div>
							<div class="modal-footer"> 
								
							</div>
							
						</div>
					</div>
				</div>
				
				<!-- CORE JS FRAMEWORK - START --> 
				<script src="assets/js/jquery-1.11.2.min.js" type="text/javascript"></script> 
				<script src="assets/js/jquery.easing.min.js" type="text/javascript"></script> 
				<script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
				<script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>  
				<script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js" type="text/javascript"></script> 
				<script src="assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>  
				<script src="assets/js/form-validation.js" type="text/javascript"></script>
				<!-- CORE JS FRAMEWORK - END --> 
				
				
				<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
				<script src="assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script> 
				<script src="assets/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script> 
				<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 
				
				
				<script src="assets/plugins/jquery-ui/smoothness/jquery-ui.min.js" type="text/javascript"></script>
		<script src="assets/plugins/datepicker/js/datepicker.js" type="text/javascript"></script> 
		<script src="assets/plugins/daterangepicker/js/moment.min.js" type="text/javascript"></script> 
		<script src="assets/plugins/daterangepicker/js/daterangepicker.js" type="text/javascript"></script> 
		<script src="assets/plugins/timepicker/js/timepicker.min.js" type="text/javascript"></script> 
		<script src="assets/plugins/datetimepicker/js/datetimepicker.min.js" type="text/javascript"></script> 
		<script src="assets/plugins/datetimepicker/js/locales/bootstrap-datetimepicker.fr.js" type="text/javascript"></script> 
		<script src="assets/plugins/colorpicker/js/bootstrap-colorpicker.min.js" type="text/javascript"></script> 
		<script src="assets/plugins/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script> 
		<script src="assets/plugins/select2/select2.min.js" type="text/javascript"></script> 
		<script src="assets/plugins/typeahead/typeahead.bundle.js" type="text/javascript"></script> 
		<script src="assets/plugins/typeahead/handlebars.min.js" type="text/javascript"></script> 
		<script src="assets/plugins/multi-select/js/jquery.multi-select.js" type="text/javascript"></script> 
		<script src="assets/plugins/multi-select/js/jquery.quicksearch.js" type="text/javascript"></script> 
		<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->  
		<script src="assets/plugins/autosize/autosize.min.js" type="text/javascript"></script><script src="assets/plugins/icheck/icheck.min.js" type="text/javascript"></script><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 
		
		<!-- CORE TEMPLATE JS - START --> 
		<script src="assets/js/scripts.js" type="text/javascript"></script> 
		<!-- END CORE TEMPLATE JS - END --> 
		
		<!-- Sidebar Graph - START --> 
		<script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
		<script src="assets/js/chart-sparkline.js" type="text/javascript"></script>
		<!-- Sidebar Graph - END --> 
		
		
		
		<script>
		
		
		function CreateReservation(id)
		{
		jQuery('#ultraModal-add').modal('show', {backdrop: 'static'});
		$('#msg-add').html('');
		
		
		var prix_lundi=$('#prix_lundi_'+id).val();
		var prix_mardi=$('#prix_mardi_'+id).val();
		var prix_mercredi=$('#prix_mercredi_'+id).val();
		var prix_jeudi=$('#prix_jeudi_'+id).val();
		var prix_vendredi=$('#prix_vendredi_'+id).val();
		var prix_samedi=$('#prix_samedi_'+id).val();
		var prix_dimanche=$('#prix_dimanche_'+id).val();
		
		var nbr_chambre_disponible=$('#nbr_chambre_disponible'+id).val();
		
		var nbr_chambr=$('#nbr_chambr').val();
		var nbr_adulte=$('#nbr_adulte').val();
		var nbr_enfant=$('#nbr_enfant').val();
		var date_debut=$('#date_debut').val();
		var date_fin=$('#date_fin').val();
		
		 
		
		jQuery.ajax({
		url: "module_ajax/reservation/add.php?id="+id+"&prix_lundi="+prix_lundi+id+"&prix_mardi="+prix_mardi+id+"&prix_mercredi="+prix_mercredi+id+"&prix_jeudi="+prix_jeudi+id+"&prix_vendredi="+prix_vendredi+id+"&prix_samedi="+prix_samedi+id+"&prix_dimanche="+prix_dimanche+id+"&nbr_chambre_disponible="+nbr_chambre_disponible+"&nbr_chambr="+nbr_chambr+"&nbr_adulte="+nbr_adulte+"&nbr_enfant="+nbr_enfant+"&date_debut="+date_debut+"&date_fin="+date_fin,
		success: function(response)
		{
		jQuery('#ultraModal-add .modal-body').html(response);
		var notif_widget = $(".perfect-scroll").height();
		$('.perfect-scroll').height(notif_widget).perfectScrollbar({
		suppressScrollX: true
		});
		<!--multiple speciality-->
		$("#ultraModal-add #speciality").select2({
		placeholder: 'Choisissez',
		allowClear: true
		}).on('select2-open', function() {
		// Adding Custom Scrollbar
		$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
		});
		
		$("#s2example-1").select2({
		placeholder: '...',
		allowClear: true
		}).on('select2-open', function() {
		// Adding Custom Scrollbar
		$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
		});	
		
		}
		});
		}	
		
		
		</script>
		
		</body>
		</html>
		
		
				