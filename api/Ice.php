<?php

class Ice
{
	protected $dbh;
	function __construct()
	{
		$this->dbh = new DBH();
		if(!$this->dbh->getConnection())
			throw new Exception("Unable to connect to DB");
	}
	
	function save(
						$P_Fullname = "", 
						$P_Phoneno = "", 
						$P_Address = "", 
						$IC1_Fullname = "",
						$IC1_Phoneno = "",
						$IC1_Address = "",
						$IC2_Fullname = "",
						$IC2_Phoneno = "",
						$IC2_Address = "",
						$M_Bloodgroup = "",
						$M_Allergies = "",
						$M_MedHistory = "",
						$D_Fullname = "",
						$D_Phoneno = "",
						$D_Address = "",
						$D_AffHospital = "",
						$username = ""
				)
	{
		if($P_Fullname == '') $P_Fullname = $_REQUEST['P_Fullname'];
		if($P_Phoneno == '') $P_Phoneno = $_REQUEST['P_Phoneno'];
		if($P_Address == '') $P_Address = $_REQUEST['P_Address'];
		if($IC1_Fullname == '') $IC1_Fullname = $_REQUEST['IC1_Fullname'];
		if($IC1_Phoneno == '') $IC1_Phoneno = $_REQUEST['IC1_Phoneno'];
		if($IC1_Address == '') $IC1_Address = $_REQUEST['IC1_Address'];
		if($IC2_Fullname == '') $IC2_Fullname = $_REQUEST['IC2_Fullname'];
		if($IC2_Phoneno == '') $IC2_Phoneno = $_REQUEST['IC2_Phoneno'];
		if($IC2_Address == '') $IC2_Address = $_REQUEST['IC2_Address'];
		if($M_Bloodgroup == '') $M_Bloodgroup = $_REQUEST['M_Bloodgroup'];
		if($M_Allergies == '') $M_Allergies = $_REQUEST['M_Allergies'];
		if($M_MedHistory == '') $M_MedHistory = $_REQUEST['M_MedHistory'];
		if($D_Fullname == '') $D_Fullname = $_REQUEST['D_Fullname'];
		if($D_Phoneno == '') $D_Phoneno = $_REQUEST['D_Phoneno'];
		if($D_Address == '') $D_Address = $_REQUEST['D_Address'];
		if($D_AffHospital == '') $D_AffHospital = $_REQUEST['D_AffHospital'];
		if($username == '') $username = $_SESSION['username'];

		$ret = Array();
		// Dont forget the status type and message
		$ret['status'] = Array();
		$ret['status']['type'] = "Success";
		$ret['status']['message'] = "Details Saved Successfully";
		$ret['debug']['input'] = Array();
		$ret['debug']['input']['P_Fullname'] = $P_Fullname;
		$ret['debug']['input']['P_Phoneno'] = $P_Phoneno;
		$ret['debug']['input']['P_Address'] = $P_Address;
		$ret['debug']['input']['IC1_Fullname'] = $IC1_Fullname;
		$ret['debug']['input']['IC1_Phoneno'] = $IC1_Phoneno;
		$ret['debug']['input']['IC1_Address'] = $IC1_Address;
		$ret['debug']['input']['IC2_Fullname'] = $IC2_Fullname;
		$ret['debug']['input']['IC2_Phoneno'] = $IC2_Phoneno;
		$ret['debug']['input']['IC2_Address'] = $IC2_Address;
		$ret['debug']['input']['M_Bloodgroup'] = $M_Bloodgroup;
		$ret['debug']['input']['M_Allergies'] = $M_Allergies;
		$ret['debug']['input']['M_MedHistory'] = $M_MedHistory;
		$ret['debug']['input']['D_Fullname'] = $D_Fullname;
		$ret['debug']['input']['D_Phoneno'] = $D_Phoneno;
		$ret['debug']['input']['D_Address'] = $D_Address;
		$ret['debug']['input']['D_AffHospital'] = $D_AffHospital;
		$ret['debug']['input']['username'] = $username;

		try
		{	
			// check if the  username already exists
			$sql = "select * from taf_ice where username = '$username'";
			$sqlret = $this->dbh->execQuery($sql);
			if(count($sqlret) > 0)
			{
				// update the record
				// throw new Exception("This Username is already in use.");
			}
			// insert new user details in the db
			$sql = "insert into taf_ice(P_fullname, P_phoneno, P_address, IC1_name, IC1_phoneno, IC1_address, IC2_name, IC2_phoneno, IC2_address, M_bloodgroup, M_allergies, M_medicalhistory, D_name, D_phoneno, D_address, D_affiliatedhospital, username)
					values('$P_Fullname', '$P_Phoneno', '$P_Address', '$IC1_Fullname', '$IC1_Phoneno', '$IC1_Address', '$IC2_Fullname', '$IC2_Phoneno', '$IC2_Address', '$M_Bloodgroup', '$M_Allergies', '$M_MedHistory', '$D_Fullname', '$D_Phoneno',  '$D_Address', '$D_AffHospital', '$username')";
			$sqlret = $this->dbh->execUpdateQuery($sql);
		}
		catch(Exception $e)
		{
			$ret['status']['type'] = "Error";
			$ret['status']['message'] = "Caught Exception: " . $e->getMessage();
		}
		return $ret;

	}

	function getIce($RegisteredUser = "")
	{
		if($RegisteredUser == '' && isset($_REQUEST['username'])) $RegisteredUser = $_REQUEST['username'];
		if($RegisteredUser == '' && isset($_SESSION['username'])) $RegisteredUser = $_SESSION['username'];

		$ret = Array();
		// Dont forget the status type and message
		$ret['status'] = Array();
		$ret['status']['type'] = "Success";
		$ret['status']['message'] = "Displaying User Details Successfully";
		$ret['debug']['input'] = Array();
		$ret['debug']['input']['user'] = $RegisteredUser;

		try 
		{				
			// get user detils from db table "mypage"
			$sql = "select * from taf_ice where username = '$RegisteredUser' ";
			$rows = $this->dbh->execQuery($sql);			
			if(count($rows) <= 0)
			{
				// Not an exception grade issue. Maybe this is a new user
				$ret['status']['type'] = "NOMSG";
				$ret['status']['message'] = "New User";
				return $ret;
			}
			
			$info = $rows[0];
			$ret['ice'] = Array();
		 	$ret['ice']['P_Fullname'] = $info['P_fullname'];
		 	$ret['ice']['P_phonenumber'] = $info["P_phoneno"];
		 	$ret['ice']['P_address'] = $info["P_address"];
		 	$ret['ice']["IC1_name"] = $info["IC1_name"];
		 	$ret['ice']["IC1_phonenumber"] = $info["IC1_phoneno"];
		 	$ret['ice']["IC1_address"] = $info["IC1_address"];
		 	$ret['ice']["IC2_name"] = $info["IC2_name"];
		 	$ret['ice']["IC2_phonenumber"] = $info["IC2_phoneno"];
		 	$ret['ice']["IC2_address"] = $info["IC2_address"];
		 	$ret['ice']["M_BloodGroup"] = $info["M_bloodgroup"];
		 	$ret['ice']["M_Allergies"] = $info["M_allergies"];
		 	$ret['ice']["MedicalHistory"] = $info["M_medicalhistory"];
		 	$ret['ice']["DoctorName"] = $info["D_name"];
		 	$ret['ice']["DoctorPhone"] = $info["D_phoneno"];
		 	$ret['ice']["DoctorAddress"] = $info["D_address"];
		 	$ret['ice']["AffiliatedHospital"] = $info["D_affiliatedhospital"];				
		 	// $ret['ice']['P_FullICE'] = $info['P_fullname'] . $info["P_phoneno"] . $info["P_address"] . $info["IC1_name"] . $info["IC1_phoneno"] . $info["IC1_address"] . $info["IC2_name"] . $info["IC2_phoneno"] . $info["IC2_address"] . $info["M_bloodgroup"] . $info["M_allergies"] . $info["M_medicalhistory"] . $info["D_name"] . $info["D_phoneno"] . $info["D_address"] . $info["D_affiliatedhospital"];
		 	$ret['ice']['iceurl'] = "$RegisteredUser";

			$ret['status']['type'] = "NOMSG";


		}
		catch(Exception $e)
		{
			$ret['status']['type'] = "Error";
			$ret['status']['message'] = "Caught Exception: " . $e->getMessage();
		}
		return $ret;
	}
}
?>

