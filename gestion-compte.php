<?php
// include Config File
include_once './includes/config.inc.php';
// Authenticate user login
auth();





if(isset($_GET['action']) && $_GET['action']=='delete') {
	
	if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
		$_SESSION['notification'] = array('type'=>'error','msg'=>'Id invalide');
		redirect(ROOT_URL.'gestion-compte.php');
	}

	
	$db = db_connect();
	if($_SESSION['User']['id']!==$_GET['id'] && $db->delete('users',$_GET['id'])) {
		$_SESSION['notification'] = array('type'=>'succes','msg'=>'L\'utilisateur a été archivé avec succès');
	} else {
		$_SESSION['notification'] = array('type'=>'error','msg'=>'Il ya eu un problème d\'archiver l\'utilisateur S\'il vous plaît essayez de nouveau.');
	}
redirect(ROOT_URL.'gestion-compte.php');
}


$db = db_connect();

$limit = 20; 

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
$start_from = ($page-1) * $limit;  

$userfilter = "";
 
$users = $db->get_rows("SELECT users.* FROM users WHERE users.id!=0 $userfilter ORDER BY users.created  ASC LIMIT $start_from, $limit");



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

                    <?php if(!isset($_GET['trash'])){?>
                        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                            <div class="page-title">
                                <nav class="navbar-default">
                                    <div class="container-fluid">
                                        <h1 class="title">Gestion des Administrateurs</h1>
                                        <button type="button" class="btn btn-default navbar-btn btn-icon btn-add-product" data-toggle="modal" onclick="window.location='users-add.php'">
                                             <i class="fa fa-plus-square"></i> &nbsp; <span>Ajouter</span>
                                            </button>
                                    </div>
                                    <!-- /.container-fluid --> 
                                </nav>
                            </div>
                        </div>
                    <?php }?>

                    
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                    <?php echo notification(); ?>
                    </div>
                    <div class="clearfix"></div>
                    
                        <!---->
                       <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'> <?php echo notification(); ?> </div>
                    <div class="clearfix"></div>
                    <div class="col-lg-12">
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title">Liste Administrateurs</h2>
                            </header>
                            <div class="content-body">
                               <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <!-- ********************************************** -->
									
                                        <table id="tracing" class="display table table-hover table-condensed" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="sort-alpha">Nom d'utilisateur</th>
                                                                        <th class="sort-alpha">Nom</th>
                                                                        <th class="sort-alpha">Prenom</th>
                                                                        <th class="sort-alpha">Adresse</th>
                                                                        <th class="sort-alpha">Email</th>
                                                                       
                                                                        <th class="sort-amount">Dernière connexion</th>
                                                                        
                                                                        <th>Actions</th>
                                                                      </tr>
                                                                </thead>
                    
                                                                <tbody>
                                                                <?php foreach($users as $k => $v):?> 
                    											<?php ?>
                                                                    <tr class="odd gradeX">
                                  <td><?php echo $v['username']; ?></td>
                                  <td><?php echo $v['firstname']; ?></td>
                                  <td><?php echo $v['lastname']; ?></td>
                                   <td><?php echo $v['address']; ?></td>
                                  <td><?php echo $v['email']; ?></td>
                                 
                                  <td class="text-center"> <?php echo $v['modified']; ?></td>
                                 <td class="text-center">
                                 
                                  <a href="users-edit.php?id=<?php echo $v['id']; ?>" class="btn btn-sm btn-icon" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Modifier" data-placement="top"><i class="fa fa-edit"></i></a>
                                   <?php if(count($users)> 1):?>
                                        <a href="javascript:delItem(<?php echo $v['id']; ?>)" class="btn btn-sm btn-icon" rel="tooltip" data-animate=" animated tada" data-toggle="tooltip" data-original-title="Supprimer" data-placement="top"><i class="fa fa-trash-o"></i></a>
                                 	
                                   
           <?php endif;?>
              
                                 
                                 </td>
                          </tr>
                                                                  
                                                                 <?php endforeach;?>
                                                                    
                                                                </tbody>
                                                            </table>

                                        <!--  *********************************************** -->

                                    </div>
                                </div>
                            </div>
                        </section></div>
                        
                        <!---->

                </section>
            </section>


        <?php else: ?> <!-- rr-->

        <?php include ROOT."./page-401.php"; ?><!-- rr-->

        <? endif;?>	<!-- rr-->



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
        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->  
        
        
        <!-- calendar --> 
        <script src="assets/plugins/calendar/moment.min.js" type="text/javascript"></script>
		<!--<script src="assets/plugins/jquery-ui/smoothness/jquery-ui.min.js" type="text/javascript"></script>-->
       
		<script src="assets/plugins/calendar/fullcalendar.min.js" type="text/javascript"></script>
         <script src="assets/plugins/calendar/lang-all.js" type="text/javascript"></script>


        <!-- CORE TEMPLATE JS - START --> 
        <script src="assets/js/scripts.js" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS - END --> 

        <!-- Sidebar Graph - START --> 
        <script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/js/chart-sparkline.js" type="text/javascript"></script>
        <!-- Sidebar Graph - END --> 

	
    </body>
</html>
<script type="text/javascript">

/* Table initialisation */
            $(document).ready(function() {
                var responsiveHelper = undefined;
                var breakpointDefinition = {
                    tablet: 1024,
                    phone: 480
                };
                var tableElement = $('#tracing');

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
                   "aoColumnDefs": [
					  { 'bSortable': false, 'aTargets': [ "no-sort" ] }
					],
					"fnInitComplete": function(oSettings, json) { 
					  $('.dataTables_filter input').attr("placeholder", "Recherche");
					},
								"aaSorting": [
                        [1, "desc"]
                    ],
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
                        "sInfo": " <?php print $lang['sInfo']; ?> ",
						"sZeroRecords": "<?php print $lang['sZeroRecords']; ?>"
						
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

                $('#example_wrapper .dataTables_filter input').addClass("input-medium "); // modify table search input
                $('#example_wrapper .dataTables_length select').addClass("select2-wrapper col-md-12"); // modify table per page dropdown



                $('#tracing input').click(function() {
                    $(this).parent().parent().parent().toggleClass('row_selected');
                });
				
			});
		<!---->

				
			
			

</script>


<script type="text/javascript">

		
           
	  
	    
        
												function delItem(id){

												var a = confirm("Voulez-vous vraiment supprimer cet utilisateur ?");
													if(a){
														document.location.href='?action=delete&id='+id;
													}
												
												}
												
												
												
												 $("#typee").select2({
																placeholder: 'Choisissez',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});

												
</script>
