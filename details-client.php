

<?php
include_once './includes/config.inc.php';
 
// Authenticate user login
auth();
 
$client = $db->get_row("SELECT clients.* FROM clients WHERE clients.id=".$_GET['id']);
 
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
            .badge-warning{
                float: left;
                position: relative;
                top: 4px;
            }

            input[type="checkbox"].iswitch-md {
                margin-left: 15px;
            }

            .left-text{
                color: #000;
                font-size: 15px;
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
 

                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'> <?php echo notification(); ?> </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12">
                        <section class="box ">
                    
                            <header class="panel_header">
                                <h2 class="title">Détails du client</h2>
                            </header>

                            <div class="content-body">
                                <div class="row">
                                     
                                     <div class="row form-group">
                                        <div class="col-sm-2"></div>
                                        <label for="fullname" class="col-sm-3 control-label left-text">Nom et prénom</label>
                                        <div class="col-sm-6">
                                           <label class="control-label">
                                               <?php echo $client['firstName']." ".$client['lastName']; ?>
                                           </label>
                                      </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-sm-2"></div>
                                        <label for="email" class="col-sm-3 control-label left-text">E-mail</label>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                   <?php echo $client['email']; ?>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-sm-2"></div>
                                        <label for="email" class="col-sm-3 control-label left-text">Activité</label>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                <?php echo $client['activity']; ?>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="row form-group">
                                        <div class="col-sm-2"></div>
                                        <label for="passwordconfirm" class="col-sm-3 control-label left-text">Société</label>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                            <?php echo $client['societe']; ?>
                                            </label>
                                      </div>
                                  </div>

                                  <div class="row form-group">
                                    <div class="col-sm-2"></div>
                                    <label for="fullname" class="col-sm-3 control-label left-text">Adresse</label>
                                    <div class="col-sm-6">
                                        <label class="control-label">
                                            <?php echo $client['address']; ?>
                                        </label>
                                     </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-sm-2"></div>
                                        <label for="fullname" class="col-sm-3 control-label left-text">Adresse de livraison</label>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                <?php echo $client['adressliv']; ?>
                                            </label>
                                         </div>
                                    </div>
                            

                                    <div class="row form-group">
                                        <div class="col-sm-2"></div>
                                        <label for="fullname" class="col-sm-3 control-label left-text">Pays</label>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                <?php echo $client['country']; ?>
                                            </label>
                                         </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-sm-2"></div>
                                        <label for="fullname" class="col-sm-3 control-label left-text">Ville</label>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                <?php echo $client['ville']; ?>
                                            </label>
                                         </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-sm-2"></div>
                                        <label for="fullname" class="col-sm-3 control-label left-text">Code postal</label>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                <?php echo $client['cplocalite']; ?>
                                            </label>
                                         </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-sm-2"></div>
                                        <label for="fullname" class="col-sm-3 control-label left-text">Numéro de téléphone</label>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                <?php echo $client['phone']; ?>
                                            </label>
                                         </div>
                                    </div>

                                </div>
                            </div>
                            <!--*********************************************** --> 
                            
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
        
        <!-- <script src="assets/plugins/bootstrap3-wysihtml5/js/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>-->
        
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
        
        
        <script src="ckeditor/ckeditor/ckeditor.js"></script>
        <script src="ckeditor/js/sample.js"></script>
        
        <script src="assets/plugins/uikit/js/uikit.min.js" type="text/javascript"></script><script src="assets/plugins/uikit/js/components/nestable.min.js" type="text/javascript"></script><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 
        
        
        <script src="assets/plugins/responsive-tables/js/rwd-table.min.js" type="text/javascript"></script><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 
        
        <!-- messenger -->
        <script src="assets/plugins/messenger/js/messenger.min.js" type="text/javascript"></script><script src="assets/plugins/messenger/js/messenger-theme-future.js" type="text/javascript"></script><script src="assets/plugins/messenger/js/messenger-theme-flat.js" type="text/javascript"></script><script src="assets/js/messenger.js" type="text/javascript"></script><!-- /messenger --> 
        
        <script src="assets/js/scripts.js" type="text/javascript"></script>
        
        <?php include_once 'js/js-folder.php';?>
        
        <!-- Sidebar Graph - START --> 
        <script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script> 
        <script src="assets/js/chart-sparkline.js" type="text/javascript"></script>
 

 
    </body>
</html>
                                                                