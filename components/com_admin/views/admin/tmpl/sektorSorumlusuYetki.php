<style>
.rotate {

text-align: center;
vertical-align: middle;
width: 16px;
margin: 0px;
padding: 0px;
padding-left: 3px;
padding-right: 3px;
padding-top: 10px;
white-space: nowrap;
-webkit-transform: rotate(-90deg);
-moz-transform: rotate(-90deg);
}
</style>
<?php 
echo $this->pageTree;
$yetkiler=$this->SSYetkileri;

$users=$yetkiler[users];
$yetkiler=$yetkiler[yetki];
$sektorler=$this->sektorler;


echo "
<table style='padding-top:110px;'>
<form action=\"index.php?option=com_admin&layout=sektorSorumlusuYetki&task=yetkiKaydet\" method=\"post\" id=\"yonetimKuruluForm\">
<thead style='width:885px;display:block'>
<tr><th style='width:155px;'>İsim</th>";
	echo "<th><div class='rotate'><font color='#990000'>Yetili Sektör Sorumlusu</font></div></th>";
foreach ($sektorler as $row){
	echo "<th><div class='rotate'>".mb_substr($row[SEKTOR_ADI],0,20,"utf-8")."</div></th>";
	$sektorArr[]=$row[SEKTOR_ID];
	$sektorArrAd[]=$row[SEKTOR_ADI];
}

echo "</tr>
</thead>
<tbody style='overflow:auto; height:300px;width:900px;display:block'>";
$colspan=count($sektorArr)+2;
echo "<tr bgcolor=dedeff><td colspan=".$colspan." style='font-weight:bold;text-align:center;background-color:#dfdfdf;'>Meslek Standartları</td></tr>";

foreach ($users as $row)
{
	echo '<tr bgcolor=dedeff id="'.$row[0].'">';
	echo "<td style='width:160px;'>".mb_substr($row[1],0,21,"utf-8")."</td>";

	echo '<td title="Yetkili Sektör Sorumlusu"  align=center style="width:22px;background-color:#ff9999;"><input type="checkbox" id="2-'.$row[0].'-0" name="id[]" value="2-'.$row[0].'-0-'.$row[2].'"/></td>';
	
	for($i=0; $i<count($sektorArr); $i++)
	{
		echo '<td title="'.$sektorArrAd[$i].'"  align=center style="width:22px"><input type="checkbox" id="2-'.$row[0].'-'.$sektorArr[$i].'" name="id[]" value="2-'.$row[0].'-'.$sektorArr[$i].'-'.$row[2].'"/></td>';
	}

	echo '</tr>';
}
echo "<tr bgcolor=deffde><td colspan=".$colspan." style='font-weight:bold;text-align:center;background-color:#dfdfdf;'>Yeterlilikler</td></tr>";
foreach ($users as $row)
{
	echo '<tr bgcolor=deffde id="'.$row[0].'">';
	echo "<td style='width:160px;'>".mb_substr($row[1],0,21,"utf-8")."<input type='hidden' name='userid[]' value='".$row[2]."'></td>";
	echo '<td title="Yetkili Sektör Sorumlusu"  align=center style="width:22px;background-color:#ff9999;"><input type="checkbox" id="1-'.$row[0].'-0" name="id[]" value="1-'.$row[0].'-0-'.$row[2].'"/></td>';
	
	for($i=0; $i<count($sektorArr); $i++)
	{
		echo '<td title="'.$sektorArrAd[$i].'" align=center style="width:22px"><input type="checkbox" id="1-'.$row[0].'-'.$sektorArr[$i].'"  name="id[]" value="1-'.$row[0].'-'.$sektorArr[$i].'-'.$row[2].'" /></td>';
	}
	
	echo '</tr>';
}

echo "</tbody>";
echo "</table>
<center><input type='submit' value='Kaydet'/></center>
</form>";



echo '<script>';
foreach ($yetkiler as $row){
			echo ' jQuery("#'.$row[YETKI_ALANI].'-'.$row[USER_ID].'-'.$row[SEKTOR_ID].'").attr("checked", "checked");   
';
}
echo '</script>';

// echo "<pre>";
// print_r($id);
// echo "</pre>";
?>

