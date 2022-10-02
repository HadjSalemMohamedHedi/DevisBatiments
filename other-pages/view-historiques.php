<?php
	include_once './includes/config.inc.php';
	// Authenticate user login
	auth();
	$ajax_filter = '';
	
		if(isset($_GET['action']) && $_GET['action']=='delete_history') {
		if($db->query("DELETE FROM tracing")){
			$_SESSION['notification'] = array('type'=>'succes','msg'=>'L\'historique a été supprimé avec succès');
			
			} else {
			$_SESSION['notification'] = array('type'=>'error','msg'=>'Il y a eu un problème S\'il vous plaît essayez de nouveau.');
		}
		redirect(ROOT_URL.'view-historiques.php');
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
		
        <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />    <!-- Favicon -->
        <link rel="apple-touch-icon-precomposed" href="assets/images/apple-touch-icon-57-precomposed.png">	<!-- For iPhone -->
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/apple-touch-icon-114-precomposed.png">    <!-- For iPhone 4 Retina display -->
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/apple-touch-icon-72-precomposed.png">    <!-- For iPad -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/apple-touch-icon-144-precomposed.png">    <!-- For iPad Retina display -->
		
		
		
		
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
        <link href="assets/plugins/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" type="text/css" media="screen"/>        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 
		
        
         <!-- messenger --> 
        <link href="assets/plugins/messenger/css/messenger.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/messenger/css/messenger-theme-future.css" rel="stylesheet" type="text/css" media="screen"/><link href="assets/plugins/messenger/css/messenger-theme-flat.css" rel="stylesheet" type="text/css" media="screen"/>        <!-- END -->  
		
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
			.company{
			display:none;
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
                <section class="wrapper" style='margin-top:60px;display:inline-block;width:100%;padding:15px 0 0 15px;'>
					  <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                        <div class="page-title">

                            <div class="pull-left">
                                <h1 class="title"><i class="fa fa-history " style="    font-size: 38px;"></i> Historiques</h1>  
                            </div>
                            <div class="pull-right">
                                  <button type="button" class="btn btn-secondary btn-icon bottom15 right15" onclick="delHistory()"> <i class="fa fa-trash"></i> &nbsp; <span>Vider L'historique</span></button>
                            </div>
                        </div>
                    </div>
	
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
						<?php echo notification(); ?>
					</div>
                    <div class="clearfix"></div>
                    
					<div class="col-lg-12">
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title pull-left">Historique</h2>
                                <div class="actions panel_actions pull-right">
                                    <i class="box_toggle fa fa-chevron-down"></i>
                                    
                                    <i class="box_close fa fa-times"></i>
								</div> 
                               
							</header>
                           
                            <div class="content-body">   
                            
                            
                             <div class="row">
                           
								<div class="col-md-12 col-sm-12 col-xs-12">
									<!-- ********************************************** -->
									
									<table  class="table table-datatable table-custom" id="drillDownDataTable">
										<thead>
											<tr>
												<th class="no-sort" style="width:45px;"></th>
												<th>Date</th>
                                                <th>Objet</th>
                                                <th>Type</th>
                                                <th>User</th>
												<th>SQL</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div></div>
							</div>
							<!--  *********************************************** -->
							
							
							
						</section></div>
                        
                        <!---->
						
				</section>
			</section>
            <!-- END CONTENT -->
            
			
			
            <div class="chatapi-windows ">
				
				
			</div>    </div>
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
		
	</body>
</html>
<script type="text/javascript">
function delHistory(){
					
					var a = confirm("Voulez-vous vraiment supprimer toutes l'historiques?");
					if(a){
						document.location.href='?action=delete_history';
					}
					
				}
	/* Table initialisation */
	
	
	
	/******************************************************/
		/**************** DRILL DOWN DATATABLE ****************/
			/******************************************************/
				
				var anOpen = [];
				
				var oTable03 = $('#drillDownDataTable').dataTable({
					"sDom": "<'row'<'col-md-6'l T><'col-md-6'f>r>t<'row'<'col-md-12'p i>>",
                    "oTableTools": {
                        "aButtons": [{
                            "sExtends": "collection",
                            "sButtonText": "<i class='fa fa-cloud-download'></i>",
                            "aButtons": ["csv", "xls", "pdf", "copy"]
						}]
					},
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
					"aaSorting": [[ 1, "desc" ]],
					"bProcessing": true,
					"serverSide": true,
					"sAjaxSource": "table/historiques.php<?php echo $ajax_filter ?>",
					"aoColumns": [
					{ "mDataProp": "id" },
					{ "mDataProp": "created" },
					{ "mDataProp": "object" },
					{ "mDataProp": "type" },
					{ "mDataProp": "id_user" },
					{ "mDataProp": "sql_execute" }
					
					],
					"fnInitComplete": function(oSettings, json) { 
						$('.dataTables_filter input').attr("placeholder", "Rechercher");
						$('.iswitch').on('change', function() {
					
					var id = $(this).val();
					var object = $(this).data('object');
					
					
					$.ajax({
													type: "GET",
													dataType:"html",
													url: "./includes/change-statut-responsable.php?object="+object+"&id="+id,
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
					var tableElement = $('#users');
					
					tableElement.dataTable({
						"sDom": "<'row'<'col-md-6'l T><'col-md-6'f>r>t<'row'<'col-md-12'p i>>",
						"oTableTools": {
							"aButtons": [{
								"sExtends": "collection",
								"sButtonText": "<i class='fa fa-cloud-download'></i>",
								"aButtons": ["csv", "xls", "pdf", "copy"]
							}]
						},
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
					
					$('#users_wrapper .dataTables_filter input').addClass("input-medium "); // modify table search input
					$('#users_wrapper .dataTables_length select').addClass("select2-wrapper col-md-12"); // modify table per page dropdown
					
					
					
					$('#users input').click(function() {
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