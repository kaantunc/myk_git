<?php
$kurulus = $this->kurulus_bilgi;
$deger = $this->deger[0];
$degerYets = $this->deger[1];
?>
<div class="anaDiv text-center">
	<?php echo '<h2 class="font20 fontBold"><u>'.$kurulus['KURULUS_ADI'].'</u></h2>';?>
</div>
<?php echo $this->sayfaLink;?>
<table id="degerlendiriciListesiGrid" class="display compact" style="text-align:center;margin-bottom:10px; margin-top:20px; width:100%" border="1">
	<thead style="background-color:#71CEED">
		<tr>
			<th width="10%">Kimlik No.</th>
			<th width="15%">Ad</th>
			<th width="15%">Soyad</th>
			<th width="10%">Kişisel Beyan</th>
			<th width="10%">Cv</th>
			<th width="30%">Yeterlilik</th>
			<th width="10%">Eklenme Tarihi</th>
			<th width="10%">Onay Tarihi</th>
			<th width="10%">Aktif</th>
			<th width="10%">Durumu</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$say = 1;
	$bgcolor = 'bgcolor="#efefef"';
	foreach($deger as $row){
		$degerCount = count($degerYets[$row['TC_KIMLIK']]);
		
		if($say%2 == 0){
			echo '<tr '.$bgcolor.'>';
		}else{
			echo '<tr>';
		}
		
		echo '<td rowspan="'.$degerCount.'">'.$row['TC_KIMLIK'].'</td>';
		echo '<td rowspan="'.$degerCount.'">'.$row['ADI'].'</td>';
		echo '<td rowspan="'.$degerCount.'">'.$row['SOYADI'].'</td>';
		if(!empty($row['BEYAN'])){
			echo '<td rowspan="'.$degerCount.'" ><a href="index.php?dl='.$row['BEYAN'].'"><img alt="" src="images/pdf.png" width="50" height="50"></a></td>';
		}else{
			echo '<td rowspan="'.$degerCount.'" >Beyan Belirtilmemiş</td>';
		}
		
		if(!empty($row['CV'])){
			echo '<td rowspan="'.$degerCount.'" ><a href="index.php?dl='.$row['CV'].'"><img alt="" src="images/pdf.png" width="50" height="50"></a></td>';
		}else{
			echo '<td rowspan="'.$degerCount.'" >Cv Belirtilmemiş</td>';
		}
		
		$yetSay = 0;
		foreach($degerYets[$row['TC_KIMLIK']] as $cow) {
			if ($cow['ONAY_BEKLEYEN_DGRLNDRC'] != "-1") {
			if ($yetSay == 0) {
				echo '<td><a href="javascript:void(0)" tcno="' . $row['TC_KIMLIK'] . '" yetid="' . $cow['YETERLILIK_ID'] . '" class="yetdetay"/>' . trim($cow['YETERLILIK_KODU']) . '/' . $cow['REVIZYON'] . ' ' . $cow['YETERLILIK_ADI'] . '</a></td>';

			} else {
				if (($yetSay + $say) % 2 == 0) {
					echo '<tr ' . $bgcolor . '>';
				} else {
					echo '<tr>';
				}

				echo '<td><a href="javascript:void(0)" tcno="' . $row['TC_KIMLIK'] . '" yetid="' . $cow['YETERLILIK_ID'] . '" class="yetdetay"/>' . trim($cow['YETERLILIK_KODU']) . '/' . $cow['REVIZYON'] . ' ' . $cow['YETERLILIK_ADI'] . '</a></td>';

			}
			echo '<td align="center">' . $cow['OLUSTURMA_TARIHI'] . '</td>';
			echo '<td align="center">' . ($cow['ONAY_TARIHI'] == "" ? "-" : $cow['ONAY_TARIHI']) . '</td>';
			if ($cow['ETKIN'] == 1) {
				echo '<td align="center"><button style="background-color:green;color:white;" type="button" title="Etkin">Aktif</button></td>';
			} else {
				echo '<td align="center"><button style="background-color:red;color:white;" type="button" title="Etkisiz">Pasif</button></td>';
			}

			if ($cow['ONAY_BEKLEYEN_DGRLNDRC'] == "" || $cow['ONAY_BEKLEYEN_DGRLNDRC'] == "0") {
				if ($this->canEdit) {
					echo '<td colspan="2" align="center"><button style="background-color:blue;color:white;" class="submituser" type="button" title="Onayla/Reddet" tcid="' . $row['TC_KIMLIK'] . '" yetid="' . $cow['YETERLILIK_ID'] . '">Onayla/Reddet</button></td>';
				} else {
					echo '<td colspan="2" align="center"><button style="background-color:blue;color:white;" onclick="alert(\'İlgili değerlendirici dosya sorumlunuzda onay beklemektedir.\')" type="button" title="Onay Bekliyor">Onay Bekliyor</button></td>';
				}
			} else {
				if ($this->canEdit) {
					echo '<td colspan="2" align="center"><button style="background-color:green;color:white;" class="canceluserforyeterlilik" type="button" title="Onaylandı" tcid="' . $row['TC_KIMLIK'] . '" yetid="' . $cow['YETERLILIK_ID'] . '">Onaylandı</button></td>';
				} else {
					echo '<td colspan="2" align="center"><button style="background-color:green;color:white;" type="button" title="Onaylandı" tcid="' . $row['TC_KIMLIK'] . '" yetid="' . $cow['YETERLILIK_ID'] . '">Onaylandı</button></td>';
				}
			}
				}
							echo '</tr>';
			$yetSay++;

			}
		
		$say++;
	}
	?>
	</tbody>
</table>
<div id="loaderGif" style=" min-width: 10px; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<input type="hidden" id="tc" value="">
	<input type="hidden" id="yetid" value="">
    <table id="changeddatas">
    	<tr>
    		<td><input type="hidden" name="willconfirmeduser" id="willconfirmeduser"/>Adı :</td>
    		<td></td>
    	</tr>
    	<tr>
    		<td>Soyadı :</td>
    		<td></td>
    	</tr>
    	<tr>
    		<td>Beyan</td>
    		<td></td>
    	</tr>
    	<tr>
    		<td>Cv</td>
    		<td></td>
    	</tr>
		<tr>
			<td>Açıklama</td>
			<td><textarea id="degerlendiriciaciklama"></textarea></td>
		</tr>
    	<tr>
    		<td colspan="2">
	  			<div style="float:right; padding:10px;">
		    		<button value="Onayla" id="submituserforyeterlilik" style="background-color:grey;color:white;">Onayla</button>
		    		<button value="Reddet" id="reduserforyeterlilik" style="background-color:grey;color:white;">Reddet</button>
		    		<button value="İptal" id="canceluser" style="background-color:grey;color:white;">İptal</button>
	  			</div>
  			</td>
    	</tr>
    	<tr>
    		<td colspan="2"><em style="color:red;">Not: Parantez içerisindeki ifadeler son güncelleme esnasında yapılan değişikliklerdir.</em></td>
    	</tr>
    </table>
</div>
<div id="degelerdiriciOlcutKarsilama" style="width: 35%; min-height:100px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
	<form action="index.php?option=com_belgelendirme&task=degelerdiriciOlcutKarsilamaKaydet"  method="POST" id="degelerdiriciOlcutKarsilamaForm">
	<h2><u>Ölçüt Karşılama Formu</u></h2><br>
		<b>Değerlendirici Ölçütleri</b><br/>
		<textarea rows="6" cols="70" name="degerlendirici_olcutleri"></textarea><br/><br/>
		<b>Ölçütlerin Karşılandığına Dair Açıklama</b>
		<textarea rows="6" cols="70" name="olcut_karsilama_aciklama"></textarea><br/>
	</form>
</div>
<?php echo $this->geriLink;?>
<script type="text/javascript">

jQuery(document).ready(function(){
// 	jQuery('#degerlendiriciListesiGrid').dataTable({
// 		"aaSorting": [[ 2, "desc" ]],
// 		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
// 		"bInfo": true,
// 		"bPaginate": true,
// 		"bFilter": true,
// 		"sPaginationType": "full_numbers",
// 		"oLanguage": {
// 			"sLengthMenu": "# _MENU_ öğe göster",
//			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
// 			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ öğe)",
// 			"sInfoEmpty": "0 - 0 öğeden 0'ı gösteriliyor.",
// 			"sSearch": "Ara",
// 			"oPaginate": {
//				"sFirst":    "<?php echo JText::_("FIRST");?>",
// 				"sPrevious": "Önceki",
// 				"sNext":     "Sonraki",
//				"sLast":     "<?php echo JText::_("LAST");?>"
// 			}
// 		}
// 		});	

	jQuery(".submituser").click(function(){
		jQuery.blockUI();
		jQuery('#loaderGif #tc').val(jQuery(this).attr('tcid'));
		jQuery('#loaderGif #yetid').val(jQuery(this).attr('yetid'));
		jQuery.ajax({
			asycn:false,
			type:'POST',
			dataType: "json",
			url:"index.php?option=com_profile&task=degerlendiriciGetDatas&format=raw",
			data:'tcno='+jQuery(this).attr('tcid')+'&yetid='+jQuery(this).attr('yetid'),
			success:function(data){
				jQuery.each(data, function( index2, value2 ) { 
						 if(jQuery.isPlainObject(value2['ADI'])){
							 jQuery("#changeddatas tr:eq(0) td:eq(1)").html(value2['ADI']['NEWVALUE']+"<em style='color:red;'>("+value2['ADI']['OLDVALUE']+")</em>");
					     }else{ 
					     	jQuery("#changeddatas tr:eq(0) td:eq(1)").html(value2['ADI']);
						 }
						 
						 if(jQuery.isPlainObject(value2['SOYADI'])){
							 jQuery("#changeddatas tr:eq(1) td:eq(1)").html(value2['SOYADI']['NEWVALUE']+"<em style='color:red;'>("+value2['SOYADI']['OLDVALUE']+")</em>");
					     }else{ 
					     	jQuery("#changeddatas tr:eq(1) td:eq(1)").html(value2['SOYADI']);
						 }

						 if(jQuery.isPlainObject(value2['BEYAN'])){
							 jQuery("#changeddatas tr:eq(2) td:eq(1)").html(value2['BEYAN']['NEWVALUE']+"<em style='color:red;'>("+value2['BEYAN']['OLDVALUE']+")</em>");
					     }else{ 
					     	jQuery("#changeddatas tr:eq(2) td:eq(1)").html(value2['BEYAN']);
						 }
						 
						 if(jQuery.isPlainObject(value2['CV'])){
							 jQuery("#changeddatas tr:eq(3) td:eq(1)").html(value2['CV']['NEWVALUE']+"<em style='color:red;'>("+value2['CV']['OLDVALUE']+")</em>");
					     }else{ 
					     	jQuery("#changeddatas tr:eq(3) td:eq(1)").html(value2['CV']);
						 }
						 
						 jQuery("#changeddatas #willconfirmeduser").val(value2['TC_KIMLIK']);
				});
				jQuery.unblockUI();
				jQuery('#loaderGif').lightbox_me({
					centered: true,
			        closeClick:false,
			        closeEsc:false  
		        });
			}
		});
	
	});

	jQuery("#submituserforyeterlilik").click(function(){
		if (confirm("İlgili yeterlilik için aktif değerlendirici onaylanacak emin misiniz!") == true) {
			submitOrCancelUserForYeterlilik(jQuery('#loaderGif #tc').val(),jQuery('#loaderGif #yetid').val(),"1",jQuery('#loaderGif #degerlendiriciaciklama').val());
		}
	});
	jQuery(".canceluserforyeterlilik").click(function(){
		if (confirm("İlgili yeterlilik için aktif değerlendirici onayı iptal edilecek emin misiniz!") == true) {
			submitOrCancelUserForYeterlilik(jQuery(this).attr('tcid'),jQuery(this).attr('yetid'),"0", '');
		}
	});
	jQuery("#reduserforyeterlilik").click(function(){
		if (confirm("İlgili yeterlilik için aktif değerlendirici reddedilecek emin misiniz!") == true) {
			submitOrCancelUserForYeterlilik(jQuery('#loaderGif #tc').val(),jQuery('#loaderGif #yetid').val(),"-1",jQuery('#loaderGif #degerlendiriciaciklama').val());
		}
	});
//	jQuery("#submitusererror").click(function(){
//		alert("İlgili değerlendirici dosya sorumlunuzda onay beklemektedir.");
//		return false;
//	});
	jQuery("#confirmuser").click(function(){
		submitOrCancelUser(jQuery("#changeddatas #willconfirmeduser").val(),"1");
	});
	jQuery("#declineuser").click(function(){
		submitOrCancelUser(jQuery("#changeddatas #willconfirmeduser").val(),"0");
	});
	jQuery("#canceluser").click(function(){
		jQuery('#loaderGif').trigger('close');
	});
	jQuery(".cancelconfirmeduser").click(function(){
		if (confirm("İlgili değerlendirici onayı iptal edilecek emin misiniz!") == true) {
			submitOrCancelUser(jQuery(this).attr('tcid'),"0");
		}
	});

	jQuery(".yetdetay").click(function(){
		yetid = jQuery(this).attr('yetid');
		tcno = jQuery(this).attr('tcno');
		jQuery.ajax({
			asycn:false,
			type:'POST',
			dataType: "json",
			url:"index.php?option=com_belgelendirme&task=degerlendiriciOlcutKarsilamaDetay&format=raw",
			data:'yetid='+yetid+'&tcno='+tcno,
			success:function(data){
				if(data.STATUS == "1"){
					jQuery("textarea[name=degerlendirici_olcutleri]").html(data.DATA.DEGERLENDIRICI_OLCUT);	
					jQuery("textarea[name=olcut_karsilama_aciklama]").html(data.DATA.OLCUT_KARSILAMA_ACIKLAMA);					
					jQuery('#degelerdiriciOlcutKarsilama').lightbox_me({
						centered: true
			        });
				}else{
					alert("Teknik bir hata oluştu.Lütfen daha sonra tekrar deneyiniz!");
				}
			}
		 });
	});
});

function submitOrCancelUser(tcno,status){
	jQuery.ajax({
		asycn:false,
		type:'POST',
		dataType: "json",
		url:"index.php?option=com_profile&task=degerlendiriciSubmitOrCancel&format=raw",
		data:'tcno='+tcno+'&durum='+status,
		success:function(data){
			if(data.STATUS && data.STATUS != ""){
				alert(data.RESULT);
				window.location.reload();
			}else{
				alert("Onay işleminde hata oluştu");
			}
		}
	 });
}

function submitOrCancelUserForYeterlilik(tcno,yetid,status,aciklama){
	jQuery.ajax({
		asycn:false,
		type:'POST',
		dataType: "json",
		url:"index.php?option=com_profile&task=degerlendiriciSubmitForYeterlilik&format=raw",
		data:'tcno='+tcno+'&yetid='+yetid+'&durum='+status+'&aciklama='+aciklama,
		success:function(data){
			if(data.STATUS && data.STATUS != ""){
				alert(data.RESULT);
				window.location.reload();
			}else{
				alert("Onay işleminde hata oluştu");
			}
		}});
}
</script>