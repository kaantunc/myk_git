<?php
ini_set("display_errors","1");

defined('_JEXEC') or die('Restricted access');
require_once('libraries/form/form_config.php');
require_once('libraries/form/form_parametrik.php');
require_once('libraries/form/form.php');
require_once("libraries/joomla/utilities/browser_detection.php");

$document = &JFactory::getDocument();

$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables_themeroller.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/jquery.dataTables.css' );
$document->addStyleSheet( SITE_URL.'/includes/js/DataTables-1.9.0/media/css/validation.css' );
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/jquery.dataTables.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/validation.js');
$document->addScript (SITE_URL.'includes/js/DataTables-1.9.0/media/js/dataTables.sort.js');
// $document->addScript( SITE_URL.'/templates/elegance/js/jscal2.js' );
// $document->addScript( SITE_URL.'/templates/elegance/js/lang/tr.js' );
// $document->addStyleSheet( SITE_URL.'/templates/elegance/css/jscal2.css' );

////////////////////////////////////////////////////////////////////////////

$db = & JFactory::getOracleDBO();
$user = & JFactory::getUser();
$sektorSorumlusu  = FormFactory::sektorSorumlusuMu ($user);
$standartKurulusu = FormFactory::checkAuthorization  ($user, YT1_GROUP_ID);
$yeterlilikKurulusu = FormFactory::checkAuthorization  ($user, YT2_GROUP_ID);
$belgelendirmeKurulusu = FormFactory::checkAuthorization  ($user, YT3_GROUP_ID);
$akreditasyonKurulusu = FormFactory::checkAuthorization  ($user, YT4_GROUP_ID);

//YETKI KONTROL
/////////////////////////////////////////////////////////////////////////////////
$message = YETKI_MESAJ;
if ($user->getOracleUserId () == 0 )
$mainframe->redirect('index.php?', $message);
/////////////////////////////////////////////////////////////////////////////////

global $autSS;
$autSS = FormFactory::checkAuthorization  ($user, YET_SEKTOR_SORUMLUSU_GROUP_ID);

$gorev = JRequest::getVar('gorev');

$itemId = JRequest::getVar('Itemid');
$itemId = isset($itemId) ? $itemId : JRequest::getVar('prevItemId');
$itemIdStr = isset($itemId) ? ('&amp;prevItemId='.$itemId) : '';
$itemIdStrOrj = isset($itemId) ? ('&amp;Itemid='.$itemId) : '';

if($gorev == "goster" || $gorev == ''){
	formGoster($itemIdStr);
}
else if($gorev == "hepsi"){
	hepsiIleListele($db, $itemIdStrOrj, $user);
}
else if($gorev == "guncelleGoster"){
	$evrakId = JRequest::getVar('id');
	guncelleGoster($db, $itemIdStrOrj, $evrakId);
}
else if($gorev == "belgelendirmeguncelle"){
	global $mainframe;
	$evrakId = JRequest::getVar('id');
	$durum	 = JRequest::getVar('durum');
	//BelgeDurumu Guncelle

	$result = FormFactory::BelgelendirmebasvuruDurumGuncelle ($evrakId, $durum);
	if ($result){
		if($durum == -2){
			$durum = 7;
		}
		else if($durum == 4){
			$durum = 0;
		}
		else if($durum == 10){
			$durum = 3;
			$src = EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrakId;
			$dst = EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrakId."_onbasvuru";
			folder_copy($src, $dst);
		}
		else if($durum == 12){
			$durum = 8;
		}
		else if($durum == 18){
			$durum = 1;
		}
		else if($durum == 20){
			$durum = 6;
			$src = EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrakId;
			$dst = EK_FOLDER."belgelendirme_basvuru_ekleri/".$evrakId."_yetkibasvurusu";
			folder_copy($src, $dst);
		}
		$result = kurulusYetkiKaydet ($db, $evrakId, $durum);

		if ($result){
			$message = "Başvuru Durumu Başarıyla Güncellendi";
		}else{
			$message = "Başvuru Durumu Güncellenirken Hata Oluştu!";
		}
	}else{
		$message = "Başvuru Durumu Güncellenirken Hata Oluştu!";
	}
	

	$mainframe->redirect('index.php?option=com_basvuru_ara&amp;gorev=guncelleGoster'.$itemIdStrOrj.'&amp;id='.$evrakId, $message);
}
else if($gorev == "guncelle"){
	global $mainframe;
	$evrakId = JRequest::getVar('id');
	$durum	 = JRequest::getVar('durum');
	//Durumu Guncelle
	
	$result = raporKaydet($evrakId);
	
	$result = FormFactory::basvuruDurumGuncelle ($evrakId, $durum);
	if ($result){
		$result = kurulusYetkiKaydet ($db, $evrakId, $durum);

		if ($result){
			$message = "Başvuru Durumu Başarıyla Güncellendi";
		}else{
			$message = "Başvuru Durumu Güncellenirken Hata Oluştu!";
		}
	}else{
		$message = "Başvuru Durumu Güncellenirken Hata Oluştu!";
	}

	$mainframe->redirect('index.php?option=com_basvuru_ara&amp;gorev=guncelleGoster'.$itemIdStrOrj.'&amp;id='.$evrakId, $message);
	//guncelleGoster($db, $itemIdStrOrj, $evrakId);
}

//////////////////////////////////////////////////////////////////////////

function formGoster ($itemIdStr){
	global $autSS; 
	?>
<div class="sinavGirisBaslik">Başvuru Ara</div>

<form action="index.php?option=com_basvuru_ara<?php echo $itemIdStr?>"
	method="post">
	<input type="hidden" value="hepsi" name="gorev" />
	<table style="width:100%;">
		<tr style="display:none;">
			<td style="width:20%;">Id'ye Göre</td>
			<td style="width:80%;"><input type="text" name="evrak_id"
				style="width: 100px;" /></td>
		</tr>
		<?php if($autSS == 1){?>
		<tr>
			<td>Kuruluş</td>
			<td><?php echo kuruluslariGoster()?></td>
		</tr>
		<?php } ?>
		<tr>
			<td>Başvuru Tipine Göre</td>
			<td><?php echo tipleriGoster()?></td>
		</tr>
		<tr>
			<td colspan="2">
				<div style="width:80%; border: 1px solid red; padding:10px; margin:10px; display:none;" id="searchTypes">
					<table>
						<tr>
							<td style="width:20%;">Başvuru Tarihine Göre</td>
							<td style="width:80%;">
								<input type="text" size="10" id="tarih_baslangic" name="tarih_baslangic" />
						 	  - <input type="text" size="10" id="tarih_bitis" name="tarih_bitis" />
							</td>
						</tr>
						<tr>
							<td>Sektöre Göre</td>
							<td><?php echo sektörleriGoster() ?></td>
						</tr>
						<tr>
							<td>Başvuru Durumuna Göre</td>
							<td><?php echo durumlariGoster() ?></td>
						</tr>
						<tr>
							<td>Döküman İçeriğine Göre</td>
							<td><textarea name="icerik" id="icerik" style="paddind:5px; width:400px; height:50px;" ></textarea></td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td><input type="submit" value="Ara" /></td>
		</tr>
	</table>

</form>

<?php
}

function listele ($sonuclar, $itemIdStrOrj, $user){
	$aut = FormFactory::sektorSorumlusuMu  ($user);

	if(empty($sonuclar)){
		echo '<div class="sonucBulunamadi">Başvuru bulunmamaktır.</div>';
	}else{
		?>
<div class="tableWrapper">
	<table cellspacing="0" id="datatable">
		<thead>
			<tr class="tablo_header">
				<th>#</th>
				<th>Id</th>
				<?php if ($aut){?>
					<th>Kuruluş Adı</th>
				<?php }?>
				<th>Başvuru Tipi</th>
				<th>Başvuru Tarihi</th>
				<th>Başvuru Durumu</th>
				<?php if ($aut){?>
					<th>Başvuru Durum Güncelle</th>
					<th>Başvuru Düzenle</th>
				<?php }?>
				<th>PDF</th>
				
			</tr>
		</thead>
		<tbody>
			
			
		<?php
		$user_browser = browser_detection('browser');

		$rowCount=1;
		$rowClass="";
		foreach($sonuclar AS $satir){
			$id 	= "";
			$form 	= "";
			$option = "";
			$layout = "pdf";
			$layout_ek = "ek_pdf";
			if ($satir['BASVURU_TIP_ID'] == T1_BASVURU_TIP){
				$option = "com_meslek_std_basvur";
				$form	= T1_BASVURU_TIP;
			}else if ($satir['BASVURU_TIP_ID'] == T2_BASVURU_TIP){
				$option = "com_yeterlilik_basvur";
				$form	= T2_BASVURU_TIP;
			}else if ($satir['BASVURU_TIP_ID'] == T3_BASVURU_TIP){
				$option = "com_belgelendirme_basvur";
				$layout="pdf";
				$form	= T3_BASVURU_TIP;
			}else if ($satir['BASVURU_TIP_ID'] == T4_BASVURU_TIP){
				$option = "com_akreditasyon_basvur";
				$form	= T4_BASVURU_TIP;
			}else if ($satir['BASVURU_TIP_ID'] == YT1_BASVURU_TIP){
				$option = "com_meslek_std_taslak";
				$form	= YT1_BASVURU_TIP;
				$id		="&standart_id=".getStandartId($satir["EVRAK_ID"]);
				$layout = "tum_basvuru";
				//$layout2 = "ek_basvuru";
			}else if ($satir['BASVURU_TIP_ID'] == YT2_BASVURU_TIP){
				$option = "com_yeterlilik_taslak";
				$form	= YT2_BASVURU_TIP;
				$id		="&yeterlilik_id=".getYeterlilikId($satir["EVRAK_ID"]);
			}
			if($rowCount%2==0)
			$rowClass = "even_row";
			else
			$rowClass = "odd_row";

			if (strripos($user_browser, 'msie') !== FALSE) {
				$clickHTML = 'target="_blank" href="index.php?option='.$option.$id.'&layout='.$layout.'&format=pdf&form='.$form.'&id='.$satir['EVRAK_ID'].'"';
			} else {
				$clickHTML = 'onclick="window.open(\'index.php?option='.$option.$id.'&layout='.$layout.'&format=pdf&form='.$form.'&id='.$satir['EVRAK_ID'].'\',\'\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,directories=no,location=no\');"';
			}

			if (strripos($user_browser, 'msie') !== FALSE) {
				$clickHTML2 = 'target="_blank" href="index.php?option='.$option.$id.'&layout='.$layout_ek.'&format=pdf&form=-5&id='.$satir['EVRAK_ID'].'"';
			} else {
				$clickHTML2 = 'onclick="window.open(\'index.php?option='.$option.$id.'&layout='.$layout_ek.'&format=pdf&form=-5&id='.$satir['EVRAK_ID'].'\',\'\',\'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,directories=no,location=no\');"';
			}
			
			if(strlen($satir['BASVURU_EK_DOSYASI_PATH'])==0){
				$pdfLinkleri = '<td><table><tr><td>Tümü<a '.$clickHTML.'><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png"></a></td></tr>
								<tr><td>Ekler<a '.$clickHTML2.'><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png"></a></td></tr></table></td>';
			}
			else{
				$pdfLinkleri = '<td><a href="index.php?dl=basvuruDosyalari/'.$satir['USER_ID'].'/'.$satir['EVRAK_ID'].'/'.$satir['BASVURU_EK_DOSYASI_PATH'].'" ><img alt="PDF" src="'.SITE_URL.'/templates/elegance/images/pdf_button.png"></a></td>';
				}
				

			$duzenlemeLinki = ' href="#" ';

			echo '<tr class="'.$rowClass.'">';

			echo '<td>'.$rowCount.'</td>';
			echo '<td>'.$satir['EVRAK_ID'].'</td>';
			if ($aut)
			echo '<td>'.FormFactory::toUpperCase($satir['KURULUS_ADI']).'</td>';
			if($satir['BASVURU_TURU']==1){
				echo '<td>'.$satir['BASVURU_TIP_ADI'].' (Kapsam Genişletme Başvurusu)</td>';
			}else{
				echo '<td>'.$satir['BASVURU_TIP_ADI'].'</td>';
			}
			
			echo '<td>'.$satir['BASVURU_TARIHI'].'</td>';
			if($satir['BASVURU_TIP_ID'] == 3){
				if(isset($satir['DURUM'])){
					echo '<td>'.$satir['DURUM'];
					if (FormFactory::sektorSorumlusuMu ($user)){
						echo ' ('.$satir['ACIKLAMA'].')';
					}
				}
				else{
					echo '<td>'.$satir['BASVURU_DURUM_ADI'];
				}
				echo '</td>';
			}
			else{
				echo '<td>'.$satir['BASVURU_DURUM_ADI'].'</td>';
			}
			if ($aut){
				echo '<td><a href="index.php?option=com_basvuru_ara&gorev=guncelleGoster&id='.$satir['EVRAK_ID'].'">Güncelle</a></td>';
				
				switch($satir['BASVURU_TIP_ID'])
				{
					case 1://std
						$comValue = 'com_meslek_std_basvur&layout=basvuru_yeni';
						break;
					case 2://yet
						$comValue = 'com_yeterlilik_basvur&layout=basvuru_yeni';
						break;
					case 3: 
						$comValue = 'com_belgelendirme_basvur&layout=kurulus_bilgi';
						break;
					case 4:
						$comValue = 'com_akreditasyon_basvur';
						break;
				}
				if($satir['BASVURU_TIP_ID']<5 && $satir['BASVURU_TIP_ID']>0)//yukardakilerden biriyse
					echo '<td><a href="index.php?option='.$comValue.'&evrak_id='.$satir['EVRAK_ID'].'">Düzenle</a></td>';
				else
					echo '<td>-</td>';
			}
			
			
			if ($option == "")
				echo '<td> - </td>';
			else
				echo $pdfLinkleri;
			
			
			echo '</tr>';
			$rowCount++;
		}
		?>
		</tbody>
	</table>
</div>

<br />
<a href="index.php?option=com_basvuru_ara<?php echo $itemIdStrOrj;?>">Geri</a>

<?php
	}
}

function guncelleGoster($db, $itemIdStrOrj, $evrakId){
	$values = getGuncelleGosterValues ($db, $evrakId);
	//basvuru belgelendime ve sinav ise 
	if($values['BASVURU_TIP_ID'] == 3){
	?>
<div class="sinavGirisBaslik">Başvuru Durum Güncelle</div>

<form
	action="index.php?option=com_basvuru_ara<?php echo $itemIdStrOrj?>"
	method="post">
	<input type="hidden" value="belgelendirmeguncelle" name="gorev" /> <input
		type="hidden" value="<?php echo $evrakId;?>" name="id" />
	<table>
		<tr>
			<td width="200">Id :</td>
			<td><?php echo $evrakId; ?></td>
		</tr>
		<tr>
			<td width="200">Başvuru Tipi :</td>
			<td><?php echo $values["BASVURU_TIP_ADI"]; ?></td>
		</tr>
		<tr>
			<td width="200">Kuruluş Adı :</td>
			<td><?php echo $values["KURULUS_ADI"]; ?></td>
		</tr>
		<tr>
			<td width="200">Başvuru Tarihi :</td>
			<td><?php echo $values["BASVURU_TARIHI"]; ?></td>
		</tr>
		<tr>
			<td width="200">Başvuru Durum :</td>
			<td><?php echo getBelgelendirmeBasvuruDurumValues($values["DURUM_ID"]); ?></td>
		</tr>
		<tr>
			<td width="200">Başvuruyu İncele/Değiştir :</td>
			<td><input type="button" value="İncele/Değiştir" onclick="goToPage2(<?php echo $evrakId;?>)" /></td>
		</tr>
		<tr>
			<td><input type="submit" value="Kaydet" /></td>
		</tr>
	</table>

</form>
<?php
	}
	//basvuru belgelendime ve sinav dısındakiler 
	else{?>
	<div class="sinavGirisBaslik">Başvuru Durum Güncelle</div>
	
	<form
	action="index.php?option=com_basvuru_ara<?php echo $itemIdStrOrj?>"
	enctype="multipart/form-data" method="post">
	<input type="hidden" value="guncelle" name="gorev" /> <input
	type="hidden" value="<?php echo $evrakId;?>" name="id" />
	<table>
	<tr>
	<td width="200">Id :</td>
	<td><?php echo $evrakId; ?></td>
			</tr>
			<tr>
				<td width="200">Başvuru Tipi :</td>
				<td><?php echo $values["BASVURU_TIP_ADI"]; ?></td>
			</tr>
			<tr>
				<td width="200">Kuruluş Adı :</td>
				<td><?php echo $values["KURULUS_ADI"]; ?></td>
			</tr>
			<tr>
				<td width="200">Başvuru Tarihi :</td>
				<td><?php echo $values["BASVURU_TARIHI"]; ?></td>
			</tr>
			<tr>
				<td width="200">Başvuru Durum :</td>
				<td><?php echo getBasvuruDurumValues($values["BASVURU_DURUM_ID"]); ?>
				</td>
			</tr>
			<?php //Kapatıldı
			if(1==2) {?>
			<tr>
				<td width="200">Başvuru Belgesi:</td>
				<td><?php echo getBasvuruBelgesiTDData($values["BASVURU_EK_DOSYASI_PATH"], $values['USER_ID']); ?>
				</td>
			</tr>
			<?php }?>
			<tr>
				<td><input type="submit" value="Kaydet" /></td>
			</tr>
		</table>
	
	</form>
<?php
	}	
}

function hepsiIleListele($db, $itemIdStrOrj, $user){
	$evrak_id 	 = JRequest::getVar('evrak_id');
	$basvuru_tip = JRequest::getVar('tip');
	$basvuru_durum = JRequest::getVar('durum');
	$tarih_baslangic = JRequest::getVar('tarih_baslangic');
	$tarih_bitis = JRequest::getVar('tarih_bitis');
	$sektor = JRequest::getVar('sektor');
	$icerik = JRequest::getVar('icerik');
	if(isset($_POST['kurulus'])){
		$kurulus = JRequest::getVar('kurulus');
	}else{
		$kurulus = "";
	}
	$sonuclar = hepsiIleAra($db, $evrak_id, $basvuru_tip, $basvuru_durum, $tarih_baslangic,$tarih_bitis,$sektor,$icerik,$user,$kurulus);
	listele($sonuclar, $itemIdStrOrj, $user);
}

function hepsiIleAra($db, $evrak_id, $basvuru_tip, $basvuru_durum, $tarih_baslangic, $tarih_bitis, $sektor, $icerik , $user ,$kurulus = null){

	if (FormFactory::sektorSorumlusuMu  ($user)){
		if(($kurulus <> null || $kurulus <> "") && $kurulus <> "Seçiniz"){
			$user_id = $kurulus;
		}else{
			$user_id 	= null;
		}
		$selectPart = "KURULUS_ADI,";
		$fromPart 	= "JOIN M_KURULUS USING (USER_ID)";
	}else{
		$user_id 	= $user->getOracleUserId();
		$selectPart = "";
		$fromPart 	= "";
	}

	$evrakIdStr = $evrak_id?"EVRAK_ID = ?":"";
	$basvuruTipStr = $basvuru_tip != 'Seçiniz' ? 'BASVURU_TIP_ID = ?' : '';
	$basvuruDurumStr = $basvuru_durum != 'Seçiniz' ? 'BASVURU_DURUM_ID = ?' : '';
	$userIdStr = $user_id?"M_BASVURU.USER_ID = ?":"";
	$tarihStr = "";
	if ($tarih_baslangic || $tarih_bitis){
		if ($tarih_baslangic && $tarih_bitis)
		$tarihStr = "AND BASVURU_TARIHI BETWEEN TO_DATE('".$tarih_baslangic."','dd/mm/yyyy') AND TO_DATE('".$tarih_bitis."','dd/mm/yyyy')";
		else if ($tarih_baslangic)
		$tarihStr = "AND BASVURU_TARIHI >= TO_DATE('".$tarih_baslangic."','dd/mm/yyyy')";
		else if ($tarih_bitis)
		$tarihStr = "AND BASVURU_TARIHI <= TO_DATE('".$tarih_bitis."','dd/mm/yyyy')";
	}
	$sektorStr = $sektor != 'Seçiniz' ? 'SEKTOR_ID = ?' : '';
	$icerikStr = $icerik != '' ? 'BASVURU_EK_DOSYASI_CONTENT LIKE ?' : '';
	$userIdStr = $user_id?"USER_ID = ?":"";
	$params = array();

	if($evrakIdStr != ''){
		$params[] = $evrak_id;
	}
	if($basvuruTipStr != ''){
		$params[] = $basvuru_tip;
	}
	if($basvuruDurumStr != ''){
		$params[] = $basvuru_durum;
	}
	if($sektorStr != ''){
		$params[] = $sektor;
	}
	if($icerikStr != ''){
		$params[] = "%".$icerik."%";
	}
	if($userIdStr != ''){
		$params[] = $user_id;
	}
	if($basvuru_tip == 3){
		$sql = "SELECT DISTINCT  
						EVRAK_ID,
				".$selectPart."
				BASVURU_TIP_ADI,
				TO_CHAR(basvuru_tarihi, 'DD.MM.YYYY') AS basvuru_tarihi,
				BASVURU_DURUM_ADI, 
				BASVURU_TIP_ID,
				DURUM_ID,
				DURUM,
				ACIKLAMA,
				BASVURU_EK_DOSYASI_PATH,
				BASVURU_TURU
			FROM M_BASVURU 
				".$fromPart."
				JOIN pm_basvuru_durum USING (BASVURU_DURUM_ID) 
	     		JOIN pm_basvuru_tip USING (BASVURU_TIP_ID)
	     		JOIN M_BELGELENDIRME_DURUM USING(EVRAK_ID) 
				JOIN M_BASVURU_SEKTOR USING(EVRAK_ID) 
	     		JOIN PM_BELGELENDIRME_DURUM USING (DURUM_ID)
				JOIN PM_SEKTORLER USING (SEKTOR_ID)
			WHERE"// BASVURU_DURUM_ID != ".KAYDEDILMEMIS_BASVURU." AND
			." BASVURU_TIP_ID NOT IN (".KULLANILMAYAN_BASVURU_TIP_ID.")
				".($evrakIdStr ? ("AND ". $evrakIdStr) : '')." 
				".($basvuruTipStr ? ("AND ". $basvuruTipStr) : '')." 
				".($basvuruDurumStr ? ("AND ". $basvuruDurumStr) : '')." 
				".($sektorStr ? ("AND ". $sektorStr) : '')." 
				".($icerikStr ? ("AND ". $icerikStr) : '')." 
				".($userIdStr ? ("AND ". $userIdStr) : '')." 
				".$tarihStr." 
			ORDER BY BASVURU_TARIHI";	
	}
	else{
		$sql = "SELECT DISTINCT  
						EVRAK_ID,
						".$selectPart."
						BASVURU_TIP_ADI,
						TO_CHAR(basvuru_tarihi, 'DD.MM.YYYY') AS basvuru_tarihi,
						BASVURU_DURUM_ADI, 
						BASVURU_TIP_ID,
						BASVURU_EK_DOSYASI_PATH,
						USER_ID,
						BASVURU_TURU
					FROM M_BASVURU 
						".$fromPart."
						JOIN M_BASVURU_SEKTOR USING(EVRAK_ID) 
						JOIN pm_basvuru_durum USING (BASVURU_DURUM_ID) 
			     		JOIN pm_basvuru_tip USING (BASVURU_TIP_ID)
			     		 
					WHERE ".//BASVURU_DURUM_ID != ".KAYDEDILMEMIS_BASVURU." AND 
						 "BASVURU_TIP_ID NOT IN (".KULLANILMAYAN_BASVURU_TIP_ID.")
						".($evrakIdStr ? ("AND ". $evrakIdStr) : '')." 
						".($basvuruTipStr ? ("AND ". $basvuruTipStr) : '')." 
						".($basvuruDurumStr ? ("AND ". $basvuruDurumStr) : '')." 
						".($sektorStr ? ("AND ". $sektorStr) : '')." 
						".($icerikStr ? ("AND ". $icerikStr) : '')." 
						".($userIdStr ? ("AND ". $userIdStr) : '')." 
						".$tarihStr." 
					ORDER BY BASVURU_TARIHI";
	}
	return $db->prep_exec($sql, $params);
}

function getStandartId ($evrak_id){
	$db = & JFactory::getOracleDBO();

	$sql = "SELECT STANDART_ID
			FROM M_TASLAK_MESLEK 
			WHERE EVRAK_ID = ?";

	$data = $db->prep_exec_array($sql, array($evrak_id));

	if (isset($data)){
		return $data[0];
	}else{
		return -1;
	}
}

function getYeterlilikId ($evrak_id){
	$db = & JFactory::getOracleDBO();

	$sql = "SELECT YETERLILIK_ID
			FROM M_TASLAK_YETERLILIK 
			WHERE EVRAK_ID = ?";

	$data = $db->prep_exec_array($sql, array($evrak_id));

	if (isset($data)){
		return $data[0];
	}else{
		return -1;
	}
}

function tipleriGoster(){
	$basvuruTipler = FormParametrik::getBasvuruTip();
	?>

<select id="tip" name="tip">
	<option selected="selected" value="Seçiniz">Seçiniz</option>
		<?php 
		foreach($basvuruTipler AS $basvuruTip)
			echo '<option value="'.$basvuruTip['BASVURU_TIP_ID'].'">'.$basvuruTip['BASVURU_TIP_ADI'].' </option>';
		?>
	</select>

	<?php
}

function getAllKurulus($kurulus_durum=TUM_KURULUS_DURUM_IDS){
	$db  = &JFactory::getOracleDBO();

	$sql = "SELECT DISTINCT M_KURULUS_EDIT.USER_ID AS USER_ID, M_KURULUS_EDIT.KURULUS_ADI AS KURULUS_ADI FROM M_KURULUS
				  JOIN M_KURULUS_EDIT ON M_KURULUS.USER_ID = M_KURULUS_EDIT.USER_ID
				  WHERE M_KURULUS_EDIT.AKTIF = 1 AND M_KURULUS_EDIT.ONAY_BEKLEYEN = 0 AND M_KURULUS.KURULUS_DURUM_ID IN(".$kurulus_durum.")
				UNION
				SELECT DISTINCT USER_ID, KURULUS_ADI FROM M_KURULUS
				  WHERE USER_ID NOT IN (SELECT USER_ID FROM M_KURULUS_EDIT WHERE AKTIF = 1) AND KURULUS_DURUM_ID IN(".$kurulus_durum.")
				  ORDER BY KURULUS_ADI ASC";
	return $db->prep_exec($sql, array());
}

function kuruluslariGoster(){
// 	$kuruluslar = FormParametrik::getKuruluslar();
	$kuruluslar = getAllKurulus();
	?>

<select id="kurulus" name="kurulus" style="width:259px;">
	<option selected="selected" value="Seçiniz">Seçiniz</option>
		<?php 
		foreach($kuruluslar AS $kurulus)
			echo '<option value="'.$kurulus['USER_ID'].'">'.$kurulus['KURULUS_ADI'].' </option>';
		?>
	</select>

	<?php
}

function durumlariGoster(){
	$basvuruDurumlar = FormParametrik::getBasvuruDurum();
	?>

	<select id="durum" name="durum" style="width:232px;">
		<option selected="selected" value="Seçiniz">Seçiniz</option>
		<?php 
		foreach($basvuruDurumlar AS $basvuruDurum){
			if ($basvuruDurum['BASVURU_DURUM_ID'] >= 0){
				echo '<option value="'.$basvuruDurum['BASVURU_DURUM_ID'].'">'.$basvuruDurum['BASVURU_DURUM_ADI'].'</option>';
			}
		}
		?>
	</select>

	<?php
}

function sektörleriGoster(){
	$sektorler = FormParametrik::getSektor();
	?>

	<select id="sektor" name="sektor" style="width:232px;">
		<option selected="selected" value="Seçiniz">Seçiniz</option>
		<?php 
		foreach($sektorler AS $sektor){
			if ($sektor['SEKTOR_DURUM'] >= 0){
				echo '<option value="'.$sektor['SEKTOR_ID'].'">'.$sektor['SEKTOR_ADI'].'</option>';
			}
		}
		?>
	</select>

	<?php
}

function getBasvuruDurumValues($durumId){
	$basvuruDurumlar = FormParametrik::getBasvuruDurum();
	?>

<select id="durum" name="durum" style="width:232px;">
<?php
foreach($basvuruDurumlar AS $basvuruDurum){
	$selected = "";
	if ($basvuruDurum["BASVURU_DURUM_ID"] == $durumId)
	$selected = "selected=\"selected\"";

	echo '<option '.$selected.' value="'.$basvuruDurum["BASVURU_DURUM_ID"].'">'.$basvuruDurum['BASVURU_DURUM_ADI'].'</option>';
}
?>
</select>

<?php
}

function getBelgelendirmeBasvuruDurumValues($durumId){
	$basvuruDurumlar = FormParametrik::getBelgelendirmeBasvuruDurum();
	?>

<select id="durum" name="durum">
<?php
foreach($basvuruDurumlar AS $basvuruDurum){
	$selected = "";
	if ($basvuruDurum["DURUM_ID"] == $durumId)
	$selected = "selected=\"selected\"";

	echo '<option '.$selected.' value="'.$basvuruDurum["DURUM_ID"].'">'.$basvuruDurum['DURUM'].'</option>';
}
?>
</select>

<?php
}

function getGuncelleGosterValues ($db, $evrakId){
	$sql = "SELECT BASVURU_TIP_ID FROM M_BASVURU WHERE EVRAK_ID = ?";
	$sonuc = $db->prep_exec($sql, array($evrakId));
	if($sonuc[0]['BASVURU_TIP_ID'] == 3)
	{
	$sql = "SELECT
				BASVURU_DURUM_ID,
				TO_CHAR(basvuru_tarihi, 'DD.MM.YYYY') AS basvuru_tarihi,
				KURULUS_ADI,
				BASVURU_TIP_ADI,
				BASVURU_TIP_ID,
		        DURUM_ID,
		        DURUM,
		        BASVURU_EK_DOSYASI_PATH,
		        USER_ID
			FROM M_BASVURU 
				JOIN m_kurulus USING (USER_ID) 
        JOIN m_belgelendirme_durum USING (EVRAK_ID)
        JOIN pm_basvuru_tip USING (BASVURU_TIP_ID)
        JOIN PM_BELGELENDIRME_DURUM USING (DURUM_ID)
			WHERE EVRAK_ID = ?";
}
	else{
	$sql = "SELECT
				BASVURU_DURUM_ID,
				TO_CHAR(basvuru_tarihi, 'DD.MM.YYYY') AS basvuru_tarihi,
				KURULUS_ADI,
				BASVURU_TIP_ADI,
				BASVURU_TIP_ID,
		        BASVURU_DURUM_ID,
		        BASVURU_DURUM_ADI,
		        BASVURU_EK_DOSYASI_PATH,
		        USER_ID
			FROM M_BASVURU 
				JOIN m_kurulus USING (USER_ID) 
        JOIN pm_basvuru_durum USING (BASVURU_DURUM_ID)
        JOIN pm_basvuru_tip USING (BASVURU_TIP_ID)
       WHERE EVRAK_ID = ?";
	}
	$data = $db->prep_exec($sql, array($evrakId));

	if (isset($data[0])){
		return $data[0];
	}else{
		return null;
	}
}

function kurulusYetkiKaydet ($db, $evrakId, $durum){
	$result = true;
	$user_id 	   = getUserId ($db, $evrakId);
	$basvuruTipler = getBasvurTipValues ($db, $user_id);
	$kurulusDurum  = getKurulusDurum($db, $user_id);
	$tur		   = getBasvuruTur ($db, $evrakId);

	if ($durum == ONAYLANMIS_BASVURU){
		if ($kurulusDurum == 1){
			// Daha Once Yetkilendirilmemis
			switch ($tur){
				case T1_BASVURU_TIP:
					$durum = 2;
					break;
				case T2_BASVURU_TIP:
					$durum = 3;
					break;
				case T3_BASVURU_TIP:
					$durum = 4;
					break;
				case T4_BASVURU_TIP:
					$durum = 5;
					break;
				default:
					$durum = -1;
				break;
			}
				
				
			if ($durum != -1){
				$yetki = getKurulusYetkiNo ($db, $user_id);

				if ($yetki == null){
					$yetNo = $db->getNextVal(KURULUS_YETKILENDIRME_NO_SEQ);
					$kurulusYetkiNo = "YB-".str_pad($yetNo, 4, "0", STR_PAD_LEFT);
					$result = kurulusYetkiGuncelle ($db, $kurulusYetkiNo, $durum, $user_id);
				}else{
					$result = kurulusDurumGuncelle ($db, $durum, $user_id);
				}
			}
		}else{ //Onceden Yetkilendirilmis
			switch ($tur){
				case T1_BASVURU_TIP:
					switch ($kurulusDurum){
						case 3:
							$durum = 6;
							break;
						case 4:
							$durum = 7;
							break;
						case 5:
							$durum = 8;
							break;
						case 9:
							$durum = 12;
							break;
						case 10:
							$durum = 13;
							break;
						case 11:
							$durum = 14;
							break;
						case 15:
							$durum = 16;
							break;
						default:
							$durum = -1;
						break;
					}
					break;
				case T2_BASVURU_TIP:
					switch ($kurulusDurum){
						case 2:
							$durum = 6;
							break;
						case 4:
							$durum = 9;
							break;
						case 5:
							$durum = 10;
							break;
						case 7:
							$durum = 12;
							break;
						case 8:
							$durum = 13;
							break;
						case 11:
							$durum = 15;
							break;
						case 15:
							$durum = 16;
							break;
						default:
							$durum = -1;
						break;
					}
					break;
				case T3_BASVURU_TIP:
					switch ($kurulusDurum){
						case 2:
							$durum = 7;
							break;
						case 3:
							$durum = 9;
							break;
						case 5:
							$durum = 11;
							break;
						case 6:
							$durum = 12;
							break;
						case 8:
							$durum = 14;
							break;
						case 10:
							$durum = 15;
							break;
						case 13:
							$durum = 16;
							break;
						default:
							$durum = -1;
						break;
					}
					break;
				case T4_BASVURU_TIP:
					switch ($kurulusDurum){
						case 2:
							$durum = 8;
							break;
						case 3:
							$durum = 10;
							break;
						case 4:
							$durum = 11;
							break;
						case 6:
							$durum = 13;
							break;
						case 8:
							$durum = 14;
							break;
						case 10:
							$durum = 15;
							break;
						case 13:
							$durum = 16;
							break;
						default:
							$durum = -1;
						break;
					}
					break;
			}
				
			if ($durum != -1)
			$result = kurulusDurumGuncelle ($db, $durum, $user_id);
		}
	}else if ($durum == REDDEDILMIS_BASVURU){
		$result = true;

		if (!array_search ($tur, $basvuruTipler)){
			//Reddedilen tipten baska kabul edilmis basvuru var mi?
			//Yoksa Yetki Degistir
			switch ($tur){
				case T1_BASVURU_TIP:
					switch ($kurulusDurum){
						case 6:
							$durum = 3;
							break;
						case 7:
							$durum = 4;
							break;
						case 8:
							$durum = 5;
							break;
						case 12:
							$durum = 9;
							break;
						case 13:
							$durum = 10;
							break;
						case 14:
							$durum = 11;
							break;
						case 16:
							$durum = 15;
							break;
						default:
							$durum = 1;
						break;
					}
					break;
				case T2_BASVURU_TIP:
					switch ($kurulusDurum){
						case 6:
							$durum = 2;
							break;
						case 9:
							$durum = 4;
							break;
						case 10:
							$durum = 5;
							break;
						case 12:
							$durum = 7;
							break;
						case 13:
							$durum = 8;
							break;
						case 15:
							$durum = 11;
							break;
						case 16:
							$durum = 15;
							break;
						default:
							$durum = 1;
						break;
					}
					break;
				case T3_BASVURU_TIP:
					switch ($kurulusDurum){
						case 7:
							$durum = 2;
							break;
						case 9:
							$durum = 3;
							break;
						case 11:
							$durum = 5;
							break;
						case 12:
							$durum = 6;
							break;
						case 14:
							$durum = 8;
							break;
						case 15:
							$durum = 10;
							break;
						case 16:
							$durum = 13;
							break;
						default:
							$durum = 1;
						break;
					}
					break;
				case T4_BASVURU_TIP:
					switch ($kurulusDurum){
						case 8:
							$durum = 2;
							break;
						case 10:
							$durum = 3;
							break;
						case 11:
							$durum = 4;
							break;
						case 13:
							$durum = 6;
							break;
						case 14:
							$durum = 8;
							break;
						case 15:
							$durum = 10;
							break;
						case 16:
							$durum = 13;
							break;
						default:
							$durum = 1;
						break;
					}
					break;
			}
				
			$result = kurulusDurumGuncelle ($db, $durum, $user_id);
		}
	}

	return $result;
}

function getBasvurTipValues ($db, $user_id){
	$sql = "SELECT DISTINCT (BASVURU_TIP_ID)
			FROM M_BASVURU 
			WHERE BASVURU_TIP_ID != ".MS_PROTOKOL_BASVURU_TIP." AND 
				  BASVURU_TIP_ID != ".YET_PROTOKOL_BASVURU_TIP." AND 
				  BASVURU_DURUM_ID = ".ONAYLANMIS_BASVURU." AND 
				  USER_ID = ?";

	$data = $db->prep_exec($sql, array($user_id));

	if (isset($data[0])){
		return $data[0];
	}else{
		return array();
	}
}

function getKurulusDurum($db, $user_id){
	$sql = "SELECT KURULUS_DURUM_ID
			FROM M_KURULUS 
			WHERE USER_ID = ?";

	$data = $db->prep_exec_array($sql, array($user_id));

	if (isset($data[0])){
		return $data[0];
	}else{
		return null;
	}
}

function getBasvuruTur ($db, $evrakId){
	$sql = "SELECT BASVURU_TIP_ID
			FROM M_BASVURU  
			WHERE EVRAK_ID = ?";

	$data = $db->prep_exec_array($sql, array($evrakId));

	if (isset($data[0])){
		return $data[0];
	}else{
		return null;
	}
}

function getUserId ($db, $evrakId){
	$sql = "SELECT USER_ID
			FROM M_BASVURU  
			WHERE EVRAK_ID = ?";

	$data = $db->prep_exec_array($sql, array($evrakId));

	if (isset($data[0])){
		return $data[0];
	}else{
		return null;
	}
}

function kurulusYetkiGuncelle ($db, $kurulusYetkiNo, $kurulusDurum, $userId){

// 	$sqlLogo = "SELECT LOGO FROM M_KURULUS WHERE USER_ID = ?";
// 	$logos = $db->prep_exec($sqlLogo, array($userId));
	
// 	if(!empty($logos[0]['LOGO'])){
// 		$logResim = explode('.', $logos[0]['LOGO']);
// 		rename(EK_FOLDER.'logolar/'.$logos[0]['LOGO'],EK_FOLDER.'logolar/'.$kurulusYetkiNo.$logResim[1]);
// 	}
	
// 	$sql = "UPDATE M_KURULUS
// 			SET KURULUS_YETKILENDIRME_NUMARASI = ?,
// 				KURULUS_DURUM_ID = ?   
// 			WHERE USER_ID = ?";

	$sql = "UPDATE M_KURULUS
			SET KURULUS_DURUM_ID = ?
			WHERE USER_ID = ?";

	return $db->prep_exec_insert($sql, array($kurulusDurum, $userId));
}

function kurulusDurumGuncelle ($db, $kurulusDurum, $userId){
	$sql = "UPDATE M_KURULUS
			SET KURULUS_DURUM_ID = ?   
			WHERE USER_ID = ?";

	return $db->prep_exec_insert($sql, array($kurulusDurum, $userId));
}

function getKurulusYetkiNo ($db, $userId){
	$sql = "SELECT KURULUS_YETKILENDIRME_NUMARASI
			FROM M_KURULUS    
			WHERE USER_ID = ?";

	$data = $db->prep_exec_array($sql, array($userId));

	return $data[0];
}

function getBasvuruBelgesiTDData($raporPath, $user_id)
{
	$resultToReturn = '';
	
	$uploaderContent = 'Formata uymayan başvuru dosyaları bu kısım kullanılarak upload edilmelidir.<br>
	<input type="file" name="dosya[]" class="required" id="dosya" style="width: 210px;"  />';
	
	if(strlen($raporPath) > 0)
	{
		$resultToReturn .= '<div style="width:100%; float:left; border-top:3px solid green; border-bottom:3px solid green; padding:4px; background-color: #EEFFEE; color:green;">
		Başvuru Belgesi Eklenmiş.
		&nbsp;&nbsp;&nbsp;
		|
		&nbsp;&nbsp;&nbsp;
		<a style="color:green; text-decoration:underline;" href="index.php?dl=basvuruDosyalari/'.$user_id.'/'.$_GET['id'].'/'.$raporPath.'">İndir</a>
		&nbsp;&nbsp;&nbsp;
		|
		&nbsp;&nbsp;&nbsp;
		<a style="color:green; text-decoration:underline;" href="#" id="formGosterButton">Değiştir</a>
		<input type="hidden" id="degistirFieldSelected" name="degistirFieldSelected" value="0">
		&nbsp;&nbsp;&nbsp;
		|
		&nbsp;&nbsp;&nbsp;
		<input type="checkbox" id="raporSilCheckbox" name="raporSilCheckbox" value="1">&nbsp;&nbsp;<a onclick="if(jQuery(\'#raporSilCheckbox\').attr(\'checked\')==\'checked\') jQuery(\'#raporSilCheckbox\').removeAttr(\'checked\'); else jQuery(\'#raporSilCheckbox\').attr(\'checked\', \'checked\')" style="color:green; text-decoration:underline;" href="#">Sil</a>
		&nbsp;&nbsp;&nbsp;
		</div>';
	
		$resultToReturn .= '<div id="toggleableDiv" style="width:100%; float:left; display:none;">'.$uploaderContent.'</div>';
	
		//$resultToReturn .= '<div style="padding-top:10px; width:100%; float:left;"><input type="button" onclick="window.location=\'index.php?option=com_denetim&layout=denetim_listele\';" value="GERİ" ></div>';
	
	
	}
	else
	{
		$resultToReturn .= $uploaderContent;
	}
	
	
	return $resultToReturn;
}



function raporKaydet($evrak_id)
{
	$db  = &JFactory::getOracleDBO();
	
	$sql = "SELECT BASVURU_EK_DOSYASI_PATH FROM m_basvuru WHERE EVRAK_ID = ?";
	$data = $db->prep_exec($sql, array($evrak_id));
	$previouslySavedRaporPath = $data[0]['BASVURU_EK_DOSYASI_PATH'];
	
	$user_id 	   = getUserId ($db, $evrak_id);
	
	
	/*if(strlen($previouslySavedRaporPath)==0)
	{*/
		//RAPOR UPDATE
		
		if ($_POST['raporSilCheckbox']=='1' )
		{	
			global $mainframe;
			$directory = EK_FOLDER."basvuruDosyalari/".$user_id."/".$evrak_id."/";
			$sildir=EK_FOLDER."basvuruDosyalari/".$user_id."/".$evrak_id."/";
			foreach(glob($sildir . '/*') as $file) {
				if(is_dir($file))
					rrmdir($file);
				else
					unlink($file);
			}
			rmdir($sildir);
			
			
			$sql = "UPDATE m_basvuru SET BASVURU_EK_DOSYASI_PATH = '' WHERE EVRAK_ID = ?";
			return $db->prep_exec_insert($sql, array($evrak_id));
		}
		else
		{
			
			if($previouslySavedRaporPath=='' || $_POST['degistirFieldSelected']=='1')
			{
				global $mainframe;
				$directory = EK_FOLDER."basvuruDosyalari/".$user_id."/".$evrak_id."/";
				$sildir=EK_FOLDER."basvuruDosyalari/".$user_id."/".$evrak_id."/";
				foreach(glob($sildir . '/*') as $file) {
					if(is_dir($file))
						rrmdir($file);
					else
						unlink($file);
				}
				rmdir($sildir);
				
				
				if($_FILES[dosya][size][0]>5500000)
				{
					$mainframe->redirect("index.php?option=com_basvuru_ara", "Gönderilen dosyanın boyutu 5MB dan büyük olamaz", 'error');
				} 
				else 
				{
				
					if (!file_exists($directory)){
						mkdir($directory, 0700,true);
					}
					$normalFile = FormFactory::formatFilename ($_FILES[dosya][name][0]);
					$_FILES[dosya][name][0]=	$directory . $normalFile;
					move_uploaded_file($_FILES[dosya][tmp_name][0],$_FILES[dosya][name][0]);
				}
				
				$sql = "UPDATE m_basvuru SET BASVURU_EK_DOSYASI_PATH = ? WHERE EVRAK_ID = ?";
				return $db->prep_exec_insert($sql, array($normalFile, $evrak_id));
			
			}
			
		}
/*	}
	else
	{
		if (strlen($previouslySavedRaporPath)>0 && $_POST['raporSilCheckbox']=='1' )
		{
			$directory = EK_FOLDER."basvuruDosyalari/".$evrak_id."/";
			$sildir=EK_FOLDER."basvuruDosyalari/".$evrak_id."/";
			foreach(glob($sildir . '/*') as $file) {
				if(is_dir($file))
					rrmdir($file);
				else
					unlink($file);
			}
			rmdir($sildir);
			
			$sql = "UPDATE m_basvuru SET BASVURU_EK_DOSYASI_PATH = '' WHERE EVRAK_ID = ?";
			return $db->prep_exec_insert($sql, array($evrak_id));
		}
		else 
			return true;
		
		
	}
		
	*/
		


}
function folder_copy($src, $dst){
	$dir = opendir($src);
	@mkdir($dst);
	while(false !== ( $file = readdir($dir)) ) {
		if (( $file != '.' ) && ( $file != '..' )) {
			if ( is_dir($src . '/' . $file) ) {
				folder_copy($src . '/' . $file,$dst . '/' . $file);
			}
			else {
				copy($src . '/' . $file,$dst . '/' . $file);
			}
		}
	}
	closedir($dir);
}

?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#tip").change(function(){
			jQuery("#searchTypes").hide("slow");
			if(jQuery(this).val() == "3" || jQuery(this).val() == "4"){
				jQuery("#icerik").closest("tr").hide();
			}else{
				jQuery("#icerik").closest("tr").show();
			}
// 			jQuery("#tarih_baslangic").closest("tr")
// 			jQuery("#sektor").closest("tr")
// 			jQuery("#durum").closest("tr")
// 			jQuery("#icerik").closest("tr")
			jQuery("#searchTypes").show("slow");
		});
	   jQuery('#tarih_baslangic').live('hover',function(e){
	        jQuery(this).datepicker({
	            changeYear: true,
	            changeMonth: true,
	            onSelect: function (selected) {
	            	var dd2 = selected.split('.')[0];
	                var mm2 = selected.split('.')[1] - 1;
	                var y2 = selected.split('.')[2];
	                jQuery('#tarih_bitis').datepicker( "destroy" );
	                jQuery("#tarih_bitis").datepicker({ minDate: new Date(y2, mm2, dd2) })
	            }
	    	});
	    });
	   jQuery('#tarih_bitis').live('hover',function(e){
	        jQuery(this).datepicker({
	            changeYear: true,
	            changeMonth: true,
	            onSelect: function (selected) {
	                var dd = selected.split('.')[0];
	                var mm = selected.split('.')[1] - 1;
	                var y = selected.split('.')[2];
	                jQuery('#tarih_baslangic').datepicker( "destroy" );
	                jQuery("#tarih_baslangic").datepicker({ maxDate: new Date(y, mm, dd) })
	            }
	    	 });
	    });

	   jQuery('#datatable').dataTable({
			"aaSorting": [[ 2, "desc" ]],
			 "columnDefs": [
                { "type": "dd.mm.YYYY", targets: 5 }
            ],
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"bInfo": true,
			"bPaginate": true,
			"bFilter": true,
			"sPaginationType": "full_numbers",
			"oLanguage": {
				"sLengthMenu": "# _MENU_ öğe göster",
				"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
				"sInfo": "_START_ - _END_ (Toplam _TOTAL_ öğe)",
				"sInfoEmpty": "0 - 0 öğeden 0'ı gösteriliyor.",
				"sSearch": "Ara",
				"oPaginate": {
					"sFirst":    "<?php echo JText::_("FIRST");?>",
					"sPrevious": "Önceki",
					"sNext":     "Sonraki",
					"sLast":     "<?php echo JText::_("LAST");?>"
				}
			}
			});	
	});
	function goToPage2(evrak_id){
    	window.location.href="index.php?option=com_belgelendirme_basvur&layout=kurulus_bilgi&evrak_id="+evrak_id;
	}

	jQuery('#formGosterButton').live('click',function(e){
		e.preventDefault();
		
		jQuery('#toggleableDiv').toggle('slow');
		
		if(jQuery('#degistirFieldSelected').val()=='1')
			jQuery('#degistirFieldSelected').val("0");
		else
			jQuery('#degistirFieldSelected').val("1");
	});
</script>
<script type="text/javascript">//<![CDATA[
// bu script inputtan sonra konmalı, mümünse en alta </body> den önce

// var cal = Calendar.setup({
//     onSelect: function(cal) { cal.hide() }
// });

// cal.manageFields("tarih_baslangic_button", "tarih_baslangic", "%d.%m.%Y");
// cal.manageFields("tarih_bitis_button", "tarih_bitis", "%d.%m.%Y");
      
//]]></script>
