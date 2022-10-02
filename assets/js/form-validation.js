$(document).ready(function() {


    if ($.isFunction($.fn.validate)) {
		
		<!--partage-->  
		
	    $('#share-modal').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
               email_sh : {
                   email: true
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
				
				var action = $('#share-modal').attr('action');

				$('#submit-share')
					
		
				$.post(action, $('#share-modal').serialize(),
					function(data){
						$('#msg-share').html( data );
						$('#msg-share').slideDown();
						
						$('#share-modal #submit-share').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#share').modal('hide');
							$('#msg-share').hide();
							window.setTimeout(function () {
								window.location.href = "";
							}, 1);
							
						}
					}
				);
		
				return false;

            }

            
        });    
	  <!--add folder-->
	    $('#folder-add').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                name: {
                    required: true
                },
                speciality: {
                    required: true
                },
                created: {
                     required: true
                },
				 contributor_1: {
                    required: true                   
                },
                supervisor: {
                    required: true                   
                },
				id_categorie: {
                    required: true
                },
                manager_1: {
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

            
        });

		<!---->

        $('#msg_validate').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                email: {
                    email: true
                },
              
                website: {
                    url: true
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
				
				var action = $('#msg_validate').attr('action');
				var id_client = $('#id_client').val();

				$('#submit')
					
		
				$.post(action, $('#msg_validate').serialize(),
					function(data){
						$('#message').html( data );
						$('#message').slideDown();
						
						$('#msg_validate #submit').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#ultraModal-edit').modal('hide');
							$('#message').hide();
							window.setTimeout(function () {
								window.location.href = "manage-client.php?id_client="+id_client;
							}, 1);
							
						}
					}
				);
		
				return false;

            }
        });
		
		<!--add client-->
		
		$('#client-add').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                email: {
                    email: true
                },
              
                website: {
                    url: true
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
				
				var action = $('#client-add').attr('action');

				$('#submit-add')
					
		
				$.post(action, $('#client-add').serialize(),
					function(data){
						$('#msg-add').html( data );
						$('#msg-add').slideDown();
						
						$('#client-add #submit-add').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#ultraModal-add').modal('hide');
							$('#msg-add').hide();
							window.setTimeout(function () {
								window.location.href = "manage-client.php";
							}, 1);
							
						}
					}
				);
		
				return false;

            }
        });

		
		<!--end add-->
		
		
		<!--add contact-->
		
		$('#contact-add').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                email: {
                    email: true
                },
				id_title:{
					required:true
				},
              	id_contact_type:{
					required:true
				},
                website: {
                    url: true
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
				
				var action = $('#contact-add').attr('action');

				$('#submit-add')
					
		
				$.post(action, $('#contact-add').serialize(),
					function(data){
						$('#msg-add').html( data );
						$('#msg-add').slideDown();
						
						$('#contact-add #submit-add').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#ultraModal-add').modal('hide');
							$('#msg-add').hide();
							window.setTimeout(function () {
								window.location.href = "manage-contact.php";
							}, 1);
							
						}
					}
				);
		
				return false;

            }
        });

		
		<!--end add contact-->
		
		
<!--contac edit-->
 $('#contact-edit-old').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                email: {
                    email: true
                },
              id_title:{
					required:true
				},
				id_contact_type:{
					required:true
				},
                website: {
                    url: true
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
				
				var action = $('#contact-edit').attr('action');
				var id_contact = $('#id_contact').val();

				$('#submit')
					
		
				$.post(action, $('#contact-edit').serialize(),
					function(data){
						$('#message').html( data );
						$('#message').slideDown();
						
						$('#contact-edit #submit').removeAttr('disabled');
						if(data.match('success') != null){
							
							$('#ultraModal-edit').modal('hide');
							$('#message').hide();
							window.setTimeout(function () {
								window.location.href = "manage-contact.php?id_contact="+id_contact;
							}, 1);
							
						}
					}
				);
		
				return false;

            }
        });
		
		
		<!--add contributor-add-->
		
		$('#personal-add').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                email: {
					required:true,
                    email: true
                }, password: {
                    minlength: 6,
					maxlength: 12,
                    required: true
                },cpassword: {
                    required: true,
                    equalTo: "#password"
                },id_center: {
					required:true,
                   
                }
              
                
            },

            invalidHandler: function(event, validator) {
                //display error alert on form submit    
            },

            errorPlacement: function(label, element) { // render error placement for each input type   
                console.log(label);
              
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
				
				var action = $('#personal-add').attr('action');

				$('#submit-add')
					
		
				$.post(action, $('#personal-add').serialize(),
					function(data){
						$('#msg-add').html( data );
						$('#msg-add').slideDown();
						
						$('#personal-add #submit-add').removeAttr('disabled');
						if(data.match('success') != null){
							
							
							window.setTimeout(function () {
								$('#ultraModal-add').modal('hide');
							$('#msg-add').hide();
								window.location.href = "manage-personal.php";
							}, 1500);
							
						}
					}
				);
		
				return false;

            }
        });

		
		<!--end add personal-->
		
		<!--edit personal-->
		
		$('#personal-edit').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                email: {
					required:true,
                    email: true
                }, password: {
                    minlength: 6,
					maxlength: 12
                },cpassword: {
                    equalTo: "#password"
                },id_center: {
					required:true,
                   
                }
              
                
            },

            invalidHandler: function(event, validator) {
                //display error alert on form submit    
            },

            errorPlacement: function(label, element) { // render error placement for each input type   
                console.log(label);
               
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
				
				var action = $('#personal-edit').attr('action');

				$('#submit-edit')
					
		
				$.post(action, $('#personal-edit').serialize(),
					function(data){
						$('#msg-edit').html( data );
						$('#msg-edit').slideDown();
						
						$('#personal-add #submit-add').removeAttr('disabled');
						if(data.match('success') != null){
							
							
							window.setTimeout(function () {
								$('#ultraModal-edit').modal('hide');
								$('#msg-edit').hide();
								window.location.href = "manage-personal.php";
							}, 1500);
							
						}
					}
				);
		
				return false;

            }
        });

	
		
		/* evennement 
		======================================*/
		
		
		
		<!---->
        $('#icon_validate').validate({
            errorElement: 'span',
            errorClass: 'error',
            focusInvalid: false,
            ignore: "",
            rules: {
                formfield1: {
                    minlength: 2,
                    required: true
                },
                formfield2: {
                    required: true,
                    email: true
                },
                formfield3: {
                    required: true,
                    url: true
                }
            },

            invalidHandler: function(event, validator) {
                //display error alert on form submit    
            },

            errorPlacement: function(error, element) { // render error placement for each input type
                var icon = $(element).parent().parent('.form-group').find('i');
                var parent = $(element).parent().parent('.form-group');
                icon.removeClass('fa fa-check').addClass('fa fa-times');
                parent.removeClass('has-success').addClass('has-error');
            },

            highlight: function(element) { // hightlight error inputs
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },

            unhighlight: function(element) { // revert the change done by hightlight

            },

            success: function(label, element) {
                var icon = $(element).parent().parent('.form-group').find('i');
                var parent = $(element).parent().parent('.form-group');
                icon.removeClass("fa fa-times").addClass('fa fa-check');
                parent.removeClass('has-error').addClass('has-success');
            },

            submitHandler: function(form) {

            }
        });


        $('#general_validate').validate({
            focusInvalid: false,
            ignore: "",
            rules: {
                formfield1: {
                    required: true
                },
                formfield2: {
                    required: true,
                    email: true
                },
                formfield3: {
                    required: true,
                    url: true
                },
                formfield4: {
                    required: true,
                    creditcardtypes: true
                },
                formfield5: {
                    number: true,
                    required: true,
                },
                formfield6: {
                    minlength: 3,
                    required: true,
                },
                formfield7: {
                    maxlength: 5,
                    required: true,
                },
                formfield8: {
                    maxlength: 5,
                    required: true,
                },
                formfield9: {
                    maxlength: 5,
                    required: true,
                    equalTo: "#formfield8"
                },
                formfield10: {
                    required: true,
                },
                formfield11: {
                    required: true,
                    alphanumeric: true,
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

            }
        });








        //Form Wizard Validations
        var $validator = $("#commentForm").validate({
			focusInvalid: false,
            ignore: "",
            rules: {
                id_title: {
                    required: true,
                },
				 id_country: {
                    required: true,
                },
				id_currency: {
                    required: true,
                },
				id_lang: {
                    required: true,
                },
				id_manager: {
                    required: true,
                },
				id_contact_type: {
                    required: true,
                },
                email: {
                    
                    email: true,
                }
            },
            errorPlacement: function(label, element) {
                $('<span class="arrow"></span>').insertBefore(element);
                $('<span class="error"></span>').insertAfter(element).append(label)
            }
        });


    }



    if ($.isFunction($.fn.bootstrapWizard)) {

        $('#pills').bootstrapWizard({
            'tabClass': 'nav nav-pills',
            'debug': false,
            onShow: function(tab, navigation, index) {
                console.log('onShow');
            },
            onNext: function(tab, navigation, index) {
                console.log('onNext');
                if ($.isFunction($.fn.validate)) {
                    var $valid = $("#commentForm").valid();
                    if (!$valid) {
                        $validator.focusInvalid();
                        return false;
                    } else {
                        $('#pills').find('.form-wizard').children('li').eq(index - 1).addClass('complete');
                        $('#pills').find('.form-wizard').children('li').eq(index - 1).find('.step').html('<i class="fa fa-check"></i>');
                    }
                }
            },
            onPrevious: function(tab, navigation, index) {
                console.log('onPrevious');
            },
            onLast: function(tab, navigation, index) {
                console.log('onLast');
            },
            onTabClick: function(tab, navigation, index) {
                console.log('onTabClick');
                //alert('on tab click disabled');
            },
            onTabShow: function(tab, navigation, index) {
                console.log('onTabShow');
                var $total = navigation.find('li').length;
                var $current = index + 1;
                var $percent = ($current / $total) * 100;
                $('#pills .progress-bar').css({
                    width: $percent + '%'
                });
            }
        });

        $('#pills .finish').click(function() {
            alert('Finished!, Starting over!');
            $('#pills').find("a[href*='tab1']").trigger('click');
        });







    }




});
