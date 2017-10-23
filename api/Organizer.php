<?php
require_once "classes/DBH.php";
class Organizer
{

	protected $dbh;
	function __construct()	{
		$this->dbh = new DBH();
		if(!$this->dbh->getConnection())
			throw new Exception("Unable to connect to DB");
	}

	function createOrganizer()
	{	
		$addOrganizer = array();
		$addOrganizer['status'] = array();
		$addOrganizer['status']['type'] = "Success";
		$addOrganizer['status']['message'] = "Organizer Created Successfully";

		$Organizer_Name	= $_REQUEST['Organize_name'];
		$Contact_Person	= $_REQUEST['Contact_person'];
		$Email			= $_REQUEST['Email'];
		$Mobile			= $_REQUEST['Mobile'];
		$Address		= $_REQUEST['Address'];
		$Ac_Name		= $_REQUEST['Ac_name'];
		$Ac_No			= $_REQUEST['Ac_no'];
		$Bank_Name		= $_REQUEST['Bank_name'];
		$Bank_Branch	= $_REQUEST['Bank_branch'];
		$Ifsc_Code		= $_REQUEST['Ifsc_code'];
		$Siwift_Code	= $_REQUEST['Siwift_code'];
		$Description	= $_REQUEST['Desc'];
		$date 			= $date = date('Y-m-d H:i:s');
		$sql_roles_select = "select * from organizer where account_no = $Ac_No";
		try
			{					
				$sql_res_select = $this->dbh->execQuery($sql_roles_select);
				if(count($sql_res_select))
				{					
					throw new Exception("This Account is Already Exist in Database");
				}
				else
				{
					$sql_roles_insert ="insert into organizer(org_name, contact_person, email, mobile, address, account_name, account_no, bank, branch, ifsc_code, siwift_code, description, created_by, created, status) 
										values('$Organizer_Name', '$Contact_Person', '$Email','$Mobile', '$Address', '$Ac_Name', '$Ac_No', '$Bank_Name', '$Bank_Branch', '$Ifsc_Code', '$Siwift_Code', '$Desc', ' ', '$date', 1 )";
					$sql_roles_insert = $this->dbh->execUpdateQuery($sql_roles_insert);										
				}
			}
		catch(Exception $e)
			{
				$addOrganizer['status']['type'] = "Error";
				$addOrganizer['status']['message'] = "Caught Exception: " . $e->getMessage();
			}
		return $addOrganizer;
	}

	function getAllOrganizers()
	{
		$organizers = array();
		$organizers['roles'] = array();
		$sql_roles = "SELECT * FROM organizer";

		$sql_res = $this->dbh->execQuery($sql_roles);
		
		if(count($sql_res))
		{	foreach ($sql_res as $key => $value)
				{ 
					 $org_obj = array();
					 $org_obj = array(
					 				'org_id'=>$value['org_id'],
									'org_name'=>$value['org_name'],
									'cont_person'=>$value['contact_person'],
									'email'=>$value['email'],
									'mobile'=>$value['mobile']
								 ); 
					$organizers['roles'][] = $org_obj;
				}
		}
		
		return $organizers['roles'];
	}

	function updateOrganizer()
	{
		$updateOrganizer = array();
		$updateOrganizer['status'] = array();
		$updateOrganizer['status']['type'] = "Success";
		$updateOrganizer['status']['message'] = "Organizer Created Successfully";

		$Organizer_Name	= $_REQUEST['Organize_name'];
		$Contact_Person	= $_REQUEST['Contact_person'];
		$Email			= $_REQUEST['Email'];
		$Mobile			= $_REQUEST['Mobile'];
		$Address		= $_REQUEST['Address'];
		$Ac_Name		= $_REQUEST['Ac_name'];
		$Ac_No			= $_REQUEST['Ac_no'];
		$Bank_Name		= $_REQUEST['Bank_name'];
		$Bank_Branch	= $_REQUEST['Bank_branch'];
		$Ifsc_Code		= $_REQUEST['Ifsc_code'];
		$Siwift_Code	= $_REQUEST['Siwift_code'];
		$Description	= $_REQUEST['Desc'];
		$date 			= $date = date('Y-m-d H:i:s');
		$sql_roles_select = "select * from organizer where account_no = $Ac_No";
		try
			{					
				$sql_res_select = $this->dbh->execQuery($sql_roles_select);
				if(count($sql_res_select))
				{					
					throw new Exception("This Account is Already Exist in Database");
				}
				else
				{
					// $sql_roles_insert ="update organizer SET org_name= '$Organizer_Name', contact_person= ''

					//(org_name, contact_person, email, mobile, address, account_name, account_no, bank, branch, ifsc_code, siwift_code, description, created_by, created, status) 
										// values('$Organizer_Name', '$Contact_Person', '$Email','$Mobile', '$Address', '$Ac_Name', '$Ac_No', '$Bank_Name', '$Bank_Branch', '$Ifsc_Code', '$Siwift_Code', '$Desc', ' ', '$date', 1 )";
					// $sql_roles_insert = $this->dbh->execUpdateQuery($sql_roles_insert);										
				}
			}
		catch(Exception $e)
			{
				$updateOrganizer['status']['type'] = "Error";
				$updateOrganizer['status']['message'] = "Caught Exception: " . $e->getMessage();
			}
		return $updateOrganizer;
	}

	function getOrganizerByEmail($email)
	{
		$sql_organizer 	= "SELECT * FROM organizer where email ='$email'";	
		$sql_res 		= $this->dbh->execQuery($sql_organizer);		
		if(count($sql_res))
		{
			return $sql_res;
		}
		else
		{
			return null;
		}
	}

	function get_org_events($org_id)
	{ 	
		$sql_query		= "SELECT * from event where organizer = $org_id";
		$sql_res 		= $this->dbh->execQuery($sql_query);
		return $sql_res;
	}

	function get_org_event_shows_data($organizer_events_data)	
	{
		$show = array();
		$counter = 0; 

		foreach ($organizer_events_data as $key => $value) 
		{				 	
	 		$count_shows = 0;
	 		$get_show_details = $this->showDetails($value['event_id']);		 	
	 		$count_shows = count($get_show_details);
	 		if(!$count_shows)
	 		{
	 			$show[$counter]['event_id'][] 		= $value['event_id'];
				$show[$counter]['display_name'] 	= $value['display_name'];
				$show[$counter]['venue'] 			= $value['venue'];
				$show[$counter]['ticket_status'] 	= $value['tickets_status'];
				$show[$counter]['shows_date'] 		= "-";
				$show[$counter]['shows_time'] 		= "-";
				$show[$counter]['status'] 			= "-";
				$counter++;
	 		}
	 		else
	 		{
	 			foreach ($get_show_details as $mykey => $myvalue) 
			 	{
			 		$show[$counter]['event_id'][] 		= $value['event_id'];
					$show[$counter]['display_name'] 	= $value['display_name'];
					$show[$counter]['venue'] 			= $value['venue'];
					$show[$counter]['ticket_status'] 	= $value['tickets_status'];
					$show[$counter]['shows_date'] 	= $myvalue['shows_date'];
					$show[$counter]['shows_time'] 	= $myvalue['shows_time'];
					$show[$counter]['status'] 		= $myvalue['status'];
					$counter++;
			 	}
	 		}
		 	
		 }

		 return $show;
	}

	function showDetails($event_id)
	{
		$sql_qrys = "select * from shows where event_id = $event_id";
		$sql_res = $this->dbh->execQuery($sql_qrys);
		return $sql_res;
	}
}