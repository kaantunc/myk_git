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
		<tr class="tablo_header">
			<th>#</th>
			<th>Kay�t No</th>
			<th>TC Kimlik No</th>
			<th>Ad�</th>
			<th>Soyad�</th>
			<th>Do�ru Cevap Say�s�</th>
			<th>Yanl�� Cevap Say�s�</th>
			<th>Bo� Cevap Say�s�</th>
			<th>Ald��� Puan</th>
			<th>Sonu�</th>
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
				echo '<td>'.($satir['OGRENCI_KAYIT_NO']?$satir['OGRENCI_KAYIT_NO']:"&nbsp;").'</td>';
				echo '<td>'.($satir['TC_KIMLIK']?$satir['TC_KIMLIK']:"&nbsp;").'</td>';
				echo '<td>'.($satir['OGRENCI_ADI']?$satir['OGRENCI_ADI']:"&nbsp;").'</td>';
				echo '<td>'.($satir['OGRENCI_SOYADI']?$satir['OGRENCI_SOYADI']:"&nbsp;").'</td>';

					?>
					<td>
						<input type="text" name="dogru_cevap_<?php echo $satir['TC_KIMLIK']?>" size="8"/>
					</td>
					<td>
						<input type="text" name="yanlis_cevap_<?php echo $satir['TC_KIMLIK']?>" size="8"/>
					</td>
					<td>
						<input type="text" name="bos_<?php echo $satir['TC_KIMLIK']?>" size="8"/>
					</td>
					<td>
						<input type="text" name="puan_<?php echo $satir['TC_KIMLIK']?>" size="8"/>
					</td>
					<td>
						<select name="sinav_sonuc_<?php echo $satir['TC_KIMLIK']?>">
							<option value="Se�iniz">Se�iniz</option>
							<?php echo $this->sinavDurumlari?>
						</select>
					</td>
					<?php

				echo '</tr>';
				$rowCount++;
			}
		?>
	</table>
    <a href="index.php?option=com_sinav&view=sinav_sec">Geri</a>&nbsp;&nbsp;
	<input type="submit" value="Sonu�lar� Kaydet" />
</form>