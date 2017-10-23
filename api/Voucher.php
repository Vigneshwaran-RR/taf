<?php

include_once "Deal.php";
include_once "NI.php";

class Voucher
{

	public function getVouchersForDealIdWithFilters($merchantid, $dealid, $orderStatus, $paymentmethod, $voucherpaymentstatus, $orderReceivableStatus)
	{	
		
		$NI = new NI();
		if($merchantid == '') $merchantid = $_SESSION['userid'];
		if($dealid == '') $dealid = $_REQUEST['dealid'];
		if($orderStatus == '') $orderStatus = $_REQUEST['orderstatus'];
		if($paymentmethod == '') $paymentmethod = $_REQUEST['paymentmethod'];
		if($voucherpaymentstatus == '') $voucherpaymentstatus = $_REQUEST['voucherpaymentstatus'];
		if($orderReceivableStatus == '') $orderReceivableStatus = $_REQUEST['orderReceivableStatus'];
		// echo "22>" . $orderReceivableStatus;
		$this->setPaymentNotes();
		$ret = Array();
		// Dont forget the status type and message
		$ret['status'] = Array();
		$ret['status']['type'] = "Success";
		$ret['status']['message'] = "Retrieved Successfully";
		$ret['debug']['orderstatus'] = $orderStatus;
		$ret['debug']['payment_method'] = $paymentmethod;
		$ret['debug']['voucherpaymentstatus'] = $voucherpaymentstatus;

		if(!$dealid)
		{
			$ret['status']['type'] = "Failure";
			$ret['status']['message'] = "Deal Id is empty"; 
			return $ret;
		}
		$ret['vouchers'] = Array();
		
		try
		{
			// Perform Mage retrieval operations
			// Get vouchers for one deal/many deals
			if(is_array($dealid))
			{
				$voucherids = Mage::getModel('voucher/vouchers')->getCollection()
					->addFieldToFilter('product_id', array('in' => $dealid))
					->getAllIds();
			}
			else
			{
				$voucherids = Mage::getModel('voucher/vouchers')->getCollection()
					->addFieldToFilter('product_id', array('eq' => $dealid))
					->getAllIds();
			}

			$voucherno = 0;
			$totalVoucherAmount = 0;
			$amountRecieved = 0;
			foreach($voucherids as $voucherid)
			{
				$count++;
				$voucher = Mage::getModel('voucher/vouchers')->load($voucherid);
				$customerid = $voucher->getCustomerId();
				$customername = '';
				if($customerid)
				{
					$customer = Mage::getModel('customer/customer')->load($customerid);
					$customername .= $customer->getFirstname() . " " . $customer->getLastname();
					
				}
				$order_id = $voucher->getOrderId();
				$order = Mage::getModel('sales/order')->load($order_id);
				$orderPayment = Mage::getResourceModel('sales/order_payment_collection')
								->addFieldToSelect('*')
                     			->addFieldToFilter('parent_id',$order_id);
				$paymentMethod = $orderPayment->getFirstItem()->getMethod();
				
				// Proceed only for the selected order status
				$orderstatus = $order->getStatus();
				if($orderStatus != "All") {
					if($orderstatus != $orderStatus)
						continue; 
				}
				// Proceed only for the selected Payment Method
				if($paymentmethod != "All") {
					if($paymentMethod != $paymentmethod)
						continue;
				}
				// Check the voucher payment status
				if($voucherpaymentstatus != "All") {
					if($voucher->getVoucherPaymentStatus() != $voucherpaymentstatus)
						continue;
				}
				// Check Order Receivable Status
				$OrderID = $voucher->getOrderIncrementId();
				$currentOrderReceivableStatus = $NI->getOrderReceivableStatus($OrderID);
				if($orderReceivableStatus != "All") { 
					if($orderReceivableStatus != $currentOrderReceivableStatus)
						continue;
				}

				$items = $order->getAllVisibleItems();
				foreach($items as $item)
				{
					$price[] = $item->getOriginalPrice();
				}
				$voucherPrice = number_format((float)$price[0], 0, '', '');

				// Amount recieved
				if($currentOrderReceivableStatus == "received") {
					$amountRecieved = $amountRecieved + $voucherPrice;
					$ret['summary']['amountRecieved'] = $amountRecieved . " AED";
				}


				$_product = Mage::getModel('catalog/product')->load($voucher->getProductId());
				
				// Total Number of vouchers
				$ret['summary']['totalVouchers'] = $voucherno + 1;
				// Grand Total of Voucher Amount
				$totalVoucherAmount = $totalVoucherAmount + $voucherPrice;
				$ret['summary']['totalAmount'] = $totalVoucherAmount . " AED";
				/* Amount recieved
				$amountRecieved = 500;
				$ret['summary']['amountRecieved'] = $amountRecieved . " AED"; */
				// Commission 
				$commission = $_product->getCommission();
				$ret['summary']['commission'] = $commissionAmount . " AED";
				// Total Payable amount
				if($amountRecieved != 0) {
					$commissionAmount = ($commission/100) * $amountRecieved;
					$totalPayable = $amountRecieved - $commissionAmount;
				}
				$ret['summary']['totalPayable'] = $totalPayable . " AED";
				// Get Payment Notes
				$ret['summary']['paymentNotes'] = $_product->getpayment_notes();

				$item_id = $voucher->getItemId();
				 $product_options = '';
				 if(isset($item_id))
				 {
					 $item = Mage::getModel('sales/order_item')->load($item_id);

					 $poptions = $item->getProductOptions();
					 // print_r($poptions);
					 if(isset($poptions) && isset($poptions['options']))
					 {
						 // print_r($poptions['options'][0]['print_value']);
						 $sep = '';
						 foreach($poptions['options'] as $poption)
						 {
							 $product_options .= $sep . $poption['print_value'];
							 $sep = ', ';
						 }
					 }
				 }
				// Put the values in a simple array
				$ret['vouchers'][$voucherno] = Array();
				$ret['vouchers'][$voucherno]['Order ID'] = $voucher->getOrderIncrementId();
				$ret['vouchers'][$voucherno]['Voucher ID'] = $voucher->getId();
				$ret['vouchers'][$voucherno]['Voucher Code'] = $voucher->getDealVoucherCode();
				$ret['vouchers'][$voucherno]['Customer Name'] = $customername;
				$ret['vouchers'][$voucherno]['Product Name'] = $_product->getName();
				if($_product->hasOptions) {
					$ret['vouchers'][$voucherno]['Product Name'] = $_product->getName() . "<br/><font style='font-weight:bold;'>Option Bought:</font> " . $product_options; 
				} else {
					$ret['vouchers'][$voucherno]['Product Name'] = $_product->getName();
				}
				$ret['vouchers'][$voucherno]['Purchase Date'] = $order->getCreatedAt();
				// $ret['vouchers'][$voucherno]['storeid'] = $voucher->getStoreId();
				// $ret['vouchers'][$voucherno]['orderid'] = $voucher->getOrderId();
				// $ret['vouchers'][$voucherno]['itemid'] = $voucher->getItemId();
				// $ret['vouchers'][$voucherno]['productid'] = $voucher->getProductId();
				// $ret['vouchers'][$voucherno]['issent'] = $voucher->getIsSent();
				$ret['vouchers'][$voucherno]['Order Status'] = $order->getStatus();
				$ret['vouchers'][$voucherno]['Voucher Status'] = ucwords($voucher->getStatus());
				$ret['vouchers'][$voucherno]['Voucher Amount'] = "AED " . $voucherPrice;
				$ret['vouchers'][$voucherno]['Payment Method'] = $orderPayment->getFirstItem()->getMethod();
				$ret['vouchers'][$voucherno]['Order Receivable Status'] = $currentOrderReceivableStatus;
				$ret['vouchers'][$voucherno]['Voucher Payment Status'] = $voucher->getVoucherPaymentStatus();
				$createddate = new DateTime($voucher->getCreatedAt());
				$createddate = $createddate->format("d-m-Y");
				$ret['vouchers'][$voucherno]['Purchase Date'] = $createddate;

				$voucherno++;
			} 
		}
		catch(Exception $e)
		{
			$ret['status']['type'] = "Error";
			$ret['status']['message'] = "Caught Exception: " . $e->getMessage();
		}
		return $ret;
	}

	public function setPaymentNotes($dealid, $paymentNotes)
	{
		if($dealid == '') $dealid = $_REQUEST['dealID'];
		if($paymentNotes == '') $paymentNotes = $_REQUEST['paymentNotes'];
		$_return = Array();
		$_return['dealid'] = $dealid;
		$_return['paymentNotes'] = $paymentNotes;

		$_product = Mage::getModel('catalog/product')->load($dealid);
		
		$_product->setData('payment_notes', $paymentNotes);
		$_product->save();

		return $_return;
	}

	public function getVouchersForDealId($merchantid, $dealid)
	{	
		if($dealid == '') $dealid = $_REQUEST['dealid'];

		return $this->getVouchersForDealIdWithFilters($merchantid, $dealid, "All", "All");
	}

	public function getVouchersForDealIdAsCSV()
	{
		$dealid = $_REQUEST['dealid'];
		$merchantid = $_SESSION['userid'];
		$data = $this->getVouchersForDealId($merchantid, $dealid);

		// if error return the error string
		if($data['status']['type'] == "Error")
		{
			return $data['status']['message'];
		}

		// else form a csv
		$csvstring = $this->convertDataToCSV($data);

		$filename = "vouchersForDealId" . $dealid . ".csv";
		// tell the browser it's going to be a csv file
		header('Content-Type: application/csv');
		// tell the browser we want to save it instead of displaying it
		header('Content-Disposition: attachement; filename="'.$filename.'"');
		return $csvstring;
		
	}

	public function getAllvouchersForMerchantAsCSV()
	{
		$merchantid = $_SESSION['userid'];


		// get Deals List For Merchant
		$deal = new Deal();
		$dealsForMerchant = $deal->getDealsListForMerchant($merchantid);
		// if error return the error string
		if($dealsForMerchant['status']['type'] == "Error")
		{
			return $data['status']['message'];
		}

		$dealids = Array();
		foreach($dealsForMerchant['products'] as $index => $product)
		{
			array_push($dealids, $product['id']);
		}
		$data = $this->getVouchersForDealId($merchantid, $dealids);

		// else form a csv
		$csvstring = $this->convertDataToCSV($data);

		$filename = "vouchersForMerchantId" . $merchant . ".csv";
		// tell the browser it's going to be a csv file
		header('Content-Type: application/csv');
		// tell the browser we want to save it instead of displaying it
		header('Content-Disposition: attachement; filename="'.$filename.'"');
		return $csvstring;
	}

	public function convertDataToCSV($data)
	{
		$vouchers = $data['vouchers'];
		
		$row = 1;
		$headersep = '';
		$headercsv = '';
		$csvstring = '';
		foreach ($vouchers as $key => $voucher)
		{
			$datasep = '';
			foreach($voucher as $field => $value)
			{
				if($row == 1)
				{
					$headercsv .= $headersep . $field;
					$headersep = ',';		
				}
				$csvstring .= $datasep . $value;
				$datasep = ',';
			}
			$csvstring .= "\n";
			$row++;
		}
		$csvstring = $headercsv . "\n" . $csvstring;

		return $csvstring;
	}

	public function setVoucherStatusForVoucherIds($voucherids, $status)
	{
		if($voucherids == '') $voucherids = $_REQUEST['voucherids'];
		if($status == '') $status = $_REQUEST['status'];

		$ret = Array();
		// Dont forget the status type and message
		$ret['status'] = Array();
		$ret['status']['type'] = "Success";
		$ret['status']['message'] = "Updated Successfully";
		$ret['status']['value1'] = $voucherids;
		$ret['status']['value2'] = $status;

		if(!$voucherids)
		{
			$ret['status']['type'] = "Failure";
			$ret['status']['message'] = "Voucher list is empty"; 
			return $ret;
		}
		
		try
		{
			$voucherids = explode(',', $voucherids);
			foreach($voucherids as $voucherid)
			{
				if($voucherid)
				{
					$voucher = Mage::getModel('voucher/vouchers')->load($voucherid);
					$voucher->setVoucherPaymentStatus($status);
					$voucher->save();
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

	public function getAllVouchers()
	{
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

    // Get vouchers for Receivable Consolidation
    public function getVouchersForConsolidation($orderStatus, $paymentmethod, $orderReceivableStatus, $startDate, $endDate)
    {
		$NI = new NI();
		$ret = Array();
		if($orderStatus == '') $orderStatus = $_REQUEST['orderstatus'];
		if($paymentmethod == '') $paymentmethod = $_REQUEST['paymentmethod'];
		if($orderReceivableStatus == '') $orderReceivableStatus = $_REQUEST['orderReceivableStatus'];
		if($startDate == '') $startDate = $_REQUEST['startDate'];
		if($endDate == '') $endDate = $_REQUEST['endDate'];
		$ret["CheckArray"]['StartDate'] = $startDate; 
		$ret["CheckArray"]['EndDate'] = $endDate;
		$NIreceivableStatus = $NI->getOrderReceivableStatus(); 
		$fromDate = date('Y-m-d H:i:s', strtotime($startDate));
		$toDate = date('Y-m-d H:i:s', strtotime($endDate));
		// echo "status:" . $orderStatus;
		// $fromDate = "2010-09-07 14:53:40";
		// $toDate = "2010-09-17 14:53:40";
		/* Get the collection */
		$orders = Mage::getModel('sales/order')->getCollection()
		    ->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate))
		    ->getData();
		    // ->addAttributeToFilter('status', array('eq' => 'canceled'))


		$i = 0;
		$orderCount = 0;
		$totalOrderAmount = 0;
		$totalSettledAmount = 0;
		$difference = 0;
		$totalStoreCredit = 0;
		$totalSuspenceAmount = 0;
		foreach($orders as $order)
		{	
			// Get Payment method for order
			$orderPayment = Mage::getResourceModel('sales/order_payment_collection')
								->addFieldToSelect('*')
                     			->addFieldToFilter('parent_id',$order['entity_id']);
			$paymentMethod = $orderPayment->getFirstItem()->getMethod();
			// if($i < 10) 
			// {
				/* if($paymentmethod != "All") {
					if($paymentMethod != $paymentmethod)
						continue;
				} */
				if($orderStatus != "All") {
					if($order["status"] != $orderStatus) {
						continue;
					}
				}
				if($paymentmethod != "All") {
					if($paymentMethod != $paymentmethod) {
						continue;
					}
				}
				if($orderReceivableStatus != "All") {
					if($NIreceivableStatus != $orderReceivableStatus) {
						continue;
					}
				}

				// Get Order Amounts
				$originalOrderAmount = number_format($order['base_subtotal']);
				$settledAmount = number_format($order['base_grand_total']);
				$differenceInOrderAmount = $originalOrderAmount - $settledAmount;
				$storeCredit = number_format($order['base_discount_amount']);
				if($differenceInOrderAmount != -12)
					$suspenceAmount = $differenceInOrderAmount - $storeCredit;
				

				// Total number of orders
				$totalOrderAmount = $totalOrderAmount + $originalOrderAmount;
				$ret['summary']['totalorderamount'] = $totalOrderAmount . " AED";
				// Total Settled Amount
				$totalSettledAmount = $totalSettledAmount + $settledAmount;
				$ret['summary']['totalsettled'] = $totalSettledAmount . " AED";
				// Total Difference
				$difference = $difference + $differenceInOrderAmount;
				$ret['summary']['totaldifference'] = $difference . " AED";
				// Total Store Credit 
				$totalStoreCredit = $totalStoreCredit + $storeCredit;
				$ret['summary']['totalcredit'] = $totalStoreCredit . " AED";
				// Total Suspence Amount
				$totalSuspenceAmount = $totalSuspenceAmount + $suspenceAmount;
				$ret['summary']['totalsuspence'] = $totalSuspenceAmount . " AED";
				// $currentOrderReceivableStatus = $NI->getOrderReceivableStatus($OrderID);
				// $orderdetails = Mage::getModel('sales/order')->load($orderiddd);
				// var_dump($orderdetails->getCreatedAt());
				
				try {
					////////////////////////////////////////////////
					// $formatedCreatedDate = $orderdetails->getCreatedAt();
					// $createddate = new DateTime($orderdetails);
					// $createddate = $createddate->format("d-m-Y");

					$ret['vouchers'][$orderCount]['Order Id'] = $order['increment_id'];
					$ret['vouchers'][$orderCount]['Order Date'] = $order['created_at']; 
					$ret['vouchers'][$orderCount]['Order Status'] = $order['status'];
					$ret['vouchers'][$orderCount]['Receivable Status'] = $NIreceivableStatus;
					$ret['vouchers'][$orderCount]['Payment Method'] = $paymentMethod;
					$ret['vouchers'][$orderCount]['NI Status'] = '';
					$ret['vouchers'][$orderCount]['Order Amount'] = $originalOrderAmount . " AED";
					$ret['vouchers'][$orderCount]['Setlement Amount'] = $settledAmount . " AED";
					$ret['vouchers'][$orderCount]['Difference'] = $differenceInOrderAmount . " AED";
					$ret['vouchers'][$orderCount]['Store Credit Used'] = $storeCredit . " AED";
					$ret['vouchers'][$orderCount]['Suspense Amount'] = $suspenceAmount . " AED";

					////////////////////////////////////////////////
				} catch(Exception $e) {
					$retur['status']['message'] = "Caught Exception: " . $e->getMessage();
				}
				$orderCount++;
				$i++;
				// echo $order;
			// }

		}
		return $ret;
	}
}