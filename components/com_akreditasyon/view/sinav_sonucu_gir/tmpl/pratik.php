<?php

defined('_JEXEC') or die('Restricted access');

	//$sinavSekli = $this->postData['sinav_sekli'];
	//$sinavTuru = $this->postData['sinav_turu'];
	//$evrakId = $this->postData['evrakId'];
	
	$sinavId = JRequest::getVar( 'sinavId' );
	$sinavTuru = JRequest::getVar( 'sinav_turu' );

?>
<form onsubmit="return validate('pratik_kaydet_form')"
		id="pratik_kaydet_form" 
		action="?option=com_sinav&task=pratikKaydet" method="post">
	<input type="hidden" value="<?php echo $sinavTuru?>" name="sinavTuru" />
	<input type="hidden" value="<?php echo $sinavId?>" name="sinavId" />
		
		<table cellspacing="1">
			<tr class="tablo_header">
				<th>#</th>
				<th>Kayıt No</th>
				<th>TC Kimlik No</th>
				<th>Adı</th>
				<th>Soyadı</th>
				<th>Aldığı Puan</th>
				<th>SONUÇ</th>
			</tr>
			<?php
				$rowCount=1;
				$rowClass="";
				foreach($this->ogrenciler AS $satir){
					if($rowCount%2==0)
						$rowClass = "even_row";
					else
						$rowClass = "odd_row";
						
					echo '<tr class="'.$rowClass.'">';
					echo '<td>'.$rowCount.'</td>';					
					echo '<td>'.($satir['OGRENCI_KAYIT_NO']?$satir['OGRENCI_KAYIT_NO']:"&nsbp;").'</td>';
					echo '<td>'.($satir['TC_KIMLIK']?$satir['TC_KIMLIK']:"&nsbp;").'</td>';
					echo '<td>'.($satir['OGRENCI_ADI']?$satir['OGRENCI_ADI']:"&nsbp;").'</td>';
					echo '<td>'.($satir['OGRENCI_SOYADI']?$satir['OGRENCI_SOYADI']:"&nsbp;").'</td>';
					
						?>
						<td>
							<input type="text" name="puan_<?php echo $satir['TC_KIMLIK']?>"/>
						</td>
						<td>
							<select class="comboReq" name="sinav_sonuc_<?php echo $satir['TC_KIMLIK']?>">
								<option value="Seçiniz">Seçiniz</option>
								<?php echo $this->sinavDurumlari?>
							</select>
						</td>
						<?php
					echo '</tr>';
					$rowCount++;
				}
			?>
		</table>
    <a href="?option=com_sinav&view=sinav_sec">Geri</a>&nbsp;&nbsp;
		<input type="submit" value="Sonuçları Kaydet" />
</form>