
<?php 
echo $this->pageTree;
$sektorler=$this->tumsektorler;
?>


<form action="index.php?option=com_admin&layout=sektorIslemleri&task=sektorDurumGuncelle" method="post">
<table cellpadding=3 cellspacing=1 bgcolor="999999" style="margin-left:auto; margin-right: auto;">
<thead><tr bgcolor="efefef">
<th>Sektör Adı</th>
<th>Durumu</th>
</tr></thead>

<tbody>
<?php 

foreach ($sektorler as $satir){
	echo "<tr bgcolor='ffffff'><td>".$satir[SEKTOR_ADI]."</td><td style='text-align:center;'><input type='checkbox' name='id[]' value='".$satir[SEKTOR_ID]."'";
	
	if ($satir[SEKTOR_DURUM]==1){echo " checked";}
	
	echo "></td></tr>";
}

?>
<tr bgcolor="efefef"><td colspan=2 style="text-align:center;"><input type="submit" value="Kaydet"></td></tr>
</tbody>
</table>
</form>
<br><br>
<center>
<form action="index.php?option=com_admin&layout=sektorIslemleri&task=sektorEkle" method="post">
<label>Yeni Sektör:</label> <input type="text" name="sektorName"/>
&nbsp;&nbsp;
<input type="submit" value="Ekle">
</form>
</center>
