<?php 
if($_GET['tcg_id']!='')
{	
	$user_id = $_GET['tcg_id'];
	$userDetails = getDetailsOfTCG($user_id);
}
?>
<script src="includes/js/smartspinner/smartspinner.js" type="text/javascript"></script>
    <link href="includes/js/smartspinner/smartspinner.css" type="text/css" rel="stylesheet"/>
  
 <form id="teknikCalismaGrubuForm" method="post" action="index.php?option=com_teknik_calisma&task=teknikCalismaGrubuKaydet">
    
	<input type="hidden" name="userIdToUpdate" value="<?php echo $user_id; ?>">
	<h4 style="padding-bottom: 5px;">TEKNİK ÇALIŞMA GRUBU DETAYLARI</h4>
	<table id="tcgDetaylariTable" style="width: 350px;">
		<tbody>

			<tr>
				<td>Teknik Çalışma Grubu Adı<br> <input type="text"
					name="teknikCalismaGrubuAdi" value="<?php echo $userDetails['name']; ?>"><br>
				</td>
				<td>Kullanıcı Adı<br> <input type="text"
					name="teknikCalismaGrubuKullaniciAdi"  value="<?php echo $userDetails['username']; ?>"><br>
				</td>
			</tr>


			<tr>
				<td>Yetkili Kişi<br> <input type="text"
					name="teknikCalismaGrubuYetkiliKisi" value="<?php echo $userDetails['KURULUS_YETKILISI'];
?>"><br>
				</td>
				<td>Şifre<br> <input type="text" class="gorunurPassword"
					name="teknikCalismaGrubuSifre"><br>
				</td>
			</tr>

			<tr>
				<td>İrtibat Numarası<br> <input type="text"
					name="teknikCalismaGrubuIrtibatNo" value="<?php echo $userDetails['KURULUS_TELEFON']; ?>"><br>
				</td>
				<td>Şifre(Tekrar)<br> <input type="text" class="gorunurPassword"
					name="teknikCalismaGrubuSifreTekrar"><br><font id="passwordErrorDiv"
					style="display: none;" color="red">Şifreler uyuşmuyor</font>
				</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>E-Mail Adresi<br> <input type="text"
					name="teknikCalismaGrubuEmaili"  value="<?php echo $userDetails['email']; ?>"><br>
				</td>
			</tr>




		</tbody>
	</table>

	<br>


<!-- 	<h4 style="padding-bottom: 5px;">TEKNİK UZMANLARI</h4>-->
<!-- 	<table style="width: 100%; float: left;">-->
<!-- 		<tbody> -->
			<?php 

// 			$ss = $this->sektor_sorumlulari;

// 			for($i=0; $i<count($ss); $i++)
// 			{
// 				$tdData .= '<td><input style="margin-right: 3px;" type="checkbox" value="'.$ss[$i]['USER_ID'].'" name="sektorSorumlulari[]" >'.$ss[$i]['AD'].' '.$ss[$i]['SOYAD'].'</td>';
// 				$columns = 5;
// 				if($i % $columns == ($columns-1) || $i==count($ss)-1)
// 				{
// 					echo '<tr>'.$tdData.'</tr>';
// 					$tdData='';
// 				}
// 			}

// 			?>

<!-- 		</tbody> -->
<!-- 	</table> -->

	<br>
	
	
	<input type="button" id="uzmanHavuzuTogglerButton" value="Yeni Kişi Ekle" />
	<div id="uzmanHavuzuAcilirDiv"
		style="display: none; height:320px; overflow:auto; border: 1px solid #AEAEAE;">
		<table width="100%"; style="float:left;" id="uzmanHavuzuTable">
			<thead>
				<tr><td>#</td><td>AD</td><td>SOYAD</td><td>KURUM</td><td>ÜNVAN</td><td>CALISTIĞI GÜN</td></tr>
			</thead>
			<tbody>
				<?php 
				if($_GET['tcg_id']!='')
					$uzmanlar = $this->uzman_havuzu_VeBuTCGDisindakiCalismaSaatleri;
				else
					$uzmanlar = $this->uzman_havuzu;
				
				
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

		<a style="width:100%; float:left;" id="uzmaniEkleButton">Uzmanı Ekle</a>
		
	</div>
	
	
<br><br>
<h4>Teknik Çalışma Grubu Uzmanları:</h4>

	<div id="kayitliUzmanlarDiv">
		<table style="width:100%; float:left;" id="kayitliUzmanlarTable">
			<thead>
				<tr>
					<td style="display:none;">#</td>
					<td>AD</td>
					<td>SOYAD</td>
					<td>KURUM</td>
					<td>ÜNVAN</td>
					<td>ÇALIŞMA BAŞLANGIÇ TARİHİ</td>
					<td>ÇALIŞMA BİTİŞ TARİHİ</td>
					<td>ÇALIŞACAĞI GÜN SAYISI</td>
					<td>SİL</td>
				</tr>
			</thead>
			<tbody>
				
				<?php 
				$uzmanlar = $this->seciliTeknikCalismaninUzmanlari;
				for($i=0; $i<count($uzmanlar); $i++)
				{
					echo '<tr id="'.$uzmanlar[$i]['CALISMA_SURESI_ID'].'">';
					echo '<td style="display:none;"><input type="hidden" name="silinecekCalismaSureleriIDleri[]" value="'.$uzmanlar[$i]['CALISMA_SURESI_ID'].'" ><input type="checkbox" class="kayitliUzmanlarCheckbox" value="'.$uzmanlar[$i]['USER_ID'].'"/></td>';
					echo '<td>'.$uzmanlar[$i]['AD'].'</td>';
					echo '<td>'.$uzmanlar[$i]['SOYAD'].'</td>';
					echo '<td>'.$uzmanlar[$i]['KURUM'].'</td>';
					echo '<td>'.$uzmanlar[$i]['KURUM_UNVANI'].'</td>';
					
					
					echo '<td><input type="text" class="datepicker" name="ekipCalismaTarihleri[]" value="'.str_replace(array("/"), array("."), $uzmanlar[$i]['BASLANGIC_TARIHI']).'"></td>';
					echo '<td><input type="text" class="datepicker" name="ekipCalismaTarihleri_Bitis[]" value="'.str_replace(array("/"), array("."), $uzmanlar[$i]['BITIS_TARIHI']).'"></td>';
						
					
					echo '<td><input type="text" class="ekipSmartspinner ekipID-'.$uzmanlar[$i]['USER_ID'].' smartspinner" id="denetimSuresiSmartspinner-'.$uzmanlar[$i]['USER_ID'].'" name="denetimTarihi_Sure[]"> gün';
					
					$scriptText = '<script>jQuery(jQuery(".ekipSmartspinner")['.$i.']).spinit({initValue:'; 
						if($uzmanlar[$i]['GOREVLENDIRILDIGI_GUN_SAYISI']!='') 
							$scriptText .= str_replace(array(","), array("."), $uzmanlar[$i]['GOREVLENDIRILDIGI_GUN_SAYISI']); 
						else $scriptText .= 0; 
					$scriptText .= ',min:0.5,max:'.(UZMAN_MAX_ISGUNU-str_replace(array(","), array("."), $uzmanlar[$i]['CALISTIGI_GUN'])).',stepInc:0.5,pageInc:0.5, height: 15 });</script>';
					echo $scriptText;
					
					echo '</td>';
					
					
					echo '<td><input type="button" class="denetimEkibindenKaldirButton" value="SİL"></td>';
						
					echo '</tr>';
				}

				?>
				
			</tbody>
		</table>
	</div>
	
	
	
	<input type="button" id="kaydetButtonu" value="Kaydet">
	<font id="errorDiv" color="red" style="display:none;">Lütfen Gerekli Alanları Doldurunuz</font>
	
</form>

<script>

jQuery('#kaydetButtonu').click(function(e){
	//jQuery('#kayitliUzmanlarTable input').attr('name', 'kaydedilecekEkip[]');

	if((inputlarValidMi() && validateThisForm()) == true)
	{
		var adreseEk = '';
		jQuery('#kayitliUzmanlarTable  input[type=checkbox]').each(function (e){
				adreseEk += '&kaydedilecekEkip[]='+jQuery(this).val();
		});
		
		jQuery('.ekipSmartspinner').each(function (e){
			adreseEk += '&ekipCalisacakGunleri[]='+jQuery(this).val();
		});
	
		jQuery('#teknikCalismaGrubuForm').attr("action", jQuery('#teknikCalismaGrubuForm').attr("action")+adreseEk);
		jQuery('#teknikCalismaGrubuForm').submit();
	}
	
});


jQuery('.gorunurPassword').live('keyup', function(e){
	
	var result =  validatePasswords();
		
	if(result==false)
		{
			jQuery('.gorunurPassword').css('border', '1px solid red');
			jQuery('#passwordErrorDiv').html("Şifreler uyuşmuyor");
			jQuery('#passwordErrorDiv').show();
			
		}
	else
		{
			jQuery('.gorunurPassword').css('border', '1px solid #C0C0C0');
			jQuery('#passwordErrorDiv').hide();
			
		}
});

jQuery('.denetimEkibindenKaldirButton').live('click', function(e){
	if(confirm('Silmek İstediğinize Emin Misiniz')==true)
	jQuery(this.getParent().getParent()).remove();
	
});

jQuery('#denetimSuresiSmartspinner').spinit({initValue:<?php if($seciliDenetim['DENETIM_SURESI']!='') echo $seciliDenetim['DENETIM_SURESI']; else echo 0; ?>,min:0.5,max:60,stepInc:0.5,pageInc:0.5, height: 20 });

jQuery('.smartspinner').keydown(function(e){
	if((e.keyCode < 48 || e.keyCode > 57) && e.keyCode!=38 && e.keyCode!=40)
		e.preventDefault();
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
				
//jQuery('#kayitliUzmanlarTable').dataTable(settings);
jQuery('#uzmanHavuzuTable').dataTable(settings);

jQuery('#uzmanHavuzuTogglerButton').click(function(e){

	jQuery('#uzmanHavuzuAcilirDiv').toggle('slow');
	
});


jQuery('#uzmaniEkleButton').click(function(e){

		
	jQuery('#uzmanHavuzuTable .tumUzmanlarCheckbox').filter(':checked').each(function(e){

		if(jQuery('#kayitliUzmanlarTable tr td.dataTables_empty').length>0)
			jQuery('#kayitliUzmanlarTable tbody tr').remove();
		
		var rowContent = jQuery(this.getParent().getParent()).clone();
		var ekipSmartSpinnerTD = '<td><input type="text" class="ekipSmartspinner ekipID-'+jQuery(this).val()+' smartspinner" id="denetimSuresiSmartspinner-'+jQuery(this).val()+'" maxValue="'+jQuery(jQuery(rowContent)[5]).html()+'" name="denetimTarihi_Sure[]"> gün</td>';
		var calismaBaslangiciTD = '<td><input type="text" class="datepicker" name="ekipCalismaTarihleri[]"></td>';
		var calismaBitisiTD = '<td><input type="text" class="datepicker" name="ekipCalismaTarihleri_Bitis[]"></td>';
		var silButtonTD = '<td><input type="button" class="denetimEkibindenKaldirButton" value="SİL"></td>';
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

		jQuery(this.getParent().getParent()).append(calismaBaslangiciTD + calismaBitisiTD + ekipSmartSpinnerTD + silButtonTD);

		jQuery(this.getParent().getParent().getChildren()[5].getChildren()[0]).datepicker({});
		jQuery(this.getParent().getParent().getChildren()[6].getChildren()[0]).datepicker({});
		jQuery(this.getParent().getParent().getChildren()[7].getChildren()[0]).spinit({initValue:0,min:0.5,max:(<?php echo UZMAN_MAX_ISGUNU;?>-calistigiGunSayisiFloat),stepInc:0.5,pageInc:0.5, height: 15 });
		


	});
	jQuery('#uzmanHavuzuTable input').removeAttr('checked');
	
	jQuery('#uzmanHavuzuAcilirDiv').toggle('slow');
	
});

jQuery('.datepicker').datepicker({});

function validateThisForm()
{
	var result = validatePasswords();
	
	return result;
}

function validatePasswords()
{
	var firstValue = jQuery(jQuery('.gorunurPassword')[0]).val();
	result = true;

	jQuery('.gorunurPassword').each(function(e){
		if(jQuery(this).val() != firstValue)
			result = false;
	});
	return result;
}


function inputlarValidMi()
{
	result = true;
	//text inputs
	jQuery('#tcgDetaylariTable input, #kayitliUzmanlarTable  input[type=text]').filter('[class!=gorunurPassword]').each(function(e){

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



</script>

<?php 
function getDetailsOfTCG($user_id)
{
	$sql=mysql_query("SELECT * FROM JOS_USERS where tgUserId=".$user_id);
	$result=mysql_fetch_array($sql);
	
	$dbo = JFactory::getOracleDBO();
	$sql = "SELECT * FROM M_KURULUS	WHERE USER_ID=?";
	$result2 =  $dbo->prep_exec($sql, array($user_id ));
	
	$result['KURULUS_YETKILISI'] = $result2[0]['KURULUS_YETKILISI'];
	$result['KURULUS_TELEFON'] = $result2[0]['KURULUS_TELEFON'];
	
	
	return $result;
}
?> 
