<?php
	include_once './includes/config.inc.php';
	// Authenticate user login
	auth();
	

ini_set('upload_max_filesize', '2047M');
ini_set('post_max_size', '2G');


	if(isset($_GET['action']) && $_GET['action']=='delete') {
		
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
			$_SESSION['notification'] = array('type'=>'error','msg'=>'Id invalide');
			redirect(ROOT_URL.'manage-products.php');
		}
		
		if($db->update('products',array('deleted'=>1),$_GET['id'])) {
			$_SESSION['notification'] = array('type'=>'succes','msg'=>'Le produit a été supprimé avec succès');
			
			$product= $db->get_row("select * from products where id=".$_GET['id']);
			$filter=" and id_sub_categ=".$product['id_sub_categ'];
			$query="UPDATE products SET products.rang =products.rang - 1  WHERE statut = 1 and deleted = 0 and rang > ".$product["rang"]." ".$filter;
			$db->query($query); 
			
			
			} else {
			$_SESSION['notification'] = array('type'=>'error','msg'=>'Il y a eu un problème S\'il vous plaît essayez de nouveau.');
		}
		redirect(ROOT_URL.'manage-products.php');
	}
	/*delete trash*/
	else if(isset($_GET['action']) && $_GET['action']=='deletetrash') {
		
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
			$_SESSION['notification'] = array('type'=>'error','msg'=>'Id invalide');
			redirect(ROOT_URL.'manage-products.php?trash=true');
		}
		
		if($db->update('products',array('deleted'=>2),$_GET['id'],true)) {
			$_SESSION['notification'] = array('type'=>'succes','msg'=>'Le produit a été supprimé avec succès');
			} else {
			$_SESSION['notification'] = array('type'=>'error','msg'=>'Il y a eu un problème S\'il vous plaît essayez de nouveau.');
		}
		redirect(ROOT_URL.'manage-products.php?trash=true');
	}
	/*restore trash*/
	else if(isset($_GET['action']) && $_GET['action']=='restore') {
		
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
			$_SESSION['notification'] = array('type'=>'error','msg'=>'Id invalide');
			redirect(ROOT_URL.'manage-responsables.php?trash=true');
		}
		if($db->update('products',array('deleted'=>0),$_GET['id'])) {
			$_SESSION['notification'] = array('type'=>'succes','msg'=>'Le produit a été restauré avec succès');
			} else {
			$_SESSION['notification'] = array('type'=>'error','msg'=>'Il y a eu un problème S\'il vous plaît essayez de nouveau.');
		}
		redirect(ROOT_URL.'manage-products.php?trash=true');
	}
	/**/
	$ajax_filter = '';

	$categ = $db->get_rows("SELECT * FROM `categ` WHERE deleted = 0 ");


	/****** import csv -**************/
	if((isset($_POST['action'])) && ($_POST['action'] == "import") ){

		if(file_exists("import/uploaded_file.csv")){ unlink("import/uploaded_file.csv"); }
		if (isset($_FILES["file"])) {
            //if there was an error uploading the file
			if ($_FILES["file"]["error"] > 0) {
				echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
			} else {
				$count_ = 0;
             	//Store file in directory "upload" with the name of "uploaded_file.csv"
				$storagename = "uploaded_file.csv";
				move_uploaded_file($_FILES["file"]["tmp_name"], "import/" . $storagename);

				$row = 1;
				if (($handle = fopen("import/uploaded_file.csv", "r")) !== FALSE) {
					while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
						$num = count($data);
						if($num ==1){
							$newData = str_replace('"', '', $data[0]);
							$data = explode(",", $newData);
						}
						$row++;

						$ab = array();
						if($row>2){
							$sous_products_table = $db->get_row("SELECT * FROM sous_products_table WHERE code_article = '".$data[0]. "'");
							if ( !(empty($sous_products_table)) ) {
								/** si le produi exist **/
								$product  = $db->get_row("SELECT * FROM products WHERE id = ".$sous_products_table['id_product'] ); 

								$ab['id_product'] = $product['id'];
								$ab['code_article'] = $data[0]; 
								$ab['designation'] = $data[1];

								$prix = $data[2];$ab['prix'] = $prix;
								$remise = $data[3]; $ab['remise'] = $remise;

								if ($remise != "") {
									$promo_nb =  explode('%', $remise);
									$prix_nb =  explode('€', $prix);
									$final_price = str_replace(',', '.',  $prix_nb['0']);
									$price_promo = $final_price * ($promo_nb['0'] / 100); 
									$gh_promo = $final_price -  $price_promo;
									$ab['prix_final'] = number_format($gh_promo, 2, '.', ' ');
								}else{
									$prix_nb =  explode('€', $prix);
									$ab['prix_final'] = str_replace(',', '.',  $prix_nb['0']);
								}

								$ab['unite'] = $data[5];
								$ab['quantite'] = $data[6];
								$ab['stock_min'] = $data[7];

								$db->update('sous_products_table', $ab, $sous_products_table['id']);

								$count_++;
							} 
							
						}
					}
					fclose($handle);
				}
				if(file_exists("import/uploaded_file.csv")){
					unlink("import/uploaded_file.csv");
				}

				//$_SESSION['notification'] = array('type'=>'succes','msg'=>"La mise à jour de " . $count_ . " produits a été effectuée avec succès");

				//redirect(ROOT_URL.'manage-products.php?import=true&count='.$count_);
			}
		}else {
			echo "No file selected <br />";
		}
	}
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
			.filtre_paie {
			    margin-top: 20px;
			    float: right;
			}
			#table-filter {
			    padding: 5px 20px;
			    border-radius: 4px;
			}
		</style>
	</head>
	<!-- END HEAD -->
	
	<!-- BEGIN BODY -->
	<body>
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
				<section class="wrapper" >

					<?php if(!isset($_GET['trash'])){?>
						<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
							<div class="page-title">
								<nav class="navbar-default">
									<div class="container-fluid">
										<h1 class="title">Gestion des produits</h1>
										<button type="button" class="btn btn-danger navbar-btn btn-icon btn-import" data-toggle="modal" data-target="#exampleModal">
											<i class="fa fa-plus-square"></i> &nbsp; <span>Importer CSV</span>
										</button>
										<button type="button" class="btn btn-default navbar-btn btn-icon btn-add-product" data-toggle="modal" onclick="Add();">
											 <i class="fa fa-plus-square"></i> &nbsp; <span>Ajouter un produit</span>
										</button>
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
							<header class="panel_header">
								<h2 class="title">Liste des produits</h2>

								<div class="filtre_paie">
                                        Filtrer par gamme:
                                        <select id="table-filter">
                                            <option value="">Tous </option>
                                            <?php  
                                                foreach ($categ as $categ_) {  
                                                     print '<option>'. $categ_['titre_fr'] .'</option>';
                                                } 
                                            ?>
                                        </select>
                                    </div>

							</header>

							<div class="content-body">
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12"> 
										<!-- ********************************************** -->
						 	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#uploadModal">Upload file</button>

<!-- Modal -->
<div id="uploadModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">File upload form</h4>
      </div>
      <div class="modal-body">
        <!-- Form -->
        <form method='post' action='' enctype="multipart/form-data">
          Select file : <input type='file' name='file' id='file' class='form-control' ><br>
          <input type='button' class='btn btn-info' value='Upload' id='btn_upload'>
        </form>

        <!-- Preview-->
        <div id='preview'></div>
      </div>
 
    </div>

  </div>
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

			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    		<div class="modal-dialog" role="document">
    			<div class="modal-content">
    				<div class="modal-header">
    					<h5 class="modal-title" id="exampleModalLabel">Importer une liste des produits</h5>
    					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    						<span aria-hidden="true">&times;</span>
    					</button>
    				</div>
    				<form class="form-horizontal" action="" method="post" name="upload_excel" enctype="multipart/form-data">
    					<input type="hidden" name="action" value="import">
    					<div class="modal-body">
    						<div class="row">
    							<div class="form-group">
    								<label class="col-md-4 control-label" for="filebutton"><h4>Sélectionner un fichier</h4></label>
    								<div class="col-md-4">
    									<input type="file" name="file" id="file" class="input-large" style="margin-top: 16px;">
    								</div>
    							</div>
    						</div>
    					</div>
    					<div class="modal-footer">
    						<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
    						<button type="submit" class="btn btn-info">Importer</button>
    					</div>
    				</form>
    			</div>
    		</div>
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
		<script src="assets/plugins/bootstrap3-wysihtml5/js/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
		
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
		<script src="assets/plugins/uikit/js/uikit.min.js" type="text/javascript"></script>
		<script src="assets/plugins/uikit/js/components/nestable.min.js" type="text/javascript"></script><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 
		<script src="assets/plugins/responsive-tables/js/rwd-table.min.js" type="text/javascript"></script><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->
		
		<!-- messenger -->
		<script src="assets/plugins/messenger/js/messenger.min.js" type="text/javascript"></script>
		<script src="assets/plugins/messenger/js/messenger-theme-future.js" type="text/javascript"></script>
		<script src="assets/plugins/messenger/js/messenger-theme-flat.js" type="text/javascript"></script><script src="assets/js/messenger.js" type="text/javascript"></script><!-- /messenger --> 
		
		<script src="assets/js/scripts.js" type="text/javascript"></script>
		
		<?php include_once 'js/js-folder.php';?>
		
		<!-- Sidebar Graph - START --> 
		<script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script> 
		<script src="assets/js/chart-sparkline.js" type="text/javascript"></script>



		<!--add-->
		<div class="modal fade" id="ultraModal-add" >
			<div class="modal-dialog" style="width:60%;">
				<div class="modal-content">
					<form id="form-add" class="" action="./module_ajax/products/validate.php" method="post" enctype="multipart/form-data">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Ajouter un produit</h4>
						</div>
						<div id="msg-add" style="padding:15px; display:none"></div>
						<div class="modal-body" > loading... </div>
						<div class="modal-footer"> 
							<button type="button" class="btn btn-white" data-dismiss="modal">Fermer</button>
							<button type="submit" id="submit-add" class="btn btn-info">Valider</button>
						</div>
					</form>
				</div>
			</div>
		</div>
 
 
	</body>
</html>


<script type="text/javascript">
 
		$(document).ready(function(){
  $('#btn_upload').click(function(){

    var fd = new FormData();
    var files = $('#file')[0].files[0];
    fd.append('file',files);

    // AJAX request
    $.ajax({
      url: 'ajaxfile.php',
      type: 'post',
      data: fd,
      contentType: false,
      processData: false,
      success: function(response){
        if(response != 0){
          // Show image preview
          $('#preview').append("<img src='"+response+"' width='100' height='100' style='display: inline-block;'>");
        }else{
          alert('file not uploaded');
        }
      }
    });
  });
});			
					</script>																																		