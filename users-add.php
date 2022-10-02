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
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title> Hydrex</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

    <!-- START TOPBAR -->
    <?php include ROOT."includes/lien-css.php"; ?>
    <!-- END TOPBAR --> 

    <style>
        .company {
            display: none;
        }
        .infos-client {
            cursor: pointer;
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
                <section class="wrapper">

                    <?php if(!isset($_GET['trash'])){?>
                        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                            <div class="page-title">
                                <nav class="navbar-default">
                                    <div class="container-fluid">
                                        <h1 class="title">Ajouter utilisateur</h1>
                                    
                                    </div>
                                    <!-- /.container-fluid --> 
                                </nav>
                            </div>
                        </div>
                    <?php }?>

                     <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'> <?php echo notification(); ?> </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12">
                        <section class="box ">
                         
                            <div class="content-body"> 
                            	<div class="row">

                                    <form class="form-horizontal" method="post" action='./users-add.php' role="form" parsley-validate id="user-edit">
                      
                      <div class="form-group">
                        <label for="fullname" class="col-sm-3 control-label">Nom d'utilisateur: *</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="username" id="username" parsley-trigger="change" parsley-required="true" parsley-minlength="4" parsley-validation-minlength="1" value="<?php echo $fields['username']['value']; ?>">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Mot de passe: *</label>
                        <div class="col-sm-6">
                          <input type="password" class="form-control" name='password' id='password'  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Doit contenir au moins un chiffre et une lettre majuscule et minuscule, et au moins 8 caractères ou plus" required>
                        </div>
                      </div>

                     

                      <div class="form-group">
                        <label for="passwordconfirm" class="col-sm-3 control-label">Confirmer mot de passe:*</label>
                        <div class="col-sm-6">
                          <input type="password" class="form-control" name='cpassword' id='cpassword' parsley-equalto="#password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Doit contenir au moins un chiffre et une lettre majuscule et minuscule, et au moins 8 caractères ou plus" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="fullname" class="col-sm-3 control-label">Nom :</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="firstname" id="firstname" parsley-trigger="change"  value="<?php echo $fields['firstname']['value']; ?>">
                        </div>
                      </div>
                       <div class="form-group">
                        <label for="fullname" class="col-sm-3 control-label">Prenom :</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="lastname" id="lastname" parsley-trigger="change"  value="<?php echo $fields['lastname']['value']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="fullname" class="col-sm-3 control-label">Adresse :</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="address" id="address" parsley-trigger="change"  value="<?php echo $fields['address']['value']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="fullname" class="col-sm-3 control-label">Email :</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" name="email" id="email" parsley-trigger="change"  value="<?php echo $fields['email']['value']; ?>" parsley-type="email">
                        </div>
                      </div>


                      

                      <div class="form-group">
                        <label for="classe" class="col-sm-3 control-label">Classe *</label>
                        <div class="col-sm-6" id="selectbox">
                          <select class="form-control" name="role" id="classe" parsley-trigger="change" parsley-required="true" parsley-error-container="#selectbox">
                          <!--   <option value="1" <?php if($fields['classe']['value']=='1'){ ?>selected <?php }?>>Administrateur</option> -->
                            <option value="superadmin">Administrateur</option>
                          </select>
                        </div>
                      </div>

                      

                      <div class="form-group form-footer">
                        <div class="col-sm-offset-8 col-sm-4">
                          <button type="submit" class="btn btn-primary">Valider</button>
                          
                        </div>
                      </div>

                    </form>




                                </div>
                            </div>
                        </section></div>
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
				role: {
					required:true
                },
				username: {
					required:true
                },
				email: {
					
                    email: true
                },password: {
					required:true,
                    minlength: 6,
					maxlength: 45,
                    
                },cpassword: {
                    required:true,
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
