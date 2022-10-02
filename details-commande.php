<?php
include_once './includes/config.inc.php';
 



$id_commande = $_GET['id'];
$commande= $db->get_row("SELECT ordered_hx.* FROM ordered_hx WHERE id=".$id_commande);
$client = $db->get_row("SELECT clients.* FROM clients WHERE clients.id=".$commande['id_client']);

$produits = $db->get_rows("SELECT produit_commande.* FROM produit_commande WHERE id_commande = ".$commande['id']);

$livraison =   $commande['counts_liv'];
$toto = explode("€", $commande['total']);
//$total = $toto[0] + $livraison;
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
                                         
                                         <button id="stubmit"
                                         rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Cliquer pour Télécharger le pdf" onclick="GetPdf(<?=  $commande['id'] ?>,<?= number_format(($commande['total']/1.2)-$livraison,2)?>,<?php echo "'".$commande['ref_commande']."'";?>,<?php $date=date_create($commande['date_create']); echo "'".date_format($date,"d/m/Y")."'" ; ?>)"  data-placement="top"><i class="fa fa-file-pdf-o"></i>
                                         Télécharger pdf</button>

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
                                        <h4><b>Coûts de livraison: </b></h4><h4><?= $commande['type_livraison'].' €'; ?></h4>
                                    </div>
                                    <div class="list_produits"  style="height: 600px;overflow-x: scroll;">
                                        <h3 class="big-title">Liste des produits</h3>
                                        <table class="table table-small-font table-bordered table-striped" id="MyFac<?php echo $commande['id'],'ture';?>">
                                            <thead>
                                                <tr>
                                                    <th>Code article</th>
                                                    <th>Désignation</th>
                                                    <th>Unité</th>
                                                    <th>Qte</th>
                                                    <th>Prix</th>
                                                    <th>Tva</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($produits as $produit) { 
                                                    $s_product= $db->get_row("SELECT sous_products_table.* FROM sous_products_table WHERE id=".$produit['id_sub_produit']);
                                                    ?>
                                                    <tr>
                                                        <td><?= $s_product['code_article']; ?></td>
                                                        <td><?= $s_product['designation']; ?></td>
                                                        <td><?= $s_product['unite']; ?></td>
                                                        <td><?= $produit['quantite']; ?></td>
                                                        <td><?= $s_product['prix_final']." €"; ?></td>
                                                        <td><?= $s_product['tva']." %"; ?></td>
                                                        
                                                        <!-- <td>
                                                            <?php
                                                                if ($produit['quantite'] == 0) {
                                                                   echo "<span class='badge-danger'>Épuisé </span>";
                                                                }else{
                                                                    echo "<span class='badge-success'>Disponible</span>";
                                                                }
                                                            ?>
                                                        </td> -->
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table> 
                                    </div>
                                    <div class="form-group form-total"> 
                                        <h4><b>Total TTC: </b> <?= number_format($commande['total'],2).' €'; ?></h4>
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
                                        <div style="display: flex;">
                                         
                                    <h3 style="text-align: left;width: 50%">
                                        Référence Commande: <?= $commande['ref_commande']; ?>
                                    </h3>

                                      <h6 style="text-align: right; width: 50%">
                                        Fiche d'expédition
                                    </h6>

                                </div>
                                 
                                    <h1  style="text-align: center;">                              
                                     <?php echo $client['lastName'].' '; echo $client['firstName']; ?>
                                    </h1>
                                    <h2  style="text-align: center;">
                                        <?php  echo $client['address']." ".$client['ville'];?>
                                    </h2>
                                      <h2  style="text-align: center;">
                                        Tél: <?php  echo $client['phone'];?>
                                    </h2>
                                    <img src="images/logo-hydrex-200.png" class="img-responsive img_logo logo-nav">    

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
                            <div class="col-md-6" style="float: left;"><br><br>
                                <img src="https://hydrex-international.com/KcaBoeN-xerdyh/back-hydrex/images/logo-hydrex-200.png" class="img-responsive img_logo logo-nav">    
                            </div> 

                            <div class="col-md-6" style="float: right;">
                                <h6><b style="font-size: 18px;">Facture</b><br>
                                Réf:<?= $commande['ref_commande']; ?><br>
                                Date facturation:<?php $date=date_create($commande['date_create']); echo "'".date_format($date,"d/m/Y")."'" ; ?></h6>
                            </div> 

                       </div> 
<br><br><br>
                       <div class="infos-client">
                        <div class="row">
                            <div class="col-sm-6"style="float: left;">
                                <h5>Émetteur</h5>
                             <b>Hydrex International<b><br><a style='font-size:12;font-weight:100'>37 Rue Jeannette Ponteille, 69550 Amplepuis - France<br><b>Téléphone:</b> +33 04 74 89 30 88<br><b>Email:</b> hydrex@Hydrex.fr<a> >
                            </div>

                            <div class="col-sm-6" style="float: right;">
                                <h5><b>Adressé à:<b></h5>
                                    <b><?=strtoupper($client['lastName']);?> <?=$client['firstName'];?><b><br><a style='font-size:12;font-weight:100'><?=$client['address'];?>,<?=$client['country']; ?>,<?=$client['ville'];?><br><b>Téléphone:</b> <?=$client['phone']; ?><br><b>Email:</b> <?=$client['email']; ?><a> 
                            </div>
                        </div>
                            
                           
                        <br><br><br>
                           
                            
                        
                        </div>
<br><br><br><br>
                        <div class="list_produits">
                            <h3 class="big-title2">Liste des produits</h3>
                            <table class="table table-small-font table-bordered table-striped" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Code article</th>
                                        <th>Désignation</th>
                                        <th>Unité</th>
                                        <th>Quantite</th>
                                        <th>Prix unitaire</th>
                                        <th>Tva</th>
                                        <th>Total HT</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produits as $produit) { 
                                    $s_product= $db->get_row("SELECT sous_products_table.* FROM sous_products_table WHERE id=".$produit['id_sub_produit']); 
                                    $Products_commande= $db->get_row("SELECT * FROM Products_commande WHERE code_article='".$s_product['code_article']."'"); 

                                        ?>
                                        <tr>
                                            <td><?= $s_product['code_article']; ?></td>
                                            <td><?= $s_product['designation']; ?></td>
                                            <td style="text-transform: lowercase!important;"><?= $s_product['unite']; ?></td> 
                                            <td><?= $produit['quantite']; ?></td>
                                            <td><?= number_format($Products_commande['prix_final'],2)." €"; ?></td>
                                            <td><?= $s_product['tva']." %"; ?></td>
                                            <td><?= number_format(number_format($Products_commande['prix_final'],2)*$produit['quantite'],2)?>€</td>
                                        </tr>
                                    <?php
                                 $Total_HT += number_format(number_format($Products_commande['prix_final'],2)*$produit['quantite'],2); 
    
                                } 

                                        /*

                                          <tr>
                                      <th scope="row" colspan="2" style="text-align:right;">Total HT:</th> 
                                      <td colspan="3" style="text-align:left;">
                                        <!-- <span> <?= $commande['total']; ?> </span></td> -->         
                                        <span><?= number_format(($commande['total']/1.2)-$livraison,2)?>€</span></td>        
                                      </tr>
                                      <tr>
                                          <th scope="row" colspan="2" style="text-align:right;">Coûts de livraison HT:</th>
                                          <td colspan="3" style="text-align:left;">
                                              <span><?= $livraison;?><span>€</span></span>&nbsp;<small> via Frais de livraison</small>
                                          </td>
                                      </tr>
                                           <tr>
                                          <th scope="row" colspan="2" style="text-align:right;">TVA:</th>
                                          <td colspan="3" style="text-align:left;">
                                              <span><?= number_format((($commande['total']/1.2))*0.2,2); ?><span>€</span></span>
                                          </td>
                                      </tr>
                                      <tr>
                                          <th scope="row" colspan="2" style="text-align:right;color: #e30613;">Total TTC:</th>
                                          <td colspan="3" style="text-align:left;color: #e30613;"><b>
                                            <?= number_format($commande['total'],2).' €'; ?> </b></td>
                                      </tr>
                                        */


                                    ?> 
                                  
                                </tbody>
                            </table><br><br><br>


                                <div style="float: right;">
                                 <table id="TotalFact">
                                      <tr>
                                      <th scope="row" colspan="2" style="text-align:right;">Total HT:</th> 
                                      <td colspan="3" style="text-align:left;">
                                        <!-- <span> <?= $commande['total']; ?> </span></td> -->         
                                        <span><?= number_format($Total_HT,2);?>€</span></td>        
                                      </tr>
                                      <tr>
                                          <th scope="row" colspan="2" style="text-align:right;">Coûts de livraison HT:</th>
                                          <td colspan="3" style="text-align:left;">
                                              <span><?= $livraison-20;?><span>€</span></span>&nbsp;<!--<small> via Frais de livraison</small>-->
                                          </td>
                                      </tr>
                                           <tr>
                                          <th scope="row" colspan="2" style="text-align:right;">TVA:</th>
                                          <td colspan="3" style="text-align:left;">
                                              <span><?= number_format(($commande['total']-$livraison)-$Total_HT,2); ?><span>€</span></span>
                                          </td>
                                      </tr>
                                      <tr>
                                          <th scope="row" colspan="2" style="text-align:right;color: #e30613;">Total TTC:</th>
                                          <td colspan="3" style="text-align:left;color: #e30613;"><b><?= $commande['total']; ?> </b></td>
                                      </tr> 
                                </table>
                                </div>

                            <div style="position: absolute;bottom: 0"> 
                                <div style="text-align: center;"><h6><b style="font-size: 15px;">Hydrex International</b><br>37 Rue Jeannette Ponteille, 69550 Amplepuis - France | Site web: hydrex-international.com | Email: hydrex@Hydrex.fr | Tel:  +33 04 74 89 30 88 | Fax: +33 04 74 89 30 65</h6></div>
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
               
               var imgData = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAAAvCAYAAACmGYWkAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQ1IDc5LjE2MzQ5OSwgMjAxOC8wOC8xMy0xNjo0MDoyMiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjYxNzExNzgyNDFBMjExRUE5MkNCQkUxNkI1ODlFMjNGIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjYxNzExNzgzNDFBMjExRUE5MkNCQkUxNkI1ODlFMjNGIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NjE3MTE3ODA0MUEyMTFFQTkyQ0JCRTE2QjU4OUUyM0YiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NjE3MTE3ODE0MUEyMTFFQTkyQ0JCRTE2QjU4OUUyM0YiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7mq417AAANy0lEQVR42uxd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";

                       doc.addImage(imgData, 'JPEG', 15, 15, 50, 12);
                doc.fromHTML("<br><br><br><br><br><br><h5 style='color: #e30613;'>Référence : <?= $commande['ref_commande']; ?></h5><h5>Client : <?= $client['lastName']; ?> <?= $client['firstName']; ?></h5><h5>Adresse : <?= $client['address']; ?>
                                ,  <?= $client['country']; ?> , <?= $client['ville']; ?></h5><h3 style='color: #e30613;font-weight:bold'>Liste des produits</h3>", 15, 15, { 
                    'width': 190,                     
                    'elementHandlers': specialElementHandlers 
                }); 

                if(i==0){   
                doc.setFontSize(25);  
                doc.text(100, 35, 'Facture', 'center',);              
                 doc.autoTable({ html: '#myTable',   margin: {top: 80}, 
           didParseCell: function (table) {
                    
          if (table.section === 'head') {
            table.cell.styles.textColor = '#fff';
            table.cell.styles.fillColor = '#e30613';
          }
       }

             });
doc.autoTable({ html: "#TotalFact" ,   margin: {top: 90},theme: 'plain',margin: {left: 150}     
                 
            });

                 i++;
                }




          


                doc.setFontSize(8);
                doc.text(100, 280, ' 37 Rue Jeannette Ponteille, 69550 Amplepuis - France | Site web: hydrex-international.com | Tel:  +33 04 74 89 30 88 | Fax: +33 04 74 89 30 65', 'center');
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




<script type="text/javascript">  
let idCode="";

  function GetPdf(Code,TotalHt,ref_commande,date_fact){
    let olCode="";
   
    idCode ="#MyFac"+Code+"ture";
    if(olCode!=Code){
                  i=0;
                  var doc = new jsPDF();
      doc.setFont("Helvetica");

                }


               var imgData = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAAAvCAYAAACmGYWkAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQ1IDc5LjE2MzQ5OSwgMjAxOC8wOC8xMy0xNjo0MDoyMiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjYxNzExNzgyNDFBMjExRUE5MkNCQkUxNkI1ODlFMjNGIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjYxNzExNzgzNDFBMjExRUE5MkNCQkUxNkI1ODlFMjNGIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NjE3MTE3ODA0MUEyMTFFQTkyQ0JCRTE2QjU4OUUyM0YiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NjE3MTE3ODE0MUEyMTFFQTkyQ0JCRTE2QjU4OUUyM0YiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7mq417AAANy0lEQVR42uxd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";

                       doc.addImage(imgData, 'JPEG', 15, 15, 50, 12);
                doc.setFontSize(15);  
               // doc.text(180, 18, 'Facture', 'right',); 

                 doc.fromHTML("<h2>Facture</h2>",162, 7, { 
                    'width': 35,                     
                    'elementHandlers': specialElementHandlers 
                }); 


              doc.fromHTML("<div><h6 ><b>Réf. :"+ref_commande+"<br>Date facturation :"+date_fact+"</b></h6> </div>", 162, 10, { 
                    'width': 190,                     
                    'elementHandlers': specialElementHandlers 
                }); 
          



                doc.fromHTML("<h5>Émetteur</h5>", 15, 33, { 
                    'width': 35,                     
                    'elementHandlers': specialElementHandlers 
                }); 

            doc.fromHTML("<div style='padding:3%;background-color:red;fillColor:red'><b>Hydrex International<b><br><a style='font-size:12;font-weight:100'>37 Rue Jeannette Ponteille, 69550 Amplepuis - France<br><b>Téléphone:</b> +33 04 74 89 30 88<br><b>Email:</b> hydrex@Hydrex.fr<a> </div>", 15, 40, { 
                    'width': 250,                     
                    'elementHandlers': specialElementHandlers 
                }); 



                 doc.fromHTML("<h5><b>Adressé à:<b></h5>", 115, 33, { 
                    'width': 35,                     
                    'elementHandlers': specialElementHandlers 
                }); 



                doc.fromHTML("<div style='padding:3%;'><b><?=strtoupper($client['lastName']);?> <?=$client['firstName'];?><b><br><a style='font-size:12;font-weight:100'><?=$client['address'];?>,<?=$client['country']; ?>,<?=$client['ville'];?><br><b>Téléphone:</b> <?=$client['phone']; ?><br><b>Email:</b> <?=$client['email']; ?><a> </div>", 115, 40, { 
                    'width': 250,                     
                    'elementHandlers': specialElementHandlers 
                }); 


                if(i==0){  
     

     
                 doc.autoTable({ html: idCode ,   margin: {top: 77},        
                  didParseCell: function (table) {
                table.cell.styles.fillColor = '#fff';
                table.cell.styles.border = '1';
                table.cell.styles.border = '1px solid #000';

          if (table.section === 'head') {
            table.cell.styles.textColor = '#fff';
            table.cell.styles.fillColor = '#e30613';
          }
       } });


/*
lo
*/


 
          doc.autoTable({ html: "#TotalFact" ,   margin: {left: 120}    
                 
            });


                 i++;
                  olCode = Code;
                }
               
                 doc.fromHTML("<h5>Hydrex International</h5>", 85, 265, { 
                    'width': 35,                     
                    'elementHandlers': specialElementHandlers 
                });
                doc.setFontSize(7);

                doc.text(104, 280, ' 37 Rue Jeannette Ponteille, 69550 Amplepuis - France | Site web: hydrex-international.com | Email: hydrex@Hydrex.fr | Tel:  +33 04 74 89 30 88 | Fax: +33 04 74 89 30 65', 'center');
              doc.save('Factureee.pdf'); 

             
  }



</script>



    </body>
</html> 