<?php
include_once './includes/config.inc.php';
// Authenticate user login
auth();

ini_set('upload_max_filesize', '2047M');
ini_set('post_max_size', '2G');

if (isset($_GET['action']) && $_GET['action'] == 'delete') {

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        $_SESSION['notification'] = array('type' => 'error', 'msg' => 'Id invalide');
        redirect(ROOT_URL . 'manage-products.php');
    }

    if ($db->update('products', array('deleted' => 1), $_GET['id'])) {
        $_SESSION['notification'] = array('type' => 'succes', 'msg' => 'Le produit a été supprimé avec succès');

        $product = $db->get_row("select * from products where id=" . $_GET['id']);
        $filter = " and id_sub_categ=" . $product['id_sub_categ'];
        $query = "UPDATE products SET products.rang =products.rang - 1  WHERE statut = 1 and deleted = 0 and rang > " . $product["rang"] . " " . $filter;
        $db->query($query);

    } else {
        $_SESSION['notification'] = array('type' => 'error', 'msg' => 'Il y a eu un problème S\'il vous plaît essayez de nouveau.');
    }
    redirect(ROOT_URL . 'manage-products.php');
}
/*delete trash*/
else if (isset($_GET['action']) && $_GET['action'] == 'deletetrash') {

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        $_SESSION['notification'] = array('type' => 'error', 'msg' => 'Id invalide');
        redirect(ROOT_URL . 'manage-products.php?trash=true');
    }

    if ($db->update('products', array('deleted' => 2), $_GET['id'], true)) {
        $_SESSION['notification'] = array('type' => 'succes', 'msg' => 'Le produit a été supprimé avec succès');
    } else {
        $_SESSION['notification'] = array('type' => 'error', 'msg' => 'Il y a eu un problème S\'il vous plaît essayez de nouveau.');
    }
    redirect(ROOT_URL . 'manage-products.php?trash=true');
}
/*restore trash*/
else if (isset($_GET['action']) && $_GET['action'] == 'restore') {

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        $_SESSION['notification'] = array('type' => 'error', 'msg' => 'Id invalide');
        redirect(ROOT_URL . 'manage-responsables.php?trash=true');
    }
    if ($db->update('products', array('deleted' => 0), $_GET['id'])) {
        $_SESSION['notification'] = array('type' => 'succes', 'msg' => 'Le produit a été restauré avec succès');
    } else {
        $_SESSION['notification'] = array('type' => 'error', 'msg' => 'Il y a eu un problème S\'il vous plaît essayez de nouveau.');
    }
    redirect(ROOT_URL . 'manage-products.php?trash=true');
}
/**/
$ajax_filter = '';

$categ = $db->get_rows("SELECT * FROM `categ` WHERE deleted = 0 ");
header('Content-Type: text/html; charset=UTF-8');

/****** import csv -**************/
if ((isset($_POST['action'])) && ($_POST['action'] == "import")) {

$path = $_FILES['file']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);
if($ext!=="csv"){
	 $_SESSION['notification'] = array('type'=>'warning','msg'=>"Erreur !
			Le fichier doit en format csv!");

	}

	else{
    if (file_exists("import/uploaded_file.csv")) {unlink("import/uploaded_file.csv");}
    if (isset($_FILES["file"])) {
        //if there was an error uploading the file
        if ($_FILES["file"]["error"] > 0) {
            //echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
        } else {
            $count_ = 0;
            //Store file in directory "upload" with the name of "uploaded_file.csv"
            $storagename = "uploaded_file.csv";
            move_uploaded_file($_FILES["file"]["tmp_name"], "import/" . $storagename);

            $row = 1;
            if (($handle = fopen("import/uploaded_file.csv", "r")) !== false) {
            	$iEur=0;
            	$ErrCodes="";
                while (($data = fgetcsv($handle, 1000, ",")) !== false) {

                	 $data = array_map("utf8_encode", $data);

                	if(count($data)<7){
					 $_SESSION['notification'] = array('type'=>'warning','msg'=>"Erreur !<br>
						Le formatage doit être comme suit : Code Article,stock,Stock sécurité,designation,remise,unite,prix<br>
						Utiliser seulement les virgules pour séparer les rubriques du fichier.");
					}
					else{
					$iEur++;
                    $num = count($data);
                    if ($num == 1) {
                        $newData = str_replace('"', '', $data[0]);
                        $data = explode(";", $newData);
                    }
                    $row++;

                    $ab = array();
                    $ErreurTabl = array();



					$_SESSION['notification'] = array('type'=>'warning','msg'=>"Erreur !<br>
						Le formatage doit être comme suit : Code Article,stock,Stock sécurité,designation,remise,unite,prix <br>
						Utiliser seulement les virgules pour séparer les rubriques du fichier. <br>
						Les Codes : <br>");

                    if ($row > 2) {
                        $sous_products_table = $db->get_row("SELECT * FROM sous_products_table WHERE code_article = '" . $data[0] . "'");

						if (empty($sous_products_table)) {
                    $ErreurTabl[$iEur] = $data[0];

						}
						
						foreach($ErreurTabl as $ErrTabl)
							{
								$ErrCodes=$ErrCodes." | ".$ErrTabl." ";

							}

							$_SESSION['notification'] = array('type'=>'warning','msg'=>"Erreur !<br>
						Le formatage doit être comme suit : Code Article,stock,Stock sécurité,designation,remise,unite,prix <br>
						Utiliser seulement les virgules pour séparer les rubriques du fichier. <br>
						Les codes erronées : <br> <b>".$ErrCodes."</b>");


                        if (!(empty($sous_products_table))) {
                            /** si le produi exist **/
                         $product = $db->get_row("SELECT * FROM products WHERE id = " . $sous_products_table['id_product']);

                            $ab['id_product'] = $product['id'];
                            //$ab['code_article'] = $data[0];
                            //$ab['designation'] = $data[1];

                            $prix = $data[6].",".$data[7];
                            //$ab['prix'] = $prix;
                            $remise = $data[4];
                           // $ab['remise'] = $remise;

                            if (($remise != "") && ($remise !="0") && ($remise != 0) ) {
                                $promo_nb = explode('%', $remise);
                                $prix_nb = explode('€', $prix);
                                $final_price = str_replace(',', '.', $prix_nb['0']);
                                $price_promo = $final_price * ($promo_nb['0'] / 100);
                                $gh_promo = $final_price - $price_promo;
                                $PrixFinal = $prix_nb-(($prix_nb/100)*$remise);
                                //$ab['prix_final'] = number_format($gh_promo, 2, '.', ' ');
                                $ab['prix_final'] = number_format($PrixFinal, 2, '.', ' ');
                            
                            } else {
                                $prix_nb = explode('€', $prix);
                               $ab['prix_final'] = str_replace(',', '.', $prix_nb['0']);

							   
							}

                          //  $ab['unite'] = $data[5];
                            //$ab['quantite'] = $data[6];
                            //$ab['stock_min'] = $data[7];
  							
  							$ab['quantite'] = $data[1];
                            $ab['stock_min'] = $data[2];
                            $ab['designation'] = addslashes($data[3]);
                            $ab['remise'] = $data[4];
							$ab['unite'] = $data[5];     
                            $ab['prix'] = $data[6].",".$data[7]; 

                          try{
							$db->update('sous_products_table', $ab, $sous_products_table['id']);
						  }
						  catch(Exception $e) {
				            $_SESSION['notification'] = array('type'=>'info','msg'=>"Erreur !
							Un texte ou un code produit a été saisie incorrectement
							Veuillez vérifier le formatage de votre fichier !");

						}
                            $count_++;
                        }



                    }
                }

            }
                fclose($handle);
            }
            if (file_exists("import/uploaded_file.csv")) {
               // unlink("import/uploaded_file.csv");
            }

            //$_SESSION['notification'] = array('type'=>'succes','msg'=>"La mise à jour de " . $count_ . " produits a été effectuée avec succès");

            //redirect(ROOT_URL.'manage-products.php?import=true&count='.$count_);
        }
    } else {
        echo "No file selected <br />";
    }

}
}

$nb_stock_min =get_produit_stock_min();
function get_produit_stock_min(){
	$db = db_connect();
	$sous_products_table = $db->get_rows("SELECT sous_products_table.* FROM sous_products_table WHERE statut = 1");
	$count = 0;
   	foreach ($sous_products_table as $product) {
   		if ($product["stock_min"] != 0) {
   			if($product["quantite"] <= $product["stock_min"]){ $count ++; }
   		}
   		
   	}
	return $count;
}





$nbr_produit  = get_nbr_produit();
function get_nbr_produit(){
	$db = db_connect();
	$query="SELECT count(*) as nbr_produit FROM products where deleted = 0 ";
	$nbr_produit = $db->get_row($query);
	return $nbr_produit;
}

$stock_zero = get_stock_zero();
function get_stock_zero(){
	$db = db_connect();
	$query="SELECT count(*) as stock_zero FROM sous_products_table where stock_min = 0 and statut = 1";
	$stock_zero = $db->get_row($query);
	return $stock_zero;
}


$user_role =$_SESSION['User']['role']; /**r */



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
		<link rel="stylesheet" media="screen" type="text/css" title="Design2" href="./Styles.css" />
		<!-- START TOPBAR -->
		<?php include ROOT . "includes/lien-css.php";?>
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
		<?php include ROOT . "includes/navbar.php";?>
		<!-- END TOPBAR -->
		<!-- START CONTAINER -->
		<div class="page-container row-fluid">

			<!-- SIDEBAR - START -->
			<?php include ROOT . "includes/sidebar.php";?>
			<!--  SIDEBAR - END -->
			<!-- START CONTENT -->


		<? if($_SESSION['User']['role']=='superadmin'): ?><!-- rr-->



			<section id="main-content" class=" ">
				<section class="wrapper" >


					<div class="row m-t-25">

						<div class="col-sm-6 col-lg-4">
							<a href="manage-products.php">
								<div class="overview-item item--c2">
									<div class="overview__inner">
										<div class="overview-box clearfix">
											<div class="icon">
												<i class="ti-pulse c-pink"></i>
												<h2 class="nb-dash"><?php echo $nbr_produit['nbr_produit']; ?></h2>
											</div>
											<div class="text">
												<span>Nombre total de produits </span>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>

					<div class="col-sm-6 col-lg-4">
							<a href="produits-en-stock-min.php">
								<div class="overview-item item--c3">
									<div class="overview__inner">
										<div class="overview-box clearfix">
											<div class="icon">
												<i class="ti-alert c-red"></i>
												<h2 class="nb-dash"><?= $nb_stock_min ?></h2>
											</div>
											<div class="text">
												<span>Produits en stocks min</span>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>

						<div class="col-sm-6 col-lg-4">
							<a href="repture-stocks.php">
								<div class="overview-item item--c2">
									<div class="overview__inner">
										<div class="overview-box clearfix">
											<div class="icon">
												<i class="ti-package c-red"></i>
												<h2 class="nb-dash"><?php echo $stock_zero['stock_zero']; ?></h2>
											</div>
											<div class="text">
												<span>Rupture de stocks</span>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>

					</div>

					<button type="button" class="btn btn-danger navbar-btn btn-icon btn-import" data-toggle="modal" data-target="#exampleModal"
					style="float: left;margin-left: 2%;margin-bottom: 2%;"
					>
					<i class="fa fa-refresh"></i> &nbsp; <span>Metre à jour le stock</span>
					</button>

					<?php if (!isset($_GET['trash'])) {?>
						<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
							<div class="page-title">
								<nav class="navbar-default">
									<div class="container-fluid">
										<h1 class="title">Gestion des produits</h1>
									
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
													    print '<option>' . $categ_['titre_fr'] . '</option>';
													}
													?>
                                        </select>
                                    </div>

							</header>

							<div class="content-body">
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<!-- ********************************************** -->


										<table  class="table table-datatable table-custom table-responsive" id="drillDownDataTable">
											<thead>
												<tr>
													<!-- <th>Code produit</th> -->
													<th class="no-sort" >Image </th>
													<th>Produit</th>
													<th>Gamme</th>
													<th>Catégorie</th>
												<!--	<th>Unité de conditionnement</th>
													<th>Stock</th>
													<th>Stock sécurité</th> !-->
													<th>Tableau</th>
													<th>Statut</th>
													<th style="width: 75px;">Action</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!--*********************************************** -->

						</section>
					</div>

					<!---->

				</section>

			</section>


		<?php else: ?> <!-- rr-->

		<?php include ROOT."./page-401.php"; ?><!-- rr-->

		<? endif;?>	<!-- rr-->



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
    								<label class="col-md-4 control-label" for="filebutton"><h4>Sélectionner un fichier (.csv)</h4></label>
    								<div class="col-md-4">
    									<input type="file" name="file" id="file" class="input-large" style="margin-top: 16px;" accept=".csv">
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

		 <script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>


		<!--add-->
		<div class="modal fade" id="ultraModal-add" >
			<div class="modal-dialog" style="width:60%;">
				<div class="modal-content">
					<form id="form-add" class="" action="./module_ajax/products/validate.php"  method="post" enctype="multipart/form-data">
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
		<!--edit-->
		<div class="modal fade" id="ultraModal-edit">
			<div class="modal-dialog" style="width:60%;">
				<div class="modal-content">
					<form id="form-edit" class="" action="./module_ajax/products/validate.php" method="post">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Modifier le produit</h4>
						</div>
						<div id="msg-edit" style="padding:15px; display:none"> </div>
						<div class="modal-body" > loading... </div>
						<div class="modal-footer">
							<button type="button" class="btn btn-white" data-dismiss="modal">Fermer</button>
							<button type="submit" id="submit-edit" class="btn btn-info">Valider</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="ultraModal-edit-table">
			<div class="modal-dialog" style="width:80%;">
				<div class="modal-content">
					<form id="form-edit-table" class="" action="./module_ajax/products/validate.php" method="post">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Tableau du produit</h4>
						</div>
						<div id="msg-edit-table" style="padding:15px; display:none"> </div>
						<div class="modal-body" > loading... </div>

					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="ultraModal-edit-table_charge">
			<div class="modal-dialog" style="width:80%;">
				<div class="modal-content">
					<form id="form-edit-table_charge" class="" action="./module_ajax/products/validate.php" method="post">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Tableau des charges</h4>
						</div>
						<div id="msg-edit-table_charge" style="padding:15px; display:none"> </div>
						<div class="modal-body" > loading... </div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="ultraModal-edit-table_charge_type_2">
			<div class="modal-dialog" style="width:55%;">
				<div class="modal-content">
					<form id="form-edit-table_charge_type_2" class="" action="./module_ajax/products/validate.php" method="post">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Tableau des charges</h4>
						</div>
						<div id="msg-edit-table_charge_type_2" style="padding:15px; display:none"> </div>
						<div class="modal-body" > loading... </div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="ultraModal-select-table_charge">
			<div class="modal-dialog" style="width:80%;">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Veuillez selectionner le type du tableau des charges</h4>
					</div>
					<div id="msg-select-table_charge" style="padding:15px; display:none"> </div>
					<div class="modal-body" > loading... </div>

				</div>
			</div>
		</div>
	</body>
</html>


<script type="text/javascript">
	/* Table initialisation */

	/******************************************************/
		/**************** DRILL DOWN DATATABLE ****************/
			/******************************************************/

				var anOpen = [];

				var oTable03 = $('#drillDownDataTable').dataTable({
					"sPaginationType": "bootstrap",
					"iDisplayLength": <?php print $ConfigDefault['filedefnum'];?>,
					"oLanguage": {
					"oPaginate": {
					"sNext": "<?php print $lang['sNext'];?>",
					"sPrevious": "<?php print $lang['sPrevious'];?>"
					},
					"sSearch": "<?php print $lang['sSearch'];?>",
					"sEmptyTable": "<?php print $lang['sEmptyTable'];?>",
					"sInfoFiltered": "<?php print $lang['sInfoFiltered'];?>",
					"infoEmpty": "<?php print $lang['infoEmpty'];?>",
					"sLengthMenu": "<?php print $lang['sLengthMenu'];?>",
					"sInfo": "<?php print $lang['sInfo'];?>",
					"sZeroRecords": "<?php print $lang['sZeroRecords'];?>"
					},
					"sAjaxSource": "table/products.php<?php echo $ajax_filter ?>",
					"aoColumns": [
					//{ "mDataProp": "code_produit" },
					{ "mDataProp": "image" },
					{ "mDataProp": "titre_fr" },
					{ "mDataProp": "categ" },
					{ "mDataProp": "sub_categ" },
					//{ "mDataProp": "unite_cond" },
					//{ "mDataProp": "quantite" },
					//{ "mDataProp": "stock_min" },
					{ "mDataProp": "tableau" },
					{ "mDataProp": "statut" },
					{ "mDataProp": "action" },

					],




					"fnInitComplete": function(oSettings, json) {
					$('.dataTables_filter input').attr("placeholder", "Rechercher");

						$('[rel="tooltip"]').each(function() {
						var animate = $(this).attr("data-animate");
						var colorclass = $(this).attr("data-color-class");
						$(this).tooltip({
						template: '<div class="tooltip ' + animate + ' ' + colorclass + '"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
						});
						});
					},
				    "fnDrawCallback": function() {
				         $('.iswitch').on('change', function() {

						var id = $(this).val();
						var object = $(this).data('object');

						$.ajax({
						type: "GET",
						dataType:"html",
						url: "./includes/change-statut-object.php?object="+object+"&id="+id,
						success: function(data){
						if(data.match('success') != null){
						showSuccess('Succés')
						}else{
						showErrorMessage(data)
						}
						}
						});
						// Does some stuff and logs the event to the console
						// showErrorMessage('Ops! Something went wrong');
						});
				    }
					});

					$(document).on( 'click', '#drillDownDataTable td.control', function () {
					var nTr = this.parentNode;
					var i = $.inArray( nTr, anOpen );

					$(anOpen).each( function () {
					if ( this !== nTr ) {
					$('td.control', this).click();
					}
					});

					if ( i === -1 ) {
					$('i', this).removeClass().addClass('fa fa-minus');
					$(this).parent().addClass('drilled');
					var nDetailsRow = oTable03.fnOpen( nTr, fnFormatDetails(oTable03, nTr), 'details' );
					$('div.innerDetails', nDetailsRow).slideDown();
					anOpen.push( nTr );
					}
					else {
					$('i', this).removeClass().addClass('fa fa-plus');
					$(this).parent().removeClass('drilled');
					$('div.innerDetails', $(nTr).next()[0]).slideUp( function () {
					oTable03.fnClose( nTr );
					anOpen.splice( i, 1 );
					} );
					}

					return false;
					});

					function fnFormatDetails( oTable03, nTr ){
					var oData = oTable03.fnGetData( nTr );
					var sOut =
					'<div class="innerDetails">'+
					'<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
					'<tr><td>'+oData.horaire+'</td></tr>'+
					'<tr><td>Ajouté le:</td><td>'+oData.created+'</td></tr>'+
					'</table>'+
					'</div>';
					return sOut;
					};


					/* Table initialisation */
					$(document).ready(function() {
					var responsiveHelper = undefined;
					var breakpointDefinition = {
					tablet: 1024,
					phone: 480
					};
					var tableElement = $('#product');

					tableElement.dataTable({
					"sPaginationType": "bootstrap",
					"oLanguage": {
					"sLengthMenu": "_MENU_ ",
					"sInfo": "Affichage _START_ to _END_ de _TOTAL_ entrées"
					},
					bAutoWidth: false,
					fnPreDrawCallback: function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper) {
					//responsiveHelper = new ResponsiveDatatablesHelper(tableElement, breakpointDefinition);
					}
					},
					fnRowCallback: function(nRow) {
					//responsiveHelper.createExpandIcon(nRow);
					},
					fnDrawCallback: function(oSettings) {
					//responsiveHelper.respond();
					}
					});

					$('#product_wrapper .dataTables_filter input').addClass("input-medium "); // modify table search input
					$('#product_wrapper .dataTables_length select').addClass("select2-wrapper col-md-12"); // modify table per page dropdown



					$('#product input').click(function() {
					$(this).parent().parent().parent().toggleClass('row_selected');
					});


					/*
					* Insert a 'details' column to the table
					*/
					var nCloneTh = document.createElement('th');
					var nCloneTd = document.createElement('td');
					nCloneTd.innerHTML = '<i class="fa fa-plus-circle"></i>';
					nCloneTd.className = "center";
					});


					$('#table-filter').on('change', function(){
				       $('#drillDownDataTable').dataTable().fnFilter(this.value);
				    });

				</script>
				<script type="text/javascript">




					function delItem(id){
						var a = confirm("Voulez-vous vraiment placer ce produit dans l'archive?");
						if(a){
							document.location.href='?action=delete&id='+id;
						}
					}
					function delTrash(id){
						var a = confirm("Voulez-vous vraiment supprimer définitivement ce produit?");
						if(a){
							document.location.href='?trash=true&action=deletetrash&id='+id;
						}
					}
					function Add(){
						jQuery('#ultraModal-add').modal('show', {backdrop: 'static'});
						jQuery.ajax({
						url: "module_ajax/products/add.php",
							success: function(response) {

							jQuery('#ultraModal-add .modal-body').html(response);
							var notif_widget = $(".perfect-scroll").height();
							$('.perfect-scroll').height(notif_widget).perfectScrollbar({suppressScrollX: true});
							}

						});
					}




					$('#form-add').validate({
						focusInvalid: false,
						ignore: "",
						rules: {
							titre: {
								required:true
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

						submitHandler: function(form) {
						//CKupdate();

						//uploadFile(file);
						            var formData = new FormData($(form)[0]);

						            	$.ajax({
                url: './module_ajax/products/validate.php',
                //data: $(form).serialize(),
                data: formData,
                type: "POST",
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                 beforeSend : function () {
                    // des actions avant d'envoyer ajax, comme faire apparaitre le div
                    console.log("before sendsing");
                    $('#msg-add').show().html('<label class="labelLoading">Téléchargement fiche technique ...</label><div id="loader"><div></div></div>');
                },
                success: function (result) {
							$('#msg-add').show().html(result);
							$('#msg-add').slideDown();
							$('#form-add #submit-add').removeAttr('disabled');
							if(result.match('success') != null){
										console.log("success");
								window.setTimeout(function () {
								$('#ultraModal-add').modal('hide');
								$('#msg-add').hide();
								window.location.href = "";
								}, 1000);

							}
                },
                 error: function(result) {
							$('#msg-add').show().html(result.responseText);
							$('#msg-add').slideDown();
							$('#form-add #submit-add').removeAttr('disabled');
							window.setTimeout(function () {
								$('#ultraModal-add').modal('hide');
								$('#msg-add').hide();
								window.location.href = "";
								}, 1000);
        }

            });


						//var action = $('#form-add').attr('action');




					// 	$.post(action, $('#form-add').serialize(),
					// 	function(data){
					// 		console.log("success");
					// 		$('#msg-add').show().html( data );
					// 		$('#msg-add').slideDown();
					// 		$('#form-add #submit-add').removeAttr('disabled');
					// 		if(data.match('success') != null){
					// 					console.log("success");
					// 			// window.setTimeout(function () {
					// 			// $('#ultraModal-add').modal('hide');
					// 			// $('#msg-add').hide();
					// 			// window.location.href = "";
					// 			// }, 1000);

					// 		}
					// 	}
					// );

						return false;
						}
					});





					function Edit(id) {
						jQuery('#ultraModal-edit').modal('show', {backdrop: 'static'});
						$('#msg-edit').html('');

						jQuery.ajax({
							url: "module_ajax/products/edit.php?id="+id,
							success: function(response){
								jQuery('#ultraModal-edit .modal-body').html(response);
								var notif_widget = $(".perfect-scroll").height();
								$('.perfect-scroll').height(notif_widget).perfectScrollbar({
								suppressScrollX: true
								});
							}
						});
					}

					$('#form-edit').validate({
					focusInvalid: false,
					ignore: "",
					rules: {
					titre: {
					required:true
					}
					},
					invalidHandler: function(event, validator) {
					
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

					submitHandler: function(form) {
					

					CKupdate();

					var action = $('#form-edit').attr('action');

					$.post(action, $('#form-edit').serialize(),
					function(data){
					$('#msg-edit').html(data);
					$('#msg-edit').slideDown();

					$('#form-edit #submit-edit').removeAttr('disabled');
					if(data.match('success') != null){


					window.setTimeout(function () {
					$('#ultraModal-edit').modal('hide');
					$('#msg-edit').hide();
					window.location.href = "";
					}, 500);

					}
					}
					);

					return false;

					}
					});


					//edit_table
					function edit_table_products(id) {
						jQuery('#ultraModal-edit-table').modal('show', {backdrop: 'static'});
						$('#msg-edit').html('');

						jQuery.ajax({
							url: "module_ajax/products/edit_table_products.php?id="+id,
							success: function(response)
							{
								jQuery('#ultraModal-edit-table .modal-body').html(response);
								var notif_widget = $(".perfect-scroll").height();
								$('.perfect-scroll').height(notif_widget).perfectScrollbar({
								suppressScrollX: true
								});
							}
						});
					}

					//edit_table
					function edit_table(id)
					{
					jQuery('#ultraModal-edit-table').modal('show', {backdrop: 'static'});
					$('#msg-edit').html('');

					jQuery.ajax({
					url: "module_ajax/products/edit_table.php?id="+id,
					success: function(response)
					{
					jQuery('#ultraModal-edit-table .modal-body').html(response);
					var notif_widget = $(".perfect-scroll").height();
					$('.perfect-scroll').height(notif_widget).perfectScrollbar({
					suppressScrollX: true
					});
					<!--multiple speciality-->
					$("#ultraModal-edit-table #speciality").select2({
					placeholder: 'Choisissez',
					allowClear: true
					}).on('select2-open', function() {
					// Adding Custom Scrollbar
					$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
					});

					$("#s2example-1").select2({
					placeholder: '...',
					allowClear: true
					}).on('select2-open', function() {
					// Adding Custom Scrollbar
					$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
					});	/* */
					}
					});
					}


					$('#form-edit-table').validate({
					focusInvalid: false,
					ignore: "",
					rules: {
					titre: {
					required:true
					}
					},
					invalidHandler: function(event, validator) {

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

					submitHandler: function(form) {

					var action = $('#form-edit-table').attr('action');

					$.post(action, $('#form-edit-table').serialize(),
					function(data){
					$('#msg-edit-table').html(data);
					$('#msg-edit-table').slideDown();

					$('#form-edit-table #submit-edit-column').removeAttr('disabled');
					if(data.match('success') != null){


						window.setTimeout(function () {
						$('#form-edit-table').modal('hide');
						$('#msg-edit-tablet').hide();
						window.location.href = "";
						}, 500);

					}
					}
					);

					return false;

					}
					});
					/***********************                     *****************************************/
					/*********************** tebleau des charges *****************************************/
					/***********************                     *****************************************/


					//edit_table
					function select_table_charge(id)
					{
					jQuery('#ultraModal-select-table_charge').modal('show', {backdrop: 'static'});
					$('#msg-edit_charge').html('');

					jQuery.ajax({
					url: "module_ajax/products/select_table_charge.php?id="+id,
					success: function(response)
					{
					$('#ultraModal-select-table_charge').show();
					jQuery('#ultraModal-select-table_charge .modal-body').html(response);
					}
					});
					}






					//edit_table
					function edit_table_charge(id)
					{
					$('#ultraModal-select-table_charge').hide();
					jQuery('#ultraModal-edit-table_charge').modal('show', {backdrop: 'static'});
					$('#msg-edit_charge').html('');

					jQuery.ajax({
					url: "module_ajax/products/edit_table_charge.php?id="+id,
					success: function(response)
					{
					jQuery('#ultraModal-edit-table_charge .modal-body').html(response);
					var notif_widget = $(".perfect-scroll").height();
					$('.perfect-scroll').height(notif_widget).perfectScrollbar({
					suppressScrollX: true
					});
					<!--multiple speciality-->
					$("#ultraModal-edit-table_charge #speciality").select2({
					placeholder: 'Choisissez',
					allowClear: true
					}).on('select2-open', function() {
					// Adding Custom Scrollbar
					$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
					});

					$("#s2example-1").select2({
					placeholder: '...',
					allowClear: true
					}).on('select2-open', function() {
					// Adding Custom Scrollbar
					$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
					});	/* */
					}
					});
					}


					$('#form-edit-table_charge').validate({
					focusInvalid: false,
					ignore: "",
					rules: {
					titre: {
					required:true
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

					submitHandler: function(form) {

					var action = $('#form-edit-table_charge').attr('action');

					$.post(action, $('#form-edit-table_charge').serialize(),
					function(data){
					$('#msg-edit-table_charge').html(data);
					$('#msg-edit-table_charge').slideDown();

					$('#form-edit-table_charge #submit-edit_table_charge').removeAttr('disabled');
					if(data.match('success') != null){


					window.setTimeout(function () {
					$('#ultraModal-edit-table_charge').modal('hide');
					$('#msg-edit-table_charge').hide();
					window.location.href = "";
					}, 500);

					}
					}
					);

					return false;

					}
					});
					/************************************************************************/
					/********************** TABLEAU DES CHARGES TYPE 2 **********************/
					/************************************************************************/

					//edit_table
					function edit_table_charge_type_2(id)
					{
					$('#ultraModal-select-table_charge').hide();
					$('#ultraModal-table_charge_type_2').hide();
					jQuery('#ultraModal-edit-table_charge_type_2').modal('show', {backdrop: 'static'});
					$('#msg-edit_charge').html('');

					jQuery.ajax({
					url: "module_ajax/products/edit_table_charge_type_2.php?id="+id,
					success: function(response)
					{
					jQuery('#ultraModal-edit-table_charge_type_2 .modal-body').html(response);

					}
					});

					}

					$('#form-edit-table_charge_type_2').validate({
					focusInvalid: false,
					ignore: "",
					rules: {
					titre: {
					required:true
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

					submitHandler: function(form) {

					var action = $('#form-edit-table_charge_type_2').attr('action');

					$.post(action, $('#form-edit-table_charge_type_2').serialize(),
					function(data){
					$('#msg-edit-table_charge_type_2').html(data);
					$('#msg-edit-table_charge_type_2').slideDown();

					$('#form-edit-table_charge_type_2 #submit-edit_table_charge_type_2').removeAttr('disabled');
					if(data.match('success') != null){


					window.setTimeout(function () {
					$('#ultraModal-edit-table_charge_type_2').modal('hide');
					$('#msg-edit-table_charge_type_2').hide();
					window.location.href = "";
					}, 500);

					}
					}
					);

					return false;

					}
					});


// $('#submit-add').click(function()
// {

//     $.ajax({
//         url : './module_ajax/products/validate.php', // demo url
//         type: 'POST',
//         data: $('#form-add').serialize(),
//         success : function(response)
//         {
//         $("#response").html(response);
//         }
//     });
// });



$('#submit-add').click(function()
{
$("#form-add").submit(function(e) {
    e.preventDefault();
}).validate({

    submitHandler: function(form) {
        alert("Do some stuff...");
        //submit via ajax
        return false;  //This doesn't prevent the form from submitting.
    }
});
});
					</script>