<?php

defined('_JEXEC') or die('Restricted access');

//$sinavSekli = $this->postData['sinav_sekli'];
//$sinavTuru = $this->postData['sinav_turu'];
//$evrakId = $this->postData['evrakId'];
		
$sinavId = JRequest::getVar( 'sinavId' );
$sinavTuru = JRequest::getVar( 'sinav_turu' );
	
?>
<form onsubmit="return validate('teorik_kaydet_form')"
		id="teorik_kaydet_form"
		action="?option=com_sinav&task=teorikKaydet"
		method="POST">
		
	<input type="hidden" value="<?php echo $sinavTuru?>" name="sinavTuru" />
	<input type="hidden" value="<?php echo $sinavId?>" name="sinavId" />
	
	<table cellspacing="1">
	<thead class="tablo_header">
		<tr>
			<th>#</th>
			<th>Kayıt No</th>
			<th>TC Kimlik No</th>
			<th>Adı</th>
			<th>Soyadı</th>
			<th>Sınavı</th>
			<th>Doğru Cevap Sayısı</th>
			<th>Yanlış Cevap Sayısı</th>
			<th>Boş Cevap Sayısı</th>
			<th>Aldığı Puan</th>
			<th>Sonuç</th>
		</tr>
		</thead>
		<tbody>
		<?php
			$rowCount=1;
			$rowClass="";
			foreach($this->ogrenciler AS $satir){
				if($rowCount%2==0)
					$rowClass = "even_row";
				else
					$rowClass = "odd_row";
					
				echo '<tr class="'.$rowClass.'" style="text-align:center;">';
				echo '<td>'.$rowCount.'</td>';
				echo '<td>'.($satir['OGRENCI_KAYIT_NO']?$satir['OGRENCI_KAYIT_NO']:"&nbsp;").'</td>';
				echo '<td>'.($satir['TC_KIMLIK']?$satir['TC_KIMLIK']:"&nbsp;").'</td>';
				echo '<td>'.($satir['OGRENCI_ADI']?$satir['OGRENCI_ADI']:"&nbsp;").'</td>';
				echo '<td>'.($satir['OGRENCI_SOYADI']?$satir['OGRENCI_SOYADI']:"&nbsp;").'</td>';
				echo '<td>'.($satir['YETERLILIK_ALT_BIRIM_ADI']?$satir['YETERLILIK_ALT_BIRIM_ADI']:"&nbsp;").'<hr><input type="hidden" value="'.$satir['YETERLILIK_ALT_BIRIM_ID'].'" name="altbirimId_'.$satir['TC_KIMLIK'].'[]" /></td>';
					?>
					<td>
						<input type="text" name="dogru_cevap_<?php echo $satir['TC_KIMLIK']?>[]" size="8"/>
					</td>
					<td>
						<input type="text" name="yanlis_cevap_<?php echo $satir['TC_KIMLIK']?>[]" size="8"/>
					</td>
					<td>
						<input type="text" name="bos_<?php echo $satir['TC_KIMLIK']?>[]" size="8"/>
					</td>
					<td>
						<input type="text" name="puan_<?php echo $satir['TC_KIMLIK']?>[]" size="8"/>
					</td>
					<td>
						<select name="sinav_sonuc_<?php echo $satir['TC_KIMLIK']?>[]">
							<option value="Seçiniz">Seçiniz</option>
							<?php echo $this->sinavDurumlari?>
						</select>
					</td>
					<?php

				echo '</tr></tbody>';
				$rowCount++;
			}
		?>
	</table>
    <a href="index.php?option=com_sinav&view=sinav_sec">Geri</a>&nbsp;&nbsp;
	<input type="submit" value="Sonuçları Kaydet" />
</form>