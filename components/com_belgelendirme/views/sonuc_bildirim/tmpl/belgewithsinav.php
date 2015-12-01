<?php
echo $this->sayfaLinkBelge;
$yets = $this->yets;

$yetSelect = '<option value="0">Seçiniz</option>';
foreach ($yets as $row){
	$yetSelect .= '<option value="'.$row['YETERLILIK_ID'].'">'.$row['YETERLILIK_KODU'].' '.$row['YETERLILIK_ADI'].'</option>';
}
?>

<style>
.anaDiv{
width:100%;
margin-bottom:10px;
display: inline-block;
}

.anaSol{
float:left;
width:25%;
}

.anaSag{
float:right;
width:75%;
}
</style>

<div class="anaDiv">
	<div class="anaSol"><h3>Sınav Yapılan Yeterlilik</h3></div>
	<div class="anaSag"><select id="yetSec"><?php echo $yetSelect;?></select></div>
</div>

<div class="anaDiv">
	<table id="sinavTable" style="width:100%; text-align:center; display: none;"  border="1" cellpadding="0" cellspacing="1">
		<thead style="background-color:#71CEED"> 
			<tr>
				<th width="5%">Sınav ID</th>
				<th width="30%">Yeterlilik</th>
				<th width="10%">Sınav Tarihi</th>
				<th width="15%">Sınav Yeri</th>
				<th width="15%">Sınava Giren Aday Sayısı</th>
				<th width="15%">Belge Alan Aday Sayısı</th>
				<th width="15%">Belgeli Adaylar</th>
			</tr>
		</thead>
		<tbody id="sinavTbody">
		</tbody>
	</table>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#yetSec').live('change',function(){
		jQuery('#sinavTable').hide();
		jQuery('#sinavTbody').html('');
		var yet = jQuery(this).val();
		if(yet != 0){
			jQuery.ajax({
				async:false,
				type:'POST',
				url:"index.php?option=com_belgelendirme&task=SinavaGirenVeBasariliAday&format=raw",
				data:'kurulusId=<?php echo $this->kurulusId;?>&yetId='+yet,
				success: function(data){
						var dat = jQuery.parseJSON(data);
						if(dat){
							var sinavGir = 0;
							var sinavBel = 0;
							var table = '';

							jQuery.each(dat,function(key,val){
								table += '<tr>';
								table += '<td>'+val['SINAV_ID']+'</td>';
								table += '<td>'+val['YETERLILIK_KODU']+' '+val['YETERLILIK_ADI']+'</td>';
								table += '<td>'+val['SINAV_TARIHI']+'</td>';
								table += '<td>'+val['SINAV_ILI']+'</td>';
								table += '<td>'+val['SINAVA_GIRMIS']+'</td>';
								if(val['BELGE_ALMIS'].length == 0){
									var belgeAlmis = 0;
								}else{
									var belgeAlmis = val['BELGE_ALMIS'];
								}
								table += '<td>'+belgeAlmis+'</td>';
								if(val['BELGE_ALMIS'].length == 0){
									table += '<td></td>';
								}else{
									table += '<td><a href="index.php?option=com_belgelendirme&view=sonuc_bildirim&layout=belgelilerwithsinav&sinavId='+val['SINAV_ID']+'" target="_blank">Belgeli Adaylar</a></td>';
								}
								table += '</tr>';

								sinavGir = sinavGir + parseInt(val['SINAVA_GIRMIS']);
								sinavBel = sinavBel + parseInt(belgeAlmis);
							});

							table += '<tr>';
							table += '<td colspan="4" align="right">Toplam:</td>';
							table += '<td>'+sinavGir+'</td>';
							table += '<td>'+sinavBel+'</td>';
							table += '<td></td>';
							table += '</tr>';

							jQuery('#sinavTbody').html(table);
							jQuery('#sinavTable').show();
						}
						else{
							alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
							window.location.reload();
						}
					}
			});
		}
	});
});
</script>