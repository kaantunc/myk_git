<?php
echo $this->sayfaLink;

$seciliDenetim = $this->seciliDenetim;
$seciliDenetiminDenetimEkibi = $this->seciliDenetiminDenetimEkibi;

if( $this->seciliDenetim != null)
{
	$seciliDenetim = $this->seciliDenetim;
	$denetim_id = $_REQUEST['denetim_id'];
}
else
{
	global $mainframe;
	$mainframe->redirect('index.php?option=com_denetim&layout=denetim_listele', "Böyle bir denetim kayitli değil");
}

$uzmanDis = $this->uzmanDis;

$pm_roller = $this->ekipRolleri;
for($i=0; $i<count($pm_roller); $i++)
	$rollerOption .= '<option value="'.$pm_roller[$i]['ROL_ID'].'">'.$pm_roller[$i]['ROL_ADI'].'</option>';

?>

   <script src="includes/js/smartspinner/smartspinner.js" type="text/javascript"></script>
    <link href="includes/js/smartspinner/smartspinner.css" type="text/css" rel="stylesheet"/>
 <style>
table thead tr td
{
font-weight: bold;
}
 </style>   
   
<form method="POST" id="ekipKaydetmeFormu"
	action="index.php?option=com_denetim&task=ekip_kaydet&denetim_id=<?php echo $denetim_id; ?>">
	<br> 
	
	<h4>Denetim Başlangıç Tarihi: </h4>
	<input type="text" class="datepicker" id="denetimTarihi_Baslangic" name="denetimTarihi_Baslangic" value="<?php echo str_replace('/','.', $seciliDenetim['DENETIM_TARIHI_BASLANGIC']); ?>"> 
	<br> 
	<h4>Denetim Bitiş Tarihi: </h4>
	<input type="text" class="datepicker" id="denetimTarihi_Bitis" name="denetimTarihi_Bitis" value="<?php echo str_replace('/','.', $seciliDenetim['DENETIM_TARIHI_BITIS']); ?>"> 
	<br> 
	<h4>Denetim Suresi: </h4>
	<input type="text" class="denetimSuresiSmartspinner smartspinner" id="denetimSuresiSmartspinner" name="denetimTarihi_Sure"> gün<br><font color="AEAEDE">(Yarım gün eklemek için klavyede aşağı ve yukarı ok tuşlarını kullanabilirsiniz)</font>
	<br> 
	<h4>Denetim Gündemi: </h4>
	<textarea style="width:300px;" name="denetimGundemi"><?php echo $seciliDenetim['DENETIM_GUNDEMI']; ?></textarea>
	<br> 
	<br> 
	<h4>Denetim	Ücreti: </h4> 
	<input type="text" id="denetimUcreti" name="denetimUcreti" class="numberInput"
		value="<?php echo $seciliDenetim['DENETIM_UCRETI']; ?>"> <br> <br> 
		
<h4>Denetim Ekibi:</h4>
<button type="button" id="uzmanHavuzuTogglerButton" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Yeni Kişi Ekle</button>
	<div id="uzmanHavuzuAcilirDiv"
		style="display: none; height:320px; overflow:auto; border: 1px solid #AEAEAE;">
		<table width="100%" style="float:left;" id="uzmanHavuzuTable">
			<thead>
				<tr><td>#</td><td>AD</td><td>SOYAD</td><td>KURUM</td><td>ÜNVAN</td><td>CALISTIĞI GÜN</td></tr>
			</thead>
			<tbody>
				<?php 
				$uzmanlar = $this->onayliUzmanlar_BuDenetimdekiCalismalariHaric;
				for($i=0; $i<count($uzmanlar); $i++)
				{
					echo '<tr>';
					echo '<td><input type="checkbox"  class="tumUzmanlarCheckbox"  value="'.$uzmanlar[$i]['USER_ID'].'"/></td>';
					echo '<td>'.$uzmanlar[$i]['AD'].'</td>';
					echo '<td>'.$uzmanlar[$i]['SOYAD'].'</td>';
					echo '<td>'.$uzmanlar[$i]['KURUM'].'</td>';
					echo '<td>'.$uzmanlar[$i]['KURUM_UNVANI'].'</td>';
					echo '<td>'.(($uzmanlar[$i]['CALISTIGI_GUN']!='') ? $uzmanlar[$i]['CALISTIGI_GUN']: '0').'</td>';
					echo '</tr>';
				}

				?>
			</tbody>
		</table>

		<a style="width:100%; float:left;" id="uzmaniEkleButton"><button type="button">Uzmanı Ekle</button></a>
		
	</div>


<br><br>
	<div id="kayitliUzmanlarDiv"  style="width:100%; float:left;border:#CDCDCD solid 2px;padding:2px;overflow:auto;">
		<table style="width:100%; float:left;" id="kayitliUzmanlarTable">
			<thead>
				<tr>
					<td style="display:none;">#</td>
					<td>AD</td>
					<td>SOYAD</td>
					<td>KURUM</td>
					<td>ÜNVAN</td>
					<td>ROLÜ</td>
					<td>ÇALIŞMA BAŞLANGIÇ TARİHİ</td>
					<td>ÇALIŞMA BİTİŞ TARİHİ</td>
					<td>ÇALIŞACAĞI GÜN SAYISI</td>
					<td>SİL</td>
				</tr>
			</thead>
			<tbody>
				
				<?php 
				$uzmanlar = $this->seciliDenetiminDenetimEkibi;
				for($i=0; $i<count($uzmanlar); $i++)
				{
					echo '<tr id="'.$uzmanlar[$i]['CALISMA_SURESI_ID'].'">';
					echo '<td style="display:none;"><input type="checkbox" class="kayitliUzmanlarCheckbox" value="'.$uzmanlar[$i]['USER_ID'].'"/></td>';
					echo '<td>'.$uzmanlar[$i]['AD'].'</td>';
					echo '<td>'.$uzmanlar[$i]['SOYAD'].'</td>';
					echo '<td>'.$uzmanlar[$i]['KURUM'].'</td>';
					echo '<td>'.$uzmanlar[$i]['KURUM_UNVANI'].'</td>';
					
					
					echo '<td><select name="ekipRolu[]" id="ekipRolu-'.$i.'">'.$rollerOption.'</select></td>';
					
					
					echo '<td><input type="text" class="datepicker" name="ekipCalismaTarihleri[]" value="'.str_replace(array("/"), array("."), $uzmanlar[$i]['BASLANGIC_TARIHI']).'"></td>';
					echo '<td><input type="text" class="datepicker" name="ekipCalismaTarihleri_Bitis[]" value="'.str_replace(array("/"), array("."), $uzmanlar[$i]['BITIS_TARIHI']).'"></td>';
						
					
					echo '<td><input type="text" class="ekipSmartspinner ekipID-'.$uzmanlar[$i]['USER_ID'].' smartspinner" id="denetimSuresiSmartspinner-'.$uzmanlar[$i]['USER_ID'].'" name="denetimTarihi_Sure"> gün';
					
					$scriptText = '<script>jQuery(jQuery(".ekipSmartspinner")['.$i.']).spinit({initValue:'; 
						if($uzmanlar[$i]['GOREVLENDIRILDIGI_GUN_SAYISI']!='') 
							$scriptText .= str_replace(array(","), array("."), $uzmanlar[$i]['GOREVLENDIRILDIGI_GUN_SAYISI']); 
						else $scriptText .= 0; 
					$scriptText .= ',min:0.5,max:'.(UZMAN_MAX_ISGUNU-str_replace(array(","), array("."), $uzmanlar[$i]['CALISTIGI_GUN'])).',stepInc:0.5,pageInc:0.5, height: 20 });</script>';
					echo $scriptText;
					
					echo '</td>';
					
					
					echo '<td><input type="button" class="denetimEkibindenKaldirButton btn btn-xs btn-danger" value="SİL"></td>';
						
					echo '</tr>';
				}

				?>
				
			</tbody>
		</table>
	</div>
	
<br><br><br><br><br><br><br><br>
<div id="KayitliDis">
<h4>Uzman Dışındaki Ekip: </h4>
<button type="button" id="DisEkle" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Yeni Kişi Ekle</button><br><br>
	
	<table id="uzmanDis" style="float:left;width:100%;">
		<thead>
			<tr style="text-align:center">
				<td width='10%'>AD</td>
				<td width='15%'>SOYAD</td>
				<td width='20%'>KURUM</td>
				<td width='10%'>ÜNVAN</td>
				<td width='10%'>ROLÜ</td>
				<td width='10%'>ÇALIŞMA BAŞLANGIÇ TARİHİ</td>
				<td width='10%'>ÇALIŞMA BİTİŞ TARİHİ</td>
				<td width='5%'>ÇALIŞACAĞI GÜN SAYISI</td>
				<td width='20%'>İŞLEM</td>
			</tr>
		</thead>
		<tbody id="Distbody">
		<?php if(count($uzmanDis)>0){
			foreach ($uzmanDis as $cow){
				echo '<tr id="'.$cow['ID'].'" class="odd" style="text-align:center">
						<td>'.$cow['AD'].'</td>
						<td>'.$cow['SOYAD'].'</td>
						<td>'.$cow['KURUM'].'</td>
						<td>'.$cow['UNVAN'].'</td>
						<td>'.$cow['ROL_ADI'].'</td>
						<td>'.$cow['BAS_TARIH'].'</td>
						<td>'.$cow['BIT_TARIH'].'</td>
						<td>'.$cow['GUN'].'</td>
						<td><input type="button" value="Düzenle" id="disDuz" class="btn btn-xs btn-warning"/> | <input class="btn btn-xs btn-danger" type="button" value="Sil" id="disSil"></td>
					</tr>';
			}
		}?>
		</tbody>
	</table>
</div>

	<div style="width:100%; float:left; margin-top:20px"><input value="KAYDET" type="button" id="kaydetButtonu" class="btn btn-sm btn-success"></div>
	<font id="errorDiv" color="red" style="display:none; width:100%; float:left;">Lütfen Gerekli Alanları Doldurunuz</font>

</form>

<div id="yeniDis" style=" width: 400px; height:350px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<h1>Uzman Dışındaki Kişi Ekleme</h1><br>
	Ad:<input type="text" id="DisAd" style="margin-left: 129px"/><br><br>
	Soyad:<input type="text" id="DisSoyad" style="margin-left: 108px"/><br><br>
	Kurum:<input type="text" id="DisKurum" style="margin-left: 106px" size="35"/><br><br>
	Ünvan:<input type="text" id="DisUnvan" style="margin-left: 109px"/><br><br>
	Rolü:<select id="DisRol" style="margin-left: 118px"> <?php echo $rollerOption;?></select><br><br>
	Çalışma Başlangıç Tarihi:<input type="text" id="DisBastar" class="datepicker" style="margin-left: 2px"/><br><br>
	Çalışma Bitiş Tarihi:<input type="text" id="DisBittar" class="datepicker" style="margin-left: 33px"/><br><br>
	Çalışacağı Gün Sayısı:<input type="text" id="DisGun"style="margin-left: 9px"/><br><br>
	<input type="button" id="DisKaydet" value="Kaydet"/>
</div>

<div id="yeniDisUpdate" style=" width: 400px; height:350px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<h1>Uzman Dışındaki Kişi Güncelle</h1><br>
	Ad:<input type="text" id="gunDisAd" style="margin-left: 129px"/><br><br>
	Soyad:<input type="text" id="gunDisSoyad" style="margin-left: 108px"/><br><br>
	Kurum:<input type="text" id="gunDisKurum" style="margin-left: 106px" size="35"/><br><br>
	Ünvan:<input type="text" id="gunDisUnvan" style="margin-left: 109px"/><br><br>
	Rolü:<select id="gunDisRol" style="margin-left: 118px"> <?php echo $rollerOption;?></select><br><br>
	Çalışma Başlangıç Tarihi:<input type="text" id="gunDisBas" class="datepicker" style="margin-left: 2px"/><br><br>
	Çalışma Bitiş Tarihi:<input type="text" id="gunDisBit" class="datepicker" style="margin-left: 33px"/><br><br>
	Çalışacağı Gün Sayısı:<input type="text" id="gunDisGun"style="margin-left: 9px"/><br><br>
	<input type="button" id="DisUpdate" value="Güncelle"/>
	<input type="hidden" id="denetIdUpdate" />
</div>

<script>
//25.09.2013--------------------------------------------------//
jQuery('#DisKaydet').live('click',function(e){
	e.preventDefault();
	var ad = jQuery('#yeniDis #DisAd').val();
	var soyad = jQuery('#yeniDis #DisSoyad').val();
	var kurum = jQuery('#yeniDis #DisKurum').val();
	var unvan = jQuery('#yeniDis #DisUnvan').val();
	var rol = jQuery('#yeniDis #DisRol').val();
	var bastar = jQuery('#yeniDis #DisBastar').val();
	var bittar = jQuery('#yeniDis #DisBittar').val();
	var gun = jQuery('#yeniDis #DisGun').val();
	jQuery.ajax({
		type: 'POST',
		url: 'index.php?option=com_denetim&task=ajaxSaveDisUzman&format=raw',
		data: 'DenetimId='+<?php echo $denetim_id; ?>+'&DisAd='+ad+'&DisSoyad='+soyad+'&DisKurum='+kurum+'&DisUnvan='+unvan+'&DisRol='+rol+'&DisBastar='+bastar+'&DisBittar='+bittar+'&DisGun='+gun,
		success: function(data) {
			var dat = JSON.parse(data);
			var ekle='';
			jQuery.each(dat,function(key,vall){
				ekle = '<tr id="'+vall['ID']+'" class="odd" style="text-align:center">'+
						'<td>'+vall['AD']+'</td>'+
						'<td>'+vall['SOYAD']+'</td>'+
						'<td>'+vall['KURUM']+'</td>'+
						'<td>'+vall['UNVAN']+'</td>'+
						'<td>'+vall['ROL_ADI']+'</td>'+
						'<td>'+vall['BAS_TARIH']+'</td>'+
						'<td>'+vall['BIT_TARIH']+'</td>'+ 
						'<td>'+vall['GUN']+'</td>'+
						'<td><input type="button" value="Düzenle" id="disDuz" class="btn btn-xs btn-warning"/> | <input class="btn btn-xs btn-danger" type="button" value="Sil" id="disSil"></td>'+
						'</tr>';
			});
			jQuery('#Distbody').append(ekle);
			jQuery('#yeniDis #DisAd').val('');
			jQuery('#yeniDis #DisSoyad').val('');
			jQuery('#yeniDis #DisKurum').val('');
			jQuery('#yeniDis #DisUnvan').val('');
			jQuery('#yeniDis #DisRol').val('');
			jQuery('#yeniDis #DisBastar').val('');
			jQuery('#yeniDis #DisBittar').val('');
			jQuery('#yeniDis #DisGun').val('');
			jQuery('#yeniDis').trigger('close');
		}
	});
});

jQuery('#DisEkle').live('click',function(e){
	e.preventDefault();
	jQuery('#yeniDis').lightbox_me({
        centered: true, 
        });
});

jQuery('#Distbody #disSil').live('click',function(e){
	e.preventDefault();
	var iid = jQuery(this).closest('tr').attr('id');
	if(confirm("Silmek istediğinizden emin misiniz?") == true){
		jQuery.ajax({
			type: 'POST',
			url: 'index.php?option=com_denetim&task=ajaxDelDisUzman&format=raw',
			data: 'DenetimId='+<?php echo $denetim_id; ?>+'&DisId='+iid,
			success: function(data) {
				jQuery('#Distbody #'+iid).remove();
			}
		});			
	}
});

jQuery('#Distbody #disDuz').live('click',function(e){
	e.preventDefault();
	var iid = jQuery(this).closest('tr').attr('id');
		jQuery.ajax({
			type: 'POST',
			url: 'index.php?option=com_denetim&task=ajaxGetDisUzman&format=raw',
			data: 'DenetimId='+<?php echo $denetim_id; ?>+'&DisId='+iid,
			success: function(data) {
				var dat = JSON.parse(data);
				jQuery.each(dat,function(key,vall){
					jQuery('#yeniDisUpdate #gunDisAd').val(vall['AD']);
					jQuery('#yeniDisUpdate #gunDisSoyad').val(vall['SOYAD']);
					jQuery('#yeniDisUpdate #gunDisKurum').val(vall['KURUM']);
					jQuery('#yeniDisUpdate #gunDisUnvan').val(vall['UNVAN']);
					jQuery('#yeniDisUpdate #gunDisRol').html('<option value="'+vall['ROL']+'">'+vall['ROL_ADI']+'</option>');
					jQuery('#yeniDisUpdate #gunDisBas').val(vall['BAS_TARIH']);
					jQuery('#yeniDisUpdate #gunDisBit').val(vall['BIT_TARIH']);
					jQuery('#yeniDisUpdate #gunDisGun').val(vall['GUN']);
					jQuery('#yeniDisUpdate #denetIdUpdate').val(vall['ID']);
					jQuery.ajax({
						type: 'POST',
						url: 'index.php?option=com_denetim&task=ajaxGetDisUzmanRols&format=raw',
						data: 'RolId='+vall['ROL'],
						success: function(data1) {
							var dat1 = JSON.parse(data1);
							jQuery.each(dat1,function(key1,vall1){
								jQuery('#yeniDisUpdate #gunDisRol').append('<option value="'+vall1['ROL_ID']+'">'+vall1['ROL_ADI']+'</option>');
						});
					}
				});
				});
				jQuery('#yeniDisUpdate').lightbox_me({
			        centered: true, 
			    });
			}
		});			
});

jQuery('#yeniDisUpdate #DisUpdate').live('click',function(e){
	e.preventDefault();
	var iid = jQuery('#yeniDisUpdate #denetIdUpdate').val();
	var disad = jQuery('#yeniDisUpdate #gunDisAd').val();
	var dissoyad = jQuery('#yeniDisUpdate #gunDisSoyad').val();
	var diskurum = jQuery('#yeniDisUpdate #gunDisKurum').val();
	var disunvan = jQuery('#yeniDisUpdate #gunDisUnvan').val();
	var disrol = jQuery('#yeniDisUpdate #gunDisRol').val();
	var disbas = jQuery('#yeniDisUpdate #gunDisBas').val();
	var disbit = jQuery('#yeniDisUpdate #gunDisBit').val();
	var disgun = jQuery('#yeniDisUpdate #gunDisGun').val();
	jQuery.ajax({
		type: 'POST',
		url: 'index.php?option=com_denetim&task=ajaxUpdateDisUzman&format=raw',
		data: 'DenetimId='+<?php echo $denetim_id; ?>+'&DisId='+iid+'&DisAd='+disad+'&DisSoyad='+dissoyad+'&DisKurum='+diskurum+'&DisUnvan='+disunvan+'&DisRol='+disrol+'&DisBas='+disbas+'&DisBit='+disbit+'&DisGun='+disgun,
		success: function(data) {
			var dat = JSON.parse(data);
			var ekle='';
			jQuery.each(dat,function(key,vall){
				ekle = '<td>'+vall['AD']+'</td>'+
				'<td>'+vall['SOYAD']+'</td>'+
				'<td>'+vall['KURUM']+'</td>'+
				'<td>'+vall['UNVAN']+'</td>'+
				'<td>'+vall['ROL_ADI']+'</td>'+
				'<td>'+vall['BAS_TARIH']+'</td>'+
				'<td>'+vall['BIT_TARIH']+'</td>'+ 
				'<td>'+vall['GUN']+'</td>'+
				'<td><input type="button" value="Düzenle" id="disDuz" class="btn btn-xs btn-warning"/> | <input class="btn btn-xs btn-danger" type="button" value="Sil" id="disSil"></td>';
			});
			jQuery('#Distbody #'+iid).html('');
			jQuery('#Distbody #'+iid).append(ekle);
			jQuery('#yeniDisUpdate').trigger('close');
		}
	});			
});
//-------------------------------------------------//				
jQuery('.denetimEkibindenKaldirButton').live('click', function(e){
	if(confirm('Silmek İstediğinize Emin Misiniz')==true)
	jQuery(this.getParent().getParent()).remove();
	
});

jQuery('#denetimSuresiSmartspinner').spinit({initValue:<?php if($seciliDenetim['DENETIM_SURESI']!='') echo $seciliDenetim['DENETIM_SURESI']; else echo 0; ?>,min:0.5,max:60,stepInc:0.5,pageInc:0.5, height: 20 });

jQuery('.smartspinner').keydown(function(e){
	if((e.keyCode < 48 || e.keyCode > 57) && e.keyCode!=38 && e.keyCode!=40)
		e.preventDefault();
});


jQuery(".numberInput").live("keydown", function(event) {
    // Allow: backspace, delete, tab, escape, and enter
    if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
         // Allow: Ctrl+A
        (event.keyCode == 65 && event.ctrlKey === true) || 
         // Allow: home, end, left, right
        (event.keyCode >= 35 && event.keyCode <= 40)) {

    	if(event.keyCode == 38 && event.currentTarget.value!="")//yukarı
       		event.currentTarget.value = parseInt(event.currentTarget.value)+1;  
    	else if(event.keyCode == 40  && event.currentTarget.value!="")//aşagı
   			event.currentTarget.value = parseInt(event.currentTarget.value)-1;  
    	

             // let it happen, don't do anything
             return;
    }
    else {
        // Ensure that it is a number and stop the keypress
        if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
            event.preventDefault(); 
        } 
        
              
    }
});



var settings = {
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
	    "oLanguage": {
			"sLengthMenu": "<?php echo JText::_("LENGTH_MENU");?>",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "<?php echo JText::_("INFO");?>",
			"sInfoEmpty": "<?php echo JText::_("INFO_EMPTY");?>",
			"sInfoFiltered": "<?php echo JText::_("INFO_FILTERED");?>",
			"sSearch": "<?php echo JText::_("SEARCH");?>",
			"oPaginate": {
				"sFirst":    "<?php echo JText::_("FIRST");?>",
				"sPrevious": "<?php echo JText::_("PREVIOUS");?>",
				"sNext":     "<?php echo JText::_("NEXT");?>",
				"sLast":     "<?php echo JText::_("LAST");?>"
			}
		}
	};
				
jQuery('#kayitliUzmanlarTable').dataTable(settings);
//jQuery('#uzmanHavuzuTable').dataTable(settings);
jQuery('#uzmanDis').dataTable(settings);
jQuery('#uzmanHavuzuTogglerButton').click(function(e){

	if(jQuery(this).children('i').hasClass('fa-plus')){
		jQuery(this).children('i').removeClass('fa-plus');
		jQuery(this).children('i').addClass('fa-minus');
	}else{
		jQuery(this).children('i').removeClass('fa-minus');
		jQuery(this).children('i').addClass('fa-plus');
	}
	jQuery('#uzmanHavuzuAcilirDiv').toggle('slow');
	
});



jQuery('.datepicker').datepicker({
	changeYear: true,
    changeMonth: true
});

jQuery('#uzmaniEkleButton').click(function(e){

	var selectText = '<td><select name="kaydedilecekRoller[]"><?php echo $rollerOption; ?></select></td>';
		
	jQuery('#uzmanHavuzuTable .tumUzmanlarCheckbox').filter(':checked').each(function(e){

		if(jQuery('#kayitliUzmanlarTable tr td.dataTables_empty').length>0)
			jQuery('#kayitliUzmanlarTable tbody tr').remove();
		
		var rowContent = jQuery(this.getParent().getParent()).clone();
		var ekipSmartSpinnerTD = '<td><input type="text" class="ekipSmartspinner ekipID-'+jQuery(this).val()+' smartspinner" id="denetimSuresiSmartspinner-'+jQuery(this).val()+'" maxValue="'+jQuery(jQuery(rowContent)[5]).html()+'" name="denetimTarihi_Sure"> gün</td>';
		var calismaBaslangiciTD = '<td><input type="text" class="datepicker" name="ekipCalismaTarihleri[]"></td>';
		var calismaBitisiTD = '<td><input type="text" class="datepicker" name="ekipCalismaTarihleri_Bitis[]"></td>';
		var silButtonTD = '<td><input type="button" class="denetimEkibindenKaldirButton btn btn-xs btn-danger" value="SİL"></td>';
		jQuery('#uzmanHavuzuTable tbody').append(rowContent);
		
	//	jQuery('#kayitliUzmanlarTable tbody').after('<tr>'+jQuery(ekipSmartSpinnerTDReloaded).html()+'</tr>');
		
		jQuery('#kayitliUzmanlarTable').append(jQuery(this.getParent().getParent()));//clone + append, sonra da aşağıdakileri duzelt

		jQuery(this.getParent()).hide();//hide checkbox td

		var calistigiGunSayisi = jQuery(this.getParent().getParent().getChildren()[5]).html();
		calistigiGunSayisi = calistigiGunSayisi.replace(',','.');
		var calistigiGunSayisiFloat;
		try
		{
			calistigiGunSayisiFloat = parseFloat(calistigiGunSayisi);
		}
		catch(err)
		 {
			calistigiGunSayisiFloat = 0;
		 }
		
		jQuery(this.getParent().getParent().getChildren()[5]).remove();//Çalıştıgı gün td yi sil
		
//		jQuery(this.getParent().getParent()).html(jQuery(this.getParent().getParent()).html()+selectText+ekipSmartSpinnerTD);

		jQuery(this.getParent().getParent()).append(selectText + calismaBaslangiciTD + calismaBitisiTD + ekipSmartSpinnerTD + silButtonTD);

		jQuery(this.getParent().getParent().getChildren()[6].getChildren()[0]).datepicker({});
		jQuery(this.getParent().getParent().getChildren()[7].getChildren()[0]).datepicker({});		
		jQuery(this.getParent().getParent().getChildren()[8].getChildren()[0]).spinit({initValue:0,min:0.5,max:(<?php echo UZMAN_MAX_ISGUNU;?>-calistigiGunSayisiFloat),stepInc:0.5,pageInc:0.5, height: 15 });
		


	});
	jQuery('#uzmanHavuzuTable input').removeAttr('checked');
	
	jQuery('#uzmanHavuzuAcilirDiv').toggle('slow');
	
});


jQuery('#kaydetButtonu').click(function(e){
	//jQuery('#kayitliUzmanlarTable input').attr('name', 'kaydedilecekEkip[]');

	if(inputlarValidMi() == true)
	{
		var adreseEk = '';
		jQuery('#kayitliUzmanlarTable  input[type=checkbox]').each(function (e){
				adreseEk += '&kaydedilecekEkip[]='+jQuery(this).val();
		});
		jQuery('#kayitliUzmanlarTable select').each(function (e){
				adreseEk += '&kaydedilecekRoller[]='+jQuery(this).val();
		});
		jQuery('.ekipSmartspinner').each(function (e){
			adreseEk += '&ekipCalisacakGunleri[]='+jQuery(this).val();
		});
	
		adreseEk += '&denetimSuresi='+jQuery('#denetimSuresiSmartspinner').val();
		
		jQuery('#ekipKaydetmeFormu').attr("action", jQuery('#ekipKaydetmeFormu').attr("action")+adreseEk);
		jQuery('#ekipKaydetmeFormu').submit();
	}
	
});

function addToEkipTable(ekipElemaniAdi, ekipElemaniSoyadi, elemanRolu)
{
	var tableName = "kayitliUzmanlarTable";
	var adInput = '<input class="adTextbox" type="text" value="'+ekipElemaniAdi+'" name="ekipElemaniAdi[]"/>';
	var soyadInput = '<input class="soyadTextbox" type="text" value="'+ekipElemaniSoyadi+'" name="ekipElemaniSoyadi[]"/>';
	var rolSelect = jQuery('<select name="ekipRolu[]"><?php echo $this->rollerSelectOptions; ?></select>');
	
	if(jQuery('.ekipRow').length == 1 && jQuery(jQuery('.ekipRow').children()[1]).children().length == 0)
	{
		jQuery(jQuery('.ekipRow').children()[1]).append(adInput);
		jQuery(jQuery('.ekipRow').children()[2]).append(soyadInput);
		jQuery(jQuery('.ekipRow').children()[3]).append(rolSelect);
	}
	else
	{
		jQuery('#ekipIlkTD').attr("rowspan", parseInt(jQuery('#ekipIlkTD').attr("rowspan"))+1);

		var satir = '<tr class="ekipRow">'
					+'<td>'
						+ adInput
					+'</td>'
					+'<td>'
						+ soyadInput
					+'</td>'
					+'<td>'
						+ jQuery('<div>').append(rolSelect.clone()).html()
					+'</td>'
			+'</tr>';
		jQuery('#innerEkipTable').append(satir);
	}

	jQuery(jQuery(rolSelect).children()[parseInt(elemanRolu)-1]).attr("selected", "selected");
	
}

function ekipRoluSelectiniSec(index, optionValue)
{
	var select = jQuery('select[name="ekipRolu[]"]')[index];
	var options = jQuery('select[name="ekipRolu[]"]')[index].getChildren();
	for(var i=0; i<options.length; i++)
		if(jQuery(options[i]).val()==optionValue)
			jQuery(options[i]).attr('selected', 'selected');
}



function inputlarValidMi()
{
	result = true;
	//text inputs
	jQuery('#denetimTarihi_Baslangic, #denetimTarihi_Bitis, #denetimUcreti, #kayitliUzmanlarTable .datepicker ').each(function(e){

		if(jQuery(this).val()=='')
		{
			result = false;
			jQuery(this).css('border','1px solid red');
			jQuery('#errorDiv').html("Lütfen Gerekli Alanları Doldurunuz");
		}
		else
		{
			jQuery(this).css('border','1px solid #C0C0C0');
		}
	});

	


	jQuery('#kayitliUzmanlarTable  input[type=checkbox]').each(function(e){
		var adaminIDsi = jQuery(this).val();
		var adaminCalisacagiGunlerSpineditleri = jQuery('.ekipID-'+adaminIDsi);
		var maxIsgunu = <?php echo UZMAN_MAX_ISGUNU; ?>;
		var adaminCalismisOlduguGunSayisi = parseFloat(jQuery(jQuery('#uzmanHavuzuTable .tumUzmanlarCheckbox[value='+adaminIDsi+']').parent().parent().children()[5]).html().replace(',','.'));
		var tumDenetcilerCheckbox = jQuery('#uzmanHavuzuTable .tumUzmanlarCheckbox[value='+adaminIDsi+']');

		var currentNumber = adaminCalismisOlduguGunSayisi;
		jQuery(adaminCalisacagiGunlerSpineditleri).each(function(e){
			currentNumber += parseFloat(jQuery(this).val());
		});
		if(currentNumber > maxIsgunu )
		{
			result = false;
			jQuery(adaminCalisacagiGunlerSpineditleri).css('border', '1px solid red');
			jQuery('#errorDiv').html("Maksimum iş günü aşılıyor");
		}
		else
		{
			jQuery(adaminCalisacagiGunlerSpineditleri).css('border','1px solid #C0C0C0');
			jQuery('#errorDiv').hide("slow");
		}
	});
	
	if(result==false)
	{	
		jQuery('#kaydetButtonu').css('border','1px solid red');
		jQuery('#errorDiv').show("slow");
	}
	else
	{
		jQuery('#kaydetButtonu').css('border','1px solid #C0C0C0');
		jQuery('#errorDiv').hide("slow");
	}

	return result;
}





<?php 

$uzmanlar2 = $this->seciliDenetiminDenetimEkibi;
for($i=0; $i<count($uzmanlar2); $i++)
{
	echo ' ekipRoluSelectiniSec('.$i.', '.$uzmanlar2[$i]['PERSONEL_ROLU'].'); ';	
}

?>

</script>
