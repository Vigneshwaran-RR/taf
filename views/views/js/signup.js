$(document).ready(function(){
	
//$("#main").find("input","password").css({"border-color":"white"});
//$("#main").find("input","password").addClass('bordered');

	$("#register").click(function(){
		
		if(checkNotEmpty())
		{
		
			var params = {
				displayname: $("#displayname").val(),
				username: $("#username").val(),
				password: $("#password").val(),
				email: $("#email").val()
						};
				ajaxCall("User/register", "POST", params, "html", register_callback);
		}
		

			$("#displayname").focus(function(){
				$("#dispError").hide();
				$("#displayname").css('border-color','white');
			});
			$("#username").focus(function(){
				$("#userError").hide();
				$("#username").css('border-color','white');
			});
			$("#password").focus(function(){
				$("#passError").hide();
				$("#password").css('border-color','white');
			});
			$("#rpassword").focus(function(){
				$("#repassError").hide();
				$("#rpassword").css('border-color','white');
			});
			$("#email").focus(function(){
				$("#emailError").hide();
				$("#email").css('border-color','white');
			});
		
			
	});

	function register_callback(data)
	{
		if(data.status.type == "Error")
		{
			$("#successdiv").text(data.status.message);
		}
	}

	$("#cancel").click(function(){
		window.location.href = "home";
	});

	function checkNotEmpty()
	{
		var ret = false;
		var displayname = $("#displayname").val();
		var username = $("#username").val();
		var password = $("#password").val();
		var rpassword = $("#rpassword").val();
		var email = $("#email").val();
		var count = 0;
		var textAry =  Array();

		if(displayname == "")
		{			
			$("#displayname").css("border-color","#EB1052","color","red");
			$("#dispError").text("Display Name is Empty").show().css({'color' : 'red', 'font-weight' : 'bolder'});			
			count+=1;						
		}
		if(username == "") 
		{			
			$("#username").css("border-color","Red","color","red");
			$("#userError").text("UserName is Empty").show().css({'color' : 'red', 'font-weight' : 'bolder'});
			count+=1;
		}
		if(password == "")
		{			
			$("#password").css("border-color","Red","color","red");
			$("#passError").text("Password is Empty").show().css({'color' : 'red', 'font-weight' : 'bolder'});
			count+=1;
		}
		if(rpassword == "")
		{
			$("#rpassword").css("border-color","Red","color","red");
			$("#repassError").text("Confirm Password is Empty").show().css({'color' : 'red', 'font-weight' : 'bolder'});
			count+=1;
		}
		if(email == "")
		{
			$("#email").css("border-color","Red");
			$("#emailError").text("Email is Empty").show().css({'color' : 'red', 'font-weight' : 'bolder'});
			count+=1;
		}
		if(password != rpassword)
		{
			$("#rpassword").css("border-color","Red","color","red");
			$("#repassError").text("Password doesn't match").show().css({'color' : 'red', 'font-weight' : 'bolder'});
			count+=1;
		}
			if(count >0)
			{
				return ret;
			}
			else
			{
				return true;
			}
	}

});