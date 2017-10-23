<?php

require_once "api/MerchantInfo.php";
require_once "api/Voucher.php";
require_once "api/Deal.php";

$merchantid = $_SESSION['userid'];

$merchantInfo = new MerchantInfo();
$merchantdata = $merchantInfo->getRecordForUserid($merchantid);

$merchantDetails = $merchantInfo->getAllMerchantsDetails(); 
// var_dump($merchantDetails[1]);

$deals = new Deal();
$merchantDeals = $deals->getDealsListForMerchant(1);
// var_dump($merchantDeals);
// Get order status
// $orderstatus = $deals->getOrderStatus();
// var_dump($orderstatus);
?>

<script language='javascript'>
	var firstMerchant = <?php echo json_encode($merchantdata); ?>;
	var merchantDeals = <?php echo json_encode($merchantDeals['products']); ?>;
	var merchantName = <?php echo json_encode($merchantDetails); ?>;
</script>
