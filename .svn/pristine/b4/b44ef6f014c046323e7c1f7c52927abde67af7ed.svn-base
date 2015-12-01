<?php 
$editable  = $this->ms_liste_durum;

if ($editable){
	$name  = "Liste Onaylandı";
	$style = 'style="background-color:rgb(100,150,100);color:rgb(255,255,255);height: 35px;"';
}else{
	$name  = "Liste Onaylanmadı";
	$style = 'style="background-color:rgb(170,0,0);color:rgb(255,255,255);height: 35px;"';
}
?>

<form onsubmit="return validate('kurulus_edit_form')"
	  action="index.php?option=com_kurulus_edit&amp;layout=meslek_std_liste&amp;task=standartKaydet&amp;id=<?php echo $this->user_id?>&amp;tur=<?php echo $this->kurulus_tur?>"
	  enctype="multipart/form-data" method="post"
	  id="kurulus_edit_form"
	  name="kurulus_edit_form">

	<?php echo $this->pageTree;?>
	
	<div class="form_item" style="text-align:center; padding-bottom: 15px;">
		<input <?php echo $style;?> value="<?php echo $name;?>" id="duzenleme" name="duzenleme" type="button" onclick="changeEditStatus ()"/>
		<input value="<?php echo $editable;?>" id="editable" name="editable" type="hidden" />
		<div class="cfclear">&nbsp;</div>
	</div>
	
	<div class="form_item">
		<div class="form_element cf_placeholder">
			<div id="meslek_standart_div" style="overflow-x:scroll;overflow-y:hidden;"></div>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>

	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Kaydet" name="kaydet" type="submit" />
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
	
</form>

<script type="text/javascript">

//MESLEK STANDARTLARI
<?php
	$param = array ($this->pm_seviye, $this->pm_sektor);
	$k = '), "comboReq"), new Array("combo", new Array(';
	$r = 'dTables.meslek_standart = new Array( new Array("text", "required", "20"),new Array("textarea", "required","7","22"), new Array("combo", new Array(';
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
	
	$k = '), "comboReq"), new Array("text"),new Array("text"),new Array("text","date","10","date"),new Array("text","date","10","date"));';
	}
	$r .= $p;
	echo $r;
?>
//MESLEK STANDARTLARI SONU

function createTables (){
	var tableName = 'meslek_standart';
	var headers = new Array ('Meslek','Tanımı','Seviye','İlgili Olduğu Sektör', 'Mesleğe ilişkin<br />yasal düzenleme', 'Mevcut meslek <br /> standardı çalışması', 'Standart hazırlama başlangıç tarihi', 'Standart hazırlama bitiş tarihi');
	createTable(tableName, headers);
	patchEkleForDatePick(tableName, new Array ("7", "8"), headers);
	addMeslekValues (dTables.meslek_standart, "meslek_standart");
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

	if (isset (arr)){
		addTableValues (arr, arrId, params, name, true);
	}
}

</script>

<script type="text/javascript">//<![CDATA[
//bu script inputtan sonra konmalı, mümünse en alta </body> den önce
	
var cal = Calendar.setup({
	onSelect: function(cal) { cal.hide() }
});

//]]></script>