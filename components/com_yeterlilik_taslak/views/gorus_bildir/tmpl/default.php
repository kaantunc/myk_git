<?php
defined('_JEXEC') or die('Restricted access');

?>
<script type="text/javascript">

var authorized = 0;

jQuery(document).ready(function(){
	var tableName = "gorusTable";
	var headers	  = new Array ('Sira No','Yeterlilik üzerindeki<br />yer (bölüm, satir no,<br />sayfa no)','Görüs ve Öneriler'/*,'Degerlendirme','Standart üzerinde<br />yapilan düzeltme'*/);
	createTable(tableName, headers);
	//patchSatirEkleGorus("gorusTable");
	patchSatirEkle(tableName, headers, tableName);
});

dTables.gorusTable = new Array(
		new Array("text","","4"),
		new Array("text",""),
		new Array("textarea","")/*,
		new Array("text",""),
		new Array("text","")*/
);

</script>
<form action="?option=com_yeterlilik_taslak&task=gorusKaydet" method="POST">

<input type="hidden" name="yeterlilikId" value="<?php echo $this->yeterlilikId?>"></input>
<input type="hidden" name="seviyeId" value="<?php echo $this->seviyeId?>"></input>

<table>
	<tbody>
		<tr>
			<td width="250">Yeterlilik Adi</td>
			<td><input type="text"
				name="yet_ad" size="25" value="<?php echo $this->yeterlilikAdi?>" readonly="readonly"></td>
		</tr>
		<tr>
			<td width="250">Yeterlilik Seviyesi</td>
			<td><input type="text"
				name="yet_seviye" size="12" value="<?php echo $this->seviyeAdi?>" readonly="readonly"></td>
		</tr>
		<tr>
			<td width="250">Son Görüs Verme Tarihi</td>
			<td><input type="text"
				name="son_gorus_tarihi" size="12" value="<?php echo $this->sonGorusTarihi?>" readonly="readonly"></td>
		</tr>
		<tr>
			<td width="250">Görüs Bildiren Kurulus/Kisi/Unvani</td>
			<td><input type="text"
				name="unvan" size="20" class="required"></td>
		</tr>
		<tr>
			<td width="250">E-posta</td>
			<td><input type="text"
				name="e_posta" size="20" class="required"></td>
		</tr>
		<tr>
			<td width="250">Telefon</td>
			<td><input type="text"
				name="telefon" size="12" class="required irtibatTelFax"></td>
		</tr>
		<tr>
			<td width="250">Faks</td>
			<td><input type="text"
				name="faks" size="12" class="required irtibatTelFax"></td>
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
Bu form yeterliligin hazirlama sürecinde seffafligi ve katilimciligi artirmak, ayni zamanda objektif ve ulusal platformda kabul gören yeterlilikler olusturabilmek amaciyla ilgili taraflarin taslak yeterlilik üzerindeki görüslerinin alinmasi ve degerlendirilmesi için kullanilmaktadir. 
</div>

<div id="gorusTable_div"></div>
<br />
<input type="submit" value="Gönder"></input>
<br />
<br />
<a href="javascript:history.go(-1)">Geri</a>
</form>

<script>
jQuery(".irtibatTelFax").live("focus",function (){
	jQuery(this).mask("(999) 999-9999");
})
</script>