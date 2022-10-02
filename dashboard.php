
<?php
	include_once './includes/config.inc.php';
	// Authenticate user login
	auth();
	
	if(isset($_GET['action']) && $_GET['action']=='delete') {
		
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
			$_SESSION['notification'] = array('type'=>'error','msg'=>'Id invalide');
			redirect(ROOT_URL.'dashboard.php');
		}
		
		if($db->update('demandes',array('statut'=>'deleted'),$_GET['id'])) {
			$_SESSION['notification'] = array('type'=>'succes','msg'=>'La commande a été supprimé avec succès');
			
			} else {
			$_SESSION['notification'] = array('type'=>'error','msg'=>'Il y a eu un problème S\'il vous plaît essayez de nouveau.');
		}
		redirect(ROOT_URL.'dashboard.php');
	}
	/*delete trash*/
	else if(isset($_GET['action']) && $_GET['action']=='deletetrash') {
		
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
			$_SESSION['notification'] = array('type'=>'error','msg'=>'Id invalide');
			redirect(ROOT_URL.'dashboard.php?trash=true');
		}
		
		if($db->update('demandes',array('statut'=>'deleted'),$_GET['id'],true)) {
			$_SESSION['notification'] = array('type'=>'succes','msg'=>'La commande a été supprimé avec succès');
			} else {
			$_SESSION['notification'] = array('type'=>'error','msg'=>'Il y a eu un problème S\'il vous plaît essayez de nouveau.');
		}
		redirect(ROOT_URL.'dashboard.php?trash=true');
	}
	/*restore trash*/
	else if(isset($_GET['action']) && $_GET['action']=='restore') {
		
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
			$_SESSION['notification'] = array('type'=>'error','msg'=>'Id invalide');
			redirect(ROOT_URL.'manage-responsables.php?trash=true');
		}
		if($db->update('demandes',array('statut'=>''),$_GET['id'])) {
			$_SESSION['notification'] = array('type'=>'succes','msg'=>'La commande a été restauré avec succès');
			} else {
			$_SESSION['notification'] = array('type'=>'error','msg'=>'Il y a eu un problème S\'il vous plaît essayez de nouveau.');
		}
		redirect(ROOT_URL.'dashboard.php?trash=true');
	}
	/**/
	$ajax_filter = '';

$nbr_produit  = get_nbr_produit();
function get_nbr_produit(){
	$db = db_connect();
	$query="SELECT count(*) as nbr_produit FROM products where deleted = 0 ";
	$nbr_produit = $db->get_row($query);
	return $nbr_produit;
}
$demande_en_attente = get_demande_en_attente();
function get_demande_en_attente(){
	$db = db_connect();
	$query="SELECT count(*) as en_attente FROM demandes where statut = '' ";
	$demande_en_attente = $db->get_row($query);
	return $demande_en_attente;
}
$nb_commandes=get_nb_commandes();
function get_nb_commandes(){
	$db = db_connect();
	$query="SELECT count(*) as nb_commandes FROM ordered_hx where state = 'En préparation' and deleted = 0";
	$nb_commandes = $db->get_row($query);
	return $nb_commandes;
}

$nb_expd_commandes=get_nb_expd_commandes();
function get_nb_expd_commandes(){
	$db = db_connect();
	$query="SELECT count(*) as nb_expd_commandes FROM ordered_hx where state = 'Expédié' and deleted = 0";
	$nb_expd_commandes = $db->get_row($query);
	return $nb_expd_commandes;
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
			.iconp{
				float: left;
    			margin-right: 4px;
    			font-size: 30px;
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


		<? if($_SESSION['User']['role']=='superadmin'): ?><!-- rr-->




			<section id="main-content" class=" ">
				<section class="wrapper">

					<div class="row m-t-25">
						<div class="col-sm-6 col-lg-4">
							<a href="commandes-en-attentes.php">
								<div class="overview-item item--c3">
									<div class="overview__inner">
										<div class="overview-box clearfix">
											<div class="icon">
												<i class="ti-shopping-cart c-yellow"></i>
												<h2 class="nb-dash"><?php echo $nb_commandes['nb_commandes']; ?></h2>
											</div>
											<div class="text">
												<span>Commandes en attente</span>
											</div>
										</div>
									</div>  
								</div>
							</a>
						</div>
						<div class="col-sm-6 col-lg-4">
							<a href="commandes-expediees.php">
								<div class="overview-item item--c2">
									<div class="overview__inner">
										<div class="overview-box clearfix">
											<div class="icon">
												<i class="ti-truck c-green"></i>
												<h2 class="nb-dash"><?php echo $nb_expd_commandes['nb_expd_commandes']; ?></h2>
											</div>
											<div class="text">
												<span>Commandes en cours d'éxpedition</span>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
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


					</div>
					<div class="row m-t-25">
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
						<div class="col-sm-6 col-lg-4">
							<a href="manage-products.php">
								<div class="overview-item item--c2">
									<div class="overview__inner">
										<div class="overview-box clearfix">
											<div class="icon">
												<i class="ti-layout-list-thumb-alt c-orange"><span class="iconp"></span></i>
												<h2 class="nb-dash"><?php echo $demande_en_attente['en_attente']; ?></h2>
											</div>
											<div class="text">
												<span>Pack personnalisés</span>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>


					</div>

 				<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'> <?php echo notification(); ?> </div>
					<div class="clearfix"></div>
					<div class="col-lg-12">
						<section class="box ">
 					
 							<header class="panel_header">
								<h2 class="title">Liste des demandes des packs personnalisés</h2>
							</header>

							<div class="content-body">
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12"> 
										<!-- ********************************************** -->
										
										<table  class="table table-datatable table-custom" id="drillDownDataTable">
											<thead>
												<tr>
													<th>Client</th>
													<th>Référence</th>
													<th>Composants</th>
													<th>Titre</th>
													<th>Emballage</th>
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
 					<div class="modal-body" > Voulez-vous changer le statut de la commande en "Traitée" ? </div>
					<div class="modal-footer"> 
						<button type="button" class="btn btn-white" data-dismiss="modal" onclick="annlerDemande()">Annuler</button>
						<button type="submit" id="submit-edit" class="btn btn-info" onclick="validerDemande();">Valider</button>
					</div>
				</div>
			</div>
		</div>

		<!--Détails demande -->
		<div class="modal fade" id="details-demande">
			<div class="modal-dialog" style="width:40%;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Détails de la demande </h4>
					</div>
					<div id="msg-edit" style="padding:15px; display:none"> </div>
					<div class="modal-body" > loading... </div>
				</div>
			</div>
		</div>

		<!--Détails du client-->
		<div class="modal fade" id="details-client">
			<div class="modal-dialog" style="width:40%;">
				<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Détails du client </h4>
						</div>
						<div id="msg-edit" style="padding:15px; display:none"> </div>
						<div class="modal-body" > loading... </div>
				</div>
			</div>
		</div>
		<!--edit a modifier-->
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
							<h4 class="modal-title">Tableau des composants</h4>
						</div>
						<div id="msg-edit-table" style="padding:15px; display:none"> </div>
						<div class="modal-body" > loading... </div>
						
					</form>
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
					"iDisplayLength": <?php print $ConfigDefault['filedefnum']; ?>,
					"oLanguage": {
					"oPaginate": {
					"sNext": "<?php print $lang['sNext']; ?>",
					"sPrevious": "<?php print $lang['sPrevious']; ?>"
					},
					"sSearch": "<?php print $lang['sSearch']; ?>",
					"sEmptyTable": "<?php print $lang['sEmptyTable']; ?>",
					"sInfoFiltered": "<?php print $lang['sInfoFiltered']; ?>",
					"infoEmpty": "<?php print $lang['infoEmpty']; ?>",
					"sLengthMenu": "<?php print $lang['sLengthMenu']; ?>",
					"sInfo": "<?php print $lang['sInfo']; ?>",
					"sZeroRecords": "<?php print $lang['sZeroRecords']; ?>"
					},
					"aoColumnDefs": [
					{ 'bSortable': false, 'aTargets': [ "no-sort" ] }
					],
					"aaSorting": [[ 1, "asc" ]],
					"bProcessing": true,
					"sAjaxSource": "table/demandes.php<?php echo $ajax_filter ?>",
					"aoColumns": [
					{ "mDataProp": "client" },
					{ "mDataProp": "Ref" },
					{ "mDataProp": "tableau" },
					{ "mDataProp": "titre_fr" },
					{ "mDataProp": "emballage" },
					{ "mDataProp": "statut" },
					{ "mDataProp": "action" },
					],
					
					"fnInitComplete": function(oSettings, json) { 
					$('.dataTables_filter input').attr("placeholder", "Rechercher");
					$('.iswitch').on('change', function() {
					
					var id = $(this).val();
					var object = $(this).data('object');
					
					
					/*$.ajax({
					type: "GET",
					dataType:"html",
					url: "./includes/change-statut-demandes.php?object="+object+"&id="+id,
					success: function(data){
					if(data.match('success') != null){
					showSuccess('Succés')
					}else{
					showErrorMessage(data)
					}
					}
					});*/
					// Does some stuff and logs the event to the console
					// showErrorMessage('Ops! Something went wrong');
					});
					$('[rel="tooltip"]').each(function() {
					var animate = $(this).attr("data-animate");
					var colorclass = $(this).attr("data-color-class");
					$(this).tooltip({
					template: '<div class="tooltip ' + animate + ' ' + colorclass + '"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
					});
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
					"aoColumnDefs": [{
					'bSortable': false,
					'aTargets': [0]
					}],
					"aaSorting": [
					[1, "asc"]
					],
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
					
					
				</script>
				<script type="text/javascript">
					
					function delItem(id){
						
						var a = confirm("Voulez-vous vraiment placer la commande dans la Corbeille?");
						if(a){
							document.location.href='?action=delete&id='+id;
						}
						
					}
					function delTrash(id){
						
						var a = confirm("Voulez-vous vraiment supprimer définitivement la commande?");
						if(a){
							document.location.href='?trash=true&action=deletetrash&id='+id;
						}
						
					}
					
					function detailsDemande(id){
						jQuery('#details-demande').modal('show', {backdrop: 'static'});

						jQuery.ajax({
							url: "module_ajax/demandes/detaills.php?id="+id,
							success: function(response)
							{
								jQuery('#details-demande .modal-body').html(response);
								var notif_widget = $(".perfect-scroll").height();
								$('.perfect-scroll').height(notif_widget).perfectScrollbar({
									suppressScrollX: true
								});
								 
							}
						});
					}

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

					function detailsClient(id)
					{
						jQuery('#details-client').modal('show', {backdrop: 'static'});

						jQuery.ajax({
							url: "module_ajax/client/show.php?id="+id,
							success: function(response)
							{
								jQuery('#details-client .modal-body').html(response);
								var notif_widget = $(".perfect-scroll").height();
								$('.perfect-scroll').height(notif_widget).perfectScrollbar({
									suppressScrollX: true
								});
								 
							}
						});

					}

					function Edit(id)
					{
					jQuery('#ultraModal-edit').modal('show', {backdrop: 'static'});
					$('#msg-edit').html('');
					
					jQuery.ajax({
					url: "module_ajax/products/edit.php?id="+id,
					success: function(response)
					{
					jQuery('#ultraModal-edit .modal-body').html(response);
					var notif_widget = $(".perfect-scroll").height();
					$('.perfect-scroll').height(notif_widget).perfectScrollbar({
					suppressScrollX: true
					});
					<!--multiple speciality-->
					$("#ultraModal-edit #speciality").select2({
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
					$('#form-edit').validate({
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
					function edit_table(id){
						jQuery('#ultraModal-edit-table').modal('show', {backdrop: 'static'});
						$('#msg-edit').html('');
						
						jQuery.ajax({
							url: "module_ajax/products/show_compos.php?id="+id,
							success: function(response){
								$('#ultraModal-edit-table .modal-body').html(response);
							}
						});
					}
					
					
					/*$('#form-edit-table').validate({
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
					
					var action = $('#form-edit-table').attr('action'); 
					
					$.post(action, $('#form-edit-table').serialize(),
					function(data){
					$('#msg-edit-table').html(data);
					$('#msg-edit-table').slideDown();
					
					$('#form-edit-table #submit-edit-column').removeAttr('disabled');
					if(data.match('success') != null){
					
					
					window.setTimeout(function () {
					$('#ultraModal-edit-column').modal('hide');
					$('#msg-edit-tablet').hide();
					window.location.href = "";
					}, 500);
					
					}
					}
					);
					
					return false;
					
					}
					});  */
			</script>																		