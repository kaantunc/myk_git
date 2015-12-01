<?php 
defined('_JEXEC') or die('Restricted access');

$data = $this->yetki_yeterlilik;

?>
<table cellspacing="1" border="1" style="width:100%;">
	<thead>
		<tr>
			<th colspan="3"><?php echo $data[3][0]["KURULUS_ADI"];?>'ın Yetkilendirildiği Yeterlilikler</th>
		</tr>
		<tr class="tablo_header">
			<th>Yeterlilik</th>
			<th>Açıklama</th>
			<th>Yetkilendirme Tarihi</th>
		</tr>
	</thead>
	<tbody>
	<?php $ekle=''; for($kk = 0; $kk < count($data[0]); $kk++){
			if(count($data[1][$data[0][$kk]["YETERLILIK_ID"]][0]) > 0){
				$ekle.='<tr style="text-align:center;"><td>'.$data[0][$kk]["YETERLILIK_KODU"].' - '.$data[0][$kk]["YETERLILIK_ADI"].'</td><td>';
			for($ii = 0; $ii < count($data[1][$data[0][$kk]["YETERLILIK_ID"]][0]); $ii++){
				if($data[0][$kk]["YENI_MI"] == 0){
					if($ii == count($data[1][$data[0][$kk]["YETERLILIK_ID"]][0])-1){
						$ekle .= $data[0][$kk]["YETERLILIK_KODU"].'/'.$data[1][$data[0][$kk]["YETERLILIK_ID"]][0][$ii]["BIRIM_NO"].'</td>';
					}
					else{
						$ekle .= $data[0][$kk]["YETERLILIK_KODU"].'/'.$data[1][$data[0][$kk]["YETERLILIK_ID"]][0][$ii]["BIRIM_NO"].', ';
						}
					}
				else{
					if($ii == count($data[1][$data[0][$kk]["YETERLILIK_ID"]][0])-1){
						$ekle .= $data[1][$data[0][$kk]["YETERLILIK_ID"]][0][$ii]["BIRIM_KODU"].'</td>';
					}
					else{
						$ekle .= $data[1][$data[0][$kk]["YETERLILIK_ID"]][0][$ii]["BIRIM_KODU"].', ';
						}
					}
			}
			if(count($data[2][$data[0][$kk]["YETERLILIK_ID"]][0])> 0){
				$ekle .= '<td>'.$data[2][$data[0][$kk]["YETERLILIK_ID"]][0][0]["YETKI_KAPSAMI_YETKI_TARIHI"].'</td>';
			}
		}
	}
		$ekle .= '</tr></tbody></table>';
		echo $ekle;
?>
		

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
			ekle += '<td>'+data[2][data[0][jj]["USER_ID"]][0][0]["YETKI_KAPSAMI_YETKI_TARIHI"]+'</td>';
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