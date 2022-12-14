<?php include_once './includes/config.inc.php'; 




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
 					<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'> <?php echo notification(); ?> </div>
					<div class="clearfix"></div>
					<div class="col-lg-12">
						<section class="box ">
 							<header class="panel_header">
								<h2 class="title"><?= $nb_stock_min ?> produits en stock minimum</h2>
							</header>
							<div class="content-body">
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12"> 
										<!-- ********************************************** -->
										
										<table  class="table table-datatable table-custom" id="drillDownDataTable">
											<thead>
												<tr>
													<th>Code article</th>
													<th>D??signation</th>
													<th>Quantit??</th>
													<th>Stock</th>
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
		"sAjaxSource": "table/stock_min.php<?php echo $ajax_filter ?>",
		"aoColumns": [
		{ "mDataProp": "code_article" },
		{ "mDataProp": "designation" },
		{ "mDataProp": "quantite" },
		{ "mDataProp": "stock_min" },
		],
		"fnInitComplete": function(oSettings, json) { 
			$('.dataTables_filter input').attr("placeholder", "Rechercher");
			$('.iswitch').on('change', function() {
				var id = $(this).val();
				var object = $(this).data('object');
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
		'<tr><td>Ajout?? le:</td><td>'+oData.created+'</td></tr>'+
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
				"sInfo": "Affichage _START_ to _END_ de _TOTAL_ entr??es"
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
					
		var nCloneTh = document.createElement('th');
		var nCloneTd = document.createElement('td');
		nCloneTd.innerHTML = '<i class="fa fa-plus-circle"></i>';
		nCloneTd.className = "center";
	});

</script>
