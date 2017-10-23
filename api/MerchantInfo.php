<?php

class MerchantInfo
{
	public function getAllMerchantsDetails()
	{
		// Get all merchant details
		$collection = Mage::getModel('Companyinfo/Companyinfo')->getCollection()->getAllIds();
		// var_dump($collection);
		foreach ($collection as $value) {
			$merchant = Mage::getModel('Companyinfo/Companyinfo')->load($value);
			$index = $merchant->getId();
			// var_dump($merchant);
			$merchantName[$index] = $merchant->getName();
			// echo "<br/>Merchat Name->" . $merchant->getName();
		}	
		return $merchantName;
	}

	public function getRecordForUserid($userid)
	{

		$ret = Array();
		// Dont forget the status type and message
		$ret['status'] = Array();
		$ret['status']['type'] = "Success";
		$ret['status']['message'] = "Retrieved Successfully";
		
		try {
			// Perform Mage retrieval operations
			$merchant = Mage::getModel('Companyinfo/Companyinfo')->load($userid);
			/* Get all merchant details
			$collection = Mage::getModel('Companyinfo/Companyinfo')->getCollection()->getAllIds();
			// var_dump($collection);
			foreach ($collection as $value) {
				$merchant = Mage::getModel('Companyinfo/Companyinfo')->load($value);
				echo "<br/>Merchat Name->" . $merchant->getName();
			} */
			// echo "Hello id".$userid;
			// echo ($merchant->getId());
			// Put the values in a simple array
			$ret['merchant'] = Array();
			$ret['merchant']['id'] = $merchant->getId();
			$ret['merchant']['name'] = $merchant->getName();
			$ret['merchant']['contactname'] = $merchant->getContactname();
			$ret['merchant']['contactemail'] = $merchant->getContactemail();
			$ret['merchant']['contactphone'] = $merchant->getContactphone();
			$ret['merchant']['image'] = $merchant->getImage();
			$ret['merchant']['address'] = $merchant->getAddress();
			$ret['merchant']['email'] = $merchant->getEmail();
			$ret['merchant']['telephone'] = $merchant->getTelephone();
			$ret['merchant']['info'] = $merchant->getInfo();
			$ret['merchant']['map'] = $merchant->getMap();
			$ret['merchant']['description'] = $merchant->getDescription();
			$ret['merchant']['nameoncheck'] = $merchant->getNameoncheck();
			$ret['merchant']['internalnotes'] = $merchant->getInternalnotes();
			$ret['merchant']['username'] = $merchant->getUsername();
			$ret['merchant']['password'] = $merchant->getPassword();
		}
		catch(Exception $e)
		{
			$ret['status']['type'] = "Error";
			$ret['status']['message'] = "Caught Exception: " . $e->getMessage();
		}

		$_merchantcollection = Mage::getModel('Companyinfo/Companyinfo')->getCollection();
			$_merchantcollection->addFieldToFilter(
									"username"
								);
			//var_dump($_merchantcollection);
			$merchant = $_merchantcollection->getFirstItem();
			$uname = $merchant->getUsername();
			$pword = $merchant->getPassword();
		$merchantHelper = Mage::helper('companyinfo');
		// var_dump($merchantHelper);

		return $ret;
	}

	public function getRecordForUsername($username = '')
	{

		$ret = Array();
		// Dont forget the status type and message
		$ret['status'] = Array();
		$ret['status']['type'] = "Success";
		$ret['status']['message'] = "Retrieved Successfully";
		
		try
		{
			// Perform Mage retrieval operations
			$_merchantcollection = Mage::getModel('Companyinfo/Companyinfo')->getCollection();
			if($username)
			{
				$_merchantcollection->addFieldToFilter(
										"username", Array('eq' => $username)
									);
			}
			$merchant = $_merchantcollection->getFirstItem();
			// Put the values in a simple array
			$ret['merchant'] = Array();
			$ret['merchant']['id'] = $merchant->getId();
			$ret['merchant']['name'] = $merchant->getName();
			$ret['merchant']['contactname'] = $merchant->getContactname();
			$ret['merchant']['contactemail'] = $merchant->getContactemail();
			$ret['merchant']['contactphone'] = $merchant->getContactphone();
			$ret['merchant']['image'] = $merchant->getImage();
			$ret['merchant']['address'] = $merchant->getAddress();
			$ret['merchant']['email'] = $merchant->getEmail();
			$ret['merchant']['telephone'] = $merchant->getTelephone();
			$ret['merchant']['info'] = $merchant->getInfo();
			$ret['merchant']['map'] = $merchant->getMap();
			$ret['merchant']['description'] = $merchant->getDescription();
			$ret['merchant']['nameoncheck'] = $merchant->getNameoncheck();
			$ret['merchant']['internalnotes'] = $merchant->getInternalnotes();
			$ret['merchant']['username'] = $merchant->getUsername();
			$ret['merchant']['password'] = $merchant->getPassword();
		}
		catch(Exception $e)
		{
			$ret['status']['type'] = "Error";
			$ret['status']['message'] = "Caught Exception: " . $e->getMessage();
		}

		return $ret;
	}

	function validateMerchant($username, $password)
	{
		try
		{
			// Perform Mage retrieval operations
			$_merchantcollection = Mage::getModel('Companyinfo/Companyinfo')->getCollection();
			$_merchantcollection->addFieldToFilter(
									"username", Array('eq' => $username)
								);
			$merchant = $_merchantcollection->getFirstItem();
			$uname = $merchant->getUsername();
			$pword = $merchant->getPassword();

			// encrypt the password provided
			$merchantHelper = Mage::helper('companyinfo');
			$password = $merchantHelper->encrypt($password, $merchant->getEncKey());

			if($uname == $username && $pword == $password)
				return true;
			else
				return false;
		}
		catch(Exception $e)
		{
			// Something went wrong
			// refuse entry
			return false;
		}

		// refuse in case of doubt
		return false;

	}

	function userValidation($username, $password)
	{
		try
		{
			$_usercollection = Mage::getModel('Companyinfo/Dgaccount')
							->getCollection()
							->addFieldToFilter("username", Array('eq' => $username))
							->getData();
			
			$uname = $_usercollection[0]['username'];
			$pword = $_usercollection[0]['password'];
			// echo "uname--" . $uname . "--username--" . $username;
			// echo "<br/>pword--" . $pword . "--password--" . $password;
			if ($uname == $username && $pword == $password)
				return true;
			else
				return false;

			/* print_r($uname."--".$pword);
			echo "<br/>";
			print_r($_usercollection);
			echo "<br/>";
			print_r($_usercollection[0]['id']);
			echo "<br/>";
			var_dump($_usercollection); */
		}
		catch(Exception $e) 
		{
			return false;
		}

		// refuse in case of doubt
		return false;
	}
}
