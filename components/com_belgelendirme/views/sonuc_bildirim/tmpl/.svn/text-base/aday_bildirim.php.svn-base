<?php
echo $this->sayfaLink;
$yets = $this->yets;
$kurs = $this->kurs;
$sonucs = $this->sonucs;
$basarili = $sonucs[0];
$basarisiz = $sonucs[1];
$ogr = $sonucs[2];
//echo '<br><h2>'.$yets[0]['YETERLILIK_KODU'].'/'.$yets[0]['REVIZYON'].' '.$yets[0]['YETERLILIK_ADI'].' ('.$yets[0]['BASLANGIC_TARIHI'].')</h2><br>';
$BelgeVar = 0;
foreach($basarili as $key=>$vall){
	 if(count($ogr[$key]['ONCEKI_BELGE'])>0){
	 	$BelgeVar++;
	 }
}
if($BelgeVar){
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	 jQuery.blockUI({
		 message: jQuery('#BelgeUyari') ,
		 css: {
			 width: '50%',
			 left:  '30%', 
			 }, 
         onOverlayClick: jQuery.unblockUI
     });
});
</script>
<div id="BelgeUyari" style="display:none;"> 
    <div class="anaDiv font18 fontBold text-warning">
    	<i class="fa fa-exclamation-circle"></i> 
    	Listede kırmızıyla belirtilmiş satırdaki adaylar daha önce sınava konu olan yeterlilikten belge almıştır. 
    	<i class="fa fa-exclamation-circle"></i>
    </div>
    <div class="anaDiv">
    	<button type="button" class="btn btn-sm btn-danger" onclick="jQuery.unblockUI();">Kapat</button>
    </div>
</div>
<?php 
}
?>
<style>
.width150{
	width:150px;
	float:left;
	font-weight: bold;
	color:#063B5E;
}
.aramaClass>div{
	padding-top:10px;
}
.aramaClass{
	margin-bottom:30px;
}
.aramaSonuc{
 	display:none;
	margin-top:20px;
}
</style>
<div class="aramaClass">
<div class="width150">Kurulus Adı:</div><div><?php echo $kurs['KURULUS_ADI'];?></div>
<div class="width150">Kuruluş Kodu:</div><div><?php echo $kurs['KURULUS_YETKILENDIRME_NUMARASI'];?></div>
<div class="width150">Sınavın Yeterliliği:</div><div><?php echo $yets[0]['YETERLILIK_KODU'].'/'.$yets[0]['REVIZYON'].' '.$yets[0]['YETERLILIK_ADI'];?></div>
<div class="width150">Sınavın Tarihi:</div><div><?php echo $yets[0]['BASLANGIC_TARIHI'];?></div>
</div>

<?php    
	$sayBas=0;
    $basariliEkle = "";
    foreach($basarili as $key=>$vall){
    	
    	if(count($ogr[$key]['ONCEKI_BELGE'])>0){
    		$bgcolor="#ff6c60";
    		$tooltips = "";
    		foreach ($ogr[$key]['ONCEKI_BELGE'] as $data){
    			$tooltips .= "<strong>Belge No:</strong> <em>".$data['BELGENO'].'</em><br>';
			}
    	}else{
    		if($sayBas%2==0){
    			$bgcolor="#efefef";
    		}else{
    			$bgcolor="#FFFFFF";
    		}
    	}
    	
        $birimler = '';
        $basariliEkle .= '<tr bgcolor="'.$bgcolor.'">';
        $basariliEkle .= '<td rowspan="2" class="tooltip" title="'.$tooltips.'"><input type="checkbox"  checked="checked" name="basarili[]" value="'.$key.'"/></td>';
        $basariliEkle .= '<td rowspan="2" class="fontBold tooltip" title="'.$tooltips.'">'.($sayBas+1).'</td>';
        $basariliEkle .= '<td class="fontBoldtooltip" title="'.$tooltips.'">'.$ogr[$key]['TC_KIMLIK'].' - '.$ogr[$key]['ADI'].' '.$ogr[$key]['SOYADI'].'</td></tr>';
        $basariliEkle .= '<tr bgcolor="'.$bgcolor.'"><td>';
        foreach($vall as $keyy=>$birims){
        	$basariliEkle .= $birims[1].',';
		}
        $basariliEkle .= $birimler . '</td></tr>';
        $sayBas++;
	}

    $sayBassiz=0;
    $basarisizEkle = "";
    foreach($basarisiz as $key=>$vall){
    	if($sayBassiz%2==0){
        	$bgcolor="#efefef";
        }else{
        	$bgcolor="#FFFFFF";
        }
        $birimler = '';
        $basarisizEkle .= '<tr bgcolor="'.$bgcolor.'">';
        $basarisizEkle .= '<td rowspan="2"><input type="checkbox" name="basarisiz[]" value="'.$key.'"/></td>';
        $basarisizEkle .= '<td>'.$ogr[$key]['ADI'].' '.$ogr[$key]['SOYADI'].'</td>';
        $basarisizEkle .= '<td rowspan="2"><textarea name="aciklama['.$key.']"></textarea></td></tr>';
        $basarisizEkle .= '<tr bgcolor="'.$bgcolor.'"><td>';
        foreach($vall as $keyy=>$birims){
        	$basarisizEkle .= $birims[2].',';
		}
        $basarisizEkle .= $birimler . '</td></tr>';
        $sayBassiz++;
	}
	
?>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.tooltip').tooltipster({
		contentAsHTML: true,
		theme: 'tooltipster-shadow',
		positionTracker: true,
		interactive: true
	});
});

jQuery('#adayGonderIptal').live('click',function(e){
	e.preventDefault();
	jQuery('#basariliAdaylar').html('');
	jQuery('#basarisizAdaylar').html('');
	jQuery('#adaySecGonderSinav').val('');
	jQuery('#adaySecGonder').trigger('close');
});

jQuery('#adayGonderKaydet').live('click',function(e){
	e.preventDefault();
//	if(confirm('Aday Sonuçlarını Göndermek istediğinizden emin misiniz? Gönderdikten sonra sonuç sayfasında işlem yapamazsınız.')){
    	var hata = 0;
    	jQuery.each(jQuery(':checkbox[name="basarisiz[]"]'),function(key,vall){
        	if(vall.checked == true){
        		if(jQuery('textarea[name="aciklama['+vall.value+']"]').val().length == 0 || jQuery('textarea[name="aciklama['+vall.value+']"]').val() == ''){
                    hata++;
               	}
            }
        });

        if(hata>0){
        	alert('Lütfen Belge Almaya Hak Kazanamayan Adaylar kısmında seçmiş olduğunuz adaylar için Belge Verebilmek için Açıklama kısımlarını doldurunuz.');
        }else{
        	jQuery.each(jQuery(':checkbox[name="basarisiz[]"]'),function(key,vall){
        		if(vall.checked == false){
                	jQuery('textarea[name="aciklama['+vall.value+']"]').remove();
                }
            });
        	jQuery('#belgeAdayBildirimKaydet').submit();
        }
//	}
// 	jQuery('#belgeAdayBildirimKaydet').submit();
});
</script>

    <form id="belgeAdayBildirimKaydet" name="belgeAdayBildirimKaydet"
	action="index.php?option=com_belgelendirme&view=sonuc_bildirim&layout=belgeno_bildirim" enctype="multipart/form-data" method="post">
	<div id="basAdayDiv" class="anaDiv">
		<i>Aşağıda kırmızıyla belirtilmiş satırdaki adaylar daha önce sınava konu olan yeterlilikten belge almıştır.</i><br><br>
    	<h2>Belge Almaya Hak Kazanan Adaylar</h2>
    	<table style="width:100%; text-align:center" border="1">
    		<thead style="background-color:#71CEED">
    		<tr>
    		<th>#</th>
    		<th>Sıra</th>
    		<th>Aday Bilgisi</th>
    		</tr>
    		</thead>
    		<tbody id="basariliAdaylar">
    		<?php echo $basariliEkle;?>
    		</tbody>
    	</table>
    </div>
    <div class="anaDiv">
    	<button type="button" id="adayGonderKaydet" class="btn btn-sm btn-success">Gönder</button>
    </div>
    	<input type="hidden" name="sinav" value="<?php echo $this->sinavId;?>" id="adaySecGonderSinav"/>
    </form>
