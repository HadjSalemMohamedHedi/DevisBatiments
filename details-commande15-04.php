<?php
include_once './includes/config.inc.php';
 

$id_commande = $_GET['id'];
$commande= $db->get_row("SELECT ordered_hx.* FROM ordered_hx WHERE id=".$id_commande);
$client = $db->get_row("SELECT clients.* FROM clients WHERE clients.id=".$commande['id_client']);

$produits = $db->get_rows("SELECT produit_commande.* FROM produit_commande WHERE id_commande = ".$commande['id']);

$livraison =   $commande['counts_liv'];
$toto = explode("€", $commande['total']);
$total = $toto[0] + $livraison;
?>
<!DOCTYPE html>
<html class=" ">
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Hydrex International</title>
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
            .title-item{ padding: 15px; }
            .form-infos {
                display: -webkit-inline-box;
                width: 100%;
                border-bottom: 1px solid #eee;
                    margin-bottom: 10px;
            }
            .form-infos h4 {
                margin-right: 20px;
                    font-size: 15px;
                        color: #2f3338;
            }
            .big-title{ color: #e30613;font-weight: 600; }
            .list_produits{
                background: #f3f3f3;
                padding: 15px;
                color: #000;
                border-radius: 2px;
                /*margin-top: 20px;*/
            }
            .list_produits .form-infos{  border-bottom: 1px solid #b3b3b3; }
            .list_produits .form-infos h4{ color: #000; }
            .row_valid {
                margin-top: 21px;
                margin-bottom: 15px;
                padding-bottom: 10px;
            }
            .row_valid button {
                outline: none !important;
                border: none !important;
            }
            .form-total b{ 
                color: #000000;
                font-size: 18px;
                font-weight: 600;
            }
            .form-total h4{ 
               color: #e30613;
               font-size: 18px;
               font-weight: 600;
           }
           .form-total {
                text-align: right;
                margin-top: 30px;
            }
            .cmd-success {
                background: #0e5ba7;
                color: #fff;
                padding: 8px 20px;
                position: relative;
                top: 6px;
                right: 10px;
                border-radius: 2px;
            }
            .cmd-new{
                color: #fff;
                padding: 8px 20px;
                border-radius: 2px;
                float: left;
            }
            .top-title{  min-height: 80px; }
            #FicheExpe{             
               display: none
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
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'> <?= notification(); ?> </div>
                    <div class="clearfix"></div>
                    <input type="hidden" id="id_commande" value="<?= $commande['id']; ?>">
                    <div class="row m-t-25">
                        <div class="col-sm-12 col-lg-12">
                            <div class="overview-item title-item top-title">
                                <h2 class="title col-md-3">Détails de la commande</h2>
                                    <?php if($commande['state'] == 'En préparation'){ ?>
                                        <h4 class="col-md-9"><span class="cmd-new  badge-danger">Commande En préparation </span></h4>
                                    <?php } else if($commande['state'] == 'Expédié'){ ?>
                                        <h4 class="col-md-9"><span class="cmd-new badge-warning">Commande expédié </span></h4>
                                    <?php }else{ ?>
                                        <h4 class="col-md-9"><span class="cmd-success">Commande livrée</span></h4>
                                <?php } ?> 
                            </div>

                        </div>
                    </div>
                    <div class="row m-t-25">

                        <div class="col-sm-6 col-lg-6">
                            <div class="overview-item"> 

                                <div class="row m-t-25" style="margin-bottom: 30px;">
                                    <div class="col-sm-6 col-lg-6">
                                        <?php if ($commande['state'] == 'En préparation') { ?>
                                            <input type="checkbox" data-object="ordered_hx" value="<?= $commande['id']; ?>"
                                            class="iswitch iswitch-md iswitch-primary" ><h5 class="rouge" style="font-weight: 600;margin: 0"> Changer en expédié </h5> 
                                        <?php }else if ($commande['state'] == 'Expédié') { ?>
                                            <button type="button" class="btn btn-info btn-exp" data-toggle="modal" data-target="#modal-valid-commande" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Cliquer pour confirmer la livraison de la commande" data-placement="top" data-id="<?= $commande['total']; ?>">Confirmer la livraison</button>
                                         <?php } ?>
                                    </div>
                                    <div class="col-sm-6 col-lg-6 text-right">
                                        <button class="btn btn-default" 
                                        rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Cliquer pour imprimer la facture" data-placement="top"
                                        onclick="PrintElem('right-item')"><i class="fa fa-print"></i>  Imprimer la facture</button>
                                         <button id="submit"
                                         rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Cliquer pour télcharger le pdf" data-placement="top"
                                         ><i class="fa fa-file-pdf-o"></i> Télcharger le pdf</button>

                                    </div> 

                                </div>

                                 <div>
                                    <h3 class="big-title">Information de la commande</h3>
                                    <div class="form-group form-infos">
                                        <h4><b>Référence: </b></h4><h4><?= $commande['ref_commande']; ?></h4>
                                    </div>
                                    <div class="form-group form-infos">
                                        <h4><b>La date de création: </b></h4><h4><?= date("d/m/Y", strtotime($commande['date_create'])); ?></h4>
                                    </div> 
                                    <div class="form-group form-infos">
                                        <h4><b>Type de livraison: </b></h4><h4><?= $commande['type_livraison']; ?></h4>
                                    </div>
                                    <div class="list_produits"  style="height: 600px;overflow-x: scroll;">
                                        <h3 class="big-title">Liste des produits</h3>
                                        <table class="table table-small-font table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Code article</th>
                                                    <th>Désignation</th>
                                                    <th>Qte</th>
                                                    <th>Prix</th>
                                                    <th>Unité</th>
                                                    <th>Etat</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($produits as $produit) { 
                                                    $s_product= $db->get_row("SELECT sous_products_table.* FROM sous_products_table WHERE id=".$produit['id_sub_produit']);
                                                    ?>
                                                    <tr>
                                                        <td><?= $s_product['code_article']; ?></td>
                                                        <td><?= $s_product['designation']; ?></td>
                                                        <td><?= $produit['quantite']; ?></td>
                                                        <td><?= $s_product['prix_final']." €"; ?></td>
                                                        <td><?= $s_product['unite']; ?></td>
                                                        <td>
                                                            <?php
                                                                if ($produit['quantite'] == 0) {
                                                                   echo "<span class='badge-danger'>Épuisé </span>";
                                                                }else{
                                                                    echo "<span class='badge-success'>Disponible</span>";
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table> 
                                    </div>
                                    <div class="form-group form-total"> 
                                        <h4><b>Total: </b> <?= $commande['total']; ?></h4>
                                    </div>
                                </div>   
                                
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-6">
                            <div class="overview-item">
                             <div class="col-sm-6 col-lg-6">

                                <h3 class="big-title">Information du clients</h3>
                            </div>

                                <div class="col-sm-6 col-lg-6 text-right">
                                        <button class="btn btn-default" onclick="PrintElem('FicheExpe')"rel="tooltip" data-animate=" animated tada" data-toggle="tooltip"
                                        data-original-title="Imprimer la fiche expédition"
                                        ><i class="fa fa-print"></i> Imprimer la fiche expédition</button>
                                    </div> 

                                    <div id="FicheExpe">
                                        <div class="row" style="height: 60px"> 
                                            <div class="col-md-4" style="float: left;">
                                                <img src="images/logo-hydrex-200.png" class="img-responsive img_logo logo-nav">    
                                            </div> 
                                            <div class="col-md-8">
                                               <h3 class="big-title">Fiche d'expédition</h3>
                                        
                                            </div>
                                        </div> 
                                      
                                      
                              
                              
                                      <div class="form-group form-infos">
                                    <h4><b>Référence: </b></h4><h4><?= $commande['ref_commande']; ?></h4>
                                </div>
                           
                              <div style="display: flex">
                                       <div class="form-group form-infos" style="width: 50%">
                                    <h4><b>Nom: </b></h4><h4><?= $client['lastName']; ?></h4>
                                </div>
                               
                                       <div class="form-group form-infos" style="width: 50%">
                                    <h4><b>Prénom: </b></h4><h4><?= $client['firstName']; ?></h4>
                                </div>
                               
                              </div>
                               

                                
                              
                                  <div class="form-group form-infos">
                                    <h4><b>Numéro de téléphone: </b></h4><h4><?= $client['phone']; ?></h4>
                                </div>
                                 <div class="form-group form-infos">
                                <h4><b>Adresse: </b></h4><h3 style="margin-top: 5px;font-weight: 100;margin-right: 10px;margin-bottom: 5px;"><?= $client['address']; ?>
                                ,  <?= $client['country']; ?> , <?= $client['ville']; ?>.</h3><br>                              
                            </div>
                                <div class="form-group form-infos">
                                    <h4><b>Adresse e-mail: </b></h4><h4><?= $client['email']; ?></h4>
                                </div>


                                    <h6 style="border-bottom: 1px dashed #000;text-align: center;">
                                        Hydrex International : 37, Rue Jeannette Ponteille, 69550 Amplepuis - France
                                    </h6>
                                 
                              

                                    </div>

                                <div class="form-group form-infos">
                                    <h4><b>Nom: </b></h4><h4><?= $client['lastName']; ?></h4>
                                </div>
                                <div class="form-group form-infos">
                                    <h4><b>Prénom: </b></h4><h4><?= $client['firstName']; ?></h4>
                                </div>
                                <div class="form-group form-infos">
                                    <h4><b>Adresse e-mail: </b></h4><h4><?= $client['email']; ?></h4>
                                </div>
                              <!--   <?php if($client['email2'] != ""){ ?>
                                    <div class="form-group form-infos">
                                        <h4><b>Adresse e-mail de contact: </b></h4><h4><?= $client['email2']; ?></h4>
                                    </div>
                                <?php } ?>  -->
                                <div class="form-group form-infos">
                                    <h4><b>Numéro de téléphone: </b></h4><h4><?= $client['phone']; ?></h4>
                                </div>
                                <div class="form-group form-infos">
                                    <h4><b>Adresse: </b></h4><h4><?= $client['address']; ?></h4>
                                </div>
                                <div class="form-group form-infos">
                                    <h4><b>Adresse de livraison: </b></h4><h4><?= $client['adressliv']; ?></h4>
                                </div>
                                <div class="form-group form-infos">
                                    <h4><b>Société: </b></h4><h4><?= $client['societe']; ?></h4>
                                </div>
                                <div class="form-group form-infos">
                                    <h4><b>Activité: </b></h4><h4><?= $client['activity']; ?></h4>
                                </div>
                                <div class="form-group form-infos">
                                    <h4><b>Pays: </b></h4><h4><?= $client['country']; ?></h4>
                                </div>
                                <div class="form-group form-infos">
                                    <h4><b>Ville: </b></h4><h4><?= $client['ville']; ?></h4>
                                </div>
                                <div class="form-group form-infos">
                                    <h4><b>Code Postal: </b></h4><h4><?= $client['cplocalite']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                           

                    <div id="right-item" style="display: none;position: relative;">
                        <div class="row" style="height: 60px"> 
                            <div class="col-md-6" style="float: left;">
                                <img src="images/logo-hydrex-200.png" class="img-responsive img_logo logo-nav">    
                            </div> 
                       </div> 

                       <div class="infos-client">
                            <h3 class="big-title">FACTURE</h3> 
                            <div class="form-group form-infos">
                                <h4 style="font-size: 16px;color: #e30613;"><b>Référence: </b></h4> 
                                <h3 style="font-size: 16px;margin-top: 5px;margin-bottom: 5px;color: #e30613;"><?= $commande['ref_commande']; ?></h3>
                            </div>
                            <div class="form-group form-infos">
                                <h4><b>Client : </b></h4>
                                <h3 style="margin-top: 5px;font-weight: 100;margin-bottom: 5px;"><?= $client['lastName']; ?> <?= $client['firstName']; ?></h3>
                            </div>
                        <!--     <div class="form-group form-infos">
                                <h4><b>Adresse e-mail: </b></h4><h3 style="margin-top: 5px;font-weight: 100;margin-bottom: 5px;"><?= $client['email']; ?></h3>
                            </div>  -->
                            <div class="form-group form-infos">
                                <h4><b>Adresse: </b></h4><h3 style="margin-top: 5px;font-weight: 100;margin-right: 10px;margin-bottom: 5px;"><?= $client['address']; ?>
                                ,  <?= $client['country']; ?> , <?= $client['ville']; ?></h3><br>                              
                            </div>
                            <div class="form-group form-infos">
                              <h4><b>Adresse de livraison: </b></h4><h3 style="margin-top: 5px;font-weight: 100;margin-bottom: 5px;"><?= $client['adressliv']; ?></h3>
                          </div>
                          <!--   <div class="form-group form-infos">
                                <h4><b>Société: </b></h4><h3 style="margin-top: 5px;font-weight: 100;margin-right: 10px;margin-bottom: 5px;"><?= $client['societe']; ?></h3><h4><b>Activité: </b></h4><h3 style="margin-top: 5px;font-weight: 100;margin-bottom: 5px;"><?= $client['activity']; ?></h3>
                            </div>  -->
                          <!--   <div class="form-group form-infos">
                                <h4><b>Pays: </b></h4><h3 style="margin-top: 5px;font-weight: 100;margin-right: 10px;margin-bottom: 5px;"><?= $client['country']; ?></h3><h4><b>Ville: </b></h4>
                                <h3 style="margin-top: 5px;font-weight: 100;margin-right: 10px;margin-bottom: 5px;"><?= $client['ville']; ?></h3> <h4><b>Code Postal: </b></h4>
                                <h3 style="margin-top: 5px;font-weight: 100;margin-bottom: 5px;"><?= $client['cplocalite']; ?></h3>
                            </div> -->
                        </div>

                        <div class="list_produits">
                            <h3 class="big-title2">Liste des produits</h3>
                            <table class="table table-small-font table-bordered table-striped" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Code article</th>
                                        <th>Désignation</th>
                                        <th>Quantite</th>
                                        <th>Prix</th>
                                        <th>Unité</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produits as $produit) { 
                                        $s_product= $db->get_row("SELECT sous_products_table.* FROM sous_products_table WHERE id=".$produit['id_sub_produit']); 
                                        ?>
                                        <tr>
                                            <td><?= $s_product['code_article']; ?></td>
                                            <td><?= $s_product['designation']; ?></td>
                                            <td><?= $produit['quantite']; ?></td>
                                            <td><?= $s_product['prix_final']." €"; ?></td>
                                            <td style="text-transform: lowercase!important;"><?= $s_product['unite']; ?></td> 
                                        </tr>
                                    <?php } ?> 
                                    <tr>
                                      <th scope="row" colspan="2" style="text-align:right;">Sous-total:</th> 
                                      <td colspan="3" style="text-align:left;">
                                          <span> <?= $commande['total']; ?> </span></td>
                                    </tr>
                                      <tr>
                                          <th scope="row" colspan="2" style="text-align:right;">Expédition:</th>
                                          <td colspan="3" style="text-align:left;">
                                              <span><?= $livraison; ?> <span>€</span></span>&nbsp;<small>via Frais de livraison</small>
                                          </td>
                                      </tr>
                                      <tr>
                                          <th scope="row" colspan="2" style="text-align:right;color: #e30613;">Total:</th>
                                          <td colspan="3" style="text-align:left;color: #e30613;"><b>  <?= $total; ?> € </b></td>
                                      </tr>
                                </tbody>
                            </table>
                            <div style="position: absolute;bottom: 0"> 
                                <span style="margin-right: 5px;">37 Rue Jeannette Ponteille, 69550 Amplepuis - France  </span>
                                <span style="margin-right: 5px;"><b>Tel: </b> +33 04 74 89 30 88</span>
                                <span style="margin-right: 5px;"><b>Fax: </b> +33 04 74 89 30 65</span> 
                            </div>
                        </div>     
                    </div>
                </div>


                   
                  <!--*********************************************** -->   
              </section>
          </div>
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
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
        
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
                    
                    <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="annlerDemande()">&times;</button>
                            <h4 class="modal-title">Valider la commande </h4>
                    </div>
                    <div class="modal-body" > Voulez-vous changer le statut de la commande en "Traitée" ? </div>
                    <div class="modal-footer"> 
                        <button type="button" class="btn btn-white" data-dismiss="modal" onclick="annlerDemande()">Annuler</button>
                        <button type="submit" id="submit-edit" class="btn btn-info" onclick="validerDemande();">Valider</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-valid-commande">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Confirmer la livraison de la commande </h4>
                    </div>
     
                    <div id="msg-edit-table" style="padding:15px; display:none"> </div>
                    <div class="modal-body" > Voulez-vous vraiment confirmer la livraison de la commande ?</div>
                    <div class="modal-footer"> 
                        <button type="button" class="btn btn-white" data-dismiss="modal">Fermer</button>
                        <button type="submit" onclick="valid_commande()" class="btn btn-info">Valider</button>
                    </div>

                </div>
            </div>
        </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>


        <script type="text/javascript">
function PrintElem(elem)
{
   
            var mywindow = window.open('', 'PRINT', 'height=1200,width=1700;');
   
    var style='<style>.big-title2{ text-align: left;margin-top: 50px; } .big-title{ color: #e30613;font-weight: 600;font-size: 25px;text-align: center;margin: 40px 0;}.form-infos {display: -webkit-inline-box;width: 100%;border-bottom: 1px solid #eee;margin-bottom: 0px;}.list_produits{background-color: #f3f3f3;padding: 0px;color: #000;border-radius: 2px;margin-top:-35px;}.table-bordered{ border: none; }.table-bordered>tbody>tr>td{ border-right: 1px solid #ddd; border-bottom: 1px solid #ddd; padding: 5px;}.table-bordered>thead>tr>th{ border-top: 1px solid #ddd;padding: 5px;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;padding: 10px;}.form-total h4{text-align: center;margin-top: 40px;margin-bottom: 40px;color: #e30613;font-size: 25px;} .form-infos h3{font-size: 15px; } .form-infos h4{ margin-right: 10px; margin-bottom: 5px; margin-top: 5px; } .form-infos h4 b{  font-size: 15px; margin-right: 0px;}.badge-success{ color: #00983d; } </style>  ';
    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write(style);
    mywindow.document.write('</head><body>');
   
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}
</script>
        <script type="text/javascript">

             var doc = new jsPDF();
             let i=0;
            
            var specialElementHandlers = { 
                '#editor': function (element, renderer) { 
                    return true; 
                } 
            };
           
            $('#submit').click(function () { 
             
                doc.fromHTML("<img src='images/logo-hydrex-200.png' height='12' /> ", 15, 15, { 
                    'width': 190,                     
                    'elementHandlers': specialElementHandlers 
                }); 

                doc.fromHTML("<br><br><br><br><br><br><h5 style='color: #e30613;'>Référence : <?= $commande['ref_commande']; ?></h5><h5>Client : <?= $client['lastName']; ?> <?= $client['firstName']; ?></h5><h5>Adresse : <?= $client['address']; ?>
                                ,  <?= $client['country']; ?> , <?= $client['ville']; ?></h5><h5>Adresse de livraison : <?= $client['adressliv']; ?></h5>", 15, 15, { 
                    'width': 190,                     
                    'elementHandlers': specialElementHandlers 
                }); 

                if(i==0){   
                doc.setFontSize(25);  
                doc.text(100, 25, 'Facture', 'center',);              
                 doc.autoTable({ html: '#myTable',   margin: {top: 85}, });
                 i++;
                }

                doc.setFontSize(9);
                doc.text(100, 280, ' 37 Rue Jeannette Ponteille, 69550 Amplepuis - France | Tel:  +33 04 74 89 30 88 | Fax: +33 04 74 89 30 65', 'center');

            
                
                doc.save('Facture.pdf'); 
            });      


            function valid_commande(){
                var id = $("#id_commande").val();
                jQuery.ajax({
                    url: "module_ajax/commandes/validate.php?id="+id,
                    success: function(response) {

                       window.setTimeout(function () {
                        $('#modal-valid-commande').modal('hide');
                        window.location.href = "";
                    }, 1000);

                   }
               });
            }

             $('.iswitch').on('change', function() {
                    
                        var id = $(this).val();
                        var object = $(this).data('object');

                        $.ajax({
                        type: "GET",
                        dataType:"html",
                        url: "./includes/change-statut-commande.php?object="+object+"&id="+id,
                        success: function(data){
                        if(data.match('success') != null){
                            showSuccess('La commandes a été expédiée');
                            // window.setTimeout(function () { window.location.href = ""; }, 1000);

                        }else{
                            showErrorMessage(data)
                        }
                        }
                        });
                        // Does some stuff and logs the event to the console
                        // showErrorMessage('Ops! Something went wrong');
            });

        

            function annlerDemande(){ location.reload(); }

            function validerDemande(){
                var id = $("#id_commande").val();
                var object = 'commande';
                $.ajax({
                    type: "GET",
                    dataType:"html",
                    url: "./includes/change-statut-commande.php?object="+object+"&id="+id,
                    success: function(data){
                        if(data.match('success') != null){
                            showSuccess('La commande a été traitée');
                            setTimeout(function(){ location.reload(); }, 3000);
                        }else{
                            showErrorMessage(data)
                        }
                        $('#valid-client').modal('hide');
                    }
                });
            }

            function valider_commande(id){
                $('#valid-client').data('bs.modal',null);
                jQuery('#valid-client').modal('show', {backdrop: 'static',keyboard: false});
                $("#id_commande").val(id);
                $('#valid-client').data('bs.modal').options.backdrop = 'static';
            }
        </script>






    </body>
</html> 