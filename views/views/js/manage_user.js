$(document).ready(function(){

	$(".add_user_table").append("<tr> <th class='col1'>User Name</th> <th class='col2'> Mobile Number </th> <th class='col3'> Email </th> <th class='col4'> Options </th></tr>");
	$.each(pass_organizers,function(key,value){
		$(".add_user_table").append("<tr><td class='col1'>"+value['name']+"</td> <td class='col2'>"+value['mobile']+"</td> <td class='col3'>"+value['email']+"</td> <td class='col4'><a href='' class='org_user_edit' id="+value['email']+"> Edit </a> | <a href='' class='org_user_send_pwd'> Send Password </a> | <a href='' class='org_user_delete' id="+value['email']+"> Delete </a></td></tr> ");		
	});

	$(".org_user_edit").click(function(){
		var qryStrng 	= this.id;		
		var path 		= pathToEditUser+"?id="+qryStrng;
		$(this).attr('href',path);
	});

	$(".org_user_send_pwd").click(function(){
		$(this).attr('href',pathToEditSendPasswd);
	});

	$(".org_user_delete").click(function(){

		alert("Do you really want to delete this User from your Organization") ;
		var email 		= this.id;
		var arg 		= {		
							Email : email						
			 	  		  };
		ajaxCall("User/deleteOrganizerUserByEmail", "POST", arg, "html", orgUserDeleted);	
	});

	$("#create_user").click(function(){
		
		var pass_arg =  {
							username 	: $("#org_user_name").val(),
							mobile   	: $("#org_user_mob").val(),
							email   	: $("#org_user_email").val(),
							password   	: $("#org_user_pass").val(),
							org_id 		: organizer_id
						};
		if($("#org_user_name").val() !="" && $("#org_user_pass").val() !="")
		{
			ajaxCall("User/createOrganizerUser", "POST", pass_arg, "html", orgUserAdded);
		}		
	});
	
});

function orgUserDeleted()
{

}
function orgUserAdded()
{

}