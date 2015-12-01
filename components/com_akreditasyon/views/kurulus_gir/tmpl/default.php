<?php
defined('_JEXEC') or die('Restricted access');

?>

<script type="text/javascript">

dTables.kurulusGir = new Array(
		new Array("text","required","6"),
		/*new Array("text","required","25"),*/
		new Array( "combo",
				new Array(
			new Array("Seçiniz", "Seçiniz")<?php echo $this->kurCombo?>),"comboReq"),
			new Array( "combo",
					new Array(
				new Array("Seçiniz", "Seçiniz")<?php echo $this->yetkiCombo?>))

);

function createTables(){

	var headers = new Array(
			'Sıra No',
			'Denetlenecek Kuruluş',
			'Yetki'/*,
			'Yeterlilik',
			'Sınav Kapsamı'*/
	);
	
	//yeterlilikleriAl();
		createTable("kurulusGir",
				headers
	);
	patchSatirEkle("kurulusGir", headers,"kurulusGir");
	//patchEkleForDatePick("sinavTakvimi", 2);
	
}

</script>

<div class="sinavGirisBaslik">Akredite Edilen Kuruluş Listesi</div>

<form id="kurulusGirForm" action="?option=com_akreditasyon&task=kurulusKaydet" method="post" onsubmit="return validate('kurulusGirForm')">
	<input name="mode" value="taslak" type="hidden"></input>

	<div id="kurulusGir_div"></div>
	<br />
	<input type="submit" value="Kaydet" />
</form>
