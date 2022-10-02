<?php
include_once './includes/config.inc.php';
 
// Authenticate user login
auth();

$id_demande = $_GET['id'];

$demande = $db->get_row("SELECT demandes.* FROM demandes WHERE demandes.id=".$id_demande);

$client = $db->get_row("SELECT clients.* FROM clients WHERE clients.id=".$demande['id_client']);

$composants = $db->get_rows("SELECT composants.* FROM composants WHERE composants.id_demande = ".$demande['id']);




?>
<!DOCTYPE html>
<html class=" ">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Hydrex</title>
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
                                <h2 class="title">Détails de la demande</h2>
                            </header>

                            <div class="content-body">
                                <div class="row">
                                     
                                     <div class="row form-group">
                                        <div class="col-sm-2"></div>
                                        <label for="fullname" class="col-sm-3 control-label">Client</label>
                                        <div class="col-sm-6">
                                           <label class="control-label">
                                               <?php echo $client['firstName']." ".$client['lastName']; ?>
                                           </label>
                                      </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-sm-2"></div>
                                        <label for="email" class="col-sm-3 control-label">Référence</label>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                   <?php echo $demande['ref']; ?>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-sm-2"></div>
                                        <label for="email" class="col-sm-3 control-label">Titre</label>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                   <?php echo $demande['titre']; ?>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-sm-2"></div>
                                        <label for="email" class="col-sm-3 control-label">Emballage</label>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                   <?php echo $demande['emballage']; ?>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-sm-2"></div>
                                        <label for="email" class="col-sm-3 control-label">Date de réception</label>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                <?php echo date("d/m/Y", strtotime($demande['date'])); ?>
                                            </label>
                                        </div>
                                    </div>

                                    <?php  if($demande['statut'] == 'validé'){ ?>
                                    <div class="row form-group">
                                        <div class="col-sm-2"></div>
                                        <label for="email" class="col-sm-3 control-label">Date de traitement</label>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                <?php echo date("d/m/Y", strtotime($demande['datetrai'])); ?>
                                            </label>
                                        </div>
                                    </div>
                                     <?php } ?>

                                    <div class="row form-group">
                                        <div class="col-sm-2"></div>
                                        <label for="passwordconfirm" class="col-sm-3 control-label">Composants</label>
                                        <div class="col-sm-6">
                                            <table cellspacing="0" id="table-product" class="table table-small-font table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Quantite</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($composants as $key => $composant) {   
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $composant['nom_composant']; ?></td>
                                                            <td><?php echo $composant['quantite']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                      </div>
                                  </div>

                                  <div class="row form-group">
                                    <div class="col-sm-2"></div>
                                    <label for="fullname" class="col-sm-3 control-label">Titre</label>
                                    <div class="col-sm-6">
                                        <label class="control-label">
                                            <?php echo $demande['titre']; ?>
                                        </label>
                                     </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-2"></div>
                                <label for="fullname" class="col-sm-3 control-label">Statut</label>
                                <div class="col-sm-6">
                                    <label class="control-label">
                                  <?php
                                  
                                    if($demande['statut'] == 'validé'){
                                         $statut = '<span class="badge badge-success">Traitée</span>'; 
                                    }else{
                                        $statut =  '<span class="badge badge-warning">En attente</span> <input type="checkbox" data-object="demandes" value="'.$demande['id'].'"';
                                        $statut .= 'class="iswitch iswitch-md iswitch-primary" onclick="valider_demande(\''.$demande['id'].'\');" id="input--'.$demande['id'].'"> '; 
                                    }

                                    echo $statut;
                                  ?>
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

     <!--Valider la demande -->
        <div class="modal fade" id="valid-client">
            <div class="modal-dialog" style="width:40%;">
                <div class="modal-content">
                    <input type="hidden" id="idemande">
                    <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="annlerDemande()">&times;</button>
                            <h4 class="modal-title">Valider la demande </h4>
                    </div>
                    <div class="modal-body" > Voulez-vous changer le statut de la commande en "Traitée " ? </div>
                    <div class="modal-footer"> 
                        <button type="button" class="btn btn-white" data-dismiss="modal" onclick="annlerDemande()">Annuler</button>
                        <button type="submit" id="submit-edit" class="btn btn-info" onclick="validerDemande();">Valider</button>
                    </div>
                </div>
            </div>
        </div>


<script type="text/javascript">
    
    function annlerDemande(){
                        location.reload();
                    }

    function validerDemande(){
                        var id = $("#idemande").val();
                        var object = 'demandes';
                        $.ajax({
                            type: "GET",
                            dataType:"html",
                            url: "./includes/change-statut-demandes.php?object="+object+"&id="+id,
                            success: function(data){
                                if(data.match('success') != null){
                                    showSuccess('La demande a été validé');
                                       setTimeout(function(){ location.reload(); }, 3000);
                                }else{
                                    showErrorMessage(data)
                                }
                                $('#valid-client').modal('hide');
                            }
                        });
                    }

    function valider_demande(id)
    {
                        $('#valid-client').data('bs.modal',null);
                        jQuery('#valid-client').modal('show', {backdrop: 'static',keyboard: false});
                        $("#idemande").val(id);
                        $('#valid-client').data('bs.modal').options.backdrop = 'static';
                    }
</script>

    </body>
</html>
                                                                