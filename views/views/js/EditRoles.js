$(document).ready(function(){
	$.each(pass_roles,function(key,value){
		$("#add_Role_forPage").append("<option value="+value['role_id']+">"+value['role_name']+"</option>");
	});
});