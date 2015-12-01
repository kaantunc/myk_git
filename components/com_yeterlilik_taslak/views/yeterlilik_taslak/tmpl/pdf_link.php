<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$evrak_id		= $this->evrak_id;
$yeterlilik_id  = $this->yeterlilik_id;
$url = "index.php?option=com_yeterlilik_taslak&view=yeterlilik_taslak&layout=pdf&format=pdf&form=5&id=".$evrak_id."&yeterlilik_id=".$yeterlilik_id;
echo "<h2>".PDF_MESAJ."</h2><br>";
echo "<a href='$url' target=\"_blank\">PDF için tıklayınız...</a>";

?>