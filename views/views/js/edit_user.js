$(document).ready(function(){
	$("#edit_user_table").append("<tr> <td class='col1'> Name: </td> <td class='col2'> <input type='text' id='org_user' readonly name='user_of_name' class='form-control user_of_name' /></td></tr> <tr> <td class='col1'> Mobile No: </td> <td class='col2'> <input type='text' name='user_mob' id='user_mobile' class='form-control user_of_name' /> </td> </tr> <tr> <td class='col1'> Email Id: </td> <td class='col2'> <input type='text' class='form-control user_of_name' id='user_email' readonly name='user_email'  /> </td> </tr> <tr> <td class='col1'> Password: </td> <td class='col2'> <input type='text' class='form-control user_of_name' name='user_pass' id='user_pass' /> </td> </tr> ");
	$("#org_user").val(pass_organizer_user[0]['name']);
	$("#user_mobile").val(pass_organizer_user[0]['mobile']);
	$("#user_email").val(pass_organizer_user[0]['email']);
	// $("#user_pass").val(pass_organizer_user[0]['password']);
});