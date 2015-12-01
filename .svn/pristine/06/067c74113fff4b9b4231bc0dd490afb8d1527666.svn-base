<?php
defined('_JEXEC') or die('Restricted access');


$document = &JFactory::getDocument();
$document->addScript( SITE_URL.'/templates/elegance/js/paginate.min.js' );
$document->addScript( SITE_URL.'/templates/elegance/js/tablesort.min.js' );

$sonuclar = $this->sinavlar;
$aramaSozcugu = $this->aramaSozcugu;

$iskomite = $this->komite;

if(empty($sonuclar)){
	echo '<div class="sonucBulunamadi">'.JText::_('SINAV_BILDIRIMI_YOK').'</div>';
	if($iskomite){
		echo '<a href="index.php?option=com_kurulus_ara&gorev=kurulus_adi&kurulus_adi='. $aramaSozcugu.'">Geri</a>';
	}
}
else{


?>

<div class="tableWrapper">
<form action="index.php?option=com_sinav&task=sertifikaBasvur" method="POST">
<table cellspacing="0" class="paginate-10 sortable">
	<thead>
	<tr class="tablo_header">
		<th class="sortable-numeric">#</th>
		<th class="sortable-date-dmy">Sınav Tarihi</th>
		<th class="sortable-date-dmy">Sınav Saati</th>
		<th class="sortable-text">Sınav Merkezi</th>
		<th class="sortable-text">Yeterlilik Adı</th>
		<th class="sortable-text">Yeterlilik Seviyesi</th>
		<th class="sortable-text">Yeterlilik Birimleri</th>
		<th class="sortable-numeric">Toplam Aday</th>
		<?php if($iskomite == 1){?>
		<th class="sortable-text">Sonuç Gör</th>
		<th class="sortable-text">Sonuç Girilmesine İzin Ver</th>
		<?php }else{?>
		<th class="sortable-text">Sonuç Gir</th>
		<?php }?>
		<th class="sortable-text">Sertifika İsteği</th>
	</tr>
	</thead>
	<tbody>
	<?php
		$rowCount=1;
		$rowClass="";
		$checkBoxDisabled = "";
		foreach($sonuclar AS $satir){
			if($rowCount%2==0)
				$rowClass = "even_row";
			else
				$rowClass = "odd_row";
				
			echo '<tr class="'.$rowClass.'">';
			
			echo '<td>'.$rowCount.'</td>';
			echo '<td>'.($satir['SINAV_TARIHI']?$satir['SINAV_TARIHI']:"&nsbp;").'</td>';
			echo '<td>'.($satir['SINAV_SAAT']?$satir['SINAV_SAAT']:"&nsbp;").'</td>';
			echo '<td>'.($satir['MERKEZ_ADI']?$satir['MERKEZ_ADI']:"&nsbp;").'</td>';
			echo '<td>'.($satir['YETERLILIK_ADI']?$satir['YETERLILIK_ADI']:"&nsbp;").'</td>';
			echo '<td>'.($satir['SEVIYE_ADI']?$satir['SEVIYE_ADI']:"&nsbp;").'</td>';
			//echo '<td class="birimler" id="'.$satir['YETERLILIK_ID'].'">'.($satir['SINAV_BIRIMLERI']?$satir['SINAV_BIRIMLERI']:"&nsbp;").'</td><input type="hidden" class="'.$satir['YETERLILIK_ID'].'" value="'.$satir['SINAV_BIRIMLERI'].'"/>';
			echo '<td class="birimler" id="'.$satir['YETERLILIK_ID'].'"><a href="#">Detaylara Bak</a><input type="hidden" class="'.$satir['YETERLILIK_ID'].'" value="'.$satir['SINAV_BIRIMLERI'].'"/></td>';
			echo '<td>'.($satir['TOPLAM_ADAY']?$satir['TOPLAM_ADAY']:"&nsbp;").'</td>';
			
			if(($satir['BASARILI_ADAY'] == SERTIFIKA_BASVURULDU) && $iskomite == 0){
				$checkBoxDisabled = 'disabled="disabled"';
				echo '<td><a href="index.php?option=com_sinav&view=sinav_sonucu_gor&sinavId='.$satir['M_SINAV_ID'].'">Sonuçlara Bak</a></td>';
				echo '<td><input value="1" name="sertifika_'.$satir['M_SINAV_ID'].'" type="checkbox" />'.JText::_('SERTIFIKA_BASVURUSU_YAPILMIS').'</td>';
			}
			else if(($satir['BASARILI_ADAY'] == BASARILI_ADAY_EKLENDI) && $iskomite == 0){
				$checkBoxDisabled = 'disabled="disabled"';
				echo '<td><a href="index.php?option=com_sinav&view=sinav_sonucu_gor&sinavId='.$satir['M_SINAV_ID'].'">Sonuçlara Bak</a></td>';
				echo '<td><input value="1" name="sertifika_'.$satir['M_SINAV_ID'].'" type="checkbox" />'.JText::_('SERTIFIKA_BASVURUSU_YAPILMAMIS').'</td>';
			}
			else if(($satir['BASARILI_ADAY'] == BASARILI_ADAY_EKLENMEDI) && $iskomite == 0){
				$checkBoxDisabled = 'disabled="disabled"';
				echo '<td><a href="index.php?option=com_sinav&task=sinavSonucuGir&sinavId='.$satir['M_SINAV_ID'].'">Sonuç Gir</a></td>';
				echo '<td><input value="1" name="sertifika_'.$satir['M_SINAV_ID'].'" type="checkbox" />'.JText::_('SERTIFIKA_BASVURUSU_YAPILMAMIS').'</td>';
			}
			else if($satir['BASARILI_ADAY'] == BASARILI_ADAY_EKLENMEDI && $iskomite == 1){
				$checkBoxDisabled = 'disabled="disabled"';
				echo '<td>'.JText::_('SINAV_SONUC_GIRILMEMIS').'</td>';
				echo '<td><input type="button" onclick="DurumDegistir('.$satir['M_SINAV_ID'].')" value="Yetki Ver"/></td>';
				echo '<td>'.JText::_('SERTIFIKA_BASVURUSU_YAPILMAMIS').'</td>';
			}
			else if($satir['BASARILI_ADAY'] == BASARILI_ADAY_EKLENDI && $iskomite == 1){
				$checkBoxDisabled = 'disabled="disabled"';
				echo '<td><a href="index.php?option=com_sinav&view=sinav_sonucu_gor&sinavId='.$satir['M_SINAV_ID'].'">Sonuçlara Bak</a></td>';
				echo '<td><input type="button" onclick="DurumDegistir('.$satir['M_SINAV_ID'].')" value="Yetki Ver"/></td>';
				echo '<td>'.JText::_('SERTIFIKA_BASVURUSU_YAPILMAMIS').'</td>';
			}
			else if($satir['BASARILI_ADAY'] == SERTIFIKA_BASVURULDU && $iskomite == 1){
				$checkBoxDisabled = 'disabled="disabled"';
				echo '<td><a href="index.php?option=com_sinav&view=sinav_sonucu_gor&sinavId='.$satir['M_SINAV_ID'].'">Sonuçlara Bak</a></td>';
				echo '<td><input type="button" onclick="DurumDegistir('.$satir['M_SINAV_ID'].')" value="Yetki Ver"/></td>';
				echo '<td>'.JText::_('SERTIFIKA_BASVURUSU_YAPILMIS').'</td>';
			}
			else {
				if($satir['BASARILI_ADAY'] == BASARILI_ADAY_EKLENMEDI){
					$checkBoxDisabled = 'disabled="disabled"';
					if(!$iskomite)
						echo '<td><a href="index.php?option=com_sinav&task=sinavSonucuGir&sinavId='.$satir['M_SINAV_ID'].'">Sonuç Gir</a></td>';
					else
						echo '<td>'.JText::_('SINAV_SONUC_GIRILMEMIS').'</td>';
				}
				
				else{// BASARILI_ADAY_EKLENDI
					$checkBoxDisabled = '';
					//echo '<td>'.JText::_('SINAV_SONUC_GIRILMIS').'</td>';
					echo '<td><a href="index.php?option=com_sinav&view=sinav_sonucu_gor&sinavId='.$satir['M_SINAV_ID'].'">Sonuçlara Bak</a></td>';
				}
				if(!$iskomite)
					echo '<td><input '.$checkBoxDisabled.' value="1" name="sertifika_'.$satir['M_SINAV_ID'].'" type="checkbox" /></td>';
				
				else
					echo '<td>'.JText::_('SERTIFIKA_BASVURUSU_YAPILMAMIS').'</td>';
			}
			echo '</tr>';
			$rowCount++;
		}
	?>
	</tbody>
</table>
<?php if(!$iskomite){?>
<div style="float: right; margin-top:4px">
<div id="revizyonlarPopupDiv" style="padding:10px; width:300px; height:250px; background-color:white; display:none;" ></div>
<input type="submit" value=" Sertifika için Başvur">
</div>
<div style="clear: right"></div>
<?php }?>
</form>
</div>
<?php if($iskomite){
echo '<a href="index.php?option=com_kurulus_ara&gorev=kurulus_adi&kurulus_adi='. $aramaSozcugu.'">Geri</a>';
}
?>

<?php
}
?>
<script type="text/javascript">
var kackac;
jQuery('.birimler').live('click',function(){
	jQuery.blockUI({ message: '<h1>Lütfen Bekleyin!</h1>',
		css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
    } }); 
	var yetId = jQuery(this).attr('id');
	var birim = jQuery(this).find('input[type="hidden"]').val();//jQuery('.'+yetId)
	var sendData = 'yetId=' + yetId + '&altbirim='+birim;
	var url = 'index.php?option=com_sinav&task=SinavSecBirimler&format=raw';
    	jQuery.ajax({
    		  url: url,
    		  data: sendData,
    		  type: "POST",
    		  dataType: 'json',
    		  success: function(data) {
    			  if(data['success']){
    				  BirimlerGelen(data['array']['kapsamlar'], data['array']['sekiller']);
     			  }else{
    				  alert("Hata oluştu");
    			  }
    		  }
    	});
    	
});

function BirimlerGelen(altbirimler, sekiller){
	kackac = '';
	var uzunluk = altbirimler.length;
	for(var pp=0; pp < uzunluk; pp++){
	if(sekiller[0] == null){
		altbirim = new Array(uzunluk);
		for(var jj = 0; jj<uzunluk; jj++){
			altbirim[jj] = new Array(4);
			}
			for(var i=0; i < uzunluk; i++){
						altbirim[i][0] = altbirimler[i][0]["BIRIM_ADI"];
						altbirim[i][1] = altbirimler[i][0]["BIRIM_KODU"]+altbirimler[pp][0]["OLC_DEG_HARF"]+altbirimler[pp][0]["OLC_DEG_NUMARA"];
						altbirim[i][2] = altbirimler[i][0]["BIRIM_ID"]+'_'+altbirimler[pp][0]["OLC_DEG_HARF"]+altbirimler[pp][0]["OLC_DEG_NUMARA"];
						altbirim[i][3] = altbirimler[i][0]["ID"];
			}
		}
	else{
		altbirim = new Array(uzunluk);
		for(var jj = 0; jj<uzunluk; jj++){
			altbirim[jj] = new Array(4);
			}
			for(var i=0; i < uzunluk; i++){
						altbirim[i][0] = altbirimler[i][0]["YETERLILIK_ALT_BIRIM_ADI"];
						if(sekiller[i] == 0){
							altbirim[i][1] = altbirimler[i][0]["YETERLILIK_ALT_BIRIM_NO"]+'/T1';
							altbirim[i][2] = altbirimler[i][0]['YETERLILIK_ALT_BIRIM_ID']+'_0';
							altbirim[i][3] = altbirimler[i][0]['YETERLILIK_ALT_BIRIM_ID']+'_0';
						}
						else if(sekiller[i] == 1){
							altbirim[i][1] = altbirimler[i][0]["YETERLILIK_ALT_BIRIM_NO"]+'/P1';
							altbirim[i][2] = altbirimler[i][0]['YETERLILIK_ALT_BIRIM_ID']+'_1';
							altbirim[i][3] = altbirimler[i][0]['YETERLILIK_ALT_BIRIM_ID']+'_1';
						}
						
			}
		}	
    		
	}
    				
    				for(var jj = 0; jj < altbirim.length; jj++){
    					if(altbirim[jj][2] != undefined){
    						//kackac += '<span><p>'+altbirim[jj][3]+'	-	'+altbirim[jj][0]+'	('+altbirim[jj][1]+')</p></span><br/>';
    						kackac += '<span><p>'+altbirim[jj][0]+'	('+altbirim[jj][1]+')</p></span><br/>';
    					}
    				}
    				
var altbirimdiv;
var altbirimdiv = '<div class="popupsinavlar" style="padding:10px; width:400px; height:450px; background-color:white; display:none; overflow:auto;">'+kackac+'</div>';
jQuery('#revizyonlarPopupDiv').html(altbirimdiv);
jQuery('.popupsinavlar').lightbox_me({
   centered: true, 
});
kackac='';
jQuery.unblockUI({});
}

function DurumDegistir(sinav){
	var sendData = 'sinav=' + sinav;
	jQuery.ajax({
		  url: 'index.php?option=com_sinav&task=SonucGuncelle&format=raw',
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
				  alert("İşlem Başarılı");
			  }else{
				  alert("Hata oluştu");
			  }
		  }
	});
}

</script>
