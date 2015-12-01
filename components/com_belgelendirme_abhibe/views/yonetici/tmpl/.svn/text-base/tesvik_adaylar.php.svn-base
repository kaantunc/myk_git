<?php
$KurPro = $this->ABKurPro;
$toplamKota = $this->ABKurKota;
$OdenenKota = $this->ABKurKullanilanKota;
$OdenenDezKota = $this->ABKurKullanilanDezKota;
$ABKurBekKota = UcretDuzenle($this->ABKurBekKota);
$ABKurBekDezKota = UcretDuzenle($this->ABKurBekDezKota);
$AdayBilgi = $this->TesvikAdaylar['AdayBilgi'];
$UcretBilgi = $this->TesvikAdaylar['UcretBilgi'];
$tesvik = $this->tesvik;
$kurBilgi = $this->kurBilgi;

$dovizKuru = $tesvik['DOVIZ_KURU'];
if($tesvik['DURUM'] == 5){
	$dovizKuru = $tesvik['BANKA_KURU'];
}

$maxUcret = FormABHibeUcretHesabi::ABHibeMaxUcret()*UcretDuzenle($dovizKuru);
$KurKdv = UcretDuzenle(1+($KurPro['KDV']/100));
// $TopDezKota = 0;
// $TopDezsiz = $toplamKota;
// if(1 == 1){
// 	$TopDezKota = UcretDuzenle($toplamKota)/10;
// 	$TopDezsiz = $toplamKota-$TopDezKota;
// }
$TopDezKota = UcretDuzenle($toplamKota)/10;
$TopDezsiz = $toplamKota-$TopDezKota;

$TopKDV = 0;
$TopKDVsiz = 0;
foreach ($AdayBilgi as $row){
	$Odenecek = 0;
	$Hesap = 0;
	if($row['ITIRAZ_DURUM'] == null || $row['ITIRAZ_DURUM'] == -1){
		foreach ($UcretBilgi[$row['BELGENO']] as $cow){
			$Hesap += $cow['ucret'];
		}
	}else{
		$Hesap = UcretDuzenle($row['ITIRAZ_UCRET']);
	}
	
	$anaPara = UcretDuzenle($Hesap/$KurKdv);
	
	if($anaPara > UcretDuzenle($maxUcret)){
		$kdvli = UcretDuzenle($maxUcret);
		$kdvsiz = UcretDuzenle($maxUcret);
	}else{
		$kdvli = $Hesap;
		$kdvsiz = $anaPara;
	}
	$TopKDV += $kdvli;
	$TopKDVsiz += $kdvsiz;
}
?>
<?php if($tesvik['DURUM'] == 5){ ?>
<div class="anaDiv fontItalic font16 text-warning">
	<i class="fa fa-question-circle"></i> Bu ekrandaki bütün hesaplamalar Ödeme Anındaki Banka EURO Kuru'na göre yapılmıştır.
</div>
<?php } ?>
<div class="anaDiv">
	<div class="div30 font20 hColor">
	İstek Id:
	</div>
	<div class="div70 fontBold font20">
	<?php echo $tesvik['ID']?>
	</div>
</div>
<div class="anaDiv">
	<div class="div30 font20 hColor">
	Kuruluş:
	</div>
	<div class="div70 fontBold font20">
	<?php echo $kurBilgi['KURULUS_ADI'];?>
	</div>
</div>
<div class="anaDiv">
	<div class="div30 font20 hColor">
	Ücret İadesi Talep Tarihi:
	</div>
	<div class="div70 fontBold font20">
	<?php echo $tesvik['BIT_TARIH']?>
	</div>
</div>
<div class="anaDiv">
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				TC Merkez Bankası EURO <span class="font16">(<?php echo $tesvik['DOVIZ_TARIHI'];?>)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php echo $tesvik['DOVIZ_KURU'].' TL';?>
			</div>
		</div>
	</div>
	<?php if($tesvik['DURUM'] == 5){ ?>
		<div class="div50">
			<div class="anaDiv">
				<div class="div60 font16 fontBold hColor">
					Banka EURO Kuru <span class="font16">(<?php echo $tesvik['ODEME_TARIHI'];?>)</span>:
				</div>
				<div class="div40 fontBold font16">
					<?php echo $tesvik['BANKA_KURU'].' TL';?>
				</div>
			</div>
		</div>
	<?php } ?>
</div>
<div class="anaDiv">
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				AB Hibe Toplam Kota <span class="font16">(TL)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php echo Hesapla($toplamKota*UcretDuzenle($dovizKuru)).' TL';?>
			</div>
		</div>
	</div>
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				AB Hibe Toplam Kota <span class="font16">(EURO)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php echo Hesapla($toplamKota).' €';?>
			</div>
		</div>
	</div>
</div>
<div class="anaDiv">
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				AB Hibe Kullanilan Toplam Kota <span class="font16">(TL)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php echo Hesapla($OdenenKota*UcretDuzenle($dovizKuru)).' TL';?>
			</div>
		</div>
	</div>
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				AB Hibe Kullanilan Toplam Kota <span class="font16">(EURO)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php echo Hesapla($OdenenKota).' €';?>
			</div>
		</div>
	</div>
</div>
<div class="anaDiv">
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				Kullanilan Dezavantajlı Toplam Kota <span class="font16">(TL)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php echo Hesapla($OdenenDezKota*UcretDuzenle($dovizKuru)).' TL';?>
			</div>
		</div>
	</div>
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				Kullanilan Dezavantajlı Toplam Kota <span class="font16">(EURO)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php echo Hesapla($OdenenDezKota).' €';?>
			</div>
		</div>
	</div>
</div>
<div class="anaDiv">
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				Kullanılabilir Normal Kota <span class="font16">(TL)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php 
				echo Hesapla(($TopDezsiz-($OdenenKota-$OdenenDezKota))*UcretDuzenle($dovizKuru)). 'TL';
// 				echo Hesapla($OdenenDezKota*UcretDuzenle($dovizKuru)).' TL';?>
			</div>
		</div>
	</div>
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				Kullanılabilir Normal Kota <span class="font16">(EURO)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php echo Hesapla($TopDezsiz-($OdenenKota-$OdenenDezKota)).' €';?>
			</div>
		</div>
	</div>
</div>
<div class="anaDiv">
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				Kullanılabilir Dezavantajlı Kota <span class="font16">(TL)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php 
				echo Hesapla(($TopDezKota-$OdenenDezKota)*UcretDuzenle($dovizKuru)). 'TL';
// 				echo Hesapla($OdenenDezKota*UcretDuzenle($dovizKuru)).' TL';?>
			</div>
		</div>
	</div>
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				Kullanılabilir Dezavantajlı Kota <span class="font16">(EURO)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php echo Hesapla($TopDezKota-$OdenenDezKota).' €';?>
			</div>
		</div>
	</div>
</div>
<div class="anaDiv">
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				Geri Ödemesi Beklenen Normal Ücret <span class="font16">(TL)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php 
				echo Hesapla(($ABKurBekKota-$ABKurBekDezKota)*UcretDuzenle($dovizKuru)). 'TL';
				?>
			</div>
		</div>
	</div>
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				Geri Ödemesi Beklenen Normal Ücret <span class="font16">(EURO)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php echo Hesapla($ABKurBekKota-$ABKurBekDezKota).' €';?>
			</div>
		</div>
	</div>
</div>
<div class="anaDiv">
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				Geri Ödemesi Beklenen Dezavantajlı Ücret <span class="font16">(TL)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php 
				echo Hesapla($ABKurBekDezKota*UcretDuzenle($dovizKuru)). 'TL';
				?>
			</div>
		</div>
	</div>
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				Geri Ödemesi Beklenen Dezavantajlı Ücret <span class="font16">(EURO)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php echo Hesapla($ABKurBekDezKota).' €';?>
			</div>
		</div>
	</div>
</div>
<div class="anaDiv">
	<div class="div30 hColor font20">
		İmza Yetkilisi Unvan:
	</div>
	<div class="div70 fontBold font20">
		<?php echo $tesvik['IMZA_UNVAN'];?>
	</div>
</div>
<div class="anaDiv">
	<div class="div30 hColor font20">
		İmza Yetkilisi Ad Soyad:
	</div>
	<div class="div70 fontBold font20">
		<?php echo $tesvik['IMZA_ISIM'];?>
	</div>
</div>
<div class="anaDiv">
	<div class="div30 hColor font20">
		KDV'li toplam tutarı:
	</div>
	<div class="div70 font20 fontBold" id="SeciliKDV">
		<?php echo Hesapla($TopKDV);?> TL
	</div>
</div>
<div class="anaDiv">
	<div class="div30 hColor font20">
		KDV'siz toplam tutarı:
	</div>
	<div class="div70 font20 fontBold" id="SeciliKDVsiz">
		<?php echo Hesapla($TopKDVsiz);?> TL
	</div>
</div>
<?php if($tesvik['DURUM'] == 5){?>
<div class="anaDiv">
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font18 fontBold hColor">
				Ödenen Toplam Tutar <span class="font16">(TL)</span>:
			</div>
			<div class="div40 fontBold font18">
				<?php echo Hesapla(UcretDuzenle($tesvik['ODENEN'])*UcretDuzenle($tesvik['BANKA_KURU'])).' TL';?>
			</div>
		</div>
	</div>
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font18 fontBold hColor">
				Ödenen Toplam Tutar <span class="font16">(EURO)</span>:
			</div>
			<div class="div40 fontBold font18">
				<?php echo Hesapla(UcretDuzenle($tesvik['ODENEN'])).' €';?>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<div class="anaDiv" style="overflow: auto;">
	<table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
		<thead style="text-align:center;background-color:#71CEED">
			<tr>
				<th width="5%">#</th>
				<th width="15%">Adı Soyadı</th>
				<th width="10%">TC Kimlik</th>
				<th width="15%">Belge No</th>
				<th width="10%">Belge Düzenlenme Tarihi</th>
				<th width="25%">Yeterlilik</th>
				<th width="10%">KDV'li Ücreti</th>
				<th width="10%">KDV'siz Ücreti</th>
				<th width="8%">Dezavantaj Bilgisi</th>
				<th width="10%">Başvuru Dosyası</th>
				<th width="10%">IBAN</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$say = 0;
		foreach ($AdayBilgi as $row){
			$say++;
			// Ücret Hesabı
			$Odenecek = 0;
			$Hesap = 0;
			if($row['ITIRAZ_DURUM'] == null || $row['ITIRAZ_DURUM'] == -1){
				foreach ($UcretBilgi[$row['BELGENO']] as $cow){
					$Hesap += $cow['ucret'];
				}
			}else{
				$Hesap = UcretDuzenle($row['ITIRAZ_UCRET']);
			}
				
			$anaPara = UcretDuzenle($Hesap/$KurKdv);
				
			if($anaPara > UcretDuzenle($maxUcret)){
				$kdvli = UcretDuzenle($maxUcret);
				$kdvsiz = UcretDuzenle($maxUcret);
			}else{
				$kdvli = $Hesap;
				$kdvsiz = $anaPara;
			}
			// Ücret Hesabı SON
			
			echo '<tr>';
			echo '<td>'.$say.'</td>';
			
			echo '<td>'.$row['ADI'].' '.$row['SOYADI'].'</td>';
			echo '<td>'.$row['TCKIMLIKNO'].'</td>';
			echo '<td>'.$row['BELGENO'].'</td>';
			echo '<td>'.$row['BELGE_DUZENLEME_TARIHI'].'</td>';
			echo '<td>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].'</td>';
			echo '<td>'.Hesapla(UcretDuzenle($kdvli)).' TL</td>';
			echo '<td>'.Hesapla(UcretDuzenle($kdvsiz)).' TL</td>';
			
			if($row['DEZAV'] != null){
				$dosyaType = strtolower(pathinfo($row['DEZAV'], PATHINFO_EXTENSION));
				if($dosyaType == 'pdf' || $dosyaType == 'doc' || $dosyaType == 'docx' || $dosyaType == 'zip' || $dosyaType == 'rar'){
					echo '<td><a target="_blank" href="index.php?dl=abhibe/dezavantaj/'.$row['DEZSINAV'].'/'.$row['DEZAV'].'" class="btn btn-sm btn-primary">İndir</a></td>';
				}else if($dosyaType == 'jpg' || $dosyaType == 'jpeg' || $dosyaType == 'png' || $dosyaType == 'gif' || $dosyaType == 'pjpeg'){
					echo '<td><a target="_blank" href="index.php?img=abhibe/dezavantaj/'.$row['DEZSINAV'].'/'.$row['DEZAV'].'" class="btn btn-sm btn-primary">İndir</a></td>';
				}
			}else{
				echo '<td>Yok</td>';
			}
			
			echo '<td><a target="_blank" class="btn btn-xs btn-primary" href="index.php?dl=abhibe/basvuru/'.$row['BASSINAV'].'/'.$row['BASDOK'].'">İndir</a></td>';
			echo '<td class="font15 fontBold">'.$row['BASIBAN'].'</td>';
			echo '</tr>';
		} 
		?>
		</tbody>
	</table>
</div>
<div class="anaDiv">
	<div class="div50">
		<a href="index.php?option=com_belgelendirme_abhibe&view=yonetici" class="btn btn-sm btn-danger">Geri</a>
	</div>
</div>
</form>
<script type="text/javascript">
jQuery(document).ready(function($){
	var oTables = jQuery('#kurTable').dataTable({
// 		"aaSorting": [[ 1, "asc" ]],
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": "# _MENU_ öğe göster",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ Belge Var)",
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
</script>

<?php 
function UcretDuzenle($ucret){
	return str_replace(',', '.',$ucret);
}

function Hesapla($alinacak){
	$dat = floor($alinacak*100)/100;
	return number_format($dat,'2',',','.');
}
?>