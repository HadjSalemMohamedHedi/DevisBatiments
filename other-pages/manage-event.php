<?php
	include_once './includes/config.inc.php';
	
	// Authenticate user login
	auth();
	
	if(isset($_GET['action']) && $_GET['action']=='delete') {
		
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
			$_SESSION['notification'] = array('type'=>'error','msg'=>'Id invalide');
			redirect(ROOT_URL.'manage-responsables.php');
		}
		
		if($db->delete('calendar',$_GET['id'])) {
			$_SESSION['notification'] = array('type'=>'succes','msg'=>'le rendez-vous a été supprimé avec succès');
			} else {
			$_SESSION['notification'] = array('type'=>'error','msg'=>'Il y a eu un problème S\'il vous plaît essayez de nouveau.');
		}
		redirect(ROOT_URL.'manage-event.php');
	}
	$ajax_filter = '';
	if(isset($_GET['all_event'])){
		$ajax_filter = '?all_event';
	}
	
	if(isset($_POST['filter']))
	{
		$explode = explode('||',$_POST["intervalle"]);
		if(strtotime($explode[0])&& strtotime($explode[1]))
		{
			$_SESSION['start']= $start=date('Y-m-d 00:00:00',strtotime($explode[0]));
			$_SESSION['end']= $end=date('Y-m-d 23:59:59',strtotime($explode[1])); 
			$_SESSION['id_search']=($_POST["filter_par"]=='commercial')?$db->escape($_POST['id_commercial_search']):$db->escape($_POST['id_responsable_search']);
			
			$ajax_filter.=($ajax_filter!='')?'&star='.$start.'&end='. $end.'&statut='.$db->escape($_POST['statut']):'?star='.$start.'&end='. $end.'&statut='.$db->escape($_POST['statut']); 
			$ajax_filter.=($_POST["filter_par"]=='commercial')?'&id_commercial='.$db->escape($_POST['id_commercial_search']):'&id_responsable='.$db->escape($_POST['id_responsable_search']);
		}
		else{ $_SESSION['notification'] = array('type'=>'error','msg'=>'- L\'intervalle de temps est obligatoire.');}
	}
	
	$filter_comm='';
	$filter_resp='';
	if($_SESSION['User']['classe']=='4'){
		$filter_comm="AND id_responsible='".$_SESSION['User']['id']."'";
		$filter_resp="AND id='".$_SESSION['User']['id']."'";
	}
	if($_SESSION['User']['classe']=='2'){
		$filter_comm=$filter_resp=" AND id_contributor='".$_SESSION['User']['id']."'";
	}		
	$responsables = $db->get_rows("SELECT users.* FROM users WHERE users.classe='4' AND  status !=0 AND deleted=0 $filter_resp"); 
	$commerciaux = $db->get_rows("SELECT * FROM users WHERE users.classe='3' AND  status !=0 AND deleted=0 $filter_comm");
?>

<!DOCTYPE html>
<html class=" ">
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
		.lawyer_list{
		display:none;
		}
		
		.fc-basic-view tbody .fc-row {
		min-height: 2em !important;
		}
		.fc-center h2{
		padding-top:4px;
		font-size:22px !important;
		}
		.company{
		display:none;
		}
		.clsDatePicker,.datepicker,.bootstrap-timepicker-widget {
		z-index: 100000 !important;
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
							<h1 class="title">Liste des rendez-vous</h1>  
						</div>
						
					</div>
				</div>
				<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden' >
					<div class="page-title">
						<nav class="navbar navbar-default">
							<div class="container-fluid"> 
								<!-- Ultra Admin and toggle get grouped for better mobile display -->
								
								<div class="collapse navbar-collapse pull-right" id="bs-example-navbar-collapse-3">
									<button type="button" class="btn btn-default navbar-btn btn-icon" data-toggle="modal" href="#section-cancel"> <i class="box_setting fa fa-minus" ></i> &nbsp; <span>Fermer des dates</span></button>
									<button type="button" class="btn btn-default navbar-btn btn-icon" onclick="Addevent();"> <i class="fa fa-plus-square"></i> &nbsp; <span>Ajouter une réservation</span></button>
								</div>
							</div>
							<!-- /.container-fluid --> 
						</nav>
					</div>
				</div>
				
				<!---->
				
				<div class="clearfix"></div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<section class="box ">
						<div class="content-body">
							<div class="row"> <?php echo notification(); ?>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="row" <?=($_SESSION['User']['classe']=='3')?'style="display:none"':''?> >
										<form method="post" action="manage-event.php">
											<h3>Filtrer Par:</h3>
											<ul class="list-unstyled">
												<li style="display: inline;width: 50%;}">
													<input tabindex="5" type="radio"  name="filter_par" class="icheck-custom" value="commercial" <?=(isset($_POST['filter_par']) && $_POST['filter_par']=="commercial")?'checked':''?>>
													<label class="iradio-label form-label">Commercial</label>
												</li>
												<li style="display: inline;width: 50%;margin-left: 20px;}">
													<input tabindex="5" type="radio" class="icheck-custom" name="filter_par" value="responsable" <?=(!isset($_POST['filter_par']) ||( isset($_POST['filter_par']) && $_POST['filter_par']=="responsable"))?'checked':''?>>
													<label class="iradio-label form-label" >Responsable</label>
												</li>  
											</ul>      
											
											<div class="col-lg-3 col-md-4">
												<div class="form-group">
													<label class="" for="daterange-2">Intervalle</label>
													<input type="text" id="daterange-2" name="intervalle" class="form-control daterange" data-format="DD-MM-YYYY" data-start-date="<?php echo date('d-m-Y',strtotime("-1 month", time())) ?>" data-end-date="<?php echo date('d-m-Y',strtotime("+1 month", time())) ?>" data-separator="||" value="<?php if(isset($_POST['intervalle'])){ echo $_POST['intervalle'];}?>">
												</div>
											</div>
											
											
											
											<div class="col-lg-3 col-md-3">
												<div class="form-group commercial">
													<label class="" for="id_commercial_search">Commercial</label>
													<select class="form-control" name="id_commercial_search" id="id_commercial_search">
														<option value="">==========</option>
														<?php foreach($commerciaux as $k=>$v):?>
														<option value="<?php echo $v['id'] ?>" <?php if(isset($_POST['id_commercial_search']) && $_POST['id_commercial_search']==$v['id']){?> selected="selected" <?php }?>><?php echo $v['firstname']." ". $v['lastname'];?></option>
														<?php endforeach;?>
													</select>
												</div>
												
												<div class="form-group responsable" style="display:none">
													<label class="" for="id_responsable_search">Responsable</label>
													<select class="form-control" name="id_responsable_search" id="id_responsable_search">
														<option value="">==========</option>
														<?php foreach($responsables as $k=>$v):?>
														<option value="<?php echo $v['id'] ?>" <?php if(isset($_POST['id_responsable_search']) && $_POST['id_responsable_search']==$v['id']){?> selected="selected" <?php }?>><?php echo $v['firstname']." ". $v['lastname'];?></option>
														<?php endforeach;?>
													</select>
												</div>
												
											</div>
											<div class="col-lg-3 col-md-3">
												<div class="form-group">
													<label class="" for="statut">Statut</label>
													<select class="form-control" name="statut" id="statut">
														<option value="">==========</option>
														<option value="0" <?php if(isset($_POST['statut']) && $_POST['statut']=='0'){?> selected="selected" <?php }?>>En cours</option>
														<option value="1" <?php if(isset($_POST['statut']) && $_POST['statut']=='1'){?> selected="selected" <?php }?>>Confirmé</option>
														<option value="2" <?php if(isset($_POST['statut']) && $_POST['statut']=='2'){?> selected="selected" <?php }?>>Validé</option>
														<option value="3" <?php if(isset($_POST['statut']) && $_POST['statut']=='3'){?> selected="selected" <?php }?>>Annulé</option>
														<option value="5" <?php if(isset($_POST['statut']) && $_POST['statut']=='5'){?> selected="selected" <?php }?>>A repositionner</option>
														<option value="6" <?php if(isset($_POST['statut']) && $_POST['statut']=='6'){?> selected="selected" <?php }?>>RDV Perso<</option>
														</select>
														</div>
													</div>
													
													<div class="col-md-2" style="padding-top:26px;">
														<?php if (isset($_POST["intervalle"])) { 
															$explode = explode('||',$_POST["intervalle"]);
															if(strtotime($explode[0])&& strtotime($explode[1])){
															?>
															<input type="hidden" id="start" value="<?php echo $explode[0]; ?>">
															<input type="hidden" id="end" value="<?php echo $explode[1]; ?>">
														<?php }}?>
														<button type="submit" name="filter" class="btn btn-success">filtrer</button>
														<? if(isset($_POST['filter']) && isset( $_SESSION['start']) && isset( $_SESSION['end']) && isset( $_SESSION['id_search'])){?>
															<button type="button"  class="btn btn-default navbar-btn btn-icon" onclick="window.open('pdf/rapport_to_pdf.php','_blank')" > <i class="box_setting fa fa-print " ></i> &nbsp; <span>Imprimer</span></button>
														<? }?>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</section>
						</div>
						<div class="clearfix"></div>
						
						<!---->
						<div class="col-lg-12">
							<section class="box ">
								<header class="panel_header">
									<h2 class="title pull-left">Réservations</h2>
									<div class="actions panel_actions pull-right">
										<button type="button" class="btn btn-default navbar-btn btn-icon" onclick="document.location.href='manage-event.php?all_event'"> <i class="box_setting fa fa-eye" ></i> &nbsp; <span>Voir tout</span></button>
										<button type="button" class="btn btn-default navbar-btn btn-icon" onclick="Addevent();"> <i class="fa fa-plus-square"></i> &nbsp; <span>Ajouter une réservation</span></button>
									</div>
								</header>
								<div class="content-body">
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12"> 
											<!-- ********************************************** -->
											<table  class="table table-datatable table-custom" id="drillDownDataTable">
												<thead>
													<tr>
														<th width="2%">Ref</th>
														<th width="5%">Début</th>
														<th width="5%">Fin</th>
														<th width="10%">Responsable</th>
														<th width="100">Commercial</th>
														<th width="100">Description</th>
														<th width="10%">Commentaire commerciale</th>
														<th width="15%">Client</th>
														<th width="6%">Action</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
											
											<!--  *********************************************** --> 
											
										</div>
									</div>
								</div>
							</section>
						</div>
						
						<!----> 
						
					</section>
				</section>
				<!-- END CONTENT -->
				
				
				<div class="chatapi-windows ">
					
					
				</div>
			</div>
			<!--ADD-->
			
			<div class="modal fade" id="ultraModal-add">
				<div class="modal-dialog">
					<div class="modal-content">
						<form id="event-add" class="" action="./includes/validate-event.php" method="post">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Ajouter un rendez-vous</h4>
							</div>
							<div class="modal-body perfect-scroll" > </div>
							<div class="modal-footer"> 
								<!--<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>-->
								<button type="submit" id="submit-add" class="btn btn-info">Valider</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!--edit-->
			<div class="modal fade " id="ultraModal-edit" >
				<div class="modal-dialog">
					<div class="modal-content">
						<form id="event-edit" class="" action="./includes/validate-event.php" method="post">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Modifier le rendez-vous</h4>
							</div>
							<div class="modal-body perfect-scroll" > </div>
							<div class="modal-footer"> 
								<!--<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>-->
								<button type="submit" id="submit-edit" class="btn btn-info">Valider</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			
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
			
			
			<script type="text/javascript">
				jQuery(function($) {
					
					'use strict';
					if ($.isFunction($.fn.datetimepicker)) {
						
						$('.form_datetime_lang').datetimepicker({
							language: 'fr',
							todayBtn: 1,
							autoclose: 1,
							todayHighlight: 1,
							startView: 2,
							forceParse: 0,
							showMeridian: 0
						});
					}
				});
				var responsiveHelper = undefined;
                var breakpointDefinition = {
                    tablet: 1024,
                    phone: 480
				};
				
				
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
								"iDisplayLength": 100,
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
										{ 'bSortable': true, 'aTargets': [ "no-sort" ] }
										],
										"aaSorting": [[ 1, "asc" ]],
										"bProcessing": true,
										"sAjaxSource": "table/events.php<?= $ajax_filter ?>",
										"aoColumns": [
										{ "mDataProp": "id" },
										{ "mDataProp": "start", "sType": "date-euro","bSortable": "true"},
										{ "mDataProp": "end" , "sType": "date-euro","bSortable": "true"},
										{ "mDataProp": "name_resp" },
										{ "mDataProp": "name_commer" },
										{ "mDataProp": "description" },
										{ "mDataProp": "comment" },
										{ "mDataProp": "client" },
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
									
								</script> 
								<script type="text/javascript">
									
									function delItem(id){
										
										var a = confirm("Voulez-vous vraiment placer ce rendez-vous dans la Corbeille?");
										if(a){
											document.location.href='?action=delete&id='+id;
										}
										
									}
									function delTrash(id){
										
										var a = confirm("Voulez-vous vraiment supprimer définitivement cet rendez-vous?");
										if(a){
											document.location.href='?trash=true&action=deletetrash&id='+id;
										}
										
									}            	
								</script>
								<script type="text/javascript">
									
									function Editevent(id)
									{
										jQuery('#ultraModal-edit').modal('show', {backdrop: 'static'});
										
										jQuery.ajax({
											url: "event-edit.php?id_event="+id,
											success: function(response)
											
											{
												jQuery('#ultraModal-edit .modal-body').html(response);
												
												var notif_widget = $(".perfect-scroll").height();
												$('.perfect-scroll').height(notif_widget).perfectScrollbar({
													suppressScrollX: true
												});
												
												$("#id_commercial").select2({
													placeholder: 'Choisissez',
													allowClear: true
													}).on('select2-open', function() {
													// Adding Custom Scrollbar
													$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
												});
												$("#id_responsible").select2({
													placeholder: 'Choisissez',
													allowClear: true
													}).on('select2-open', function() {
													// Adding Custom Scrollbar
													$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
												});
												
												$('.form_datetime_lang').datetimepicker({
													language: 'fr',
													weekStart: 1,
													todayBtn: 1,
													autoclose: 1,
													todayHighlight: 1,
													startView: 2,
													forceParse: 0,
													showMeridian: 0
												});
												
												
												$('input.icheck-custom').on('ifClicked', function(event){
													
													var val =$(this).attr('value');
													
													
													}).iCheck({
													checkboxClass: 'icheckbox_minimal',
													radioClass: 'iradio_minimal',
													increaseArea: '20%'
												});
												
												$('#id_client').on('change', function() {
													option_val = $(this).val();
													
													if(option_val=='add'){
														window.setTimeout(function () {
															window.location.href = "client-add.php?redirect=booking";
														}, 1);
													}
												});
											}
										});
									}
									
									
									
									function Addevent()
									{
										jQuery('#ultraModal-add').modal('show', {backdrop: 'static'});
										
										jQuery.ajax({
											url: "event-add.php",
											success: function(response)
											{
												jQuery('#ultraModal-add .modal-body').html(response);
												var notif_widget = $(".perfect-scroll").height();
												$('.perfect-scroll').height(notif_widget).perfectScrollbar({
													suppressScrollX: true
												});
												
												$("#id_commercial").select2({
													placeholder: 'Choisissez',
													allowClear: true
													}).on('select2-open', function() {
													// Adding Custom Scrollbar
													$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
												});
												$("#id_responsible").select2({
													placeholder: 'Choisissez',
													allowClear: true
													}).on('select2-open', function() {
													// Adding Custom Scrollbar
													$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
												});
												
												$('.form_datetime_lang').datetimepicker({
													language: 'fr',
													weekStart: 1,
													todayBtn: 1,
													autoclose: 1,
													todayHighlight: 1,
													startView: 2,
													forceParse: 0,
													showMeridian: 0
												});
												
												
												
												$('input.icheck-custom').on('ifClicked', function(event){
													
													var val =$(this).attr('value');
													if(val==2){
														$('.lawyer_list').slideDown(500);
														//$('#company').attr('required', 'required');
														}else {
														$('.lawyer_list').slideUp(500); 
														//$('#company').removeAttr('required'); 
													}
													}).iCheck({
													checkboxClass: 'icheckbox_minimal',
													radioClass: 'iradio_minimal',
													increaseArea: '20%'
												});
												
											}
										});
									}
									<?php if(isset($_GET['id_client']) && is_numeric($_GET['id_client'])){?>
										$(document).ready(function() {	
										jQuery('#ultraModal-add').modal('show', {backdrop: 'static'});
										
										jQuery.ajax({
										url: "event-add.php?id_client=<?php echo $_GET['id_client']; ?>",
										success: function(response)
										{
										jQuery('#ultraModal-add .modal-body').html(response);
										var notif_widget = $(".perfect-scroll").height();
										$('.perfect-scroll').height(notif_widget).perfectScrollbar({
										suppressScrollX: true
										});
										
										
										$("#id_commercial").select2({
										placeholder: 'Choisissez',
										allowClear: true
										}).on('select2-open', function() {
										// Adding Custom Scrollbar
										$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
										});
										$("#id_responsible").select2({
										placeholder: 'Choisissez',
										allowClear: true
										}).on('select2-open', function() {
										// Adding Custom Scrollbar
										$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
									});
									
									$('.form_datetime_lang').datetimepicker({
										language: 'fr',
										
										weekStart: 1,
										todayBtn: 1,
										autoclose: 1,
										todayHighlight: 1,
										startView: 2,
										forceParse: 0,
										showMeridian: 0
									});
									
									$('.form_datetime_lang').on('change', function() {
										option_val =  $('#dtpick_3').val();
										
										jQuery.ajax({
											url: "includes/get-personal.php?date="+option_val,
											success: function(response)
											{
												$('.employer').html(response);
											}
											
										});
									});
									
									$('input.icheck-custom').on('ifClicked', function(event){
										
										var val =$(this).attr('value');
										if(val==2){
											$('.lawyer_list').slideDown(500);
											//$('#company').attr('required', 'required');
											}else {
											$('.lawyer_list').slideUp(500); 
											//$('#company').removeAttr('required'); 
										}
										}).iCheck({
										checkboxClass: 'icheckbox_minimal',
										radioClass: 'iradio_minimal',
										increaseArea: '20%'
									});
									
									$('#id_client').on('change', function() {
										option_val = $(this).val();
										
										if(option_val=='add'){
											window.setTimeout(function () {
												window.location.href = "client-add.php?redirect=booking";
											}, 1);
										}
									});
									
									
								}
							});
						});                      
					<?php }?>								
					
				</script>
				<script language="javascript">
					$(document).ready(function() {
						
						
						
						$('input.icheck-custom').on('ifClicked', function(event){
							
							var val =$(this).attr('value');
							console.log(val);
							if(val=='commercial'){
								$(".commercial").slideToggle();
								$(".responsable").slideUp();
								}else{
								$(".responsable").slideToggle();
								$(".commercial").slideUp();
							}
							}).iCheck({
							checkboxClass: 'icheckbox_minimal',
							radioClass: 'iradio_minimal',
							increaseArea: '20%'
						});
						
						
						
						var val_filter= $('input.icheck-custom').attr('value');
						if(val_filter =='responsable'){
							console.log(val_filter);
							$(".commercial").slideToggle();
							$(".responsable").slideUp();
							}else{
							$(".responsable").slideToggle();
							$(".commercial").slideUp();
						}
						
						
					});
					
					
					
					function trim(str) {
						str = str.replace(/^\s+/, '');
						for (var i = str.length - 1; i >= 0; i--) {
							if (/\S/.test(str.charAt(i))) {
								str = str.substring(0, i + 1);
								break;
							}
						}
						return str;
					}
					
					function dateHeight(dateStr){
						if (trim(dateStr) != '') {
							var frDate = trim(dateStr).split(' ');
							var frTime = frDate[1].split(':');
							var frDateParts = frDate[0].split('/');
							var day = parseInt(frDateParts[0]) * 60 * 24;
							var month = parseInt(frDateParts[1]) * 60 * 24 * 31;
							var year = parseInt(frDateParts[2]) * 60 * 24 * 366;
							var hour = frTime[0] * 60;
							var minutes = frTime[1];
							var x = day+month+year+hour+minutes;
							} else {
							var x = 99999999999999999; //GoHorse!
						}
						return x;
					}
					
					jQuery.fn.dataTableExt.oSort['date-euro-asc'] = function(a, b) {
						var x = dateHeight(a);
						var y = dateHeight(b);
						var z = ((x < y) ? -1 : ((x > y) ? 1 : 0));
						return z;
					};
					
					jQuery.fn.dataTableExt.oSort['date-euro-desc'] = function(a, b) {
						var x = dateHeight(a);
						var y = dateHeight(b);
						var z = ((x < y) ? 1 : ((x > y) ? -1 : 0));
						return z;
					};
				</script>	
				<script src="assets/js/event-validation.js" type="text/javascript"></script> 
			</body>
		</html>		