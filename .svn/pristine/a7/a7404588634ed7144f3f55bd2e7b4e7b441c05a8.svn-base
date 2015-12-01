<?php
// defined('_JEXEC') or die('Restricted access');
// require_once('libraries/form/form.php');
// require_once('libraries/form/form_config.php');
// require_once('libraries/form/form_parametrik.php');

$db = & JFactory::getOracleDBO();
$tcKimlikNo=$_GET["tckn"];
$yetkod=substr($_GET["yn"],0,-1);

$yetkod=explode(",",$yetkod);

foreach ($yetkod as $row){
	$sqlek.="BELGENO like '%".$row."%' or ";
}
$sqlek=substr($sqlek,0,-4);
$sql = "select * from M_BELGE_SORGU where TCKIMLIKNO='".$tcKimlikNo."' and (".$sqlek.") and BELGEDURUMU = 1 and ROWNUM = 1 and  GECERLILIK_TARIHI>=sysdate order by GECERLILIK_TARIHI DESC";

$row= $db->prep_exec($sql, array());
// print_r($row);
// print_r(array_flip($row));

// $xml = new SimpleXMLElement('<xml/>');
// array_walk_recursive(array_flip($row[0]), array ($xml, 'addChild'));
// print $xml->asXML();

echo json_encode($row);

?>