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
                var tableElement = $('#data-deal-buying');

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
										
											var deal_buying = $('.deal_buying-'+id);
									
											var a = confirm("Voulez vous vraiment supprimer ce  deal !");
											
											if(a){
												
												$.ajax({
													type: "GET",
													dataType:"html",
													url: "./includes/delete-object.php?object=deal_buying&id_deal_buying="+id,
													success: function(data){
														
														if(data.match('success') != null){
															deal_buying.parents('tr').fadeOut(200);
															if(data.match('last') != null){
																deal_buying.parents('tbody').html('<tr class="odd"><td valign="top" colspan="11" class="dataTables_empty"><?php print $lang['infoEmpty']; ?></td></tr>');
																$('button.add-prestation').hide();
															}
															showSuccess('Objet supprimé avec succés');
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
                                                        url: "deal-buying-transform.php?id_deal_buying="+id,
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
		</script>
        
         
        <!--edit-->
        
             <!--Valider cheque-->                                   
        <div class="modal" id="ultraModal-transform" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
                                                    <div class="modal-dialog animated bounceInDown">
                                                        <div class="modal-content">
                                                        	<form id="deal_buying-transform" class="" action="./includes/validate-deal-buying.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Transformer Deal</h4>
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
		
		

	<!--transform-->

	$('#deal_buying-transform').validate({
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
				
				var action = $('#deal_buying-transform').attr('action');

				$('#submit-transform')
					
		
				$.post(action, $('#deal_buying-transform').serialize(),
					function(data){
						$('#msg-transform').html( data );
						$('#msg-transform').slideDown();
						
						$('#deal_buying-transform #submit-transform').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#ultraModal-transform').modal('hide');
							$('#msg-transform').hide();
							
							window.setTimeout(function () {
								
								window.location.href = "manage-deal.php";
								
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
     
        
       