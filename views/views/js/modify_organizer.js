$(document).ready(function(){

	$("#organize_name").val(pass_organizers[0]['org_name']);
	$("#contact_person").val(pass_organizers[0]['contact_person']);
	$("#email").val(pass_organizers[0]['email']);
	$("#mobile").val(pass_organizers[0]['mobile']);
	$("#address").val(pass_organizers[0]['address']);
	$("#ac_name").val(pass_organizers[0]['account_name']);
	$("#ac_no").val(pass_organizers[0]['account_no']);
	$("#bank_name").val(pass_organizers[0]['bank']);
	$("#bank_branch").val(pass_organizers[0]['branch']);
	$("#ifsc_code").val(pass_organizers[0]['ifsc_code']);
	$("#siwift_code").val(pass_organizers[0]['siwift_code']);
	$("#desc").val(pass_organizers[0]['description'])
	
	$("#modify_organizer").click(function()
	{
		var organize_name 		= $("#organize_name").val();
		var contact_person 		= $("#contact_person").val();
		var email 				= $("#email").val();
		var mobile 				= $("#mobile").val();
		var address 			= $("#address").val();
		var ac_name 			= $("#ac_name").val();
		var ac_no 				= $("#ac_no").val();
		var bank_name 			= $("#bank_name").val();
		var bank_branch 		= $("#bank_branch").val();
		var ifsc_code 			= $("#ifsc_code").val();
		var siwift_code 		= $("#siwift_code").val();
		var desc 				= $("#desc").val();

		var arg = {
						Organize_name : organize_name,
						Contact_person : contact_person,
						Email : email,
						Mobile : mobile,
						Address : address,
						Ac_name : ac_name,
						Ac_no : ac_no,
						Bank_name : bank_name,
						Bank_branch : bank_branch,
						Ifsc_code : ifsc_code,
						Siwift_code : siwift_code,
						Desc : desc
			 	  };

			ajaxCall("Organizer/updateOrganizer", "POST", arg, "html", organizer_modified);
	});
});

function organizer_modified(data)
{
	//code here
}