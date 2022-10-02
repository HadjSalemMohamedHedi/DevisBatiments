<div class="modal fade" id="ultraModal-add">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="prestation-add" class="" action="./includes/validate-prestation.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Ajouter une prestation</h4>
                                                            </div>
                                                            
                                                            <div id="msg-add" style="padding:15px;">
                                                            
                                                            </div>
        
                                                            <div class="modal-body" style="overflow-y:auto; max-height:600px;">
        
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
        <!--edit-->
        <div class="modal fade" id="ultraModal-edit">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="prestation-edit" class="" action="./includes/validate-prestation.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Modifier prestation</h4>
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
                                                <!---->
                                                

        
        <!-- modal end -->
    </body>
</html>
<script type="text/javascript">

var responsiveHelper = undefined;
                var breakpointDefinition = {
                    tablet: 1024,
                    phone: 480
                };
                var tableElement = $('#dataprestation');

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
				

</script>


<script type="text/javascript">

		
            $("#id_folder").select2({
																placeholder: 'Choisissez',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
	  
	    
        
												function delItem(id){

												var a = confirm("Voulez-vous vraiment placer cette prestation dans la Corbeille?");
													if(a){
													document.location.href='?action=delete&id='+id;
													}
												
												}
												
												function delTrash(id){

												var a = confirm("Voulez-vous vraiment supprimer définitivement cette prestation ?");
													if(a){
													document.location.href='?trash=true&action=deletetrash&id='+id;
													}
												
												}
												
												 $("#type_prestation").select2({
																placeholder: 'Choisissez',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});

												
                                                function Editprestation(id)
                                                {
                                                    jQuery('#ultraModal-edit').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
                                                        url: "prestation-edit.php?id_prestation="+id,
                                                        success: function(response)

                                                        {
                                                            jQuery('#ultraModal-edit .modal-body').html(response);
															 $('#time2').timepicker({ 
															 showMeridian: false
															 });	
															
															
															  $('#date-prestation2').datepicker({
															 format: "dd-mm-yyyy",
															 icons: {
															  time: "fa fa-clock-o",
															  date: "fa fa-calendar",
															  up: "fa fa-arrow-up",
															  down: "fa fa-arrow-down"
																}
													 		 });
															  $("#date-prestation2").on("dp.show",function (e) {
																var newtop = $('.bootstrap-datetimepicker-widget').position().top - 45;      
																$('.bootstrap-datetimepicker-widget').css('top', newtop + 'px');
															  });
															<!--multiple folder-->
															 $("#id_folder_edit").select2({
																placeholder: 'Choisissez',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
															<!---->
															 $("#id_type_prestation2").select2({
																placeholder: 'Choisissez',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
															
															
															
                                                        }
                                                    });
                                                }
												
												 function Addprestation()
                                                {
                                                    jQuery('#ultraModal-add').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
                                                        url: "prestation-add.php",
                                                        success: function(response)
                                                        {
                                                            jQuery('#ultraModal-add .modal-body').html(response);
															
															 $('#time').timepicker({ 
															 showMeridian: false,
															  defaultTime:'00:00',
															 });	
															
															
															  $('#date-prestation').datepicker({
																  lunguage: "fr",
															 format: "dd-mm-yyyy",
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
																													

																 
															<!--multiple folder-->
															 $("#id_folder_add").select2({
																placeholder: 'Choisissez',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
															<!---->
															 $("#id_type_prestation").select2({
																placeholder: 'Choisissez',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
															
                                                        }
                                                    });
                                                }
												
												
$(document).ready(function() {
	
	$.validator.addMethod("time", function(value, element) {  
return this.optional(element) || /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/i.test(value);  
}, "Durée valide.");
		
		$('#prestation-add').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                id_type_prestation: {
                    required: true
                },
				id_folder: {
                    required: true
                },hour: {
					required: true,
                    
                },minute: {
					required: true,
                    
                },date: {
                    required: true
                },price_hour: {
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
				
				var action = $('#prestation-add').attr('action');

				$('#submit-add')
					
		
				$.post(action, $('#prestation-add').serialize(),
					function(data){
						$('#ultraModal-add #msg-add').html( data );
						$('#ultraModal-add #msg-add').slideDown();
						
						$('#prestation-add #submit-add').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#ultraModal-add').modal('hide');
							$('#msg-add').hide();
							window.setTimeout(function () {
								
								var id = $('#folder').val();
								
								if($.isNumeric(id) && id>0){
									window.location.href = "folder-detail.php?id_folder="+ id +"&tab=prestation";
								}else{
									window.location.href = "manage-prestation.php";
								}
							}, 500);
							
						}
					}
				);
		
				return false;

            }
        });
		
		$('#prestation-edit').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                  id_type_prestation: {
                    required: true
                },
				id_folder: {
                    required: true
                },hour: {
					required: true,
                    
                },minute: {
					required: true,
                    
                },date: {
                    required: true
                },price_hour: {
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
				
				var action = $('#prestation-edit').attr('action');

				$('#submit-edit')
					
		
				$.post(action, $('#prestation-edit').serialize(),
					function(data){
						$('#msg-edit').html( data );
						$('#msg-edit').slideDown();
						
						$('#prestation-add #submit-add').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#ultraModal-edit').modal('hide');
							$('#msg-edit').hide();
							
							window.setTimeout(function () {
								
								var id = $('#folder').val();
								
								if($.isNumeric(id)){
									
									window.location.href = "folder-detail.php?id_folder="+ id +"&tab=prestation";
								}else{
									window.location.href = "manage-prestation.php";
								}
							}, 500);
							
						}
					}
				);
		
				return false;

            }
        });
		
	
	 });
												
</script>