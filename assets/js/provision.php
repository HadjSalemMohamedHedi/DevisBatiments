 <script type="text/javascript">
 
 
 var responsiveHelper = undefined;
                var breakpointDefinition = {
                    tablet: 1024,
                    phone: 480
                };
                var tableElement = $('#dataprovision');

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
                        [0, "asc"]
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
 <!---->
 function delProvision(id_folder,id){
									
											var a = confirm("Voulez vous vraiment supprimer cette provision !");
											if(a){
												document.location.href='?id_folder='+id_folder+'&action=deleteprovision&id='+id;
											}
										}
 <!--provision chekbox-->
   	var count = 0;
		   
					$('#dataprovision tr input.provision').each(function() {
						
						if($(this).prop('checked')){
							count ++;
						}
						
					 });
					
					//alert(count);
					if(count==0){
						$('button.add-invoice-provision').hide();
					}else{
						$('button.add-invoice-provision').show();
					}
					<!---->
   			
			  $('.provision').on('ifChanged', function(event){
				
					var count = 0;
		   
					$('#dataprovision tr input.provision').each(function() {
						
						if($(this).prop('checked')){
							count ++;
						}
						
					 });
					
					//alert(count);
					if(count==0){
						$('button.add-invoice-provision').hide();
					}else{
						$('button.add-invoice-provision').show();
					}
						
				}).iCheck({
					checkboxClass: 'icheckbox_minimal',
					radioClass: 'iradio_minimal',
					increaseArea: '20%'
			});
			
			
			
			function Addprovision()
                                                {
                                                    jQuery('#provision-add').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
                                                        url: "provision-add.php?id_folder=<?php echo $_GET['id_folder']; ?>",
                                                        success: function(response)
                                                        {
                                                            jQuery('#provision-add .modal-body').html(response);
															
															  $('#date-provision').datepicker({
																  language: "fr-FR",
																  language: '<?php echo $_SESSION['language']; ?>',
																 format: "<?php echo $lang_default['date_format_js']; ?>",
																 icons: {
																  time: "fa fa-clock-o",
																  date: "fa fa-calendar",
																  up: "fa fa-arrow-up",
																  down: "fa fa-arrow-down"
																}
													 		 });
															 
															  $("#provision-add #id_client").select2({
																placeholder: '...',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
																
																$('.iCheck').iCheck({
																	checkboxClass: 'icheckbox_minimal',
																	radioClass: 'iradio_minimal',
																	increaseArea: '20%'
																});
																
																
                                                        }
                                                    });
                                                }
												<!--edit provision-->
												function Editprovision(id)
                                                {
                                                    jQuery('#provision-edit').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
                                                        url: "provision-edit.php?id_provision="+id+"&id_folder=<?php echo $_GET['id_folder']; ?>",
                                                        success: function(response)
                                                        {
                                                            jQuery('#provision-edit .modal-body').html(response);
															
															  $('#date-provision-edit').datepicker({
																  language: "fr-FR",
																  language: '<?php echo $_SESSION['language']; ?>',
																 format: "<?php echo $lang_default['date_format_js']; ?>",
																 icons: {
																  time: "fa fa-clock-o",
																  date: "fa fa-calendar",
																  up: "fa fa-arrow-up",
																  down: "fa fa-arrow-down"
																}
													 		 });
															 
															$("#provision-edit #id_client").select2({
																placeholder: '...',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
																
																$('.iCheck').iCheck({
																	checkboxClass: 'icheckbox_minimal',
																	radioClass: 'iradio_minimal',
																	increaseArea: '20%'
																});
																
																
															
                                                        }
                                                    });
                                                }
			
			

$(document).ready(function() {


    if ($.isFunction($.fn.validate)) {
		
		$('#provision-modal-add').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
               id_client: {
                    required: true
                },
				id_folder: {
                    required: true
                },
				date: {
                    required: true
                },
				
            },

            invalidHandler: function(event, validator) {
                //display error alert on form submit    
            },

            /*errorPlacement: function(label, element) { // render error placement for each input type   
                console.log(label);
                $('<span class="error"></span>').insertAfter(element).append(label)
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },*/
			
			 errorPlacement: function(error, element) { // render error placement for each input type
                var icon = $(element).parent().parent('.form-group').find('i');
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
				
				var action = $('#provision-modal-add').attr('action');

				$('#submit-add')
					
		
				$.post(action, $('#provision-modal-add').serialize(),
					function(data){
						$('#msg-add').html( data );
						$('#msg-add').slideDown();
						
						$('#provision-modal-add #submit-add').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#provision-add').modal('hide');
							$('#msg-add').hide();
							window.setTimeout(function () {
									var id = $('#folder').val();
								
									if($.isNumeric(id)){
										window.location.href = "folder-detail.php?id_folder="+ id +"&tab=invoice";
									}
							}, 500);
							
						}
					}
				);
		
				return false;

            }
        });

		
		<!--end -->
		
		$('#provision-modal-edit').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
               id_client: {
                    required: true
                },
				id_folder: {
                    required: true
                },
				date: {
                    required: true
                },
				
            },

            invalidHandler: function(event, validator) {
                //display error alert on form submit    
            },

             errorPlacement: function(error, element) { // render error placement for each input type
                var icon = $(element).parent().parent('.form-group').find('i');
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
				
				var action = $('#provision-modal-edit').attr('action');

				$('#submit-edit')
					
		
				$.post(action, $('#provision-modal-edit').serialize(),
					function(data){
						$('#msg-edit').html( data );
						$('#msg-edit').slideDown();
						
						$('#provision-modal-add #submit-edit').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#provision-edit').modal('hide');
							$('#msg-edit').hide();
							window.setTimeout(function () {
									var id = $('#folder').val();
								
									if($.isNumeric(id)){
										window.location.href = "folder-detail.php?id_folder="+ id +"&tab=invoice";
									}
							}, 500);
							
						}
					}
				);
		
				return false;

            }
        });

		
		
    }


});
</script>

<div class="modal" id="provision-add" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Crèer provision</h4>
                    </div>
                    	<form id="provision-modal-add" method="post" action="includes/validate-provision.php">
                        <div id="msg-add" style="padding:15px;"></div>
                            <div class="modal-body" style="overflow-y:auto; max-height:600px; margin:5px;">
                            			
                                            
                            
                        	</div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" type="button">Fermer</button>
                                <button id="submit-add" class="btn btn-success" type="submit">Enregistrer</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <!--edit provision-->
        <div class="modal" id="provision-edit" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Modifier provision</h4>
                    </div>
                    	<form id="provision-modal-edit" method="post" action="includes/validate-provision.php">
                        <div id="msg-edit" style="padding:15px;"></div>
                            <div class="modal-body" style="overflow-y:auto; max-height:600px; margin:5px;">
                            			
                                            
                            
                        	</div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" type="button">Fermer</button>
                                <button id="submit-edit" class="btn btn-success" type="submit">Enregistrer</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>                               