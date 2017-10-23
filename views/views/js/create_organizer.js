$(document).ready(function(){
	
	$("#create_organizer").click(function()
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

		//var fields = Array(organize_name, contact_person, email, mobile, address, ac_name, ac_no, bank_name, bank_branch, ifsc_code, siwift_code, desc);
		
		var arg = {		Organize_name : organize_name,
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

			ajaxCall("Organizer/createOrganizer", "POST", arg, "html", organizer_Added);			
			//clear all the text boxes		

	});	
});

function organizer_Added(data)
{

}

