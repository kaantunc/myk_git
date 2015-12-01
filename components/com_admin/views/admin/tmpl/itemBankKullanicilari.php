
<?php 
echo $this->pageTree;
$users=$this->itemBankUsers;
$kurulus=$this->kuruluslar;

?>
<form action="index.php?option=com_admin&layout=itemBankKullanicilari&task=itemBankUsersGuncelle" method="post">
<table style="margin-left:auto; margin-right: auto;">
<thead><tr bgcolor="efefef">
<th>Joomla Id</th>
<th>Adı Soyadı</th>
<th style="width:30%;">Kuruluş Adı</th>
<th>Kullanıcı Adı</th>
<th>Şifre</th>
<th>E-Posta</th>
<th>Durumu</th>

</tr></thead>

<tbody>
<?php

for ($i=0;$i<count($users);$i++){
	echo "<tr>
	<td style=\"text-align:center; margin:2px\">".$users[$i][0]."<input type='hidden' name='id[$i]' value='".$users[$i][0]."'></td>
	<td><input name='ad[$i]' value='".$users[$i][1]."'></td>
	<td>".$users[$i][5]."</td>
	<td><input name='username[$i]' value='".$users[$i][2]."'></td>
	<td><input name='sifre[$i]' value=''></td>
	<td><input name='eposta[$i]' value='".$users[$i][3]."'></td>
	<td style='text-align:center;'><input type='checkbox' name='durum[$i]' value='aktif'";

	if ($users[$i][4]==0){
		echo " checked";
	}

	echo "></td>
	</tr>";
}

?>
<tr bgcolor="efefef"><td colspan=7 style="text-align:center;"><input type="submit" value="Kaydet"></td></tr>
</tbody>
</table>
</form>
<br><br>
<center>
<form action="index.php?option=com_admin&layout=itemBankKullanicilari&task=itemBankUsersEkle" method="post">
<table>
<tr><td><label>Kuruluş</label> </td><td>
<select name="kurulus"/>
<?php 
foreach ($kurulus as $satir){
	echo "<option value='".$satir["USER_ID"]."'>".$satir["KURULUS_ADI"]."</option>";
}
?>
</select>

</td></tr>
<tr><td><label>Adı Soyadı:</label></td><td> <input type="text" name="name"/></td></tr>
<tr><td><label>Kullanıcı Adı:</label></td><td> <input type="text" name="username"/></td></tr>
<tr><td><label>Şifre:</label></td><td> <input type="text" name="password"/></td></tr>
<tr><td><label>E-Posta:</label></td><td> <input type="text" name="email"/></td></tr>
<!-- tr><td><label>Alanı:</label></td><td> <input type="checkbox" name="ms" value='1' checked/>Meslek Standartları &nbsp& <input type="checkbox" name="yet" value='1' checked/>Yeterlilik</td></tr-->
</table>
&nbsp;&nbsp;
<input type="submit" value="Ekle">
</form>
</center>
