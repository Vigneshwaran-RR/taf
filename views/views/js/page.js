$(document).ready(function(){

$("#addpage").click(function(){
		var page_name = $("#page_name").val();
		if(page_name !="") 
		{	var arg = {		page_Name : page_name
			 		  };
			ajaxCall("Pages/addPage", "POST", arg, "html", pageAdded);
			$("#page_name").val("");
		}
		else
		{	alert("Please Type Pagename firstly");			
		}
	});
});

function pageAdded(data)
	{	//code...
	}