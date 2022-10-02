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
<!---->
<?php if(isset($_GET['id_folder'])&& is_numeric($_GET['id_folder'])){?>
									function delPrestation(id_folder,id){
									
											var a = confirm("Voulez vous vraiment supprimer cette prestation !");
											if(a){
												document.location.href='?id_folder='+id_folder+'&action=deleteprestation&id='+id;
											}
										}
										<?php }?>
		var count = 0;
		   
					$('#dataprestation tr input.prestation').each(function() {
						
						if($(this).prop('checked')){
							count ++;
						}
						
					 });
					
					//alert(count);
					if(count==0){
						$('button.add-invoice').hide();
					}else{
						$('button.add-invoice').show();
					}
					<!---->
   			
			  $('.prestation').on('ifChanged', function(event){
				
					var count = 0;
		   
					$('#dataprestation tr input.prestation').each(function() {
						
						if($(this).prop('checked')){
							count ++;
						}
						
					 });
					
					//alert(count);
					if(count==0){
						$('button.add-invoice').hide();
					}else{
						$('button.add-invoice').show();
					}
						
				}).iCheck({
					checkboxClass: 'icheckbox_minimal',
					radioClass: 'iradio_minimal',
					increaseArea: '20%'
			});
			
			
			<!---->
												function sharePrestation(id_prestation,id_folder){
													
													jQuery('#ultraModal-share-prestation').modal('show', {backdrop: 'static'});
													 jQuery.ajax({
                                                        url: "prestation-share.php?id_folder="+id_folder+"&id_prestation="+id_prestation,
                                                        success: function(response)
                                                        {
                                                            jQuery('#ultraModal-share-prestation .modal-body').html(response);
															var notif_widget = $(".test-widget").height();
																$('.test-widget').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
																});
														}
													 });
													
												}
												<!---->
			
			
			function Editprestation(id)
                                                {
                                                    jQuery('#ultraModal-edit').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
                                                        url: "prestation-edit.php?id_folder=<?php echo $_GET['id_folder']; ?>&id_prestation="+id,
                                                        success: function(response)

                                                        {
                                                            jQuery('#ultraModal-edit .modal-body').html(response);
															
															var notif_widget = $(".test-widget").height();
																$('.test-widget').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
																});
															 $('#time2').timepicker({ 
															 showMeridian: false
															 });	
															
															
															  $('#date-prestation2').datepicker({
															 format: "<?php echo $lang_default['date_format_js']; ?>",
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
															  <!---->
															 $("#id_type_prestation2").select2({
																placeholder: 'Choisissez',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
															<!--multiple folder-->
															 $("#id_folder_edit").select2({
																placeholder: 'Choisissez',
																allowClear: true
															}).on('select2-open', function() {
																// Adding Custom Scrollbar
																$(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
															});
															
															
															
															
                                                        }
                                                    });
                                                }
												
												<!---->
												
													

                                                     function Addprestation2(id_folder)
                                                {
                                                    jQuery('#ultraModal-add').modal('show', {backdrop: 'static'});
													
													
													var emails = [];
													
												
														 $("input[name^='email']").each(function () {
														 
															if($(this).prop('checked')){
															 emails.push($(this).val());
															}
													    
														});

                                                    jQuery.ajax({
														type: "POST",
                                                        url: "prestation-add.php?id_folder="+id_folder,
														data: {
															id_folder: id_folder,
																emails: emails															
														},
														 success: function(response)
                                                        {
                                                            jQuery('#ultraModal-add .modal-body').html(response);
															
															var notif_widget = $(".test-widget").height();
																$('.test-widget').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
																});
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
                                                }
												<!---->
												 function Addprestation(id_folder)
                                                {
                                                    jQuery('#ultraModal-add').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
                                                        url: "prestation-add.php?id_folder="+id_folder,
                                                        success: function(response)
                                                        {
                                                            jQuery('#ultraModal-add .modal-body').html(response);
															
															var notif_widget = $(".test-widget").height();
																$('.test-widget').height(notif_widget).perfectScrollbar({
																	suppressScrollX: true
																});
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
                                                }
												
												<!--validation-->
$(document).ready(function() {


    if ($.isFunction($.fn.validate)) {
												<!--add prestation-->
		
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
						$('#msg-add-prestation').html( data );
						$('#msg-add-prestation').slideDown();
						
						$('#prestation-add #submit-add').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#ultraModal-add').modal('hide');
							$('#msg-add-prestation').hide();
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

		
		<!--end add prestation-->
		$('#prestation-edit').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                 id_type_prestation: {
                    required: true
                },
				id_folder: {
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

		
		<!--end edit prestation-->
		
		<!---->
		$('#prestation-share').validate({
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
				
				var action = $('#prestation-share').attr('action');

				$('#submit-share-prestation')
					
		
				$.post(action, $('#prestation-share').serialize(),
					function(data){
						$('#msg-share-prestation').html( data );
						$('#msg-share-prestation').slideDown();
						
						$('#ultraModal-share-prestation #submit-share-prestation').removeAttr('disabled');
						if(data.match('danger') != null){
							
							
							
						}else if(data.match('success') != null){
							$('#ultraModal-share-prestation').modal('hide');
							$('#msg-share-prestation').hide();
							
							window.setTimeout(function () {
								
								var id = $('#id_folder').val();
								
								
								showSuccess('Prestation partagé avec succés');
								
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
        
                                                            <div class="modal-body test-widget">
        
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




		<div class="modal fade" id="ultraModal-add">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="prestation-add" class="" action="./includes/validate-prestation.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Ajouter une prestation</h4>
                                                            </div>
                                                            
                                                            <div id="msg-add-prestation" style="padding:15px;">
                                                           
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

<div class="modal fade" id="ultraModal-share-prestation">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="prestation-share" class="" action="./includes/validate-prestation.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Partage client</h4>
                                                            </div>
                                                            
                                                            <div id="msg-share-prestation" style="padding:15px; display:none;">
                                                            
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
                                                                        <button type="submit" id="submit-share-prestation"  class="btn btn-purple">
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