<?php
class User
{
	protected $dbh;
	function __construct()
	{
		$this->dbh = new DBH();
		if(!$this->dbh->getConnection())
			throw new Exception("Unable to connect to DB");
	}

	function getAllUsers()
	{		
		$users = array();
		$users['users'] = array();
		$displaynames = array();		
		$sql_roles = "SELECT * FROM taf_users";	
		$sql_res = $this->dbh->execQuery($sql_roles);
		
		if(count($sql_res))
		{	foreach ($sql_res as $key => $value) 
			{	$users['users'][] = $value;
			}
			foreach ($users['users'] as $key) 
			{	$displaynames[] = $key['display_name'];
			}	
		}
		return $displaynames;
	}

	function validateUser($user, $pass)
	{
		$md5pass = md5($pass);	// do md5 here
		$sql = "select * from taf_users where email = '" . $user . "' and password = '" . $md5pass . "'";
		$sqlret = $this->dbh->execQuery($sql);
		if(count($sqlret) > 0) return true;
		return false;
	}

	function getUserRecord($user)
	{
		// return user record in format $ret['id'], $ret['username'], $ret['password'];
		$sql = "select * from taf_users where username = '" . $user . "'";
		$sqlret = $this->dbh->execQuery($sql);
		return $sqlret;
	}

	function authPage($page) {
		// check whether this page is authenticated to the current user
		$role_name = $_SESSION['role_name'];
		$sql_get_role_id = "select role_id from taf_roles where role_name='" .$role_name ."'";
		$sql_exe_qry = $this->dbh->execQuery($sql_get_role_id);		
		$role_id = $sql_exe_qry[0]['role_id'];
		$_SESSION['role_id'] = $role_id;
		//in taf_auth_pages table check the page name with role_id
		$sql_get_auth_page = "select * from taf_authd_pages where role_id=".$role_id." and grtd_pages ='". $page."' ";
		$sql_exe_qry = $this->dbh->execQuery($sql_get_auth_page);
		if(!empty($sql_exe_qry))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function register($displayname = "", $username = "", $pass = "", $email = "")
	{
		if($displayname == '') $displayname = $_REQUEST['displayname'];
		if($username == '') $username = $_REQUEST['username'];
		if($pass == '') $password = $_REQUEST['password'];
		if($email == '') $email = $_REQUEST['email'];

		$ret = Array();
		// Dont forget the status type and message
		$ret['status'] = Array();
		$ret['status']['type'] = "Success";
		$ret['status']['message'] = "User Created Successfully";
		$ret['debug']['input'] = Array();
		$ret['debug']['input']['displayname'] = $displayname;
		$ret['debug']['input']['username'] = $username;
		$ret['debug']['input']['password'] = $password;
		$ret['debug']['input']['email'] = $email;

		try
		{
	
			// check if the email id or username already exists
			$sql = "select * from taf_users where username = '$username'";
			$sqlret = $this->dbh->execQuery($sql);
			if(count($sqlret) > 0)
			{
				throw new Exception("This username is already in use.");
			}

			// Create new user in the db
			$sql = "insert into taf_users(username, password, display_name, email, role) values('$username', '" . md5($password) . "', '$displayname', '$email', 'user')";
			$sqlret = $this->dbh->execUpdateQuery($sql);
		}
		catch(Exception $e)
		{
			$ret['status']['type'] = "Error";
			$ret['status']['message'] = "Caught Exception: " . $e->getMessage();
		}
		return $ret;

	}

	function createOrganizerUser()
	{
		$username 	= $_REQUEST['username'];
		$mobile 	= $_REQUEST['mobile'];
		$password 	= $_REQUEST['password'];
		$email 		= $_REQUEST['email'];
		$org_id		= $_REQUEST['org_id'];
		$ret = Array();
		// Dont forget the status type and message
		$ret['status'] 				= Array();
		$ret['status']['type'] 		= "Success";
		$ret['status']['message'] 	= "User Created Successfully";
		$ret['debug']['input'] 		= Array();
		
		$ret['debug']['input']['username'] 	= $username;
		$ret['debug']['input']['mobile'] 	= $mobile;
		$ret['debug']['input']['password'] 	= $password;
		$ret['debug']['input']['email'] 	= $email;
		$date = date('Y-m-d H:i:s');
		try
		{	
			// check if the email id or username already exists
			$sql = "select * from taf_users where email = '$email' and role = 'User'";
			$sqlret = $this->dbh->execQuery($sql);
			if(count($sqlret) > 0)
			{
				throw new Exception("This User is already Exist.");
			}
			// Create new user in the db
			$sql = "insert into taf_users(username, password, display_name, email, role, org_id, mobile) values('$username', '" . md5($password) . "', '$username', '$email', 'User', '$org_id','$mobile')";
			$sqlret = $this->dbh->execUpdateQuery($sql);
		}
		catch(Exception $e)
		{
			$ret['status']['type'] = "Error";
			$ret['status']['message'] = "Caught Exception: " . $e->getMessage();
		}
		return $ret;
	}

	function getAllOrganizerUsers($org_id)
	{
		$org_users 			= array();
		$org_users['users'] = array();
		$displaynames 		= array(); echo $org_id.' is the id'		;
		$sql_organizer 		= "SELECT * FROM user where user_type_id = 4 and org_id = $org_id";	
		$sql_res 			= $this->dbh->execQuery($sql_organizer);		
		
		if(count($sql_res))
		{	foreach ($sql_res as $key => $value)
				{ 
					 $org_obj = array();
					 $org_obj = array(
									'name'=>$value['name'],
									'mobile'=>$value['mobile'],
									'email'=>$value['email']
								 	 );
					$org_users['users'][] = $org_obj;
				}
		}
		return $org_users['users'];
	}

	function getOrganizerUserByEmail($email)
	{			
		$sql_organizer 	= "SELECT * FROM user where user_type_id = 4 and email ='$email'";	
		$sql_res 		= $this->dbh->execQuery($sql_organizer);		
		if(count($sql_res))
		{
			return $sql_res;
		}
		else
		{
			return false;
		}
	}

	function deleteOrganizerUserByEmail()
	{ 
		$email 		= $_REQUEST['Email']; 
		$ret 		= array();
		// Dont forget the status type and message
		$ret['status'] 				= array();
		$ret['status']['type'] 		= "Success";
		$ret['status']['message'] 	= "User Deleted Successfully";
		try
		{
			$sql_delete = "DELETE from user where user_type_id = 4 and email = '$email'"; 
			$sql_val = $this->dbh->execQuery($sql_delete);
		}
		catch(Exception $e)
		{
			$ret['status']['type'] = "Error";
			$ret['status']['message'] = "Caught Exception: " . $e->getMessage();
		}
		return $ret;
	}

	function validateOrganizerUser($user, $pass)
	{ 
		$sql_org_login = "select * from user where email = '" . $user . "' and password = '" . md5($pass) . "' and user_type_id = 4";
			$sql_ret = $this->dbh->execQuery($sql_org_login);
			if(count($sql_ret) > 0)			
				return true;	
			else
				return false;
	}

	function organizerUserDetails($user)
	{
		$sql = "select * from user where email = '" . $user . "'";
		$sqlret = $this->dbh->execQuery($sql);
		return $sqlret;
	}
}
?>
