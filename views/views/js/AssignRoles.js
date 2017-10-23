$(document).ready(function(){
	$.each(pass_roles,function(key,value){
		$("#choose_Role").append("<option value="+value['role_id']+">"+value['role_name']+"</option>");		
	});
	for (var i = 0; i < pass_users.length; i++) {	
		$("#select_user").append("<option value="+pass_users[i]+">"+pass_users[i]+"</option>");    
	}
	$("#update").click(function(){
		if($("#choose_Role option:selected").text() != "")
		{
			var param = {	display_Name : $("#select_user option:selected").text(),
							role_Name : $("#choose_Role option:selected").text()
						};
			ajaxCall("Role/updateRole", "POST", param, "html", update_role);
		}
		else{	alert("Please choose Role");
			}
	});
});
function update_role()
{
	//Code...
}