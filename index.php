<?php include_once "./includes/config.inc.php";

if(isset($_SESSION['User']['username'])) {
	redirect(ROOT_URL.'dashboard.php');
}

if($_POST) {
	// check user is valid
	if(!check_user($_POST['username'],$_POST['password'])) {
			$error = 'Invalid authentication details';
	}else{
        $user_role =$_SESSION['User']['role'];
           if($user_role == "superadmin") {
            redirect(ROOT_URL.'dashboard.php');
           }else if($user_role == "blogger") {
            redirect(ROOT_URL.'manage-blog.php');
           }
           else{
            redirect(ROOT_URL.'liste-des-demandes.php');
           }
           




	}
    
}
?>
<!DOCTYPE html>
<html class="">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title> Hydrex International </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

        <!-- CORE CSS FRAMEWORK - START -->
        <link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <link href="assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS FRAMEWORK - END -->

        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <link href="assets/plugins/icheck/skins/square/orange.css" rel="stylesheet" type="text/css" media="screen"/>        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 

        <!-- CORE CSS TEMPLATE - START -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->

    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class="login_page">

        <div class="login-wrapper">
            
            <div class="login-content">
                <div class="login-logo">
                    <a href="#">
                        <img src="images/logo-hydrex-200.png" alt="Hydrex">
                    </a>
                </div>
                <div class="login-form">
                     <form name="loginform" id="loginform" method="post" action="index.php">
                        <?php echo notification(); ?>
                        <?php if (isset($error)){   ?>
                            <div class="alert alert-error alert-dismissible fade in">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                              <strong>Erreur!</strong><?php  echo '<p>',$error,'</p>';  ?>
                            </div> 
                        <?php }?>
                            <div class="form-group">
                                <label for="username">Nom d'utilisateur </label>
                                <input type="text" name="username" id="username" class="input au-input" size="20" />
                            </div>
                            <div class="form-group">
                                <label for="password">Mot de passe </label>
                                <input type="password" name="password" id="password" class="input au-input" size="20" />
                            </div>
 
                            <div class="row form-group">
                            <div class="col-md-12 submit">
                                <button type="submit" name="wp-submit" id="wp-submit" class="btn btn-orange btn-block btn-login"> Se connecter</button>
                            </div>
                            </div>
                        </form>       
                </div>
            </div>

            <p id="nav" class="hidden">
                <a class="pull-left" href="#" title="Password Lost and Found">Mot de passe oublié?</a>
            </p>
 
        </div>





        <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->


        <!-- CORE JS FRAMEWORK - START --> 
        <script src="assets/js/jquery-1.11.2.min.js" type="text/javascript"></script> 
        <script src="assets/js/jquery.easing.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>  
        <script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>  
        <!-- CORE JS FRAMEWORK - END --> 


        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <script src="assets/plugins/icheck/icheck.min.js" type="text/javascript"></script><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


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
