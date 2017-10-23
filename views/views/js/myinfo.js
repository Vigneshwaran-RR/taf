$(document).ready(function(){

	var params = {
	};
	ajaxCall("Ice/getIce", "POST", params, "html", fill_form);		

	function fill_form(data)
	{
		if (data.ice)
		{
			$("#P_fullname").val(data.ice.P_Fullname);
			$("#P_phoneno").val(data.ice.P_phonenumber);
			$("#P_address").val(data.ice.P_address);

			$("#IC1_fullname").val(data.ice.IC1_name);
			$("#IC1_phoneno").val(data.ice.IC1_phonenumber);
			$("#IC1_address").val(data.ice.IC1_address);

			$("#IC2_fullname").val(data.ice.IC2_name);
			$("#IC2_phoneno").val(data.ice.IC2_phonenumber);
			$("#IC2_address").val(data.ice.IC2_address);

			$("#M_bloodgroup").val(data.ice.M_BloodGroup);
			$("#M_allergies").val(data.ice.M_Allergies);
			$("#M_medHistory").val(data.ice.MedicalHistory);

			$("#D_fullname").val(data.ice.DoctorName);
			$("#D_phoneno").val(data.ice.DoctorPhone);
			$("#D_address").val(data.ice.DoctorAddress);
			$("#D_affHospital").val(data.ice.AffiliatedHospital);

			$("#fulltext").val(data.ice.iceurl);
		}
	}


	function fieldValidations()
	{
		var validate = new Array();
		var count =0; 

		if($("#P_fullname").val() == "")
		{ 
			validate[0] = 'false';
			count+= 1;
		}
		if($("#P_phoneno").val() == "")
		{ 
			validate[1] = 'false';
			count+= 1;
		}
		if($("#P_address").val() == "")
		{ 
			validate[2] = 'false';
			count+= 1;
		}
		if($("#IC1_fullname").val() == "")
		{ 
			validate[3] = "false";
			count+= 1;
		}
		if($("#IC1_phoneno").val() == "")
		{ 
			validate[4] = "false";
			count+= 1;
		}
		if($("#IC1_address").val() == "")
		{ 
			validate[5] = "false";
			count+= 1;
		}

		if(count == 0)
		{
			return true;
		}
		else
		{
			if(validate[0] == "false" || validate[1] == "false" || validate[2] == "false")
			{
				$("#profileStatus").text("Please fill all Profile Information");
				$("#profileStatus").show();
				$("#profileStatus").fadeOut(5000);
				}
			if(validate[3] =="false" || validate[4] == "false" || validate[5] =="false")
			{
				$("#Ice1Status").text("Please fill all Details");
				$("#Ice1Status").show();
				$("#Ice1Status").fadeOut(5000);
				}
			}
	}

	$("#register").click(function(){

		if(fieldValidations())
		{

	 		var params = {
				P_Fullname: $("#P_fullname").val(),
				P_Phoneno: $("#P_phoneno").val(),
				P_Address: $("#P_address").val(),
				IC1_Fullname: $("#IC1_fullname").val(),
				IC1_Phoneno: $("#IC1_phoneno").val(),
				IC1_Address: $("#IC1_address").val(),
				IC2_Fullname: $("#IC2_fullname").val(),
				IC2_Phoneno: $("#IC2_phoneno").val(),
				IC2_Address: $("#IC2_address").val(),
				M_Bloodgroup: $("#M_bloodgroup").val(),
				M_Allergies: $("#M_allergies").val(),
				M_MedHistory: $("#M_medHistory").val(),
				D_Fullname: $("#D_fullname").val(),
				D_Phoneno: $("#D_phoneno").val(),
				D_Address: $("#D_address").val(),
				D_AffHospital: $("#D_affHospital").val()
			};

			ajaxCall("Ice/save", "POST", params, "html", register_callback);		
		}
	});

	function register_callback(data)
	{
		//alert(data);
	}

	$("#cancel").click(function(){
		window.location.href = "home";
	});	

});
