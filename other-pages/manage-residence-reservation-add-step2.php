<?php
	include_once './includes/config.inc.php';
 	
	// Authenticate user login
	auth();


	if (isset ($_POST['add_reservation'])){
		

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
 													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
												</select>								
											</div>
											
											
											<div class="form-group" style="width: 10%;margin-left:2%;">
												<label>Adultes </label>
												<select name="nbr_adulte" class="form-control m-bot15" style="display: block;width: 85%;">
													<option value="--">--</option>
 													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
												</select>								
											</div>
											<div class="form-group" style="width: 10%;margin-left:2%;">
												<label>Enfants </label>
												<select name="nbr_enfant" class="form-control m-bot15" style="display: block;width: 85%;">
													<option value="--">--</option>
													<option value="0">0</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
												</select>								
											</div>
											<div class="form-group" style="width: 10%;margin-left:2%;">
												<label>&nbsp; </label>
												<button type="submit" class="btn btn-purple">Voir les disponibilitées</button>					
											</div>
											<div class="form-group" style="width: 10%;margin-left:7%;">
												<label>&nbsp; </label>
												<a href="manage-calendar.php" style="margin-left:2%;" class="btn btn-primary">Afficher la calendrier</a>					
											</div>
										</form>
										
									</div>
									
									
									
									
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
														if ($residence['max_child'] != $nbr_enfant) {
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
														
														/* 	echo "<br>prix_lun = ".$prix_lun;
															echo "<br>prix_mar = ".$prix_mar;
															echo "<br>prix_mer = ".$prix_mer;
															echo "<br>prix_jeu = ".$prix_jeu;
															echo "<br>prix_ven = ".$prix_ven;
															echo "<br>prix_sam = ".$prix_sam;
														echo "<br>prix_dim = ".$prix_dim; */
														
														
													?>
													
													
													<div class="search_result">
														<form method="post" action="manage-residence-reservation-add-step2.php">
															<input type="hidden" name="add_reservation" value="add">
															<input type="hidden" name="id_residence_type" value="<?php echo $residence['id'];?>">
															<input type="hidden" name="nbr_chambr" value="<?php echo $nbr_chambr;?>">
															<input type="hidden" name="nbr_adulte" value="<?php echo $nbr_adulte;?>">
															<input type="hidden" name="nbr_enfant" value="<?php echo $nbr_enfant;?>">
															<input type="hidden" name="date_debut" value="<?php echo $periode_de;?>">
															<input type="hidden" name="date_fin" value="<?php echo $periode_a;?>">
															<div class="pull-left col-sm-3 col-xs-3"><img class="img-responsive" src="<?php echo $src_img;?>"></div>
															<div class="pull-left col-sm-9 col-xs-9">
																<h4><a href="#"><?php echo $residence['titre_fr'];?></a></h4>
																<span class="team-member-edit"><?php echo $res['nbr_chambre_disponible'];?> chambres disponibles</span>
																<span style=" display:block" class="team-member-edit"><?php echo sprintf("%0.2F",($total_price)); ?> DT pour <?php echo $nbJours;?> jours</span>
																<div class="timings"> 
																	<ul class="list-inline list-unstyled">
																		
																		<li><span class="temp" style="  font-size: 13px;color: #32323a;">Prix par jours : </span><span class="temp" style="display: block;font-size: 10px;">&nbsp;</span></li>
																		<li><span class="temp" style=" font-size: 12px;">Lun</span> <span class="temp" style="display: block;font-size: 10px;"><?php echo sprintf("%0.2F",($prix_lun)); ?> DT</span></li>     
																		<li><span class="temp" style=" font-size: 12px;">Mar</span> <span class="temp" style="display: block;font-size: 10px;"><?php echo sprintf("%0.2F",($prix_mar)); ?> DT</span></li>
																		<li><span class="temp" style=" font-size: 12px;">Mer</span> <span class="temp" style="display: block;font-size: 10px;"><?php echo sprintf("%0.2F",($prix_mer)); ?> DT</span></li>
																		<li><span class="temp" style=" font-size: 12px;">Jeu</span> <span class="temp" style="display: block;font-size: 10px;"><?php echo sprintf("%0.2F",($prix_jeu)); ?> DT</span></li>
																		<li><span class="temp" style=" font-size: 12px;">Ven</span> <span class="temp" style="display: block;font-size: 10px;"><?php echo sprintf("%0.2F",($prix_ven)); ?> DT</span></li>
																		<li><span class="temp" style=" font-size: 12px;">Sam</span> <span class="temp" style="display: block;font-size: 10px;"><?php echo sprintf("%0.2F",($prix_sam)); ?> DT</span></li>
																		<li><span class="temp" style=" font-size: 12px;">Dim</span> <span class="temp" style="display: block;font-size: 10px;"><?php echo sprintf("%0.2F",($prix_dim)); ?> DT</span></li>
																		
																		
																	</ul>
																</div>
 																<button type="submit"  class="btn btn-primary pull-right">Reserver</button>
																
															</div>
														</form>
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
		function getDispo(){
		
		alert("e");}
		</script>
		
		
		
		
		
		</body>
		</html>
		
		
				