$(document).ready(function(){
	$("#addRole").click(function(){
		var role_R = $("#newRole").val();
		if(role_R != "")
		{
			var pass_arg = {	add_Roles : role_R
						   };
			ajaxCall("Role/addRole", "POST", pass_arg, "html", addedRoles);
		}
		
	});
});

function addedRoles()
{	//Code...
}
