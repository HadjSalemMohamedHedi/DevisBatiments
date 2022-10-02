<script type="text/javascript">



   $('#selectall').on('ifChanged', function(event){
			 
					if($(this).prop('checked')){
						$('input.selecta').iCheck('check');
					}else{
						$('input.selecta').iCheck('uncheck');
					}
						
				}).iCheck({
					checkboxClass: 'icheckbox_minimal',
					radioClass: 'iradio_minimal',
					increaseArea: '20%'
			});
					
		  $('input.selecta').iCheck({
					checkboxClass: 'icheckbox_minimal',
					radioClass: 'iradio_minimal',
					increaseArea: '20%'
			});
   
  											 
												/*
                                                function Editcontact(id)
                                                {
                                                    jQuery('#ultraModal-edit').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
                                                        url: "contact-edit.php?id_contact="+id,
                                                        success: function(response)
                                                        {
                                                            jQuery('#ultraModal-edit .modal-body').html(response);
															<!--auto complite title-->
															 $("#id_title-1").select2({
																placeholder: '...',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
															
															$("#id_contact_type-1").select2({
																placeholder: '...',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
																
															<!---->
                                                        }
                                                    });
                                                }*/
												
												/* function Addcontact()
                                                {
                                                    jQuery('#ultraModal-add').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
                                                        url: "contact-add.php",
                                                        success: function(response)
                                                        {
                                                            jQuery('#ultraModal-add .modal-body').html(response);
															<!--select-->
															 $("#s2example-1").select2({
																placeholder: '...',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
															
															$("#id_contact_type").select2({
																placeholder: '...',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
															<!---->
                                                        }
                                                    });
                                                }
*/
										

										
										
										
										
										function archive(id){
									
										var a = confirm("Voulez-vous réellement archiver ce dossier ?");
											if(a){
											document.location.href='?action=archive&id_folder='+id;
											}
										
										}
	
												
												
												

function History(id,object)
                                                {
                                                    jQuery('#section-settings').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
                                                        url: "includes/history.php?object="+object+"&id_object="+id,
                                                        success: function(response)
                                                        {
                                                            jQuery('#section-settings .modal-body').html(response);
															
															var responsiveHelper = undefined;
															var breakpointDefinition = {
																tablet: 1024,
																phone: 480
															};
															var tableElement = $('#tracing');
											
															tableElement.dataTable({
																"sPaginationType": "bootstrap",
															   "aoColumnDefs": [
																  { 'bSortable': false, 'aTargets': [ "no-sort" ] }
																],
																"fnInitComplete": function(oSettings, json) { 
																  $('.dataTables_filter input').attr("placeholder", "Recherche");
																},
																"aaSorting": [
																	[0, "desc"]
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
											
														   
															
														
													<!---->
												 }
                                                    });
                                                }
</script>


      
        
        <div class="modal" id="section-settings" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
                                                    <div class="modal-dialog animated bounceInDown">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Historique</h4>
                                                            </div>
                                                            <div class="modal-body" style="overflow-y:auto; max-height:600px;">
                                        
                                                                Loading...
                                        
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button data-dismiss="modal" class="btn btn-default" type="button">Fermer</button>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
        <div class="modal" id="share" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Partage</h4>
                    </div>
                    	<form id="share-modal" method="post" action="includes/share.php">
                        <div id="msg-share" style="padding:15px;"></div>
                            <div class="modal-body" style="overflow-y:auto; max-height:600px; margin:20px;">
                            			
                                            
                            
                        	</div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" type="button">Fermer</button>
                                <button class="btn btn-success" type="submit" name="share">Partager</button>
                            </div>
                    </form>
                </div>
            </div>
         </div>