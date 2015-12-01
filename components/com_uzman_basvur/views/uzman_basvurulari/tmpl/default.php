<?php
if ($_GET["action"]==""){
$basvurular = $this->bekleyenbasvurular;
$title="Bekleyen Başvurular";
} else if ($_GET["action"]=="onayli"){
	$basvurular = $this->onaylanmisbasvurular;
$title="Onaylanmış Başvurular";
} else {
	$basvurular = $this->redddedilmisbasvurular;
$title="Reddedilmiş Başvurular";
}
?>
<style>
td{
padding:2px;
}
thead tr td,.incele{
text-align:center;
font-weight:bold
}
.tckimlik{
text-align:center;
}
</style>
<center><h1><?php echo $title;?></h1></center>
<p>
<table align=center style="width:100%" bgcolor="#aaaaaa"  cellspacing=1>
<thead>
<tr bgcolor="#efefef">
<td>TC Kimlik No</td>
<td>Adı Soyadı</td>
<td>E-Posta Adresi</td>
<td>Telefon</td>
<td>Detay</td>
</tr>
</thead>
<tbody>


<?php 
if (count($basvurular)>0){
	foreach($basvurular as $row){
		echo "<tr bgcolor='#ffffff'><td class=tckimlik>".$row[TC_KIMLIK]."</td><td>".$row[AD]." ".$row[SOYAD]."</td><td>".$row[EPOSTA]."</td><td>".$row[TEL]."</td><td class=incele><a href=index.php?option=com_uzman_basvur&tc_kimlik=".$row[TC_KIMLIK].">İncele</a> || <a href=index.php?option=com_uzman_basvur&format=pdf&layout=pdf&tc_kimlik=".$row[TC_KIMLIK]." target='_blank'>PDF</a></td></tr>";
		
	}
} else {
	echo "<tr bgcolor='#ffffff'><td colspan=5 align=center>Kayıtlı Bekleyen başvuru yok</td></tr>";
}
?>
</tbody>
</table>
