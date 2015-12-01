<?php
defined('_JEXEC') or die('Restricted access');
?>
<form method="POST"
		action="?option=com_sinav&view=sertifika_ozet"
		id="sinav_oncesi_form"
		name="sinav_oncesi_form"
		onsubmit="return validate('sinav_oncesi_form')">

<input type="hidden" name="sinavIds" value="<?php echo $this->sinavIds?>"></input>

<div class="sinavGirisBaslik">Seçilen Sınavlar</div>

<table style="width:750px" cellspacing="0" class="paginate-10 sortable">
	<thead>
	<tr class="tablo_header">
		<th>#</th>
		<th class="sortable-date-dmy">Sınav Tarihi</th>
		<th class="sortable-text">Yeterlilik Adı</th>
		<th class="sortable-text">Sınav Merkezi</th>
		<th class="sortable-text">Sınav Şekli</th>
		<th class="sortable-numeric">Toplam Aday</th>
	</tr>
	</thead>
	<tbody>
	<?php
		$rowCount=1;
		$rowClass="";
		foreach($this->sinavlar AS $satir){
			if($rowCount%2==0)
				$rowClass = "even_row";
			else
				$rowClass = "odd_row";
				
			echo '<tr class="'.$rowClass.'" style="text-align:center;">';
			
			echo '<td>'.$rowCount.'</td>';
			echo '<td>'.($satir['SINAV_TARIHI']?$satir['SINAV_TARIHI']:"&nsbp;").'</td>';
			echo '<td>'.($satir['YETERLILIK_ADI']?$satir['YETERLILIK_ADI']:"&nsbp;").'</td>';
			echo '<td>'.($satir['MERKEZ_ADI']?$satir['MERKEZ_ADI']:"&nsbp;").'</td>';
			echo '<td>'.($satir['SINAV_BIRIMLERI']?$satir['SINAV_BIRIMLERI']:"&nsbp;").'</td>';
			echo '<td>'.($satir['TOPLAM_ADAY']?$satir['TOPLAM_ADAY']:"&nsbp;").'</td>';
			
			echo '</tr>';
			$rowCount++;
		}
	?>
	</tbody>
</table>
<br />
<div class="sinavGirisBaslik">Öğrenciler</div>
<table style="width:750px" cellspacing="0" class="paginate-10 sortable">
	<thead>
	<tr class="tablo_header">
		<th>#</th>
		<th>Kayıt No</th>
		<th>TC Kimlik</th>
		<th>Adı</th>
		<th>Soyadı</th>
		<th>Doğum Tarihi</th>
		<th>Doğum Yeri</th>
		<th>Baba Adı</th>
		<th>Başarılı Oldukları Sınavları</th>
	</tr>
	</thead>
	<tbody>
	<?php
		$rowCount=1;
		$rowClass="";
		foreach($this->ogrenciler AS $ogr){
			if($rowCount%2==0)
				$rowClass = "even_row";
			else
				$rowClass = "odd_row";
				
			echo '<tr class="'.$rowClass.'" style="text-align:center;">';
			
			echo '<td>'.$rowCount.'</td>';
			echo '<td>'.($ogr['OGRENCI_KAYIT_NO']?$ogr['OGRENCI_KAYIT_NO']:"&nsbp;").'</td>';
			echo '<td>'.($ogr['TC_KIMLIK']?$ogr['TC_KIMLIK']:"&nsbp;").'</td>';
			echo '<td>'.($ogr['OGRENCI_ADI']?$ogr['OGRENCI_ADI']:"&nsbp;").'</td>';
			echo '<td>'.($ogr['OGRENCI_SOYADI']?$ogr['OGRENCI_SOYADI']:"&nsbp;").'</td>';
			echo '<td>'.($ogr['OGRENCI_DOGUM_TARIHI']?$ogr['OGRENCI_DOGUM_TARIHI']:"&nsbp;").'</td>';
			echo '<td>'.($ogr['OGRENCI_DOGUM_YERI']?$ogr['OGRENCI_DOGUM_YERI']:"&nsbp;").'</td>';
			echo '<td>'.($ogr['OGRENCI_BABA_ADI']?$ogr['OGRENCI_BABA_ADI']:"&nsbp;").'</td>';
			echo '<td>'.($ogr['OGRENCI_DOGUM_TARIHI']?$ogr['OGRENCI_DOGUM_TARIHI']:"&nsbp;").'</td>';
			echo '</tr>';
			$rowCount++;
		}
	?>
	</tbody>
</table>
<br />
<div id="belgeDuzenlenecekBilgi_div" style="overflow-x:auto;overflow-y:hidden;padding-bottom:10px"></div>

<div class="form_item">
  <div class="form_element cf_button">
    <a href="index.php?option=com_sinav&view=sinav_sec">Geri</a>&nbsp;&nbsp;
    <input value="İleri" name="submitButton" type="submit"/>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
</form>
