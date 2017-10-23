<?php
error_reporting(E_ALL);
include "classes/init.php";
//require "../base_config.php";

$homepage 		= $eventus_tix_base_url."/organizer/event_organizer_list";
$user_homepage 	= $eventus_tix_base_url."/organizer/user_home";

try
{
	$api 		= isset($_REQUEST['api']) ? $_REQUEST['api'] : "";
	$method 	= isset($_REQUEST['method']) ? $_REQUEST['method'] : "";
	$page 		= isset($_REQUEST['page']) ? $_REQUEST['page'] : "";
	$action 	= isset($_REQUEST['action']) ? $_REQUEST['action'] : "";

	$auth 		= new Authorizer();
	$wrap 		= new Wrapper($api, $method, $page);

	// Sign up page? Welcome sir!
	if($page == 'signup')
	{
		$wrap->renderPage("signup", "tafpresignin");
		exit;
	}

	// Sign up page? Welcome sir!
	if($page == 'iceinfo')
	{
		$wrap->renderPage($page, "tafpresignin");
		exit;
	}

	// User logging out? Take care of that first
	if($action == 'logout' || $page == 'logout')
	{
		$auth->logout();
		header("Location: " . SIGNINPAGE);
	}

	if($page == 'signin')
	{  echo "begun <br/>";
		if($auth->auth())
		{ echo "Validated <br/>"." and the role is ".$_SESSION['taf_user_role']; 
			if($_SESSION['taf_user_role'] == 'User')
			{
				header("Location: " . $user_homepage);
			}
			else
			{
				header("Location: " . $homepage);
			}			
		}
	}
	//If signin page and successful authentication then go to the homepage "event_organizer_list"
	
	// Authorize the request -- only if not a register request
	if(($api != "User" && $method != "register" && $_SESSION['org_id'] == ""))
	{
		if(!$auth->auth())
		{
			$wrap->renderPage("signin", "tafpresignin");
			exit;
		}
	}	

	// If neither api nor page provided
	if($api == "" && $page == "")
	{
		header("Location: " . LANDINGPAGE);
		//echo LANDINGPAGE;
	}

	// Process the request
	echo $wrap->execute();
}
catch (Exception $ex)
{
	echo $ex->getMessage();
}
