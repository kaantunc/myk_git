<?php 
$basvuru = $this->basvuru;
?>

<form
	onsubmit="return validate('ChronoContact_meslek_std_basvuru_t1')"
	action="index.php?option=com_meslek_std_basvur&amp;layout=kapsam&amp;task=standartKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_meslek_std_basvuru_t1"
	name="ChronoContact_meslek_std_basvuru_t1">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
echo $this->pageTree;
?>

<div class="form_item">
	<div class="form_element cf_heading">
		<h1 class="contentheading">Meslek Standardı Hazırlama Kapsamı/Planı</h1>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_text"><span class="cf_text">11. Hazırlanması
	düşünülen meslek standartlarını lütfen belirtiniz.</span></div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="meslek_standart_div" style="overflow-x:scroll;overflow-y:hidden;"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_text">
		<span class="cf_text"> *Bu alanda eğer varsa mesleğin farklı seviyeleri seçilecektir. </span>
		<p>
			<span class="cf_text">
				<a	href="http://www.myk.gov.tr/index.php/ayc"
					target="_blank" rel="lyteframe" rev="width:600px; height:500px;">Avrupa Yeterlilik
				Çerçevesi Referans Seviyeleri için tıklayınız... </a>
			</span>
		</p>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_text"><span class="cf_text">12. Bu
	mesleklere ilişkin mevcut durumu ve geleceğe yönelik eğilimleri gösteren
	piyasa çalışması var mıdır? </span></div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea">
	<textarea class="cf_inputbox" rows="5"
		id="text_65" title="" cols="60" name="madde_12"><?php echo $basvuru["PIYASA_ACIKLAMA"]; ?></textarea></div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_text"><span class="cf_text">13. Belirtilmek
	istenen diğer hususlar</span></div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_textarea">
	<textarea class="cf_inputbox" rows="5"
		id="text_65" title="" cols="60" name="madde_13"><?php echo $basvuru["DIGER_HUSUSLAR"]; ?></textarea></div>
	<div class="cfclear">&nbsp;</div>
</div>
<div class="form_item">
	<div class="form_element cf_text"><span class="cf_text">14. Eklenmek istenen belgeler (tanıtım
	broşürü, süreli yayınlar vb.) </span></div>
	<div class="cfclear">&nbsp;</div>
</div>


<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="ekler_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>
<?php
$durum = $this->basvuruDurum;
if($durum[0]['DURUM_ID'] == -1 || $durum[0]['DURUM_ID'] == -2 || $this->ssyetkili == true || $this->evrak_id == -1){
?>	
<div class="form_item" style="padding-top: 25px;">
	<div class="form_element cf_button">
		<input value="Kaydet" name="kaydet" type="submit" />
	</div>
	<div class="cfclear">&nbsp;</div>
</div>
<?php } ?>	
</form>

<script type="text/javascript">

//MESLEK STANDARTLARI
<?php
$param = array ($this->pm_seviye, $this->pm_sektor);
$k = '), "comboReq"), new Array("combo", new Array(';
$r = 'dTables.meslek_standart = new Array( new Array("text", "required uppercase", "30"),new Array("textarea", "required"), new Array("combo", new Array(';
$p = '';

for ($i = 0; $i < count ($param); $i++){
$data = $param[$i];

$s = 'new Array ("Seçiniz", "Seçiniz"),';
if(isset($data)){
    foreach ($data as $row){
        $id	   = $row[0];
        $value = $row[1];
        
        $s .= 'new Array ("'.$id.'","'.FormFactory::normalizeVariable ($value).'"),';
    }
}
$s = substr ($s, 0, strlen($s)-1);


$p .= $s.$k;

$k = '), "comboReq", ""), new Array("text", "", "15"),new Array("text", "", "15"),new Array("text","date","10","date"),new Array("text","date","10","date"));';
}
$r .= $p;
echo $r;
?>
//MESLEK STANDARTLARI SONU

dTables.ekler = new Array(new Array("text", ""), new Array("upload"));

function createTables (){
	var header = new Array ('Meslek','Tanımı','Seviye*','İlgili Olduğu Sektör', 'Mesleğe ilişkin yasal <br />düzenleme var mıdır?', 'Mevcut meslek standardı<br />çalışması<br />var mıdır?', 'Standart hazırlama başlangıç tarihi', 'Standart hazırlama bitiş tarihi');
	var tableName = 'meslek_standart';
	createTable(tableName, header);
	patchEkleForDatePick(tableName, new Array ('7' , '8'), header);
	addMeslekValues (dTables.meslek_standart, "meslek_standart");

	createTable('ekler', new Array ('Açıklama', 'Belge Gönderimi'));
	addEkValues (new Array (new Array("text")), 'ekler');
}

function addMeslekValues (meslek, name){
	var length = meslek.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = meslek[i][0];
	}
	
	<?php
	$data = $this->meslek;
	$tableCount = count ($data);
	
	$c  = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $data[$i];
	
		echo 'arrId['.$id++.']= "'. $arr["STANDART_ID"] .'";';
		
	    echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["STANDART_ADI"]) .'";';
	    echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["STANDART_TANIMI"]) .'";';
	    echo 'arr['.$c++.']= "'. $arr["SEVIYE_ID"] .'";';
	    echo 'arr['.$c++.']= "'. $arr["SEKTOR_ID"] .'";';
	    echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["YASAL_DUZENLEME"]) .'";';
	    echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["MEVCUT_CALISMA"]) .'";';
	    echo 'arr['.$c++.']= "'. $arr["BASLANGIC_TARIHI"] .'";';
	    echo 'arr['.$c++.']= "'. $arr["BITIS_TARIHI"] .'";';
	}
	?>

	if (isset (arr))
		addTableValues (arr, arrId, params, name);
}

function addEkValues (params, name){
	var arr 	 = new Array ();
	var aciklama = new Array ();
	<?php
	$data = $this->ekler;
	$tableCount = count ($data);
	
	$c  = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $data[$i];
		echo 'arr['.$c++.']= "'.FormFactory::normalizeVariable ($arr["BASVURU_EK_ADI"]) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["BASVURU_EK_ID"]) .'";';
		echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["BASVURU_EK_PATH"]) .'";';
		echo 'aciklama['.$i.']= "'. FormFactory::normalizeVariable ($arr["BASVURU_EK_ACIKLAMA"]) .'";';
	}
	
	?>
	if (isset (arr)){
		addTableValues (aciklama, new Array (), params, name);

		for (var i = 0; i < aciklama.length; i++){
			var fileName = arr[i*3];
			var ekId = arr[(i*3)+1];
			var destinationPath = arr[(i*3)+2];
			var id		 = name + "_0";
			var sira	 = i+1;

			var formDiv = document.getElementById(name + "_div");
			var inputPath = document.createElement("input");
			inputPath.setAttribute("type", "hidden");
			inputPath.setAttribute("id", "ek_id_"+sira);
			inputPath.setAttribute("name","ek_id_"+sira);
			inputPath.setAttribute("value", ekId);
			formDiv.appendChild (inputPath);
			
			var resultDiv 	= document.getElementById(id + "_result_div_" + sira);
			var inputPath = '<input type="hidden" value="'+destinationPath+'" name="path_ekler_0_'+sira +'">' +
				 			'<input type="hidden" value="1_'+fileName+'" name="filename_ekler_0_'+sira +'">';
			var result = inputPath + '<div class="up_success">'+fileName+' yüklendi!<\/div>';
			result 	  += '<div><input type="button" value="Değiştir" onclick="removeUploaded(\''+id+'\',\''+sira+'\')" /><\/div>';
			resultDiv.innerHTML = result;
		
			var uploadSpan = document.getElementById(id + "_upload_form_span_" + sira);
			uploadSpan.style.visibility = 'hidden';
			uploadSpan.style.height = 0;
		}
	}
}

</script>

<script type="text/javascript">//<![CDATA[
//bu script inputtan sonra konmalı, mümünse en alta </body> den önce
	
var cal = Calendar.setup({
	onSelect: function(cal) { cal.hide() }
});
jQuery(document).ready(function (){
	
		jQuery(".tarihsecbuton").live("click",function (){
			jQuery('.DynarchCalendar-topCont').animate({
			    left: jQuery(window).width()/2		  
			  }, 100, function() {
			    // Animation complete.
			  });
		});

<?php if($durum[0]['DURUM_ID'] != -1 && $durum[0]['DURUM_ID'] != -2 && $this->ssyetkili != true && $this->evrak_id != -1){?>
	jQuery('input[value="Sil"]').remove();
	jQuery('input[value="Değiştir"]').remove();
	jQuery('#satirEkle_meslek_standart').remove();
	jQuery('#rowNumber-meslek_standart').remove();
	jQuery('#satirEkle_ekler').remove();
	jQuery('#rowNumber-ekler').remove();
<?php } ?>

});
//]]></script>