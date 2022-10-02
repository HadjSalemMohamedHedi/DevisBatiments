<?php
include_once './includes/config.inc.php';
 
// Authenticate user login
auth();

$id_actualite = $_GET['id'];
$_SESSION['id_actualite'] = $_GET['id'];

$actualite = $db->get_row("SELECT actualites.* FROM actualites WHERE id=".$id_actualite);
$actualite_images = $db->get_rows("SELECT actualite_images.* FROM actualite_images WHERE id=".$id_actualite);
  
if($_POST) {

if(empty($errors)) {
      $_POST['brev_description'] = addslashes($_POST['brev_description']); 
      $_POST['brev_description_en'] = addslashes($_POST['brev_description_en']);
      $_POST['description'] = addslashes($_POST['description']); 
      $_POST['description_en'] = addslashes($_POST['description_en']);   
      $_POST['titre_fr'] = addslashes($_POST['titre_fr']);   
      $_POST['titre_en'] = addslashes($_POST['titre_en']);
      
      if ($_POST['date_debut'] == "0000-00-00") {
        $_POST['date_debut'] = date("Y-m-d");
      }else {
        $_POST['date_debut'] = addslashes($_POST['date_debut']);
      }
        
      $_POST['date_fin'] = addslashes($_POST['date_fin']);
      //$_POST['status'] = addslashes($_POST['status']);
      /***********************/
      
      if(!$db->update('actualites',$_POST,$id_actualite)) {
        echo  '<div class="list-group-item list-group-item-danger">save failed</div>';
        } else {
        //$id_actualite=$id_actualite['id'];
        $db->query("delete from actualite_images where id_actualite = ".$id_actualite);
        
        foreach ($_SESSION['images-actualite'] as $img)
        {
          if ($img!='-1'){
            $actualite_images=array();
            $actualite_images['id_actualite']=$id_actualite;
            $actualite_images['path']=$img;
            $db->insert('actualite_images',$actualite_images);
          }
        }
        
       $sucess ='<div class="alert alert-success alert-dismissible fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>Success:</strong>Mise à jour effectué avec succès.</div>';
      }
      }else{
      $msg='<div class="list-group-item list-group-item-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Erreur:</strong><br>';
      foreach($errors as $error):
      $msg.='- '.$error.'<br>';
      endforeach;
      $msg.='</div>';
     
      exit;
    } 

      header('Location: manage-actualites.php');      

     // header('Location: details-actualite?id='.$id_actualite);      

  }
  

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
 
                <?php echo $sucess;  echo $msg; ?>
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'> <?php echo notification(); ?> </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12">
                        <section class="box ">
                    
                            <header class="panel_header">
                                <h2 class="title">Détails de l'actualite</h2>
                            </header>

                            <div class="content-body">
    <form id="form-edit" class=""  method="post">                            
                                 <div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="username" class="control-label">Titre (FR) *:</label>
            <div class="controls">
                <input type="text" class="form-control" id="titre_fr" name="titre_fr" required="required" value="<?php echo $actualite['titre_fr']?>">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="username" class="control-label">Titre (EN) *:</label>
            <div class="controls">
                <input type="text" class="form-control" id="titre_en" name="titre_en" required="required" value="<?php echo $actualite['titre_en']?>">
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-6">
        <div class="form-group">
            <label for="email" class="control-label">Date début :</label>
            <div class="controls">
                <input type="date" class="form-control" id="date_debut" name="date_debut" value="<?php echo $actualite['date_debut']?>">
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label for="password" class="control-label">Date fin :</label>
            <div class="controls">
                <input type="date" class="form-control" id="date_fin" name="date_fin" value="<?php echo $actualite['date_fin']?>">
            </div>
        </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-md-12">
        <label for="phone" class="control-label">Brève description: </label>
        <ul class="nav nav-tabs transparent">
            <li class="active">
                <a href="#brevdesc-fr" data-toggle="tab">
                    Description FR
                </a>
            </li>
            <li>
                <a href="#brevdesc-en" data-toggle="tab">
                    Description EN 
                </a>
            </li>
        </ul>
        
        <div class="tab-content transparent">
            <div class="tab-pane fade in active" id="brevdesc-fr">
                <div>
                    <textarea id="editor_fr2" name="brev_description" class="bootstrap-wysihtml5-textarea" placeholder="Brève description (max 130 caractères) ..." style="width: 100%; height: 150px; font-size: 14px; line-height: 23px;padding:15px;"><?php echo $actualite['brev_description']?></textarea>
                </div>
            </div>
            <div class="tab-pane fade" id="brevdesc-en">
                <textarea  id="editor_en2" name="brev_description_en" class="bootstrap-wysihtml5-textarea" placeholder="Brief description (max 130 characters) ..." style="width: 100%; height: 150px; font-size: 14px; line-height: 23px;padding:15px;"><?php echo $actualite['brev_description_en']?></textarea>
            </div>
        </div>
    </div>
    
</div>

<div class="row">
    <div class="col-md-12">
        <label for="phone" class="control-label">Description: </label>
        <ul class="nav nav-tabs transparent">
            <li class="active">
                <a href="#desc-fr" data-toggle="tab">
                    Description FR
                </a>
            </li>
            <li>
                <a href="#desc-en" data-toggle="tab">
                    Description EN 
                </a>
            </li>
        </ul>
        
        <div class="tab-content transparent">
            <div class="tab-pane fade in active" id="desc-fr">
                <div>
                    <textarea  id="editor_fr" name="description" class="bootstrap-wysihtml5-textarea" placeholder="Description ..." style="width: 100%; height: 150px; font-size: 14px; line-height: 23px;padding:15px;"><?php echo $actualite['description']?></textarea>
                </div>
            </div>
            <div class="tab-pane fade" id="desc-en">
                <textarea  id="editor_en" name="description_en" class="bootstrap-wysihtml5-textarea" placeholder="Description ..." style="width: 100%; height: 150px; font-size: 14px; line-height: 23px;padding:15px;"><?php echo $actualite['description_en']?></textarea>
            </div>
        </div>
    </div>
</div>

 
<div class="row" style="margin-top:5px;">
    
    <div class="col-md-12">
        <div class="form-group">
            <label for="username" class="control-label">Images :</label>
            <div class="controls">
                <iframe src="upload/uploadact.php?id=<?php echo $id_actualite; ?>" style="width: 100%;height:250px;"></iframe>
            </div>
        </div>
    </div>
</div>

 


<button type="submit" id="submit-edit" class="btn btn-info">Valider</button>
<input type="hidden" name="id" value="<?php echo $db->escape($_GET['id'])?>" />
<input type="hidden" name="action" value="edit" />
</form>

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
 v>
 
    </body>
</html>
                                                                