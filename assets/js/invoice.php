<script type="text/javascript">

			


 var responsiveHelper = undefined;
                var breakpointDefinition = {
                    tablet: 1024,
                    phone: 480
                };
                
				<!--data table invoice-->
				var tableElement = $('#datainvoice');

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

function delInvoice(id_folder,id,type){
									
											var a = confirm("Voulez vous vraiment supprimer cette facture !");
											if(a){
												document.location.href='?id_folder='+id_folder+'&action=deleteinvoice&id='+id+'&type='+type;
											}
										}
	
function EditInvoice(id_folder,id_invoice)
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
												
												 function AddInvoice(id_folder,type)
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
												
												
												<!--facture libre-->
												function AddInvoice3(id_folder)
                                                {
                                                    jQuery('#modal-invoice3-add').modal('show', {backdrop: 'static'});
													
                                                    jQuery.ajax({
														type: "POST",
                                                        url: "invoice3-add.php",
														data: {
															id_folder: id_folder,
														},
                                                        success: function(response)
                                                        {
                                                            jQuery('#modal-invoice3-add .modal-body').html(response);
															
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
															$('#modal-invoice3-add #date-invoice').datepicker({
															 format: "<?php echo $lang_default['date_format_js']; ?>",
															 icons: {
															  time: "fa fa-clock-o",
															  date: "fa fa-calendar",
															  up: "fa fa-arrow-up",
															  down: "fa fa-arrow-down"
																}
													 		 });
															<!---->
															$('#modal-invoice3-add #date_end').datepicker({
															 format: "<?php echo $lang_default['date_format_js']; ?>",
															 icons: {
															  time: "fa fa-clock-o",
															  date: "fa fa-calendar",
															  up: "fa fa-arrow-up",
															  down: "fa fa-arrow-down"
																}
													 		 });
															 
															 $("#modal-invoice3-add #id_client").select2({
																placeholder: '...',
																allowClear: true
																}).on('select2-open', function() {
																	// Adding Custom Scrollbar
																	$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
																});
															<!---->
															var output ='';
															
															var nD = 1;
															 $('#add-row').click(function(){
	 
																//alert('test');
																
																nD ++;
																
																	output = '<div class="row"><div class="col-md-5">';
																	output +='<div class="form-group"><label for="amount" class="control-label">Designation '+nD+':</label>';
																	output +='<input type="text" class="form-control" name="designation[]" value="" required/></div></div>'
																	output +='<div class="col-md-3"><div class="form-group"><label for="tva" class="control-label">TVA:</label>';
																	output +='<select name="tva[]" class="form-control" required><option value="">====</option><option value="0">0 %</option>';
																	output +='<option value="6">6 %</option><option value="21">21 %</option></select></div></div>';
																	output +='<div class="col-md-3"><div class="form-group">';
                                                                    output +='<label for="id_folder" class="control-label">Montant:</label> <input type="text" class="form-control" name="amount[]" value="" required/></div></div>';
                                                             output +='<div class="col-md-1"><a  type="button" class="remove-row btn btn-warning btn-sm" style="margin-top:30px;"><i class="fa fa-minus"></i></a></div>';
																	output +='</div>';
																
																$( ".row_one" ).before(output);
																
																	$('.remove-row').click(function(){
																		if(nD > 1){
																			nD = nD - 1;
																		}
																		var content = $(this).parent().parent();	
																		   content.remove();
																	});
																
																//output ='';
																
															});
															
															
															<!--/-->
															
                                                        }
                                                    });
                                                }
												<!--facture libre edit-->
												function EditInvoice3(id_folder,id_invoice)
                                                {
                                                    jQuery('#modal-invoice3-edit').modal('show', {backdrop: 'static'});
													
                                                    jQuery.ajax({
														type: "POST",
                                                        url: "invoice3-edit.php",
														data: {
															id_invoice: id_invoice,
															id_folder: id_folder,
														},
                                                        success: function(response)
                                                        {
                                                            jQuery('#modal-invoice3-edit .modal-body').html(response);
															
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
															$('#modal-invoice3-edit #date-invoice').datepicker({
															 format: "<?php echo $lang_default['date_format_js']; ?>",
															 icons: {
															  time: "fa fa-clock-o",
															  date: "fa fa-calendar",
															  up: "fa fa-arrow-up",
															  down: "fa fa-arrow-down"
																}
													 		 });
															<!---->
															$('#modal-invoice3-edit #date-end').datepicker({
															 format: "<?php echo $lang_default['date_format_js']; ?>",
															 icons: {
															  time: "fa fa-clock-o",
															  date: "fa fa-calendar",
															  up: "fa fa-arrow-up",
															  down: "fa fa-arrow-down"
																}
													 		 });
															
															 $("#modal-invoice3-edit #id_client").select2({
																placeholder: '...',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
															<!---->
															var output ='';
															
															var nD = parseInt($('#nbr').val());
															
															$( ".row_one" ).before(output);
																
																	$('.remove-row').click(function(){
																		nD = nD - 1;
																		var content = $(this).parent().parent();	
																		   content.remove();
																	});
															
															 $('#add-row').click(function(){
	 
																//alert('test');
																
																nD ++;
																
																	output = '<div class="row"><div class="col-md-5">';
																	output +='<div class="form-group"><label for="amount" class="control-label">Designation '+nD+':</label>';
																	output +='<input type="text" class="form-control" name="designation[]" value="" required/></div></div>'
																	output +='<div class="col-md-3"><div class="form-group"><label for="tva" class="control-label">TVA:</label>';
																	output +='<select name="tva[]" class="form-control" required><option value="">====</option><option value="0">0 %</option>';
																	output +='<option value="6">6 %</option><option value="21">21 %</option></select></div></div>';
																	output +='<div class="col-md-3"><div class="form-group">';
                                                                    output +='<label for="id_folder" class="control-label">Montant:</label> <input type="text" class="form-control" name="amount[]" value="" required/></div></div>';
                                                             output +='<div class="col-md-1"><a  type="button" class="remove-row btn btn-warning btn-sm" style="margin-top:30px;"><i class="fa fa-minus"></i></a></div>';
																	output +='</div>';
																
																$( ".row_one" ).before(output);
																
																	$('.remove-row').click(function(){
																		nD = nD - 1;
																		var content = $(this).parent().parent();	
																		   content.slideUp();
																	});
																
																//output ='';
																
															});
															
															
															<!--/-->
															
                                                        }
                                                    });
                                                }
												<!--validation-->
		$(document).ready(function() {
			
		$('#invoice-add').validate({
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
                
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },
			
			/* errorPlacement: function(error, element) { // render error placement for each input type
                
                var parent = $(element).parent().parent('.form-group');
                
                parent.removeClass('has-success').addClass('has-error');
            },*/

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
										//window.location.href = "folder-detail.php?id_folder="+ id +"&tab=invoice&tab2=invoice";
										window.location.href = "manage-invoice.php";
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
            
           
            ignore: "",
            rules: {
               amount: {
                    required: true,
					number:true,
                },
				date: {
                    required: true
                },
				date_end:{
                    required: true
                },
				payment:{
                    required: true
                },
				
            },

            invalidHandler: function(event, validator) {
                //display error alert on form submit    
            },

           /* errorPlacement: function(label, element) { // render error placement for each input type   
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
		$('#invoice-edit').validate({
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
		$('#invoice3-edit').validate({
           
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
				
				var action = $('#invoice3-edit').attr('action');

				$('#invoice3-edit #submit-edit')
					
		
				$.post(action, $('#invoice3-edit').serialize(),
					function(data){
						$('#invoice3-edit #msg-edit').html( data );
						$('#invoice3-edit').slideDown();
						
						$('#invoice3-edit #submit-edit').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#modal-invoice3-edit').modal('hide');
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
});
		
		
		
</script>

<div class="modal fade" id="modal-invoice-edit">
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
                                                                <button type="submit" id="submit-edit" class="btn btn-purple"><i class="fa fa-floppy-o icon-xs"></i>&nbsp; Valider</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>




		<div class="modal fade" id="modal-invoice-add">
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
                                                                <button type="submit" id="submit-add" class="btn btn-purple"><i class="fa fa-floppy-o icon-xs"></i>&nbsp; Valider</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!--modal facture libre-->
                                                <div class="modal fade" id="modal-invoice3-add">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="invoice3-add" class="" action="./includes/validate-invoice3.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Créer facture libre</h4>
                                                            </div>
                                                            
                                                            <div id="msg-add" style="padding:15px;">
                                                            
                                                            </div>
        
                                                            <div class="modal-body test-widget">
        
                                                                loading...
        
                                                            </div>
        
                                                            <div class="modal-footer">
                                                                <!--<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>-->
                                                                <button type="submit" id="submit-add" class="btn btn-purple"><i class="fa fa-floppy-o icon-xs"></i>&nbsp; Valider</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                               <!--*-->
                                               
                                               <div class="modal fade" id="modal-invoice3-edit">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="invoice3-edit" class="" action="./includes/validate-invoice3.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Modifier facture libre</h4>
                                                            </div>
                                                            
                                                            <div id="msg-edit" style="padding:15px;">
                                                            
                                                            </div>
        
                                                            <div class="modal-body" style="overflow-y:auto; max-height:600px;">
        
                                                                loading...
        
                                                            </div>
        
                                                            <div class="modal-footer">
                                                                <!--<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>-->
                                                                <button type="submit" id="submit-add" class="btn btn-purple"><i class="fa fa-floppy-o icon-xs"></i>&nbsp; Valider</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                