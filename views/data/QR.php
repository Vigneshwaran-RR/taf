<?php

include('/api/PHP-QR-Code-Generator/src/QR/QR.php');

$qrCode = QR\QR::generate(isset($_GET['fulltext']) ? $_GET['fulltext'] : 'Hello, World!');
$qrCode->printCode();