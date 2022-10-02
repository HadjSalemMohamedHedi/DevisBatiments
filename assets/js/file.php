 <script type="text/javascript">
 
 function shareDocument(id_document,id_folder){
													
													jQuery('#ultraModal-share-document').modal('show', {backdrop: 'static'});
													 jQuery.ajax({
                                                        url: "document-share.php?id_folder="+id_folder+"&id_document="+id_document,
                                                        success: function(response)
                                                        {
                                                            jQuery('#ultraModal-share-document .modal-body').html(response);
														}
													 });
													
												}
 
 function EditFile(id,id_folder)
                                                {
                                                    jQuery('#edit-file').modal('show', {backdrop: 'static'});

                                                    jQuery.ajax({
                                                        url: "includes/file-edit.php?id_document="+id+"&id_folder="+id_folder,
                                                        success: function(response)
                                                        {
                                                            jQuery('#edit-file .modal-body').html(response);
															
															$('input[type="checkbox"]').iCheck({
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
 
$(document).ready(function() {
	if ($.isFunction($.fn.validate)) {
		
		/*file edit*/
		
		
		$('#file-modal').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                 description: {
                    required: false
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
				
				var action = $('#file-modal').attr('action');

				$('#submit-file-edit')
					
		
				$.post(action, $('#file-modal').serialize(),
					function(data){
						$('#msg-edit-file').html( data );
						$('#msg-edit-file').slideDown();
						
						$('#file-modal #submit-edit').removeAttr('disabled');
						if(data.match('success') != null){
							
							
							
							window.setTimeout(function () {
								
								$('#file-modal').modal('hide');
								$('#msg-edit-file').hide();
								
								var id = $('#folder').val();
								
								if($.isNumeric(id)){
									
									window.location.href = "folder-detail.php?id_folder="+ id +"&tab=doc";
								}else{
									window.location.href = "file-manager.php";
								}
							}, 1000);
							
						}
					}
				);
		
				return false;

            }
        });
		<!--partage client-->
		$('#document-share').validate({
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
				
				var action = $('#document-share').attr('action');

				$('#submit-share-document')
					
		
				$.post(action, $('#document-share').serialize(),
					function(data){
						$('#msg-share-document').html( data );
						$('#msg-share-document').slideDown();
						
						$('#ultraModal-share-document #submit-share-document').removeAttr('disabled');
						if(data.match('danger') != null){
							
							
							
						}else if(data.match('success') != null){
							$('#ultraModal-share-document').modal('hide');
							$('#msg-share-document').hide();
							
							window.setTimeout(function () {
								
								
								
								
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
		
		<!---->
		
		}
												});
									
</script>

<div class="modal" id="edit-file" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Modifier</h4>
                    </div>
                    	<form id="file-modal" method="post" action="includes/validate-file.php">
                        	<div id="msg-edit-file" style="padding:15px;"></div>
                            <div class="modal-body" style="overflow-y:auto; max-height:600px;">
                            			
                                            
                            
                        	</div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" type="button">Fermer</button>
                                <button id="submit-file-edit" class="btn btn-success" type="submit" name="share">Modifier</button>
                            </div>
                    	</form>
                </div>
            </div>
        </div>
        
        <div class="modal" id="share" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog animated bounceInDown">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Partage</h4>
                    </div>
                    	<form id="share-modal" method="post" action="includes/share.php">
                        <div id="msg-share" style="padding:15px;"></div>
                            <div class="modal-body" style="overflow-y:auto; max-height:600px; margin:20px;">
                            			
                                            
                            
                        	</div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" type="button">Fermer</button>
                                <button class="btn btn-success" type="submit" name="share">Partager</button>
                            </div>
                    </form>
                </div>
            </div>
         </div>
         
         
         <div class="modal fade" id="ultraModal-share-document">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        	<form id="document-share" class="" action="./includes/validate-document.php" method="post">
                                                            
        
                                                            
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title">Partage client</h4>
                                                            </div>
                                                            
                                                            <div id="msg-share-document" style="padding:15px; display:none;">
                                                            
                                                            </div>
        
                                                            <div class="modal-body">
        
                                                                loading...
        
                                                            </div>
        
                                                            <div class="modal-footer">
                                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                                    <div class='pull-left'>
                                                                        <button class="btn btn-primary hidden">
                                                                            <i class="fa fa-paper-plane-o icon-xs"></i> &nbsp; Envoyer
                                                                        </button>
                                                                        <button type="submit" id="submit-share-document"  class="btn btn-purple">
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