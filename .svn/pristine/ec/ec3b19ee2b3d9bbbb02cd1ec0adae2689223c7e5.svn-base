
<?php 
echo $this->pageTree;
$users=$this->sektorSorumlulari;

?>
<form action="index.php?option=com_admin&layout=sektorSorumlusu&task=sektorSorumlusuGuncelle" method="post">
<table style="margin-left:auto; margin-right: auto;">
<thead><tr bgcolor="efefef">
<th>Joomla Id</th>
<th>TgUserId</th>
<th>Adı Soyadı</th>
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
	<td><input name='tgUserName[$i]' value='".$users[$i][1]."' size=5></td>
	<td><input name='ad[$i]' value='".$users[$i][2]."'></td>
	<td><input name='username[$i]' value='".$users[$i][3]."'></td>
	<td><input name='sifre[$i]' value=''></td>
	<td><input name='eposta[$i]' value='".$users[$i][4]."'></td>
	<td style='text-align:center;'><input type='checkbox' name='durum[$i]' value='aktif'";

	if ($users[$i][5]==0){
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
DYS tablosundaki gercek TgUserId'nin onune 100 eklenmeli
<form action="index.php?option=com_admin&layout=sektorSorumlusu&task=sektorSorumlusuEkle" method="post">
<table>
<tr><td><label>TgUserId:</label> </td><td><input type="text" name="tguserid"/></td></tr>
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
