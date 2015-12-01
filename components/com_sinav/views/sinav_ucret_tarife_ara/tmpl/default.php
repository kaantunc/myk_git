<?php 
defined('_JEXEC') or die('Restricted access');

$kurulus = $this->kurulus;
?>
<form method="post" action="index.php?option=com_sinav&task=ucretTarifesiAra">

<table id="belgelendirmeUcretleriTablosuArama" style="width:100%;" >
	<tr>
		<td>Kuruluş Adı: <select style="margin-left:5px;" id="kurulus_id" name="kurulus_id">
				<option value="">Seçiniz</option>
				<?php foreach($kurulus as $rows){
					echo '<option value="'.$rows["USER_ID"].'">'.$rows["KURULUS_ADI"].'</option>';
				}?>
			</select>
		</td>
	</tr>
</table>
<input type="button" value="Ara" onclick="KurulusSecildi()"/>

<div style="margin-top:20px;" id="tarifeler">

</div>
</form>

<script type="text/javascript">
function KurulusSecildi(){
	var sendData = 'kurulus_id=' + jQuery('#kurulus_id').val();
	var url = 'index.php?option=com_sinav&task=ucretTarifesiAra&format=raw';
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
					  alert("Hata oluştu");
				  }
			  }
		});	
}

function tarifeGetir(data){
	jQuery('#belgelendirmeUcretleriTablosu').remove();
	jQuery('h4').remove();
	var ekle = '';
	if(data[1].length == 0){
		var yaz = '<div><h4>'+data[2][0]["KURULUS_ADI"]+'<br/>Hiç bir ücret tarifesinde bulunmamış.</h4></div>';
		}
	else{
	var yaz = '<table id="belgelendirmeUcretleriTablosu" cellspacing="1" border="1" style="width:100%;">'
		+'<thead>'
			+'<tr class="tablo_header">'
			+'<th>ULUSAL YETERLİLİK BELGELENDİRME PROGRAMI</th>'
			+'<th style="width:100px;">ÜCRET(TL)</br>KDV DÂHİL</th>'
			+'<th style="width:100px;">İNDİRİMLİ ÜCRET(TL)</br>KDV DÂHİL</th>'
			+'</tr>'
		+'</thead>'
		+'<tbody>'
		+'<h4>'+data[2][0]["KURULUS_ADI"]+' SINAV VE BELGELENDIRME ÜCRET TARİFESİ</h4>';
	for(var ii = 0; ii < data[1].length; ii++){
		ekle += '<tr id="'+data[1][ii]['UCRET_ID']+'"><td>'+data[1][ii]['BELGELENDIRME_PROGRAMI_ACKLM']+'</td>'
		  +'<td style="width:100px;">'+data[1][ii]['UCRET']+'</td>'
		  +'<td style="width:100px;">'+data[1][ii]['INDIRIMLI_UCRET']+'</td></tr>'; 
		}
	yaz += ekle + '</tbody></table>';
	}
	jQuery('#tarifeler').append(yaz);
}
</script>