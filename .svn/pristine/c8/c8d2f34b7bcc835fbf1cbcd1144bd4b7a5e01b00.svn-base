<?php
?>
<span style="color:#063B5E;">T.C. Kimlik No: </span><input type="text" id="tcno"/><input type="button" value="Getir" id="adayGetir"/>
<hr>
<div id="adayBilgi" style="display:none">
	<div><span style="color:#063B5E;">Adı: </span><span id="isim" style="margin-left:78px"></span></div>
	<div><span style="color:#063B5E;">Soyadı: </span><span id="soyisim" style="margin-left:57px"></span></div>
	<div><span style="color:#063B5E;">Doğum Tarihi: </span><span id="dtarih" style="margin-left:21px"></span></div>
	<div><span style="color:#063B5E;">Doğum Yeri: </span><span id="dyer" style="margin-left:31px"></span></div>
	<div><span style="color:#063B5E;">Baba Adı: </span><span id="Bisim" style="margin-left:45px"></span></div>
	<div><span style="color:#063B5E;">Cinsiyeti: </span><span id="cins" style="margin-left:46px"></span></div>
	<div><span style="color:#063B5E;">Eğitimi: </span><span id="egitim" style="margin-left:56px"></span></div>
	<div><span style="color:#063B5E;">Çalışma Durumu: </span><span id="Cdurum" ></span></div>
</div>
<script type="text/javascript">
function tckimlikkontorolu(tcno) {
    var tckontrol,toplam; tckontrol = tcno; toplam = Number(tcno.substring(0,1)) + Number(tcno.substring(1,2)) +
    Number(tcno.substring(2,3)) + Number(tcno.substring(3,4)) +
    Number(tcno.substring(4,5)) + Number(tcno.substring(5,6)) +
    Number(tcno.substring(6,7)) + Number(tcno.substring(7,8)) +
    Number(tcno.substring(8,9)) + Number(tcno.substring(9,10)); 
    strtoplam = String(toplam); onunbirlerbas = strtoplam.substring(strtoplam.length,strtoplam.length-1);

    if(onunbirlerbas == tcno.substring(10,11)) {
        return true;
    } else{ 
        return false; 
    } 
}


jQuery(document).ready(function(){
	jQuery('#adayGetir').live('click',function(e){
		e.preventDefault();
		jQuery('#adayBilgi').hide();
		jQuery('#isim').html('');
		jQuery('#soyisim').html('');
		jQuery('#dtarih').html('');
		jQuery('#dyer').html('');
		jQuery('#Bisim').html('');
		jQuery('#cins').html('');
		jQuery('#egitim').html('');
		jQuery('#Cdurum').html('');
		var tcno = jQuery('#tcno').val();
		if(tcno.length == 11){
			if(tckimlikkontorolu(tcno)){
				jQuery.ajax({
					async:false,
					type:'post',
					url:'index.php?option=com_belgelendirme&task=tcKayitliAday&format=raw',
					data:'tcno='+tcno,
					success:function(data){
						var dat = jQuery.parseJSON(data);
						if(dat.length>0){
							jQuery('#isim').append(dat[0]['ADI']);
							jQuery('#soyisim').append(dat[0]['SOYADI']);
							jQuery('#dtarih').append(dat[0]['DOGUM_TARIHI']);
							jQuery('#dyer').append(dat[0]['DOGUM_YERI']);
							jQuery('#Bisim').append(dat[0]['BABA_ADI']);
							if(dat[0]['CINSIYETI'] == 1){
								jQuery('#cins').append('Erkek');
							}
							else if (dat[0]['CINSIYETI'] == 2){
								jQuery('#cins').append('Kadın');
							}
							else{
								jQuery('#cins').append('Belirtilmemiş');
							}
							
							if(dat[0]['EGITIMI'] == 1){
								jQuery('#egitim').append('Okuma yazması yok');
								}
							else if(dat[0]['EGITIMI'] == 2){
								jQuery('#egitim').append('Okur yazar');
								}
							else if(dat[0]['EGITIMI'] == 3){
								jQuery('#egitim').append('İlkokul');
							}
							else if(dat[0]['EGITIMI'] == 4){
								jQuery('#egitim').append('Orta okul');
							}
							else if(dat[0]['EGITIMI'] == 5){
								jQuery('#egitim').append('Lise');
							}
							else if(dat[0]['EGITIMI'] == 6){
								jQuery('#egitim').append('Ön lisans');
							}
							else if(dat[0]['EGITIMI'] == 7){
								jQuery('#egitim').append('Lisans');
							}
							else if(dat[0]['EGITIMI'] == 8){
								jQuery('#egitim').append('Yüksek lisans');
							}
							else if(dat[0]['EGITIMI'] == 9){
								jQuery('#egitim').append('Doktora');
							}
							
							if(dat[0]['CALISMA_DURUMU'] == 1){
								jQuery('#Cdurum').append('Çalışıyor');
							}
							else{
								jQuery('#Cdurum').append('Çalışmıyor');
							}
							
							jQuery('#adayBilgi').show('slow');
						}
						else{
							alert("Bu T.C. Kimlik No'suna ait bir kullanıcı bulunmamaktadır.");
						}
					}
				});
			}
			else{
				alert('Girdiğiniz T.C. Kimlik No hatalıdır.Lütfen tekrar giriniz.');
				}
		}
		else{
			alert('Girdiğiniz T.C. Kimlik No hatalıdır.Lütfen tekrar giriniz.');
		}
	});
})
</script>