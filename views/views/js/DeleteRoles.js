$(document).ready(function(){
	$.each(pass_roles,function(key,value){
		$("#deleterole").append("<option value="+value['role_id']+">"+value['role_name']+"</option>");
	});

	$("#deletepge").click(function(){
		if($("#deleterole option:selected").text() != "Select Role")
		{
			var selected_role = $("#deleterole option:selected").text();			
			if(confirm("Are you sure want to delete the role  "+selected_role+" ?"))
			{
				var arg = {		deleteRole : selected_role
					  	  };
				ajaxCall("Role/deleteRole", "POST", arg, "html", deletedRole);
			}
		}
	});
});

function deletedRole()
{
	//Code...
}