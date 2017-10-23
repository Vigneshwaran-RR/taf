$(document).ready(function(){

	$("#firstname").focus();

	$("#lastname").focus(function(){
		if(isAlphabet($("#firstname").val()))
		{	$(this).focus();
		}
		else
		{	$("#firstname").focus();
		}
	});

	$("#phoneno").focus(function(){
		if(isAlphabet($("#lastname").val()))
		{	$(this).focus();
		}
		else
		{	$("#lastname").focus();
		}
	});

	$("#email").focus(function(){
		if(isNumeric($("#phoneno").val()))
		{	$(this).focus();
		}
		else
		{	$("#phoneno").focus();
		}
	});

});

function isAlphabet(data)
{	if(data.match(/^[a-zA-Z]+$/))
	{	return true;
	}
	else
	{	return false;
	}
}

function isAlphaNumeric(data)
{	if(data.match(/^[a-zA-Z0-9 ]+$/))
	{	return true;
	}
	else
	{	return false;
	}
}

function isNumeric(data)
{	if(data.match(/^[0-9]+$/))
	{	return true;
	}
	else
	{	return false;
	}
}