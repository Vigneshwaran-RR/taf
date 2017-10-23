<?php
require_once "api/NI.php";
require_once "api/PayPal.php";
require_once "api/COD.php";
	
	$btn_name = $_REQUEST['UploadBtn'] ;
	$NI = new NI();
	$PayPal = new PayPal();
	$COD = new COD();

	if($btn_name == "NIUploadBtn") {
		try {
			if($_FILES['NIFile']['name']) {
				$handle =fopen($_FILES['NIFile']['tmp_name'], 'r');
				$NI->NIuploadReceivables($handle);
			}
		} catch(Exception $e) {
			echo "Caught Exception: Error " . $e->getMessage();
		}
	} elseif($btn_name == "PayPalUploadBtn") {
		try {
			if($_FILES['PayPalFile']['name']) {
				$handle =fopen($_FILES['PayPalFile']['tmp_name'], 'r');
				$PayPal->PayPaluploadReceivables($handle);
			}
		} catch(Exception $e) {
			echo "Caught Exception: Error " . $e->getMessage();
		}
	} else {
		try {
			if($_FILES['CODFile']['name']) {
				$handle =fopen($_FILES['CODFile']['tmp_name'], 'r');
				$COD->CODuploadReceivables($handle);
			}
		} catch(Exception $e) {
			echo "Caught Exception: Error " . $e->getMessage();
		}
	}