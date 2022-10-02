 <script type="text/javascript">
 
 
 var responsiveHelper = undefined;
                var breakpointDefinition = {
                    tablet: 1024,
                    phone: 480
                };
                
				<!--data table invoice-->
				var tableElement = $('#combinaison');

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
                        [2, "asc"]
                    ],
                   "iDisplayLength": 20,
		 "oLanguage": {
			 			"oPaginate": {
							"sNext": "Suivant",
							"sPrevious": "Précédent"
						  },
			 			"sSearch": "",
						"sEmptyTable": "Aucun enregistrement trouvé",
			 			"sInfoFiltered": " - filtré de _MAX_ résultats",
						"infoEmpty": "Aucun résultats trouvé",
                        "sLengthMenu": "_MENU_ ",
                        "sInfo": "Montrer _START_ à _END_ de _TOTAL_ résultats",
						"sZeroRecords": "Aucun enregistrement à afficher"
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
				
				 $('#combinaison .dataTables_filter input').addClass("input-medium "); // modify table search input
                $('#combinaison .dataTables_length select').addClass("select2-wrapper col-md-12"); // modify table per page dropdown



                $('#combinaison input').click(function() {
                    $(this).parent().parent().parent().toggleClass('row_selected');
                });
				
				<!---->
				function delItem(id,id_product){
										
											var combination = $('.combination-'+id);
									
											var a = confirm("Voulez vous vraiment supprimer cette combinaison !");
											/*if(a){
												document.location.href='?id_folder='+id_folder+'&action=deletecombination&id='+id;
											}*/
											if(a){
												$.ajax({
													type: "GET",
													dataType:"html",
													url: "./includes/delete-object.php?object=combination&id_combination="+id+"&id_product="+id_product,
													success: function(data){
														if(data.match('success') != null){
															combination.parents('tr').fadeOut(200);
															if(data.match('last') != null){
																combination.parents('tbody').html('<tr class="odd"><td valign="top" colspan="10" class="dataTables_empty">Aucun résultats trouvé</td></tr>');
																
															}
															showSuccess('combinaison supprimé avec succés')
														}else{
															showErrorMessage('Ops! Something went wrong')
														}
													}
												});
											}
										}
					<!---->
					function AddCombination(id_product)
				{
					jQuery('#ultraModal-add').modal('show', {backdrop: 'static'});
					
					jQuery.ajax({
						url: "combination-add.php?id_product="+id_product,
						success: function(response)
						{
							jQuery('#ultraModal-add .modal-body').html(response);
							var notif_widget = $(".perfect-scroll").height();
									$('.perfect-scroll').height(notif_widget).perfectScrollbar({
									suppressScrollX: true
							});
							<!--select-->
							
							if ($.isFunction($.fn.datetimepicker)) {
			
								$('.form_datetime_lang2').datetimepicker({
									language: 'fr',
									todayBtn: 1,
									autoclose: 1,
									todayHighlight: 1,
									startView: 2,
									forceParse: 0,
									showMeridian: 0,
									pickerPosition: "top-left"
								});
							 }
							if ($.isFunction($.fn.spinner)) {
								$( ".spinner" ).spinner();
							}if ($.isFunction($.fn.timepicker)) {
								$('.timepicker').timepicker({ 
									showMeridian: false,
									defaultTime:'00:00',
								});	
								$(".timepicker").on('click', function(ev) {
									$(".bootstrap-timepicker-widget").css("z-index", "10000");
								}); 
							}
							$('input.icheck-custom').iCheck({
								checkboxClass: 'icheckbox_minimal',
								radioClass: 'iradio_minimal',
								increaseArea: '20%'
							});
							$('.mail-compose-editor2').wysihtml5({
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
							$('.icheck-deal').each(function() {
			
																			 $(this).on('ifChanged', function(combination){
																				
																					//var val=$('input[type=checkbox][name=deal]:checked').attr('value');
																					var val = $(this).filter(':checked').val();
																		   
																					var id = $(this).data('id');
																					
																					
																					
																					if(val==1){
																						$('.deal').removeClass("hidden"); 
																					}else{
																						$('.deal').addClass("hidden"); 
																					}
																						
																				}).iCheck({
																					checkboxClass: 'icheckbox_minimal',
																					radioClass: 'iradio_minimal',
																					increaseArea: '20%'
																			});
																		});
							<!---->
						}
					});
				}
				
				function EditCombination(id_combination,id_product)
				{
					jQuery('#ultraModal-edit').modal('show', {backdrop: 'static'});
					
					jQuery.ajax({
						url: "combination-edit.php?id_combination="+id_combination+"&id_product="+id_product,
						success: function(response)
						{
							jQuery('#ultraModal-edit .modal-body').html(response);
							var notif_widget = $(".perfect-scroll").height();
									$('.perfect-scroll').height(notif_widget).perfectScrollbar({
									suppressScrollX: true
							});
							<!--select-->
							
							if ($.isFunction($.fn.datetimepicker)) {
			
								$('.form_datetime_lang2').datetimepicker({
									language: 'fr',
									todayBtn: 1,
									autoclose: 1,
									todayHighlight: 1,
									startView: 2,
									forceParse: 0,
									showMeridian: 0,
									pickerPosition: "top-left"
								});
							 }
							if ($.isFunction($.fn.spinner)) {
								$( ".spinner" ).spinner();
							}if ($.isFunction($.fn.timepicker)) {
								$('.timepicker').timepicker({ 
									showMeridian: false,
									defaultTime:'00:00',
								});	
								$(".timepicker").on('click', function(ev) {
									$(".bootstrap-timepicker-widget").css("z-index", "10000");
								}); 
							}
							$('input.icheck-custom').iCheck({
								checkboxClass: 'icheckbox_minimal',
								radioClass: 'iradio_minimal',
								increaseArea: '20%'
							});
							$('.mail-compose-editor2').wysihtml5({
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
							
							var val=$('input[type=checkbox][name=deal_combination]:checked').attr('value');
							if(val==1){
								$('.deal').removeClass("hidden"); 
							}else{
								$('.deal').addClass("hidden"); 
							}
							
							<!---->
							$('.icheck-deal').each(function() {
			
																			 $(this).on('ifChanged', function(combination){
																				
																					//var val=$('input[type=checkbox][name=deal]:checked').attr('value');
																					var val = $(this).filter(':checked').val();
																		   
																					var id = $(this).data('id');
																					
																					
																					
																					if(val==1){
																						$('.deal').removeClass("hidden"); 
																					}else{
																						$('.deal').addClass("hidden"); 
																					}
																						
																				}).iCheck({
																					checkboxClass: 'icheckbox_minimal',
																					radioClass: 'iradio_minimal',
																					increaseArea: '20%'
																			});
																		});
							<!---->
						}
					});
				}
												
			<!---->
												
												
<!--validation-->
$(document).ready(function() {
	if ($.isFunction($.fn.validate)) {
		
		$('#combination-add').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
               nbr_person: {
                    required: true,
					number: true
                },
				duration: {
                    required: true
                },
				price: {
                    required: true,
					 number: true,
                },sale_price: {
					 number: true
                },price_deal: {
					 number: true
                },nbr_sale: {
					 number: true
                }
				
            },

            invalidHandler: function(combination, validator) {
                //display error alert on form submit    
            },

            errorPlacement: function(label, element) { // render error placement for each input type   
                console.log(label);
               // $('<span class="error"></span>').insertAfter(element).append(label)
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
				
				var action = $('#combination-add').attr('action');

				$('#submit-add-combination')
				
				
				
				$.ajax({
					  url:action,
					  type:"POST",
					  data: $('#combination-add').serialize(),
					  dataType:"json",
					  success: function(data){
						$('#msg-add-combination').html( data.msg );
						$('#msg-add-combination').slideDown();
						
						//alert(JSON.stringify(data));
						
						if(data.success){
							
							var action = '<button type="button" class="btn btn-default btn-xs navbar-btn btn-icon" data-toggle="modal" onclick="EditCombination('+data.post.id_combination+','+data.post.id_product+')"> <i class="fa fa-edit"></i></button>';
							
								action += ' <button type="button" class="btn btn-default navbar-btn btn-icon btn-xs combination-'+data.post.id_combination+'" onclick="delItem('+data.post.id_combination+','+data.post.id_product+')"> <i class="fa fa-trash"></i></button>';
							
							var row  = '<tr class="tr-'+data.post.id_combination+' odd">';
								row += '<td>'+data.post.nbr_person+'</td>';
								row += '<td>'+data.post.duration+'</td>';
								row += '<td>'+data.post.price+'&euro;</td>';
							if(data.post.on_sale==1){
								
								row += '<td>'+data.post.sale_price+'&euro;</td>';
							}else{
								row += '<td>Non</td>';
							}
							
							if(data.post.deal_combination==1){
								row += '<td> Oui</td>';
								row += '<td>'+data.post.code+'</td>';
								
							row += '<td><span class="deal-expire badge-primary  bold " data-expire="'+data.post.expired+'"></span></td>';
								//row += '<td>'+data.post.expire+'</td>';
								
								
								row += '<td>'+data.post.price_deal+'&euro;</td>';
								row += '<td>'+data.post.nbr_sale+'</td>';
							}else{
                                 row += '<td> Non</td>';
								 row += '<td>//</td>';
                                  row += '<td>//</td>';
								   row += '<td>//</td>';
								    row += '<td>//</td>';                 
                             }
									
								row += '<td>'+action+'</td>';  
								row += '</tr>';
								
								
							$('.dataTables_empty').parents('tr').fadeOut(200);
							
							$('#tbody').prepend(row);
							
							
							window.setTimeout(function () {
								$('#ultraModal-add').modal('hide');
							$('#msg-add-combination').hide();
							showSuccess('Succés');
							}, 500);
							
						}
						
						$('.deal-expire').each(function() {
			  
							  var expire = $(this).data('expire');
							  
							   
								  $(this).countdown(expire, function(event) {
									 $(this).text(
									   event.strftime('%D Jours %H:%M:%S')
									 );
								  });
							  
							  });
					  },error: function(x, e) {
							var s = x.status, 
								m = 'Ajax error: ' ; 
							if (s === 0) {
								m += 'Check your network connection.';
							}
							if (s === 404 || s === 500) {
								m += s;
							}
							if (e === 'parsererror' || e === 'timeout') {
								m += e;
							}
							alert(m);
						}
					})
										
		
				
		
				return false;

            }
        });

		
		<!--end add combination-->
		
		$('#combination-edit').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                   nbr_person: {
                    required: true,
					number: true
                },
				duration: {
                    required: true
                },
				price: {
                    required: true,
					 number: true,
                },sale_price: {
					 number: true
                },price_deal: {
					 number: true
                },nbr_sale: {
					 number: true
                }
                
            },

            invalidHandler: function(combination, validator) {
                //display error alert on form submit    
            },

            errorPlacement: function(label, element) { // render error placement for each input type   
                console.log(label);
               // $('<span class="error"></span>').insertAfter(element).append(label)
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
				
				var action = $('#combination-edit').attr('action');

				$('#submit-edit-combination')
					
		
				$.ajax({
					  url:action,
					  type:"POST",
					  data: $('#combination-edit').serialize(),
					  dataType:"json",
					  success: function(data){
						$('#msg-edit-combination').html( data.msg );
						$('#msg-edit-combination').slideDown();
						
						//alert(JSON.stringify(data));
						
						if(data.success){
							
							var action = '<button type="button" class="btn btn-default btn-xs navbar-btn btn-icon" data-toggle="modal" onclick="EditCombination('+data.post.id_combination+','+data.post.id_product+')"> <i class="fa fa-edit"></i></button>';
							
								action += ' <button type="button" class="btn btn-default navbar-btn btn-icon btn-xs combination-'+data.post.id_combination+'" onclick="delItem('+data.post.id_combination+','+data.post.id_product+')"> <i class="fa fa-trash"></i></button>';
							
							var row  = '';
								row += '<td>'+data.post.nbr_person+'</td>';
								row += '<td>'+data.post.duration+'</td>';
								row += '<td>'+data.post.price+'&euro;</td>';
							if(data.post.on_sale==1){
								
								row += '<td>'+data.post.sale_price+'&euro;</td>';
							}else{
								row += '<td>Non</td>';
							}
							
							if(data.post.deal_combination==1){
								row += '<td> Oui</td>';
								row += '<td>'+data.post.code+'</td>';
								row += '<td>'+data.post.start+'</td>';
								row += '<td><span class="deal-expire badge-primary  bold " data-expire="'+data.post.expired+'"></span></td>';
								row += '<td>'+data.post.end+'</td>';
								
								row += '<td>'+data.post.price_deal+'&euro;</td>';
								row += '<td>'+data.post.nbr_sale+'</td>';
							}else{
                                 row += '<td> Non</td>';
								 row += '<td>//</td>';
                                  row += '<td>//</td>';
								   row += '<td>//</td>';
								    row += '<td>//</td>';    
									row += '<td>//</td>';
								    row += '<td>//</td>';                 
                             }
									
								row += '<td>'+action+'</td>';  
								
								
								
							$('.dataTables_empty').parents('tr').fadeOut(200);
							
							$('.tr-'+data.post.id_combination).html(row);
							
							
							window.setTimeout(function () {
								$('#ultraModal-edit').modal('hide');
							$('#msg-edit-combination').hide();
							showSuccess('Succés');
							}, 500);
							
							
							$('.deal-expire').each(function() {
			  
							  var expire = $(this).data('expire');
							  
							   
								  $(this).countdown(expire, function(event) {
									 $(this).text(
									   event.strftime('%D Jours %H:%M:%S')
									 );
								  });
							  
							  });
							
						}
					  },error: function(x, e) {
							var s = x.status, 
								m = 'Ajax error: ' ; 
							if (s === 0) {
								m += 'Check your network connection.';
							}
							if (s === 404 || s === 500) {
								m += s;
							}
							if (e === 'parsererror' || e === 'timeout') {
								m += e;
							}
							alert(m);
						}
					})
		
				return false;

            }
        });




	
    }
});
									
</script>

  