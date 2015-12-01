<?php
	defined( '_JEXEC' ) or die( 'Restricted access' );
	$model 	= &$this->getModel("Yeterlilik_Taslak");
	$yeterlilik_id = JRequest::getVar("yeterlilik_id");
	
	$user 	= &JFactory::getUser();
//	$taslakYeterlilik 	= $this->taslakYeterlilik;
//	$yeterlilikBilgi	= $this->yeterlilikBilgi;
	$taslakYeterlilik 	= $model->getTaslakYeterlilik ($yeterlilik_id);
	$yeterlilikBilgi	= $model->getYeterlilikBilgi ($yeterlilik_id);
		$standart 			= $this->standart;
	$kaynakMeslek		= $this->kaynakMeslek;
	$kaynakBirim		= $this->kaynakBirim;
	$zorunluBirim 		= $this->zorunluBirim;
	$secmeliBirim 		= $this->secmeliBirim;
	$bilgi				= $this->bilgi;
	$beceri				= $this->beceri;
	$yetkinlik			= $this->yetkinlik;
	$teorikOlcme 		= $this->teorikOlcme;
	$performansOlcme 	= $this->performansOlcme;
	$gelistiren_kurulus = $this->gelistiren_kurulus;
	$katki_kurulus		= $this->katki_kurulus;
	//EKLER
	$terim				= $this->terim;
	$birim_bilgi		= $this->birim_bilgi;
	$birim_beceri		= $this->birim_beceri;
	$birim_yetkinlik	= $this->birim_yetkinlik;
	$gorus_kurulus		= $this->gorus_kurulus;
	$canOpenEkler		= $this->canOpenEkler;

	$cellPadding = '3';
	$saysay = 0;
	

?>	



	<div id="taslak">
	
	<table border="1" cellpadding=<?php echo $cellPadding;?>>
	<tbody>
		<?php
			
		$count = 1;
		$data = "";
		$standartHTML = "";
		if ($standart != null){
			foreach ($standart as $row){
				$standartHTML .=/*"<b>".*/ $row["STANDART_ADI"].":"/*. "</b>"*/	." ".$row["STANDART_ACIKLAMA"]."<br />";
				//$standartHTML .= "<br />";
			}
		}
		
		$refKoduText = ($yeterlilikBilgi["YETERLILIK_KODU"])?$yeterlilikBilgi["YETERLILIK_KODU"]:("..UY00..-".substr($yeterlilikBilgi["SEVIYE_ADI"],7,1));
		
		echo tableRow ($count++, "YETERLİLİĞİN ADI", "<font size=11>&nbsp;".$yeterlilikBilgi["YETERLILIK_ADI"]."</font>");
		echo tableRow ($count++, "REFERANS KODU",  "<font size=11>&nbsp;".$refKoduText."</font>");
		echo tableRow ($count++, "SEVİYE", "<font size=11>&nbsp;".substr($yeterlilikBilgi["SEVIYE_ADI"],7,1)."</font>");		
		echo tableRow ($count++, "ULUSLARARASI SINIFLANDIRMADAKİ YERİ","<font size=11>".rtrim($standartHTML,"<br />")."</font>");
		echo tableRow ($count++, "TÜR", "<font size=11>&nbsp;-"."</font>");
		echo tableRow ($count++, "KREDİ DEĞERİ", "<font size=11>&nbsp;-"."</font>");
		
		$yayinTarihiText = ($yeterlilikBilgi["YAYIN_TARIHI"])?$yeterlilikBilgi["YAYIN_TARIHI"]:".. / .. / ....";
		$revizyonNoText = ($yeterlilikBilgi["REVIZYON_NO"])?$yeterlilikBilgi["REVIZYON_NO"]:"-";
		$revizyonTarihiText = ($yeterlilikBilgi["REVIZYON_TARIHI"])?$yeterlilikBilgi["REVIZYON_TARIHI"]:"-";
		
		
		echo tableRowsWithSplitData ($count++, array("A)YAYIN TARİHİ", "B)REVİZYON NO", "C)REVİZYON TARİHİ"), array($yayinTarihiText, $revizyonNoText, $revizyonTarihiText));
		
		
		echo tableRowWithSecondDataPadding ($count++, "AMAÇ", "<font size=11>&nbsp;".$taslakYeterlilik["YETERLILIK_AMAC"]."</font>", 15);
	//echo tableRow ($count++, "İLGİLİ OLDUĞU SEKTÖR:", "&nbsp;".$yeterlilikBilgi["SEKTOR_ADI"]);
		$kaynakMeslekHTML = "";
		if ($kaynakMeslek != null){
			foreach ($kaynakMeslek as $row){
				if ($row["KAYNAK_ID"] == -1){
					$kaynakMeslekHTML .=  $row["KAYNAK_ACIKLAMA"];
					$kaynakMeslekHTML .="<br />";
					$countkynm++;
				} else {
				//MYK/ 09UMS0006-4 Referans Kodlu Bacacı-Seviye-4 Meslek Standardı
					$kaynakMeslekHTML .= getStandartKodu($row["KAYNAK_ID"])." ". getStandartAdi($row["KAYNAK_ID"])."(Seviye ".getStandartSeviye($row["KAYNAK_ID"]).") Ulusal Meslek Standardı"; //." - ".$row["KAYNAK_ACIKLAMA"];					$kaynakMeslekHTML .="<br />";
					$kaynakMeslekHTML .="<br />";
					$countkynm++;					
				}	  
				//$kaynakMeslekHTML .= "<br />";
			}
		}	
		
		echo tableRowTitle ($count++, "YETERLİLİĞE KAYNAK TEŞKİL EDEN MESLEK STANDART(LAR)I");
		echo tableRowDataWithBackground2 ("<font size=11>".rtrim($kaynakMeslekHTML,"<br />")."</font>");
		//echo tableRowTitle ($count++, "YETERLİLİĞE KAYNAK TEŞKİL EDEN YETERLİLİK BİRİM/BİRİMLERİ");
		echo tableRowTitle ($count++, "YETERLİLİK SINAVINA GİRİŞ ŞART(LAR)I");
		
		if(strlen($taslakYeterlilik["YETERLILIK_EGITIM_SEKIL"])>0)
			echo tableRowDataWithBackground2 ("<font size=11>".$taslakYeterlilik["YETERLILIK_EGITIM_SEKIL"]."</font>");
		else 
			echo tableRowDataWithBackground2 ("-");
		
		echo tableRowTitle ($count++, "YETERLİLİĞİN YAPISI");
		
		echo tableRowDataWithBackground("11-a) Zorunlu Birimler");
		
	
		if($taslakYeterlilik["ZORUNLU_ACIKLAMA"]) $zorunluBirimHTML .= "<br />".nl2br($taslakYeterlilik["ZORUNLU_ACIKLAMA"]). "<br />";
		if ($zorunluBirim != null){
			foreach ($zorunluBirim as $row){
				$birimKoduParcalari = explode('-', $row["BIRIM_KODU"]);
				$refKoduParcalari = split('-', $refKoduText);
				$zorunluBirimHTML .= statikTabloHTML ("<font size=11>".(($birimKoduParcalari[0]=='')? $refKoduParcalari[0] :'').$row["BIRIM_KODU"]." "."</font>"	,"<font size=11>". $row["BIRIM_ADI"]."</font>");
				//$zorunluBirimHTML .= "<br />";
		
			}
		}
		
		echo tableRowDataWithBackground2 ($zorunluBirimHTML);
		
		
		echo tableRowDataWithBackground("11-b) Seçmeli Birimler");
		if($taslakYeterlilik["SECMELI_ACIKLAMA"]) $secmeliBirimHTML .= "<br />".nl2br($taslakYeterlilik["SECMELI_ACIKLAMA"]). "<br />";
		if ($secmeliBirim != null){
			foreach ($secmeliBirim as $row){
				$birimKoduParcalari = explode('-', $row["BIRIM_KODU"]);
				$refKoduParcalari = split('-', $refKoduText);
				$secmeliBirimHTML .= statikTabloHTML ("<font size=11>".(($birimKoduParcalari[0]=='')? $refKoduParcalari[0] :'').$row["BIRIM_KODU"]." "."</font>"	, "<font size=11>".$row["BIRIM_ADI"]."</font>");
				//$secmeliBirimHTML .= "<br />";
			
			}
		}
		
		echo tableRowDataWithBackground2 ($secmeliBirimHTML);
		
		echo tableRowDataWithBackground("11-c) Birimlerin Guruplandırma Alternatifleri ve İlave Öğrenme Çıktıları");
		
		$txtt="<font size=11>".nl2br($taslakYeterlilik["BIRIMLERIN_GRUPLANDIRILMA"])."<br />".nl2br($taslakYeterlilik["ILAVE_OGRENME_CIKTILARI"])."</font>";
		if (($taslakYeterlilik["ILAVE_OGRENME_CIKTILARI"]=="-") || ($taslakYeterlilik["ILAVE_OGRENME_CIKTILARI"]==""))
			$txtt="<font size=11>".nl2br($taslakYeterlilik["BIRIMLERIN_GRUPLANDIRILMA"])."</font>";
		echo tableRowDataWithBackground2 ($txtt);

		
		echo tableRowTitle ($count++, "ÖLÇME VE DEĞERLENDİRME");
		
		echo tableRowData ("<font size=11>".$taslakYeterlilik["YETERLILIK_ORTAM"]."</font>");
			
		echo tableRow ($count++, "BELGE GEÇERLİLİK SÜRESİ", "<font size=11>".$taslakYeterlilik["YETERLILIK_GECERLILIK_SURE"]."</font>");
		echo tableRow ($count++, "GÖZETİM SIKLIĞI", "<font size=11>".$taslakYeterlilik["YETERLILIK_METHOD_GOZETIM"]."</font>");
		echo tableRow ($count++, "BELGE YENİLEMEDE UYGULANACAK ÖLÇME DEĞERLENDİRME YÖNTEMİ", "<font size=11>".$taslakYeterlilik["YETERLILIK_DEG_YONTEM"]."</font>");
		
		
		if ($gelistiren_kurulus != null)
		{
			for($i = 0; $i <count($gelistiren_kurulus); $i++){
				$gelistirenKurulusText .= ''.$gelistiren_kurulus[$i]["YETERLILIK_KURULUS_ADI"];
				if ($i<count($gelistiren_kurulus)-1){
					$gelistirenKurulusText .="<BR/>";
				}
				
			}
			
		}
		echo tableRow ($count++, "YETERLİLİĞİ GELİŞTİREN KURULUŞ(LAR)", "<font size=11>".$gelistirenKurulusText."</font>");
		
		$yeterlilikSektoru = $yeterlilikBilgi["SEKTOR_ADI"];
		$ykOnayTarihi = ($yeterlilikBilgi["KARAR_TARIHI"]) ? $yeterlilikBilgi["KARAR_TARIHI"] : '...' ; 
		$ykOnaySayisi = ($yeterlilikBilgi["KARAR_SAYI"]) ? $yeterlilikBilgi["KARAR_SAYI"] : '...';
		echo tableRow ($count++, "YETERLİLİĞİ DOĞRULAYAN SEKTÖR KOMİTESİ", "<font size=11>"."MYK ".$yeterlilikSektoru." Komitesi"."</font>");
		echo tableRow ($count++, "MYK YÖNETİM KURULU ONAY TARİHİ VE SAYISI",  "<font size=11>".$ykOnayTarihi.' / '.$ykOnaySayisi."</font>");
		
?>
		

	</tbody>	
	</table>
<?php
	/*foreach($dipnotAciklama as $a=>$b){
		echo "<small><b>".$a.".</b> Revize No: ".$b."</small><BR/>";
	}*/
?>
	</div>
	
<?php 

	//BIRIMLER
	$eklenmisBirim = $this->eklenmisBirim;
	for($i = 0; $i <count($eklenmisBirim); $i++)
	{
		
		$birimID = $eklenmisBirim[$i]["BIRIM_ID"];
		$birimKodu = $eklenmisBirim[$i]["BIRIM_KODU"];
		$krediDegeriText = ($eklenmisBirim[$i]["BIRIM_KREDI"]) ? $eklenmisBirim[$i]["BIRIM_KREDI"] : '-';
		$birimYayinTarihiText = ($eklenmisBirim[$i]["BIRIM_YAYIN_TAR"]) ? $eklenmisBirim[$i]["BIRIM_YAYIN_TAR"] : '.. / .. / ....';
		$birimRevNoText = ($eklenmisBirim[$i]["BIRIM_REV_NO"]=='') ? '00' : $eklenmisBirim[$i]["BIRIM_REV_NO"] ;
		
		$birimTableRowCount = 0;
		echo '<div id="birim'.($i+1).'">';
		
		echo '<span style="text-align: center;"><b>'.$eklenmisBirim[$i]["BIRIM_KODU"].' '. FormFactory::toUpperCase($eklenmisBirim[$i]["BIRIM_ADI"]) .' BİRİMİ</b></span><BR/><BR/>';
		echo '<table border="1" cellpadding="'.$cellPadding.'">';
		echo tableRow (++$birimTableRowCount, "YETERLİLİK BİRİMİ ADI", "<font size=11>".$eklenmisBirim[$i]["BIRIM_ADI"]  ."</font>"); 
		echo tableRow (++$birimTableRowCount, "REFERANS KODU", "<font size=11>".$birimKodu ."</font>"); 
		echo tableRow (++$birimTableRowCount, "SEVİYE", "<font size=11>".$eklenmisBirim[$i]["BIRIM_SEVIYE"] ."</font>" ); 
		echo tableRow (++$birimTableRowCount, "KREDİ DEĞERİ", "<font size=11>".$krediDegeriText ."</font>" ); 
		//echo tableRow (++$birimTableRowCount, "A) YAYIN TARİHİ <BR/> B) REVİZYON NO <BR/> C) REVİZYON TARİHİ", "&nbsp;".$eklenmisBirim[$i]["BIRIM_YAYIN_TAR"]."<br />"."&nbsp;".$eklenmisBirim[$i]["BIRIM_YAYIN_TAR"]."<br />"."&nbsp;".$eklenmisBirim[$i]["BIRIM_YAYIN_TAR"] ); 
		echo tableRowWithRowSpannedNumber (++$birimTableRowCount, "A)YAYIN TARİHİ", "<font size=11>". $birimYayinTarihiText ."</font>", 3);
		echo tableRowWithRowSpannedNumber_WithoutNumber("B)REVİZYON NO", "<font size=11>". $birimRevNoText."</font>");
		echo tableRowWithRowSpannedNumber_WithoutNumber("C)REVİZYON TARİHİ", "<font size=11>".$eklenmisBirim[$i]["BIRIM_REV_TAR"] ."</font>");
		echo tableRowTitle(++$birimTableRowCount, "YETERLİLİK BİRİMİNE KAYNAK TEŞKİL EDEN MESLEK STANDARDI");
		 
		$biriminKaynaklariListesiViewID = 'biriminKaynaklariListesiDetayli-'.$birimID;
		$biriminKaynaklariListesi= $this->$biriminKaynaklariListesiViewID;
		$biriminKaynaklariListesiText = (count($biriminKaynaklariListesi)==0) ? '-' : '';
		for($j=0; $j<count($biriminKaynaklariListesi); $j++)
		{	
			$kaynak = $biriminKaynaklariListesi[$j];
			if($j!=0)
				$biriminKaynaklariListesiText .= '<BR/>';
			
			$biriminKaynaklariListesiText .= $kaynak['STANDART_KODU'].' '.$kaynak['STANDART_ADI'].'(Seviye '.$kaynak['SEVIYE_ID'].')';
		}
		echo tableRowDataWithBackground2("<font size=11>".rtrim($biriminKaynaklariListesiText) ."</font>");
		
		
		
		echo tableRowTitle(++$birimTableRowCount, "ÖĞRENME ÇIKTILARI");
		
		$tableDataText = "";
		
		$ogrenmeCiktisiViewID = 'biriminOgrenmeCiktilari-'.$birimID;
		$buBiriminOgrenmeCiktilari = $this->$ogrenmeCiktisiViewID;
		for($j=0; $j<count($buBiriminOgrenmeCiktilari); $j++)
		{
			$ogrenmeCiktisiID = $buBiriminOgrenmeCiktilari[$j]["OGRENME_CIKTISI_ID"];
			$buOgrenmeCiktisininBaglamlariViewID = 'ogrenmeCiktisininBaglamlari-'.$birimID."-".$ogrenmeCiktisiID;
			$buOgrenmeCiktisininBaglamlari = $this->$buOgrenmeCiktisininBaglamlariViewID;
			$buOgrenmeCiktisininBasarimOlcutuViewID = 'ogrenmeCiktisininBasarimOlcutleri-'.$birimID.'-'.$ogrenmeCiktisiID;
			$buOgrenmeCiktisininBasarimOlcutleri = $this->$buOgrenmeCiktisininBasarimOlcutuViewID;
			
			
			$tableDataText .= (($j!=0) ? '<BR/>' : '').'<strong style="text-decoration:underline;">Öğrenme Çıktısı '.($j+1).': '.$buBiriminOgrenmeCiktilari[$j]["OGRENME_CIKTISI_YAZISI"].'</strong>'; //.'", "'.$buOgrenmeCiktisininBaglamlari[0]["BAGLAM_ACIKLAMA"].'" ); ';
			
			for($k=0; $k<count($buOgrenmeCiktisininBasarimOlcutleri); $k++)
			{
				if($k==0)
					$tableDataText .= '<BR/><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Başarım Ölçütleri</strong>'; 
				
				$basarimOlcutuID = $buOgrenmeCiktisininBasarimOlcutleri[$k]["BASARIM_OLCUTU_ID"];
			
				$buBasarimOlcutununBaglamlariViewID = 'basarimOlcutununBaglamlari-'.$birimID."-".$ogrenmeCiktisiID."-".$basarimOlcutuID;
				$buBasarimOlcutununBaglamlari = $this->$buBasarimOlcutununBaglamlariViewID;
			
				$tableDataText .= '<BR/><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.($j+1).'.'.($k+1).'</strong>&nbsp;&nbsp;'.$buOgrenmeCiktisininBasarimOlcutleri[$k]["BASARIM_OLCUTU_ADI"]; //.'", "'.$buBasarimOlcutununBaglamlari[0]["BAGLAM_ACIKLAMA"].'" 	); ';
			}
			
			
		}
		if (FormFactory::toUpperCase($eklenmisBirim[$i]["BIRIM_ADI"])=='YABANCI DİL'){//Yabancı Dil de pdf çıktısı farklı
				$tableDataText .='<span align="justify"><BR/><BR/> Yukarıdaki öğrenme çıktılarında belirtilen; dinleme, okuma, karşılıklı konuşma, sözlü anlatım ve yazılı anlatım becerilerine ilişkin düzeyler; 17 Ekim 2000 tarihinde, dil yeterliliklerinin belirlenmesi için kullanılması kararlaştırılan Avrupa Dil Portfolyosunda yer alan dil yeterliliği ölçütlerindeki (A1-C2) arasındaki düzeylerdir.</span>';
			}
		echo tableRowDataWithBackground2("<font size=11>".rtrim($tableDataText) ."</font>");
//		echo tableRowData($tableDataText);
		
		
		echo tableRowTitle(++$birimTableRowCount, "ÖLÇME VE DEĞERLENDİRME");
		if (FormFactory::toUpperCase($eklenmisBirim[$i]["BIRIM_ADI"])=='YABANCI DİL'){//Yabancı Dil de pdf çıktısı farklı
			echo tableRowDataWithBackground2("<span align='justify'><font size=11>Ölçme ve değerlendirme, yabancı dil yeterliliğindeki 5 öğrenme çıktısının seviyesine göre belirlenmiş ayrı ayrı yöntemler ile gerçekleştirilecektir.</font></span>");
		}
		else{
		echo tableRowDataWithBackground("8 a) Teorik Sınav");
		$teorikSinavData = '';
		$buBiriminTeorikSinavlariViewID = 'biriminTeorikSinavlari-'.$birimID;
		$buBiriminTeorikSinavlari = $this->$buBiriminTeorikSinavlariViewID;
		for($j=0; $j<count($buBiriminTeorikSinavlari); $j++)
		{
			if($j!=0)
				$teorikSinavData.='<br />';
			
			$teorikSinavData.= '<strong>(T'.($j+1).') '.$buBiriminTeorikSinavlari[$j]["OLC_DEG_ADI"].': </strong> '.FormFactory::replaceNewLinesWithBRForJavascriptCode($buBiriminTeorikSinavlari[$j]["OLC_DEG_ACIKLAMA"]); //.'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SAYISI"].'", "'.$buBiriminTeorikSinavlari[$j]["BASARI_KRITERI"].'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MIN_DK"].'",  "'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MIN_SN"].'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MAX_DK"].'", "'.$buBiriminTeorikSinavlari[$j]["SORU_SURESI_MAX_SN"].'" ); ';
		}
		if(strlen($teorikSinavData)>0){
//			echo tableRowData($teorikSinavData);
			$teorikSinavData='<span align="justify"><font size=11>'.$teorikSinavData.'</font></span>';
			echo tableRowDataWithBackground2($teorikSinavData);
		} else {
//			echo tableRowData("Teorik sınav öngörülmemektedir");
			echo tableRowDataWithBackground2("<font size=11>"."Bu birimde teorik sınav yapılmamaktadır." ."</font>");//Teorik sınav öngörülmemektedir
		}
		
		echo tableRowDataWithBackground("8 b) Performansa Dayalı Sınav");
		$performansSinaviData = '';
		$buBiriminPerformansSinavlariViewID = 'biriminPerformansSinavlari-'.$birimID;
		$buBiriminPerformansSinavlari = $this->$buBiriminPerformansSinavlariViewID;
		for($j=0; $j<count($buBiriminPerformansSinavlari); $j++)
		{
			if($j!=0)
				$performansSinaviData.='<br />';
				
			$performansSinaviData .= '<strong>(P'.($j+1).') '.$buBiriminPerformansSinavlari[$j]["OLC_DEG_ADI"].': </strong> '.FormFactory::replaceNewLinesWithBRForJavascriptCode($buBiriminPerformansSinavlari[$j]["OLC_DEG_ACIKLAMA"]); //.'", "", "'.$buBiriminPerformansSinavlari[$j]["BASARI_KRITERI"].'","","","",""); ';
		}
		if(strlen($performansSinaviData)>0){
//			echo tableRowData($performansSinaviData);
			$performansSinaviData='<span align="justify"><font size=11>'.$performansSinaviData.'</font></span>';
			echo tableRowDataWithBackground2($performansSinaviData);
			//echo tableRowDataWithBackground2("<span align='justify'><font size=11>".$performansSinaviData ."</font></span>");
		}else{
//			echo tableRowData("Performans sınavı öngörülmemektedir");
			echo tableRowDataWithBackground2("<font size=11>Bu birimde performansa dayalı sınav yapılmamaktadır.</font>");//"Performans sınavı öngörülmemektedir"
		}
		echo tableRowDataWithBackground("8 c) Ölçme ve Değerlendirmeye İlişkin Diğer Koşullar");
		$buBiriminDigerSinavlariViewID = 'biriminDigerSinavlari-'.$birimID;
		$buBiriminDigerSinavlari = $this->$buBiriminDigerSinavlariViewID;
		$digerSinavData = '';
		for($j=0; $j<count($buBiriminDigerSinavlari); $j++)
		{
			$digerSinavData .= FormFactory::replaceNewLinesWithBRForJavascriptCode($buBiriminDigerSinavlari[$j]["OLC_DEG_ACIKLAMA"]);
			if($j != count($buBiriminDigerSinavlari)-1)
				$digerSinavData .= '<br />'; 
		}
		
		if(strlen($digerSinavData)>0){
//			echo tableRowData($digerSinavData);
			echo tableRowDataWithBackground2("<font size=11>".rtrim($digerSinavData) ."</font>");
		}else{
//			echo tableRowData("-");
			echo tableRowDataWithBackground2("<font size=11>"."-" ."</font>");
		}
		}
		$buBirimiGelistirenKuruluslarViewID = 'birimiGelistirenKuruluslar-'.$birimID;
		$buBirimiGelistirenKuruluslar = $this->$buBirimiGelistirenKuruluslarViewID;
		$birimGelistirenKurulusText = (count($buBirimiGelistirenKuruluslar)==0) ? '-' : '';
		for($j=0; $j<count($buBirimiGelistirenKuruluslar); $j++)
		{
			if($j!=0)
				$birimGelistirenKurulusText .= '<BR/>';
			$birimGelistirenKurulusText .= $buBirimiGelistirenKuruluslar[$j]["KURULUS_ADI"];
		}
		echo tableRow (++$birimTableRowCount, "YETERLİLİK BİRİMİNİ GELİŞTİREN KURUM/KURULUŞ(LAR)", "<font size=11>".$birimGelistirenKurulusText ."</font>");
		
		
		echo tableRow (++$birimTableRowCount, "YETERLİLİK BİRİMİNİ DOĞRULAYAN SEKTÖR KOMİTESİ", '<font size=11>'.'MYK '.$yeterlilikSektoru.' Sektör Komitesi' .'</font>' );
		
		echo tableRow (++$birimTableRowCount, "MYK YÖNETİM KURULU ONAY TARİHİ ve SAYISI", "<font size=11>".str_replace('/', '.', $eklenmisBirim[$i]["BIRIM_MYK_YK_ONAY_TAR"]).' / '.$eklenmisBirim[$i]["BIRIM_MYK_YK_ONAY_SAYI"] ."</font>");
		
		
		echo '</table>';
		if (FormFactory::toUpperCase($eklenmisBirim[$i]["BIRIM_ADI"])=='YABANCI DİL'){
		}
		else{
		echo newLineDiv();
		
		echo '<span style="font-weight: bold;font-size: 11pt; text-align:center;">EKLER</span>';
		
		$birimKoduSplitted = split("/", $birimKodu);	
		$birimKodu_ZorunluSecmeliIdentifier = "";
		if(count($birimKoduSplitted) == 2)
			$birimKodu_ZorunluSecmeliIdentifier = $birimKoduSplitted[1];
		
		//bu kısmı sonradan istediler
		$birimKodu_ZorunluSecmeliIdentifier = $birimKodu;
		
		echo newLineDiv('<strong>EK '.$birimKodu_ZorunluSecmeliIdentifier.'-1: </strong>Yeterlilik Biriminin Kazandırılması için Tavsiye Edilen Eğitime İlişkin Bilgiler');
		//echo newLineDiv('Bu birimin kazandırılması için aşağıda içeriği tanımlanan bir eğitim programının tamamlanması tavsiye edilir');
		//echo newLineDiv();
		//echo newLineDiv('<font style="text-decoration:underline; font-weight:bold;">Eğitim İçeriği:</font>');
		if($eklenmisBirim[$i]['BIRIM_EK1_ACIKLAMASI']!='')
			echo newLineDiv('<strong>Açıklama: </strong>'.FormFactory::replaceNewLinesWithBRForJavascriptCode($eklenmisBirim[$i]['BIRIM_EK1_ACIKLAMASI']));
			
		$buBiriminEk1YazilariViewID = 'buBiriminEk1Yazilari-'.$birimID;
		$buBiriminEk1Yazilari = $this->$buBiriminEk1YazilariViewID;
		for($j=0; $j<count($buBiriminEk1Yazilari); $j++)
			echo newLineDiv( str_replace(' ', '&nbsp;', $buBiriminEk1Yazilari[$j]["EK1_YAZISI"]) );//($j+1).'. '.
		
		if($eklenmisBirim[$i]["EK2_KONTROL_LISTELIMI"]=="1")
			$kontrolListesiz = false;
		else $kontrolListesiz = true;
		
		echo newLineDiv();
		if ($kontrolListesiz)
			echo newLineDiv('<strong>EK '.$birimKodu_ZorunluSecmeliIdentifier.'-2: </strong>Yeterlilik Biriminde Belirtilen Değerlendirme Araçları İle Ölçülen Başarım Ölçütlerine İlişkin Tablo');
		else
			echo newLineDiv('<strong>EK '.$birimKodu_ZorunluSecmeliIdentifier.'-2: </strong>Yeterlilik Biriminin Ölçme ve Değerlendirmesinde Kullanılacak Kontrol Listesi');
		
		
		if($kontrolListesiz==true)
		{
			$biriminEk2si_KontrolListesizViewID = 'biriminEk2si_KontrolListesiz-'.$birimID;
			$biriminEk2si_KontrolListesiz = $this->$biriminEk2si_KontrolListesizViewID;
			echo '<table border="1"  cellpadding='.$cellPadding.'><thead><tr  style="background-color:RGB(198, 217, 241);"><th><strong>Başarım Ölçütleri</strong></th><th><strong>Değerlendirme Aracı</strong></th></tr></thead><tbody>';
			
			for($j=0; $j<count($biriminEk2si_KontrolListesiz); $j++)
			{
				$birNoktaBir = $biriminEk2si_KontrolListesiz[$j]["OGRENME_CIKTISI_INDEX"].'.'.$biriminEk2si_KontrolListesiz[$j]["BASARIM_OLCUTU_INDEX"];
				$ek2KontrolListesizArray[$birNoktaBir]['OGRENME_CIKTISI_INDEX'] = $biriminEk2si_KontrolListesiz[$j]["OGRENME_CIKTISI_INDEX"];
				$ek2KontrolListesizArray[$birNoktaBir]['BASARIM_OLCUTU_INDEX'] = $biriminEk2si_KontrolListesiz[$j]["BASARIM_OLCUTU_INDEX"];
				$ek2KontrolListesizArray[$birNoktaBir]['BASARIM_OLCUTU_ADI'] = $biriminEk2si_KontrolListesiz[$j]["BASARIM_OLCUTU_ADI"];
				$ek2KontrolListesizArray[$birNoktaBir]['SINAVLARI'][] = $biriminEk2si_KontrolListesiz[$j]["SINAV_IDENTIFIER"].$biriminEk2si_KontrolListesiz[$j]["SINAV_INDEX"];
			}
			
			foreach($ek2KontrolListesizArray as $ek2KontrolListesizArrayPart)
			{
				$sinavText = '';
				for($k=0; $k<count($ek2KontrolListesizArrayPart['SINAVLARI']); $k++)
				{
					if($k!=0)
						$sinavText .= ', ';
					$sinavText .= $ek2KontrolListesizArrayPart['SINAVLARI'][$k];
				}
				echo '<tr >
				<td>'.$ek2KontrolListesizArrayPart["OGRENME_CIKTISI_INDEX"].'.'.$ek2KontrolListesizArrayPart["BASARIM_OLCUTU_INDEX"].': '.$ek2KontrolListesizArrayPart["BASARIM_OLCUTU_ADI"].'</td>
				<td>'.$sinavText.'</td>
				</tr>';
			}
			
			echo '</tbody></table>';
			
			
		}
		else
		{
			echo '<span style="font-weight: bold;font-size: 11pt; text-align:left;">a) BİLGİLER</span></BR>';
			echo newLineDiv('');
			$biriminEk2si_KontrolListeliTablo1ViewID = 'biriminEk2si_KontrolListeli-Tablo1-'.$birimID;
			$biriminEk2si_KontrolListeliTablo1 = $this->$biriminEk2si_KontrolListeliTablo1ViewID;
			echo '<table border="1"  cellpadding='.$cellPadding.'><tr style="background-color:RGB(198, 217, 241);"><th width="9%" align="center"><strong><FONT SIZE=10>No</font></strong></th><th width="40%" align="center"><strong><FONT SIZE=10>Bilgi İfadesi</font></strong></th><th width="9%" align="center"><strong><FONT SIZE=10>UMS İlgili Bölüm</font></strong></th><th width="21%" align="center"><strong><FONT SIZE=10>Yeterlilik Birimi Başarım Ölçütü</font></strong></th><th width="20%" align="center"><strong><FONT SIZE=10>Değerlendirme Aracı</font></strong></th></tr>';
			$model=$this->getModel();
			
			for($j=0; $j<count($biriminEk2si_KontrolListeliTablo1); $j++)
			{
				$degerlendirmeAraclari=$model->getEk2KontrolListele_DegerlendirmeAraclari($biriminEk2si_KontrolListeliTablo1[$j]["EK2_KONTROL_LISTELI_ID"]);
				$degerlendirmeAraclariText="";
				for($k=0;$k<count($degerlendirmeAraclari);$k++)
				{
					$degerlendirmeAraclariText.= $degerlendirmeAraclari[$k]['DEGERLENDIRME_ARACI_HARF'].$degerlendirmeAraclari[$k]['DEGERLENDIRME_ARACI_NUMARA'];
					if($k!=count($degerlendirmeAraclari)-1)
						$degerlendirmeAraclariText.=', ';
				}
				echo '<tr ><td  width="9%" align="center">BG.'.$biriminEk2si_KontrolListeliTablo1[$j]["SIRA_NO"].'</td><td width="40%" >'
						.$biriminEk2si_KontrolListeliTablo1[$j]["EK_YAZISI"].
						'</td><td  width="9%" align="center">'.FormFactory::replaceNewLinesWithBRForJavascriptCode($biriminEk2si_KontrolListeliTablo1[$j]["MESLEK_STANDARDI_BO_TEXT"]).'
					</td><td width="21%" >'.$biriminEk2si_KontrolListeliTablo1[$j]["OGRENME_CIKTISI_INDEX"].
						'.'.$biriminEk2si_KontrolListeliTablo1[$j]["BASARIM_OLCUTU_INDEX"].
						': '.$biriminEk2si_KontrolListeliTablo1[$j]["BASARIM_OLCUTU_ADI"].'
					</td><td width="20%" align="center">'.$degerlendirmeAraclariText.'</td></tr>';
			}
			if(count($biriminEk2si_KontrolListeliTablo1)==0)
				echo '<tr ><td  width="9%">BG.1</td><td width="40%"></td><td width="10%"></td><td width="20%"></td><td width="20%"></td></tr>'
					.'<tr ><td  width="9%">BG.2</td><td width="40%"></td><td width="10%"></td><td width="20%"></td><td width="20%"></td></tr>'
					.'<tr ><td  width="9%">...</td><td width="40%"></td><td  width="10%"></td><td width="20%"></td><td width="20%"></td></tr>';
			
			
			echo '</table>';
			echo newLineDiv();
			echo '<span style="font-weight: bold;font-size: 11pt; text-align:left;">b) BECERİ VE YETKİNLİKLER</span></BR>';
			echo newLineDiv('');
				
			$biriminEk2si_KontrolListeliTablo2ViewID = 'biriminEk2si_KontrolListeli-Tablo2-'.$birimID;
			$biriminEk2si_KontrolListeliTablo2 = $this->$biriminEk2si_KontrolListeliTablo2ViewID;
			echo '<table border="1" cellpadding='.$cellPadding.'><tr style="background-color:RGB(198, 217, 241);"><th  width="9%" align="center"><strong><FONT SIZE=10>No</font></strong></th><th width="40%" align="center"><strong><FONT SIZE=10>Beceri ve Yetkinlik İfadesi</font></strong></th><th width="9%" align="center"><strong><FONT SIZE=10>UMS İlgili Bölüm</font></strong></th><th width="21%" align="center"><strong><FONT SIZE=10>Yeterlilik Birimi Başarım Ölçütü</font></strong></th><th width="20%" align="center"><strong><FONT SIZE=10>Değerlendirme Aracı</font></strong></th></tr>';
			//echo '<table border="1" cellpadding='.$cellPadding.'><tr style="background-color:RGB(198, 217, 241);"><th width="9%" align="center"><strong><FONT SIZE=10>No</font></strong></th><th width="40%" align="center"><strong><FONT SIZE=10>Bilgi İfadesi</font></strong></th><th width="9%" align="center"><strong><FONT SIZE=10>UMS İlgili Bölüm</font></strong></th><th width="21%" align="center"><strong><FONT SIZE=10>Yeterlilik Birimi Başarım Ölçütü</font></strong></th><th width="20%" align="center"><strong><FONT SIZE=10>Değerlendirme Aracı</font></strong></th></tr>';
			for($j=0; $j<count($biriminEk2si_KontrolListeliTablo2); $j++)
			{
				$degerlendirmeAraclari=$model->getEk2KontrolListele_DegerlendirmeAraclari($biriminEk2si_KontrolListeliTablo2[$j]["EK2_KONTROL_LISTELI_ID"]);
				$degerlendirmeAraclariText="";
				for($k=0;$k<count($degerlendirmeAraclari);$k++)
				{
					$degerlendirmeAraclariText.= $degerlendirmeAraclari[$k]['DEGERLENDIRME_ARACI_HARF'].$degerlendirmeAraclari[$k]['DEGERLENDIRME_ARACI_NUMARA'];
					if($k!=count($degerlendirmeAraclari)-1)
					$degerlendirmeAraclariText.=', ';
				}
				
				echo '<tr ><td  width="9%" align="center">BY.'.$biriminEk2si_KontrolListeliTablo2[$j]["SIRA_NO"].'</td>
				<td width="40%">'.$biriminEk2si_KontrolListeliTablo2[$j]["EK_YAZISI"].
				'</td><td  width="9%" align="center">'.FormFactory::replaceNewLinesWithBRForJavascriptCode($biriminEk2si_KontrolListeliTablo2[$j]["MESLEK_STANDARDI_BO_TEXT"]).'
				</td><td width="21%">'.$biriminEk2si_KontrolListeliTablo2[$j]["OGRENME_CIKTISI_INDEX"].
				'.'.$biriminEk2si_KontrolListeliTablo2[$j]["BASARIM_OLCUTU_INDEX"].
				': '.$biriminEk2si_KontrolListeliTablo2[$j]["BASARIM_OLCUTU_ADI"].'
				</td><td width="20%" align="center">'.$degerlendirmeAraclariText.'</td></tr>';
			}
			if(count($biriminEk2si_KontrolListeliTablo2)==0)
				echo '<tr ><td  width="9%" align="center">BY.1</td><td width="40%"></td><td width="9%" align="center"></td><td width="21%"></td><td width="20%"></td></tr>'
				.'<tr ><td  width="9%" align="center">BY.2</td><td width="40%"></td><td width="9%" align="center"></td><td width="21%"></td><td width="20%"></td></tr>'
				.'<tr ><td  width="9%" align="center">...</td><td  width="40%"></td><td width="9%" align="center"></td><td width="21%"></td><td width="20%"></td></tr>';
				
			echo '</table>';
			
			
			
		}
		}
		
		
	}


	
	
	
	
	
	
	
	//EKLER
	
	echo '<div id="ek1">';
	echo '<strong>EK 1:</strong> Yeterlilik Birimleri';
	
	$zorunluText = ''; 
	$secmeliText='';
	for($i=0; $i<count($this->yeterlilikBirimleri); $i++)
	{	
		if($this->yeterlilikBirimleri[$i]['ZORUNLU']=='1')
			$zorunluText .= (($zorunluText != '') ? '<br />' : '<BR/><strong>Zorunlu Birimler:</strong><BR/>' ).$this->yeterlilikBirimleri[$i]["BIRIM_KODU"]." ".$this->yeterlilikBirimleri[$i]["BIRIM_ADI"];
		else 
			$secmeliText  .= (($secmeliText != '') ? '<br />' : '<BR/><strong>Seçmeli Birimler:</strong><BR/>' ).$this->yeterlilikBirimleri[$i]["BIRIM_KODU"]." ".$this->yeterlilikBirimleri[$i]["BIRIM_ADI"];
	}
	
	echo $zorunluText;
	echo $secmeliText;
	
	echo '</div>';
	
	
	
	echo '<div id="ek2">';
	echo '<BR/><strong>EK 2</strong>: Terimler, Simgeler ve Kısaltmalar';
	if($taslakYeterlilik["TERIM_ACIKLAMA"]) 
		echo "<div style='font-align:justify; float:left; width:100%;'>".nl2br($taslakYeterlilik["TERIM_ACIKLAMA"]). "</div>";
	
//	echo '<span style="text-align:center;"><strong>Terim Listesi</strong></span><br />';
	
	if ($terim != null){
		foreach ($terim as $row){
			echo statikTabloHTMLWithJustify($row["TERIM_ADI"].": "	, $row["TERIM_ACIKLAMA"]);
			//echo "<br />";
		}
	}
	echo "ifade eder.";
	echo '</div>';

	echo '<div id="ek3">';
	echo '<BR/><strong>EK 3:</strong> Meslekte Yatay ve Dikey İlerleme Yolları';
	echo newLineDivWithJustify(FormFactory::replaceNewLinesWithBRForJavascriptCode($taslakYeterlilik["MESLEKTE_YATAY_DIKEY"]));
	echo '</div>';
	

	//if($canOpenEkler){
	echo '<div id="ek4">';
	echo '<BR/><strong>EK 4:</strong> Değerlendirici Ölçütleri';
	echo newLineDivWithJustify(FormFactory::replaceNewLinesWithBRForJavascriptCode($taslakYeterlilik["DEGERLENDIRICI_OLCUT"]));
	echo '</div>';
	
	echo '<div id="ek5">';
	echo '<BR/>';
	echo '<strong>EK 5(*):</strong> Resmi Görüşe Gönderilmesi '
	.'Öncesinde Yeterlilik Taslağında Katkıda Bulunan Kurum / Kuruluşlar';
	//echo '<br/>';
	if ($katki_kurulus != null){
		foreach ($katki_kurulus as $row1){
			echo newLineDiv($row1["YETERLILIK_KURULUS_ADI"]);
		}
	}
	else echo newLineDiv('-');
	echo '</div>';
	
	
	echo '<div id="ek6">';
	echo '<BR/>';
	echo '<strong>EK 6(*):</strong> Yeterlilik Taslağının Görüşe Gönderildiği '
	.'Kurum ve Kuruluşlar';
	if ($gorus_kurulus != null)
	{
		foreach ($gorus_kurulus as $row1)
		{
			echo newLineDiv($row1["YETERLILIK_KURULUS_ADI"]);
		}
	}
	echo '</div>';
	
	echo '<div id="ek7">';
	//echo '<h3 style="text-align:left;">EK 7: YETERLİLİK TASLAĞINA İLİŞKİN KURUM VE KURULUŞLARDAN GELEN GÖRÜŞLERİN DEĞERLENDİRİLMESİNE İLİŞKİN FORM</h3>';
	echo '</div>';
	
	echo '<div id="ek8">';
	//echo '<h3 style="text-align:left;">EK8 : Yeterlilik Taslağında yer alan ve Mesleki Yeterlilik, Sınav ve Belgelendirmenin belirlenmesi amacıyla gerçekleştirilen pilot uygulamaya ilişkin belge ve kayıtlar</h3>';
	echo '</div>';
	
	echo '<div id="ek9">';
	echo '<BR/>';
	echo '<strong>EK 9(*):</strong> Yeterlilik Sınavına Giriş Şartları ve '
	.'Belge Geçerlilik Süresine İlişkin Açıklamalar<BR/>';
	echo $taslakYeterlilik["YETERLILIK_EK_ACIKLAMA"];

	
	echo newLineDiv();
	echo newLineDiv('(*): Bu ekler, yeterlilik taslaklarının değerlendirilmesi ve/veya yetkilendirilmiş kuruluşlar için saklanacak olup
			yeterliliklerin kamuya açık olan nüshalarında yayınlanmayacaktır.');
	
	echo '</div>';
	

	
	
	
	

	
function tableRow ($count, $title, $data){
	if(strlen(trim($data, '&nbsp;'))==0)
		$data = '-';
	
	$style = 'style="background-color:RGB(198, 217, 241); vertical-align:middle;"';
	$numWidth = 8;
	$width = (100-$numWidth)/2;
	
	return  '<tr ><td align="center" '.$style.' width="'.$numWidth.'%"><strong>'.$count.'</strong></td>
				<td '.$style.' width="'.$width.'%"><strong>'.$title.'</strong></td>
				<td align="justify" width="'.$width.'%" >'.$data.'</td></tr>';
}
function tableRowsWithSplitData ($count, $headerArray, $textArray){
	$rowData = '';
	
	$style = 'style="background-color:RGB(198, 217, 241);margin-top:auto; margin-bottom:auto;"';
	$numWidth = 8;
	$width = (100-$numWidth)/2;
	
	for($i=0; $i<count($headerArray); $i++)
	{
		if($i==0)
		{
			$rowData .= '<tr >
			<td align="center" '.$style.' width="'.$numWidth.'%" rowspan="'.count($headerArray).'"><strong>'.$count.'</strong></td>
			<td '.$style.' width="'.$width.'%"><strong>'.$headerArray[$i].'</strong></td>
			<td align="justify" width="'.$width.'%" >'.$textArray[$i].'</td>
			</tr>';
		}
		else
		{
			$rowData .= '<tr >
			<td '.$style.' width="'.$width.'%"><strong>'.$headerArray[$i].'</strong></td>
			<td align="justify" width="'.$width.'%" >'.$textArray[$i].'</td>
			</tr>';
		}
			
		
	}
	return $rowData ;
	
}
function tableRowWithSecondDataPadding ($count, $title, $data, $padding){
	if(strlen(trim($data, '&nbsp;'))==0)
		$data = '-';
	
	$style = 'style="background-color:RGB(198, 217, 241);"';
	$numWidth = 8;
	$width = (100-$numWidth)/2;

	return  '<tr ><td align="center"  '.$style.' width="'.$numWidth.'%"><strong>'.$count.'</strong></td>
	<td '.$style.' width="'.$width.'%"><strong>'.$title.'</strong></td>
	<td align="justify" width="'.$width.'%"><div style="padding:'.$padding.'px;">'.$data.'</div></td></tr>';
}
function tableRowWithRowSpannedNumber ($count, $title, $data, $rowSpan){
	if(strlen(trim($data, '&nbsp;'))==0)
		$data = '-';
	
		$style = 'style="background-color:RGB(198, 217, 241);"';
		$numWidth = 8;
		$width = (100-$numWidth)/2;
	
		return  '<tr ><td align="center"  rowspan="'.$rowSpan.'" '.$style.' width="'.$numWidth.'%"><strong>'.$count.'</strong></td>
				<td '.$style.' width="'.$width.'%"><strong>'.$title.'</strong></td>
				<td width="'.$width.'%" >'.$data.'</td></tr>';
	}
	function tableRowWithRowSpannedNumber_WithoutNumber ($title, $data){
		if(strlen(trim($data, '&nbsp;'))==0)
			$data = '-';
		
		$style = 'style="background-color:RGB(198, 217, 241);"';
		$numWidth = 8;
		$width = (100-$numWidth)/2;
	
		return  '<tr ><td '.$style.' width="'.$width.'%"><strong>'.$title.'</strong></td>
		<td width="'.$width.'%" >'.$data.'</td></tr>';
	}
	function tableRowTitle ($count, $title){
		$style = 'style="background-color:RGB(198, 217, 241);"';
		$numWidth = 8;
		$width = 100-$numWidth;
	
		return  '<tr ><td align="center"  '.$style.' width="'.$numWidth.'%"><strong>'.$count.'</strong></td>
				<td '.$style.' width="'.$width.'%" colspan=2><strong>'.$title.'</strong></td></tr>';
	}
	
	function tableRowData ($data){
		if(strlen(trim($data, '&nbsp;'))==0)
			$data = '-';
		
		return  '<tr >
					<td width="100%" align="justify" colspan=3>'.$data.'</td>
				 </tr>';
	}
	
	function tableRowDataWithBackground ($data){
		if(strlen(trim($data, '&nbsp;'))==0)
			$data = '-';
		
		return  '<tr  style="background-color:RGB(198, 217, 241);">
		<td width="100%" style="background-color:RGB(198, 217, 241);" colspan=3><strong>'.$data.'</strong></td>
		</tr>';
	}
	
	function tableRowDataWithBackground2 ($data){
		if(strlen(trim($data, '&nbsp;'))==0)
			$data = '-';
		
		return  '<tr  style="background-color:RGB(255, 255, 255);">
		<td width="100%" style="background-color:RGB(255, 255, 255);" colspan="3">'.$data.'</td>
		</tr>';
	}
	
	function tableRowDataTitle ($title, $data){
		if(strlen(trim($data, '&nbsp;'))==0)
			$data = '-';
		
		return  '<tr >
					<td width="35%"><strong>'.$title.'</strong></td>
					<td width="65%">'.$data.'</td>
			 	</tr>';
	}
	
	function statikTabloHTML ($paramTitle, $param){	
		$html = '<div><span><strong>'.$paramTitle.'</strong>'.$param.'</span></div>';
		
		return $html; 
	}
	function statikTabloHTMLWithJustify ($paramTitle, $param){
		$html = '<div style="text-align:justify;"><strong>'.$paramTitle.'</strong>'.$param.'</div>';
	
		return $html;
	}
	function newLineDiv($divText = '&nbsp;')
	{
		return '<div style="float:left; width:100%;">'.$divText.'</div>';
	}
	function newLineDivWithJustify($divText = '&nbsp;')
	{
		return '<div style="text-align:justify; float:left; width:100%;">'.$divText.'</div>';
	}
	//Birimler ve Beceri yetkinliklerin bulundugu array'i alir
	//Birimlere gore ayirir ve birim bilgilerini kolon adlariyla tutar.
	//Beceri yetkinlikleri ise sirayla numeric olarak koyar 
	function convertBirimBeceriYetkinlik2DArray ($array){
		$newArray = array();
		
		$altBirimId = -1;
		$altBirimCount = -1;
		$bilgiCount = 0;
		for ($i = 0; $i < count($array); $i++){
			if ($altBirimId == $array[$i]["YETERLILIK_ALT_BIRIM_ID"]){
				$bilgiCount++;
				$newArray[$altBirimCount][$bilgiCount] = $array[$i]["BECERI_YETKINLIK_ADI"];
			}else{
				$bilgiCount = 0;
				$altBirimCount++;
				$newArray[$altBirimCount]["YETERLILIK_ALT_BIRIM_ADI"]= $array[$i]["YETERLILIK_ALT_BIRIM_ADI"];
				$newArray[$altBirimCount]["YETERLILIK_ALT_BIRIM_KODU"]= $array[$i]["YETERLILIK_ALT_BIRIM_KODU"];
				$newArray[$altBirimCount]["YETERLILIK_ALT_BIRIM_KREDI"]= $array[$i]["YETERLILIK_ALT_BIRIM_KREDI"];
				$newArray[$altBirimCount]["YETERLILIK_ALT_BIRIM_NO"]= $array[$i]["YETERLILIK_ALT_BIRIM_NO"];
				$newArray[$altBirimCount][$bilgiCount] = $array[$i]["BECERI_YETKINLIK_ADI"];
				$altBirimId = $array[$i]["YETERLILIK_ALT_BIRIM_ID"];
			}
		}
		
		return $newArray;
	}
	
	function getStandartAdi($standart_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT standart_adi 
				FROM m_meslek_standartlari   
				WHERE standart_id = ?";
		
		$params = array ($standart_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	function getStandartKodu($standart_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT standart_kodu
				FROM m_meslek_standartlari   
				WHERE standart_id = ?";
		
		$params = array ($standart_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	function getStandartSeviye($standart_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT seviye_id
				FROM m_meslek_standartlari   
				WHERE standart_id = ?";
		
		$params = array ($standart_id);
		
		$data = $_db->prep_exec_array($sql, $params);
		
		if (!empty($data))
			return $data[0];
		else
			return null;
	}
	
	function getYeterlilikAltBirimAdi($alt_birim_id){
		$_db = &JFactory::getOracleDBO();
		
		$sql = "SELECT yeterlilik_alt_birim_adi, yeterlilik_alt_birim_kodu 
				FROM m_yeterlilik_alt_birim   
				WHERE yeterlilik_alt_birim_id = ?";
		
		$params = array ($alt_birim_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		if (!empty($data))
			return $data[0]["YETERLILIK_ALT_BIRIM_ADI"]." - ".$data[0]["YETERLILIK_ALT_BIRIM_KODU"];
		else
			return null;
	}
?>

<script type="text/javascript">

</script>