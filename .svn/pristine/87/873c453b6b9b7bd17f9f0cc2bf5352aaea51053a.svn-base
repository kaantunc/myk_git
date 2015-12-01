<?php 

?>
<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak_yeni&layout=yeterlilik_kaynagi&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?>
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">YETERLİLİĞE KAYNAK TEŞKİL EDEN MESLEK STANDARTLARI</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="kaynak_meslek_div"></div>
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('yeterlilik_kaynagi', <?php echo $this->yeterlilik_id;?>)"/>
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

//KAYNAK MESLEK
<?php
$data = $this->onayliStandart;

$r = 'dTables.kaynak_meslek = new Array(new Array("text","","4", "", readOnly),new Array("combo", new Array(new Array("ulusal","Yayınlanmış Meslek Standardı"), new Array("taslak","Taslak Meslek Standardı"), new Array("uluslararasi","Uluslararası Meslek Standardı"),"", "", "200"), "", "getStandart(this.value, this.id)"), new Array("combo", new Array(';
$s = 'new Array ("Seçiniz", "Seçiniz"),';

if(isset($data)){
  foreach ($data as $row){
      $id 	 = $row["STANDART_ID"];
      $value = FormFactory::normalizeVariable ($row["STANDART_ADI"])." - ".FormFactory::normalizeVariable ($row["SEVIYE_ADI"]);
      $s .= 'new Array ("'.$id.'","'.$value.'"),';
  }
}

$s = substr ($s, 0, strlen($s)-1);
$r = $r.$s.'),"comboReq", "", "200"), new Array("text","", "40", "", readOnly) );';
echo $r;
?>
//KAYNAK MESLEK SONU

//KAYNAK BIRIM
<?php
$data = $this->onayliAltBirim;

$r = 'dTables.kaynak_birim = new Array(new Array("text","","4", "", readOnly),new Array("combo", new Array(';
$s = 'new Array ("Seçiniz", "Seçiniz"),';

if(isset($data)){
  foreach ($data as $row){
      $id 	 = $row["YETERLILIK_ALT_BIRIM_ID"];
      $value = FormFactory::normalizeVariable ($row["YETERLILIK_ALT_BIRIM_ADI"])." - ".FormFactory::normalizeVariable ($row["YETERLILIK_ALT_BIRIM_KODU"]);
      $s .= 'new Array ("'.$id.'","'.$value.'"),';
  }
}

$s = substr ($s, 0, strlen($s)-1);
$r = $r.$s.',new Array ("-1","Diğer")),"comboReq", "", "300"), new Array("text","", "60", "", readOnly));';
echo $r;
?>
//KAYNAK BIRIM

function createTables(){
	var tableName = 'kaynak_meslek'; 
	var headers	  = new Array ('Sıra No', 'Meslek Standardı Türü', 'Meslek Standardı Adı', 'Açıklama');
	createTable(tableName, headers);
	patchSatirEkle(tableName,headers,tableName);
	addKaynakMeslekValues (dTables.kaynak_meslek, tableName);

	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 4);
	}

	tableName = 'kaynak_birim'; 
	headers	  = new Array ('Sıra No', 'Yeterlilik Birimi Adı', 'Açıklama');
	createTable(tableName, headers);
	patchSatirEkle(tableName,headers,tableName);
	addKaynakBirimValues (dTables.kaynak_birim, tableName)

	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 3);
	}
}

function addKaynakMeslekValues (meslek, name){
	var length = meslek.length;
	var params = new Array ();
	var arr    = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = meslek[i][0];
	}
	
	<?php
	$data = $this->kaynakMeslek;
	$tableCount = count ($data);
	
	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $data[$i];
		echo 'arr['.$c++.']= "'.($i+1).'";';
	    echo 'arr['.$c++.']= "'.getStandartTur ($arr["KAYNAK_ID"]).'";';
	    echo 'arr['.$c++.']= "'.$arr["KAYNAK_ID"] .'";';
	    echo 'arr['.$c++.']= "'.FormFactory::normalizeVariable ($arr["KAYNAK_ACIKLAMA"]) .'";';
	}
	?>

	if (isset (arr)){
		addTableValues (arr, params, name);
	}
}

function addKaynakBirimValues (birim, name){
	var length = birim.length;
	var params = new Array ();
	var arr    = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = birim[i][0];
	}
	
	<?php
	$data = $this->kaynakBirim;
	$tableCount = count ($data);
	
	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $data[$i];
		echo 'arr['.$c++.']= "'.($i+1).'";';
	    echo 'arr['.$c++.']= "'.$arr["KAYNAK_ID"] .'";';
	    echo 'arr['.$c++.']= "'.FormFactory::normalizeVariable ($arr["KAYNAK_ACIKLAMA"]) .'";';
	}
	?>

	if (isset (arr))
		addTableValues (arr, params, name);
}

function getStandart(val, id){
	var tmp = id.split("-");

	jQuery.ajax({  
		url: "index.php?option=com_yeterlilik_taslak_yeni&task=getStandart&format=raw&standartTur=" + val,  
		dataType: 'json',    
		async: false,  
		success: function(respond){  
			var html = '';
			var meslekComboID = tmp[0]+"-3-"+tmp[2];
			var aciklamaID	  = tmp[0]+"-4-"+tmp[2];
			
			if(respond["result"] == "success"){
				var data = respond["data"];
				html = '<option value="Seçiniz">Seçiniz</option>';
				
				for (var i = 0; i < data.length; i++){
					html += '<option value="'+data[i]['STANDART_ID']+'">'+data[i]['STANDART_ADI']+' - '+data[i]['SEVIYE_ADI']+'</option>';
				}
	
				jQuery("#"+meslekComboID).html(html);
				jQuery("#"+aciklamaID).removeClass('req');
			}else{
				html = '<option value="-1">Diğer</option>';
				jQuery("#"+meslekComboID).html(html); 
				jQuery("#"+meslekComboID).removeClass('comboReq');
				jQuery("#"+aciklamaID).addClass('req');
			} 
		}  
	});
}
</script>

<?php 
function getStandartTur ($standart_id){
	$_db = & JFactory::getOracleDBO();
	
	$sql = "SELECT MESLEK_STANDART_SUREC_DURUM_ID 
			FROM m_meslek_standartlari 
			WHERE standart_id = $standart_id";
	
	$data = $_db->loadResultArray ($sql);
	$reddedilmis = explode(",", REDDEDILMIS_STANDART);
	
	if (isset($data[0])){
		if( $data[0] == RESMI_GAZETEDE_YAYINLANMIS_STANDART){
			return "ulusal";
		}else if(!in_array ($data[0], $reddedilmis)){
			return "taslak";
		}
	}else{
		return "uluslararasi";
	}

}
?>