<?php
// $doviz = $this->doviz;
// $maxUcret = FormABHibeUcretHesabi::ABHibeMaxUcret()*$doviz['alis'];

$KurPro = $this->ABKurPro;
$AdayBilgi = $this->TesvikAdaylar['AdayBilgi'];
$UcretBilgi = $this->TesvikAdaylar['UcretBilgi'];
$tesvik = $this->tesvik;
$kurBilgi = $this->kurBilgi;
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

$doviz = $this->doviz;
$dovizKuru = UcretDuzenle($doviz['alis']);
$maxUcret = FormABHibeUcretHesabi::ABHibeMaxUcret()*UcretDuzenle($dovizKuru);
$KurKdv = UcretDuzenle(1+($KurPro['KDV']/100));

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
	<div class="div30 font20 hColor">
	TC Merkez Bankası EURO <span class="font16">(<?php echo $doviz['tarih'];?>)</span>:
	</div>
	<div class="div70 fontBold font20">
	<?php echo $dovizKuru.' TL';?>
	</div>
</div>
<div class="anaDiv">
	<div class="div50">
		<div class="anaDiv">
			<div class="div60 font20 hColor">
				AB Hibe Toplam Kota <span class="font16">(TL)</span>:
			</div>
			<div class="div40 fontBold font20">
				<?php echo Hesapla($toplamKota*UcretDuzenle($dovizKuru)).' TL';?>
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
<form id="TesvikIstek" action="index.php?option=com_belgelendirme_abhibe&task=TesvikAdayKaydet" enctype="multipart/form-data" method="post">
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
<div class="anaDiv">
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
				<th width="10%">Dezavantaj Dökümanları</th>
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
		
			if($anaPara > UcretDuzenle($maxUcret)){
				$kdvli = UcretDuzenle($maxUcret);
				$kdvsiz = UcretDuzenle($maxUcret);
			}else{
				$kdvli = $Hesap;
				$kdvsiz = $anaPara;
			}
					
			// Ücret Hesabı SON			
			$say++;
			echo '<tr>';
			$classDez = "";
			if($row['DEZAV'] != null){
				$classDez = "classDez";
			}
			echo '<td><input type="checkbox" class="AdayCheck '.$classDez.'" name="adays[]" value="'.$row['BELGENO'].'" checked="checked"/></td>';
			
			echo '<td>'.$row['ADI'].' '.$row['SOYADI'].'</td>';
			echo '<td>'.$row['TCKIMLIKNO'].'</td>';
			echo '<td>'.$row['BELGENO'].'</td>';
			echo '<td>'.$row['BELGE_DUZENLEME_TARIHI'].'</td>';
			echo '<td>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].'</td>';
			echo '<td>'.Hesapla($kdvli).' TL <input type="hidden" id="kdvliTutar" value="'.$kdvli.'"/></td>';
			echo '<td>'.Hesapla($kdvsiz).' TL <input type="hidden" id="kdvsizTutar" value="'.$kdvsiz.'"/></td>';
// 			echo '<td>'.UcretDuzenle($BelgeMasraf[$row['BELGENO']]).' TL</td>';
// 			echo '<td>'.Hesapla($Odenecek+UcretDuzenle($BelgeMasraf[$row['BELGENO']])).' TL</td>';
			if($row['DEZAV'] != null){
				$dosyaType = strtolower(pathinfo($row['DEZAV'], PATHINFO_EXTENSION));
				if($dosyaType == 'pdf' || $dosyaType == 'doc' || $dosyaType == 'docx' || $dosyaType == 'zip' || $dosyaType == 'rar'){
					echo '<td><a target="_blank" href="index.php?dl=abhibe/dezavantaj/'.$row['SINAV_ID'].'/'.$row['DEZAV'].'" class="btn btn-sm btn-info">İndir</a></td>';
				}else if($dosyaType == 'jpg' || $dosyaType == 'jpeg' || $dosyaType == 'png' || $dosyaType == 'gif' || $dosyaType == 'pjpeg'){
					echo '<td><a target="_blank" href="index.php?img=abhibe/dezavantaj/'.$row['SINAV_ID'].'/'.$row['DEZAV'].'" class="btn btn-sm btn-info">İndir</a></td>';
				}
			}else{
				echo '<td>Yok</td>';
			}

			echo '</tr>';
		} 
		?>
		</tbody>
	</table>
</div>
<div class="anaDiv">
	<div class="div50">
		<a href="index.php?option=com_belgelendirme_abhibe&view=yonetici" class="btn btn-sm btn-danger">İptal</a>
	</div>
	<div class="div50 text-right">
		<button type="button" class="btn btn-sm btn-success" id="TesvikKaydet">Kaydet</button>
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

	jQuery('#TesvikKaydet').live('click',function(e){
		e.preventDefault();
		oTables.fnFilter('');
		var oSettings = oTables.fnSettings();
        oSettings._iDisplayLength = <?php echo $say;?>;
        oTables.fnDraw();

		var belgelist = "";
        jQuery.each(jQuery('input[name="adays[]"]:checked'),function(){
        	belgelist += jQuery(this).val() + ",";
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
		data:"TopUcret="+kdvsiz+"&TopDez="+dezUcret+"&doviz="+parseFloat(<?php echo $dovizKuru;?>)+"&kId=<?php echo $kurBilgi['USER_ID']?>&IstekId=<?php echo $this->IstekId;?>"
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