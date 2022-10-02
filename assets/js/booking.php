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
                var tableElement = $('#datacalendar');

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
                        [6, "desc"]
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
										
											var event = $('.event-'+id);
									
											var a = confirm("Voulez vous vraiment supprimer cette  réservation !");
											
											if(a){
												
												$.ajax({
													type: "GET",
													dataType:"html",
													url: "./includes/delete-object.php?object=event&id="+id,
													success: function(data){
														if(data.match('success') != null){
															event.parents('tr').fadeOut(200);
															if(data.match('last') != null){
																event.parents('tbody').html('<tr class="odd"><td valign="top" colspan="11" class="dataTables_empty"><?php print $lang['infoEmpty']; ?></td></tr>');
																$('button.add-prestation').hide();
															}
															showSuccess('Réservation supprimé avec succés')
														}else{
															showErrorMessage('Ops! Something went wrong')
														}
													}
												});
											}
										}
			 
         
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
															
															 $("#id_client_add").select2({
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
        
         <div class="modal fade" id="ultraModal-add">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="event-add" class="" action="./includes/validate-event.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Ajouter une Réservation</h4>
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
                                                        	<form id="event-edit" class="" action="./includes/validate-event.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Modifier Réservation</h4>
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
                         <div class="modal" id="section-cancel" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                 <form id="cancel" class="" action="./includes/validate-event.php" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Fermez des date</h4>
                    </div>
                    <div id="msg-cancel" style="padding:15px;">
                                                            
                                                            </div>
                    <div class="modal-body">
                       
                     <div class="col-md-4">
                    
                    	<div class="form-group">
                                                                    <label class="form-label" for="id_personal">Action</label>
                                                                  
                                                                        <select class="form-control" name="action" id="action" required>
                                                                           	 <option value="cancel">Ajouter</option>
                                                                             <option value="delete">Supprimer</option>
                                                                    
                                                                            </select>
                                                                                
                                                                   
                                                                </div>
                       
                     </div>
                     <div class="clearfix"></div>
                     <div class="col-md-12">
						 <div class="form-group">
                                                                	 <label  class="control-label">Début</label>
                                                                    <div class="input-group date form_datetime_lang2" data-date="" data-date-format="DD dd MM yyyy - hh:ii" data-link-field="dtpick_333">
                                                                        <input class="form-control" size="16" type="text" value="" readonly>
                                                                        <span class="input-group-addon"><span class="fa fa-times"></span></span>
                                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                                    </div>
                                                                    <input type="hidden" id="dtpick_333" name="date-begin" value="" />
                                                                </div>
                       </div>                                 	
                                                                <div class="col-md-12"><div class="form-group">
                                                                	 <label for="start" class="control-label">Fin</label>
                                                                    <div class="input-group date form_datetime_lang2" data-date="" data-date-format="DD dd MM yyyy - hh:ii" data-link-field="dtpick_444">
                                                                        <input class="form-control" size="16" type="text" value="" readonly>
                                                                        <span class="input-group-addon"><span class="fa fa-times"></span></span>
                                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                                    </div>
                                                                    <input type="hidden" id="dtpick_444" name="date-end" value="" />
                                                                </div></div>
                                                                <?php $personals = $db->get_rows("SELECT personal.* FROM personal WHERE personal.active='1' AND personal.deleted='0' AND personal.id_category!='0'");?>
                                                                <div class="col-md-12"><div class="form-group">
                                                                    <label class="form-label" for="id_personal">Employé</label>
                                                                  
                                                                        <select class="form-control" name="id_personal" id="id_personal" required>
                                                                            <option value="">==========</option>
                                                                             
                                                                             <?php foreach($personals as $k=>$v):
																			 $personal = $db->get_row("SELECT personal.* FROM personal WHERE personal.id_personal='".$v['id_personal']."'");
																			 if($personal['active']=='1'){
																			 ?>
                                                                                            <option value="<?php echo $v['id_personal'] ?>"><?php echo $personal['firstname']." ". $personal['lastname'];?></option>
                                                                             <?php }endforeach;?>
                                                                    
                                                                            </select>
                                                                                
                                                                   
                                                                </div></div>
                                                                <div class="col-md-12"><div class="form-group">
                                                                    <label for="description" class="control-label">Note:</label>
                                                                    <div class="controls">
                                                                    	<textarea class="form-control" rows="3" name="description" id="description"></textarea>
                                                                    </div>
                                                                </div></div>
                    </div>
                    <div class="modal-footer">
                    	<!--<input type="hidden" value="cancel" name="action">-->
                        <button data-dismiss="modal" class="btn btn-default" type="button">Fermer</button>
                        <button type="submit" id="submit-cancel" name="cancel" class="btn btn-success" >Valider</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        
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
		
		$('#event-edit').validate({
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
				
				var action = $('#event-edit').attr('action');

				$('#submit-edit')
					
		
				$.post(action, $('#event-edit').serialize(),
					function(data){
						$('#msg-edit').html( data );
						$('#msg-edit').slideDown();
						
						$('#event-edit #submit-edit').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#ultraModal-edit').modal('hide');
							$('#msg-edit').hide();
							
							window.setTimeout(function () {
								
								window.location.href = "manage-event.php";
								
							}, 500);
							
						}
					}
				);
		
				return false;

            }
        });

		
		
	<!---->
	$('#open').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                  intervalle: {
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
				
				var action = $('#open').attr('action');

				$('#submit-open')
					
		
				$.post(action, $('#open').serialize(),
					function(data){
						$('#msg-open').html( data );
						$('#msg-open').slideDown();
						
						$('#open #submit-open').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#ultraModal-edit').modal('hide');
							$('#msg-open').hide();
							
							window.setTimeout(function () {
									window.location.href = "manage-event.php";
								
							}, 500);
							
						}
					}
				);
		
				return false;

            }
        });


	<!---->
	$('#cancel').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                  intervalle: {
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
				

				var action = $('#cancel').attr('action');

				$('#submit-cancel')
					
		
				$.post(action, $('#cancel').serialize(),
					function(data){
						$('#msg-cancel').html( data );
						$('#msg-cancel').slideDown();
						
						$('#cancel #submit-cancel').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#section-cancel').modal('hide');
							$('#msg-cancel').hide();
							
							window.setTimeout(function () {
								
								
								
									window.location.href = "manage-event.php";
								
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