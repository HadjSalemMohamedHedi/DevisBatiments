<?php
	include_once './includes/config.inc.php';
	include_once './includes/validate-user.php';
	
	// Authenticate user login
	auth();
	
	if(!isset($_GET['id']) && !is_numeric($_GET['id']))exit;
	
	$residence_type = $db->get_row("SELECT residence_type.* FROM residence_type WHERE  residence_type.id=".$db->escape($_GET['id']));
	
	$langs= $db->get_rows("SELECT lang.* FROM lang WHERE lang.active='1'");
	
	
	$residence_prix = $db->get_row("SELECT residence_prix.* FROM residence_prix WHERE  residence_prix.type= 'standard' and  residence_prix.id_residence=".$db->escape($_GET['id']));
	if (empty($residence_prix)){
		$new_residence_type=array();
		$new_residence_type['id_residence']=$_GET['id'];
		$new_residence_type['prix_lun']=$residence_type['default_price'];
		$new_residence_type['prix_mar']=$residence_type['default_price'];
		$new_residence_type['prix_mer']=$residence_type['default_price'];
		$new_residence_type['prix_jeu']=$residence_type['default_price'];
		$new_residence_type['prix_ven']=$residence_type['default_price'];
		$new_residence_type['prix_sam']=$residence_type['default_price'];
		$new_residence_type['prix_dim']=$residence_type['default_price'];
		$new_residence_type['type']="standard";
		$new_residence_type['statut']="1";
		
		if(!$db->insert('residence_prix',$new_residence_type)) {}
	}
	
	if (isset ($_POST['add_price']))
	{
		if ( (!is_numeric($_POST['lundi_prix_add'])) || (!is_numeric($_POST['mardi_prix_add']))  || (!is_numeric($_POST['mercredi_prix_add'])) || (!is_numeric($_POST['jeudi_prix_add'])) || (!is_numeric($_POST['vendredi_prix_add'])) || (!is_numeric($_POST['samedi_prix_add'])) || (!is_numeric($_POST['dimanche_prix_add'])) ) {
			$errors[] = "vérifier les prix";
		}
		if(empty($errors)) {
			$new_residence_type=array();
			$new_residence_type['id_residence']=$_GET['id'];
			$new_residence_type['prix_lun']=$_POST['lundi_prix_add'];
			$new_residence_type['prix_mar']=$_POST['mardi_prix_add'];
			$new_residence_type['prix_mer']=$_POST['mercredi_prix_add'];
			$new_residence_type['prix_jeu']=$_POST['jeudi_prix_add'];
			$new_residence_type['prix_ven']=$_POST['vendredi_prix_add'];
			$new_residence_type['prix_sam']=$_POST['samedi_prix_add'];
			$new_residence_type['prix_dim']=$_POST['dimanche_prix_add'];
			$new_residence_type['type']="personalise";
			$new_residence_type['statut']="1";
			
			$intervalle_date=$_POST['intervalle_date'];
			$pieces = explode("||", $intervalle_date);
			$_POST['periode_de']= $pieces[0];
			$_POST['periode_a']= $pieces[1];
			
			$date_debut_ = strtotime($_POST['periode_de']);
			$new_residence_type['periode_de'] = date('Y-m-d',$date_debut_);
				
			$date_debut_ = strtotime($_POST['periode_a']);
			$new_residence_type['periode_a'] = date('Y-m-d',$date_debut_);
			
			if($db->insert('residence_prix',$new_residence_type)) {$success[] = "La mise à jours des prix a été effectué avec succès";}
		}
	}
	if (isset ($_POST['apdate_price']))
	{
		if ( (!is_numeric($_POST['prix_lun'])) || (!is_numeric($_POST['prix_mar']))  || (!is_numeric($_POST['prix_mer'])) || (!is_numeric($_POST['prix_jeu'])) || (!is_numeric($_POST['prix_ven'])) || (!is_numeric($_POST['prix_sam'])) || (!is_numeric($_POST['prix_dim'])) ) {
			$errors[] = "vérifier les prix";
		}       
		if(empty($errors)) {
			$new_residence_type=array();
			$new_residence_type['prix_lun']=$_POST['prix_lun'];
			$new_residence_type['prix_mar']=$_POST['prix_mar'];
			$new_residence_type['prix_mer']=$_POST['prix_mer'];
			$new_residence_type['prix_jeu']=$_POST['prix_jeu'];
			$new_residence_type['prix_ven']=$_POST['prix_ven'];
			$new_residence_type['prix_sam']=$_POST['prix_sam'];
			$new_residence_type['prix_dim']=$_POST['prix_dim'];
			
			if($db->update('residence_prix',$new_residence_type,$_POST['id'])) {$success[] = "La mise à jours des prix a été effectué avec succès";}
		}
	}
	
	$residence_prix = $db->get_row("SELECT residence_prix.* FROM residence_prix WHERE  residence_prix.type= 'standard' and  residence_prix.id_residence=".$db->escape($_GET['id']));
	
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
					    <h2 class="title pull-left">Gestion de prix des résidences de type  <?php echo $residence_type['titre_fr']?></h2>
						
						<section class="box ">
							<header class="panel_header">
								
								<h2 class="title pull-left ">Prix standard</h2>
								<div class="actions panel_actions pull-right">
									<i class="box_toggle fa fa-chevron-down"></i>
									<!--	<i class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></i>
									<i class="box_close fa fa-times"></i>-->
								</div>
								
							</header>
							<div class="content-body" style="display: block;">    <div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="row">
										
										<div class="col-md-3 col-sm-3 col-xs-12">
											<h3>Prix standard</h3>
										</div>
										<div class="col-md-6 col-sm-12 col-xs-12">
											<form method="post" >
												<input type="hidden" name="apdate_price" value="add">
												<input type="hidden" name="id" value="<?php echo $residence_prix['id'];?>">
												
												<div class="input-group warning">
													<span class="input-group-addon" style="width: 20%;">Lundi</span>
													<input type="text" class="form-control" name="prix_lun" value="<?php echo sprintf("%0.2F",($residence_prix['prix_lun'])); ?>" >
													<span class="input-group-addon">$</span>
												</div><br>
												
												<div class="input-group warning">
													<span class="input-group-addon" style="width: 20%;">Mardi</span>
													<input type="text" class="form-control" name="prix_mar" value="<?php echo sprintf("%0.2F",($residence_prix['prix_mar'])); ?>">
													<span class="input-group-addon">$</span>
												</div><br>
												
												<div class="input-group warning">
													<span class="input-group-addon" style="width: 20%;">Mercredi</span>
													<input type="text" class="form-control" name="prix_mer" value="<?php echo sprintf("%0.2F",($residence_prix['prix_mer'])); ?>">
													<span class="input-group-addon">$</span>
												</div><br>
												<div class="input-group warning">
													<span class="input-group-addon" style="width: 20%;">Jeudi</span>
													<input type="text" class="form-control" name="prix_jeu" value="<?php echo sprintf("%0.2F",($residence_prix['prix_jeu'])); ?>">
													<span class="input-group-addon">$</span>
												</div><br>
												<div class="input-group warning">
													<span class="input-group-addon" style="width: 20%;">Vendredi</span>
													<input type="text" class="form-control" name="prix_ven" value="<?php echo sprintf("%0.2F",($residence_prix['prix_ven'])); ?>">
													<span class="input-group-addon">$</span>
												</div><br>
												<div class="input-group primary">
													<span class="input-group-addon" style="width: 20%;">Samedi</span>
													<input type="text" class="form-control" name="prix_sam" value="<?php echo sprintf("%0.2F",($residence_prix['prix_sam'])); ?>">
													<span class="input-group-addon">$</span>
												</div><br>
												<div class="input-group primary">
													<span class="input-group-addon" style="width: 20%;">Dimanche</span>
													<input type="text" class="form-control" name="prix_dim" value="<?php echo sprintf("%0.2F",($residence_prix['prix_dim'])); ?>">
													<span class="input-group-addon">$</span>
												</div><br>
												
												<button type="submit" class="btn btn-primary  pull-right">Sauvegarder les modifications</button>
												
											</form>
										</div>
										<div class="col-md-3 col-sm-3 col-xs-12">
										</div>
									</div>
								</div>
							</div>
							</div>
						</section>
                        
						<section class="box ">
							<header class="panel_header">
								<h2 class="title pull-left">Prix personalisé</h2>
								<div class="actions panel_actions pull-right">
									<i class="box_toggle fa fa-chevron-down"></i>
									<!--	<i class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></i>
									<i class="box_close fa fa-times"></i>-->
								</div>
							</header>
							<div class="content-body" style="display: block;">    <div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="row"  style="margin-bottom:250px;" >
										<form method="post" >
											<h3>Ajouter un prix personalisé</h3>
											
											<input type="hidden" name="add_price" value="add">
											
											<div class="col-lg-3 col-md-4">
												<div class="form-group">
													<label class="" for="daterange-2">Intervalle de date</label>
													<input type="text" id="daterange-2" name="intervalle_date" class="form-control daterange" data-format="DD-MM-YYYY" data-start-date="<?php echo date('d-m-Y',strtotime("-1 month", time())) ?>" data-end-date="<?php echo date('d-m-Y',strtotime("+1 month", time())) ?>" data-separator="||" value="<?php if(isset($_POST['intervalle'])){ echo $_POST['intervalle'];}?>">
												</div>
											</div>
											
											<div class="col-md-6 col-sm-12 col-xs-12">
												<br>
												<div class="input-group warning">
													<span class="input-group-addon" style="width: 20%;">Lundi</span>
													<input type="text" name="lundi_prix_add" class="form-control"  >
													<span class="input-group-addon">$</span>
												</div><br>
												
												<div class="input-group warning">
													<span class="input-group-addon" style="width: 20%;">Mardi</span>
													<input type="text" name="mardi_prix_add" class="form-control">
													<span class="input-group-addon">$</span>
												</div><br>
												
												<div class="input-group warning">
													<span class="input-group-addon" style="width: 20%;">Mercredi</span>
													<input type="text" name="mercredi_prix_add" class="form-control" >
													<span class="input-group-addon">$</span>
												</div><br>
												<div class="input-group warning">
													<span class="input-group-addon" style="width: 20%;">Jeudi</span>
													<input type="text" name="jeudi_prix_add" class="form-control"  >
													<span class="input-group-addon">$</span>
												</div><br>
												<div class="input-group warning">
													<span class="input-group-addon" style="width: 20%;">Vendredi</span>
													<input type="text" name="vendredi_prix_add" class="form-control"  >
													<span class="input-group-addon">$</span>
												</div><br>
												<div class="input-group primary">
													<span class="input-group-addon" style="width: 20%;">Samedi</span>
													<input type="text" name="samedi_prix_add" class="form-control"  >
													<span class="input-group-addon">$</span>
												</div><br>
												<div class="input-group primary">
													<span class="input-group-addon" style="width: 20%;">Dimanche</span>
													<input type="text" name="dimanche_prix_add" class="form-control"  >
													<span class="input-group-addon">$</span>
												</div><br>
												
												<button type="submit" class="btn btn-primary  pull-right">Ajouter</button>
												
												
											</div>
											
											<div class="col-md-3 col-sm-3 col-xs-12"></div>	
											
											
											
										</form>
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
			
			
			
			
			
			
			
			
			
			
			
			
			
			<!-- General section box modal start -->
			<div class="modal" id="section-settings" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
				<div class="modal-dialog animated bounceInDown">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Section Settings</h4>
						</div>
						<div class="modal-body">
							
							Body goes here...
							
						</div>
						<div class="modal-footer">
							<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
							<button class="btn btn-success" type="button">Save changes</button>
						</div>
					</div>
				</div>
			</div>
			<!-- modal end -->
	</body>
</html>


<script type="text/javascript">
	
	
	$('input.icheck-custom').on('ifClicked', function(event){
		
		var val =$(this).attr('value');
		if(val==2){
			$('.lawyer_list').slideDown(500);
			//$('#company').attr('required', 'required');
			}else {
			$('.lawyer_list').slideUp(500); 
			//$('#company').removeAttr('required'); 
		}
		}).iCheck({
		checkboxClass: 'icheckbox_minimal',
		radioClass: 'iradio_minimal',
		increaseArea: '20%'
	});
	
	
	<!--multiple speciality-->
	$("#id_lang").select2({
		placeholder: 'Choisissez',
		allowClear: true
		}).on('select2-open', function() {
		// Adding Custom Scrollbar
		$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
	});
	$("#id_categorie").select2({
		placeholder: 'Choisissez...',
		allowClear: true
		}).on('select2-open', function() {
		// Adding Custom Scrollbar
		$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
	});
	
	
	<!---->
	
	
	$('#user-edit').validate({
		focusInvalid: false,
		ignore: "",
		rules: {
			classe: {
				required:true
			},
			username: {
				required:true
			},
			email: {
				
				email: true
				},password: {
				
				minlength: 6,
				maxlength: 12,
				
				},cpassword: {
				
				equalTo: "#password"
			}
		},
		
		invalidHandler: function(event, validator) {
			//display error alert on form submit    
		},
		
		errorPlacement: function(label, element) { // render error placement for each input type   
			console.log(label);
			$('<span class="error"></span>').insertAfter(element).append(label)
			var parent = $(element).parent().parent('.form-group');
			parent.removeClass('has-success').addClass('has-error');
		},
		
		highlight: function(element) { // hightlight error inputs
			var parent = $(element).parent().parent('.form-group');
			parent.removeClass('has-success').addClass('has-error');
		},
		
		unhighlight: function(element) { // revert the change done by hightlight
			
		},
		
		success: function(label, element) {
			var parent = $(element).parent().parent('.form-group');
			parent.removeClass('has-error').addClass('has-success');
		},
		
		
	});
	
	
	
	
</script>
