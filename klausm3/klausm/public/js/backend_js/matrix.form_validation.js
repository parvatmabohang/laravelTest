
$(document).ready(function(){
	$("#new_pwd").click(function(){
           var current_pwd = $("#current_pwd").val();
           $.ajax({
              type: 'get',
               url: '/admin/check-pwd',
               data: {current_pwd:current_pwd},
               success:function(resp){
                 if(resp == "false") {
                    $("#chkPwd").html("<font color='red'>Current Password is Incorrect</font>");
                  } else {
                   $("#chkPwd").html("<font color='green'>Current Password is Correct</font>");
                   }
               },error:function(){
                  alert("Error");
                }   
           });
         });


	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	
	$('select').select2();
	
	// Form Validation
   $("#add_category").validate({
		rules:{
			required:{
				required:true
			},
			category_name:{
				required:true
				
			},
			description:{
				required:true
				
			},
			url:{
				required:true
				
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
  $("#add_product").validate({
		rules:{
			category_id:{
				required:true
				
			},
			product_name:{
				required:true
				
			},
                        product_code:{
				required:true
				
			},
			product_color:{
				required:true
				
			},
                       product_price:{
                                 required:true,
                                 number:true		
                       },
                       image:{
                                 required:true		
                       }
                  },
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
      $("#edit_product").validate({
		rules:{
			category_id:{
				required:true
				
			},
			product_name:{
				required:true
				
			},
                        product_code:{
				required:true
				
			},
			product_color:{
				required:true
				
			},
                       product_price:{
                                 required:true,
                                 number:true		
                       }
                  },
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
    $("#basic_validate").validate({
		rules:{
			required:{
				required:true
			},
			email:{
				required:true,
				email: true
			},
			date:{
				required:true,
				date: true
			},
			url:{
				required:true,
				url: true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	
	$("#number_validate").validate({
		rules:{
			min:{
				required: true,
				min:10
			},
			max:{
				required:true,
				max:24
			},
			number:{
				required:true,
				number:true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	
	$("#password_validate").validate({
		rules:{
			new_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
                        current_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			confirm_pwd:{
				required:true,
				minlength:6,
				maxlength:20,
				equalTo:"#new_pwd"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
        $(document).ready(function(){
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = '<div class="field_wrapper" style="margin-left:180px;margin-top:5px;"> <input type="text" name="sku[]" id="sku" placeholder="SKU" style="width:120px;" required/> <input type="text" name="size[]" id="size" placeholder="Size" style="width:120px;" required/> <input type="number" name="price[]" id="price" placeholder="Price" style="width:120px;" required/> <input type="number" name="stock[]" id="stock" placeholder="Stock" style="width:120px;" required/><a href="javascript:void(0);" class="remove_button"        title="Remove field">Remove</a></div>'; //New input field html 
            var x = 1; //Initial field counter is 1
            $(addButton).click(function(){ //Once add button is clicked
                if(x < maxField){ //Check maximum number of input fields
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); // Add field html
                }
            });
            $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
              e.preventDefault();
              $(this).parent('div').remove(); //Remove field html
              x--; //Decrement field counter
    });
});
});