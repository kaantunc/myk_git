<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// require_once("libraries/joomla/utilities/browser_detection.php");
// $user_browser = browser_detection('browser');

$classBirinci = "leftCol";
$classIkinci = "rightCol";

$protokolID = JRequest::getVar("protokolID");

if(isset($protokolID))
{
	if($this->meslekiYeterlilikProtokoluMu==false)
	{
		global $mainframe;
		$mainframe->redirect("index.php?option=com_yetkilendirme_yet", "Bu protokol yeterlilik protokolü değil.", 'error');
	}
	
	$arr[0] = "1";
	$arr[1] = "2";

	$seciliProtokol = $this->seciliProtokol;
	$seciliProtokolunKuruluslari = $this->seciliProtokolunKuruluslari;

	$protokolAdi = $seciliProtokol[0]["ADI"];
	$yetkiBaslangici = $seciliProtokol[0]["IMZA_TARIHI"];
	$yetkiBitisi = $seciliProtokol[0]["BITIS_TARIHI"];
	$dosya = $seciliProtokol[0]["DOSYA"];
	$ilgiliProtokolIDsi = $seciliProtokol[0]["ILGILI_PROTOKOL_ID"];
	$yetkilendirmeSuresi = $seciliProtokol[0]["SURESI"];
	$yetkilendirmeTuru = $seciliProtokol[0]["YETKILENDIRME_TURU"];
	if($seciliProtokol[0]["PROTOKOL_MU"]=="1")
		$protokolMuRadioText = '<input value="1" type="radio" name="protokolMuRadioButtons[]" checked>Protokol<br>
								<input value="0" type="radio" name="protokolMuRadioButtons[]" >Yetkilendirme<br>';
	else
		$protokolMuRadioText = '<input value="1" type="radio" name="protokolMuRadioButtons[]">Protokol<br>
								<input value="0" type="radio" name="protokolMuRadioButtons[]" checked>Yetkilendirme<br>';
	
		
	$kurulusVeYeterlilikVisibilitysi = "display: block;";
	$kaydetButtonTexti = "Kuruluşları Kaydet";
}
else
{
	$kurulusVeYeterlilikVisibilitysi = "display: none;";
	$kaydetButtonTexti = "Kuruluş ve Yeterlilik Ekle";
	
	$protokolMuRadioText = '<input value="1" type="radio" name="protokolMuRadioButtons[]" checked>Protokol<br>
							<input value="0" type="radio" name="protokolMuRadioButtons[]" >Yetkilendirme<br>';
	
}


$meslekStandartSeviyeleri = $this->meslekStandartSeviyeleri;
$meslekStandartSektorleri = $this->meslekStandartSektorleri;
$ulusalStandartlar = $this->ulusalStandartlar;
$yetkilendirmeTurleri = $this->yetkilendirmeTurleri;

//SEVIYELER
$seviyeOptions = "<option value=''></option>";
foreach($meslekStandartSeviyeleri as $seviye){
	$seviyeOptions .= "<option value='".$seviye["SEVIYE_ID"]."'>".$seviye["SEVIYE_ADI"]."</option>";
}

//SEKTORLER
$sektorOptions = "<option value=''></option>";
foreach($meslekStandartSektorleri as $sektor){
	$sektorOptions .= "<option value='".$sektor["SEKTOR_ID"]."'>".$sektor["SEKTOR_ADI"]."</option>";
}

//ULUSAL STANDARTLAR
$ulusalStandartOptions = "<option value=''></option>";
foreach($ulusalStandartlar as $standart){
	$ulusalStandartOptions .= "<option value='".$standart["STANDART_ID"]."'>".$standart["STANDART_ADI"]."</option>";
}

//YETKILENDIRME TURU ICIN
$yetkilendirmeTuruOptions = "";
foreach($yetkilendirmeTurleri as $yTuru){

if($yetkilendirmeTuru == $yTuru["TUR_ID"])
	$seciliMiText = ' selected="selected" ';
else 
	$seciliMiText = '';

	$yetkilendirmeTuruOptions .= "<option value='".$yTuru["TUR_ID"]."' ".$seciliMiText." >".$yTuru["ACIKLAMA"]."</option>";
}

$yetkilendirmeID = JRequest::getVar("protokolID");

?>
<div class="form_item">
	<div class="form_element cf_heading">
		<h1 class="contentheading">Yeterlilik Yetkilendirmesi</h1>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_content">
	<form method="post" id="yeniProtokolForm"
		action="index.php?option=com_yetkilendirme_yet&amp;task=protokolKaydet">
		<input type="hidden" id="protokolID" name="protokolID" value="<?php echo $protokolID;?>"/>
	
		<div style="display:none;" class="form_row">
			<div class="<?php echo $classBirinci; ?>">
						<strong>Yetkilendirme Turu:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
					
					<?php if(strlen($protokolID)>0)
						$disabled = ' disabled ';
					else
						$disabled = '';
					?>
					
					
					<select <?php echo $disabled; ?> class="yetkilendirmeTuruRadioButtons required" name="kurulusTuruRadioButtons"><?php echo $yetkilendirmeTuruOptions; ?></select>
			</div>
			<div style="clear:both;"></div>
		</div>
							
		<div style="display:none;" class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>İlgili Protokol IDsi:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input  type="text" name="ilgiliProtokolIDsiTextbox" id="ilgiliProtokolIDsiTextbox"
					value="<?php echo $ilgiliProtokolIDsi; ?>" maxlength="400" />
				<a id="protokoleGitHyperlink" href="#">Protokole Git</a>
			</div>
			<div style="clear:both;"></div>
		</div>
		
		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Protokol Adı:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input class="required" type="text" name="protokolAdiTextbox"
					value="<?php echo $protokolAdi; ?>" maxlength="400"
					style="width: 300px;" />
			</div>
			<div style="clear:both;"></div>
		</div>
		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Başlangıç Tarihi</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input class="required" type="text" maxlength="10" name="yetkiBaslangiciDatePicker" id="yetkiBaslangiciDatePicker"
					value="<?php echo $yetkiBaslangici; ?>" />
			</div>
			<div style="clear:both;"></div>
		</div>
		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Bitiş Tarihi:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input class="required"  type="text" maxlength="10" name="yetkiBitisiDatePicker" id="yetkiBitisiDatePicker"
					value="<?php echo $yetkiBitisi; ?>" />
			</div>
			<div style="clear:both;"></div>
		</div>
		
		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Yetkilendirme Süresi:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input type="text" name="yetkilendirmeSuresiTextbox" class="required"
					id="yetkilendirmeSuresiTextbox" onkeyup="jQuery(this).val(jQuery(this).val().replace(/\D/g,''));" value="<?php echo $yetkilendirmeSuresi; ?>" style="width: 35px;" />(ay)
			</div>
			<?php // YUKARIDAKI KOD NUMARA YAZARKEN NUMARA DIŞINDAKILERE IZIN VERMIYOR, STRIP OFF TEXTS ?>
			<div style="clear: both;"></div>
		</div>
			
		
		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Protokol:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<?php echo $protokolMuRadioText; ?>
			</div>
			<div style="clear: both;"></div>
		</div>
		
		
		<div style="display:none;" class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Yetkilendirme Sektörleri:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<select name="yetkilendirmeSektorleriMultipleSelect[]"  id="yetkilendirmeSektorleriMultipleSelect"  multiple="multiple">
					<?php
					$sektorler = $this->meslekStandartSektorleri;
					$protokolSektorleri = $this->protokolunSektorleri;
					
					
					for($i = 0; $i< count($sektorler); $i++)
					{	
						$selected = "";					
						for($j=0; $j< count($protokolSektorleri); $j++)
						if($sektorler[$i]["SEKTOR_ID"] == $protokolSektorleri[$j]["SEKTOR_ID"])
							$selected = ' selected ';

						$x= "<option value='".$sektorler[$i]["SEKTOR_ID"]."' ".$selected." >" .$sektorler[$i]["SEKTOR_ADI"]. "</option>";
						echo $x;
					}					
					?>
				</select>
				<br><font class="kucukMinikAciklamaYazisiClassi">Çoklu seçmek veya silmek için (Ctrl) tuşunu kullanınız</font>
			</div>
			<div style="clear: both;"></div>
		</div>
		
		
		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Protokol Dosyası:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<div id="protokolDosya_div"></div>
			</div>
			<div style="clear:both;"></div>
		</div>
	
	
		<div class="form_row">
			<?php 
				if(isset($yetkilendirmeID))
				{
					echo '<div class="submit_button">
					<input style="padding:0px; float:left;" type="submit" value="Kaydet"
					name="kaydetButton" class="kaydetButton" id="kaydetButton" />
					<br></div>';
			
				}
			?>
			
			<div style="clear: both;"></div>
		</div>
	
		<div style="<?php echo $kurulusVeYeterlilikVisibilitysi; ?>" class="kurulus_wrapper">
			<div class="title_wrapper">
				<strong>Protokol Uzatma Süreleri:</strong>
			</div>
			
			<div class="gridview_wrapper">
				<div style="width: 100%; padding-top: 10px;padding-bottom: 10px;">
					<a id="newUzatma" href="">Yeni Uzatma Ekle </a>
				</div>
				
				<div>
					<table cellpadding="0" cellspacing="0" border="0" class="display" id="uzatmalar">
						<thead>
							<tr>
								<th>Uzatma Süresi (Ay Bazında)</th>
								<th>Açıklama</th>
								<th><?php echo JText::_("EDIT_TEXT"); ?></th>
								<th><?php echo JText::_("DELETE_TEXT"); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php
						$data = $this->uzatmalar;
						
						if ($data != null){
							foreach ($data as $row){
								$elm = "<tr id='".$row['UZATMA_ID']."'>";
						
								$elm .= "<td>".$row['UZATMA_SURESI']."</td>";
								$elm .= "<td>".$row['ACIKLAMA']."</td>";
								$elm .= "<td><a class='editUzatma' href=''>".JText::_("EDIT_TEXT")."</a></td>";
								$elm .= "<td><a class='deleteUzatma' href=''>".JText::_("DELETE_TEXT")."</a></td>";
						
								$elm .= "</tr>";
						
								echo $elm;
							}
						}						
						?>
						</tbody>
					</table>
				</div>
				<div style="clear: both;"></div>
			</div>
			<div style="clear: both;"></div>
		</div>
	
	
	
		<div style="<?php echo $kurulusVeYeterlilikVisibilitysi; ?>" class="kurulus_wrapper">
			<div>
				<strong>Yetkilendirmeye Dahil Kuruluşlar:</strong>
				<input type="checkbox" id="yetkilendirmeyeDahilKurulusCheckbox" <?php if($_GET['tumKuruluslar']=='1') echo ' checked '; ?> >Tüm Kuruluşlar
			</div>
	
			<div class="gridview_wrapper">
				<div>
					<table cellpadding="0" cellspacing="0" border="0" class="display"
						id="kuruluslar">
						<thead>
							<tr>
								<th class="no_sort">#</th>
								<th>Kuruluş Türü</th>
								<th>Kuruluş Adı</th>
							</tr>
						</thead>
						<tbody>					
							
						<?php
						$kuruluslar = $this->kuruluslar;
						$j=0;
						$allTheTableContents = "";
						for($i=0; $i<count($kuruluslar); $i++)
						{
							$allTheRowContents = "";
							$rowChecked = false;
								
							$checked = "";
							$class = "";
							$yetkilendirmeKurulusTuru_AsilChecked = "";
							$yetkilendirmeKurulusTuru_YardimciChecked = "";
							if($kuruluslar[$i]["USER_ID"]== $seciliProtokolunKuruluslari[$j]["USER_ID"])
							{
								$rowChecked = true;
								
								$checked = ' checked="checked" ';
								$class = 'checkedRow';
								if($seciliProtokolunKuruluslari[$j]["KURULUS_TURU"] == PM_YETKILENDIRME_KURULUS_TURU__YARDIMCI)
									$yetkilendirmeKurulusTuru_YardimciChecked = "checked='checked'";
								else
									$yetkilendirmeKurulusTuru_AsilChecked = "checked='checked'";
								$j++;
							}
							$allTheRowContents .= '<tr class=" '.$class.' ">';
							$allTheRowContents .= '<td><input style="float:left;" type="checkbox" value="'.$kuruluslar[$i]["USER_ID"].'-'.$yetkilendirmeID.'"  name="kurulusCheckbox[]" class="kurulusCheckbox"  '.$checked.' ></td>';
							
							$allTheRowContents .= '<td>';
							$allTheRowContents .= '<input type="radio" class="kurulusTuruRadioButtons-'.$kuruluslar[$i]["USER_ID"].' kurulusradioasil"  name="kurulusTuruRadioButtons-'.$kuruluslar[$i]["USER_ID"].'" value="'.PM_YETKILENDIRME_KURULUS_TURU__ASIL.'" '.$yetkilendirmeKurulusTuru_AsilChecked.'>Asıl<br>';
							$allTheRowContents .= '<input type="radio" class="kurulusTuruRadioButtons-'.$kuruluslar[$i]["USER_ID"].' kurulusradioyardimci"  name="kurulusTuruRadioButtons-'.$kuruluslar[$i]["USER_ID"].'" value="'.PM_YETKILENDIRME_KURULUS_TURU__YARDIMCI.'" '.$yetkilendirmeKurulusTuru_YardimciChecked.'>Yardımcı';
							$allTheRowContents .= '</td>';
							
							$allTheRowContents .= '<td> '.$kuruluslar[$i]["KURULUS_ADI"].'</td>';
							/*$allTheRowContents .= '<td> '.$kuruluslar[$i]["KURULUS_YETKILISI"].'</td>';
							$allTheRowContents .= '<td> '.$kuruluslar[$i]["KURULUS_YETKILI_UNVANI"].'</td>';
							$allTheRowContents .= '<td> '.$kuruluslar[$i]["KURULUS_WEB"].'</td>';*/
							$allTheRowContents .= '</tr>';
							
							if($rowChecked==true)
								$allTheTableContents = $allTheRowContents.$allTheTableContents;
							else
								$allTheTableContents = $allTheTableContents.$allTheRowContents;
							
						}
						echo $allTheTableContents;
						
						?>
						</tbody>
					</table>
				</div>
				<?php 
				if(isset($yetkilendirmeID))
				{
//					echo '<br><br><div class="submit_button">
//					<input style="padding:0px; float:left;" type="button" value="'.$kaydetButtonTexti.'"
//					name="kaydetButton" class="kaydetButtonx ui-button ui-widget ui-state-default ui-corner-all" id="kaydetButton" role="button" aria-disabled="false"/>
//						<br></div>';
						
				}
					
			?>
				
				<div style="clear:both;"></div>
			</div>
			<div style="clear:both;"></div>
		</div>
		
		<?php 	if(!isset($yetkilendirmeID))
				{
					echo '<div class="submit_button">
					<input type="submit" value="'.$kaydetButtonTexti.'"
					name="kaydetButton" class="kaydetButton ui-button ui-widget ui-state-default ui-corner-all" id="kaydetButton" role="button" aria-disabled="false" />
					</div>';
						
				}
		?>
	
		<div style="<?php echo $kurulusVeYeterlilikVisibilitysi; ?>"  class="standart_wrapper">
			<div>
				<strong>Yetkilendirme Dahilindeki Yeterlilikler:</strong>
			</div>
			<div class="gridview_wrapper">
				<div id="container">
					
					<div>
						<div style="float:left; padding-top: 10px;padding-bottom: 10px;">
							<a id="newMeslekStandart" href="">Yeni Yeterlilik Ekle </a><font id="yeniMeslekStandardiEkleButtonError" color="red"></font>
						</div>
						<div style="float:left; padding: 10px 0 10px 20px;">
							<a id="addExistingMeslekStandart" href="">Varolan Yeterlilik Ekle</a>
						</div>
						<div style="float:left; padding: 10px 0 10px 20px;">
							<a id="newRevizyonEkle" href="">Yeni Revizyon Ekle </a><font id="newRevizyonEkleButtonError" color="red"></font>
						</div>
					</div>
					<div style="display: none; float:left; width:100%; margin-bottom:10px; border: 1px solid #898989" class="existing_standart_wrapper"
						id="existing_standart_wrapper">
	
						<div id="existing_standart_container">
	
							<div style="background-color: #CDCDCD;padding: 5px;">
								Yeterlilik Seviyesi Seçiniz:<br> <select id="existing_seviyeler">
								<?php
								$seviyeler = $this->meslekStandartSeviyeleri;
								echo "<option value='0'>Seçiniz</option>";
								for($i = 0; $i< count($seviyeler); $i++)
								echo "<option value='".$seviyeler[$i]["SEVIYE_ID"]."'>" .$seviyeler[$i]["SEVIYE_ADI"]. "</option>";
								?>
								</select> <br> Yeterlilik Sektörü Seçiniz:<br> <select
									id="existing_sektorler">
									<?php
									$sektorler = $this->meslekStandartSektorleri;
									echo "<option value='0'>Seçiniz</option>";
									for($i = 0; $i< count($sektorler); $i++)
									echo "<option value='".$sektorler[$i]["SEKTOR_ID"]."'>" .$sektorler[$i]["SEKTOR_ADI"]. "</option>";
									?>
								</select><div style="display:none;"> <br> Revizyon Durumu Seçiniz:<br> 
								
								<input type="radio" name="varolanStandartEkle_RevizyonluCheckbox" id="varolanStandartEkle_RevizyonluCheckbox_Taslak" value="0" checked> Taslak
								<br>
								<input type="radio" name="varolanStandartEkle_RevizyonluCheckbox" id="varolanStandartEkle_RevizyonluCheckbox_Revizyon" value="1"> Revizyon Durumunda
								<br>
								</div>
								<input type="button" value="Getir" id="varolanStandartEkle_GetirButton">
							</div>
							 
							<div id="varolanStandartlarContainer" style="padding: 5px; display:none;"> 
								<div style="padding-bottom:10px; width:100%">
									<a style="display: none;" href='' class='varolanStandartlariEkleButton'>Seçilenleri Ekle</a>
								</div>
								
								<div style="width: 100%;">
									<table  style="display: none; width: 100%;" id="existing_meslekStandartlari">
										<thead>
											<tr>
												<th>#</th>
												<th>Yeterlilik Adı</th>
												<th>Yeterlilik Seviyesi</th>
												<th>Revizyon</th>
												<th>Yeterlilik Durumu</th>
												<th>Yeterlilik Sektörü</th>
												<th>Teslim Tarihi</th>
											</tr>
										</thead>
										<tbody style="width:100%">
										
										</tbody>
									</table>
								</div>
							
								<div style="clear: both;"></div>
								
								<div style="padding-top:10px; width:100%">
									<a style="display: none;"  href='' class='varolanStandartlariEkleButton'>Seçilenleri Ekle</a>
								</div>
							</div>
									
						</div>
						<div style="clear: both;"></div>
					</div>
					<br/><br/>
					<div id="demo">
						<table style="width: 100%; float:left;" id="meslekStandartlari">
							<thead >
								<tr>
									<th>Yet.Id</th>
									<th>Yeterlilik Adı</th>
									<th>Yeterlilik Seviyesi</th>
									<th>Revizyon</th>
									<th>Yeterlilik Sektörü</th>
									<th>Teslim Tarihi</th>
									<th><?php echo JText::_("EDIT_TEXT"); ?></th>
									<th><?php echo JText::_("DELETE_TEXT"); ?></th>
								</tr>
							</thead>
							<tbody>
							<?php
							$data = $this->seciliProtokolunYeterlilikleri;
		
							if ($data != null){
								foreach ($data as $row){
									$elm = "<tr id='".$row['YETERLILIK_ID']."'>";
									$elm .= "<td>".$row['YETERLILIK_ID']."</td>";
									$elm .= "<td>".$row['YETERLILIK_ADI']."</td>";
									$elm .= "<td>".$row['SEVIYE_ADI']."</td>";
									$elm .= "<td>".$row['REVIZYON']."</td>";
									$elm .= "<td>".$row['SEKTOR_ADI']."</td>";
									
									//$elm .= "<td style='display:none;'>".$row['STANDART_ADI']."</td>";
									
									$elm .= "<td>".$row['YETERLILIK_TESLIM_TARIHI']."</td>";
									$elm .= "<td><a class='editMeslekStandart' href=''>".JText::_("EDIT_TEXT")."</a><br><a class='cancelMeslekStandart' href=''>İptal Et</a></td>";
									$elm .= "<td><a class='deleteMeslekStandart' href=''>".JText::_("DELETE_TEXT")."</a></td>";
										
									$elm .= "</tr>";
										
									echo $elm;
								}
							}
							?>
							</tbody>
						</table>
					</div>
				
				
					<br><br>
					
					
				
				</div>
				<div style="clear:both;"></div>
			</div>
			<div style="clear:both;"></div>
		</div>

	</form>
	
	<div id="dialog-confirm" title="<?php echo JText::_("DELETE_CONFIRM_TITLE");?>">
		<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo JText::_("DELETE_CONFIRM_TEXT");?></p>
	</div>
	
	<div style="clear:both;"></div>
</div>
<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <div class="form_item">
	  <div class="form_element cf_textbox" style="width: 100%;" id="yeterlilik_durum_container">
	    <label class="cf_label" style="width: 150px; float: left;">Yeterlilik Durumu</label>
	    <select name="yeterlilik_durum" id="yeterlilik_durum" style="float: left;">
	    	<option>Seçiniz</option>
	    	<?php foreach ($this->yeterlilikDurumlari as $yeterlilikDurum){ ?>
	    		<option value="<?php echo $yeterlilikDurum['YETERLILIK_DURUM_ID'];?>"><?php echo $yeterlilikDurum['YETERLILIK_DURUM_ADI'];?></option>
	    	<?php }?>
	    </select>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	<div class="form_item">
	  <div class="form_element cf_textbox" style="width: 100%;">
	    <label class="cf_label" style="width: 150px; float: left;">Yeterlilik Adı</label>
	    <select name="yeterlilik_adi" id="yeterlilik_adi" style="width:222px; float: left;">
	    	<option>Seçiniz</option>
	    </select>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	<div class="form_item" style="margin-top:10px;">
		<div style="width:30%; float: right;">	
			<input  type="button" id="yeterLilikRevizyonSec" value="Seç"/>
			<input type="button" id="yeterLilikRevizyonIptal" value="İptal"/>
		</div>
	</div>
</div>
<!-- JAVASCRIPT -->

<script type="text/javascript">

var inputChanged = false;
var settings = {
    "oLanguage": {
		"sLengthMenu": "<?php echo JText::_("LENGTH_MENU");?>",
		"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
		"sInfo": "<?php echo JText::_("INFO");?>",
		"sInfoEmpty": "<?php echo JText::_("INFO_EMPTY");?>",
		"sInfoFiltered": "<?php echo JText::_("INFO_FILTERED");?>",
		"sSearch": "<?php echo JText::_("SEARCH");?>",
		"oPaginate": {
			"sFirst":    "<?php echo JText::_("FIRST");?>",
			"sPrevious": "<?php echo JText::_("PREVIOUS");?>",
			"sNext":     "<?php echo JText::_("NEXT");?>",
			"sLast":     "<?php echo JText::_("LAST");?>"
		}
	}
};

jQuery(document).ready(function() {	
	jQuery( "input:submit", ".submit_button" ).button();	
	//TAKVIM
	jQuery( "#yetkiBaslangiciDatePicker" ).datepicker({ });
	jQuery( "#yetkiBitisiDatePicker" ).datepicker({ });

	jQuery('#varolanStandartEkle_GetirButton').click(function(e) {
			existingVariablesChanged();
	});

	//ON SUBMIT VALIDATE
	jQuery("#yeniProtokolForm").validate();
	jQuery.extend(jQuery.validator.messages, {
	    required: "*"
	});

	jQuery("#yeterlilik_durum").val("2");
	jQuery("#yeterlilik_durum").trigger("change");
	jQuery("#yeterlilik_durum_container").hide();

	//INIT TABLES
    var oTableKurulus = jQuery('#kuruluslar').dataTable(settings);
    var oTableMS = jQuery('#meslekStandartlari').dataTable(settings);  
    var oTableVarolanMS = jQuery('#existing_meslekStandartlari').dataTable(settings);
    var oTableUzatma = jQuery('#uzatmalar').dataTable(settings);
    
	///////////////////////////////////////////////////////////////////////////////////////
	jQuery('input').change(function() {
		inputChanged=true;
	});
	jQuery('select').change(function() {
		inputChanged=true;
	});
  	//EDIT ROW FOR MESLEK STANDARTLARI
    jQuery('#meslekStandartlari a.editMeslekStandart').live('click', function (e) {
        e.preventDefault();
         
        //Get the row as a parent of the link that was clicked on
        var nRow = jQuery(this).parents('tr')[0];
         
        if (this.innerHTML == "<?php echo JText::_("SAVE_TEXT");?>" ) {
            //This row is being edited and should be saved
            if (validate (nRow)){
            	saveMSRow( oTableMS, nRow, false);
            }
        }
        else {
            //No row currently being edited
            editMSRow( oTableMS, nRow, false );
        }
        
       // Stop event handling in IE
        return false;
    } );
  	//END EDIT ROW FOR MESLEK STANDARTLARI
	
	///////////////////////////////////////////////////////////////////////////////////////

  	//SAVE ROW FOR MESLEK STANDARTLARI
    jQuery('#meslekStandartlari a.saveMeslekStandart').live('click', function (e) {
        e.preventDefault();

        var nRow = jQuery(this).parents('tr')[0]; 
        if (validate (nRow)){
        	saveMSRow( oTableMS, nRow, true);
        }

     	// Stop event handling in IE
        return false;
    } );
  	//END SAVE ROW FOR MESLEK STANDARTLARI

	///////////////////////////////////////////////////////////////////////////////////////

	
	jQuery('#yetkilendirmeyeDahilKurulusCheckbox').click(function(e){
		if(jQuery(this).attr('checked')=="checked")
			window.location = 'index.php?option=com_yetkilendirme_yet&layout=yeni&protokolID=<?php echo $_GET['protokolID']; ?>&tumKuruluslar=1';
		else
			window.location = 'index.php?option=com_yetkilendirme_yet&layout=yeni&protokolID=<?php echo $_GET['protokolID']; ?>&tumKuruluslar=0';
	});
		
		
  	//NEW ROW FOR MESLEK STANDARTLARI
    jQuery('#newMeslekStandart').click( function (e) {

    	if(jQuery('.yetkilendirmeTuruRadioButtons').val()=='3')
    	{
    		jQuery('#yeniMeslekStandardiEkleButtonError').html("Revizyon Yetkilendirmesine Yeni Standart Eklenemez");
        }
    	else
    	{
            e.preventDefault();
            var nRow = jQuery(this).parents('tr')[0];
            
            var aiNew = oTableMS.fnAddData( [ '',
											  '', //Meslek Adi
                                              '', //Meslek Seviyesi
                                              '<input type="hidden" name="revizyon" id="revizyon" value="00"/>00', //Revizyon
                                              '', //Meslek Sektoru
                                              '', //Teslim Tarihi
                                              '<a class="editMeslekStandart" href=""><?php echo JText::_("EDIT_TEXT");?></a><br><a class="cancelMeslekStandart" href="">İptal Et</a>', //Guncelle
                                              '<a class="deleteMeslekStandart" href=""><?php echo JText::_("DELETE_TEXT");?></a>' //Sil
                                            ], true );
            var nRow = oTableMS.fnGetNodes( aiNew[0] );
            editMSRow( oTableMS, nRow, true);
            	
    	}
        

     	// Stop event handling in IE
        return false;
    } );
  	//END NEW ROW FOR MESLEK STANDARTLARI

	///////////////////////////////////////////////////////////////////////////////////////
	
    //DELETE ROW FOR MESLEK STANDARTLARI
    jQuery('#meslekStandartlari a.deleteMeslekStandart').live('click', function (e) {
        e.preventDefault();
        var nRow = jQuery(this).parents('tr')[0];
        var id = nRow.getAttribute('id');

      	//Satir yeni eklenmemisse
        if (id != null){
            
	        jQuery( "#dialog-confirm" ).dialog({
		        buttons: {
					"<?php echo JText::_("DELETE_TEXT");?>": function() {
				        deleteMSRow( oTableMS, nRow );
				        jQuery( this ).dialog( "close" );
					},
					"<?php echo JText::_("CANCEL_TEXT");?>": function() {
						jQuery( this ).dialog( "close" );
						
					}
		        }
			});

	        jQuery( "#dialog-confirm" ).dialog("open");
        }else{
        	oTableMS.fnDeleteRow( nRow );
        }      

     	// Stop event handling in IE
        return false;
    } );
  	//END DELETE ROW FOR MESLEK STANDARTLARI

	///////////////////////////////////////////////////////////////////////////////////////

  	//CANCEL EDIT FOR MESLEK STANDARTLARI
    jQuery('#meslekStandartlari a.cancelEditMeslekStandart').live('click', function (e) {
    	e.preventDefault();
        
        var nRow = jQuery(this).parents('tr')[0];
        cancelMSEdit( oTableMS, nRow );

     	// Stop event handling in IE
        return false;
    } );

	//////////////////////////////////
	
	//NEW ROW FOR MESLEK STANDARTLARI
	var existingStandartHidden = 1;
    jQuery('#addExistingMeslekStandart').click( function (e) {

		if(existingStandartHidden==0)//gizli değilse gizle
    	{
			jQuery('#existing_meslekStandartlari').hide("slow");
	    	jQuery('#existing_standart_wrapper').hide("slow");
    		jQuery('#existing_seviyeler').val(0);
    		jQuery('#existing_sektorler').val(0);

    		var oTableVarolanMS = jQuery('#existing_meslekStandartlari').dataTable();
			oTableVarolanMS.fnClearTable();

    		existingStandartHidden = 1;
    	}
    	else // zaten gizliyse göster
    	{
    		jQuery('#existing_standart_wrapper').show("slow");
    		//jQuery('#existing_meslekStandartlari').show("slow");
    		//jQuery('.varolanStandartlariEkleButton').show("slow");
    		
    		existingStandartHidden = 0;
    		existingVariablesChanged();
    	}	
        
     	// Stop event handling in IE
        return false;
    } );
  	//END NEW ROW FOR MESLEK STANDARTLARI
	
	/////////////////////////////////////////////////////
		//NEW ROW FOR UZATMALAR
    jQuery('#newUzatma').click( function (e) {
        e.preventDefault();       
        var aiNew = oTableUzatma.fnAddData( [ '', //Uzatma Suresi
	                                          '', //Aciklama
	                                          '<a class="editUzatma" href=""><?php echo JText::_("EDIT_TEXT");?></a>', //Guncelle
	                                          '<a class="deleteUzatma" href=""><?php echo JText::_("DELETE_TEXT");?></a>' //Sil
	                                        ], true );
        nRow = oTableUzatma.fnGetNodes( aiNew[0] );
        editUzatmaRow( oTableUzatma, nRow, true);

     	// Stop event handling in IE
        return false;
    } );
  	//END NEW ROW FOR UZATMALAR
  	
  	///////////////////////////////////////////////////////////////////////////////////////
  	
  	//SAVE ROW FOR UZATMALAR
    jQuery('#uzatmalar a.saveUzatma').live('click', function (e) {
        e.preventDefault();

        var nRow = jQuery(this).parents('tr')[0]; 
        if (validate (nRow)){
        	saveUzatmaRow( oTableUzatma, nRow, true);
        }

     	// Stop event handling in IE
        return false;
    } );
  	//END SAVE ROW FOR UZATMALAR
  	
  	///////////////////////////////////////////////////////////////////////////////////////
  	
  	//EDIT ROW FOR UZATMALAR
    jQuery('#uzatmalar a.editUzatma').live('click', function (e) {
        e.preventDefault();
         
        //Get the row as a parent of the link that was clicked on
        var nRow = jQuery(this).parents('tr')[0];
         
        if (this.innerHTML == "<?php echo JText::_("SAVE_TEXT");?>" ) {
            //This row is being edited and should be saved
            if (validate (nRow)){
            	saveUzatmaRow( oTableUzatma, nRow, false);
            }
        }
        else {
            //No row currently being edited
            editUzatmaRow( oTableUzatma, nRow, false );
        }

     	// Stop event handling in IE
        return false;
    } );
  	//END EDIT ROW FOR UZATMALAR
  	
  	///////////////////////////////////////////////////////////////////////////////////////
  	
  	//DELETE ROW FOR UZATMALAR
    jQuery('#uzatmalar a.deleteUzatma').live('click', function (e) {
        e.preventDefault();
        var nRow = jQuery(this).parents('tr')[0];
        var id = nRow.getAttribute('id');

      	//Satir yeni eklenmemisse
        if (id != null){
	        jQuery( "#dialog-confirm" ).dialog({
		        buttons: {
					"<?php echo JText::_("DELETE_TEXT");?>": function() {
				        deleteUzatmaRow( oTableUzatma, nRow );
				        jQuery( this ).dialog( "close" );
					},
					"<?php echo JText::_("CANCEL_TEXT");?>": function() {
						jQuery( this ).dialog( "close" );
						
					}
		        }
			});

	        jQuery( "#dialog-confirm" ).dialog("open");
        }else{
        	oTableUzatma.fnDeleteRow( nRow );
        }      

     	// Stop event handling in IE
        return false;
    } );
  	//END DELETE ROW FOR UZATMALAR
  	
	///////////////////////////////////////////////////////////////////////////////////////

  	//CANCEL EDIT FOR UZATMALAR
    jQuery('#uzatmalar a.cancelUzatma').live('click', function (e) {
    	e.preventDefault();
        
        var nRow = jQuery(this).parents('tr')[0];
        cancelUzatmaEdit( oTableUzatma, nRow );

     	// Stop event handling in IE
        return false;
    } );
    
  	///////////////////////////////////////////////////////////////////////////////////////
  	
	//DIALOG
	jQuery( "#dialog:ui-dialog" ).dialog( "destroy" );
	
	jQuery( "#dialog-confirm" ).dialog({
		resizable: false,
		modal: true,
		autoOpen: false
	});


	jQuery("#meslekStandartlari a.cancelMeslekStandart").live('click', function (e) {
        e.preventDefault();
        yeterlilikid = jQuery(this).closest('tr').attr('id');
		if(confirm("İlgili yeterlilik iptal edilecektir.Emin misiniz ?")){
			jQuery.ajax({
				  url: "index.php?option=com_yetkilendirme_yet&task=updateYeterlilikStatus&format=raw",
				  data: "yeterlilik_id="+yeterlilikid+"&yeterlilik_durum=iptal",
				  type: "POST",
				  dataType: 'json',
				  success: function(data) {
					  if(data.ERROR == true){
							alert(data.MESSAGE);
							window.location.reload();
					  }else{
						  alert(data.MESSAGE);
					  }
				  }
			});	
		}
    });


	// ATTACH EVENT TO MOUSEDOWN
	var seciliKurulusIDleri = [];
	var seciliKurulusRolleri = [];
	jQuery('#kuruluslar_next, #kuruluslar_previous').live('mousedown', function (e) {
		kurulusIDleriniKaydet();
	});

	function kurulusIDleriniKaydet()
	{
		jQuery('.kurulusCheckbox').each(function() {
			var index = seciliKurulusIDleri.indexOf(jQuery(this).val());
			if( index != -1)
			{
					seciliKurulusIDleri.splice(index, 1);
					seciliKurulusRolleri.splice(index, 1);
					
			}
		 }); //DROP ALL THE CHECKBOXES IF THEY EXIST

		jQuery('.kurulusCheckbox:checked').each(function() {
			var kurulusID = jQuery(this).val();
			var kurulusRol = jQuery('.kurulusTuruRadioButtons-'+kurulusID+':checked').val();
			
			seciliKurulusIDleri.push(kurulusID);
			seciliKurulusRolleri.push(kurulusRol);
		 });//ADD THE ONES THAT ARE SELECTED AND NOT IN THE ARRAY
	}
	
	jQuery('.kaydetButtonx').live('mousedown', function (e) {
		jQuery(window).unbind('beforeunload');
		kurulusIDleriniKaydet();
		
		var kurulusIdleriText = "";
		var kurulusRolleriText = "";
		for(var i=0; i<seciliKurulusIDleri.length; i++)
		{	//alert(''+seciliKurulusIDleri[i]);
			kurulusIdleriText += "&seciliKurulusIDleri[]=" + seciliKurulusIDleri[i];


			if(typeof(seciliKurulusRolleri[i])=="undefined")
			 	seciliKurulusRolleri[i] = 1; //ASIL KURULUS

			kurulusRolleriText += "&seciliKurulusRolleri[]=" + seciliKurulusRolleri[i];
			
		}
		//alert(kurulusIdleriText+kurulusRolleriText);
		jQuery("#yeniProtokolForm").attr("action", "index.php?option=com_yetkilendirme_yet&amp;task=protokolKaydet" + kurulusIdleriText + kurulusRolleriText);
		jQuery("#yeniProtokolForm").submit();
	});

	
	
	//
    jQuery('#protokoleGitHyperlink').live('click', function (e) {

    	window.open('index.php?option=com_protokol_yet&layout=yeni&protokolID='+jQuery("#ilgiliProtokolIDsiTextbox").val()); 
        
     	// Stop event handling in IE
        return false;
    } );
  	//

	<?php
            if(isset($yetkilendirmeID)){
            ?>
	jQuery('.kurulusradioasil').live('click', function (e) {
		jQuery(this).closest('tr').find('[type=checkbox]').prop('checked', true);
		data=jQuery(this).closest('tr').find('[type=checkbox]').val().split("-");
		kurulus_id=data[0];
		protokol_id=data[1];
		kurulusTuru=1;
		tip="kaydet";
		kurulusKaydetAjax (protokol_id,kurulus_id,kurulusTuru,tip);
	});
	jQuery('.kurulusradioyardimci').live('click', function (e) {
		jQuery(this).closest('tr').find('[type=checkbox]').prop('checked', true);
		data=jQuery(this).closest('tr').find('[type=checkbox]').val().split("-");
		kurulus_id=data[0];
		protokol_id=data[1];
		kurulusTuru=2;
		tip="kaydet";
		kurulusKaydetAjax (protokol_id,kurulus_id,kurulusTuru,tip);
	});


	jQuery('.kurulusCheckbox').live('click', function (e) {
		if (jQuery(this).prop('checked')!=true) {
			data = jQuery(this).val().split("-");
			kurulus_id = data[0];
			protokol_id = data[1];
			kurulusTuru = 0;
			tip = "sil";
			kurulusKaydetAjax(protokol_id, kurulus_id, kurulusTuru, tip);
		}
	});

	function kurulusKaydetAjax(protokol_id, kurulus_id, kurulusTuru, tip){
		jQuery.blockUI();
		jQuery.ajax({
			url: "index.php?option=com_yetkilendirme_ms&task=kurulusKaydetAjax&format=raw",
			data: "protokol_id="+protokol_id+"&kurulus_id="+kurulus_id+"&kurulusTuru="+kurulusTuru+"&tip="+tip,
			type: "POST",
			dataType: 'json',
			success: function(data) {
				jQuery.unblockUI();
				alert (data);
			}
		});
	}
	<?php
	}
	?>
	

} );

function editMSRow ( oTable, nRow, isSave )
{
	inputChanged=true;
	
    var aData = oTable.fnGetData(nRow);
    var jqTds = jQuery('>td', nRow);

    var seviyeOptions = "<?php echo $seviyeOptions;?>";
    var sektorOptions = "<?php echo $sektorOptions;?>";
    var ulusalStandartOptions = "<?php echo $ulusalStandartOptions;?>";
    
    jqTds[1].innerHTML = '<input class="required uppercase" value="'+aData[1]+'" type="text" name="meslekAdi" />';
    jqTds[2].innerHTML = '<select class="required" name="meslekSeviyesi">'+ seviyeOptions + '</select>'; // meslek Seviyeleri
    jqTds[4].innerHTML = '<select class="required" style="width:150px;" name="meslekSektoru">'+ sektorOptions + '</select>'; //meslek sektorleri
   	jqTds[5].innerHTML = '<input value="'+aData[5]+'" type="text" name="protokolTeslim" class="protokolTeslim" maxlength="10" />';
    
    if(!isSave)
    {
    	var selectedSeviyeValue = aData[2];
    	var selectedSektorValue = aData[4];
    	var selectedUlusalStandartValue = aData[5];
    	//SEVIYE
    	var seviyeOptions = jQuery('option:contains("' + selectedSeviyeValue + '")',  jqTds[2]);
    	seviyeOptions.attr('selected', 'selected');
		//SEKTOR
        var sektorOption = jQuery('option:contains("' + selectedSektorValue + '")',  jqTds[4]);
        sektorOption.attr('selected', 'selected');
		
}
    
    jQuery( ".protokolTeslim" ).datepicker({ });
	
	
	//UPPERCASE
	jQuery('.uppercase', nRow).upper({
	     ln: 'tr'
	}); 
    
    if (!isSave)//BURADAKI 5 LER 6 IDI
    	jqTds[6].innerHTML = '<a class="editMeslekStandart" href=""><?php echo JText::_("SAVE_TEXT");?></a><br><a class="cancelEditMeslekStandart" href=""><?php echo JText::_("CANCEL_TEXT");?></a>';
    else
    	jqTds[6].innerHTML = '<a class="saveMeslekStandart" href=""><?php echo JText::_("SAVE_TEXT");?></a>';

}

function cancelMSEdit ( oTable, nRow )
{
    var aData = oTable.fnGetData(nRow);
    var jqTds = jQuery('>td', nRow);
    jqTds[0].innerHTML = aData[0];
    jqTds[1].innerHTML = aData[1];
    jqTds[2].innerHTML = aData[2];
    jqTds[3].innerHTML = aData[3];
    jqTds[4].innerHTML = aData[4];
    //jqTds[5].innerHTML = aData[5];
    jqTds[5].innerHTML = '<a class="editMeslekStandart" href=""><?php echo JText::_("EDIT_TEXT");?></a><br><a class="cancelMeslekStandart" href="">İptal Et</a>';
}

function saveMSRow ( oTable, nRow, isSave )
{
	var jqInputs = jQuery('input', nRow);
	var jqSelects = jQuery('select', nRow);
	
	var sendData = jqInputs.serializeArray();
	var sendDataSelects = jqSelects.serializeArray();
	var sendDataAll = sendData.concat(sendDataSelects);
	
	var protokolIDD = jQuery("#protokolID").val();
		
	var url = 'index.php?option=com_yetkilendirme_yet&task=ajaxSaveRow&format=raw&protokolID='+protokolIDD;

	if (!isSave){
		url = 'index.php?option=com_yetkilendirme_yet&task=ajaxEditRow&format=raw&protokolID='+protokolIDD;

		var obj = new Object;
		obj.name= 'id';
		obj.value= nRow.getAttribute('id');

		sendDataAll.push(obj);
	}
			
	jQuery.ajax({
		  url: url,
		  data: sendDataAll,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
				  //alert("Başarıyla Eklendi");
				jQuery("#bilgilendirme").html(data['data']);

				
				
			    oTable.fnUpdate( jqInputs[0].value, nRow, 1, false );
			    oTable.fnUpdate( jQuery(jqSelects[0]).find("option:selected").text(), nRow, 2, false );
			    oTable.fnUpdate( "00", nRow, 3, false );
			    oTable.fnUpdate( jQuery(jqSelects[1]).find("option:selected").text(), nRow, 4, false );
			   	oTable.fnUpdate( jqInputs[1].value, nRow, 5, false );
			    oTable.fnUpdate( '<a class="editMeslekStandart" href=""><?php echo JText::_("EDIT_TEXT");?></a>', nRow, 6, false );
			    oTable.fnUpdate( '<a class="deleteMeslekStandart" href=""><?php echo JText::_("DELETE_TEXT"); ?></a>', nRow, 7, false );

				  if (isSave){
						nRow.setAttribute('id', data['id']);				
						alert("Başarıyla eklendi");				
					}

			  }
			  else
			  {
				alert("Eklemede hata");
			  	jQuery("#bilgilendirme").html(data['data']);
			  }

			  oTable.fnDraw();	 
		  }
	});
}

function deleteMSRow ( oTable, nRow)
{
	var jqInputs = jQuery('input', nRow);
	var sendData = jqInputs.serializeArray();

	var obj = new Object;
	obj.name= 'id';
	obj.value= nRow.getAttribute('id');

	
	sendData.push(obj);

	var protokolIDD = document.getElementById("protokolID").value;
	
	jQuery.ajax({
		  url: "index.php?option=com_yetkilendirme_yet&task=ajaxDeleteRow&format=raw&protokolID="+protokolIDD,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
				jQuery("#bilgilendirme").html(data['data']);
				oTable.fnDeleteRow( nRow );
				updateProtokolunStandartlari(data['array']);
				existingVariablesChanged();
			  }else{
			  	jQuery("#bilgilendirme").html(data['data']);
			  	oTable.fnDraw();
			  }
		  }
	});	
}

//FILE UPLOAD
dTables.protokolDosya = new Array(new Array("upload"));

function createTables(){
	tableName = "protokolDosya";
	createTable(tableName, new Array(''));
	satirEkleKaldir (tableName);
	satirSilKaldir (tableName, 0);
	addProtokolDosya (tableName);
}

function addProtokolDosya (tableName){
	<?php
 	$path = $dosya;	
 	echo "var path = '".FormFactory::normalizeVariable ($path)."';";
 	echo "var fileName = '".FormFactory::getNormalFilename(basename  ($path))."';";
	?>

	if (path != null && path != ''){
		var id		 = tableName + "_0";
		var sira	 = 1;
		var resultDiv 	= document.getElementById(id + "_result_div_" + sira);
		var inputPath = '<input type="hidden" value="'+path+'" name="path_'+id+'_'+sira +'">' +
						'<input type="hidden" value="" name="filename_'+id+'_'+sira +'">';				
			
		var result = inputPath + '<div class="up_success">'+fileName+' yüklendi!';
		result 	  += '<input type="button" value="İndir" onclick="window.location.href=\'index.php?option=com_yetkilendirme_yet&amp;task=indir&amp;protokolID=<?php echo $protokolID;?>\'" class="up_submitbtn" style="float:none;"> <\/div>';
		result 	  += '<div><input type="button" value="Değiştir" onclick="removeUploaded(\''+id+'\',\''+sira+'\')" /><\/div>';
		resultDiv.innerHTML = result;
	
		var uploadSpan = document.getElementById(id + "_upload_form_span_" + sira);
		uploadSpan.style.visibility = 'hidden';
		uploadSpan.style.height = 0;
	}
}

function existingVariablesChanged()
{
	if(jQuery("#existing_sektorler").val()== 0 && jQuery("#existing_seviyeler").val()== 0  )
	{	//IKISI DE SECILI DEGIL
		jQuery("#existing_sektorler").css("border", "1px solid red");
		jQuery("#existing_seviyeler").css("border", "1px solid red");

		jQuery("#varolanStandartlarContainer").hide("slow");
		jQuery(".varolanStandartlariEkleButton").hide("slow");
		jQuery("#existing_meslekStandartlari").hide("slow");
		
	}
	else
	{
		jQuery("#existing_sektorler").css("border", "1px solid #C6C3C6");
		jQuery("#existing_seviyeler").css("border", "1px solid #C6C3C6");

		jQuery("#varolanStandartlarContainer").show("slow");
		jQuery("#existing_meslekStandartlari").show("slow");
		
		
		
		var sektorlerText = "";
		var seviyelerText = "";
		var sendData = null;
		var protokolIDText = "&protokolID=<?php echo $_REQUEST['protokolID'];?>";
		
		if(jQuery("#existing_sektorler").val()!= 0  ) ;
			sektorlerText = "&sektorID="+jQuery("#existing_sektorler").val();
		if(jQuery("#existing_seviyeler").val()!= 0  ) ;
			seviyelerText = "&seviyeID="+jQuery("#existing_seviyeler").val();


			var oTableVarolanMS = jQuery('#existing_meslekStandartlari').dataTable();
			oTableVarolanMS.fnClearTable();
			oTableVarolanMS.fnAddData( ["GETİRİLİYOR.", "","","","", "", "",""]);

			var revizyonMu;
// 			if(jQuery('#varolanStandartEkle_RevizyonluCheckbox_Revizyon').attr('checked')=='checked')//revizyonsa
// 				revizyonMu = '&revizyonMu=1';
// 			else
				revizyonMu = '';
				
			jQuery.ajax({
				  url: "index.php?option=com_yetkilendirme_yet"+revizyonMu+"&task=ajaxFetchExistingStandart&format=raw"+seviyelerText+sektorlerText+protokolIDText,
				  data: sendData,
				  type: "POST",
				  dataType: 'json',
				  success: function(data) {
					  if(data['success']){
						//jQuery("#bilgilendirme").html(data['data']);
						//alert('success');
						putVarolanStandartDataToGrid(data['array']);
						jQuery(".varolanStandartlariEkleButton").show("slow");
						//oTable.fnDeleteRow( nRow );
					  }else{
					  	//jQuery("#bilgilendirme").html(data['data']);
						//alert("FAIL, LOL!");
					  	//oTable.fnDraw();
						oTableVarolanMS.fnClearTable();
						oTableVarolanMS.fnAddData( [ data['data'], "","","","","","", ""]);

						jQuery(".varolanStandartlariEkleButton").hide("slow");
						
					  }
				  }
			});

		
	}
}

function putVarolanStandartDataToGrid(arrayToPut)
{
	jQuery('#existing_meslekStandartlari').show("slow");

	var oTableVarolanMS = jQuery('#existing_meslekStandartlari').dataTable();

	oTableVarolanMS.fnClearTable();
	
    for(var i=0; i<arrayToPut.length; i++)
    {
    	oTableVarolanMS.fnAddData( [
"<input type='checkbox' value='"+arrayToPut[i]["YETERLILIK_ID"]+"' id='varolanStandartlarCheckbox-"+i+"' name='varolanStandartlarCheckbox[]' class='varolanStandartlarCheckbox' /> ",
arrayToPut[i]["YETERLILIK_ADI"],
arrayToPut[i]["SEVIYE_ADI"],
arrayToPut[i]["REVIZYON"],
arrayToPut[i]["YETERLILIK_DURUM_ADI"],
arrayToPut[i]["SEKTOR_ADI"],
arrayToPut[i]["YETERLILIK_TESLIM_TARIHI"]]);
    }  
    
}

//
jQuery('.varolanStandartlariEkleButton').live('click', function (e) {

	if(jQuery("#existing_sektorler").val()== 0 && jQuery("#existing_seviyeler").val()== 0  )
	{	//IKISI DE SECILI DEGIL
		jQuery("#existing_sektorler").css("border", "1px solid red");
		jQuery("#existing_seviyeler").css("border", "1px solid red");
		
	}
	else
	{
		jQuery("#existing_sektorler").css("border", "1px solid #C6C3C6");
		jQuery("#existing_seviyeler").css("border", "1px solid #C6C3C6");
	
    	var jqInputs = jQuery('.varolanStandartlarCheckbox');
    	var sendData = jqInputs.serializeArray();
    	
		var url = 'index.php?option=com_yetkilendirme_yet&task=ajaxAddFromVarolanStandartlar&format=raw&protokolID=<?php echo $_REQUEST['protokolID'] ?>';
		
    	jQuery.ajax({
    		  url: url,
    		  data: sendData,
    		  type: "POST",
    		  dataType: 'json',
    		  success: function(data) {
    			  if(data['success']){
    				  alert("Başarıyla Eklendi");
    			    	existingVariablesChanged();
    			    	updateProtokolunStandartlari(data['array']);


    			    	jQuery('#existing_meslekStandartlari').hide("slow");
    			    	jQuery('#existing_standart_wrapper').hide("slow");
    		    		jQuery('#existing_seviyeler').val(0);
    		    		jQuery('#existing_sektorler').val(0);

    		    		var oTableVarolanMS = jQuery('#existing_meslekStandartlari').dataTable();
    					oTableVarolanMS.fnClearTable();

    		    		existingStandartHidden = 1;
    			      
     			  }
     			  else
         	      {
    				  alert("FAIL, LOL!");
    			  }
    		  }
    	});
	}
	// Stop event handling in IE
    return false;
} );

jQuery(".saveRevizyon").live('click', function (e) { 
	var nRow = jQuery(this).parents('tr')[0]; 
	var jqInputs = jQuery('input', nRow);
	var jqSelects = jQuery('select', nRow);
	
	var yetid 			= jQuery(this).closest('tr').attr("tempid");
	var meslekSeviyesi 	= jQuery(this).closest('tr').find("[name=meslekSeviyesi]").val();
	var revizyon 		= jQuery(this).closest('tr').find("[name=revizyon]").val();
	var meslekSektoru 	= jQuery(this).closest('tr').find("[name=meslekSektoru]").val();
	var protokolTeslim 	= jQuery(this).closest('tr').find("[name=protokolTeslim]").val();
	
	var sendData = "yeterlilik_id="+yetid+"&meslekseviyesi="+meslekSeviyesi+"&revizyon="+revizyon+"&mesleksektoru="+meslekSektoru+"&protokolteslim="+protokolTeslim+"&protokolid="+jQuery("#protokolID").val();
	jQuery.ajax({
		  url: "index.php?option=com_yetkilendirme_yet&task=ajaxRevizyonOlustur&format=raw&yetid="+yetid,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['status'] == "1"){
				jQuery(nRow).removeAttr("tempid");
				jQuery(nRow).attr('id',data['yeterlilik_id']);
				jQuery(nRow).find(".revizyon").val(data['revizyon']);
				jQuery(nRow).find("td:eq(0)").html(data['yeterlilik_id']);
				jQuery(nRow).find("td:eq(1)").html(jQuery(nRow).find("input[name=meslekAdi]").val());
				jQuery(nRow).find("td:eq(2)").html(jQuery(nRow).find("select[name=meslekSeviyesi] option:selected").html());
				jQuery(nRow).find("td:eq(3)").html(jQuery(nRow).find(".revizyon").val());
				jQuery(nRow).find("td:eq(4)").html(jQuery(nRow).find("select[name=meslekSektoru] option:selected").html());
				jQuery(nRow).find("td:eq(5)").html(jQuery(nRow).find("input[name=protokolTeslim]").val());
				jQuery(nRow).find("td:eq(6)").html("<a class='editMeslekStandart' href=''>Güncelle</a><br><a class='cancelMeslekStandart' href=''>İptal Et</a>");
				jQuery(nRow).find("td:eq(7)").html("<a class='deleteMeslekStandart' href=''>Sil</a>");
				//updateYetkilendirmeStandartlari(data['array']);
				//existingVariablesChanged();
			  }else{
			  	oTable.fnDraw();
			  }
		  }
	});
	return false;
});
jQuery("#newRevizyonEkle").click(function(){
	jQuery('#loaderGif').lightbox_me({
		centered: true,
        closeClick:false,
        closeEsc:false  
    });
    return false;
});
jQuery("#loaderGif #yeterlilik_durum").change(function(){
	jQuery.ajax({
		  url: "index.php?option=com_yetkilendirme_yet&task=ajaxYeterlilikGetirByStatus&format=raw&yetstatus="+jQuery(this).val(),
		  type: "POST",
		  dataType: 'json',
          beforeSend: function() {
        	  jQuery("#loaderGif #yeterlilik_adi").html("<option>Seçiniz</option>");
          },
		  success: function(data) {	  
			  jQuery.each(data, function(key,val){
			        jQuery("#loaderGif #yeterlilik_adi").append("<option value="+val.YETERLILIK_ID+">"+val.YETERLILIK_ADI+"</option>");
			    });
		  }
	});
});
jQuery(".cancelRevizyon").live('click',function(){
	var oTableMS = jQuery('#meslekStandartlari').dataTable();
	var nRow = jQuery(this).parents('tr')[0]; 
	oTableMS.fnDeleteRow( nRow );
	return false;
});
jQuery("#yeterLilikRevizyonSec").click(function(){
	jQuery.ajax({
		  url: "index.php?option=com_yetkilendirme_yet&task=ajaxYeterlilikGetirById&format=raw&yetid="+jQuery(this).closest("#loaderGif").find("#yeterlilik_adi").val(),
		  type: "POST",
		  dataType: 'json',
        beforeSend: function() {
        	jQuery('#loaderGif').trigger('close');
        },
		  success: function(data) {
			  if(data['status'] == "1"){ console.log(data['result']);
					var oTableMS = jQuery('#meslekStandartlari').dataTable();
				    var nRow = jQuery(this).parents('tr')[0];
				 
				    var yetid = data['result']['YETERLILIK_ID'];
				    
				    var aiNew = oTableMS.fnAddData( [ '',
													  '', //Meslek Adi
				                                      '', //Meslek Seviyesi
				                                      '', //Revizyon
				                                      '', //Meslek Sektoru
				                                      '', //Teslim Tarihi
				                                      '<a class="editMeslekStandart" href="#" onClick="event.preventDefault(); return false;"><?php echo JText::_("EDIT_TEXT");?></a><br><a class="cancelMeslekStandart" href="">İptal Et</a>', //Guncelle
				                                      ''//Sil
				                                    ], true );
				    var oTableMS = jQuery('#meslekStandartlari').dataTable();
				    var nRow = oTableMS.fnGetNodes( aiNew[0] );
				    var aData = oTableMS.fnGetData(nRow);
				    jQuery(nRow).attr("tempid",yetid);
				    var jqTds = jQuery('>td', nRow);

				    var seviyeOptions = "<?php echo $seviyeOptions;?>";
				    var sektorOptions = "<?php echo $sektorOptions;?>";
				    var ulusalStandartOptions = "<?php echo $ulusalStandartOptions;?>";
				    jqTds[1].innerHTML = '';
				    jqTds[1].innerHTML = '<input class="required uppercase" id="meslekadi_'+yetid+'_rev" value="'+data['result']['YETERLILIK_ADI']+'" type="text" name="meslekAdi" />';
				    jqTds[2].innerHTML = '<select class="required" name="meslekSeviyesi" id="meslekseviyesi_'+yetid+'_rev">'+ seviyeOptions + '</select>'; // meslek Seviyeleri
				    jqTds[3].innerHTML = '<input value="'+data['result']['REVIZYON']+'" type="text" name="revizyon" id="revizyon_'+yetid+'_rev" class="revizyon" maxlength="2" style="width:82px;" />';
				    jqTds[4].innerHTML = '<select class="required" style="width:150px;" id="mesleksektoru_'+yetid+'_rev" name="meslekSektoru">'+ sektorOptions + '</select>'; //meslek sektorleri
				   	jqTds[5].innerHTML = '<input value="'+aData[4]+'" type="text" name="protokolTeslim" id="protokolteslim_'+yetid+'_rev" class="protokolTeslim" maxlength="10" />';

				    jQuery("#meslekseviyesi_"+yetid+"_rev").val(data['result']['SEVIYE_ID']);
				    jQuery("#mesleksektoru_"+yetid+"_rev").val(data['result']['SEKTOR_ID']);
//				     jQuery("#protokolteslim_"+yetid+"_rev").val(jQuery(this).closest("tr").find('td:eq(4)').html());
				    
				    jQuery( ".protokolTeslim" ).datepicker({ });
					
					
					//UPPERCASE
					jQuery('.uppercase', nRow).upper({
					     ln: 'tr'
					}); 

				    jqTds[6].innerHTML = '<a class="saveRevizyon"><?php echo JText::_("SAVE_TEXT");?></a> <a class="cancelRevizyon" href=""><?php echo JText::_("CANCEL_TEXT");?></a>';
				    
			  }

		  }
	});
	
});
jQuery("#yeterLilikRevizyonIptal").click(function(){
	jQuery('#loaderGif').trigger('close');
});
	//
function updateProtokolunStandartlari(arrayToPut)
{
	var oTableMS = jQuery('#meslekStandartlari').dataTable();

	oTableMS.fnClearTable();
	for(var i=0; i<arrayToPut.length; i++)
    {
    	var a = oTableMS.fnAddData( [
			arrayToPut[i]["YETERLILIK_ID"],
			arrayToPut[i]["YETERLILIK_ADI"],
			arrayToPut[i]["SEVIYE_ADI"],
			arrayToPut[i]["REVIZYON"],
			arrayToPut[i]["SEKTOR_ADI"],
			arrayToPut[i]["YETERLILIK_TESLIM_TARIHI"],
			'<td><a class="editMeslekStandart" href=""><?php echo JText::_("EDIT_TEXT"); ?></a><br><a class="cancelMeslekStandart" href="">İptal Et</a></td>',
			'<td><a class="deleteMeslekStandart" href=""><?php echo JText::_("DELETE_TEXT"); ?></a></td>'
		]);
		
      	
      	var nRow = oTableMS.fnSettings().aoData[ a[0] ].nTr;
      	//var nRow = jQuery('#meslekStandartlari tbody').find('tr')[index]; 
      	//alert(nRow.innerHTML);
        nRow.setAttribute('id', arrayToPut[i]["YETERLILIK_ID"]);
    }   
	
}


//UZATMA ILE ILGILI KISIMLAR
function editUzatmaRow ( oTable, nRow, isSave )
{
	
	inputChanged=true;
	
  var aData = oTable.fnGetData(nRow);
  var jqTds = jQuery('>td', nRow);
  
  jqTds[0].innerHTML = '<input size="40" class="required " value="'+aData[0]+'" type="text" name="uzatmaSuresi"  onkeyup="jQuery(this).val(jQuery(this).val().replace(/\\D/g,\'\'));" />';
  jqTds[1].innerHTML = '<input size="50" class=" " value="'+aData[1]+'" type="text" name="uzatmaAciklama"/>';

  
  if (!isSave)
  	jqTds[2].innerHTML = '<a class="editUzatma" href=""><?php echo JText::_("SAVE_TEXT");?></a> <a class="cancelUzatma" href=""><?php echo JText::_("CANCEL_TEXT");?></a>';
  else
  	jqTds[2].innerHTML = '<a class="saveUzatma" href=""><?php echo JText::_("SAVE_TEXT");?></a>';
	
}

function cancelUzatmaEdit ( oTable, nRow )
{
	
  var aData = oTable.fnGetData(nRow);
  var jqTds = jQuery('>td', nRow);
  jqTds[0].innerHTML = aData[0];
  jqTds[1].innerHTML = aData[1];
  jqTds[2].innerHTML = '<a class="editUzatma" href=""><?php echo JText::_("EDIT_TEXT");?></a>';

}

function saveUzatmaRow ( oTable, nRow, isSave )
{
	
	var jqInputs = jQuery('input', nRow);
	var jqSelects = jQuery('select', nRow);
	
	var sendData = jqInputs.serializeArray();
	var sendDataSelects = jqSelects.serializeArray();
	var sendDataAll = sendData.concat(sendDataSelects);
	
	var protokolID = jQuery("#protokolID").val();
		
	var url = 'index.php?option=com_yetkilendirme_yet&task=ajaxUzatmaKaydet&format=raw&protokolID='+protokolID;

	if (!isSave){
		url = 'index.php?option=com_yetkilendirme_yet&task=ajaxUzatmaGuncelle&format=raw&protokolID='+protokolID;

		var obj = new Object;
		obj.name= 'id';
		obj.value= nRow.getAttribute('id');
		
		sendDataAll.push(obj);
	}
			
	jQuery.ajax({
		  url: url,
		  data: sendDataAll,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){				
			    oTable.fnUpdate( jqInputs[0].value, nRow, 0, false );
			    oTable.fnUpdate( jqInputs[1].value, nRow, 1, false );
			    oTable.fnUpdate( '<a class="editUzatma" href=""><?php echo JText::_("EDIT_TEXT");?></a>', nRow, 2, false );

				  if (isSave){
						nRow.setAttribute('id', data['id']);
						alert("Başarıyla eklendi");					
					}
			  }
			  else
			  {
				  alert("Eklemede hata");
			  }

			  oTable.fnDraw();	 
		  }
	});
	
}

function deleteUzatmaRow ( oTable, nRow)
{
	
	var jqInputs = jQuery('input', nRow);
	var sendData = jqInputs.serializeArray();

	var obj = new Object;
	obj.name= 'id';
	obj.value= nRow.getAttribute('id');

	sendData.push(obj);

	var protokolID = document.getElementById("protokolID").value;
	
	jQuery.ajax({
		  url: "index.php?option=com_yetkilendirme_yet&task=ajaxUzatmaSil&format=raw&protokolID="+protokolID,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
				oTable.fnDeleteRow( nRow );
				//updateYetkilendirmeStandartlari(data['array']);
				//existingVariablesChanged();
			  }else{
			  	oTable.fnDraw();
			  }
		  }
	});
	
}



</script>