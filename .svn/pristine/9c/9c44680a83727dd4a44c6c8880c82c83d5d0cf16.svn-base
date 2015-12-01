<?php 
$sektorSorumlusu = $this->sektorSorumlusu;
?>
<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak_yeni&layout=ek_1&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?> 
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<div class="form_item">
  <div class="form_element cf_heading">
  	
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">Yeterlilik EK-1 Belgesi: Yeterlilik Birimleri</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea" > 
		<div style="font-weight: bold; padding-left:20px;">
		<?php 
		
		$eklenmisBirim = $this->eklenmisBirim;
		
		for($i=0; $i<count($eklenmisBirim); $i++)
		{	
			if($eklenmisBirim[$i]["ZORUNLU"]==1)
				echo '(ZORUNLU) ';
			else if($eklenmisBirim[$i]["ZORUNLU"]==0)
				echo '(SEÇMELİ) ';
			else
				echo '(BELİRLENMEMİŞ) ';
			
			echo $eklenmisBirim[$i]["BIRIM_ADI"].'<br>';
				
		}
		?>
		</div>
		<br>
		<hr>
		<font style="font-size: 8pt;">Birimler sekmesinde kaydedilmiş birimlerdir, düzenlemeler Birimler sekmesinde yapılabilir</font>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>



<?php 
/*if ($this->canEdit){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Kaydet" name="kaydet" type="submit" />
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}

echo $this->yorumDiv;

if ($sektorSorumlusu && $this->yorumDiv!=""){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('ek_1', <?php echo $this->standart_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}*/
?>
</form>

<script type="text/javascript">



</script>