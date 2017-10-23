<?php

require_once "classes/DBH.php";

class Pages
{
	protected $dbh;
	function __construct()
	{	$this->dbh = new DBH();
		if(!$this->dbh->getConnection())
			throw new Exception("Unable to connect to DB");
	}

	function addPage($pagename = "")
	{
		if($pagename == '') $pagename = $_REQUEST['page_Name'];
		$page = array();
		$page['status'] = array();
		$page['status']['type'] = "Success";
		$page['status']['message'] = "Page has Added Successfully";

		try
		{	$sql = "select * from taf_pages";
			$sqlret = $this->dbh->execQuery($sql);
			$page_id =count($sqlret)+1;

			$sql_duplicate = "select * from taf_pages where page_name = '$pagename'";
			$page['debug']['sql'] = $sql_duplicate;
			$sql_dup = $this->dbh->execQuery($sql_duplicate);
			if(count($sql_dup) >=1)
			{	throw new Exception("This Page is already Exists");
			}
			else 
			{	$sql_update = "insert into taf_pages(page_id,page_name)values('$page_id','$pagename')";
				$sql_ret = $this->dbh->execUpdateQuery($sql_update);
			}		
		}
		catch(Exception $e)
		{	$page['status']['type'] = "Error";
			$page['status']['message'] = "Caught Exception: " . $e->getMessage();
		}
		return $page;
	}

	function getAllPages()
	{
		$pages = array();
		$page_names = array();
		$sql_get_pages = "select * from taf_pages";
		$sql_res_pages = $this->dbh->execQuery($sql_get_pages);
		if(count($sql_res_pages) > 0)
		{	foreach ($sql_res_pages as $key => $value) 
			{	$pages[] = $value['page_name'];
			}				
		}
		return $pages;
	}

	function saveUserPages()
	{
		$savepages = array();	
		$savepages['status'] = array();
		$savepages['status']['type'] = "Success";
		$savepages['status']['message'] = "Roles are Retrieved Successfully";
		$user_page = Array();
		$user_page = $_REQUEST['userpages'];
		if($get_rolename == '') $get_rolename = $_REQUEST['role_name'];
		//Get role id passing Role Name in sql query
		try
		{	$role_id_sql = "select role_id from taf_roles where role_name = '".$get_rolename."' ";
			$role_id_ret = $this->dbh->execQuery($role_id_sql);
			$info = $role_id_ret[0];
			$role_id = $info['role_id'];
			//Checking whether the role already assigned with Pages,
			//If yes, do DELETE and INSERT, else do simple INSERT			
			$check_role_pages_sql = "select * from taf_authd_pages where role_id = $role_id";
			$check_role_pages_ret = $this->dbh->execQuery($check_role_pages_sql);
			if(count($check_role_pages_ret) > 0)
			{	if($user_page)
				{	//DELETING the Previous stored Pages to the Respective Roles
					$delete_page_sql = "delete from taf_authd_pages where role_id = $role_id";
					$is_deleted = $this->dbh->execQuery($delete_page_sql);
					//INSERTING new pages to the Respective Pages
					foreach ($user_page as $key => $value) 
					{	$addpage_sql = "insert into taf_authd_pages(role_id,grtd_pages)values($role_id,'".rtrim($value,'/')."')";
						$is_added = $this->dbh->execUpdateQuery($addpage_sql);					
					}
				}
			}
			else //Use this Retrieved Role id to store roles Granted Pages of Respective Roles
			{	if($user_page)
				{	foreach ($user_page as $key => $value) 
					{	$addpage_sql = "insert into taf_authd_pages(role_id,grtd_pages)values($role_id,'".rtrim($value,'/')."')";
						$is_added = $this->dbh->execUpdateQuery($addpage_sql);
					}	
				}
			}			
		}
		catch(Exception $e)
		{	$savepages['status']['type'] = "Error";
			$savepages['status']['message'] = "Caught Exception: " . $e->getMessage();
		}		
		return $savepages;
	}

	function getUserPages()
	{	
		$return_values = array();
		//Get Role id using RoleName...
		$choosed_role = $_REQUEST['role_selected'];
		$get_role_id_sql = "select role_id from taf_roles where role_name ='" .$choosed_role. "' ";
		$exec_sql = $this->dbh->execQuery($get_role_id_sql);
		$info = $exec_sql[0];
		$role_id = $info['role_id']; //Got Role Id here...
		//Query to get the Granted Pages having given role id as parameter...
		$get_user_pages_sql = "select grtd_pages from taf_authd_pages where role_id = $role_id";
		$exec_sql_pages = $this->dbh->execQuery($get_user_pages_sql);
		for ($i=0; $i < sizeof($exec_sql_pages); $i++) { 
			$return_values[] = $exec_sql_pages[$i]['grtd_pages'];
		}
		return $return_values;
	} 
}
