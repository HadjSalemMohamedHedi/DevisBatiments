<script type="text/javascript">

  var responsiveHelper = undefined;
                var breakpointDefinition = {
                    tablet: 1024,
                    phone: 480
                };
                var tableElement = $('#dataemail');

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
<?php if(!isset($_GET['id_folder'])|| !is_numeric($_GET['id_folder'])){$_GET['id_folder']='null'; }?>
									function delItem(id){
										
											var email = $('.email-'+id);
									
											var a = confirm("Voulez vous vraiment supprimer cet email !");
											/*if(a){
												document.location.href='?id_folder='+id_folder+'&action=deleteemail&id='+id;
											}*/
											if(a){
												$.ajax({
													type: "GET",
													dataType:"html",
													url: "./includes/delete-object.php?object=email&id_email="+id+"&id_folder=<?php echo $_GET['id_folder'];?>",
													success: function(data){
														if(data.match('success') != null){
															email.parents('tr').fadeOut(200);
															if(data.match('last') != null){
																email.parents('tbody').html('<tr class="odd"><td valign="top" colspan="8" class="dataTables_empty"><?php print $lang['infoEmpty']; ?></td></tr>');
																$('button.add-prestation').hide();
															}
															showSuccess('Email supprimé avec succés')
														}else{
															showErrorMessage('Ops! Something went wrong')
														}
													}
												});
											}
										}
										
		var count = 0;
		   
					$('#dataemail tr input.email').each(function() {
						
						if($(this).prop('checked')){
							count ++;
						}
						
					 });
					
					//alert(count);
					if(count==0){
						$('button.add-prestation').hide();
					}else{
						$('button.add-prestation').show();
					}
					<!---->
   			
			  $('.email').on('ifChanged', function(event){
				
					var count = 0;
		   
					$('#dataemail tr input.email').each(function() {
						
						if($(this).prop('checked')){
							count ++;
						}
						
					 });
					
					//alert(count);
					if(count==0){
						$('button.add-prestation').hide();
					}else{
						$('button.add-prestation').show();
					}
						
				}).iCheck({
					checkboxClass: 'icheckbox_minimal',
					radioClass: 'iradio_minimal',
					increaseArea: '20%'
			});
			
			
			
			function EditEmail(id,id_folder)
                                                {
                                                    jQuery('#ultraModal-edit-email').modal('show', {backdrop: 'static'});
													
													//var id_folder = $('#id_folder').val();
													
													

                                                    jQuery.ajax({
                                                        url: "email-edit.php?id_folder="+id_folder+"&id_email="+id,
                                                        success: function(response)

                                                        {
                                                            jQuery('#ultraModal-edit-email .modal-body').html(response);
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
																<!---->
																
																$('.remove-attach').click(function() { 
																
																	var tr = $(this);
			
																	var id = $(this).data('id');
																	
																	 jQuery.ajax({
																		dataType:"json",
																		url: "data/upload-file.php?ac=remove-attach&id_document="+id,
																			success: function(data){
																				if(data.result == 'success'){
																					tr.parents('tr').fadeOut(200);
																				}else{
																					showErrorMessage('Ops! Something went wrong');
																				}
																			}
																
																		});
																
																});
																<!---->
																
																/*var id = $(".id_folder").val();
																if($.isNumeric(id)){
																	$('.dropzone-container').slideDown(100);
																}
																
																$(".id_folder").change(function(){
																// alert($(this).val());
																	id_folder = $(this).val();
																	if($.isNumeric(id_folder )){
																		$('.dropzone-container').slideDown(100);
																	}else{
																		$('.dropzone-container').slideUp(100);
																	}
																});*/
																<!---->
																
																
																	
																			
															
																
															 if ($.isFunction($.fn.dropzone)) {
																 
																 /**/
																					
																					var id_document  = <?php echo nextIdDoc() ?>;
																					var i = $("#count_file").val(),
																					$custom_droplist = $("#custom-droptable"),
																					example_dropzone = $("#customDZ").dropzone({
																						url: "data/upload-file.php?id_folder="+id_folder+"&id_email="+id+"&id_document="+id_document,
																	
																						// Events
																						addedfile: function(file) {
																							/****************/
																							/*jQuery.ajax({
																								dataType:"json",
																								url: "./includes/get-id-new-doc.php",
																										success: function(doc){
																											id_document = doc.id_document;*/
																							
																							if (i == 0) {
																								$custom_droplist.find('tbody').html('');
																							}else{
																								i = parseInt(i)+1;	
																							}
																	
																							var size = parseInt(file.size / 1024, 10);
																							size = size < 1024 ? (size + " KB") : (parseInt(size / 1024, 10) + " MB");
																	
																							var $el = $('<tr>\
																														<td class="text-center">' + (i++) + '</td>\
																														<td>' + file.name + '</td>\
																														<td><div class="progress"><div class="progress-bar progress-bar-warning"></div></div></td>\
																														<td>' + size + '</td>\
																														<td><a href="javascript:void(0)" class="remove-attach btn btn-orange btn-sm" data-id="'+id_document+'"><i class="fa fa-close"></i></a></td>\
																													</tr>');
																							
																	
																							$custom_droplist.find('tbody').append($el);
																							file.fileEntryTd = $el;
																							file.progressBar = $el.find('.progress-bar');
																							id_document = parseInt(id_document)+1;				
																							/****************/
																						},
																	
																						uploadprogress: function(file, progress, bytesSent) {
																							file.progressBar.width(progress + '%');
																							$('.custom-dropzone .drop-table').perfectScrollbar({
																								suppressScrollX: true
																							});
																						},
																						
																						/* success: function( file, result ){
																							 obj = JSON.stringify(result);
																								 alert(obj); 
																							 // <---- here is your filename
																						},*/
																																		
																						success: function(file) {
																							file.progressBar.removeClass('progress-bar-warning').addClass('progress-bar-success');
																							$('.remove-attach').click(function() { 
																								var tr = $(this);
																								var id = $(this).data('id');
																	
																							 jQuery.ajax({
																								dataType:"json",
																								url: "data/upload-file.php?ac=remove-attach&id_document="+id,
																									success: function(data){
																										if(data.result == 'success'){
																											tr.parents('tr').fadeOut(200);
																										}else{
																											showErrorMessage('Ops! Something went wrong')
																										}
																									}
																						
																								});
										
																								
																								
																								
																							
																							});
																						},
																	
																						error: function(file) {
																							file.progressBar.removeClass('progress-bar-warning').addClass('progress-bar-red');
																						}
																					});
																									
																				/*}});*/

																
													
															}

															<!---->
																var notif_widget = $(".test-widget").height();
																$('.test-widget').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
																});
																
																var cc = $('input#cc');
																if(cc.val()!==''){
																	$(".mail_compose_cc").show();
																}
																var bcc = $('input#bcc');
																if(bcc.val()!==''){
																	$(".mail_compose_bcc").show();
																}
															
															
															
																 $('span.cc').click(function() { 
																 var ele = $(".mail_compose_cc");
																		if (ele.is(":visible")) {
																			ele.hide();
																		} else {
																			ele.show();
																		}
																	});
															
																	$('span.bcc').click(function() {
																		var ele = $(".mail_compose_bcc");
																		if (ele.is(":visible")) {
																			ele.hide();
																		} else {
																			ele.show();
																		}
																	});
																	
																	$('.iCheck').iCheck({
																		checkboxClass: 'icheckbox_minimal',
																		radioClass: 'iradio_minimal',
																		increaseArea: '20%'
																	});
																	
																	$('.mail-compose-editor').wysihtml5({
																	toolbar: {
																		"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
																		"emphasis": true, //Italics, bold, etc. Default true
																		"lists": false, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
																		"html": true, //Button which allows you to edit the generated HTML. Default false
																		"link": true, //Button to insert a link. Default true
																		"image": false, //Button to insert an image. Default true,
																		"color": false, //Button to change color of font  
																		"blockquote": false, //Blockquote  
																		"size": "none" //default: none, other options are xs, sm, lg
																	}
																});
															
															$('#date-email-edit').datepicker({
															 format: "<?php echo $lang_default['date_format_js']; ?>",
															 icons: {
															  time: "fa fa-clock-o",
															  date: "fa fa-calendar",
															  up: "fa fa-arrow-up",
															  down: "fa fa-arrow-down"
																}
													 		 });
															  $("#date-email").on("dp.show",function (e) {
																var newtop = $('.bootstrap-datetimepicker-widget').position().top - 45;      
																$('.bootstrap-datetimepicker-widget').css('top', newtop + 'px');
															  });
															
                                                        }
                                                    });
                                                }
												
												<!---->
												function shareEmail(id_email,id_folder){
													
													jQuery('#ultraModal-share-email').modal('show', {backdrop: 'static'});
													 jQuery.ajax({
                                                        url: "email-share.php?id_folder="+id_folder+"&id_email="+id_email,
                                                        success: function(response)
                                                        {
                                                            jQuery('#ultraModal-share-email .modal-body').html(response);
															var notif_widget = $(".test-widget").height();
																$('.test-widget').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
																});
														}
													 });
													
												}
												<!---->
												
												 function AddEmail(id_folder,id_email)
                                                {
                                                    jQuery('#ultraModal-add-email').modal('show', {backdrop: 'static'});
													
                                                    jQuery.ajax({
                                                        url: "email-add.php?id_folder="+id_folder+"&id_email="+id_email,
                                                        success: function(response)
                                                        {
                                                            jQuery('#ultraModal-add-email .modal-body').html(response);
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
															<!---->
															
															if(!$.isNumeric(id_folder )){
															 $(".id_folder").change(function(){
																// alert($(this).val());
																id_folder = $(this).val();
																if($.isNumeric(id_folder )){
																	
																	$('.dropzone-container').slideDown(100);
																	
																		if ($.isFunction($.fn.dropzone)) {
																		
																			var id_document  = <?php echo nextIdDoc() ?>;
		
																		var i = 1,
																			$custom_droplist = $("#custom-droptable-add"),
																			example_dropzone = $("#customDZ2").dropzone({
																				
																				
																				
																				url: "data/upload-file.php?id_folder="+id_folder+"&id_email="+id_email+"&id_document="+id_document,
															
																				// Events
																				addedfile: function(file) {
																					if (i == 1) {
																						$custom_droplist.find('tbody').html('');
																					}
															
																					var size = parseInt(file.size / 1024, 10);
																					size = size < 1024 ? (size + " KB") : (parseInt(size / 1024, 10) + " MB");
															
																					var $el = $('<tr>\
																												<td class="text-center">' + (i++) + '</td>\
																												<td>' + file.name + '</td>\
																												<td><div class="progress"><div class="progress-bar progress-bar-warning"></div></div></td>\
																												<td>' + size + '</td>\
																												<td><a href="javascript:void(0)" class="remove-attach btn btn-orange btn-sm" data-id="'+id_document+'"><i class="fa fa-close"></i></a></td>\
																											</tr>');
															
																					$custom_droplist.find('tbody').append($el);
																					file.fileEntryTd = $el;
																					file.progressBar = $el.find('.progress-bar');
																					id_document = parseInt(id_document)+1;
																				},
															
																				uploadprogress: function(file, progress, bytesSent) {
																					file.progressBar.width(progress + '%');
																					$('.custom-dropzone .drop-table').perfectScrollbar({
																						suppressScrollX: true
																					});
																				},
															
																				success: function(file) {
																					file.progressBar.removeClass('progress-bar-warning').addClass('progress-bar-success');
																					
																					$('.remove-attach').click(function() { 
																		
																						var tr = $(this);
																						var id = $(this).data('id');
																	
																							 jQuery.ajax({
																								dataType:"json",
																								url: "data/upload-file.php?ac=remove-attach&id_document="+id,
																									success: function(data){
																										if(data.result == 'success'){
																											tr.parents('tr').fadeOut(200);
																										}else{
																											showErrorMessage('Ops! Something went wrong')
																										}
																									}
																						
																								});
																						
																						
																					
																					});
																				},
															
																				error: function(file) {
																					file.progressBar.removeClass('progress-bar-warning').addClass('progress-bar-red');
																				}
																			});
																			
																		
															
																	}
																}else{
																	$('.dropzone-container').slideUp(100);
																	showErrorMessage('Veuillez choisir le dossier de cet email !');
																}
															 });
															 
															 /**/
															}else{
																
																$('.dropzone-container').slideDown();
																
																if ($.isFunction($.fn.dropzone)) {
																		
																		
																		var id_document  = <?php echo nextIdDoc() ?>;
																		var i = 1,
																			$custom_droplist = $("#custom-droptable-add"),
																			example_dropzone = $("#customDZ2").dropzone({
																				
																				
																				
																				url: "data/upload-file.php?id_folder="+id_folder+"&id_email="+id_email+"&id_document="+id_document,
															
																				// Events
																				addedfile: function(file) {
																					if (i == 1) {
																						$custom_droplist.find('tbody').html('');
																					}
															
																					var size = parseInt(file.size / 1024, 10);
																					size = size < 1024 ? (size + " KB") : (parseInt(size / 1024, 10) + " MB");
															
																					var $el = $('<tr>\
																												<td class="text-center">' + (i++) + '</td>\
																												<td>' + file.name + '</td>\
																												<td><div class="progress"><div class="progress-bar progress-bar-warning"></div></div></td>\
																												<td>' + size + '</td>\
																												<td><a href="javascript:void(0)" class="remove-attach btn btn-orange btn-sm" data-id="'+id_document+'"><i class="fa fa-close"></i></a></td>\
																											</tr>');
															
																					$custom_droplist.find('tbody').append($el);
																					file.fileEntryTd = $el;
																					file.progressBar = $el.find('.progress-bar');
																					id_document = parseInt(id_document)+1;
																				},
															
																				uploadprogress: function(file, progress, bytesSent) {
																					file.progressBar.width(progress + '%');
																					$('.custom-dropzone .drop-table').perfectScrollbar({
																						suppressScrollX: true
																					});
																				},
															
																				success: function(file) {
																					file.progressBar.removeClass('progress-bar-warning').addClass('progress-bar-success');
																					
																					
																					
																					$('.remove-attach').click(function() { 
																		
																						var tr = $(this);
																						var id = $(this).data('id');
																	
																							 jQuery.ajax({
																								dataType:"json",
																								url: "data/upload-file.php?ac=remove-attach&id_document="+id,
																									success: function(data){
																										if(data.result == 'success'){
																											tr.parents('tr').fadeOut(200);
																										}else{
																											showErrorMessage('Ops! Something went wrong');
																										}
																									}
																						
																								});
																						
																						
																					
																					});
																				},
															
																				error: function(file) {
																					file.progressBar.removeClass('progress-bar-warning').addClass('progress-bar-red');
																				}
																			});
																
																	}
															}
															<!---->
													

															<!---->
															var notif_widget = $(".test-widget").height();
																$('.test-widget').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
																});
															
															
															$('span.cc').click(function() {
																  
																 
															     var ele = $(".mail_compose_cc");
																		if (ele.is(":visible")) {
																			ele.hide();
																		} else {
																			ele.show();
																		}
																	});
															
																	$('span.bcc').click(function() {
																		var ele = $(".mail_compose_bcc");
																		if (ele.is(":visible")) {
																			ele.hide();
																		} else {
																			ele.show();
																		}
																	});
																	
																	$('.iCheck').iCheck({
																		checkboxClass: 'icheckbox_minimal',
																		radioClass: 'iradio_minimal',
																		increaseArea: '20%'
																	});
																<!---->	
																$('.mail-compose-editor').wysihtml5({
																	toolbar: {
																		"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
																		"emphasis": true, //Italics, bold, etc. Default true
																		"lists": false, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
																		"html": true, //Button which allows you to edit the generated HTML. Default false
																		"link": true, //Button to insert a link. Default true
																		"image": false, //Button to insert an image. Default true,
																		"color": true, //Button to change color of font  
																		"blockquote": false, //Blockquote  
																		"size": "none" //default: none, other options are xs, sm, lg
																	}
																});
																													<!---->
															  $('#date-email').datepicker({
																  language: '<?php echo $_SESSION['language']; ?>',
																 format: "<?php echo $lang_default['date_format_js']; ?>",
																 icons: {
																  time: "fa fa-clock-o",
																  date: "fa fa-calendar",
																  up: "fa fa-arrow-up",
																  down: "fa fa-arrow-down"
																}
													 		 });
															  $("#date-email").on("dp.show",function (e) {
																var newtop = $('.bootstrap-datetimepicker-widget').position().top - 45;      
																$('.bootstrap-datetimepicker-widget').css('top', newtop + 'px');
															  });
																<!---->
																									
															
															
                                                        }
                                                    });
                                                }
												
												<!--validation-->
$(document).ready(function() {


    if ($.isFunction($.fn.validate)) {
												<!--add email-->
		
		$.validator.addMethod("time", function(value, element) {  
return this.optional(element) || /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/i.test(value);  
}, "Durée valide.");
		
		$('#email-add').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
               
				email_to: {
                    required: true,
					email: true
                },
				email_cc: {
                    
					email: true
                },
				email_bcc: {
                    
					email: true
                },
				subject: {
                    required: true
                },message: {
                    required: true
                },id_folder: {
                    required: true
                },date: {
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
				
				var action = $('#email-add').attr('action');

				/*$('#submit-add-email')
				
				$.ajax({
				data: form.serialize(),
				type: 'POST',
				success: function(data) {
					alert('data');
				}
					
				});*/
					
		
				$.post(action, $('#email-add').serialize(),
					function(data){
						
						var id = $('#id_folder').val();
							var id_email =  parseInt(data);
						
						$('#msg-add-email').html( data );
						$('#msg-add-email').slideDown();
						
						$('#email-add #submit-add-email').removeAttr('disabled');
						
						if(data){
							
							if(data.match('success') != null || $.isNumeric(id_email)){
								$('#ultraModal-add-email').modal('hide');
								$('#msg-add-email').hide();
								
								showSuccess('Email créé avec succés')
							}
							
							<!---->
							 /*if($('#prested').prop('checked')){*/
							 
							 if($.isNumeric(id_email)){
								
							
                                                    jQuery('#ultraModal-add').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
                                                        url: "prestation-add.php?id_folder="+id+"&id_email="+id_email,
                                                        success: function(response)
                                                        {
                                                            jQuery('#ultraModal-add .modal-body').html(response);
															
															 $('#time').timepicker({ 
															 showMeridian: false,
															  defaultTime:'00:00',
															 });	
															
															
															  $('#date-prestation').datepicker({
																  language: '<?php echo $_SESSION['language']; ?>',
																 format: "<?php echo $lang_default['date_format_js']; ?>",
																 icons: {
																  time: "fa fa-clock-o",
																  date: "fa fa-calendar",
																  up: "fa fa-arrow-up",
																  down: "fa fa-arrow-down"
																}
													 		 });
															  $("#date-prestation").on("dp.show",function (e) {
																var newtop = $('.bootstrap-datetimepicker-widget').position().top - 45;      
																$('.bootstrap-datetimepicker-widget').css('top', newtop + 'px');
															  });
																<!---->
															 $("#id_type_prestation").select2({
																placeholder: 'Choisissez',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
																												
															<!--multiple folder-->
															 $("#id_folder_add").select2({
																placeholder: 'Choisissez',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
															
                                                        }
                                                    });
							 }else if(data.match('success') != null){
								<!---->
								window.setTimeout(function () {
									
									
									
									if($.isNumeric(id)){
										window.location.href = "folder-detail.php?id_folder="+ id +"&tab=email";
									}else{
										window.location.href = "manage-email.php";
									}
								}, 500);
							 }
							
						}
					}
				);
		
				return false;

            }
        });

		
		<!--end add email-->
		$('#email-edit').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                 
				email_to: {
                    required: true,
					email: true
                },
				email_cc: {
                    
					email: true
                },
				email_bcc: {
                    
					email: true
                },
				subject: {
                    required: true
                },message: {
                    required: true
                },id_folder: {
                    required: true
                },date: {
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
				
				var action = $('#email-edit').attr('action');

				$('#submit-edit-email')
					
		
				$.post(action, $('#email-edit').serialize(),
					function(data){
						$('#msg-edit-email').html( data );
						$('#msg-edit-email').slideDown();
						
						$('#ultraModal-edit-email #submit-edit-email').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#ultraModal-edit-email').modal('hide');
							$('#msg-edit-email').hide();
							
							window.setTimeout(function () {
								
								var id = $('#id_folder').val();
								
								if($.isNumeric(id)){
									
									window.location.href = "folder-detail.php?id_folder="+ id +"&tab=email";
								}else{
									window.location.href = "manage-email.php";
								}
							}, 500);
							
						}
					}
				);
		
				return false;

            }
        });
		
		<!---->
		$('#email-share').validate({
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
				
				var action = $('#email-share').attr('action');

				$('#submit-share-email')
					
		
				$.post(action, $('#email-share').serialize(),
					function(data){
						$('#msg-share-email').html( data );
						$('#msg-share-email').slideDown();
						
						$('#ultraModal-share-email #submit-share-email').removeAttr('disabled');
						if(data.match('danger') != null){
							
							
							
						}else if(data.match('success') != null){
							$('#ultraModal-share-email').modal('hide');
							$('#msg-share-email').hide();
							
							window.setTimeout(function () {
								
								var id = $('#id_folder').val();
								
								
								showSuccess('Email partagé avec succés');
								
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
		
		<!--end edit email-->
		

    }




});
			
</script>			 
<div class="modal fade" id="ultraModal-edit-email">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="email-edit" class="" action="./includes/validate-email.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Modifier email</h4>
                                                            </div>
                                                            
                                                            <div id="msg-edit-email" style="padding:15px;">
                                                            
                                                            </div>
        
                                                            <div class="modal-body test-widget">
        
                                                                loading...
        
                                                            </div>
        
                                                           
                                                            <div class="modal-footer">
                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                    <div class='pull-left'>
                                                                        <button class="btn btn-primary hidden">
                                                                            <i class="fa fa-paper-plane-o icon-xs"></i> &nbsp; Envoyer
                                                                        </button>
                                                                        <button type="submit" id="submit-edit-email"  class="btn btn-purple">
                                                                            <i class="fa fa-floppy-o icon-xs"></i> &nbsp; Enregistrer
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




		<div class="modal fade" id="ultraModal-add-email">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="email-add" class="" action="./includes/validate-email.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Ajouter un email</h4>
                                                            </div>
                                                            
                                                            <div id="msg-add-email" style="padding:15px;">
                                                            
                                                            </div>
        
                                                            <div class="modal-body test-widget">
        
                                                                loading...
        
                                                            </div>
        
                                                            <div class="modal-footer">
                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                    <div class='pull-left'>
                                                                        <button class="btn btn-primary hidden">
                                                                            <i class="fa fa-paper-plane-o icon-xs"></i> &nbsp; Envoyer
                                                                        </button>
                                                                        <button type="submit" id="submit-add-email"  class="btn btn-purple">
                                                                            <i class="fa fa-floppy-o icon-xs"></i> &nbsp; Enregistrer
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
                                                
                                                <div class="modal fade" id="ultraModal-share-email">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="email-share" class="" action="./includes/validate-email.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Partage client</h4>
                                                            </div>
                                                            
                                                            <div id="msg-share-email" style="padding:15px; display:none;">
                                                            
                                                            </div>
        
                                                            <div class="modal-body test-widget">
        
                                                                loading...
        
                                                            </div>
        
                                                            <div class="modal-footer">
                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                    <div class='pull-left'>
                                                                        <button class="btn btn-primary hidden">
                                                                            <i class="fa fa-paper-plane-o icon-xs"></i> &nbsp; Envoyer
                                                                        </button>
                                                                        <button type="submit" id="submit-share-email"  class="btn btn-purple">
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
