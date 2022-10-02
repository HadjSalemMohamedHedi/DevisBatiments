 <script type="text/javascript">
 
 
 var responsiveHelper = undefined;
                var breakpointDefinition = {
                    tablet: 1024,
                    phone: 480
                };
                
				<!--data table invoice-->
				var tableElement = $('#dataevent');

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
				
				 $('#example_wrapper .dataTables_filter input').addClass("input-medium "); // modify table search input
                $('#example_wrapper .dataTables_length select').addClass("select2-wrapper col-md-12"); // modify table per page dropdown



                $('#dataprestation input').click(function() {
                    $(this).parent().parent().parent().toggleClass('row_selected');
                });
				
					<!---->
												function shareEvent(id_event,id_folder){
													
													jQuery('#ultraModal-share-event').modal('show', {backdrop: 'static'});
													 jQuery.ajax({
                                                        url: "event-share.php?id_folder="+id_folder+"&id_event="+id_event,
                                                        success: function(response)
                                                        {
                                                            jQuery('#ultraModal-share-event .modal-body').html(response);
															var notif_widget = $(".test-widget").height();
																$('.test-widget').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
																});
														}
													 });
													
												}
												<!---->
 <!---->
 function delEvent(id_folder,id){

												var a = confirm("Voulez-vous vraiment placer cette événement dans la Corbeille?");
													if(a){
													document.location.href='?id_folder='+id_folder+'&action=deleteevent&id='+id;
													}
												
												}
	
function Editevent(id)
                                                {
                                                    jQuery('#ultraModal-edit-event').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
                                                        url: "event-edit.php?id_folder=<?php echo $_GET['id_folder']; ?>&id_event="+id,
                                                        success: function(response)

                                                        {
                                                            jQuery('#ultraModal-edit-event .modal-body').html(response);
															
															
															var notif_widget = $(".test-widget").height();
																$('.test-widget').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
																});
															
															 $('.form_datetime_lang').datetimepicker({
																	language: '<?php echo $_SESSION['language']; ?>',
																	weekStart: 1,
																	todayBtn: 1,
																	autoclose: 1,
																	todayHighlight: 1,
																	startView: 2,
																	forceParse: 0,
																	showMeridian: 0
																});
																
																
																$('.iCheck').iCheck({
																	checkboxClass: 'icheckbox_minimal',
																	radioClass: 'iradio_minimal',
																	increaseArea: '20%'
																});
															
																var shared_dft = $('#shared_dft').val();
					
					
																	if(shared_dft<2){
																		 $('.lawyer_list').slideUp(500); 
																		
																		}else{
																				$('.lawyer_list').slideDown(500);
																		}
												
																$('input.icheck-custom').on('ifClicked', function(event){
																	 
																	var val =$(this).attr('value');
																	
																	if(val>1){
																		$('.lawyer_list').slideDown(500);
																		//return false;
																		
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
												
												 function Addevent()
                                                {
                                                    jQuery('#ultraModal-add-event').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
                                                        url: "event-add.php?id_folder=<?php echo $_GET['id_folder']; ?>",
                                                        success: function(response)
                                                        {
                                                            jQuery('#ultraModal-add-event .modal-body').html(response);
															
															var notif_widget = $(".test-widget").height();
																$('.test-widget').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
																});
															 $('.form_datetime_lang').datetimepicker({
																	language: '<?php echo $_SESSION['language']; ?>',
																	
																	weekStart: 1,
																	todayBtn: 1,
																	autoclose: 1,
																	todayHighlight: 1,
																	startView: 2,
																	forceParse: 0,
																	showMeridian: 0
																});
																
																$('.iCheck').iCheck({
																	checkboxClass: 'icheckbox_minimal',
																	radioClass: 'iradio_minimal',
																	increaseArea: '20%'
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
												<!--validation-->
												$(document).ready(function() {
												if ($.isFunction($.fn.validate)) {
		
		$('#event-add').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
               title: {
                    required: true
                },
				dominus: {
                    required: true
                },
				supervisor: {
                    required: true
                },
				manager: {
                    required: true
                },
				juridiction: {
                    required: true
                },
				id_folder: {
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
				
				var action = $('#event-add').attr('action');

				$('#submit-add-event')
					
		
				$.post(action, $('#event-add').serialize(),
					function(data){
						$('#msg-add-event').html( data );
						$('#msg-add-event').slideDown();
						
						$('#event-add #submit-add-event').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#ultraModal-add-event').modal('hide');
							$('#msg-add-event').hide();
							window.setTimeout(function () {
									var id = $('#folder').val();
								
									if($.isNumeric(id)){
										window.location.href = "folder-detail.php?id_folder="+ id +"&tab=agenda";
									}else{
										window.location.href = "manage-event.php";
									}
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
                  title: {
                    required: true
                },
				dominus: {
                    required: true
                },
				supervisor: {
                    required: true
                },
				manager: {
                    required: true
                },
				juridiction: {
                    required: true
                },
				id_folder: {
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
				
				var action = $('#event-edit').attr('action');

				$('#submit-edit-event')
					
		
				$.post(action, $('#event-edit').serialize(),
					function(data){
						$('#msg-edit-event').html( data );
						$('#msg-edit-event').slideDown();
						
						$('#event-edit #submit-edit-event').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#ultraModal-edit-event').modal('hide');
							$('#msg-edit-event').hide();
							
							window.setTimeout(function () {
								
								var id = $('#folder').val();
								
									if($.isNumeric(id)){
										window.location.href = "folder-detail.php?id_folder="+ id +"&tab=agenda";
									}else{
										window.location.href = "manage-event.php";
									}
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
									window.location.href = "agenda.php";
								
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
								
								
								
									window.location.href = "agenda.php";
								
							}, 500);
							
						}
					}
				);
		
				return false;

            }
        });
		
	<!---->
	$('#event-share').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                 
				
				
                
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
				
				var action = $('#event-share').attr('action');

				$('#submit-share-event')
					
		
				$.post(action, $('#event-share').serialize(),
					function(data){
						$('#msg-share-event').html( data );
						$('#msg-share-event').slideDown();
						
						$('#ultraModal-share-event #submit-share-event').removeAttr('disabled');
						if(data.match('danger') != null){
							
							
							
						}else if(data.match('success') != null){
							$('#ultraModal-share-event').modal('hide');
							$('#msg-share-event').hide();
							
							window.setTimeout(function () {
								
								var id = $('#id_folder').val();
								
								
								showSuccess('Événements partagé avec succés');
								
								/*if($.isNumeric(id)){
									
									window.location.href = "folder-detail.php?id_folder="+ id +"&tab=email";
								}else{
									window.location.href = "manage-email.php";
								}*/
							}, 500);
							
						}
					}
				);
		
				return false;

            }
        });
		
		<!--end -->



    }
												});
									
</script>

  <div class="modal fade" id="ultraModal-add-event">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="event-add" class="" action="./includes/validate-event.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Ajouter un événement</h4>
                                                            </div>
                                                            
                                                            <div id="msg-add-event" style="padding:15px;">
                                                            
                                                            </div>
        
                                                            <div class="modal-body test-widget">
        
                                                                loading...
        
                                                            </div>
        
                                                            <div class="modal-footer">
                                                                <!--<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>-->
                                                                <button type="submit" id="submit-add-event" class="btn btn-purple"><i class="fa fa-floppy-o icon-xs"></i>&nbsp; Valider</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
        <!--edit-->
        <div class="modal fade" id="ultraModal-edit-event">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="event-edit" class="" action="./includes/validate-event.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Modifier l'événement</h4>
                                                            </div>
                                                            
                                                            <div id="msg-edit-event" style="padding:15px;">
                                                            
                                                            </div>
        
                                                            <div class="modal-body test-widget">
        
                                                                loading...
        
                                                            </div>
        
                                                            <div class="modal-footer ">
                                                                <!--<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>-->
                                                                <button type="submit" id="submit-edit-event" class="btn btn-purple"><i class="fa fa-floppy-o icon-xs"></i>&nbsp; Valider</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!---->
                                                
                  </div>
  
  <div class="modal fade" id="ultraModal-share-event">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="event-share" class="" action="./includes/validate-event.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Partage client</h4>
                                                            </div>
                                                            
                                                            <div id="msg-share-event" style="padding:15px; display:none;">
                                                            
                                                            </div>
        
                                                            <div class="modal-body test-widget">
        
                                                                loading....
        
                                                            </div>
        
                                                            <div class="modal-footer">
                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                    <div class='pull-left'>
                                                                        <button class="btn btn-primary hidden">
                                                                            <i class="fa fa-paper-plane-o icon-xs"></i> &nbsp; Envoyer
                                                                        </button>
                                                                        <button type="submit" id="submit-share-event"  class="btn btn-purple">
                                                                            <i class="fa fa-share-alt icon-xs"></i> &nbsp; Partager
                                                                        </button>
                                                                        <button class="btn btn-secondary hidden"  name="trash" value="1">
                                                                            <i class="fa fa-trash-o icon-xs"></i> &nbsp; Corbeille
                                                                        </button>
                                                                    </div>
                
                                                                </div>
                                                               
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>