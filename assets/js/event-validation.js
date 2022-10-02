$(document).ready(function() {


    if ($.isFunction($.fn.validate)) {
		
		$('#event-add').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                id_responsible: {
                    required: true
                },
				id_commercial: {
                    required: true
                },
				postcode: {
                    required: true
                },
				start: {
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
										window.location.href = "agenda.php";
							}, 1500);
							
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
                id_responsible: {
                    required: true
                },
				id_commercial: {
                    required: true
                },
				postcode: {
                    required: true
                },
				start: {
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
								
								window.location.href = "agenda.php";
								
							}, 1500);
							
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


    }


});
