<?php
class NI
{
	public function NIuploadReceivables($handle)
	{
		$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
        $connection->beginTransaction();
        $sql = "INSERT INTO sales_order_receivable (order_id, order_receivable_status, order_receivable_approval, order_received_amount, order_received_source, order_received_date) VALUES (?, ?, ?, ?, ?, ?)";
		try {
			while(($data = fgetcsv($handle, 1000, ',')) != FALSE) {
				// try {
					$bind = array($data[4], $data[12], "Not Approved", $data[10], "NI", $data[1]);
			        $connection->query($sql, $bind);
			        $connection->commit();
		    	// } catch(Exception $e) {
					// echo "Exception" . $e->getMessage();
			    // }
			}
		}
		catch(Exception $e){
			echo "Exception" .$e->getMessage();
		}
	}

    // Get order Receivable status
    public function getOrderReceivableStatus($OrderId) {
		// Get Order Receivable data from table 
		$OrderReceivablecollection = Mage::getModel('Companyinfo/Orderreceivable')->getCollection()
							->addFieldToFilter('order_id', array('eq' => $OrderId))
							->addFieldToSelect('order_receivable_status')
							->getData();
		$statusValues = $OrderReceivablecollection[0]['order_receivable_status'];
		$receivableStatus = explode(' - ', $statusValues);
        if($receivableStatus[1] == "Approved"){
        	$currentStatus = "received";
        } else {
        	$currentStatus = "notreceived";
        }
        return $currentStatus;
    }


}
?>