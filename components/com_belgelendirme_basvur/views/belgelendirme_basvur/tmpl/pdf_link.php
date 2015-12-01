<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

//$evrak_id = $this->evrak_id;
$evrak_id = $_GET['evrak_id'];
$url = "index.php?option=com_belgelendirme_basvur&layout=pdf&format=pdf&form=3&id=".$evrak_id;
//echo "<h2>".PDF_MESAJ."</h2><br>";
echo "<a href='$url' target=\"_blank\">PDF için tıklayınız...</a>";
echo "<h2>Belgelendirme kuruluşları için yetkilendirilme başvuru formunu MYK'ya ulaştırınız.</h2><br>";
?>