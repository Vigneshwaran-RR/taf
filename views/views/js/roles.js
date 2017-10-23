$(document).ready(function(){

	var breakMe = 0;
	$.each(pass_roles,function(key,value){
		$("#choose_Role").append("<option value="+value['role_id']+">"+value['role_name']+"</option>");
		$("#choose_Role_forPage").append("<option value="+value['role_id']+">"+value['role_name']+"</option>");
		$("#add_Role_forPage").append("<option value="+value['role_id']+">"+value['role_name']+"</option>");
		});	
	for (var i = 0; i < pass_users.length; i++) {	
		$("#select_user").append("<option value="+pass_users[i]+">"+pass_users[i]+"</option>");    
	}
	for (var i=0; i<pass_pages.length; i++) {
		
		breakMe += 1;
		$("#list_pages").append("<input type='checkbox' value="+pass_pages[i]+">&nbsp;&nbsp;"+pass_pages[i]+"&nbsp;&nbsp;");
		if(breakMe == 3)
		{
			$("#list_pages").append("<br/>");
			breakMe = 0;
		}

	}

	$('#choose_Role_forPage').on('change', function (e){	    
	    var role = $("#choose_Role_forPage option:selected").text();
	    if(role!= "Select Role")
	    {	var pass_param = {	role_selected : role
	    					 };
	    	ajaxCall("Pages/getUserPages", "POST", pass_param, "html", fillGrantedRole);
	    }
	    $('#list_pages input[type=checkbox]').each(function(){				
    		$(this).prop('checked',false);    	
		});
	});
	

	

	$("#assign").click(function(){
    	var ids = new Array(); 
		$('#list_pages input[type=checkbox]:checked').each(function(){
    		ids.push($(this).val());
		});
		if(ids.length >0)
		{
			var argmnt = {	userpages : ids,
							role_name : $("#choose_Role_forPage option:selected").text()
					  	 };
			ajaxCall("Pages/saveUserPages", "POST", argmnt, "html", updateUserPages);
		}	
	});

	$("#addpage").click(function(){
		var page_name = $("#page_name").val();
		if(page_name !="") 
		{	var arg = {		page_Name : page_name
			 		  };
			ajaxCall("Pages/addPage", "POST", arg, "html", pageAdded);
		}
		else
		{	alert("Please Type Pagename firstly");			
		}
	});

});
	function fillGrantedRole(data)
	{
		$.each(data,function(key,value)
		{
			$('#list_pages input[type=checkbox]').each(function(){				
    			if($(this).val() == value)
    			{	$(this).prop('checked',true);     				
    			}
			});
		});		
	}

	function pageAdded(data)
	{	//code...
	}

	function update_role(data)
	{	//code...
	}

	function updateUserPages(data)
	{	//alert(data.length);
	}

	