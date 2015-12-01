<?php 
defined('_JEXEC') or die('Restricted access');

$kurulus = $this->kurulus;
$yeterlilik = $this->yeterlilik;
?>
<form method="post" action="index.php?option=com_sinav&task=ucretTarifesiAra">

<table id="belgelendirmeUcretleriTablosuArama" style="width:100%;" >
	<tr>
		<td>Kuruluş Adı: <select style="margin-left: 10px;" id="kurulus_id" name="kurulus_id">
				<option value="">Seçiniz</option>
				<?php foreach($kurulus as $rows){
					echo '<option value="'.$rows["USER_ID"].'">'.$rows["KURULUS_ADI"].'</option>';
				}?>
			</select>
		</td>
	</tr>
	<tr>
		<td style="padding-top:10px;">Yeterlilik Adı: <select style="margin-left: 5px;" id="yeterlilik_id" name="yeterlilik_id">
				<option value="">Seçiniz</option>
				<?php foreach($yeterlilik as $rows){
					echo '<option value="'.$rows["YETERLILIK_ID"].'">'.$rows["YETERLILIK_KODU"].' - '.$rows["YETERLILIK_ADI"].'</option>';
				}?>
			</select>
		</td>
	</tr>
</table>
<input type="button" value="Ara" onclick="KurulusSecildi()"/>
</br>
</br>
<div id="tarifeler">

</div>
</form>

<script type="text/javascript">
function KurulusSecildi(){
	var sendData = 'kurulus_id=' + jQuery('#kurulus_id').val() + '&yeterlilik_id=' + jQuery('#yeterlilik_id').val();
	var url = 'index.php?option=com_sinav&task=yetkiYeterlilikAra&format=raw';
		jQuery.ajax({
			  url: url,
			  data: sendData,
			  type: "POST",
			  dataType: 'json',
			  success: function(data) {
				  if(data['success']){
					  tarifeGetir(data['array']);
					  //data['array'][0]
					  //data['array'][1]
	 			  }else{
					  alert("Kayıt yok veya Hata oluştu");
				  }
			  }
		});	
}

function tarifeGetir(data){
	jQuery('#yets').remove();
	jQuery('#kurulus_adi').remove();
	var ekle = '';
	var yaz = '';
	/*var ekle = '<table style="width:100%;" >'
		+'<thead>'
			+'<tr>'
			+'<td>Yeterlilik</td>'
			+'<td>Açıklama</td>'
			+'<td>Yetkilendirme Tarihi</td>'
			+'</tr>'
		+'</thead>';*/
	if(data[4] == "yetId"){		
		for(var jj = 0; jj < data[0].length; jj++){
			ekle = '';
			ekle += '<table cellspacing="1" border="1" style="width:100%;" ><thead>'
			+'<tr>'
			+'<th colspan="3">'+data[3][data[0][jj]["USER_ID"]][0][0]["KURULUS_ADI"]+'"ın Yetkilendirildiği Yeterlilikler</th>'
			+'</tr>'
			+'<tr class="tablo_header">'
			+'<th>Yeterlilik</th>'
			+'<th>Açıklama</th>'
			+'<th>Yetkilendirme Tarihi</th>'
			+'</tr>'
		+'</thead><tbody>'
			+'<tr style="text-align:center;"><td>'+data[0][jj]["YETERLILIK_KODU"]+' - '+data[0][jj]["YETERLILIK_ADI"]+'</td><td>';
			for(var ii = 0; ii < data[1][data[0][jj]["USER_ID"]][0].length; ii++){
				if(data[0][jj]["YENI_MI"] == 0){
					if(ii == (data[1][data[0][jj]["USER_ID"]][0].length-1)){
						ekle += data[0][jj]["YETERLILIK_KODU"]+'/'+data[1][data[0][jj]["USER_ID"]][0][ii]["BIRIM_NO"]+'</td>';
					}
					else{
						ekle += data[0][jj]["YETERLILIK_KODU"]+'/'+data[1][data[0][jj]["USER_ID"]][0][ii]["BIRIM_NO"]+', ';
						}
					}
				else{
					if(ii == (data[1][data[0][jj]["USER_ID"]][0].length-1)){
						ekle += data[1][data[0][jj]["USER_ID"]][0][ii]["BIRIM_KODU"]+'</td>';
					}
					else{
						ekle += data[1][data[0][jj]["USER_ID"]][0][ii]["BIRIM_KODU"]+', ';
						}
					}
			}
			if(data[2][data[0][jj]["USER_ID"]][0].length > 0){
				ekle += '<td>'+data[2][data[0][jj]["USER_ID"]][0][0]["YETKI_KAPSAMI_YETKI_TARIHI"]+'</td>';
			}
		ekle += '</tr></tbody></table>';
		yaz += ekle;
		}
	}
		
	else if(data[4] == "kurulus"){
		for(var jj = 0; jj < data[3].length; jj++){
			ekle = '';
			ekle += '<table cellspacing="1" border="1" style="width:100%;" ><thead>'
			+'<tr>'
			+'<th colspan="3">'+data[3][0]["KURULUS_ADI"]+'"ın Yetkilendirildiği Yeterlilikler</th>'
			+'</tr>'
			+'<tr class="tablo_header">'
			+'<th>Yeterlilik</th>'
			+'<th>Açıklama</th>'
			+'<th>Yetkilendirme Tarihi</th>'
			+'</tr>'
		+'</thead><tbody>';
		for(var kk = 0; kk < data[0].length; kk++){
			if(data[1][data[0][kk]["YETERLILIK_ID"]][0].length > 0)
				ekle+='<tr style="text-align:center;"><td>'+data[0][kk]["YETERLILIK_KODU"]+' - '+data[0][kk]["YETERLILIK_ADI"]+'</td><td>';
			for(var ii = 0; ii < data[1][data[0][kk]["YETERLILIK_ID"]][0].length; ii++){
				if(data[0][kk]["YENI_MI"] == 0){
					if(ii == (data[1][data[0][kk]["YETERLILIK_ID"]][0].length-1)){
						ekle += data[0][kk]["YETERLILIK_KODU"]+'/'+data[1][data[0][kk]["YETERLILIK_ID"]][0][ii]["BIRIM_NO"]+'</td>';
					}
					else{
						ekle += data[0][kk]["YETERLILIK_KODU"]+'/'+data[1][data[0][kk]["YETERLILIK_ID"]][0][ii]["BIRIM_NO"]+', ';
						}
					}
				else{
					if(ii == (data[1][data[0][kk]["YETERLILIK_ID"]][0].length-1)){
						ekle += data[1][data[0][kk]["YETERLILIK_ID"]][0][ii]["BIRIM_KODU"]+'</td>';
					}
					else{
						ekle += data[1][data[0][kk]["YETERLILIK_ID"]][0][ii]["BIRIM_KODU"]+', ';
						}
					}
			}
			if(data[2][data[0][kk]["YETERLILIK_ID"]][0].length > 0){
				ekle += '<td>'+data[2][data[0][kk]["YETERLILIK_ID"]][0][0]["YETKI_KAPSAMI_YETKI_TARIHI"]+'</td>';
			}
		}
		ekle += '</tr></tbody></table>';
		yaz += ekle;
		}
		}
		
	else{
		ekle = '';
		ekle += '<table cellspacing="1" border="1" style="width:100%;"><thead>'
		+'<tr>'
		+'<th colspan="3">'+data[3][0]["KURULUS_ADI"]+'"ın Yetkilendirildiği Yeterlilikler</th>'
		+'</tr>'
		+'<tr class="tablo_header">'
		+'<th>Yeterlilik</th>'
		+'<th>Açıklama</th>'
		+'<th>Yetkilendirme Tarihi</th>'
		+'</tr>'
	+'</thead><tbody>';
	
		if(data[1].length > 0)
			ekle+='<tr style="text-align:center;"><td>'+data[0][0]["YETERLILIK_KODU"]+' - '+data[0][0]["YETERLILIK_ADI"]+'</td><td>';
		for(var ii = 0; ii < data[1].length; ii++){
			if(data[0][0]["YENI_MI"] == 0){
				if(ii == (data[1].length-1)){
					ekle += data[0][0]["YETERLILIK_KODU"]+'/'+data[1][ii]["BIRIM_NO"]+'</td>';
				}
				else{
					ekle += data[0][0]["YETERLILIK_KODU"]+'/'+data[1][ii]["BIRIM_NO"]+', ';
					}
				}
			else{
				if(ii == (data[1].length-1)){
					ekle += data[1][ii]["BIRIM_KODU"]+'</td>';
				}
				else{
					ekle += data[1][ii]["BIRIM_KODU"]+', ';
					}
				}
		}
		if(data[2].length > 0){
			ekle += '<td>'+data[2][0]["YETKI_KAPSAMI_YETKI_TARIHI"]+'</td>';
		}
	
	ekle += '</tr></tbody></table>';
	yaz += ekle;
		}
		
	jQuery('#tarifeler').append('<div id="yets">'+yaz+'</div>');
}
</script>