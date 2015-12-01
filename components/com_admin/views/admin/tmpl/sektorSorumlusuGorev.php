<?php
echo $this->pageTree;

$users = $this->sektorSor;
$gorevli = $this->gorevli;
$kurulusGorevliler = $this->kurulusGorevliler;

$kurulus = $this->kuruluslar;

$kurs = '<option value="0">Seçiniz</option>';
foreach ($kurulus as $row){
	if($row['USER_ID'] == $this->kurId){
		$kurs .= '<option value="'.$row['USER_ID'].'" selected="selected">'.$row['KURULUS_ADI'].'</option>';
	}else{
		$kurs .= '<option value="'.$row['USER_ID'].'">'.$row['KURULUS_ADI'].'</option>';
	}
}
?>

<div style="width:125px;float:left"><h2>Kuruluş Adı:</h2></div><div style="float:left"><select name="kurulus" id="kurs">
<?php echo $kurs;?>
</select></div>

<form method="POST" action="index.php?option=com_admin&task=kurulusaGorevlendir" id="gorevliKaydetForm">
<input type="hidden" name="kurs" value="<?php echo $this->kurId;?>" />
<table style="width:100%;margin-top:50px;"  border="1" cellpadding="0" cellspacing="1">
	<thead style="background-color:#71CEED">
		<tr>
			<th width="70%">İsim</th>
			<th width="15%" bgcolor="green" style="color:white">Birincil Yetki</th>
			<th width="15%" bgcolor="#ff9999" style="color:white">İkincil Yetki</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$say = 1;
	foreach($users as $cow){
		if($say%2==0){
			$bcolor = 'bgcolor="#efefef"';
		}else{
			$bcolor = 'bgcolor="#ffffff"';
		}
		$say++;
		
		echo '<tr '.$bcolor.'>';
		echo '<td align="center">'.$cow->name.'</td>';
		if(in_array($cow->tgUserId, $gorevli)){
			if($kurulusGorevliler[$cow->tgUserId]['BIRINCIL'] == 1){
				echo '<td align="center" bgcolor="green"><input type="radio" checked="checked" name="gorevBir" value="'.$cow->tgUserId.'"/></td>';
				echo '<td align="center" ><input disabled="disabled" type="checkbox" name="gorevIki[]" value="'.$cow->tgUserId.'"/></td>';
			}else{
				echo '<td align="center" ><input disabled="disabled" type="radio" name="gorevBir" value="'.$cow->tgUserId.'"/></td>';
				echo '<td align="center" bgcolor="#ff9999"><input type="checkbox" checked="checked" name="gorevIki[]" value="'.$cow->tgUserId.'"/></td>';
			}
		}else{
			echo '<td align="center"><input type="radio" name="gorevBir" value="'.$cow->tgUserId.'"/></td>';
			echo '<td align="center"><input type="checkbox" name="gorevIki[]" value="'.$cow->tgUserId.'"/></td>';
		}
		echo '</tr>';
	}
	?>
	</tbody>
</table>
<input type="button" id="GorevliKaydet" value="Kaydet"/>
</form>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#kurs').live('change',function(){
		window.location.href = "index.php?option=com_admin&layout=sektorSorumlusuGorev&kurulus="+jQuery(this).val();
	});

	jQuery('input[name="gorevBir"]').live('click',function(){
		jQuery('input[name="gorevIki[]"][disabled="disabled"]').attr('disabled',false);
		jQuery('input[name="gorevBir"]').closest('td').attr('bgcolor','white');
		jQuery(this).closest('td').attr('bgcolor','green');
		jQuery('input[name="gorevIki[]"][value="'+jQuery(this).val()+'"]').attr('disabled',true);
	});

	jQuery('input[name="gorevIki[]"]').live('click',function(){
		if(jQuery(this).prop('checked')){
			jQuery(this).closest('td').attr('bgcolor','#ff9999');
			jQuery('input[name="gorevBir"][value="'+jQuery(this).val()+'"]').attr('disabled',true);
		}else{
			jQuery(this).closest('td').attr('bgcolor','white');
			jQuery('input[name="gorevBir"][value="'+jQuery(this).val()+'"]').attr('disabled',false);
		}
	});

	jQuery('#GorevliKaydet').live('click',function(){
		if(jQuery('input[name="gorevBir"]:checked').length == 0){
			alert('Lütfen Kuruluş İçin Birincil Dosya Sorumlusunu Seçiniz.');
		}else{
			jQuery('#gorevliKaydetForm').submit();
		}
	});
});
</script>