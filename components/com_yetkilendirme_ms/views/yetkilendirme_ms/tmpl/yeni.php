<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once("libraries/joomla/utilities/browser_detection.php");
$user_browser = browser_detection('browser');

$classBirinci = "leftCol";
$classIkinci = "rightCol";

$yetkilendirmeID = JRequest::getVar("yetkilendirmeID");

if(isset($yetkilendirmeID))
{
	if(!$this->meslekStandardiYetkilendirmesiMi)
	{
		global $mainframe;
		$mainframe->redirect("index.php?option=com_yetkilendirme_ms&layout=yeni", "Bu yetkilendirme meslek standardı yetkilendirmesi değil.", 'error');
	}


	$arr[0] = "1";
	$arr[1] = "2";

	$seciliYetkilendirme = $this->seciliYetkilendirme;
	$seciliYetkilendirmeKuruluslari = $this->seciliYetkilendirmeKuruluslari;

	$yetkilendirmeAdi = $seciliYetkilendirme[0]["ADI"];
	$yetkiBaslangici = $seciliYetkilendirme[0]["IMZA_TARIHI"];
	$yetkiBitisi = $seciliYetkilendirme[0]["BITIS_TARIHI"];
	$dosya = $seciliYetkilendirme[0]["DOSYA"];
	$ilgiliProtokolIDsi = $seciliYetkilendirme[0]["ILGILI_PROTOKOL_ID"];
	$yetkilendirmeSuresi = $seciliYetkilendirme[0]["SURESI"];
	$yetkilendirmeTuru = $seciliYetkilendirme[0]["YETKILENDIRME_TURU"];

	$kurulusVeStandartVisibilitysi = "display: block;";
	$kaydetButtonTexti = "Kuruluşları Kaydet";
	
	if($seciliYetkilendirme[0]["PROTOKOL_MU"]=="1")
		$protokolMuRadioText = '<input value="1" type="radio" name="protokolMuRadioButtons[]" checked>Protokol<br>
								<input value="0" type="radio" name="protokolMuRadioButtons[]" >Yetkilendirme<br>';
	else
		$protokolMuRadioText = '<input value="1" type="radio" name="protokolMuRadioButtons[]">Protokol<br>
								<input value="0" type="radio" name="protokolMuRadioButtons[]" checked>Yetkilendirme<br>';
	
}
else
{
	$protokolMuRadioText = '<input value="1" type="radio" name="protokolMuRadioButtons[]" checked>Protokol<br>
							<input value="0" type="radio" name="protokolMuRadioButtons[]" >Yetkilendirme<br>';
	
	$kurulusVeStandartVisibilitysi = "display: none;";
	$kaydetButtonTexti = "Kuruluş ve Standart Ekle";
}
$meslekStandartSeviyeleri = $this->meslekStandartSeviyeleri;
$meslekStandartSektorleri = $this->meslekStandartSektorleri;
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

//YETKILENDIRME TURU ICIN
$yetkilendirmeTuruOptions = "";
foreach($yetkilendirmeTurleri as $yTuru){

	if($yetkilendirmeTuru == $yTuru["TUR_ID"])
		$seciliMiText = ' selected="selected" ';
	else
		$seciliMiText = '';
	
	$yetkilendirmeTuruOptions .= "<option value='".$yTuru["TUR_ID"]."' ".$seciliMiText." >".$yTuru["ACIKLAMA"]."</option>";
}

?>
<div class="form_item">
	<div class="form_element cf_heading">
		<h1 class="contentheading">Meslek Standardı Yetkilendirme</h1>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_content">
	<form method="post" id="yeniYetkilendirmeForm"
		action="index.php?option=com_yetkilendirme_ms&amp;task=yetkilendirmeKaydet">
		<input type="hidden" id="yetkilendirmeID" name="yetkilendirmeID"
			value="<?php echo $yetkilendirmeID;?>" />

		<div style="display:none;" class="form_row">
			<div class="<?php echo $classBirinci; ?>">
						<strong>Yetkilendirme Turu:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<?php if(strlen($yetkilendirmeID)>0)
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
				<input type="text" name="ilgiliProtokolIDsiTextbox" id="ilgiliProtokolIDsiTextbox"
					value="<?php echo $ilgiliProtokolIDsi; ?>" maxlength="400" />
				<a id="protokoleGitHyperlink" href="#">Protokole Git</a>
			</div>
			<div style="clear:both;"></div>
		</div>
		
		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Yetkilendirme Adı:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input type="text" name="yetkilendirmeAdiTextbox" class="required"
					id="yetkilendirmeAdi" value="<?php echo $yetkilendirmeAdi; ?>"
					maxlength="400" style="width: 300px;" />
			</div>
			<div style="clear: both;"></div>
		</div>
		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Başlangıç Tarihi:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input class="required" type="text" maxlength="10" name="yetkiBaslangiciDatePicker" id="yetkiBaslangiciDatePicker"
					value="<?php echo $yetkiBaslangici; ?>" />
			</div>
			<div style="clear: both;"></div>
		</div>
		<div class="form_row">
			<div class="<?php echo $classBirinci; ?>">
				<strong>Bitiş Tarihi</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<input class="required"  type="text" maxlength="10" name="yetkiBitisiDatePicker" id="yetkiBitisiDatePicker"
					value="<?php echo $yetkiBitisi; ?>" />
			</div>
			<div style="clear: both;"></div>
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
		
		
		<div style="display:none;"  class="form_row">
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
				<strong>Yetkilendirme Dosyası:</strong>
			</div>
			<div class="<?php echo $classIkinci; ?>">
				<div id="yetkilendirmeDosya_div"></div>
			</div>
			<div style="clear: both;"></div>
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
		
		
		
		
		
		
		
		<div style="<?php echo $kurulusVeStandartVisibilitysi; ?>" class="kurulus_wrapper">
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
		
		
		
		<div style="<?php echo $kurulusVeStandartVisibilitysi; ?>" class="kurulus_wrapper">
			<div class="title_wrapper">
				<strong> Yetkilendirmeye Dahil Kuruluşlar:</strong>
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
							
							$checked = "";
							$class = "";
							$rowChecked = false;
							$yetkilendirmeKurulusTuru_AsilChecked = "";
							$yetkilendirmeKurulusTuru_YardimciChecked = "";
							
							foreach($seciliYetkilendirmeKuruluslari as $seciliYetkilendirmeKurulusu){
								if($kuruluslar[$i]["USER_ID"]== $seciliYetkilendirmeKurulusu["USER_ID"])
								{
									$checked = ' checked="checked" ';
									$rowChecked = true;
									$class = 'checkedRow';
									
									if($seciliYetkilendirmeKurulusu["KURULUS_TURU"] == PM_YETKILENDIRME_KURULUS_TURU__YARDIMCI)
									$yetkilendirmeKurulusTuru_YardimciChecked = "checked='checked'";
									else
									$yetkilendirmeKurulusTuru_AsilChecked = "checked='checked'";
									
									$seciliYetkilendirmeKuruluslari[$j]["FOUNDED"] = true;
									
									$j++;
								}
							}
						
							$allTheRowContents .= '<tr class=" '.$class.' ">';
							$allTheRowContents .= '<td><input type="checkbox" value="'.$kuruluslar[$i]["USER_ID"].'-'.$yetkilendirmeID.'" name="kurulusCheckbox[]" class="kurulusCheckbox" '.$checked.' ></td>';
							
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
						
						foreach($seciliYetkilendirmeKuruluslari as $secili){
							if(!isset($secili['FOUNDED']) && !isset($_GET['tumKuruluslar'])){
								header('Location:index.php?option=com_yetkilendirme_ms&layout=yeni&yetkilendirmeID='.$_GET['yetkilendirmeID'].'&tumKuruluslar=1');
							}
						}
						
						echo $allTheTableContents;
						
						?>
						</tbody>
					</table>
				</div>
				
				<?php 
//				if(isset($yetkilendirmeID))
//				{
//					echo '<br><br><div class="submit_button">
//					<input style="padding:0px; float:left;" type="submit" value="'.$kaydetButtonTexti.'"
//					name="kaydetButton" class="kaydetButtonx" id="kaydetButton" />
//						<br></div>';
//
//				}
					
			?>
				
			</div>
			<div style="clear: both;"></div>
		</div>

		<?php
		if(!isset($yetkilendirmeID))
				{
					echo '<div class="submit_button">
					<input type="submit" value="'.$kaydetButtonTexti.'"
					name="kaydetButton" class="kaydetButton" id="kaydetButton" />
					</div>';

				}
		?>
				
		<div style="<?php echo $kurulusVeStandartVisibilitysi; ?>" class="standart_wrapper">
			
			<div>
				<strong>Yetkilendirme Dahilindeki Meslek Standartları:</strong>
			</div>
			<div class="gridview_wrapper" >
				<div id="container">
					<div style="float:left; padding-top: 10px;padding-bottom: 10px;">
						<a id="newMeslekStandart" href="">Yeni Meslek Standardı Ekle </a><font id="yeniMeslekStandardiEkleButtonError" color="red"></font>
					</div>
					<div style="float:left; padding: 10px 0 10px 20px;">
						<a id="addExistingMeslekStandart" href="">Varolan Meslek Standardı Ekle</a>
					</div>
					<div style="float:left; padding: 10px 0 10px 20px;">
						<a id="newRevizyonEkle" href="">Yeni Revizyon Ekle </a><font id="newRevizyonEkleButtonError" color="red"></font>
					</div>
					<div style="float:left; margin:10px 0 10px 0; width:100%; display: none;border: 1px solid #898989;" class="existing_standart_wrapper"
						id="existing_standart_wrapper">

						<div id="existing_standart_container">

							<div style="background-color: #CDCDCD;padding: 5px;">
								Meslek Seviyesi Seçiniz:<br> <select id="existing_seviyeler">
								<?php
								$seviyeler = $this->meslekStandartSeviyeleri;
								echo "<option value='0'>Seçiniz</option>";
								for($i = 0; $i< count($seviyeler); $i++)
								echo "<option value='".$seviyeler[$i]["SEVIYE_ID"]."'>" .$seviyeler[$i]["SEVIYE_ADI"]. "</option>";
								?>
								</select> <br> Meslek Sektörü Seçiniz:<br> 
								<select
									id="existing_sektorler">
									<?php
									$sektorler = $this->meslekStandartSektorleri;
									echo "<option value='0'>Seçiniz</option>";
									for($i = 0; $i< count($sektorler); $i++)
									echo "<option value='".$sektorler[$i]["SEKTOR_ID"]."'>" .$sektorler[$i]["SEKTOR_ADI"]. "</option>";
									?>
								</select>
								<input type="button" value="Getir" id="varolanStandartEkle_GetirButton">
							</div>

							<div id="varolanStandartlarContainer" style="padding: 5px;  display:none;">
								<div style="width: 100%; padding-bottom:10px;">
									<a  style="display: none;"  href='' class='varolanStandartlariEkleButton'>Seçilenleri Ekle</a>
								</div>
								
								<div style="width: 100%;">
									<table  style="display: none; width: 100%;"	id="existing_meslekStandartlari">
										<thead>
											<tr>
												<th>#</th>
												<th>Standart Adı</th>
												<th>Standart Seviyesi</th>
												<th>Revizyon</th>
												<th>Standart Sektörü</th>
												<th>Standart Durumu</th>	
											</tr>
										</thead>
										<tbody>
	
										</tbody>
									</table>
								</div>

								<div style="clear: both;"></div>
								<div style="width: 100%; padding-top:10px;">
									<a style="display: none;" href='' class='varolanStandartlariEkleButton'>Seçilenleri Ekle</a>
								</div>
							</div>
						</div>
						<div style="clear: both;"></div>
					</div>
					<div id="demo">
						<table style="width: 100%;"
							id="meslekStandartlari">
							<thead>
								<tr>
									<th>Mes. Id</th>
									<th>Meslek Adı</th>
									<th>Meslek Seviyesi</th>
									<th>Revizyon</th>
									<th>Durumu</th>
									<th>Meslek Sektörü</th>
									<th>Teslim Tarihi</th>
									<th><?php echo JText::_("EDIT_TEXT"); ?></th>
									<th><?php echo JText::_("DELETE_TEXT"); ?></th>
								</tr>
							</thead>
							<tbody>

							<?php
							$data = $this->seciliYetkilendirmeStandartlari;

							if ($data != null){
								foreach ($data as $row){
									$elm = "<tr id='".$row['STANDART_ID']."'>";
									$elm .= "<td class='standartid'>".$row['STANDART_ID']."</td>";
									$elm .= "<td class='standart'>".$row['STANDART_ADI']."</td>";
									$elm .= "<td class='seviye'>".$row['SEVIYE_ADI']."</td>";
									$elm .= "<td class='revizyon'>".$row['REVIZYON']."</td>";
									$elm .= "<td class='durum'>".$row['MESLEK_STANDART_DURUM_ADI']."</td>";
									$elm .= "<td class='sektor'>".$row['SEKTOR_ADI']."</td>";
									$elm .= "<td class='tarih'>".$row['BITIS_TARIHI']."</td>";
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
				</div>
				<div style="clear: both;"></div>
			</div>
		</div>
	</form>

	<div id="dialog-confirm"
		title="<?php echo JText::_("DELETE_CONFIRM_TITLE");?>">
		<p>
			<span class="ui-icon ui-icon-alert"
				style="float: left; margin: 0 7px 20px 0;"></span>
			
			
			
			<?php echo JText::_("DELETE_CONFIRM_TEXT");?></p>
	</div>

	<div style="clear: both;"></div>
</div>
<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <div class="form_item">
	  <div class="form_element cf_textbox" style="width: 100%;" id="standart_durum_container">
	    <label class="cf_label" style="width: 166px; float: left;">Meslek Standardı Durumu</label>
	    <select name="standart_durum" id="standart_durum" style="float: left;">
	    	<option>Seçiniz</option>
	    	<?php foreach ($this->standartDurumlari as $standartDurum){ ?>
	    		<option value="<?php echo $standartDurum['MESLEK_STANDART_DURUM_ID'];?>"><?php echo $standartDurum['MESLEK_STANDART_DURUM_ADI'];?></option>
	    	<?php }?>
	    </select>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	<div class="form_item">
	  <div class="form_element cf_textbox" style="width: 100%;">
	    <label class="cf_label" style="width: 166px; float: left;">Meslek Standardı Adı</label>
	    <select name="standart_adi" id="standart_adi" style="width:222px; float: left;">
	    	<option>Seçiniz</option>
	    </select>
	  </div>
	  <div class="cfclear">&nbsp;</div>
	</div>
	<div class="form_item" style="margin-top:10px;">
		<div style="width:30%; float: right;">	
			<input  type="button" id="standartRevizyonSec" value="Seç"/>
			<input type="button" id="standartRevizyonIptal" value="İptal"/>
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

var msg = 'Sayfayı terketmek üzeresiniz. Kaydedilmemiş verileriniz kaybolacak.';
jQuery(window).bind('beforeunload', function(e) {
	// For IE and Firefox prior to version 4
	if (e) {
		e.returnValue = msg;
	}

	// For Safari
	if(inputChanged==true)
	return msg;
}); 

jQuery(document).ready(function() {	
	jQuery( "input:submit", ".submit_button" ).button();
	
	var existingStandartHidden = 1;

	//ON SUBMIT VALIDATE
	jQuery("#yeniYetkilendirmeForm").validate();
	jQuery.extend(jQuery.validator.messages, {
	    required: "*"
	});
	
	//TAKVIM
	jQuery( "#yetkiBaslangiciDatePicker" ).datepicker({ });
	jQuery( "#yetkiBitisiDatePicker" ).datepicker({ });

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


	
	jQuery('#varolanStandartEkle_GetirButton').click(function(e) {
		existingVariablesChanged();
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
	jQuery("#meslekStandartlari a.cancelMeslekStandart").live('click', function (e) {
        e.preventDefault();
        standartid = jQuery(this).closest('tr').attr('id');
		if(confirm("İlgili Meslek standardı iptal edilecektir.Emin misiniz ?")){
			jQuery.ajax({
				  url: "index.php?option=com_yetkilendirme_ms&task=updateStandartStatus&format=raw",
				  data: "standart_id="+standartid+"&stadart_durum=iptal",
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
	    
			var url = 'index.php?option=com_yetkilendirme_ms&task=ajaxAddFromVarolanStandartlar&format=raw&yetkilendirmeID=<?php echo $_REQUEST['yetkilendirmeID'] ?>';
			
	    	jQuery.ajax({
	    		  url: url,
	    		  data: sendData,
	    		  type: "POST",
	    		  dataType: 'json',
	    		  success: function(data) {
	    			  if(data['success']){
	    				  alert("Başarıyla Eklendi");
	    			    	existingVariablesChanged();
	    			    	updateYetkilendirmeStandartlari(data['array']);
	     			  }else{
	    				  alert("FAIL, LOL!");
	    			  }
	    		  }
	    	});
    	}
    	// Stop event handling in IE
        return false;
    } );
  	//

	///////////////////////////////////////////////////////////////////////////////////////

  	//NEW ROW FOR MESLEK STANDARTLARI
    jQuery('#newMeslekStandart').click( function (e) {

    	if(jQuery('.yetkilendirmeTuruRadioButtons').val()=='3')
    	{
    		jQuery('#yeniMeslekStandardiEkleButtonError').html("Revizyon Yetkilendirmesine Yeni Standart Eklenemez");
        }
    	else
    	{
    		jQuery('#yeniMeslekStandardiEkleButtonError').html(" ");
        	
            e.preventDefault();
            var nRow = jQuery(this).parents('tr')[0];
            
            var aiNew = oTableMS.fnAddData( [ '',
											  '', //Meslek Adi
                                              '', //Meslek Seviyesi
                                              '', //Revizyon
                                              '', //Meslek Sektoru
                                              '', //Hazirlama Baslangic
                                              '', //Hazirlama Bitis
											  '',
                                              '<a class="deleteMeslekStandart" href=""><?php echo JText::_("DELETE_TEXT");?></a>' //Sil
                                            ], true );
            var nRow = oTableMS.fnGetNodes( aiNew[0] );
            editMSRow( oTableMS, nRow, true);
            	
        }

     	// Stop event handling in IE
        return false;
    } );
  	//END NEW ROW FOR MESLEK STANDARTLARI

  	//NEW ROW FOR MESLEK STANDARTLARI
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
    		jQuery('#existing_meslekStandartlari').show("slow");
        	existingStandartHidden = 0;
        	existingVariablesChanged();
    	}	
        
     	// Stop event handling in IE
        return false;
    } );
  	//END NEW ROW FOR MESLEK STANDARTLARI

  	jQuery('#yetkilendirmeyeDahilKurulusCheckbox').click(function(e){
		if(jQuery(this).attr('checked')=="checked")
			window.location = 'index.php?option=com_yetkilendirme_ms&layout=yeni&yetkilendirmeID=<?php echo $_GET['yetkilendirmeID']; ?>&tumKuruluslar=1';
		else
			window.location = 'index.php?option=com_yetkilendirme_ms&layout=yeni&yetkilendirmeID=<?php echo $_GET['yetkilendirmeID']; ?>&tumKuruluslar=0';
	});

	
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

	///////////////////////////////////////////////////////////////////////////////////////
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
        	oTableMS.fnDeleteRow( nRow );
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
		jQuery("#yeniYetkilendirmeForm").attr("action", "index.php?option=com_yetkilendirme_ms&amp;task=yetkilendirmeKaydet" + kurulusIdleriText + kurulusRolleriText);
		jQuery("#yeniYetkilendirmeForm").submit();
	});



	//
    jQuery('#protokoleGitHyperlink').live('click', function (e) {

    	window.open('index.php?option=com_protokol_ms&layout=yeni&protokolID='+jQuery("#ilgiliProtokolIDsiTextbox").val()); 
        
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
		kurulusKaydetMSAjax (protokol_id,kurulus_id,kurulusTuru,tip);
	});
	jQuery('.kurulusradioyardimci').live('click', function (e) {
		jQuery(this).closest('tr').find('[type=checkbox]').prop('checked', true);
		data=jQuery(this).closest('tr').find('[type=checkbox]').val().split("-");
		kurulus_id=data[0];
		protokol_id=data[1];
		kurulusTuru=2;
		tip="kaydet";
		kurulusKaydetMSAjax (protokol_id,kurulus_id,kurulusTuru,tip);
	});

	jQuery('.kurulusCheckbox').live('click', function (e) {
		if (jQuery(this).prop('checked')!=true) {
			data = jQuery(this).val().split("-");
			kurulus_id = data[0];
			protokol_id = data[1];
			kurulusTuru = 0;
			tip = "sil";
			kurulusKaydetMSAjax(protokol_id, kurulus_id, kurulusTuru, tip);
		}
	});

	function kurulusKaydetMSAjax(protokol_id, kurulus_id, kurulusTuru, tip){
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

	jqTds[0].className = "standartid";
    jqTds[1].className = "standart";
    jqTds[2].className = "seviye";
    jqTds[3].className = "revizyon";
    jqTds[4].className = "durum";
    jqTds[5].className = "sektor";
    jqTds[6].className = "tarih";
    jqTds[7].className = "tarih";
    
    jqTds[1].innerHTML = '<input size="23" class="required uppercase" value="'+aData[1]+'" type="text" name="meslekAdi"/>';
    jqTds[2].innerHTML = '<select class="required" name="meslekSeviyesi">'+ seviyeOptions + '</select>'; // meslek Seviyeleri
    jqTds[3].innerHTML = '<input value="'+aData[3]+'" type="text" name="revizyon" style="width:80px;" class="revizyon" maxlength="2" />';
    jqTds[5].innerHTML = '<select class="meslekSektor required" name="meslekSektoru" style="width:130px;">'+ sektorOptions + '</select>'; //meslek sektorleri
    jqTds[6].innerHTML = '<input size="10" value="'+aData[6]+'" type="text" name="hazirlamaBaslangic" class="hazirlamaBaslangic" maxlength="10" />';
    
    if(!isSave)
    {
    	var selectedSeviyeValue = aData[2];
    	var selectedSektorValue = aData[5];
    	//SEVIYE
    	var seviyeOptions = jQuery('option:contains("' + selectedSeviyeValue + '")',  jqTds[2]);
    	seviyeOptions.attr('selected', 'selected');
		//SEKTOR
         var sektorOption = jQuery('option:contains("' + selectedSektorValue + '")',  jqTds[5]);
        sektorOption.attr('selected', 'selected');
    }
    
    jQuery( ".hazirlamaBaslangic" ).datepicker({ });
	jQuery( ".hazirlamaBitis" ).datepicker({ });	

	//UPPERCASE
	jQuery('.uppercase', nRow).upper({
	     ln: 'tr'
	}); 
    
    if (!isSave)
    	jqTds[7].innerHTML = '<a class="editMeslekStandart" href=""><?php echo JText::_("SAVE_TEXT");?></a> <a class="cancelEditMeslekStandart" href=""><?php echo JText::_("CANCEL_TEXT");?></a>';
    else
    	jqTds[7].innerHTML = '<a class="saveMeslekStandart" href=""><?php echo JText::_("SAVE_TEXT");?></a>';
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
    jqTds[5].innerHTML = aData[5];
    jqTds[6].innerHTML = aData[6];
    jqTds[7].innerHTML = '<a class="editMeslekStandart" href=""><?php echo JText::_("EDIT_TEXT");?></a><br><a class="cancelMeslekStandart" href="">İptal Et</a>';
    jqTds[8].innerHTML = aData[8];
}

function saveMSRow ( oTable, nRow, isSave )
{
	var jqInputs = jQuery('input', nRow);
	var jqSelects = jQuery('select', nRow);
	
	var sendData = jqInputs.serializeArray();
	var sendDataSelects = jqSelects.serializeArray();
	var sendDataAll = sendData.concat(sendDataSelects);
	
	var yetkilendirmeID = jQuery("#yetkilendirmeID").val();
		
	var url = 'index.php?option=com_yetkilendirme_ms&task=ajaxSaveRow&format=raw&yetkilendirmeID='+yetkilendirmeID;

	if (!isSave){
		url = 'index.php?option=com_yetkilendirme_ms&task=ajaxEditRow&format=raw&yetkilendirmeID='+yetkilendirmeID;

		var obj = new Object;
		obj.name= 'id';
		obj.value= nRow.getAttribute('id');
		console.log(obj);
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
				oTable.fnUpdate( data['id'], nRow, 0, false );
			    oTable.fnUpdate( jqInputs[0].value, nRow, 1, false );
			    oTable.fnUpdate( jQuery(jqSelects[0]).find("option:selected").text(), nRow, 2, false );
				oTable.fnUpdate( jqInputs[1].value, nRow, 3, false );
			    oTable.fnUpdate( jQuery(jqSelects[1]).find("option:selected").text(), nRow, 5, false );
			    oTable.fnUpdate( jqInputs[2].value, nRow, 6, false );
// 			    oTable.fnUpdate( jqInputs[3].value, nRow, 5, false );
			    oTable.fnUpdate( '<a class="editMeslekStandart" href=""><?php echo JText::_("EDIT_TEXT");?></a><br><a class="cancelMeslekStandart" href="">İptal Et</a>', nRow, 7, false );

				  if (isSave){
						nRow.setAttribute('id', data['id']);
						alert("Başarıyla eklendi");					
				  }else{

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

	var yetkilendirmeID = document.getElementById("yetkilendirmeID").value;
	
	jQuery.ajax({
		  url: "index.php?option=com_yetkilendirme_ms&task=ajaxDeleteRow&format=raw&yetkilendirmeID="+yetkilendirmeID,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
				jQuery("#bilgilendirme").html(data['data']);
				oTable.fnDeleteRow( nRow );
				updateYetkilendirmeStandartlari(data['array']);
				existingVariablesChanged();
			  }else{
			  	jQuery("#bilgilendirme").html(data['data']);
			  	oTable.fnDraw();
			  }
		  }
	});	
}

//FILE UPLOAD
dTables.yetkilendirmeDosya = new Array(new Array("upload"));

function createTables(){
	tableName = "yetkilendirmeDosya";
	createTable(tableName, new Array(''));
	satirEkleKaldir (tableName);
	satirSilKaldir (tableName, 0);
	addYetkilendirmeDosya (tableName);
}

function addYetkilendirmeDosya (tableName){
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
		result 	  += '<input type="button" value="İndir" onclick="window.location.href=\'index.php?option=com_yetkilendirme_ms&amp;task=indir&amp;yetkilendirmeID=<?php echo $yetkilendirmeID;?>\'" class="up_submitbtn" style="float:none;"> <\/div>';
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
		var yetkilendirmeIDText = "&yetkilendirmeID=<?php echo $_REQUEST['yetkilendirmeID'];?>";
		
		if(jQuery("#existing_sektorler").val()!= 0  ) ;
			sektorlerText = "&sektorID="+jQuery("#existing_sektorler").val();
		if(jQuery("#existing_seviyeler").val()!= 0  ) ;
			seviyelerText = "&seviyeID="+jQuery("#existing_seviyeler").val();

		var oTableVarolanMS = jQuery('#existing_meslekStandartlari').dataTable();
		oTableVarolanMS.fnClearTable();
		oTableVarolanMS.fnAddData( ["GETİRİLİYOR.", "","","","","","","",""]);

		jQuery.ajax({
				  url: "index.php?option=com_yetkilendirme_ms&task=ajaxFetchExistingStandart&format=raw"+seviyelerText+sektorlerText+yetkilendirmeIDText,
				  data: sendData,
				  type: "POST",
				  dataType: 'json',
				  success: function(data) {
					  if(data['success']){
						//jQuery("#bilgilendirme").html(data['data']);
						putVarolanStandartDataToGrid(data['array']);
						jQuery(".varolanStandartlariEkleButton").show("slow");
						//oTable.fnDeleteRow( nRow );
					  }else{
					  	//jQuery("#bilgilendirme").html(data['data']);
						oTableVarolanMS.fnClearTable();
						oTableVarolanMS.fnAddData( [ data['data'], "","","","","","","","" ]);
						jQuery(".varolanStandartlariEkleButton").hide("slow");	
						//alert("FAIL, LOL!");
					  	//oTable.fnDraw();
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
			"<input type='checkbox' value='"+arrayToPut[i]["STANDART_ID"]+"' id='varolanStandartlarCheckbox-"+i+"' name='varolanStandartlarCheckbox[]' class='varolanStandartlarCheckbox' /> ",
			arrayToPut[i]["STANDART_ADI"],
			arrayToPut[i]["SEVIYE_ADI"],
			arrayToPut[i]["REVIZYON"],
			arrayToPut[i]["SEKTOR_ADI"],
			arrayToPut[i]["MESLEK_STANDART_DURUM_ADI"]
    	]);
    }  
    
}

function updateYetkilendirmeStandartlari(arrayToPut)
{
	var oTableMS = jQuery('#meslekStandartlari').dataTable();

	oTableMS.fnClearTable();
	for(var i=0; i<arrayToPut.length; i++)
    {
    	var a = oTableMS.fnAddData( [
			arrayToPut[i]["STANDART_ID"],
			arrayToPut[i]["STANDART_ADI"],
			arrayToPut[i]["SEVIYE_ADI"],
			arrayToPut[i]["REVIZYON"],
			arrayToPut[i]["MESLEK_STANDART_DURUM_ADI"],
			arrayToPut[i]["SEKTOR_ADI"],
			arrayToPut[i]["BITIS_TARIHI"],
			'<td><a class="editMeslekStandart" href=""><?php echo JText::_("EDIT_TEXT"); ?></a><br><a class="cancelMeslekStandart" href="">İptal Et</a></td>',
			'<td><a class="deleteMeslekStandart" href=""><?php echo JText::_("DELETE_TEXT"); ?></a></td>'
        ]);
    	var nRow = oTableMS.fnSettings().aoData[ a[0] ].nTr;
        nRow.setAttribute('id', arrayToPut[i]["STANDART_ID"]);
    }  
	
}


//UZATMA ILE ILGILI KISIMLAR
function editUzatmaRow ( oTable, nRow, isSave )
{
	
	inputChanged=true;
	
var aData = oTable.fnGetData(nRow);
var jqTds = jQuery('>td', nRow);

jqTds[0].innerHTML = '<input size="50" class="required " value="'+aData[0]+'" type="text" name="uzatmaSuresi"  onkeyup="jQuery(this).val(jQuery(this).val().replace(/\\D/g,\'\'));" />';
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
	
	var yetkilendirmeID = jQuery("#yetkilendirmeID").val();
		
	var url = 'index.php?option=com_yetkilendirme_ms&task=ajaxUzatmaKaydet&format=raw&protokolID='+yetkilendirmeID;

	if (!isSave){
		url = 'index.php?option=com_yetkilendirme_ms&task=ajaxUzatmaGuncelle&format=raw&protokolID='+yetkilendirmeID;

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

	var protokolID = document.getElementById("yetkilendirmeID").value;
	
	jQuery.ajax({
		  url: "index.php?option=com_yetkilendirme_ms&task=ajaxUzatmaSil&format=raw&protokolID="+protokolID,
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

jQuery("#newRevizyonEkle").click(function(){
	jQuery('#loaderGif').lightbox_me({
		centered: true,
        closeClick:false,
        closeEsc:false  
    });
    return false;
});

jQuery("#loaderGif #standart_durum").change(function(){
	jQuery.ajax({
		  url: "index.php?option=com_yetkilendirme_ms&task=ajaxStandartGetirByStatus&format=raw&yetstatus="+jQuery(this).val(),
		  type: "POST",
		  dataType: 'json',
          beforeSend: function() {
        	  jQuery("#loaderGif #standart_adi").html("<option>Seçiniz</option>");
          },
		  success: function(data) {	  
			  jQuery.each(data, function(key,val){
			        jQuery("#loaderGif #standart_adi").append("<option value="+val.STANDART_ID+">"+val.STANDART_ADI+"</option>");
			    });
		  }
	});
});

jQuery("#standartRevizyonIptal").click(function(){
	jQuery('#loaderGif').trigger('close');
});
jQuery("#standartRevizyonSec").click(function(){
	jQuery.ajax({
		  url: "index.php?option=com_yetkilendirme_ms&task=ajaxStandartGetirById&format=raw&standartid="+jQuery(this).closest("#loaderGif").find("#standart_adi").val(),
		  type: "POST",
		  dataType: 'json',
        beforeSend: function() {
        	jQuery('#loaderGif').trigger('close');
        },
		  success: function(data) {
			  if(data['status'] == "1"){
					var oTableMS = jQuery('#meslekStandartlari').dataTable();
				    var nRow = jQuery(this).parents('tr')[0];
				 
				    var standartid = data['result']['STANDART_ID'];
				    
				    var aiNew = oTableMS.fnAddData( [ '',
													  '', //Meslek Adi
				                                      '', //Meslek Seviyesi
													  '', //Durumu
				                                      '', //Revizyon
				                                      '', //Meslek Sektoru
				                                      '', //Teslim Tarihi
				                                      '<a class="editMeslekStandart" href="#" onClick="event.preventDefault(); return false;"><?php echo JText::_("EDIT_TEXT");?></a><br><a class="cancelMeslekStandart" href="">İptal Et</a>', //Guncelle
				                                      ''//Sil
				                                    ], true );
				    var oTableMS = jQuery('#meslekStandartlari').dataTable();
				    var nRow = oTableMS.fnGetNodes( aiNew[0] );
				    var aData = oTableMS.fnGetData(nRow);
				    jQuery(nRow).attr("tempid",standartid);
				    var jqTds = jQuery('>td', nRow);

				    var seviyeOptions = "<?php echo $seviyeOptions;?>";
				    var sektorOptions = "<?php echo $sektorOptions;?>";
				    var ulusalStandartOptions = "<?php echo $ulusalStandartOptions;?>";
				    jqTds[0].innerHTML = '';
				    jqTds[1].innerHTML = '<input class="required uppercase" id="meslekadi_'+standartid+'_rev" value="'+data['result']['STANDART_ADI']+'" type="text" name="meslekAdi" />';
				    jqTds[2].innerHTML = '<select class="required" name="meslekSeviyesi" id="meslekseviyesi_'+standartid+'_rev">'+ seviyeOptions + '</select>'; // meslek Seviyeleri
				    jqTds[3].innerHTML = '<input value="'+data['result']['REVIZYON']+'" type="text" name="revizyon" id="revizyon_'+standartid+'_rev" class="revizyon" maxlength="2" style="width:82px;" />';
				    jqTds[4].innerHTML = data['result']['MESLEK_STANDART_DURUM_ADI'];   
					jqTds[5].innerHTML = '<select class="required" style="width:120px;" id="mesleksektoru_'+standartid+'_rev" name="meslekSektoru">'+ sektorOptions + '</select>'; //meslek sektorleri
				   	jqTds[6].innerHTML = '<input value="'+aData[4]+'" style="width:120px;"  type="text" name="protokolTeslim" id="protokolteslim_'+standartid+'_rev" class="protokolTeslim" maxlength="10" />';

				    jQuery("#meslekseviyesi_"+standartid+"_rev").val(data['result']['SEVIYE_ID']);
				    jQuery("#mesleksektoru_"+standartid+"_rev").val(data['result']['SEKTOR_ID']);
//				     jQuery("#protokolteslim_"+yetid+"_rev").val(jQuery(this).closest("tr").find('td:eq(4)').html());
				    
				    jQuery( ".protokolTeslim" ).datepicker({ });
	
					//UPPERCASE
					jQuery('.uppercase', nRow).upper({
					     ln: 'tr'
					}); 
				    jqTds[7].innerHTML = '<a href="javascript:void(0);" class="saveRevizyon"><?php echo JText::_("SAVE_TEXT");?></a> <a href="javascript:void(0);" class="cancelRevizyon" href=""><?php echo JText::_("CANCEL_TEXT");?></a>';    
			  }
		  }
	});
});
jQuery(".cancelRevizyon").live('click',function(){
	var oTableMS = jQuery('#meslekStandartlari').dataTable();
	var nRow = jQuery(this).parents('tr')[0]; 
	oTableMS.fnDeleteRow( nRow );
	return false;
});

jQuery(".saveRevizyon").live('click', function (e) { 
	var nRow = jQuery(this).parents('tr')[0]; 
	var jqInputs = jQuery('input', nRow);
	var jqSelects = jQuery('select', nRow);
	
	var standartid 			= jQuery(this).closest('tr').attr("tempid");
	var meslekSeviyesi 	= jQuery(this).closest('tr').find("[name=meslekSeviyesi]").val();
	var revizyon 		= jQuery(this).closest('tr').find("[name=revizyon]").val();
	var meslekSektoru 	= jQuery(this).closest('tr').find("[name=meslekSektoru]").val();
	var protokolTeslim 	= jQuery(this).closest('tr').find("[name=protokolTeslim]").val();
	
	var sendData = "standart_id="+standartid+"&meslekseviyesi="+meslekSeviyesi+"&revizyon="+revizyon+"&mesleksektoru="+meslekSektoru+"&protokolteslim="+protokolTeslim+"&protokolid="+jQuery("#yetkilendirmeID").val();
	jQuery.ajax({
		  url: "index.php?option=com_yetkilendirme_ms&task=ajaxRevizyonOlustur&format=raw&standartid="+standartid,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['status'] == "1"){
				jQuery(nRow).removeAttr("tempid");
				jQuery(nRow).attr('id',data['standart_id']);
				jQuery(nRow).find(".revizyon").val(data['revizyon']);
				jQuery(nRow).find("td:eq(0)").html(data['standart_id']);
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
</script>
