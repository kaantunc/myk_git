<?php
$denetim = $this->kurulusDenetim;
$selectKurs = '<option value="0">Hepsi</option>';
foreach($denetim as $cow){
	if(isset($_GET['kid']) && $_GET['kid'] != 0 && $_GET['kid'] == $cow['USER_ID']){
		$selectKurs .= '<option value="'.$cow['USER_ID'].'" selected="selected">'.$cow['KURULUS_ADI'].'</option>';
	}else{
		$selectKurs .= '<option value="'.$cow['USER_ID'].'">'.$cow['KURULUS_ADI'].'</option>';
	}
}
?>
<style>
#denetimListesiGrid thead tr td
{
	font-weight: bold;
	padding:3px;
}
#yeniButton {
    background-image: url("images/ekle.png");
    background-position: left center;
    background-repeat: no-repeat;
    cursor: pointer;
    padding: 2px 5px 2px 18px;
}
</style>

<input id="yeniButton" type="button" value="Yeni Denetim" name="yeniButton" onclick="window.location='index.php?option=com_denetim&layout=yeni_denetim';"><br><br>
<span><strong>Denetim Kuruluşları: </strong></span><select id="kursSec"><?php echo $selectKurs;?></select>

<table style="width:100%;margin-top:10px" border="0" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED"> 
		<tr>
			<td>#</td>
			<th width="10%">YB KODU</th>
			<th width="40%">KURULUS ADI</th>
			<th width="10%">SON DENETIM TARIHI</th>
			<th width="10%">SONRAKİ DENETİM TARİHİ</th>
			<th width="10%">DENETİM EKİBİ</th>
			<th width="10%">UYGUNSUZLUK</th>
			<th width="20%">KURULUŞUN DENETİMLERİ</th>
		</tr>
	</thead>
	<tbody style="text-align:center">
	<?php 
	$even = 'bgcolor="#efefef"';
	$say = 1;
	foreach ($denetim as $row){
		if(!isset($_GET['kid']) || $_GET['kid'] == 0){
			if($say%2==0){
				echo '<tr '.$even.'>';
			}else{
				echo '<tr>';
			}
			echo '<td>'.$say.'</td>';
			echo '<td>'.$row['KURULUS_YETKILENDIRME_NUMARASI'].'</td>';
			echo '<td>'.$row['KURULUS_ADI'].'</td>';
			echo '<td>'.$row['SON_DENETIM'].'</td>';
			echo '<td>'.OnePlusYear($row['SON_DENETIM']).'</td>';
			echo '<td><button type="button" onclick="denetimEkibi('.$row['DENETIM_ID'].')" class="btn btn-xs btn-warning">Denetim Ekibi</button></td>';
			if($row['UYGUNSUZLUK']>0){
				$uyUrl = "index.php?option=com_denetim&layout=uygunsuzluk_listele&denetim_id=".$row['DENETIM_ID'];
				echo '<td><a href="'.$uyUrl.'" target="_blank">'.$row['UYGUNSUZLUK'].'</a></td>';	
			}else{
				echo '<td>Yok</td>';
			}
			$url = "window.location='index.php?option=com_denetim&layout=denetim_listele&kid=".$row['USER_ID']."'";
			echo '<td><button type="button" onclick="'.$url.'" class="btn btn-xs btn-primary">Denetimler</button></td>';
			echo '</tr>';
		}else if(isset($_GET['kid']) && $_GET['kid'] != 0 && $_GET['kid'] == $row['USER_ID']){
			if($say%2==0){
				echo '<tr '.$even.'>';
			}else{
				echo '<tr>';
			}
			echo '<td>'.$say.'</td>';
			echo '<td>'.$row['KURULUS_YETKILENDIRME_NUMARASI'].'</td>';
			echo '<td>'.$row['KURULUS_ADI'].'</td>';
			echo '<td>'.$row['SON_DENETIM'].'</td>';
			echo '<td>'.OnePlusYear($row['SON_DENETIM']).'</td>';
			echo '<td><button type="button" onclick="denetimEkibi('.$row['DENETIM_ID'].')" class="btn btn-xs btn-warning">Denetim Ekibi</button></td>';
			if($row['UYGUNSUZLUK']>0){
				$uyUrl = "index.php?option=com_denetim&layout=uygunsuzluk_listele&denetim_id=".$row['DENETIM_ID'];
				echo '<td><a href="'.$uyUrl.'" target="_blank">'.$row['UYGUNSUZLUK'].'</a></td>';	
			}else{
				echo '<td>Yok</td>';
			}
			$url = "window.location='index.php?option=com_denetim&layout=denetim_listele&kid=".$row['USER_ID']."'";
			echo '<td><button type="button" onclick="'.$url.'" class="btn btn-xs btn-primary">Denetimler</button></td>';
			echo '</tr>';
		}
		$say++;
	}
	?>
	</tbody>
</table>
<div id="Ekip" style=" min-width: 80%; min-height:10px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px">
    <table style="width:100%;margin-top:10px" border="0" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED"> 
		<tr>
			<th width="20%">Adı</th>
			<th width="20%">Soyadı</th>
			<th width="30%">Görev Rolü</th>
			<th width="30%">Görev Aldığı Gün Sayısı</th>
		</tr>
	</thead>
	<tbody style="text-align:center" id="ekipTbody">
	</tbody>
</table>
</div>
<?php 
function OnePlusYear($date){
	$tarih = explode('/', $date);
	return $tarih[0].'/'.$tarih[1].'/'.($tarih[2]+1);
}
?>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#kursSec').live('change',function(){
		var url = "index.php?option=com_denetim&layout=kurulus_denetim&kid="+jQuery(this).val();
		window.location.href = url;
	});
});

function denetimEkibi(denetimId){
	jQuery('#ekipTbody').html('');
	jQuery.ajax({
		async:false,
		type:'POST',
		url:"index.php?option=com_denetim&task=getDenetimEkibi&format=raw",
		data:'denetimId='+denetimId,
		success:function(data){
			var dat = jQuery.parseJSON(data);
			var even = 'bgcolor="#efefef"';
			var say = 1;
			var ekle='';
			jQuery.each(dat,function(key,vall){
				if(say%2==0){
					ekle += '<tr '+even+'>';
				}else{
					ekle += '<tr>';
				}
				ekle += '<td>'+vall['AD']+'</td>'+
				'<td>'+vall['SOYAD']+'</td>'+
				'<td>'+vall['ROL_ADI']+'</td>'+
				'<td>'+vall['GOREVLENDIRILDIGI_GUN_SAYISI']+'</td></tr>';
				say++;
			});
			jQuery('#ekipTbody').html(ekle);
			jQuery('#Ekip').lightbox_me({
			  	  centered: true
			    });
			}
	});
}
</script>