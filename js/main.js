
$(document).ready(function(){

// validate email
	function verify_email(email){
		$(".e_error").hide(); // hide the error until it returns result . email error
		if (email == ""){
			$(".e_error").show();
			$(".e_error").html("Please enter your Email Address");
			$(".e_error").addClass("wrong"); // just added a class to change the text color and defined the class in my css (.wrong)
		} else {
			$.ajax({
			url : "action.php",
			method : "POST",
			data : {check_email:1,email:email},
			success : function(data){
				// alert(data);
				$(".e_error").show();
				//console.log(data);
				if (data == "already_exists"){
					$(".e_error").html("Email Already Exists");
				} else if (data == "invalid_email"){
					$(".e_error").html("Invalid Email Address");
				} else if (data == "ok"){
					$(".e_error").html("ok");
				}
			}
		})

		}
		
	}
	//when you leave from the email input, this verify email function when trigger
	$("#u_email").focusout(function(){
		var email = $("#u_email").val();
		verify_email(email);
	})




		// TO Register User

		$("#register_form").on("submit",function(){
			$.ajax({
				url : "action.php",
				method : "POST",
				data : $("#register_form").serialize(),
				success : function(data){
					//alert(data);
					if (data == "empty_fields"){
						alert("Please fill all fields");
					}
					// it's not supposed to throw this . check the action.php . i commented mail() just to use this
					if (data == "email_send_success"){
						window.location.href = "verify_email.php";
					}
				}
			})
		})



			// To login 

		$("#login_form").on("submit",function(){
			var log_email = $("#log_email").val();
			var log_password = $("#log_password").val();
			if (log_email == "" || log_password == ""){
				alert("Please enter email or password");
			} else {
				$("#login").html("Loading..."); // we just targeted any id that is convenient for us and did this because it will take time to get the data from server. so it will just be showing loading until it finishes getting data
				$.ajax({
					url : "action.php",
					method : "POST",
					data : $("#login_form").serialize(),
					success : function(data){
						alert(data);
						if (data == "login_success"){
							window.location.href = "profile.php";
						}
					}
				})
			}
		});





});






