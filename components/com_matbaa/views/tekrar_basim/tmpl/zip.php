<?php
$basimId = $this->basimId;
header('Content-type: application/zip');
header('Content-Disposition: attachment; filename="'.$basimId.'.zip"');
readfile(EK_FOLDER."sinavBelgeTekrarQRcode/".$basimId."/".$basimId.".zip");
exit();