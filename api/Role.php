<?php

require_once "classes/DBH.php";

class Role
{
	protected $dbh;
	function __construct()
	{
		$this->dbh = new DBH();
		if(!$this->dbh->getConnection())
			throw new Exception("Unable to connect to DB");
	}
	
	function addRole($theName)
	{
		$addRoles = array();
		$addRoles = array();
		$addRoles['status'] = array();
		$addRoles['status']['type'] = "Success";
		$addRoles['status']['message'] = "Role added Successfully";
		$theName = $_REQUEST['add_Roles'];
		$sql_roles_select = "select * from taf_roles where role_name = $theName";
		try
			{					
				$sql_res_select = $this->dbh->execQuery($sql_roles_select);
				if(count($sql_res_select))
				{					
					throw new Exception("This name is Already Exist in Database");
				}
				else
				{
					$sql_roles_insert ="insert into taf_roles(role_name) values('$theName')";
					$sql_roles_insert = $this->dbh->execUpdateQuery($sql_roles_insert);					
				}
			}
		catch(Exception $e)
			{
				$addRoles['status']['type'] = "Error";
				$addRoles['status']['message'] = "Caught Exception: " . $e->getMessage();
			}
			return $addRoles;
	}

	function getAllRoles()
	{	
		$roles = array();
		$roles['roles'] = array();
		$sql_roles = "SELECT * FROM taf_roles";

		$sql_res = $this->dbh->execQuery($sql_roles);
		
		if(count($sql_res))
		{	foreach ($sql_res as $key => $value)
				{ 
					 $role_obj = array();
					 $role_obj = array(
									'role_id'=>$value['role_id'],
									'role_name'=>$value['role_name']
								 ); 
					$roles['roles'][] = $role_obj;
				}
		}
		
		return $roles['roles'];		
	}

	function updateRole($displayname = "", $rolename = "")
	{
		if($displayname == '') $displayname = $_REQUEST['display_Name'];
		if($rolename == '') $rolename = $_REQUEST['role_Name'];
		$update = array();	
		$update['status'] = array();
		$update['status']['type'] = "Success";
		$update['status']['message'] = "Role is Updated Successfully";
		try
		{	$sql_update = "UPDATE taf_users SET role = '".$rolename."' WHERE display_name = '".$displayname."' ";			
			$sql_ret = $this->dbh->execUpdateQuery($sql_update);
		}
		catch(Exception $e)
		{	$update['status']['type'] = "Error";
			$update['status']['message'] = "Caught Exception: " . $e->getMessage();
		}
		return $update;
	}

	function deleteRole($role_delete ="")
	{
		$role_delete = $_REQUEST['deleteRole'];		
		$delete = array();
		$delete['status'] = array();
		$delete['status']['type'] = "Success";
		$delete['status']['message'] = "Role is deleted successfully";
		try
		{
			$sql_delete = "delete from taf_roles where role_name = '$role_delete'";
			$sql_val = $this->dbh->execQuery($sql_delete);
		}
		catch(Exception $e)
		{
			$delete['status']['type'] = "Error";
			$delete['status']['message'] = "Caught Exception: " . $e->getMessage();
		}
		return $delete;
	}

}

?>
