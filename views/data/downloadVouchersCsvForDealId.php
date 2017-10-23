<?php

require_once "api/Voucher.php";

$merchantid = $_SESSION['userid'];
$dealid = $_GET['dealid'];

print_r($_REQUEST);
echo "+++++++";
print_r($_POST);
echo "+++++++";
print_r($_GET);

$voucher = new Voucher();
$vouchers = $voucher->getVouchersForDealId($merchantid, $dealid);

print_r($vouchers);
?>

<script language='javascript'>
	// var merchantDeals = <?php echo json_encode($merchantDeals['products']); ?>;
</script>
