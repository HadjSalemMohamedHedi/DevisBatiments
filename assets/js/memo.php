<div class="modal fade" id="modal-task-edit">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="memo-form" class="" action="validate-memo.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title"></h4>
                                                            </div>
                                                            
                                                            <div id="msg-memo" style="padding:15px;">
                                                            
                                                            </div>
        
                                                            <div class="modal-body" style="overflow-y:auto; max-height:600px;">
        
                                                               <div class="progress">
                                                                    <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                                        
                                                                    </div>
                                                                </div>
        
                                                            </div>
        
                                                            <div class="modal-footer">
                                                                <!--<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>-->
                                                                <button type="submit" id="submit-edit" class="btn btn-purple"><i class="fa fa-floppy-o icon-xs"></i>&nbsp; Valider</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
<script type="text/javascript">
		 
		 	 
		 
		 	 function editNote(id,id_folder)
                                                {
                                                    jQuery('#modal-task-edit').modal('show', {backdrop: 'static'});
													
													jQuery('#modal-task-edit .modal-title').text('Modifier une tâche');

                                                    jQuery.ajax({
                                                        url: "edit-note.php?id_note="+id+"&ac=edit&id_folder="+id_folder,
                                                        success: function(response)
                                                        {
                                                            jQuery('#modal-task-edit .modal-body').html(response);
															$('#memo-form').submit(function(){

		
		
																	var action = $(this).attr('action');
															
																	$('#memo-form').attr('disabled','disabled');
																	$.ajax({data: $('#memo-form').serialize(),
																			type:"POST",
																			url:"includes/validate-memo.php",
																			dataType: 'html',
																			success: function(data) {
																			$('#msg-memo').html( data );
																			$('#msg-memo').slideDown();
																			
																			$('#memo-form #submit-edit').removeAttr('disabled');
																			if(data.match('success') != null){
																				
																				
																			}
																		}
																	});
															
																	return false;
															
																});
															
															
                                                        }
                                                    });
                                                }
			function addNote(id_folder)
                                                {
                                                    jQuery('#modal-task-edit').modal('show', {backdrop: 'static'});
													
													jQuery('#modal-task-edit .modal-title').text('Ajouter une tâche');

                                                    jQuery.ajax({
                                                        url: "edit-note.php?ac=add&id_folder="+id_folder,
                                                        success: function(response)
                                                        {
                                                            jQuery('#modal-task-edit .modal-body').html(response);
															$('#memo-form').submit(function(){

		
		
																	var action = $(this).attr('action');
															
																	$('#memo-form').attr('disabled','disabled');
																	$.ajax({data: $('#memo-form').serialize(),
																			type:"POST",
																			url:"includes/validate-memo.php",
																			dataType: 'html',
																			success: function(data) {
																			$('#msg-memo').html( data );
																			$('#msg-memo').slideDown();
																			
																			$('#memo-form #submit-edit').removeAttr('disabled');
																			if(data.match('success') != null){
																				
																				
																			}
																		}
																	});
															
																	return false;
															
																});
																														
															
															
                                                        }
                                                    });
                                                }		
		 	$('a.task').click(function(){
				
				var task = $(this);
				
				var id = $(this).data('id');
									
											var a = confirm("Voulez vous vraiment supprimer cette note !");
											if(a){
												$.ajax({
													type: "GET",
													dataType:"html",
													url: "./includes/add-note.php?id_note="+id,
													success: function(data){
														showSuccess('Note supprimé avec succés');
														task.parents('li').fadeOut(200);
														task.parents('tr').fadeOut(200);
													}
												});
											}
										});
										
										var responsiveHelper = undefined;
                var breakpointDefinition = {
                    tablet: 1024,
                    phone: 480
                };
                
				<!--data table invoice-->
				var tableElement = $('#datanote');

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
                        "sInfo": "<?php print $lang['sInfo']; ?>",
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
				
				 $('#datanote .dataTables_filter input').addClass("input-medium "); // modify table search input
                $('#datanote .dataTables_length select').addClass("select2-wrapper col-md-12"); // modify table per page dropdown



                $('##datanote input').click(function() {
                    $(this).parent().parent().parent().toggleClass('row_selected');
                });
				
				
				
		 </script>