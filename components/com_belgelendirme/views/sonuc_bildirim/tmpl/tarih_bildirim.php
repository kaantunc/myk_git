<?php 
include ('libraries/phpqrcode/qrlib.php');

QRcode::png('http://google.com','c://qrgoogle.png',QR_ECLEVEL_H,3,1);
?>