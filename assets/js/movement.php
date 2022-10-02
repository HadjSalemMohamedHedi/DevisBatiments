<script type="text/javascript">

			


 var responsiveHelper = undefined;
                var breakpointDefinition = {
                    tablet: 1024,
                    phone: 480
                };
                
				<!--data table invoice-->
				var tableElement = $('#datamovement');

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

<!---->

function delMovement(id_folder,id,type){
									
											var a = confirm("Voulez vous vraiment supprimer cette facture !");
											if(a){
												document.location.href='?id_folder='+id_folder+'&action=deleteinvoice&id='+id+'&type='+type;
											}
										}
	
function EditInvoice_(id_folder,id_invoice)
                                                {
                                                    jQuery('#modal-invoice-edit').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
														type: "POST",
                                                        url: "invoice-edit.php",
														data: {
															id_folder: id_folder,
															id_invoice: id_invoice,
														},
                                                        success: function(response)
                                                        {
                                                            jQuery('#modal-invoice-edit .modal-body').html(response);
															
															var notif_widget = $(".test-widget").height();
																$('.test-widget').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
																});
															$('input.iCheck').iCheck({
																checkboxClass: 'icheckbox_minimal',
																radioClass: 'iradio_minimal',
																increaseArea: '20%'
															});
															<!---->	
															$('#modal-invoice-edit #date-invoice').datepicker({
															 format: "<?php echo $lang_default['date_format_js']; ?>",
															 icons: {
															  time: "fa fa-clock-o",
															  date: "fa fa-calendar",
															  up: "fa fa-arrow-up",
															  down: "fa fa-arrow-down"
																}
													 		 });
															<!---->
															$('#modal-invoice-edit #date-end').datepicker({
															 format: "<?php echo $lang_default['date_format_js']; ?>",
															 icons: {
															  time: "fa fa-clock-o",
															  date: "fa fa-calendar",
															  up: "fa fa-arrow-up",
															  down: "fa fa-arrow-down"
																}
													 		 });
															 <!---->
															 $("#modal-invoice-edit #id_client").select2({
																placeholder: '...',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
															<!--/-->
															
                                                        }
                                                    });
                                                }
												
												 function AddInvoice_(id_folder,type)
                                                {
                                                    jQuery('#modal-invoice-add').modal('show', {backdrop: 'static'});
													
													var provisions = [];
													var prestations = [];
													
													if(type=='1'){
														
														
													
														 $("input[name^='provision']").each(function () {
														 
															if($(this).prop('checked')){
															  provisions.push($(this).val());
															}
													    
														});
														
													}else{
														
													
														 $("input[name^='prestation']").each(function () {
														 
															if($(this).prop('checked')){
															  prestations.push($(this).val());
															}
													    
														});
													}
													
													//alert(JSON.stringify(prestations));

                                                    jQuery.ajax({
														type: "POST",
                                                        url: "invoice-add.php",
														data: {
															id_folder: id_folder,
															
																type: type,
																prestations: prestations,
																provisions: provisions
															
														},
                                                        success: function(response)
                                                        {
                                                            jQuery('#modal-invoice-add .modal-body').html(response);
															
															var notif_widget = $(".test-widget").height();
																$('.test-widget').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
																});
															$('input.iCheck').iCheck({
																checkboxClass: 'icheckbox_minimal',
																radioClass: 'iradio_minimal',
																increaseArea: '20%'
															});
															<!---->	
															$('#modal-invoice-add #date-invoice').datepicker({
															 format: "<?php echo $lang_default['date_format_js']; ?>",
															 icons: {
															  time: "fa fa-clock-o",
															  date: "fa fa-calendar",
															  up: "fa fa-arrow-up",
															  down: "fa fa-arrow-down"
																}
													 		 });
															<!---->
															$('#modal-invoice-add #date-end').datepicker({
															 format: "<?php echo $lang_default['date_format_js']; ?>",
															 icons: {
															  time: "fa fa-clock-o",
															  date: "fa fa-calendar",
															  up: "fa fa-arrow-up",
															  down: "fa fa-arrow-down"
																}
													 		 });
															 <!---->
															 $("#modal-invoice-add #id_client").select2({
																placeholder: '...',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
															<!--/-->
															
                                                        }
                                                    });
                                                }
												
												
												
												
												<!--validation-->
		$(document).ready(function() {
			
		$('#invoice-add_').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
               amount: {
                    required: true,
					 number:true,
                },
				tva: {
                    required: true
                },
				date: {
                    required: true
                },
				
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
				
				var action = $('#invoice-add').attr('action');

				$('#invoice-add #submit-add')
					
		
				$.post(action, $('#invoice-add').serialize(),
					function(data){
						$('#invoice-add #msg-add').html( data );
						$('#invoice-add').slideDown();
						
						$('#invoice-add #submit-add').removeAttr('disabled');
						if(data.match('success') != null){
							
							//$('#ultraModal-add').modal('hide');
							//$('#invoice-add #msg-add').hide();
							window.setTimeout(function () {
									var id = $('#id_folder').val();
								
									if($.isNumeric(id)){
										window.location.href = "folder-detail.php?id_folder="+ id +"&tab=invoice&tab2=invoice";
									}
							}, 100);
							
						}
					}
				);
		
				return false;

            }
        });
		<!--facture libre-->
			$('#invoice3-add').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
               amount: {
                    required: true,
					 number:true,
                },
				date: {
                    required: true
                },
				
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
				
				var action = $('#invoice3-add').attr('action');

				$('#invoice3-add #submit-add')
					
		
				$.post(action, $('#invoice3-add').serialize(),
					function(data){
						$('#invoice3-add #msg-add').html( data );
						$('#invoice3-add').slideDown();
						
						$('#invoice3-add #submit-add').removeAttr('disabled');
						if(data.match('success') != null){
							
							//$('#ultraModal-add').modal('hide');
							//$('#invoice-add #msg-add').hide();
							window.setTimeout(function () {
									var id = $('#id_folder').val();
								
									if($.isNumeric(id)){
										window.location.href = "folder-detail.php?id_folder="+ id +"&tab=invoice&tab2=invoice";
									}
							}, 100);
							
						}
					}
				);
		
				return false;

            }
        });
		<!--invoice-->
		$('#invoice-edit_').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
               amount: {
                    required: true,
					 number:true,
                },
				tva: {
                    required: true
                },
				date: {
                    required: true
                },
				
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
				
				var action = $('#invoice-edit').attr('action');

				$('#invoice-edit #submit-edit')
					
		
				$.post(action, $('#invoice-edit').serialize(),
					function(data){
						$('#invoice-edit #msg-edit').html( data );
						$('#invoice-edit').slideDown();
						
						$('#invoice-edit #submit-edit').removeAttr('disabled');
						if(data.match('success') != null){
							
							//$('#ultraModal-add').modal('hide');
							//$('#invoice-add #msg-add').hide();
							window.setTimeout(function () {
									var id = $('#id_folder').val();
								
									if($.isNumeric(id)){
										window.location.href = "folder-detail.php?id_folder="+ id +"&tab=invoice&tab2=invoice";
									}
							}, 100);
							
						}
					}
				);
		
				return false;

            }
        });
		
		<!--facture libre-->
		<!--invoice-->
		
});
		
		
		
</script>

<div class="modal fade" id="modal-invoice-edit_">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="invoice-edit" class="" action="./includes/validate-invoice.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Modifier Facture</h4>
                                                            </div>
                                                            
                                                            <div id="msg-edit" style="padding:15px;">
                                                            
                                                            </div>
        
                                                            <div class="modal-body" style="overflow-y:auto; max-height:600px;">
        
                                                                loading...
        
                                                            </div>
        
                                                            <div class="modal-footer">
                                                                <!--<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>-->
                                                                <button type="submit" id="submit-edit" class="btn btn-info">Valider</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>




		<div class="modal fade" id="modal-invoice-add_">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="invoice-add" class="" action="./includes/validate-invoice.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Créer facture</h4>
                                                            </div>
                                                            
                                                            <div id="msg-add" style="padding:15px;">
                                                            
                                                            </div>
        
                                                            <div class="modal-body test-widget" >
        
                                                                loading...
        
                                                            </div>
        
                                                            <div class="modal-footer">
                                                                <!--<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>-->
                                                                <button type="submit" id="submit-add" class="btn btn-info">Valider</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                               
                                                