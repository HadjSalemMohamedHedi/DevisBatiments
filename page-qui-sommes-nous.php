<?php
	include_once './includes/config.inc.php';
	include_once './includes/validate-user.php';
	
	// Authenticate user login
	auth();
	
	validate_user_add();
	
	$langs= $db->get_rows("SELECT lang.* FROM lang WHERE lang.active='1'");
	
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
        <title>  SIBEC Fixation & Supportage</title>
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
		<link rel="stylesheet" href="ckeditor/toolbarconfigurator/lib/codemirror/neo.css">
		
		
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
					<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
						<?php echo notification(); ?>
					</div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title pull-left">Ajouter utilisateur </h2>
                                
							</header>
                            <div class="content-body"> 
                            	<div class="row">
									
                                    <form class="form-horizontal" method="post" action='./users-add.php' role="form" parsley-validate id="user-edit">
										
										
										<div class="row">
											<div class="col-md-12">
												
												<ul class="nav nav-tabs transparent">
													<li class="active">
														<a href="#desc-fr" data-toggle="tab">
														Contenue FR
														</a>
													</li>
													<li>
														<a href="#desc-en" data-toggle="tab">
														Contenue EN
														</a>
													</li>
													
												</ul>
												
												<div class="tab-content transparent">
													<div class="tab-pane fade in active" id="desc-fr">
														<div class="form-group">
															<label for="fullname" class="col-sm-3 control-label">Titre FR: *</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="titre_fr" id="titre_fr"   value="<?php echo $fields['username']['value']; ?>">
															</div>
														</div>
														<div>
															<textarea  id="editor_fr" name="description_fr" class="bootstrap-wysihtml5-textarea" placeholder="Entrer la description du produit ..." style="width: 100%; height: 150px; font-size: 14px; line-height: 23px;padding:15px;"></textarea>
														</div>
													</div>
													<div class="tab-pane fade" id="desc-en">
														<div class="form-group">
															<label for="fullname" class="col-sm-3 control-label">Titre EN: *</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="titre_fr" id="titre_fr"   value="<?php echo $fields['username']['value']; ?>">
															</div>
														</div>
														<textarea  id="editor_en" name="description_en" class="bootstrap-wysihtml5-textarea" placeholder="Enter the product description ..." style="width: 100%; height: 150px; font-size: 14px; line-height: 23px;padding:15px;"></textarea>
													</div>
												</div>
											</div>
											
										</div>
										
										
										
										
										
										
										
										
										
										<div class="form-group form-footer">
											<div class="col-sm-offset-10 col-sm-4">
												<button type="submit" class="btn btn-primary">Valider</button>
												
											</div>
										</div>
										
									</form>
									
								</div>
							</div>
						</section></div>
						
				</section>
			</section>
            <!-- END CONTENT -->
            
			
			
		</div>
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
		
		
		
		
		
		
		<script src="ckeditor/ckeditor/ckeditor.js"></script>
		<script src="ckeditor/js/sample.js"></script>
		
		
		
		
		
		
		
        <!-- General section box modal start -->
		
        <!-- modal end -->
	</body>
</html>


<script type="text/javascript">
	
	
	initSample('_fr');
	initSample('_en');                      
	
</script>
