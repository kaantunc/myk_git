<?php
defined('_JEXEC') or die('Restricted access');

?>
<script type="text/javascript">

var authorized = 0;

jQuery(document).ready(function(){
	var tableName = "gorusTable";
	var headers = new Array ('Sıra No','Standart üzerindeki<br />yer (bölüm, satır no,<br />sayfa no)','Görüş ve Öneriler'/*,'Değerlendirme','Standart üzerinde<br />yapılan düzeltme'*/);
	createTable(tableName, headers);
	patchSatirEkle(tableName, headers, tableName);
});

dTables.gorusTable = new Array(
		new Array("text","","4"),
		new Array("text","","50"),
		new Array("textarea","","6","60")/*,
		new Array("text",""),
		new Array("text","")*/
);


</script>
<form action="?option=com_meslek_std_taslak&amp;task=gorusKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_gorus_bildir"
	onSubmit = "return validate('ChronoContact_gorus_bildir')"
	name="ChronoContact_gorus_bildir">

<input type="hidden" name="standartId" value="<?php echo $this->standartId?>"></input>
<input type="hidden" name="seviyeId" value="<?php echo $this->seviyeId?>"></input>

<table>
	<tbody>
		<tr>
			<td width="250">Meslek Standardı Adı</td>
			<td><input type="text"
				name="std_ad" size="60" value="<?php echo $this->standartAdi?>" readonly="readonly"></td>
		</tr>
		<tr>
			<td width="250">Meslek Standardı Seviyesi</td>
			<td><input type="text"
				name="std_seviye" size="12" value="<?php echo $this->seviyeAdi?>" readonly="readonly"></td>
		</tr>
		<tr>
			<td width="250">Son Görüş Verme Tarihi</td>
			<td><input type="text"
				name="son_gorus_tarihi" size="12"  value="<?php echo $this->sonGorusTarihi?>" readonly="readonly"></td>
		</tr>
		<tr>
			<td width="250">Görüş Bildiren Kuruluş/Kişi/Unvanı</td>
			<td><input type="text"
				name="unvan" size="60" class=""></td>
		</tr>
		<tr>
			<td width="250">E-posta</td>
			<td><input type="text"
				name="e_posta" size="60" class="e-mail"></td>
		</tr>
		<tr>
			<td width="250">Telefon</td>
			<td><input type="text"
				name="telefon" size="12" class="required numeric"></td>
		</tr>
		<tr>
			<td width="250">Faks</td>
			<td><input type="text"
				name="faks" size="12" class="numeric"></td>
		</tr>
		<tr>
			<td width="250"><?php echo JText::_("CAPTCHA_INFO");?></td>
			<td>
				<img src="index.php?option=com_egbcaptcha&width=150&height=50&characters=5" />
				<div class="captchaInfo"><?php echo JText::_("CAPTCHA_PIC_INFO");?></div>
				<input id="verify_code" name="verify_code" type="text" />
			</td>
		</tr>
	</tbody>
</table>

<br />
<br />
<div id="gorus_info">
Bu form meslek standardı hazırlama sürecinde şeffaflığı ve katılımcılığı artırmak, aynı zamanda objektif ve ulusal platformda kabul gören meslek standartları oluşturabilmek amacıyla ilgili tarafların taslak meslek standardı üzerindeki görüşlerinin alınması ve değerlendirilmesi için kullanılmaktadır. 
</div>

<div id="gorusTable_div"></div>
<br />
<input type="submit" value="Gönder"></input>
<br />
<br />
<a href="javascript:history.go(-1)">Geri</a>
</form>