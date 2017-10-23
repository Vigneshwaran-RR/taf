<?php
class Wrapper
{
	protected $api;
	protected $method;
	function __construct($api, $method, $page)
	{
		$this->api = $api;
		$this->method = $method;
		$this->page = $page;
		//echo "<br/>$api<br/>$method<br/>$page";
	}

	public function execute()
	{
		$ret = array();
		if($this->api && $this->method)
		{
			// returns a json object
			$ret = $this->invokeApi();
		}
		else if ($this->page)
		{
			// returns a html page
			$ret = $this->invokePage();
		}

		return $ret;
	}

	function invokeApi()
	{
		require_once "api/" . $this->api . ".php";
		$apiObj = new $this->api;

		if(strpos($this->method, "CSV") === FALSE)
		{
			// return JSON
			return json_encode(call_user_func(array($apiObj, $this->method)));
		}
		else
		{
			// return as is
			return call_user_func(array($apiObj, $this->method));
		}
	}

	function invokePage()
	{
		$this->renderPage($this->page);
		exit;
		return true;
	}

	function renderPage($page, $template = TEMPLATENAME)
	{ 
		require_once TEMPLATES_DIR . $template . ".php";
	}

	function renderContent($content)
	{	
		// $userobj = new User();
		// if($content != "signin" || $content != "signup" || $content != "login")
		// { 
	 //        if($userobj->authPage($content))
	 //        {
	 //            require_once VIEWS_DATA_DIR . $content . ".php";
	 //            require_once VIEWS_VIEWS_DIR . $content . ".html";
	 //        }
  //   	}
  //   	else
  //   	{ 
		
    		require_once VIEWS_DATA_DIR . $content . ".php";
	        require_once VIEWS_VIEWS_DIR . $content . ".html";
    	// }
	}

	function show()
	{
		print_r($this);
	}
}
?>
