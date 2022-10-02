<script type="text/javascript">
		jQuery(function($) {

   			 'use strict';
				if ($.isFunction($.fn.datetimepicker)) {
			
					$('.form_datetime_lang2').datetimepicker({
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
                var tableElement = $('#data-gift-card');

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
                        "sInfo": "<?php print $lang['sInfo']; ?>",
						"sZeroRecords": "<?php print $lang['sZeroRecords']; ?>"
						
                    },
                    bAutoWidth: false,
                    fnPreDrawCallback: function() {
                        if (!responsiveHelper) {
                        }
                    },
                    fnRowCallback: function(nRow) {
                    },
                    fnDrawCallback: function(oSettings) {
                    }
                });
		
			
			 $().FullCalendarExt({ version: 'php' });
			 
			 function delItem(id){
										
											var gift_card = $('.gift-card-'+id);
									
											var a = confirm("Voulez vous vraiment supprimer ce  CHÈQUE CADEAU !");
											
											if(a){
												
												$.ajax({
													type: "GET",
													dataType:"html",
													url: "./includes/delete-object.php?object=gift_card&id_gift_card="+id,
													success: function(data){
														
														if(data.match('success') != null){
															gift_card.parents('tr').fadeOut(200);
															if(data.match('last') != null){
																gift_card.parents('tbody').html('<tr class="odd"><td valign="top" colspan="11" class="dataTables_empty"><?php print $lang['infoEmpty']; ?></td></tr>');
																$('button.add-prestation').hide();
															}
															showSuccess('CHÈQUE CADEAU supprimé avec succés');
														}else{
															showErrorMessage('Ops! Something went wrong');
														}
													}
												});
											}
										}
<!----> 
function transform(id)
                                                {
                                                    jQuery('#ultraModal-transform').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
                                                        url: "gift-card-transform.php?id_gift_card="+id,
                                                        success: function(response)

                                                        {
                                                            jQuery('#ultraModal-transform .modal-body').html(response);
															var notif_widget = $(".perfect-scroll").height();
																	$('.perfect-scroll').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
															});
															 $('.form_datetime_lang').datetimepicker({
																	language: 'fr',
																	weekStart: 1,
																	todayBtn: 1,
																	autoclose: 1,
																	todayHighlight: 1,
																	startView: 2,
																	forceParse: 0,
																	showMeridian: 0,
																	//pickerPosition: "top-right"
																});
																$('input.icheck-custom').on('ifClicked', function(event){
																	 
																	var val =$(this).attr('value');
																	
																	
																	}).iCheck({
																	  checkboxClass: 'icheckbox_minimal',
																	  radioClass: 'iradio_minimal',
																	  increaseArea: '20%'
																	});
															
															
																	
                                                        }
                                                    });
                                                }
<!---->
         
		 function EditgiftCard(id)
                                                {
                                                    jQuery('#ultraModal-edit').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
                                                        url: "gift-card-edit.php?id_gift_card="+id,
                                                        success: function(response)

                                                        {
                                                            jQuery('#ultraModal-edit .modal-body').html(response);
															var notif_widget = $(".perfect-scroll").height();
																	$('.perfect-scroll').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
															});
															 $('.form_datetime_lang').datetimepicker({
																	language: 'fr',
																	weekStart: 1,
																	todayBtn: 1,
																	autoclose: 1,
																	todayHighlight: 1,
																	startView: 2,
																	forceParse: 0,
																	showMeridian: 0,
																	//pickerPosition: "top-right"
																});
																 $("#id_client").select2({
																	placeholder: 'Choisissez',
																	allowClear: true
																}).on('select2-open', function() {
																	// Adding Custom Scrollbar
																	$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
																});
															$("#id_personal_edit").select2({
																	placeholder: 'Choisissez',
																	allowClear: true
																}).on('select2-open', function() {
																	// Adding Custom Scrollbar
																	$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
																});
																$("#id_product").select2({
																	placeholder: 'Choisissez',
																	allowClear: true
																}).on('select2-open', function() {
																	// Adding Custom Scrollbar
																	$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
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
												
												 
																						
												 function AddgiftCard()
                                                {
                                                    jQuery('#ultraModal-add').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
                                                        url: "gift-card-add.php",
                                                        success: function(response)
                                                        {
                                                            jQuery('#ultraModal-add .modal-body').html(response);
															var notif_widget = $(".perfect-scroll").height();
																	$('.perfect-scroll').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
															});
															
															 $("#id_client_add").select2({
																	placeholder: 'Choisissez',
																	allowClear: true
																}).on('select2-open', function() {
																	// Adding Custom Scrollbar
																	$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
																});
															$("#id_personal_add").select2({
																	placeholder: 'Choisissez',
																	allowClear: true
																}).on('select2-open', function() {
																	// Adding Custom Scrollbar
																	$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
																});
																$("#id_product_add").select2({
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
                           });                      
				<?php }?>								
												
		</script>
        
         <div class="modal fade" id="ultraModal-add">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="event-add" class="" action="./includes/validate-event.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Ajouter un CHÈQUE CADEAU</h4>
                                                            </div>
                                                            
                                                            
        
                                                            <div class="modal-body perfect-scroll" >
                                                            	
        
                                                               
        
                                                            </div>
        
                                                            <div class="modal-footer">
                                                                <!--<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>-->
                                                                <button type="submit" id="submit-add" class="btn btn-info">Valider</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
        <!--edit-->
        <div class="modal fade" id="ultraModal-edit">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="gift-card-edit" class="" action="./includes/validate-gift-card.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Modifier CHÈQUE CADEAU</h4>
                                                            </div>
                                                            
                                                            
                                                            <div class="modal-body perfect-scroll" >
        
                                                             
        
        
                                                            </div>
        
                                                            <div class="modal-footer">
                                                                <!--<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>-->
                                                                <button type="submit" id="submit-edit" class="btn btn-info">Valider</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
             <!--Valider cheque-->                                   
        <div class="modal" id="ultraModal-transform" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
                                                    <div class="modal-dialog animated bounceInDown">
                                                        <div class="modal-content">
                                                        	<form id="gift-card-transform" class="" action="./includes/validate-gift-card.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Transformer CHÈQUE CADEAU</h4>
                                                            </div>
                                                            
                                                            <div id="msg-transform" style="margin-left:22px; margin-top:10px; margin-right:22px;" > </div>
                                                            <div class="modal-body perfect-scroll" >
        
                                                             
        
        
                                                            </div>
        
                                                            <div class="modal-footer">
                                                                <!--<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>-->
                                                                <button type="submit" id="submit-transform" class="btn btn-info">Valider</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
         <!---->               
         
        
        <script type="text/javascript">
			$(document).ready(function() {


    if ($.isFunction($.fn.validate)) {
		
		$('#event-add').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                id_client: {
                    required: true
                },
				id_personal: {
                    required: true
                },
				id_product: {
                    required: true
                },
				start: {
                    required: true
                },id_combination: {
                    required: true
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
				
				var action = $('#event-add').attr('action');

				$('#submit-add')
					
		
				$.post(action, $('#event-add').serialize(),
					function(data){
						$('#msg-add').html( data );
						$('#msg-add').slideDown();
						
						//$('#ultraModal-add .modal-body').prepend(data);
						
						$('#event-add #submit-add').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#ultraModal-add').modal('hide');
							$('#msg-add').hide();
							window.setTimeout(function () {
										window.location.href = "manage-event.php";
							}, 500);
							
						}
					}
				);
		
				return false;

            }
        });

		
		<!--end add event-->
		
		<!--edit contributor-->
		
		$('#gift-card-edit').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                  id_client: {
                    required: true
                },
				
				id_product: {
                    required: true
                }
				,id_combination: {
                    required: true
                },recipientFirstname: {
							required:true
						},
						recipientLastname: {
							required:true
						},recipientEmail: {
							email:true,
							required:true
						},recipientPhone: {
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
				
				var action = $('#gift-card-edit').attr('action');

				$('#submit-edit')
					
		
				$.post(action, $('#gift-card-edit').serialize(),
					function(data){
						$('#msg-edit').html( data );
						$('#msg-edit').slideDown();
						
						$('#gift-card-edit #submit-edit').removeAttr('disabled');
						if(data.match('success') != null){
							
							//$('#ultraModal-edit').modal('hide');
							//$('#msg-edit').hide();
							
							window.setTimeout(function () {
								
								window.location.href = "manage-gift-card.php";
								
							}, 500);
						}
					}
				);
		
				return false;

            }
        });
	<!--transform-->

	$('#gift-card-transform').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                  id_client: {
                    required: true
                },
				id_personal: {
                    required: true
                },
				id_product: {
                    required: true
                },
				start: {
                    required: true
                },id_combination: {
                    required: true
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
				
				var action = $('#gift-card-transform').attr('action');

				$('#submit-transform')
					
		
				$.post(action, $('#gift-card-transform').serialize(),
					function(data){
						$('#msg-transform').html( data );
						$('#msg-transform').slideDown();
						
						$('#gift-card-transform #submit-transform').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#ultraModal-transform').modal('hide');
							$('#msg-transform').hide();
							
							window.setTimeout(function () {
								
								window.location.href = "manage-gift-card.php";
								
							}, 500);
							
						}
					}
				);
		
				return false;

            }
        });


	<!---->


    }


});

		</script>
     
        
       