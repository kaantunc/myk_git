<?php 
$sektorSorumlusu = $this->sektorSorumlusu;
$taslakYeterlilik = $this->taslakYeterlilik;

$readOnly = "";
if (!$this->canEdit)
	$readOnly = "readOnly";
?>
<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak&layout=aciklama_son&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?>
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">YETERLİLİK BELGESİNİN GEÇERLİLİK SÜRESİ</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?>
			id="gecerlilik_sure" title="" cols="50" name="gecerlilik_sure"><?php echo $taslakYeterlilik["YETERLILIK_GECERLILIK_SURE"];?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">BELGE SAHİBİNİN GÖZETİMİNDE UYGULANACAK PERFORMANS İZLEME METODLARI ve BELGE SAHİBİNİN GÖZETİM SIKLIĞI</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?>
			id="metod_gozetim" title="" cols="50" name="metod_gozetim"><?php echo $taslakYeterlilik["YETERLILIK_METHOD_GOZETIM"];?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">GEÇERLİLİK SÜRESİ DOLAN BELGELERİN YENİLENMESİNDE UYGULANACAK DEĞERLENDİRME YÖNTEMLERİ</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="5" <?php echo $readOnly;?>
			id="degerlendirme_yontem" title="" cols="50" name="degerlendirme_yontem"><?php echo $taslakYeterlilik["YETERLILIK_DEG_YONTEM"];?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">YETERLİLİĞİ GELİŞTİREN KURULUŞLAR</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="kurulus_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<?php 
if ($this->canEdit){
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

if ($this->sektorSorumlusu && $this->yorumDiv!=""){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('aciklama_son', <?php echo $this->yeterlilik_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}
?>

</form>

<script type="text/javascript">
<?php 
if ($this->canEdit)
	echo "var isReadOnly = false;";
else
	echo "var isReadOnly = true;";
?>
var readOnly = null;
if (isReadOnly)
	readOnly = "readOnly";

dTables.kurulus = new Array(new Array("text","","4","", readOnly),	
	    					new Array("text","required", "40","", readOnly));

function createTables(){
	var tableName = 'kurulus';
	var headers	  = new Array ('Sıra No', 'Kuruluş Adı');
	createTable(tableName, headers);
	patchSatirEkle(tableName, headers, tableName);
	addKurulusValues (dTables.kurulus, tableName);
	
	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 2);
	}
}
	
function addKurulusValues (kurulus, name){
	var length = kurulus.length;
	var params = new Array ();
	var arr    = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = kurulus[i][0];
	}
	<?php
	$tableCount = count ($this->gelistiren_kurulus);
	
	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $this->gelistiren_kurulus[$i];
		
		echo 'arr['.$c++.']= "'. ($i+1) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["YETERLILIK_KURULUS_ADI"]) .'";';
	}	
	?>

	if (isset (arr))
		addTableValues (arr, params, name);
}
</script>