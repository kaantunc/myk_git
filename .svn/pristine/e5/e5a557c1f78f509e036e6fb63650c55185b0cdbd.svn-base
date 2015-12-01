<?php
$doviz = $this->doviz;

$KurPro = $this->ABKurPro;
$AdayBilgi = $this->TesvikAdaylar['AdayBilgi'];
$UcretBilgi = $this->TesvikAdaylar['UcretBilgi'];
$YetUcret = $this->TesvikAdaylar['YetUcret'];
$BelgeMasraf = $this->TesvikAdaylar['BelgeMasraf'];
$tesvikAday = $this->tesvikAday;
$tesvik = $this->tesvik;
// Maksimumu Ücret ve KDV'si
$maxUcret = FormABHibeUcretHesabi::ABHibeMaxUcret()*$doviz['alis'];
$maxKDV = UcretDuzenle(FormABHibeUcretHesabi::ABHibeMaxUcret())*(UcretDuzenle($KurPro['KDV'])/100)*UcretDuzenle($doviz['alis']);
// Kota Bilgileri
$toplamKota = UcretDuzenle($this->ABKurKota);
$TopKullanilan = UcretDuzenle($this->ABKurKullanilanKota);
$TopKulDez = UcretDuzenle($this->ABKurKullanilanDezKota);
$ABKurBekKota = UcretDuzenle($this->ABKurBekKota);
$ABKurBekDezKota = UcretDuzenle($this->ABKurBekDezKota);
$TopDezKota = 0;
if($KurPro['DEZAVANTAJ']){
	$TopDezKota = $toplamKota/10;
}
$TopDezsiz = $toplamKota-$TopDezKota;
$dovizKuru = UcretDuzenle($doviz['alis']);
$KurKdv = UcretDuzenle(1+($KurPro['KDV']/100));

$TopKDV = 0;
$TopKDVsiz = 0;
foreach ($AdayBilgi as $row){
	if(in_array($row['BELGENO'], $tesvikAday)){
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
// 		$ParaKdv = $Hesap-$anaPara;
		if($anaPara > UcretDuzenle($maxUcret)){
// 			$kdvli = UcretDuzenle($maxUcret)+$ParaKdv;
			$kdvli = UcretDuzenle($maxUcret)+$maxKDV;
			$kdvsiz = UcretDuzenle($maxUcret);
		}else{
			$kdvli = $Hesap;
			$kdvsiz = $anaPara;
		}
		
		$TopKDV += $kdvli;
		$TopKDVsiz += $kdvsiz;
	}
}
?>
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
	Ücret İadesi Talep Tarihi:
	</div>
	<div class="div70 fontBold font20">
	<?php echo $tesvik['BIT_TARIH']?>
	</div>
</div>
<div class="anaDiv">
	<div class="div30 font20 hColor">
	TC Merkez Bankası EURO <span class="font16">(<?php echo $doviz['tarih'];?>)</span>:
	</div>
	<div class="div70 fontBold font20">
	<?php echo $doviz['alis'].' TL';?>
	</div>
</div>
<div class="anaDiv">
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font20 hColor">
				AB Hibe Toplam Kota <span class="font16">(TL)</span>:
			</div>
			<div class="div40 fontBold font20">
				<?php echo Hesapla($toplamKota*$doviz['alis']).' TL';?>
			</div>
		</div>
	</div>
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font20 hColor">
				AB Hibe Toplam Kota <span class="font16">(EURO)</span>:
			</div>
			<div class="div40 fontBold font20">
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
				<?php echo Hesapla(UcretDuzenle($TopKullanilan)*UcretDuzenle($dovizKuru)).' TL';?>
			</div>
		</div>
	</div>
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				AB Hibe Kullanilan Toplam Kota <span class="font16">(EURO)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php echo Hesapla(UcretDuzenle($TopKullanilan)).' €';?>
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
				echo Hesapla(($TopDezsiz-($TopKullanilan-$TopKulDez))*UcretDuzenle($dovizKuru)). 'TL';
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
				<?php echo Hesapla($TopDezsiz-($TopKullanilan-$TopKulDez)).' €';?>
			</div>
		</div>
	</div>
</div>
<?php if($KurPro['DEZAVANTAJ']){ ?>
<div class="anaDiv">
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				Kullanılabilir Dezavantajlı Kota <span class="font16">(TL)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php 
				echo Hesapla(($TopDezKota-$TopKulDez)*UcretDuzenle($dovizKuru)). 'TL';
				?>
			</div>
		</div>
	</div>
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font16 fontBold hColor">
				Kullanılabilir Dezavantajlı Kota <span class="font16">(EURO)</span>:
			</div>
			<div class="div40 fontBold font16">
				<?php echo Hesapla($TopDezKota-$TopKulDez).' €';?>
			</div>
		</div>
	</div>
</div>
<?php } ?>
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
<form id="TesvikIstek" action="index.php?option=com_belgelendirme_abhibe&task=TesvikAdayYarat" enctype="multipart/form-data" method="post">
<!-- <input type="hidden" name="bas_tarih" value="<?php echo $this->basTarih;?>"/> -->
<input type="hidden" name="IstekId" value="<?php echo $this->IstekId;?>"/>
<div class="anaDiv">
	<div class="div30 hColor font20">
		İmza Yetkilisi Unvan:
	</div>
	<div class="div70">
		<input type="text" class="input-sm inputW50" name="unvan" value="<?php echo $tesvik['IMZA_UNVAN'];?>"/>
	</div>
</div>
<div class="anaDiv">
	<div class="div30 hColor font20">
		İmza Yetkilisi Ad Soyad:
	</div>
	<div class="div70">
		<input type="text" class="input-sm inputW50" name="isim"  value="<?php echo $tesvik['IMZA_ISIM'];?>"/>
	</div>
</div>
<div class="anaDiv">
	<div class="div40 hColor font20">
		Seçili Adayların KDV'li toplam tutarı:
	</div>
	<div class="div60 font20 fontBold" id="SeciliKDV">
		<?php echo Hesapla($TopKDV);?> TL
	</div>
</div>
<div class="anaDiv">
	<div class="div40 hColor font20">
		Seçili Adayların KDV'siz toplam tutarı:
	</div>
	<div class="div60 font20 fontBold" id="SeciliKDVsiz">
		<?php echo Hesapla($TopKDVsiz);?> TL
	</div>
</div>
<div class="anaDiv" style="overflow: auto">
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
				<th width="10%">Dezavantaj Bilgisi</th>
				<th width="10%">Başvuru Dosyası</th>
				<th width="10%">IBAN No</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$say = 0;
		foreach ($AdayBilgi as $row){
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
// 			$ParaKdv = $Hesap-$anaPara;
			if($anaPara > UcretDuzenle($maxUcret)){
				$kdvli = UcretDuzenle($maxUcret)+$maxKDV;
				$kdvsiz = UcretDuzenle($maxUcret);
			}else{
				$kdvli = $Hesap;
				$kdvsiz = $anaPara;
			}
				
			// Ücret Hesabı SON			
			$say++;
			$classDez = "";
			if($row['DEZAV'] != null){
				$classDez = "classDez";
			}
			
			echo '<tr>';
			if(in_array($row['BELGENO'], $tesvikAday)){
				echo '<td><input type="checkbox" class="AdayCheck '.$classDez.'" name="adays[]" value="'.$row['BELGENO'].'" id="aday_'.$row['TCKIMLIKNO'].'" checked="checked"/></td>';
			}else{
				echo '<td><input type="checkbox" class="AdayCheck '.$classDez.'" name="adays[]" value="'.$row['BELGENO'].'"/></td>';
			}
			
			echo '<td>'.$row['ADI'].' '.$row['SOYADI'].'</td>';
			echo '<td>'.$row['TCKIMLIKNO'].'</td>';
			echo '<td>'.$row['BELGENO'].'</td>';
			echo '<td>'.$row['BELGE_DUZENLEME_TARIHI'].'</td>';
			echo '<td>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].'</td>';
			echo '<td>'.Hesapla($kdvli).' TL <input type="hidden" id="kdvliTutar" value="'.$kdvli.'"/></td>';
			echo '<td>'.Hesapla($kdvsiz).' TL <input type="hidden" id="kdvsizTutar" value="'.$kdvsiz.'"/></td>';
// 			echo '<td>'.UcretDuzenle($BelgeMasraf[$row['BELGENO']]).' TL</td>';
// 			echo '<td>'.Hesapla($Odenecek+UcretDuzenle($BelgeMasraf[$row['BELGENO']])).' TL</td>';
			// Dezavantaj Bilgisi ve Düzeltme
			$varStyle = "";
			$yokStyle = "";
			$dezLink = "#";
			if($row['DEZAV'] == null){
				$varStyle="display:none";
			}else{
				$yokStyle="display:none";
				$dezLink = "index.php?dl=abhibe/dezavantaj/".$row['DEZSINAV']."/".$row['DEZAV'];
			}
			echo '<td>';
			echo '<div style="'.$yokStyle.'" class="DEZ_'.$row['TCKIMLIKNO'].'">';
			?>
			<button type="button" class="btn btn-xs btn-success" onclick="DezLightBox(<?php echo $row['TCKIMLIKNO'];?>,'<?php echo $row['BELGENO'];?>')">Yükle</button>
			<?php 
			echo '</div>';
			echo '<div style="'.$varStyle.'" class="DEZY_'.$row['TCKIMLIKNO'].'">';
			echo '<a target="_blank" href="'.$dezLink.'" class="btn btn-xs btn-primary DEZL_'.$row['TCKIMLIKNO'].'">Dezavantaj</a><br>';
			?>
			<button style="margin-top: 5px;" type="button" class="btn btn-xs btn-danger" onclick="FuncDezFileSil(<?php echo $row['TCKIMLIKNO'];?>,'<?php echo $row['BELGENO'];?>')">Sil</button>
			<?php
			echo '</div>';
			echo '</td>';
			// Dezavantaj Bilgisi ve Düzeltme SON
			
			// Aday Başvuru Dosyası BAS
			$varStyle = "";
			$yokStyle = "";
			$basLink = "#";
			$basVal = 0;
			if($row['BASDOK'] == null){
				$varStyle="display:none";
			}else{
				$basVal = 1;
				$yokStyle="display:none";
				$basLink = "index.php?dl=abhibe/basvuru/".$row['BASSINAV']."/".$row['BASDOK'];
			}
			echo '<td>';
			echo '<input type="hidden" class="basDurum basd_'.$row['TCKIMLIKNO'].'" name="basfile['.$row['BELGENO'].']" id="'.$row['BELGENO'].'" value="'.$basVal.'">';
			echo '<div style="'.$yokStyle.'" class="BAS_'.$row['TCKIMLIKNO'].'">';
			?>
			<button type="button" class="btn btn-xs btn-success" onclick="BasLightBox(<?php echo $row['TCKIMLIKNO'];?>,'<?php echo $row['BELGENO'];?>')">Yükle</button>
			<?php 
			echo '</div>';
			echo '<div style="'.$varStyle.'" class="BASY_'.$row['TCKIMLIKNO'].'">';
			echo '<a target="_blank" href="'.$basLink.'" class="btn btn-xs btn-primary BASL_'.$row['TCKIMLIKNO'].'">İndir</a><br>';
			?>
			<button style="margin-top: 5px;" type="button" class="btn btn-xs btn-danger" onclick="FuncBasFileSil(<?php echo $row['TCKIMLIKNO'];?>,'<?php echo $row['BELGENO'];?>')">Sil</button>
			<?php
			echo '</div>';
			echo '</td>';
			// Aday Başvuru Dosyası SON
			
			// Aday AB IBAN BAS
			$varStyle = "";
			$yokStyle = "";
			$basLink = "#";
			$ibanVal = 0;
			if($row['BASIBAN'] == null){
				$varStyle="display:none";
			}else{
				$ibanVal = 1;
				$yokStyle="display:none";
			}
			echo '<td>';
			echo '<input type="hidden" class="ibanDurum iband_'.$row['TCKIMLIKNO'].'" value="'.$ibanVal.'">';
			echo '<div style="'.$yokStyle.'" class="IBAN_'.$row['TCKIMLIKNO'].'">';
			?>
			<button type="button" class="btn btn-xs btn-success" onclick="FuncABIbanDuzenle(<?php echo $row['TCKIMLIKNO'];?>,'<?php echo $row['BELGENO'];?>')">IBAN Kaydet</button>
			<?php 
			echo '</div>';
			echo '<div style="'.$varStyle.'" class="IBANY_'.$row['TCKIMLIKNO'].'">';
			?>
			<button style="margin-top: 5px;" type="button" class="btn btn-xs btn-warning" onclick="FuncABIbanDuzenle(<?php echo $row['TCKIMLIKNO'];?>,'<?php echo $row['BELGENO'];?>')">Düzenle</button>
			<?php
			echo '</div>';
			echo '</td>';
			// Aday AB IBAN SON

			echo '</tr>';
		} 
		?>
		</tbody>
	</table>
</div>
<div class="anaDiv">
	<div class="div50">
		<a href="index.php?option=com_belgelendirme_abhibe&view=belgelendirme_abhibe" class="btn btn-sm btn-danger">İptal</a>
	</div>
	<div class="div50 text-right">
		<button type="button" class="btn btn-sm btn-success" id="TesvikKaydet">Kaydet</button>
	</div>
</div>
</form>

<!-- Dezavantaj Dosyası Yükleme -->
<div id="DezDiv" style=" width: 40%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv font20 fontBold hColor text-center">
		Dezavantaj Bilgisi
	</div>
	<div class="anaDiv font16 text-warning fontBold text-center">
		<i class="fa fa-exclamation-circle"></i> Adayın dezavantaj bilgisini tek dosya halinde pdf olarak yükleyiniz. <i class="fa fa-exclamation-circle"></i>
	</div>
	<div class="anaDiv">
		<div class="div20 font18 fontBold hColor">
			Dosya:
		</div>
		<div class="div80">
			<input type="file" name="filedez" class="input-sm inputW95"/>
			<input type="hidden" name="bNo" value="0"/>
			<input type="hidden" name="tcNo" value="0"/>
		</div>
	</div>
	<div class="anaDiv">
		<div class="div50">
			<button type="button" class="btn btn-sm btn-danger" onclick="jQuery('#DezDiv').trigger('close');">İptal</button>
		</div>
		<div class="div50 text-right">
			<button type="button" class="btn btn-sm btn-success" onclick="FuncDezFileYukle()">Yükle</button>
		</div>
	</div>
</div>

<!-- Aday Başvuru Dosyası Yükleme -->
<div id="BasDiv" style=" width: 40%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv font20 fontBold hColor text-center">
		Aday Başvuru Dosyası
	</div>
<!-- 	<div class="anaDiv font16 text-warning fontBold text-center"> -->
<!-- 		<i class="fa fa-exclamation-circle"></i> Adayın dezavantaj bilgisini tek dosya halinde pdf olarak yükleyiniz. <i class="fa fa-exclamation-circle"></i> -->
<!-- 	</div> -->
	<div class="anaDiv">
		<div class="div20 font18 fontBold hColor">
			Dosya:
		</div>
		<div class="div80">
			<input type="file" name="filebas" class="input-sm inputW95"/>
			<input type="hidden" name="bNo" value="0"/>
			<input type="hidden" name="tcNo" value="0"/>
		</div>
	</div>
	<div class="anaDiv">
		<div class="div50">
			<button type="button" class="btn btn-sm btn-danger" onclick="jQuery('#BasDiv').trigger('close');">İptal</button>
		</div>
		<div class="div50 text-right">
			<button type="button" class="btn btn-sm btn-success" onclick="FuncBasFileYukle()">Yükle</button>
		</div>
	</div>
</div>

<!-- Aday AB IBAN Duzenleme -->
<div id="IBANDiv" style=" width: 40%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<div class="anaDiv font20 fontBold hColor text-center">
		IBAN NO
	</div>
	<div class="anaDiv font16 text-warning fontBold text-center">
		<i class="fa fa-exclamation-circle"></i> Hibenin iade edileceği, başvuru formunda yer alan IBAN Numarası yazılmalıdır. <i class="fa fa-exclamation-circle"></i>
	</div>
	<div class="anaDiv">
		<div class="div20 font18 fontBold hColor">
			IBAN:
		</div>
		<div class="div80">
			<input type="text" name="abIban" class="input-sm inputW95"/>
			<input type="hidden" name="bNo" value="0"/>
			<input type="hidden" name="tcNo" value="0"/>
		</div>
	</div>
	<div class="anaDiv">
		<div class="div50">
			<button type="button" class="btn btn-sm btn-danger" onclick="jQuery('#IBANDiv').trigger('close');">İptal</button>
		</div>
		<div class="div50 text-right">
			<button type="button" class="btn btn-sm btn-success" onclick="FuncABIbanKaydet()">Yükle</button>
		</div>
	</div>
</div>

<!-- UyariLightbox -->
<div id="UyariLoader" style="width: 40%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <div class="naDiv font20 fontBold text-warning text-center text-underline">
    	<i class="fa fa-exclamation-circle"></i> UYARI <i class="fa fa-exclamation-circle"></i>
    </div>
    <div class="anaDiv font16 fontBold text-primary text-center" id="UyariContent">
    
    </div>
    <div class="anaDiv">
    	<button type="button" class="btn btn-sm btn-danger" onclick="jQuery('#UyariLoader').trigger('close');">Kapat</button>
    </div>
</div>
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

	jQuery('#TesvikKaydet').live('click',function(e){
		e.preventDefault();
		oTables.fnFilter('');
		var oSettings = oTables.fnSettings();
        oSettings._iDisplayLength = <?php echo $say;?>;
        oTables.fnDraw();

        var BasHata = 0;
        var IbanHata = 0;
		var belgelist = "";
		jQuery('input[name="adays[]"]:checked').each(function(){
        	belgelist += jQuery(this).val() + ",";
        	var tcId = jQuery(this).attr('id');
        	var spplit = tcId.split('_');
        	if(jQuery('.basd_'+spplit[1]).val() != 1){
        		jQuery('#UyariLoader #UyariContent').html(spplit[1]+" Kimlik No.'lu adayın Başvuru Dosyası kayıtlı değildir. Lütfen adayın başvuru dosyasını kaydediniz.");
				jQuery('#UyariLoader').lightbox_me({
		        	 centered: true,
		             closeClick:false,
		             closeEsc:false  
	        	});
				BasHata++;
				return false;
            }
        	if(jQuery('.iband_'+spplit[1]).val() != 1){
        		jQuery('#UyariLoader #UyariContent').html(spplit[1]+" Kimlik No.'lu adayın IBAN Bilgisi kayıtlı değildir. Lütfen adayın başvuru dosyasını kaydediniz.");
				jQuery('#UyariLoader').lightbox_me({
		        	 centered: true,
		             closeClick:false,
		             closeEsc:false  
	        	});
				IbanHata++;
				return false;
            }
    	});
        belgelist = belgelist.slice(0,-1);

        if(jQuery('#TesvikIstek input[name="unvan"]').val() == ''){
			alert('Ücret İadesi Talebinde bulunması gereken imza yetkilisi ünvan kısmını boş bırakamazsınız.');
		}else if(jQuery('#TesvikIstek input[name="isim"]').val() == ''){
			alert('Ücret İadesi Talebinde bulunması gereken imza yetkilisi ad soyad kısmını boş bırakamazsınız.');
		}else if(jQuery('input[name="adays[]"]:checked').length == 0){
			alert('Ücret İadesi Talebinde bulunmak için en az bir aday seçmelisiniz.');
		}else if(KotaOdemeKontrol()){
			return false;
		}else if(BasHata > 0 || IbanHata > 0){
			return false;
		}else{
			jQuery('#TesvikIstek').submit();
		}
	});

	jQuery('.AdayCheck').live('change',function(e){
		e.preventDefault();
		oTables.fnFilter('');
		var oSettings = oTables.fnSettings();
        oSettings._iDisplayLength = <?php echo $say;?>;
        oTables.fnDraw();
		var kdvli = 0;
		var kdvsiz = 0;
		jQuery('.AdayCheck:checked').each(function(key,val){
			kdvli += parseFloat(jQuery(this).closest('tr').children('td').children('input#kdvliTutar').val());
			kdvsiz += parseFloat(jQuery(this).closest('tr').children('td').children('input#kdvsizTutar').val());
		});
		jQuery('#SeciliKDV').html(number_format(kdvli,2,',','.')+' TL');
		jQuery('#SeciliKDVsiz').html(number_format(kdvsiz,2,',','.')+' TL');
// 		alert(number_format(kdvli,2,',','.'));
// 		alert(number_format(kdvsiz,2,',','.'));
	});
});
function OpenLightBox(ele, overSpeed, boxSpeed){
	jQuery(ele).lightbox_me({
		overlaySpeed: 350,
		lightboxSpeed: 400,
    	centered: true,
        closeClick:false,
        closeEsc:false,
        overlayCSS: {background: 'black', opacity: .7}
    });
    return false;
}

//Dezavataj Bilgisi Düzenleme BAS
function DezLightBox(tcno,bNo){
	jQuery('#DezDiv input[name="filedez"]').val('');
	jQuery('#DezDiv input[name="bNo"]').val(bNo);
	jQuery('#DezDiv input[name="tcNo"]').val(tcno);
	OpenLightBox('#DezDiv');
}
function FuncDezFileYukle(){
	var bNo = jQuery('#DezDiv input[name="bNo"]').val();
	var tcNo = jQuery('#DezDiv input[name="tcNo"]').val();
	if(!jQuery('#DezDiv input[name="filedez"]')[0].files[0]){
		alert('Lütfen Aday Dezavantaj Dosyasını Boş Bırakmayınız.');
	}else{
		var formData = new FormData();
		formData.append('file', jQuery('#DezDiv input[name="filedez"]')[0].files[0]);
		formData.append('bNo', bNo);
		formData.append('tcNo', tcNo);
	
		jQuery.ajax({
			async: false,
			url : 'index.php?option=com_belgelendirme_abhibe&task=ABHibeAdayDezFileYukle&format=raw',
			type : 'POST',
			data : formData,
			processData: false,  // tell jQuery not to process the data
			contentType: false,  // tell jQuery not to set contentType
			success : function(data) {
				var dat = jQuery.parseJSON(data);
				if(dat['hata']){
					alert(dat['message']);
				}else{
	                jQuery('div.DEZ_'+tcNo).hide();
	                jQuery('div.DEZY_'+tcNo).show();
	                jQuery('a.DEZL_'+tcNo).attr('href','index.php?dl=abhibe/dezavantaj/'+dat['sId']+'/'+dat['name']);
	                alert(dat['message']);
	            }
				jQuery('#DezDiv').trigger('close');
		   }
		});
	}
}
function FuncDezFileSil(tcNo,bNo){
	if(confirm('Adaya ait dezavantaj bilgisini silmek istediğinizden emin misiniz?')){
		jQuery.ajax({
			async: false,
			url : 'index.php?option=com_belgelendirme_abhibe&task=ABHibeAdayDezFileSil&format=raw',
			type : 'POST',
			data : 'tcNo='+tcNo+'&bNo='+bNo,
			success : function(data) {
				var dat = jQuery.parseJSON(data);
				if(dat){
					jQuery('div.DEZY_'+tcNo).hide();
	                jQuery('div.DEZ_'+tcNo).show();
	                jQuery('a.DEZL_'+tcNo).attr('href','#');
					alert('Aday Dezavantaj bilgisi başarıyla silindi.');
				}else{
	                alert('Bir hata meydana geldi. Tekrar deneyin.');
	            }
		   }
		});
	}
}
// Dezavataj Bilgisi Düzenleme SON

// Basvuru Dosyası Düzenleme BAS
function BasLightBox(tcno,bNo){
	jQuery('#BasDiv input[name="filebas"]').val('');
	jQuery('#BasDiv input[name="bNo"]').val(bNo);
	jQuery('#BasDiv input[name="tcNo"]').val(tcno);
	OpenLightBox('#BasDiv');
}
function FuncBasFileYukle(){
	var bNo = jQuery('#BasDiv input[name="bNo"]').val();
	var tcNo = jQuery('#BasDiv input[name="tcNo"]').val();
	if(!jQuery('#BasDiv input[name="filebas"]')[0].files[0]){
		alert('Lütfen Aday Başvuru Dosyasını Boş Bırakmayınız.');
	}else{
		var formData = new FormData();
		formData.append('file', jQuery('#BasDiv input[name="filebas"]')[0].files[0]);
		formData.append('bNo', bNo);
		formData.append('tcNo', tcNo);
	
		jQuery.ajax({
			async: false,
			url : 'index.php?option=com_belgelendirme_abhibe&task=ABHibeAdayBasFileYukle&format=raw',
			type : 'POST',
			data : formData,
			processData: false,  // tell jQuery not to process the data
			contentType: false,  // tell jQuery not to set contentType
			success : function(data) {
				var dat = jQuery.parseJSON(data);
				if(dat['hata']){
					alert(dat['message']);
					jQuery('input.basd_'+tcNo).val(0);
				}else{
	                jQuery('div.BAS_'+tcNo).hide();
	                jQuery('div.BASY_'+tcNo).show();
	                jQuery('a.BASL_'+tcNo).attr('href','index.php?dl=abhibe/basvuru/'+dat['sId']+'/'+dat['name']);
	                jQuery('input.basd_'+tcNo).val(1);
	                alert(dat['message']);
	            }
				jQuery('#BasDiv').trigger('close');
		   }
		});
	}
}
function FuncBasFileSil(tcNo,bNo){
	if(confirm('Adaya ait Başvuru Dosyasını silmek istediğinizden emin misiniz?')){
		jQuery.ajax({
			async: false,
			url : 'index.php?option=com_belgelendirme_abhibe&task=ABHibeAdayBasFileSil&format=raw',
			type : 'POST',
			data : 'tcNo='+tcNo+'&bNo='+bNo,
			success : function(data) {
				var dat = jQuery.parseJSON(data);
				if(dat){
					jQuery('input.basd_'+tcNo).val(0);
					jQuery('div.BASY_'+tcNo).hide();
	                jQuery('div.BAS_'+tcNo).show();
	                jQuery('a.BASL_'+tcNo).attr('href','#');
					alert('Aday Başvuru dosyası başarıyla silindi.');
				}else{
	                alert('Bir hata meydana geldi. Tekrar deneyin.');
	            }
		   }
		});
	}
}
// Basvuru Dosyası Düzenleme SON

// AB IBAN Duzenle Bas
function FuncABIbanDuzenle(tcNo,bNo){
	jQuery('#IBANDiv input[name="abIban"]').val('');
	jQuery('#IBANDiv input[name="bNo"]').val(bNo);
	jQuery('#IBANDiv input[name="tcNo"]').val(tcNo);
	jQuery.ajax({
		async: false,
		url : 'index.php?option=com_belgelendirme_abhibe&task=ABHibeAdayIbanGetir&format=raw',
		type : 'POST',
		data : 'tcNo='+tcNo+'&bNo='+bNo,
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat){
			jQuery('#IBANDiv input[name="abIban"]').val(dat['IBAN']);
		}
		OpenLightBox('#IBANDiv');
	});
}
function FuncABIbanKaydet(){
	var bNo = jQuery('#IBANDiv input[name="bNo"]').val();
	var tcNo = jQuery('#IBANDiv input[name="tcNo"]').val();
	var abIban = jQuery('#IBANDiv input[name="abIban"]').val();
	abIban = abIban.replace(/\s+/g, '');
	if(abIban.length != 26){
		alert('Lütfen IBAN Numarasını doğru girdiğinizden emin olunuz.');
	}else{
		jQuery.ajax({
			async: false,
			url : 'index.php?option=com_belgelendirme_abhibe&task=ABHibeAdayIbanKaydet&format=raw',
			type : 'POST',
			data : 'tcNo='+tcNo+'&bNo='+bNo+'&abIban='+abIban,
			success : function(data) {
				var dat = jQuery.parseJSON(data);
				if(dat['hata']){
					jQuery('input.iband_'+tcNo).val(0);
					alert(dat['message']);
				}else{
					if(dat['iban'] == null || dat['iban'] == '' || dat['iban'].length != 26){
						jQuery('div.IBAN_'+tcNo).show();
		                jQuery('div.IBANY_'+tcNo).hide();
						jQuery('input.iband_'+tcNo).val(0);
						alert(dat['message']);
					}else{
						jQuery('div.IBAN_'+tcNo).hide();
		                jQuery('div.IBANY_'+tcNo).show();
		                jQuery('input.iband_'+tcNo).val(1);
		                alert(dat['message']);
					}
	            }
				jQuery('#IBANDiv').trigger('close');
		   }
		});
	}
}
// AB IBAN Duzenle SON
function KotaOdemeKontrol(){
	var durum = false;
	var kdvsiz = 0;
	var dezUcret = 0;
	jQuery('.AdayCheck:checked').each(function(key,val){
		if(jQuery(this).hasClass('classDez')){
			dezUcret += parseFloat(jQuery(this).closest('tr').children('td').children('input#kdvsizTutar').val());
		}
		kdvsiz += parseFloat(jQuery(this).closest('tr').children('td').children('input#kdvsizTutar').val());
	});

	jQuery.ajax({
		async:false,
		type:"POST",
		url:"index.php?option=com_belgelendirme_abhibe&task=KotaOdemeKontrol&format=raw",
		data:"TopUcret="+kdvsiz+"&TopDez="+dezUcret+"&doviz="+parseFloat(<?php echo $dovizKuru;?>)+"&kId=<?php echo $this->user_id;?>"
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat['hata']){
			durum = true;
			alert(dat['mesaj']);
		}
	});

	return durum;
}

function number_format(number, decimals, dec_point, thousands_sep) {
	  //  discuss at: http://phpjs.org/functions/number_format/
	  // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	  // improved by: davook
	  // improved by: Brett Zamir (http://brett-zamir.me)
	  // improved by: Brett Zamir (http://brett-zamir.me)
	  // improved by: Theriault
	  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	  // bugfixed by: Michael White (http://getsprink.com)
	  // bugfixed by: Benjamin Lupton
	  // bugfixed by: Allan Jensen (http://www.winternet.no)
	  // bugfixed by: Howard Yeend
	  // bugfixed by: Diogo Resende
	  // bugfixed by: Rival
	  // bugfixed by: Brett Zamir (http://brett-zamir.me)
	  //  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
	  //  revised by: Luke Smith (http://lucassmith.name)
	  //    input by: Kheang Hok Chin (http://www.distantia.ca/)
	  //    input by: Jay Klehr
	  //    input by: Amir Habibi (http://www.residence-mixte.com/)
	  //    input by: Amirouche
	  //   example 1: number_format(1234.56);
	  //   returns 1: '1,235'
	  //   example 2: number_format(1234.56, 2, ',', ' ');
	  //   returns 2: '1 234,56'
	  //   example 3: number_format(1234.5678, 2, '.', '');
	  //   returns 3: '1234.57'
	  //   example 4: number_format(67, 2, ',', '.');
	  //   returns 4: '67,00'
	  //   example 5: number_format(1000);
	  //   returns 5: '1,000'
	  //   example 6: number_format(67.311, 2);
	  //   returns 6: '67.31'
	  //   example 7: number_format(1000.55, 1);
	  //   returns 7: '1,000.6'
	  //   example 8: number_format(67000, 5, ',', '.');
	  //   returns 8: '67.000,00000'
	  //   example 9: number_format(0.9, 0);
	  //   returns 9: '1'
	  //  example 10: number_format('1.20', 2);
	  //  returns 10: '1.20'
	  //  example 11: number_format('1.20', 4);
	  //  returns 11: '1.2000'
	  //  example 12: number_format('1.2000', 3);
	  //  returns 12: '1.200'
	  //  example 13: number_format('1 000,50', 2, '.', ' ');
	  //  returns 13: '100 050.00'
	  //  example 14: number_format(1e-8, 8, '.', '');
	  //  returns 14: '0.00000001'

	  number = (number + '')
	    .replace(/[^0-9+\-Ee.]/g, '');
	  var n = !isFinite(+number) ? 0 : +number,
	    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	    s = '',
	    toFixedFix = function(n, prec) {
	      var k = Math.pow(10, prec);
	      return '' + (Math.round(n * k) / k)
	        .toFixed(prec);
	    };
	  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
	    .split('.');
	  if (s[0].length > 3) {
	    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	  }
	  if ((s[1] || '')
	    .length < prec) {
	    s[1] = s[1] || '';
	    s[1] += new Array(prec - s[1].length + 1)
	      .join('0');
	  }
	  return s.join(dec);
	}
</script>

<?php 
function UcretDuzenle($ucret){
	return str_replace(',', '.',$ucret);
}
function UcretFloor($dat){
	return floor($dat*100)/100;
}
function Hesapla($alinacak){
	$dat = floor($alinacak*100)/100;
	return number_format($dat,'2',',','.');
}
?>