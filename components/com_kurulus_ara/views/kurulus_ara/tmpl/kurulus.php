<style>
.anaDiv{
	display:inline-block;
	width:100%;
	margin-top:5px;
	margin-bottom:10px;
}
.btnYeniYetki{
	color:#ffffff;
	background-color:#71CEED;
	font-size:medium;
	padding:5px;
	border-radius:10px;
	cursor: pointer;
}
.div50{
	width:49%;
	display:inline-block;
}
.div70H{
	width:69%;
	display:inline-block;
	font-size: 18px;
	font-weight: bold;
}
.div30H{
	width:29%;
	display:inline-block;
	font-size: 16px;
	font-weight: bold;
}
.divBorder{
	border: 1px solid #1C617C;;
	width:100%;
}
.tableKur td{
	padding:15px;
}
.icerikH{
	font-size: 16px;
/* 	font-weight: bold; */
}
.baslikH{
	font-size: 15px;
	font-weight: bold;
}
</style>
<?php 
$kurs = $this->kurs;
?>
<div class="anaDiv">
<?php echo $this->sayfaLink;?>
</div>
<div class="anaDiv" style="text-align:center;">
	<div class="div50">
		<img style="height:200px;max-width: 100%" src="index.php?dl=kurulus_logo/<?php echo $kurs['USER_ID'];?>/<?php echo $kurs['LOGO'];?>">
	</div>
</div>
<div class="anaDiv" style="text-align: center;">
	<h2><u><?php echo $kurs['KURULUS_ADI'];?></u></h2>
</div>
<?php if($kurs['ASKI']){?>
<div class="anaDiv text-center" style="margin-top:-20px">
	<img src="<?php echo SITE_URL;?>images/yetkisi_kaldirildi.gif" />
</div>
<?php }?>
<div class="divBorder">
	<table width="100%" class="tableKur">
		<tr bgcolor="#efefef">
			<td width="30%"><span class="baslikH">Kuruluş Adı:</span></td>
			<td width="70%"><span class="icerikH"><?php echo $kurs['KURULUS_ADI'];?></span></td>
		</tr>
		<tr>
			<td width="30%"><span class="baslikH">Kuruluş Adresi:</span></td>
			<td width="70%"><span class="icerikH"><?php echo $kurs['KURULUS_ADRESI'].' '.$kurs['KURULUS_POSTA_KODU'];?></span></td>
		</tr>
		<tr bgcolor="#efefef">
			<td width="30%"><span class="baslikH">Kuruluş Telefon Numarası:</span></td>
			<td width="70%"><span class="icerikH"><?php echo $kurs['KURULUS_TELEFON'];?></span></td>
		</tr>
		<tr>
			<td width="30%"><span class="baslikH">Kuruluş Faks Numarası:</span></td>
			<td width="70%"><span class="icerikH"><?php echo $kurs['KURULUS_FAKS'];?></span></td>
		</tr>
		<tr bgcolor="#efefef">
			<td width="30%"><span class="baslikH">Kuruluş İnternet Adresi:</span></td>
			<td width="70%"><span class="icerikH"><a href="<?php echo $kurs['KURULUS_WEB'];?>" target="_blank"><?php echo $kurs['KURULUS_WEB'];?></span></td>
		</tr>
		<tr>
			<td width="30%"><span class="baslikH">Kuruluş E-Posta Adresi:</span></td>
			<td width="70%"><span class="icerikH"><?php echo $kurs['KURULUS_EPOSTA'];?></span></td>
		</tr>
		<tr bgcolor="#efefef">
			<td width="30%"><span class="baslikH">Kuruluş Yetkilendirme Kodu:</span></td>
			<td width="70%"><span class="icerikH"><?php echo $kurs['YBKODU'];?></span></td>
		</tr>
		<tr>
			<td width="30%"><span class="baslikH">Kuruluş Yetkilendirilme Tarihi:</span></td>
			<td width="70%"><span class="icerikH"><?php echo $this->yetTarih;?></span></td>
		</tr>
	</table>
</div>