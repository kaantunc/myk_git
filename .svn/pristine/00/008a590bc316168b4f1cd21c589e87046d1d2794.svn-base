<?php
$itirazlar = $this->itirazlar['itirazlar'];
$BelgeUcretBilgi = $this->itirazlar['BelgeUcretBilgi'];
$kurulus = $this->itirazlar['kurulus'];
function UcretHesapla($dat){
	$dat = floor($dat*100)/100;
	return number_format($dat,'2',',','.');
}

function UcretDuzenle($ucret){
	return str_replace(',', '.', $ucret);
}
?>
<style>
table.dataTable tr.even.bg-danger,
table.dataTable tr.odd.bg-danger,
table.dataTable tr.odd.bg-danger td.sorting_1,
table.dataTable tr.even.bg-danger td.sorting_1{
	background-color: #ff4136;
}

table.dataTable tr.even.bg-success,
table.dataTable tr.odd.bg-success,
table.dataTable tr.odd.bg-success td.sorting_1,
table.dataTable tr.even.bg-success td.sorting_1{
	background-color: #28b62c;
}
</style>
<div class="anaDiv fontBold font20 hColor text-center">
Ücret İadesi İtirazları
</div>
<?php echo $this->iLink;?>
<div class="anaDiv">
<table width="100%" border="1" cellpadding="0" cellspacing="2" id="kurTable" class="display compact">
		<thead class="bg-info text-center">
			<tr>
				<th width="5%">#</th>
				<th width="10%">Belge NO:</th>
				<th width="10%">TC Kimlik</th>
				<th width="15%">Ad Soyad</th>
				<th width="20%">Kuruluş</th>
				<th width="10%">Hesaplanan Ücret</th>
				<th width="10%">Dezavantaj Dosyası</th>
				<?php if($this->dId == 0){ ?>
					<th width="10%">Düzenle</th>
				<?php }?>
			</tr>
		</thead>
		<tbody class="text-center">
		<?php
		$say = 1;
		foreach ($itirazlar as $row){
			$hesap = 0;
			$UcretBilgi = $BelgeUcretBilgi[$row['BELGE_NO']]['UcretBilgi'];
			$YetUcret = $BelgeUcretBilgi[$row['BELGE_NO']]['YetUcret'];
			$BelgeMasraf = $BelgeUcretBilgi[$row['BELGE_NO']]['BelgeMasraf'];
			foreach($UcretBilgi[$row['BELGE_NO']] as $cow){
				$hesap += UcretDuzenle($cow['ucret']);
			}
			
			echo '<td>'.$say.'</td>';
			echo '<td>'.$row['BELGE_NO'].'</td>';
			echo '<td>'.$row['TC_KIMLIK'].'</td>';
			echo '<td>'.$row['ADI'].' '.$row['SOYADI'].'</td>';
			echo '<td>'.$kurulus[$row['BELGE_NO']]['KURULUS_ADI'].'</td>';
			
			echo '<td>'.UcretHesapla($hesap).' TL</td>';
			$dosyaType = strtolower(pathinfo($row['DOKUMAN'], PATHINFO_EXTENSION));
			if($dosyaType == 'pdf' || $dosyaType == 'doc' || $dosyaType == 'docx' || $dosyaType == 'zip' || $dosyaType == 'rar'){
				echo '<td><a target="_blank" href="index.php?dl=abhibe/dezavantaj/'.$row['SINAV_ID'].'/'.$row['DOKUMAN'].'" class="btn btn-sm btn-info">İndir</a></td>';
			}else if($dosyaType == 'jpg' || $dosyaType == 'jpeg' || $dosyaType == 'png' || $dosyaType == 'gif' || $dosyaType == 'pjpeg'){
				echo '<td><a target="_blank" href="index.php?img=abhibe/dezavantaj/'.$row['SINAV_ID'].'/'.$row['DOKUMAN'].'" class="btn btn-sm btn-info">İndir</a></td>';
			}
			
			if($this->dId == 0){
				echo '<td>';?>
				<div class="anaDiv"><button type="button" class="btn btn-xs btn-success" onclick="FuncDezOnayla('<?php echo urlencode($row['BELGE_NO']); ?>')">Onayla</button></div>
				<div class="anaDiv"><button type="button" class="btn btn-xs btn-danger" onclick="FuncDezReddet('<?php echo urlencode($row['BELGE_NO']); ?>')">Reddet</button></div>
				<?php echo '</td>';
			}
			
			echo '</tr>';
			$say++;
		} 
		?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	var oTables = jQuery('#kurTable').dataTable({
// 		"aaSorting": [[ 1, "asc" ]],
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bInfo": true,
		"bPaginate": true,
		"bFilter": true,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": "# _MENU_ öğe göster",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ İstek Oluşturuldu)",
			"sInfoEmpty": "0 - 0 öğeden 0'ı gösteriliyor.",
			"sSearch": "Ara",
			"oPaginate": {
				"sFirst":    "<?php echo JText::_("FIRST");?>",
				"sPrevious": "Önceki",
				"sNext":     "Sonraki",
				"sLast":     "<?php echo JText::_("LAST");?>"
			}
		}
	});
});

function FuncDezOnayla(bNo){
	if(confirm('Adayın Dezavantajını onaylamak istediğinizden emin misiniz?')){
		jQuery.ajax({
			async:false,
			type:'POST',
			url:'index.php?option=com_tesvik_abhibe&task=DezAvantajDurumGuncelle&format=raw',
			data:'bNo='+bNo+'&dId=1'
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Adayın Dezavantajı başarıyla onaylandı.');
				window.location.reload();
			}else{
				alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
				window.location.reload();
			}
		});
	}
}

function FuncDezReddet(bNo){
	if(confirm('Adayın Dezavantajını reddetmek istediğinizden emin misiniz?')){
		jQuery.ajax({
			async:false,
			type:'POST',
			url:'index.php?option=com_tesvik_abhibe&task=DezAvantajDurumGuncelle&format=raw',
			data:'bNo='+bNo+'&dId=-1'
		}).done(function(data){
			var dat = jQuery.parseJSON(data);
			if(dat){
				alert('Adayın Dezavantajı başarıyla reddedildi.');
				window.location.reload();
			}else{
				alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
				window.location.reload();
			}
		});
	}
}
</script>