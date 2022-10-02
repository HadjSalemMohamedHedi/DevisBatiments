 <script type="text/javascript">
 var responsiveHelper = undefined;
                var breakpointDefinition = {
                    tablet: 1024,
                    phone: 480
                };
                var tableElement = $('#datagiftprice');

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
                        if (!responsiveHelper) {
                        }
                    },
                    fnRowCallback: function(nRow) {
                    },
                    fnDrawCallback: function(oSettings) {
                    }
                });
				
				function Addgiftprice() {
                                                    jQuery('#ultraModal-add').modal('show', {backdrop: 'static'});
													
                                                    jQuery.ajax({
                                                        url: "gift-price-add.php",
                                                        success: function(response)
                                                        {
                                                            jQuery('#ultraModal-add .modal-body').html(response);
																$('.iCheck').iCheck({
																	checkboxClass: 'icheckbox_minimal',
																	radioClass: 'iradio_minimal',
																	increaseArea: '20%'
																});
																var notif_widget = $(".perfect-scroll").height();
																$('.perfect-scroll').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
																});
																
																
																
																$('.mail-compose-editor').wysihtml5({
																	toolbar: {
																		"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
																		"emphasis": true, //Italics, bold, etc. Default true
																		"lists": false, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
																		"html": true, //Button which allows you to edit the generated HTML. Default false
																		"link": false, //Button to insert a link. Default true
																		"image": false, //Button to insert an image. Default true,
																		"color": true, //Button to change color of font  
																		"blockquote": false, //Blockquote  
																		"size": "none" //default: none, other options are xs, sm, lg
																	}
																});
																
																$('input.icheck-custom').on('ifChanged', function(event){
					 
																	
																	
																	var val = $('input[type=checkbox][name=type]:checked').attr('value');
																	
																	//alert(val);
																	if(val==1){
																		 $('.price').slideUp(100); 
																		 $('.discount').slideDown(500);
																		}else {
																		 $('.discount').slideUp(100);
																		 $('.price').slideDown(500); 
																		}
																	}).iCheck({
																	  checkboxClass: 'icheckbox_minimal',
																	  radioClass: 'iradio_minimal',
																	  increaseArea: '20%'
																	});
															<!---->
															
															if ($.isFunction($.fn.spinner)) {
																$( ".spinner" ).spinner();
															}

																
																	$('.iCheck').iCheck({
																		checkboxClass: 'icheckbox_minimal',
																		radioClass: 'iradio_minimal',
																		increaseArea: '20%'
																	});
																	
																 /*$("#id_category_add").select2({
																	placeholder: 'Choisissez',
																	allowClear: true
																}).on('select2-open', function() {
																	$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
																});*/
																
																								
															
															
                                                        }
                                                    });
                                                }
												
												function Editgiftprice(id)
                                                {
                                                    jQuery('#ultraModal-edit').modal('show', {backdrop: 'static'});
													
													
                                                    jQuery.ajax({
                                                        url: "gift-price-edit.php?id_gift_price="+id,
                                                        success: function(response)

                                                        {
                                                            jQuery('#ultraModal-edit .modal-body').html(response);
															
																var notif_widget = $(".perfect-scroll").height();
																$('.perfect-scroll').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
																});
																
																
																
																$('.mail-compose-editor').wysihtml5({
																	toolbar: {
																		"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
																		"emphasis": true, //Italics, bold, etc. Default true
																		"lists": false, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
																		"html": true, //Button which allows you to edit the generated HTML. Default false
																		"link": false, //Button to insert a link. Default true
																		"image": false, //Button to insert an image. Default true,
																		"color": true, //Button to change color of font  
																		"blockquote": false, //Blockquote  
																		"size": "none" //default: none, other options are xs, sm, lg
																	}
																});
																
															
																if ($.isFunction($.fn.spinner)) {
																	$( ".spinner" ).spinner();
																}
																										
																
															
                                                        }
                                                    });
                                                }
 
 
$(document).ready(function() {


    if ($.isFunction($.fn.validate)) {
	<!--add giftprice-->
		$.validator.addMethod("time", function(value, element) {  
return this.optional(element) || /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/i.test(value);  
}, "Durée valide.");
		
		$('#giftprice-add').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
               nbr: {
                    required: true,
					number: true
                },
				duration: {
                    required: true
                },
				price: {
                    required: true,
					 number: true,
                }
				
            },

            invalidHandler: function(event, validator) {
                //display error alert on form submit    
            },

            errorPlacement: function(label, element) { // render error placement for each input type   
                console.log(label);
                //$('<span class="error"></span>').insertAfter(element).append(label)
                var parent = $(element).parents('div.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },

            highlight: function(element) { // hightlight error inputs
                var parent = $(element).parents('div.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },

            unhighlight: function(element) { // revert the change done by hightlight

            },

            success: function(label, element) {
                var parent = $(element).parents('div.form-group');
                parent.removeClass('has-error').addClass('has-success');
            },

            submitHandler: function(form) {
				
				var action = $('#giftprice-add').attr('action');

		
				$.post(action, $('#giftprice-add').serialize(),
					function(data){
						
						
							
						
						$('#msg-add').html( data );
						$('#msg-add').slideDown();
						
						$('#giftprice-add #submit-add').removeAttr('disabled');
						
						
							 
							if(data.match('success') != null){
								<!---->
								window.setTimeout(function () {
									
										window.location.href = "manage-gift-choice.php";
									
								}, 500);
							 }
						
					}
				);
		
				return false;

            }
        });

		
		<!--end add giftprice-->
		$('#giftprice-edit').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
               nbr: {
                    required: true,
					number: true
                },
				duration: {
                    required: true
                },
				price: {
                    required: true,
					 number: true,
                }
				
            },

            invalidHandler: function(event, validator) {
                //display error alert on form submit    
            },

            errorPlacement: function(label, element) { // render error placement for each input type   
                console.log(label);
               // $('<span class="error"></span>').insertAfter(element).append(label)
                 var parent = $(element).parents('div.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },

            highlight: function(element) { // hightlight error inputs
                  var parent = $(element).parents('div.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },

            unhighlight: function(element) { // revert the change done by hightlight

            },

            success: function(label, element) {
                 var parent = $(element).parents('div.form-group');
                parent.removeClass('has-error').addClass('has-success');
            },

            submitHandler: function(form) {
				
				var action = $('#giftprice-edit').attr('action');

				$('#submit-edit')
					
		
				$.post(action, $('#giftprice-edit').serialize(),
					function(data){
						$('#msg-edit').html( data );
						$('#msg-edit').slideDown();
						
						$('#ultraModal-edit #submit-edit').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#ultraModal-edit').modal('hide');
							$('#msg-edit').hide();
							
							window.setTimeout(function () {
								
									window.location.href = "manage-gift-choice.php";
								
							}, 500);
							
						}/*else{
								showErrorMessage('Ops! Something went wrong');
							}*/
					}
				);
		
				return false;

            }
        });
		
		<!---->
		
		

    }




});

			function delItem(id){
										
											var giftprice = $('.giftprice-'+id);
									
											var a = confirm("Voulez vous vraiment supprimer ce cheque!");
											/*if(a){
												document.location.href='?id_folder='+id_folder+'&action=deletegiftprice&id='+id;
											}*/
											if(a){
												$.ajax({
													type: "GET",
													dataType:"html",
													url: "./includes/delete-object.php?object=giftprice&id_gift_price="+id,
													success: function(data){
														if(data.match('success') != null){
															giftprice.parents('tr').fadeOut(200);
															if(data.match('last') != null){
																giftprice.parents('tbody').html('<tr class="odd"><td valign="top" colspan="8" class="dataTables_empty"><?php print $lang['infoEmpty']; ?></td></tr>');
																$('button.add-prestation').hide();
															}
															showSuccess('Code promo supprimé avec succés')
														}else{
															showErrorMessage('Ops! Something went wrong')
														}
													}
												});
											}
										}
										
										
										
</script>


 												<div class="modal fade" id="ultraModal-add">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="giftprice-add" class="" action="./includes/validate-gift-price.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Ajouter </h4>
                                                            </div>
                                                            
                                                            <div id="msg-add" style="padding:15px;">
                                                            
                                                            </div>
        
                                                            <div class="modal-body perfect-scroll">
        
                                                                loading...
        
                                                            </div>
        
                                                            <div class="modal-footer">
                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                    <div class='pull-left'>
                                                                        <button class="btn btn-primary hidden">
                                                                            <i class="fa fa-paper-plane-o icon-xs"></i> &nbsp; Envoyer
                                                                        </button>
                                                                        <button type="submit" id="submit-add"  class="btn btn-purple">
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
                                                
                                                <div class="modal fade" id="ultraModal-edit">
                                                    <div class="modal-dialog" >
                                                        <div class="modal-content">
                                                        	<form id="giftprice-edit-2" class="" action="./includes/validate-gift-price.php" method="post" enctype="multipart/form-data">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Modifier </h4>
                                                            </div>
                                                            
                                                            <div id="msg-edit" style="padding:15px;">
                                                            
                                                            </div>
        
                                                            <div class="modal-body perfect-scroll">
        
                                                                loading...
        
                                                            </div>
        
                                                           
                                                            <div class="modal-footer">
                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                    <div class='pull-left'>
                                                                        <button class="btn btn-primary hidden">
                                                                            <i class="fa fa-paper-plane-o icon-xs"></i> &nbsp; Envoyer
                                                                        </button>
                                                                        <button type="submit" id="submit-edit"  class="btn btn-purple">
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
   
        