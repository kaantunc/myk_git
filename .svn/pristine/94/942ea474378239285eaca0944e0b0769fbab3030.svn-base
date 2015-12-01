<?php
$sektors = $this->sektors;
$sekSelect = '<option value="0">Seçiniz</option>';
foreach($sektors as $row){
	$selected = '';
	if($this->sek == $row['SEKTOR_ID']){
		$selected = 'selected="selected"';
	}
	$sekSelect .= '<option value="'.$row['SEKTOR_ID'].'" '.$selected.'>'.$row['SEKTOR_ADI'].'</option>';
}

$yets = $this->yets;
$yetSelect = '<option value="0">Seçiniz</option>';
foreach($yets as $row){
	$selected = '';
	if($this->yet == $row['YETERLILIK_ID']){
		$selected = 'selected="selected"';
	}
	if($row['REVIZYON'] !== '00'){
		$yetSelect .= '<option value="'.$row['YETERLILIK_ID'].'" '.$selected.'>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].' (Seviye '.$row['SEVIYE_ID'].') (Revizyon '.$row['REVIZYON'].')</option>';
	}else{
		$yetSelect .= '<option value="'.$row['YETERLILIK_ID'].'" '.$selected.'>'.$row['YETERLILIK_KODU'].'/'.$row['REVIZYON'].' '.$row['YETERLILIK_ADI'].' (Seviye '.$row['SEVIYE_ID'].')</option>';
	}
	
}

$kurs = $this->kurs;
?>
<style>

.divBorder{
	border: 1px solid #1C617C;;
	width:100%;
}

#KursTbody td{
	padding:5px;
}
#KursTbody{
	text-align: center;
}

#main{
	position:relative;
}
div#first{
	background: url('components/com_kurulus_ara/img/aski.png') repeat;
	opacity:0.25;
	width:100%;
	height:50px;
}
div#second{
	position:absolute;
 	top: 15%;
 	left: 5%;
}


</style>

<div class="anaDiv font20 text-center fontBold text-uppercase" style="color:#333333">
	<u>YetkİlendİrİlmİŞ Belgelendİrme KuruluŞu Arama</u>
</div>
<form method="post" enctype="application/x-www-form-urlencoded" action="index.php?option=com_kurulus_ara&view=kurulus_ara&layout=default">
<div class="anaDiv">
	<div class="div20 font16 hColor">Sektör:</div>
	<div class="div80"><select name="sektor" class="input-sm"><?php echo $sekSelect;?></select></div>
</div>
<div class="anaDiv">
	<div class="div20 font16 hColor">Ulusal Yeterlilik:</div>
	<div class="div80"><select name="yets" class="input-sm"><?php echo $yetSelect;?></select></div>
</div>
<div class="anaDiv" style="text-align: center">
	<button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Ara</button>
</div>
</form>
<div class="anaDiv">
	<div class="divBorder"></div>
</div>
<div class="anaDiv">
	<table width="100%" border="1" cellpadding="0" cellspacing="1" id="kurTable" class="display compact">
		<thead style="text-align:center;background-color:#71CEED">
			<tr>
				<th width="5%">#</th>			
				<th width="10%">Yetkilendirme Kodu</th>
				<th width="15%">Logo</th>
				<th width="50%">Yetkilendirilmiş Belgelendirme Kuruluş Adı</th>
				<th width="10%">Yetki Kapsamı</th>
				<th width="10%">Ücret Tarifesi</th>
			</tr>
		</thead>
		<tbody id="KursTbody">
		<?php
		$even = 'bgcolor="#efefef"';
		$say = 1;
		foreach($kurs as $row){
			if($row['USER_ID'] != 7021){
				if($say%2 == 0){
					echo '<tr '.$even.'>';
				}else{
					echo '<tr>';
				}
				
				echo '<td>'.$say.'</td>';
				echo '<td><a class="font16 fontBold" href="#" onclick="FuncKurulus('.$row['USER_ID'].')">'.$row['YBKODU'].'</a></td>';
				echo '<td><a href="#" onclick="FuncKurulus('.$row['USER_ID'].')"><img style="max-height:50px;max-width:150px" src="index.php?dl=kurulus_logo/'.$row['USER_ID'].'/'.$row['LOGO'].'"></a></td>';
				if($row['ASKI']){
						echo '<td><a href="#" onclick="FuncKurulus('.$row['USER_ID'].')" class="font16 fontBold">
							<p class="font20 fontBold text-danger text-uppercase"><img src="'.SITE_URL.'images/yetkisi_kaldirildi.gif" /></p>
								<p>'.$row['KURULUS_ADI'].'</p>
							</a>
						</td>';
				}else{
					echo '<td><a href="#" onclick="FuncKurulus('.$row['USER_ID'].')" class="font16 fontBold">'.$row['KURULUS_ADI'].'</a></td>';
				}
				
				echo '<td><button type="button" class="btn btn-xs btn-primary" onclick="FuncKapsam('.$row['USER_ID'].','.$this->yet.')">Kapsam</button></td>';
				echo '<td><button type="button" class="btn btn-xs btn-warning" onclick="FuncTarife('.$row['USER_ID'].','.$this->yet.')">Tarife</button></td>';
				echo '</tr>';
				$say++;
			}
		}
		 
		?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#kurTable').dataTable({
// 		"aaSorting": [[ 1, "asc" ]],
		"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"bInfo": true,
		"bPaginate": false,
		"bFilter": true,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": "# _MENU_ öğe göster",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "_START_ - _END_ (Toplam _TOTAL_ Kuruluş Var)",
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

	jQuery('select[name="sektor"]').live('change',function(e){
		e.preventDefault();
		jQuery('select[name="yets"]').val(0);
	});	
});

function FuncKurulus(kurId){
	window.open('index.php?option=com_kurulus_ara&view=kurulus_ara&layout=kurulus&kurId='+kurId);
}

function FuncKapsam(kurId,yetId){
	window.open('index.php?option=com_kurulus_ara&view=kurulus_ara&layout=kurulus_kapsam&kurId='+kurId+'&yetId='+yetId);
}

function FuncTarife(kurId,yetId){
	window.open('index.php?option=com_kurulus_ara&view=kurulus_ara&layout=kurulus_tarife&kurId='+kurId+'&yetId='+yetId);
}
</script>