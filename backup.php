<?php
	include_once './includes/config.inc.php';
	// Authenticate user login
	auth();
	
if(isset($_GET['action']) && $_GET['action']=='delete') {
	$file_info = new SplFileInfo($_GET['file']);
   if(is_file($_GET['file']) && $file_info->getExtension()=='gz' )unlink($_GET['file']);
	$_SESSION['notification'] = array('type'=>'success','msg'=>'Le sauvgarde a été supprimé avec succès');
redirect(ROOT_URL.'backup.php');
}
?>
<!DOCTYPE html>
<html class=" ">
		<head>
		<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
		<meta charset="utf-8" />
		<title> SIBEC Fixation & Supportage</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />
		<!-- Favicon -->
		<link rel="apple-touch-icon-precomposed" href="assets/images/apple-touch-icon-57-precomposed.png">
		<!-- For iPhone -->
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/apple-touch-icon-114-precomposed.png">
		<!-- For iPhone 4 Retina display -->
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/apple-touch-icon-72-precomposed.png">
		<!-- For iPad -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/apple-touch-icon-144-precomposed.png">
		<!-- For iPad Retina display -->

		<!-- CORE CSS FRAMEWORK - START -->
		<link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		<link href="assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
		<link href="assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
		<!-- CORE CSS FRAMEWORK - END -->

		<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
		<link href="assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/datatables/css/jquery.dataTables.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/datatables/extensions/TableTools/css/dataTables.tableTools.min.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" type="text/css" media="screen"/>
		<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->

		<!-- messenger -->
		<link href="assets/plugins/messenger/css/messenger.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/messenger/css/messenger-theme-future.css" rel="stylesheet" type="text/css" media="screen"/>
		<link href="assets/plugins/messenger/css/messenger-theme-flat.css" rel="stylesheet" type="text/css" media="screen"/>
		<!-- END -->

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

		<!-- CORE CSS TEMPLATE - START -->
		<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
		<link href="assets/css/responsive.css" rel="stylesheet" type="text/css"/>
		<!-- CORE CSS TEMPLATE - END -->
		<style>
.company {
	display: none;
}
</style>
 <script>
        function delFile(file){

            var a = confirm("Voulez vous vraiment supprimer cette sauvegarde!");
            if(a){
                document.location.href='?action=delete&file='+file;
            }

        }
    </script>
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
        <div class="page-title">
                  <div class="pull-left">
            <h1 class="title">Sauvgarde de la base de données</h1>
          </div>
                </div>
      </div>
             
              <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'> <?php echo notification(); ?> </div>
              <div class="clearfix"></div>
              <div class="col-lg-12">
        <section class="box ">
                  <header class="panel_header">
            <h2 class="title pull-left">Sauvegarde de la Base de données</h2>
            <div class="actions panel_actions pull-right">
            <button  type="button" id="sauvgardeBd" class="btn btn-default navbar-btn"> <i class="fa fa fa-database"></i> Sauvgarder la base</button>
             <!--<i class="box_toggle fa fa-chevron-down"></i> <i class="box_close fa fa-times"></i>--> </div>
          </header>
                  <div class="content-body">
            <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12"> 
                <!-- ********************************************** -->
      <?          
                if(isset($_GET['backup_database'])) {
				  new BackupMySQL(array(
					  'host' => HOSTNAME,
					  'username' => DB_USERNAME,
					  'passwd' => DB_PASSWORD,
					  'dbname' => DB_NAME,
					  'dossier' => './backup/'
					  )); 
				  redirect(ROOT_URL.'backup.php');
				  }
 foreach (glob("backup/*.sql.gz") as $filename) {?>

                                       <div class="well">
                                         Sauvegarde prise le <?=substr($filename,19,2)."/".substr($filename,17,2)."/".substr($filename,13,4)." à ".substr($filename,22,2).":".substr($filename,24,2).":".substr($filename,26,2)?>                
                                         
                                        <a class="btn btn-danger btn-icon bottom15 right15" href="javascript:delFile('<?=$filename?>')" style="float: right;">
                                            <i class="fa fa fa-trash-o"></i> &nbsp; <span>Supprimer</span>
                                        </a>
                                         <a class="btn btn-success btn-icon bottom15 right15" href="<?=$filename?>" style="float: right;">
                                            <i class="fa fa fa-download"></i> &nbsp; <span>Télécharger</span>
                                        </a>
                                       
                                        </div>
										
										<? } ?>
              </div>
                    </div>
          </div>
                  <!--  *********************************************** --> 
                  
                </section>
      </div>
              
              <!----> 
              
            </section>
  </section>
          <!-- END CONTENT -->
          
          <div class="chatapi-windows "> </div>
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

<script src="assets/plugins/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script> 
<script src="assets/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script> 
<script src="assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js" type="text/javascript"></script> 
<script src="assets/plugins/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.js" type="text/javascript"></script> 
<script src="assets/plugins/autosize/autosize.min.js" type="text/javascript"></script> 
<script src="assets/plugins/icheck/icheck.min.js" type="text/javascript"></script> 
<!--<script src="assets/plugins/jquery-ui/smoothness/jquery-ui.min.js" type="text/javascript"></script>--> 
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

<!-- messenger -->
<script src="assets/plugins/messenger/js/messenger.min.js" type="text/javascript"></script><script src="assets/plugins/messenger/js/messenger-theme-future.js" type="text/javascript"></script><script src="assets/plugins/messenger/js/messenger-theme-flat.js" type="text/javascript"></script><script src="assets/js/messenger.js" type="text/javascript"></script><!-- /messenger --> 

<script src="assets/js/scripts.js" type="text/javascript"></script>
<?php include_once 'js/js-folder.php';?>

<!-- Sidebar Graph - START --> 
<script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script> 
<script src="assets/js/chart-sparkline.js" type="text/javascript"></script>
<script type="text/javascript">
$( "#sauvgardeBd" ).click(function() {
  $.get('includes/backupBd.php?backup_database', function(data){
   $(".content-body div div").html(data);
  window.setTimeout(function () {$('#etat_sauv').hide();}, 2000);
	});
});
</script>