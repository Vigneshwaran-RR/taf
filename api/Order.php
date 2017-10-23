<?php
class Order
{
	public function setOrderStatusForOrderID($orderIds,$status)
	{
		if($orderIds == '') $orderIds = $_REQUEST['voucherids'];
		if($status == '') $status = $_REQUEST['status'];

		$ret = Array();
		// Dont forget the status type and message
		$ret['status'] = Array();
		$ret['status']['type'] = "Success";
		$ret['status']['message'] = "Updated Successfully";
		$ret['status']['value1'] = $orderIds;
		$ret['status']['value2'] = $status;

		if(!$orderIds)
		{
			$ret['status']['type'] = "Failure";
			$ret['status']['message'] = "Voucher list is empty"; 
			return $ret;
		}
		
		try
		{
			$orderIds = explode(',', $orderIds);
			foreach($orderIds as $orderId)
			{
				if($orderId)
				{
					// $voucher = Mage::getModel('voucher/vouchers')->load($voucherid);
					// $voucher->setVoucherPaymentStatus($status);
					// $voucher->save();
					$Order = Mage::getModel('Companyinfo/Orderreceivable')->load($orderId);
					$Order->setOrderReceivableStatus($status);
					$Order->save();
				}
			}
		}
		catch(Exception $e)
		{
			$ret['status']['type'] = "Error";
			$ret['status']['message'] = "Caught Exception: " . $e->getMessage();
		}

		return $ret;
	}
}