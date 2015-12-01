<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$evrak_id = $this->evrak_id;
$standart_id = $this->standart_id;
$url = "index.php?option=com_meslek_std_taslak&view=meslek_std_taslak&layout=tum_basvuru&format=pdf&form=5&id=".$evrak_id."&standart_id=".$standart_id;
//$url = "index.php?option=com_meslek_std_taslak&view=meslek_std_taslak&task=pdfOlustur&standart_id=".$standart_id;
echo "<h2>".PDF_MESAJ."</h2><br>";
echo "<a href='$url' target=\"_blank\">PDF için tıklayınız...</a>";

?>