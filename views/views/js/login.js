
$(document).ready(function(){

	$("#form-signin").attr("action", landingpage);
	if(rememberme)
	{
		$("#remember").attr("checked", "checked");
		$("#username").val(rememberme);
	}

	$("#register").click(function(){
		window.location.href = "/taf/signup";
	});

	$("#username").focus(function(){
		$("#username").removeClass("error");
	});

	$("#password").focus(function(){
		$("#password").removeClass("error");
	});

	$("#signin").click(function(){

		var ret = false;

		var username = $("#username").val();
		var password = $("#password").val();

		if(username == "" && password == "")
		{			
			ret = false;
			$("#username").addClass("error");
			$("#password").addClass("error");			
		}
		else if (username == "") 
			{
				ret = false;
				$("#username").addClass("error");
			}
		else if (password == "") 
		{
			ret = false;
			$("#password").addClass("error");
		}

		if(username != "" && password != "")
		{
			if(validateUsername(username))
			{
				if(validatePassword(password))
				{									
					$("#form-signin").submit();
					ret = true;					
				}
				else
				{	
					ret = false;
					$("#password").addClass("error");					
				}
			}
			else
			{
				ret = false;
				$("#username").addClass("error");				
			}
		}	

		return ret;
	});

});

function showDiv()
{	
	$("#displayError").show("fast");
}

function hideDiv()
{	
	$("#displayError").hide("slow");
}

function validateUsername(username)
{
	var ret = false;
	if(username.match(/^[a-zA-Z]+$/))
	{
		ret = true;
	}
	return ret;
}

function validatePassword(password)
{
	var ret = false;
	if(password.match(/^[0-9a-zA-Z]+$/))
	{
		ret = true;
	}
	return ret;
}
