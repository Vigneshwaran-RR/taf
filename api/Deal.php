<?php

include_once "Voucher.php";

class Deal
{

	/*
	 * Get an array of deal ids and description
	 * for deals associated with this merchant
	 */
	public function getDealsListForMerchant($merchantid)
	{
		if($merchantid == '') $merchantid = $_REQUEST['merchantid'];

		$ret = Array();
		// Dont forget the status type and message
		$ret['status'] = Array();
		$ret['status']['type'] = "Success";
		$ret['status']['message'] = "Retrieved Successfully";
		$ret['products'] = Array();
		$ret['debug'] = Array();
		$ret['debug']['merchantid'] = $merchantid;
		// return $ret;

		try
		{
			// Perform Mage retrieval operations
			$productids = Mage::getModel('catalog/product')->getCollection()
			    ->addAttributeToFilter('mic', array('eq' => $merchantid))
			    ->getAllIds();

			$ret['debug']['mic'] = $merchantid;
			$dealHelper = Mage::Helper('deal');

			$productno = 0;
			foreach($productids as $productid)
			{
				$ret['debug']['productids'] .=  $product_id + "--";
				$product = Mage::getModel('catalog/product')->load($productid);
				// Put the values in a simple array
				$ret['products'][$productno] = Array();
				$ret['products'][$productno]['id'] = $product->getId();
				$ret['products'][$productno]['name'] = $product->getName();
				$ret['products'][$productno]['voucher_title'] = $product->getVoucherTitle();
				$ret['products'][$productno]['deal_url'] = $dealHelper->getFullProductUrl($product);
				$ret['products'][$productno]['deal_price'] = $product->getPrice();
				$ret['products'][$productno]['agent_name'] = $product->getAttributeText('deal_agent');

				$voucherObj = new Voucher();
				$vouchers = $voucherObj->getVouchersForDealId($merchantid, $productid);
				$voucherCount = sizeof($vouchers['vouchers']);
				$ret['products'][$productno]['voucher_count'] = $voucherCount;

				$productno++;
			}
		}
		catch(Exception $e)
		{
			$ret['status']['type'] = "Error";
			$ret['status']['message'] = "Caught Exception: " . $e->getMessage();
		}
		// var_dump($ret);
		return $ret;
	}

	//This function gets all vouchrrs for a particular ID for the merchant.
	public function getVouchersofID($dealid)
	{
	    // Get all vouchers
	}

	// Set status for a voucher.
	public function setStatusofVoucher($voucherid, $status)
	{
	    // pass
	}

	// Get Order Status
	public function getOrderStatus()
	{
		$orders = Mage::getModel('sales/order')->getCollection();
		var_dump($orders);
	}

}
