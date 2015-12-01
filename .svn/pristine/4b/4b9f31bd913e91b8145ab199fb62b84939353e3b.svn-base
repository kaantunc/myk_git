<?php
$matbaaId = $this->matbaaId;
header('Content-type: application/zip');
header('Content-Disposition: attachment; filename="'.$matbaaId.'.zip"');
readfile(EK_FOLDER."sinavBelgeQRcode/".$matbaaId."/".$matbaaId.".zip");
exit();