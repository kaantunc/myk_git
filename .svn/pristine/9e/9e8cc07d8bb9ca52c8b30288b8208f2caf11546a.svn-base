<?php 
$kurulus = $this->kurulus_bilgi;
echo $this->tipLink;
$yetkiYets = $this->yetkiYets;
$pata = $this->yetkiBirims;
$yetkiBirims = $pata['yetkiBirims'];

$yetSelect = '<option value="0">Seçiniz</option>';
foreach($this->UcretTarifeYet as $row){
	$selected = '';
	if($row['YETERLILIK_ID'] == $this->yId){
		$selected = ' selected="selected"';
	}
	$yetSelect .= '<option value="'.$row['YETERLILIK_ID'].'" '.$selected.'>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].'</option>';
}

?>
<div class="anaDiv text-center">
	<?php echo '<h2 class="font20 fontBold"><u>'.$kurulus['KURULUS_ADI'].'</u></h2>';?>
</div>
<?php echo $this->sayfaLink;?>
<form method="post" enctype="multipart/form-data" action="index.php?option=com_profile&view=profile&layout=ucret_tarife_edit&kurulus=<?php echo $kurulus['USER_ID'];?>">
<div class="anaDiv text-center">
	<select class="input-sm" name="yetId"><?php echo $yetSelect;?></select>
</div>
<div class="anaDiv text-center">
	<button type="submit" class="btn btn-sm btn-success">Getir</button>
</div>
</form>
<?php if($yetkiYets){?>
<div class="anaDiv text-center">
	<?php echo '<h2 style="margin-bottom:10px;">'.$yetkiYets[0]['YETERLILIK_KODU'].'/'.$yetkiYets[0]['REVIZYON'].' '.$yetkiYets[0]['YETERLILIK_ADI'].' Ücret Tarifesi Dönemleri</h2>';?>
</div>	
<?php }?>
<div class="divBorder"></div>
<?php
foreach($yetkiYets as $row){
?>
<div class="anaDiv">
	<div class="div95 font18 hColor">
		<?php echo $row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'];?>
	</div>
</div>
<div class="anaDiv">
	<table width="100%" border="1">
		<thead style="text-align:center;background-color:#71CEED" class="theadBirims">
			<tr>
				<th width="5%">#</th>
				<th width="50%">Yetkili Ulusal Yeterlilik Birimi</th>
				<th width="15%">Toplam Birim Ücreti</th>
			</tr>
		</thead>
		<tbody class="birimsTbody">
<?php
	$even = 'bgcolor="#efefef"';
	$say = 1;
	foreach($yetkiBirims[$row['DONEM_ID']] as $cow){
		if($say%2 == 0){
			echo '<tr '.$even.'>';
			$bgcolor = 'bgcolor="#efefef"';
		}else{
			echo '<tr>';
			$bgcolor = '';
		}
		
		echo '<td>'.$say.'</td>';
		if($cow['YET_ESKI_MI'] == 1){
			echo '<td>'.$row['YETERLILIK_KODU'].'/'.$cow['BIRIM_KODU'].' '.$cow['BIRIM_ADI'].'</td>';
		}else{
			echo '<td>'.$cow['BIRIM_KODU'].' '.$cow['BIRIM_ADI'].'</td>';
		}
		
		if(isset($cow['UCRET'])){
			echo '<td class="text-end">'.$cow['UCRET'].'</td>';
		}else{
			echo '<td class="text-end"></td>';
		}
		
		echo '</tr>';
		$say++;
		
	}
?>
		</tbody>
	</table>
</div>
<div class="anaDiv">
	<div class="div50 font18 hColor">
		<span>Yeterlilik için toplam ücret bedeli:</span> <span class="basUcret"><?php echo $row['UCRET']; ?></span>
	</div>	
	<div class="div50 text-right font16">
		<p><span class="hColor">Ücret Tarifesi Başlangıç Dönemi:</span> <?php echo $row['MUTTARIH'];?></p>
		<p><span class="hColor">Ücret Tarifesi Dönemi:</span> <?php echo $row['DONEM'];?></p>
	</div>
</div>
<?php
if($this->canEdit){
?>
<div class="anaDiv">
	<button type="button" class="btn btn-sm btn-primary" onclick="FuncYetUcretDuzenle(<?php echo $row['YETERLILIK_ID'];?>,<?php echo $row['USER_ID'];?>,<?php echo $row['DONEM_ID'];?>)">Düzenle</button>
</div>
<?php
}
?>
<div class="divBorder"></div>
<?php
}
?>

<script type="text/javascript">
function FuncYetUcretDuzenle(yId,kId,dId){
	jQuery('#YetkiBirimUcret input[name="dId"]').val(0);
	jQuery('#YetkiBirimUcret input[name="yId"]').val(0);
	jQuery('#YetkiBirimUcret input[name="kId"]').val(0);

	jQuery('#YetkiBirimUcret input[name="UcretDonem"]').val('');
	jQuery('#YetkiBirimUcret input[name="YetUcret"]').val('');
	
	jQuery.ajax({
		async:false,
		type:'POST',
		url:"index.php?option=com_profile&task=ajaxGetYetUcretByDonem&format=raw",
		data:'uId='+kId+'&yId='+yId+'&dId='+dId
	}).done(function(data){
		var dat = jQuery.parseJSON(data);
		if(dat){
			jQuery('#YetkiBirimUcret input[name="yId"]').val(yId);
			jQuery('#YetkiBirimUcret input[name="kId"]').val(kId);
			jQuery('#YetkiBirimUcret input[name="dId"]').val(dId);
			var yets = dat['yets'];
			var birims = dat['birims']['yetkiBirims'];
			var donemBilgi = dat['donemBilgi'];
			
			jQuery('#YetkiBirimUcret input[name="UcretDonem"]').val(donemBilgi['TARIH']);
			jQuery('#YetkiBirimUcret h2#YetAdi').html(yets['YETERLILIK_KODU']+'/'+yets['REVIZYON']+' '+yets['YETERLILIK_ADI']);
			jQuery('#YetkiBirimUcret input[name="YetUcret"]').val(yets['UCRET']);

			var say = 1;
			var bgcolor = 'bgcolor="#efefef"';
			var ekle = '';
			jQuery.each(birims,function(key,val){
				if(say%2 == 0){
					bgcolor = 'bgcolor="#efefef"';
				}else{
					bgcolor = 'bgcolor="#ffffff"';
				}
				ekle += '<tr '+bgcolor+'>';
				
				ekle += '<td>'+say+'</td>';

				if(val['YET_ESKI_MI'] == 1){
					ekle +=  '<td>'+yets['YETERLILIK_KODU']+'/'+val['BIRIM_KODU']+' '+val['BIRIM_ADI']+'</td>';
				}else{
					ekle +=  '<td>'+val['BIRIM_KODU']+' '+val['BIRIM_ADI']+'</td>';
				}

				if(val['UCRET'].length>0 || val['UCRET'] != ''){
					ekle += '<td><input class="input-sm inputW95 text-end" type="text" name="BirimUcret['+val['BIRIM_ID']+']" value="'+val['UCRET']+'"/></td>';
				}else{
					ekle += '<td><input class="input-sm inputW95 text-end" type="text" name="BirimUcret['+val['BIRIM_ID']+']"/></td>';
				}
				
				ekle += '</tr>';
				
				say++;
			});

			
			jQuery('#BirimsUcret').html(ekle);
			jQuery('#YetkiBirimUcret').lightbox_me({
				centered: true,
			    closeClick:false,
			    closeEsc:false
			});
		}
	});
}

jQuery(document).ready(function(){
	jQuery('#UcretIptal').live('click',function(){
		jQuery('#YetkiBirimUcret').trigger('close');
	});

	jQuery('.tarih').live('hover',function(e){
		 e.preventDefault();
			jQuery(this).datepicker({
		        changeYear: true,
		        changeMonth: true,
		        dateFormat: 'dd/mm/yy'
		     });
	});

	
});
</script>

<div id="YetkiBirimUcret" style=" max-width: 70%; max-height:600px; background-color: white; border:1px solid #00A7DE; display: none; padding:20px; overflow: auto;">
<form method="post" enctype="multipart/form-data" action="index.php?option=com_profile&task=UcretKaydet">		
    <div class="anaDiv">
    	<h2 id="YetAdi"></h2>
    </div>
    <div class="anaDiv">
    	<table width="100%" border="1">
			<thead style="text-align:center;background-color:#71CEED" class="theadBirims">
				<tr>
					<th width="5%">#</th>
					<th width="50%">Yetkili Ulusal Yeterlilik Birimi</th>
					<th width="15%">Toplam Birim Ücreti</th>
				</tr>
			</thead>
			<tbody class="birimsTbody" id="BirimsUcret">
			
			</tbody>
		</table>
    </div>
    
    <input type="hidden" name="kId" />
    <input type="hidden" name="yId" />
    <input type="hidden" name="dId" />
    <div class="anaDiv">
    	<div class="div30 font16 hColor">
    		Yeterlilik için toplam ücret bedeli:
    	</div>
    	<div class="div70">
    		<input type="text" class="input-sm text-end" name="YetUcret" />
    	</div>
	</div>
	<div class="anaDiv">
    	<div class="div30 font16 hColor">
    		Dönem Başlangıç Tarihi:
    	</div>
    	<div class="div70">
    		<input type="text" class="input-sm text-end tarih" name="UcretDonem" />
    	</div>
	</div>
    <div class="anaDiv">
    	<div class="div50">
	    	<button type="submit" class="btn btn-sm btn-success">Kaydet</button>
		    <button type="button" id="UcretIptal" class="btn btn-sm btn-danger">İptal</button>
    	</div>
    </div>
</form>
</div>