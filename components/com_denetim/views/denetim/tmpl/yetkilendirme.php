<?php echo $this->sayfaLink;?>
<form id="yetkilendirmeForm" method="post" action="index.php?option=com_denetim&task=yetkilendirmeyiKaydet&denetim_id=<?php echo $_GET['denetim_id']; ?>">

<h2 style="padding-bottom:5px;">DENETİM SONUCU BELGELENDİRME YETKİLENDİRMESİ - <?php echo denetimIDdenKurulusAdiGetir($_GET['denetim_id']);?></h2>

<font style="color:#161862">
Yapılan denetim sonucu belgelendirme yetkisi verilecek ulusal yeterlilikleri/yeterlilik birimlerini seçiniz. 
<br>Tıklanamayan yeterlilik birimleri bir başka yetkilendirmede yetkilendirilmiştir. 
</font>
<br>
<br>
<?php

$yeniBirimler = $this->sinavYetkisiVerilecekBirimler;
$eskiBirimler = $this->sinavYetkisiVerilecekBirimler_EskiFormattakiYeterlilik;


////////////// YENİ BİRİMLEEEEEER //////////////////////////////////////////
$yetkilendirilecekBirimler = $yeniBirimler;
//$yetkilendirilecekBirimIDleri = $this->sinavYetkisiVerilecekBirimIDleri;
$yetkilendirilmisBirimler = $this->sinavYetkisiVerilmisBirimler;
$currentYeterlilikID = 0;
for($i=0; $i<count($yetkilendirilecekBirimler); $i++)
{	
	$currentBirimID = $yetkilendirilecekBirimler[$i]['BIRIM_ID'];
	
	$yeniYeterlilik = ($yetkilendirilecekBirimler[$i]['YETERLILIK_ID'] != $currentYeterlilikID) ? true : false; 
	if($yeniYeterlilik==true)
	{
		$currentYeterlilikID = $yetkilendirilecekBirimler[$i]['YETERLILIK_ID'];
		
		$yeterlilikChecked = (yeterlilikCheckboxuCheckedOlmaliMi($yetkilendirilecekBirimler, $yetkilendirilmisBirimler, $i)) ? ' checked="checked"  ' : '';
		
		echo '<div style="background-color:#E4F2F9; width:100%; float:left;">
		<input '.$yeterlilikChecked.'  type="checkbox" 
			class="yeterlilikCheckbox yeterlilik-'.$currentYeterlilikID.'" value="'.$currentYeterlilikID.'">
		&nbsp;'.FormFactory::toUpperCase($yetkilendirilecekBirimler[$i]['YETERLILIK_ADI']).' - SEVIYE '.$yetkilendirilecekBirimler[$i]['SEVIYE_ID'].' - REVİZYON '.$yetkilendirilecekBirimler[$i]['REVIZYON'].
		'</div>';
		
	}
	
	//$checked = (in_array($currentBirimID, $yetkilendirilmisBirimler)) ? ' checked="checked" ' : '';
	if($yetkilendirilecekBirimler[$i]['ZORUNLU'] == 1){
		echo '<div style="width:100%; float:left;">
				<input style="float:left; margin-left:15px;" type="checkbox" name="birimCheckbox[]"
					class="birimCheckbox yeterlilikBirimi-'.$currentYeterlilikID.' birim-'.$currentBirimID.' zorunlu"
					value="'.$currentBirimID.'">
				<font style="float:left;">&nbsp;'.$yetkilendirilecekBirimler[$i]['BIRIM_KODU'].' - '.$yetkilendirilecekBirimler[$i]['BIRIM_ADI'].' - Seviye '.$yetkilendirilecekBirimler[$i]['BIRIM_SEVIYE'].'</font>
				<div style="float:right;" id="yetkiVerilmeTarihiDiv-'.$currentBirimID.'">&nbsp;</div>
				<div style="float:right;" id="yetkiAlinmaTarihiDiv-'.$currentBirimID.'">&nbsp;</div>
		</div>';
	}
	else{
		echo '<div style="width:100%; float:left;">
				<input style="float:left; margin-left:15px;" type="checkbox" name="birimCheckbox[]"
					class="birimCheckbox yeterlilikBirimi-'.$currentYeterlilikID.' birim-'.$currentBirimID.'"
					value="'.$currentBirimID.'">
				<font style="float:left;">&nbsp;'.$yetkilendirilecekBirimler[$i]['BIRIM_KODU'].' - '.$yetkilendirilecekBirimler[$i]['BIRIM_ADI'].' - Seviye '.$yetkilendirilecekBirimler[$i]['BIRIM_SEVIYE'].'</font>
				<div style="float:right;" id="yetkiVerilmeTarihiDiv-'.$currentBirimID.'">&nbsp;</div>
				<div style="float:right;" id="yetkiAlinmaTarihiDiv-'.$currentBirimID.'">&nbsp;</div>
		</div>';
	}
	
	
}///////////////////// YENİ BİRİMLER BİTEEEEEEER //////////////////////////

/////////////// ESKİ BİRİMLEEEEEEER  ///////////////////////////////////
$yetkilendirilecekBirimler =  $eskiBirimler;
//$yetkilendirilecekBirimIDleri = $this->sinavYetkisiVerilecekBirimIDleri;
$yetkilendirilmisBirimler = $this->sinavYetkisiVerilmisBirimler;
$currentYeterlilikID = 0;
for($i=0; $i<count($yetkilendirilecekBirimler); $i++)
{
	$currentBirimID = $yetkilendirilecekBirimler[$i]['BIRIM_ID'];

	$yeniYeterlilik = ($yetkilendirilecekBirimler[$i]['YETERLILIK_ID'] != $currentYeterlilikID) ? true : false;
	if($yeniYeterlilik==true)
	{
		$currentYeterlilikID = $yetkilendirilecekBirimler[$i]['YETERLILIK_ID'];

		$yeterlilikChecked = (yeterlilikCheckboxuCheckedOlmaliMi($yetkilendirilecekBirimler, $yetkilendirilmisBirimler, $i)) ? ' checked="checked"  ' : '';

		echo '<div style="background-color:#E4F2F9; width:100%; float:left;">
		<input '.$yeterlilikChecked.'  type="checkbox"
		class="yeterlilikCheckbox yeterlilik-'.$currentYeterlilikID.'" value="'.$currentYeterlilikID.'">
		&nbsp;'.FormFactory::toUpperCase($yetkilendirilecekBirimler[$i]['YETERLILIK_ADI']).' - SEVIYE '.$yetkilendirilecekBirimler[$i]['SEVIYE_ID'].' - REVİZYON '.$yetkilendirilecekBirimler[$i]['REVIZYON'].
		'</div>';

	}

	//$checked = (in_array($currentBirimID, $yetkilendirilmisBirimler)) ? ' checked="checked" ' : '';
	if($yetkilendirilecekBirimler[$i]['YETERLILIK_ZORUNLU'] == 1){
		echo '<div style="width:100%; float:left;">
	<input style="float:left; margin-left:15px;" type="checkbox" name="birimCheckbox_EskiBirim[]"
	class="birimCheckbox yeterlilikBirimi-'.$currentYeterlilikID.' eskiBirim-'.$currentBirimID.' birim-'.$currentBirimID.' zorunlu" value="'.$currentBirimID.'">
	<font style="float:left;">&nbsp;'.$yetkilendirilecekBirimler[$i]['BIRIM_KODU'].' - '.$yetkilendirilecekBirimler[$i]['BIRIM_ADI'].' - Seviye '.$yetkilendirilecekBirimler[$i]['BIRIM_SEVIYE'].'</font>
	<div style="float:right;" id="yetkiVerilmeTarihiDiv-'.$currentBirimID.'">&nbsp;</div>
	<div style="float:right;" id="yetkiAlinmaTarihiDiv-'.$currentBirimID.'">&nbsp;</div>
	</div>';
	}
	else{
		echo '<div style="width:100%; float:left;">
	<input style="float:left; margin-left:15px;" type="checkbox" name="birimCheckbox_EskiBirim[]"
	class="birimCheckbox yeterlilikBirimi-'.$currentYeterlilikID.' eskiBirim-'.$currentBirimID.' birim-'.$currentBirimID.'" value="'.$currentBirimID.'">
	<font style="float:left;">&nbsp;'.$yetkilendirilecekBirimler[$i]['BIRIM_KODU'].' - '.$yetkilendirilecekBirimler[$i]['BIRIM_ADI'].' - Seviye '.$yetkilendirilecekBirimler[$i]['BIRIM_SEVIYE'].'</font>
	<div style="float:right;" id="yetkiVerilmeTarihiDiv-'.$currentBirimID.'">&nbsp;</div>
	<div style="float:right;" id="yetkiAlinmaTarihiDiv-'.$currentBirimID.'">&nbsp;</div>
	</div>';
	}
}
/////////////// ESKİ BİRİMLER BİTEEEEEEEEEEER /////////////////////////

if(count(array_merge($yeniBirimler, $eskiBirimler))== 0)
	echo 'Belgelendirme Yetkisi İçin Başvurulmuş Bir Yeterlilik Yok<br><br>';
else
	echo '<br><input type="submit" value="Kaydet" >';




echo '<script>';

//// YENİLER //////////////////////
$alinmisYetkiler = $this->sinavYetkisiAlinmisBirimlerVeYetkiTarihleri;
for($i=0; $i<count($alinmisYetkiler); $i++)
{
	echo 'jQuery("#yetkiAlinmaTarihiDiv-'.$alinmisYetkiler[$i]['BIRIM_ID'].'").html("&nbsp;&nbsp;('.$alinmisYetkiler[$i]['YETKININ_GERI_ALINDIGI_TARIH'].' tarihli denetimde yetkisi alındı)"); ';
}


$verilmisYetkiler = $this->sinavYetkisiVerilmisBirimlerVeYetkiTarihleri;
for($i=0; $i<count($verilmisYetkiler); $i++)
{
	echo 'jQuery(".birim-'.$verilmisYetkiler[$i]['BIRIM_ID'].'").attr("checked","checked"); ';
	echo 'jQuery(".birim-'.$verilmisYetkiler[$i]['BIRIM_ID'].'").prop("disabled",false); ';
	echo 'jQuery("#yetkiVerilmeTarihiDiv-'.$verilmisYetkiler[$i]['BIRIM_ID'].'").html("&nbsp;&nbsp;('.$verilmisYetkiler[$i]['YETKININ_VERILDIGI_TARIH'].' tarihli denetimde yetki verildi)"); ';
	echo 'jQuery("#yetkiAlinmaTarihiDiv-'.$verilmisYetkiler[$i]['BIRIM_ID'].'").html(""); ';
	echo 'jQuery("#yetkilendirmeForm").append("<input type=\'hidden\' name=\'oncedenYetkiVerilmisBirimler[]\' class=\'oncedenYetkiVerilmisBirimler\' value=\''.$verilmisYetkiler[$i]['BIRIM_ID'].'\'>");';
	
}

if(isset($this->sinavYetkisiVerilmisBirimlerVeYetkiTarihleriFarkliDenetim)){
	$verilmisYetkilerFarkliDenetim = $this->sinavYetkisiVerilmisBirimlerVeYetkiTarihleriFarkliDenetim;
	for($i=0; $i<count($verilmisYetkilerFarkliDenetim); $i++)
	{
		echo 'jQuery(".birim-'.$verilmisYetkilerFarkliDenetim[$i]['BIRIM_ID'].'").attr("checked","checked"); ';
		echo 'jQuery(".birim-'.$verilmisYetkilerFarkliDenetim[$i]['BIRIM_ID'].'").prop("disabled",true); ';
		echo 'jQuery(".birim-'.$verilmisYetkilerFarkliDenetim[$i]['BIRIM_ID'].'").removeAttr("name"); ';
		echo 'jQuery("#yetkiVerilmeTarihiDiv-'.$verilmisYetkilerFarkliDenetim[$i]['BIRIM_ID'].'").html("&nbsp;&nbsp;('.$verilmisYetkilerFarkliDenetim[$i]['YETKININ_VERILDIGI_TARIH'].' tarihli denetimde yetki verildi)"); ';
		echo 'jQuery("#yetkiAlinmaTarihiDiv-'.$verilmisYetkilerFarkliDenetim[$i]['BIRIM_ID'].'").html(""); ';
		echo 'jQuery("#yetkilendirmeForm").children("input[value='.$verilmisYetkilerFarkliDenetim[$i]['BIRIM_ID'].'][name=oncedenYetkiVerilmisBirimler[]]").remove();';
		
	}
}
////////// YENİLER BİTTİ

//// ESKİLER //////////////////////
$alinmisYetkiler = $this->sinavYetkisiAlinmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterlilikten;
for($i=0; $i<count($alinmisYetkiler); $i++)
{
	echo 'jQuery("#yetkiAlinmaTarihiDiv-'.$alinmisYetkiler[$i]['BIRIM_ID'].'").html("&nbsp;&nbsp;('.$alinmisYetkiler[$i]['YETKININ_GERI_ALINDIGI_TARIH'].' tarihli denetimde yetkisi alındı)"); ';
}


$verilmisYetkiler = $this->sinavYetkisiVerilmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterlilikten;
for($i=0; $i<count($verilmisYetkiler); $i++)
{
	echo 'jQuery(".eskiBirim-'.$verilmisYetkiler[$i]['BIRIM_ID'].'").attr("checked","checked"); ';
	echo 'jQuery(".birim-'.$verilmisYetkilerFarkli[$i]['BIRIM_ID'].'").prop("disabled",false); ';
	echo 'jQuery("#yetkiVerilmeTarihiDiv-'.$verilmisYetkiler[$i]['BIRIM_ID'].'").html("&nbsp;&nbsp;('.$verilmisYetkiler[$i]['YETKININ_VERILDIGI_TARIH'].' tarihli denetimde yetki verildi)"); ';
	echo 'jQuery("#yetkiAlinmaTarihiDiv-'.$verilmisYetkiler[$i]['BIRIM_ID'].'").html(""); ';
	echo 'jQuery("#yetkilendirmeForm").append("<input type=\'hidden\' name=\'oncedenYetkiVerilmisBirimler_EskiFormattakiYeterliilk[]\' class=\'oncedenYetkiVerilmisBirimler\' value=\''.$verilmisYetkiler[$i]['BIRIM_ID'].'\'>");';

} 
if(isset($this->getSinavYetkisiVerilmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterliliktenFarkliDenetim)){
	$verilmisYetkilerFarkli = $this->sinavYetkisiVerilmisBirimlerVeYetkiTarihleri_EskiFormattakiYeterlilikten;
	for($i=0; $i<count($verilmisYetkilerFarkli); $i++)
	{
		echo 'jQuery(".eskiBirim-'.$verilmisYetkilerFarkli[$i]['BIRIM_ID'].'").attr("checked","checked"); ';
		echo 'jQuery(".birim-'.$verilmisYetkilerFarkli[$i]['BIRIM_ID'].'").prop("disabled",true); ';
		echo 'jQuery(".birim-'.$verilmisYetkilerFarkli[$i]['BIRIM_ID'].'").removeAttr("name"); ';
		echo 'jQuery("#yetkiVerilmeTarihiDiv-'.$verilmisYetkilerFarkli[$i]['BIRIM_ID'].'").html("&nbsp;&nbsp;('.$verilmisYetkilerFarkli[$i]['YETKININ_VERILDIGI_TARIH'].' tarihli denetimde yetki verildi)"); ';
		echo 'jQuery("#yetkiAlinmaTarihiDiv-'.$verilmisYetkilerFarkli[$i]['BIRIM_ID'].'").html(""); ';
		echo 'jQuery("#yetkilendirmeForm").append("<input type=\'hidden\' name=\'oncedenYetkiVerilmisBirimler_EskiFormattakiYeterliilk[]\' class=\'oncedenYetkiVerilmisBirimler\' value=\''.$verilmisYetkilerFarkli[$i]['BIRIM_ID'].'\'>");';
		echo 'jQuery("#yetkilendirmeForm").children("input[value='.$verilmisYetkilerFarkliDenetim[$i]['BIRIM_ID'].'][name=oncedenYetkiVerilmisBirimler_EskiFormattakiYeterliilk[]]").remove();';
	
	}	
}
////////// ESKİLER BİTTİ



echo '</script>';



function yeterlilikCheckboxuCheckedOlmaliMi($yetkilendirilecekBirimler,$yetkilendirilmisBirimler, $index)
{
	$result = true;
	$yeterlilik_id = $yetkilendirilecekBirimler[$index]['YETERLILIK_ID'];
	for($i=0;$i<count($yetkilendirilecekBirimler); $i++)
		if($yetkilendirilecekBirimler[$i]['YETERLILIK_ID']==$yeterlilik_id)
		{
			$result = (in_array($yetkilendirilecekBirimler[$i]['BIRIM_ID'], $yetkilendirilmisBirimler)) ? true : false;
				
		}

		return $result;
}

function denetimIDdenKurulusAdiGetir($denetim_id)
{
	$db  = &JFactory::getOracleDBO();
	
	$sql = "SELECT KURULUS_ADI 
	FROM M_DENETIM JOIN M_KURULUS ON (M_DENETIM.DENETIM_KURULUS_ID = M_KURULUS.USER_ID)
	WHERE DENETIM_ID=?";
	
	$result = $db->prep_exec($sql, array($denetim_id));
	return $result[0]['KURULUS_ADI'];
}

?>


</form>

<script>

jQuery('.yeterlilikCheckbox').live('click', function(e){
	var classList = jQuery(this).attr('class').split(' ');
	var yeterlilikID = classList[1].split('-')[1];

	var checked = jQuery(this).attr('checked');


	yeterliliginTumBirimleriniCheckUncheckle(yeterlilikID, checked);

	tumBirimlerinCheckDurumlarinaBakipYeterliliginiCheckUncheckle();
	
	
});

jQuery('.birimCheckbox').live('click', function(e){
	var birimID = jQuery(this).val();
	var checked = jQuery(this).attr('checked');
	var yeterlilikID = jQuery(this).attr('class').split(' ')[1].split('-')[1];
	var zorunlu = jQuery(this).attr('class').split(' ');
	if(zorunlu.indexOf('zorunlu') >= 0){
		buIdliZorBirimleriCheckUncheckle(yeterlilikID, checked);
	}
	else{
		buIdliTumBirimleriCheckUncheckle(birimID, checked);
	}

	if(checked != 'checked')
		jQuery('.yeterlilik-'+yeterlilikID).each(function(e){
			if(jQuery(this).attr('disabled')!='disabled')
				jQuery(this).removeAttr('checked');
		});

	buBiriminYeterliliginiDigerBirimlereDeBakipCheckUncheckle(birimID, yeterlilikID);
});

function buIdliZorBirimleriCheckUncheckle(yetId, checked)
{
	if(checked == 'checked')
		jQuery('.yeterlilikBirimi-'+yetId+'.zorunlu').attr('checked', 'checked');
	else
		jQuery('.yeterlilikBirimi-'+yetId+'.zorunlu').removeAttr('checked');
// 	jQuery('.birimCheckbox').each(function(e){
// 		if(jQuery(this).val()==birimID)
// 		{
// 			var yeterlilikID = jQuery(this).attr('class').split(' ')[1].split('-')[1];

// 			if(jQuery(this).attr('disabled')!='disabled')
				
			
// 			buBiriminYeterliliginiDigerBirimlereDeBakipCheckUncheckle(birimID, yeterlilikID);
// 		}
// 	});
}


function yeterliliginTumBirimleriniCheckUncheckle(yeterlilikID, checked)
{
	jQuery('.yeterlilikBirimi-'+yeterlilikID).each(function(e){

		var birimID = jQuery(this).attr('class').split(' ')[2].split('-')[1];

		jQuery('.birim-'+birimID).each(function(e){
			if(jQuery('.yeterlilikBirimi-'+yeterlilikID+'.birim-'+jQuery(this).val()).attr('disabled')!='disabled')
				if(checked == 'checked')
					jQuery('.yeterlilikBirimi-'+yeterlilikID+'.birim-'+jQuery(this).val()).attr('checked', 'checked');
				else
					jQuery('.yeterlilikBirimi-'+yeterlilikID+'.birim-'+jQuery(this).val()).removeAttr('checked');
		});
		
	});
}

function buIdliTumBirimleriCheckUncheckle(birimID, checked)
{
	jQuery('.birimCheckbox').each(function(e){
		if(jQuery(this).val()==birimID)
		{
			var yeterlilikID = jQuery(this).attr('class').split(' ')[1].split('-')[1];

			if(jQuery(this).attr('disabled')!='disabled')
				if(checked == 'checked')
					jQuery(this).attr('checked', 'checked');
				else
					jQuery(this).removeAttr('checked');
			
			buBiriminYeterliliginiDigerBirimlereDeBakipCheckUncheckle(birimID, yeterlilikID);
		}
	});
}

function tumBirimlerinCheckDurumlarinaBakipYeterliliginiCheckUncheckle()
{
	jQuery('.birimCheckbox').each(function(e){
		var birimID = jQuery(this).val();
		var checked = jQuery(this).attr('checked');
		var yeterlilikID = jQuery(this).attr('class').split(' ')[1].split('-')[1];

		buBiriminYeterliliginiDigerBirimlereDeBakipCheckUncheckle(birimID, yeterlilikID);
		
	});
}

function buBiriminYeterliliginiDigerBirimlereDeBakipCheckUncheckle(birimID, yeterlilikID) //birim checklendi�inde di�er birimleri de kontrol edip gerekirse yeterlili�i checkliycek
{
	
	
	var birimCheckboxlari = jQuery('.yeterlilikBirimi-'+yeterlilikID);

	var allChecked = true;
	jQuery(birimCheckboxlari).each(function(e){
		if(jQuery(this).attr('checked')=='checked')
			allChecked = allChecked && true;
		else
			allChecked = allChecked && false;
		
	});
	if(allChecked==true)
		jQuery('.yeterlilik-'+yeterlilikID).attr('checked', 'checked');
	else
		jQuery('.yeterlilik-'+yeterlilikID).removeAttr('checked');
		
	
}
//26.09.2013-----------------------------------------------------------------//
// jQuery( ".zorunlu" ).live( "click", function(e){
// 	e.preventDefault();
// 	if(jQuery(this).is(":checked") == true){
// 	//	alert('kaan');
// 	}
// 	else{
// 		alert('tunc');
// 	}
// 	var clas = jQuery(this).attr('class');
// 	var newclas = clas.split(' ');
// 	var yet = newclas[1].split('-')[1];
// 	var birims = newclas[2].split('-');
// 	alert(yet);
// 	if(birims == 'eskiBirim')
// 		alert('eski   '+birims[1]);
	
//});
//-----------------------------------------------------------------//
</script>
