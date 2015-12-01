<?php
$uygunsuzluk_id = JRequest::getVar("uygunsuzluk_id");
$denetim_id = JRequest::getVar("denetim_id");


$user = & JFactory::getUser();
$userId = $user->getOracleUserId();
$denetciMi = FormFactory::buIDDenetciMi($userId);
$denetlemesiYapilacakKurulusMu = FormFactory::buIDDenetlemesiYapilacakKurulusMu($user->id);
$isSektorSorumlusu = FormFactory::buIDDenetlemedenSorumluSSMu($user->id);


if(strlen($uygunsuzluk_id) > 0)//uygunsuzluk id tanımlı yani önceden tanımlanmış bişey
{
	$uygunsuzluk = $this->seciliUygunsuzluk;
	$denetim = $this->seciliUygunsuzlugunDenetimi;
	$denetimEkibi = $this->seciliDenetiminDenetimEkibi;
	foreach($denetimEkibi as $ekipUyesi)
		$denetimEkibiText .= $ekipUyesi['AD'].' '.$ekipUyesi['SOYAD'].'<br>';
	
	$denetimBasDenetcisi = $this->seciliDenetiminBasDenetcisi;
	$denetimBasDenetcisiText .= $denetimBasDenetcisi[0]['AD'].' '.$denetimBasDenetcisi[0]['SOYAD'].'<br>';
	
}
else
{ 
	if (strlen($denetim_id) > 0) // uygunsuzluk tanımlancak, denetim_id al
	{
		$denetimEkibi = $this->seciliDenetiminDenetimEkibi;
		foreach($denetimEkibi as $ekipUyesi)
			$denetimEkibiText .= $ekipUyesi['AD'].' '.$ekipUyesi['SOYAD'].'<br>';
		
		$denetimBasDenetcisi = $this->seciliDenetiminBasDenetcisi;
		$denetimBasDenetcisiText .= $denetimBasDenetcisi[0]['AD'].' '.$denetimBasDenetcisi[0]['SOYAD'].'<br>';
		
		$denetim = $this->seciliDenetim;
	}
	else // denetim_id yoksa hata
	{
		global $mainframe;
		$mainframe->redirect("index.php?option=com_denetim&layout=denetim_listele", "Hatalı giriş yapıldı", 'error');
	}	
}

?>


<form method="post" id="uygunsuzlukRaporuForm" action="index.php?option=com_denetim&task=uygunsuzlukKaydet" enctype="multipart/form-data">

<input type="hidden" value="<?php echo $uygunsuzluk_id; ?>" name="uygunsuzluk_id"> 
<input type="hidden" value="<?php echo $denetim_id; ?>" name="denetim_id">

<table border="1" style="width:100%;"><tbody>



<?php 



if(strlen($uygunsuzluk_id) == 0)//yepyeni uygunsuzluk tanımlanırken
{
	$kurulusTemsilcisiText = '<input name="kurulusTemsilcisi" type="text">';
	$uygunsuzlukNoText = '<input name="uygunsuzlukNo" type="text">';
	$uygunsuzlukDosyaNoText = 'BK-'.$denetim['BK_KODU'].'<input name="uygunsuzlukDosyaNo" type="hidden" value="'.$denetim['BK_KODU'].'">';
	$uygunsuzlukAciklamasiText = '<br><textarea name="uygunsuzluguTespitEdilenKonu" style="width:100%; height:100px;"></textarea>';
	$uygunsuzlukTuruText = '<br><input type="radio" name="uygunsuzlukTuru" value="1" > Büyük
		<br><input checked="checked" type="radio" name="uygunsuzlukTuru" value="2" > Küçük';
	$uygunsuzlukYerindeTakipText = '<br><input type="radio" name="yerindeTakipGerekirMi" value="1" > Evet
		<br><input checked="checked" type="radio" name="yerindeTakipGerekirMi" value="0" > Hayır';
	$uygunsuzlukKurulusuText = $this->uygunsuzlugunKurulusu;
}
else if($isSektorSorumlusu)//DİĞER AŞAMALARDA SS se
{
	$kurulusTemsilcisiText = '<input name="kurulusTemsilcisi" type="text" value="'.$uygunsuzluk['KURULUS_TEMSILCISI'].'">';
	$uygunsuzlukNoText = '<input name="uygunsuzlukNo" type="text" value="'.$uygunsuzluk['UYGUNSUZLUK_NO'].'">';
	$uygunsuzlukDosyaNoText = '<input name="uygunsuzlukDosyaNo" type="text" value="'.$uygunsuzluk['DOSYA_NO'].'">';
	$uygunsuzlukAciklamasiText = '<br><textarea name="uygunsuzluguTespitEdilenKonu" style="width:100%; height:100px;">'.$uygunsuzluk['UYGUNSUZLUK_ACIKLAMASI'].'</textarea>';
	
	if($uygunsuzluk['TUR_ACIKLAMA']=="Büyük")
	{
		$buyukSelected=' checked ';
		$kucukSelected=' ';
	}
	else 
	{
		$buyukSelected=' ';
		$kucukSelected=' checked ';
	} 
	$uygunsuzlukTuruText = '<br><input type="radio" name="uygunsuzlukTuru" value="1" '.$buyukSelected.'> Büyük
	<br><input type="radio" name="uygunsuzlukTuru" value="2" '.$kucukSelected.'> Küçük';
	
	
	if($uygunsuzluk['YERINDE_TAKIP_GEREKIR_MI']=='1')
	{
		$yerindeTakipEvetSelected= ' checked ';
		$yerindeTakipHayirSelected= '';
	}
	else
	{
		$yerindeTakipEvetSelected= '';
		$yerindeTakipHayirSelected= ' checked ';
	}	
	$uygunsuzlukYerindeTakipText = '<br><input type="radio" name="yerindeTakipGerekirMi" value="1" '.$yerindeTakipEvetSelected.'> Evet
	<br><input type="radio" name="yerindeTakipGerekirMi" value="0" '.$yerindeTakipHayirSelected.'> Hayır';
	
	$uygunsuzlukKurulusuText = $this->uygunsuzlugunKurulusu;
}
else //DİĞER AŞAMALARDA KURULUŞSA
{
	$uygunsuzlukKurulusuText = $this->uygunsuzlugunKurulusu;
	$kurulusTemsilcisiText = $uygunsuzluk['KURULUS_TEMSILCISI'];
	$uygunsuzlukNoText = $uygunsuzluk['UYGUNSUZLUK_NO'];
	$uygunsuzlukDosyaNoText = $uygunsuzluk['DOSYA_NO'];
	$uygunsuzlukAciklamasiText = '<br>'.$uygunsuzluk['UYGUNSUZLUK_ACIKLAMASI'];
	$uygunsuzlukTuruText = '<br>'.$uygunsuzluk['TUR_ACIKLAMA'];
	$uygunsuzlukYerindeTakipText = ($uygunsuzluk['YERINDE_TAKIP_GEREKIR_MI']=='1') ? '<br>Evet' : '<br>Hayır';
}

$denetimTarihiText = $denetim['DENETIM_TARIHI_BASLANGIC'];
$denetimTuruText = $denetim['DENETIM_TURU_ACIKLAMA'];

$bgColor = '#E3E3FF';
//if hacialiyse
echo '<tr>
	<td style="width:100%; float:left;">
		<table style="width:100%; float:left;"><tbody>
			<tr>
				<td style="background-color:'.$bgColor.'"><strong>UYGUNSUZLUK NO:</strong></td>
				<td style="background-color:'.$bgColor.'"><strong>DENETİM TARİHİ:</strong></td>
				<td style="background-color:'.$bgColor.'"><strong>DENETİM TÜRÜ:</strong></td>
				<td style="background-color:'.$bgColor.'"><strong>DOSYA NO:</strong> </td>
			</tr>
			
			<tr>
				<td>'.$uygunsuzlukNoText.'</td>
				<td>'.$denetimTarihiText.'</td>
				<td>'.$denetimTuruText.'</td>
				<td>'.$uygunsuzlukDosyaNoText.'</td>
			</tr>
			
			<tr>
				<td style="background-color:'.$bgColor.'"><strong>KURULUŞ:</strong></td>
				<td style="background-color:'.$bgColor.'"><strong>KURULUŞ TEMSİLCİSİ:</strong></td>
				<td style="background-color:'.$bgColor.'"><strong>DENETİM EKİBİ:</strong></td>
				<td style="background-color:'.$bgColor.'"><strong>BAŞ DENETÇİ:</strong></td>
			</tr>
			
			<tr>
				<td>'.$uygunsuzlukKurulusuText .'</td>
				<td>'.$kurulusTemsilcisiText.'</td>
				<td>'. $denetimEkibiText .'</td>
				<td>'. $denetimBasDenetcisiText.'</td>
			</tr>
		</tbody></table>
		
		
		<br><strong style="background-color:'.$bgColor.'">UYGUNSUZLUK TESPİT EDİLEN KONU:</strong>'
		.$uygunsuzlukAciklamasiText.
		'<br><strong style="background-color:'.$bgColor.'">UYGUNSUZLUK TÜRÜ:</strong>'
		.$uygunsuzlukTuruText.
		'<br><strong style="background-color:'.$bgColor.'">YERİNDE TAKİP DENETİMİ GEREKİR Mİ?</strong>'
		.$uygunsuzlukYerindeTakipText. 
		
			
	'</td>
</tr>';




	//if kurulussa
	
if($uygunsuzluk['UYGUNSUZLUK_SUREC_DURUM']==PM_UYGUNSUZLUK_SUREC__UYGUNSUZLUK_TANIMLANDI)
{
	$gerceklestirilecekDuzelticiFaaliyetText = '<textarea name="duzelticiFaaliyetAciklama" style="width:100%; height:100px;"></textarea>';
	$tamamlanmaSuresiText = '<input name="tamamlanmaSuresi" type="text" >';
	$duzelticiFaaliyetTarihText = '<br><input name="duzelticiFaaliyetTarih" class="datepicker" type="text" >';
	$duzelticiFaaliyetDosya = '<br><input name="duzelticiFaaliyetDosya" type="file" />';
}
else if($denetciMi || $isSektorSorumlusu)
{
	$gerceklestirilecekDuzelticiFaaliyetText = '<textarea name="duzelticiFaaliyetAciklama" style="width:100%; height:100px;">'.$uygunsuzluk['DUZELTICI_FAALIYET'].'</textarea>';
	$tamamlanmaSuresiText = '<input name="tamamlanmaSuresi" type="text" value="'.$uygunsuzluk['TAMAMLANMA_SURESI'].'" >';
	$duzelticiFaaliyetTarihText = '<br><input name="duzelticiFaaliyetTarih" class="datepicker" type="text" value="'.$uygunsuzluk['DUZELTICI_FAALIYET_TARIHI'].'" >';
	if(!empty($uygunsuzluk['DUZELTICI_FILE'])){
		$duzelticiFaaliyetDosya = '<br>
								<div id="uploadedfiles">
									<a href="index.php?dl='.$uygunsuzluk['DUZELTICI_FILE'].'"><div style="line-height: 40px; float: left;">Yüklenen dosya</div>&nbsp;<img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png" width="26" height="28" style="margin: 0 auto; border: 3px solid #ddd;" /></a>
									<a href="javascript:void(0);" id="changefile">Değiştir</a>
								</div>
								<div id="uploadcontainer" style="display:none;">
									<input name="duzelticiFaaliyetDosya" type="file" /> 
									<a href="javascript:void(0);" id="cancelupload">İptal</a>
								</div>';
	}
	else{
		$duzelticiFaaliyetDosya = '<br><input name="duzelticiFaaliyetDosya" type="file" />';
	}
	
	$duzelticiFaaliyetSonucTarih = '<br><input name="duzelticiFaaliyetSonucTarih" class="datepicker" type="text" value="'.str_replace('/','.',$uygunsuzluk['DUZELTICI_FAALIYET_SNC_TARIHI']).'" >';
	if($uygunsuzluk['DUZELTICI_FAALIYET_SONUCU']=='1')
	{
		$yeterliSelected = ' checked ';
		$yetersizSelected = ' ';
	}
	else
	{
		$yeterliSelected = ' ';
		$yetersizSelected = ' checked ';
	}	
	
	$duzelticiFaaliyetSonucuText = '<br><input type="radio" name="duzelticiFaaliyetSonucu" '.$yeterliSelected.' value="1" > Yeterli
									<br><input type="radio" name="duzelticiFaaliyetSonucu" value="0" '.$yetersizSelected.' > Yetersiz';
	$dfSonucAciklamaText = '<br><textarea name="duzelticiFaaliyetSonucuText" style="width:100%; height:100px;">'.$uygunsuzluk['DUZELTICI_FAALIYET_SNC_ACK'].'</textarea>';
	
}
else
{
	
	if($uygunsuzluk['UYGUNSUZLUK_SUREC_DURUM']==3){
		$gerceklestirilecekDuzelticiFaaliyetText = $uygunsuzluk['DUZELTICI_FAALIYET'];
		$tamamlanmaSuresiText = $uygunsuzluk['TAMAMLANMA_SURESI'];
		$duzelticiFaaliyetTarihText = '<br>'.$uygunsuzluk['DUZELTICI_FAALIYET_TARIHI'];
		if(!empty($uygunsuzluk['DUZELTICI_FILE'])){
			$duzelticiFaaliyetDosya = '<br><a href="index.php?dl='.$uygunsuzluk['DUZELTICI_FILE'].'">Yüklenen Dosya</a>';
		}
		else{
			$duzelticiFaaliyetDosya = '<br>Yok';
		}
		
		if($uygunsuzluk['UYGUNSUZLUK_SUREC_DURUM']==PM_UYGUNSUZLUK_SUREC__DUZELTICI_FAALIYET_TAMAMLANDI)
		{
			$duzelticiFaaliyetSonucTarih = '<br><input name="duzelticiFaaliyetSonucTarih" class="datepicker" type="text" >';
			$duzelticiFaaliyetSonucuText = '<br><input type="radio" name="duzelticiFaaliyetSonucu" checked value="1" > Yeterli
				<br><input type="radio" name="duzelticiFaaliyetSonucu" value="0" > Yetersiz';
			$dfSonucAciklamaText = '<br><textarea name="duzelticiFaaliyetSonucuText" style="width:100%; height:100px;"></textarea>';
		}
		else if($uygunsuzluk['UYGUNSUZLUK_SUREC_DURUM']==PM_UYGUNSUZLUK_SUREC__UYGUNSUZLUK_SONUCLANDI)
		{
			$duzelticiFaaliyetSonucTarih = '<br>'.$uygunsuzluk['DUZELTICI_FAALIYET_SNC_TARIHI'];
			$dfSonucAciklamaText = '<br>'.$uygunsuzluk['DUZELTICI_FAALIYET_SNC_ACK'];
		
			if($uygunsuzluk['DUZELTICI_FAALIYET_SONUCU']=='1')
				$duzelticiFaaliyetSonucuText = '<br>Yeterli';
			else
				$duzelticiFaaliyetSonucuText = '<br>Yetersiz';
		}
	}else{
		$gerceklestirilecekDuzelticiFaaliyetText = '<textarea name="duzelticiFaaliyetAciklama" style="width:100%; height:100px;">'.$uygunsuzluk['DUZELTICI_FAALIYET'].'</textarea>';
		$tamamlanmaSuresiText = '<input name="tamamlanmaSuresi" type="text" value="'.$uygunsuzluk['TAMAMLANMA_SURESI'].'" >';
		$duzelticiFaaliyetTarihText = '<br><input name="duzelticiFaaliyetTarih" class="datepicker" type="text" value="'.$uygunsuzluk['DUZELTICI_FAALIYET_TARIHI'].'" >';
		if(!empty($uygunsuzluk['DUZELTICI_FILE'])){
		$duzelticiFaaliyetDosya = '<br>
								<div id="uploadedfiles">
									<a href="index.php?dl='.$uygunsuzluk['DUZELTICI_FILE'].'"><div style="line-height: 40px; float: left;">Yüklenen dosya</div>&nbsp;<img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png" width="26" height="28" style="margin: 0 auto; border: 3px solid #ddd;" /></a>
									<a href="javascript:void(0);" id="changefile">Değiştir</a>
								</div>
								<div id="uploadcontainer" style="display:none;">
									<input name="duzelticiFaaliyetDosya" type="file" /> 
									<a href="javascript:void(0);" id="cancelupload">İptal</a>
								</div>';
		}
		else{
			$duzelticiFaaliyetDosya = '<br><input name="duzelticiFaaliyetDosya" type="file" />';
		}
		
		$duzelticiFaaliyetSonucTarih = '<br><input name="duzelticiFaaliyetSonucTarih" class="datepicker" type="text" value="'.str_replace('/','.',$uygunsuzluk['DUZELTICI_FAALIYET_SNC_TARIHI']).'" >';
		if($uygunsuzluk['DUZELTICI_FAALIYET_SONUCU']=='1')
		{
			$yeterliSelected = ' checked ';
			$yetersizSelected = ' ';
		}
		else
		{
			$yeterliSelected = ' ';
			$yetersizSelected = ' checked ';
		}	
		
		$duzelticiFaaliyetSonucuText = '<br><input type="radio" name="duzelticiFaaliyetSonucu" '.$yeterliSelected.' value="1" > Yeterli
										<br><input type="radio" name="duzelticiFaaliyetSonucu" value="0" '.$yetersizSelected.' > Yetersiz';
		$dfSonucAciklamaText = '<br><textarea name="duzelticiFaaliyetSonucuText" style="width:100%; height:100px;">'.$uygunsuzluk['DUZELTICI_FAALIYET_SNC_ACK'].'</textarea>';
	}
	
}

if(strlen($uygunsuzluk_id) != 0)	
	echo'<tr>
		<td style="width:100%; float:left;">
		<strong style="background-color:'.$bgColor.'">GERÇEKLEŞTİRİLECEK DÜZELTİCİ FAALİYET</strong><br>'
		.$gerceklestirilecekDuzelticiFaaliyetText.'<br>
		<strong style="background-color:'.$bgColor.'">TAMAMLANMA SÜRESİ:</strong><br>'
		.$tamamlanmaSuresiText.'<br>
		<strong style="background-color:'.$bgColor.'">TARİH:</strong>'
		.$duzelticiFaaliyetTarihText.'<br>
		<strong style="background-color:'.$bgColor.'">DÜZELTİCİ FAALİYET DOSYA:(Eğer dosya halinde bulunuyorsa)</strong>'
		.$duzelticiFaaliyetDosya.'<br>
		</td>
	</tr>';
	


if(		$uygunsuzluk['UYGUNSUZLUK_SUREC_DURUM']==PM_UYGUNSUZLUK_SUREC__DUZELTICI_FAALIYET_TAMAMLANDI
	|| 	$uygunsuzluk['UYGUNSUZLUK_SUREC_DURUM']==PM_UYGUNSUZLUK_SUREC__UYGUNSUZLUK_SONUCLANDI)
{	

	if( ! ($uygunsuzluk['UYGUNSUZLUK_SUREC_DURUM']==PM_UYGUNSUZLUK_SUREC__DUZELTICI_FAALIYET_TAMAMLANDI && $denetlemesiYapilacakKurulusMu))
	echo '<tr>
		<td style="width:100%; float:left;">
			<strong style="background-color:'.$bgColor.'">DÜZELTİCİ FAALİYET SONUCU</strong> 
			'.$duzelticiFaaliyetSonucuText.'
			<br><strong style="background-color:'.$bgColor.'">AÇIKLAMA:</strong>'
			.$dfSonucAciklamaText.
			'<br><strong style="background-color:'.$bgColor.'">BAŞ DENETÇİ:</strong>
			<br>'.$denetimBasDenetcisiText.'
			<strong style="background-color:'.$bgColor.'">TARİH:</strong>'
			.$duzelticiFaaliyetSonucTarih.'
		</td>
	</tr>';
}

?>
		


</tbody></table>



<?php 
switch(true)
{
	case (($denetciMi || $isSektorSorumlusu)):
	case (strlen($uygunsuzluk_id) != 0 && $uygunsuzluk['UYGUNSUZLUK_SUREC_DURUM']==PM_UYGUNSUZLUK_SUREC__UYGUNSUZLUK_TANIMLANDI && $denetlemesiYapilacakKurulusMu):
	//case (strlen($uygunsuzluk_id) != 0 && $uygunsuzluk['UYGUNSUZLUK_SUREC_DURUM']==PM_UYGUNSUZLUK_SUREC__DUZELTICI_FAALIYET_TAMAMLANDI):
		if($denetim_id){
			$geri = "javascript:location.href='index.php?option=com_denetim&layout=uygunsuzluk_listele&denetim_id=".$denetim_id."'";
		}else{
			$geri = "javascript:location.href='index.php?option=com_denetim&layout=uygunsuzluk_listele&denetim_id=".getDenetimId($uygunsuzluk_id)."'";	
		}
		echo '<br><input type="button" onclick="'.$geri.'" value="Geri"/> ';
		echo '<input type="submit" value="KAYDET"/>';		
		break;
		case (strlen($uygunsuzluk_id) != 0 && $uygunsuzluk['UYGUNSUZLUK_SUREC_DURUM']==2 && $denetlemesiYapilacakKurulusMu):
			//case (strlen($uygunsuzluk_id) != 0 && $uygunsuzluk['UYGUNSUZLUK_SUREC_DURUM']==PM_UYGUNSUZLUK_SUREC__DUZELTICI_FAALIYET_TAMAMLANDI):
			if($denetim_id){
				$geri = "javascript:location.href='index.php?option=com_denetim&layout=uygunsuzluk_listele&denetim_id=".$denetim_id."'";
			}else{
				$geri = "javascript:location.href='index.php?option=com_denetim&layout=uygunsuzluk_listele&denetim_id=".getDenetimId($uygunsuzluk_id)."'";
			}
			echo '<br><input type="button" onclick="'.$geri.'" value="Geri"/> ';
			echo '<input type="submit" value="KAYDET"/>';
			break;
	case (strlen($uygunsuzluk_id) != 0 && $uygunsuzluk['UYGUNSUZLUK_SUREC_DURUM']==PM_UYGUNSUZLUK_SUREC__UYGUNSUZLUK_SONUCLANDI):
	default:
		break;
	
}
		
?>

<script type="text/javascript">

jQuery(document).ready(function(){
	jQuery('.datepicker').datepicker({});
	
	jQuery("#changefile").click(function() {
		jQuery("#uploadedfiles").hide("slow");
		jQuery("#uploadcontainer").show("slow");
	});
	jQuery("#cancelupload").click(function() {
		jQuery("#uploadcontainer").hide("slow");
		jQuery("#uploadedfiles").show("slow");
	});
});
</script>

</form>



<?php 

function getKurulusAdi($denetim_id)
{
	$db  = &JFactory::getOracleDBO();
	
	$sql = "SELECT *
	FROM M_DENETIM, M_KURULUS WHERE
	M_DENETIM.DENETIM_KURULUS_ID = M_KURULUS.USER_ID 
	AND	DENETIM_ID = ?
	";
	
	$result = $db->prep_exec($sql, array($denetim_id));
	if(count($result)>0)
		return $result[0]['KURULUS_ADI'];
	else
		return null;
}

function getDenetimData($denetim_id)
{
	
}

function getDenetimId($uygunsuzluk_id){
	$db  = &JFactory::getOracleDBO();

	$sql = "SELECT DENETIM_ID
		FROM M_UYGUNSUZLUK WHERE
		UYGUNSUZLUK_ID = ?
		";
	
	$result = $db->prep_exec($sql, array($uygunsuzluk_id));
	if($result)
		return $result[0]['DENETIM_ID'];
	else
		return null;
}
?>