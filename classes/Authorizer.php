<?php

require_once "api/MerchantInfo.php";
ob_start();

class Authorizer
{

	public function auth()
	{
		$user = isset($_SESSION['taf_username']) ? $_SESSION['taf_username'] : "";
		if(!$user)
		{
			$user 		= isset($_POST['username']) ? $_POST['username'] : "";
			$pass 		= isset($_POST['password']) ? $_POST['password'] : "";
			$remember 	= isset($_POST['remember']) ? $_POST['remember'] : "";		
			
			if($remember) {
				setcookie('taf_remember_me', $user, time() + (10 * 365 * 24 * 60 * 60));
			}
			elseif(!$remember) {
				if(isset($_COOKIE['taf_remember_me'])) {
					$past = time() - 100;
					setcookie('taf_remember_me', 'gone', $past);
				}
			}

			if ($user != "" && $pass != "")
			{
				$userobj = new User();
				if($userobj->validateUser($user, $pass))
				{					
					$user_access_record 			= $userobj->getUserRecord($user);
					$_SESSION['taf_username'] 		= $user_access_record[0]['display_name'];
					$_SESSION['taf_userid'] 		= $user_access_record[0]['id'];
					$_SESSION['taf_user_role']		= $user_access_record[0]['role'];
					if($user_access_record[0]['role'] == 'User')
					{
						$_SESSION['taf_org_id']			= $user_access_record[0]['org_id'];	
					}
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false; // either user or pass is empty
			}
		}
		// If user session var is there
		// the request is authenticated
		return true;
	}

	// function authUser()
	// { //unset($_SESSION);
	// 	$user = isset($_SESSION['taf_username']) ? $_SESSION['taf_username'] : ""; 
	// 	if(!$user)
	// 	{
	// 		$user 		= isset($_POST['username']) ? $_POST['username'] : "";
	// 		$pass 		= isset($_POST['password']) ? $_POST['password'] : "";
	// 		$remember 	= isset($_POST['remember']) ? $_POST['remember'] : "";		
			
	// 		if($remember) {
	// 			setcookie('taf_remember_me', $user, time() + (10 * 365 * 24 * 60 * 60));
	// 		}
	// 		elseif(!$remember) {
	// 			if(isset($_COOKIE['taf_remember_me'])) {
	// 				$past = time() - 100;
	// 				setcookie('taf_remember_me', 'gone', $past);
	// 			}
	// 		}

	// 		if ($user != "" && $pass != "")
	// 		{ 
	// 			$userobj = new User();
	// 			if($userobj->validateOrganizerUser($user, $pass))
	// 			{ 
	// 				$org_user_access_record 	= $userobj->organizerUserDetails($user);
	// 				$_SESSION['user_email'] 	= $user;					
	// 				$_SESSION['user_id'] 		= $org_user_access_record[0]['user_id'];
	// 				$_SESSION['name'] 			= $org_user_access_record[0]['name'];
	// 				$_SESSION['org_id'] 		= $org_user_access_record[0]['org_id'];
	// 				$_SESSION['role_name']		= $org_user_access_record[0]['user_role'];
	// 				//return true;
	// 			}
	// 			else
	// 			{
	// 				return false;
	// 			}
	// 		}
	// 		else
	// 		{
	// 			return false; // either user or pass is empty
	// 		}
	// 	}
	// 	return true;
	// }

	public function logout()
	{
		session_destroy();
	}
}

