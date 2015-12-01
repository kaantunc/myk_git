<form
<?php 
$task = "task=taslakKaydet";
echo 'onSubmit = "return validate(\'ChronoContact_yeterlilik_taslak\')"';
echo 'action=index.php?option=com_yeterlilik_taslak_yeni&layout=yeterliligin_yapisi&'.$task.'&yeterlilik_id='.$this->yeterlilik_id;	
?>
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_taslak"
	name="ChronoContact_yeterlilik_taslak">

<?php echo $this->pageTree; ?>

<!-- Yeterliliğin Yapısı -->
<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">YETERLİLİĞİN YAPISI</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_content">
	<div class="birim_wrapper" style="padding-bottom:0px;">
		<div class="gridview_wrapper">
			<div id="container">				
				<div id="birimler_gridview">
					<table style="width: 100%;" id="birimler">
						<thead>
							<tr>
								<th>Sıra No</th>
								<th>Birim Adı</th>
								<th>Zorunlu/Seçmeli</th>
								
							</tr>
						</thead>
						<tbody>
						<?php
						$eklenmisBirim = $this->eklenmisBirim; 
						for ($i=0; $i< count($eklenmisBirim); $i++) {
							
							if($eklenmisBirim[$i]["ZORUNLU"]=="1")
								$zorunluVal = "Zorunlu";
							else if($eklenmisBirim[$i]["ZORUNLU"]=="0")
								$zorunluVal = "Seçmeli";
							else if($eklenmisBirim[$i]["ZORUNLU"]=="-1")
								$zorunluVal = "Belirlenmemiş";
							
							echo '<tr>
								<td>'.$eklenmisBirim[$i]["SIRA_NO"].'</td>
								<td>'.$eklenmisBirim[$i]["BIRIM_ADI"].'</td>
								<td>'.$zorunluVal.'</td>
								
							</tr>';
							
							
						}
						?>
							
						</tbody>
					</table>
				</div>
				
				<div style="clear: both;"></div>
			</div>
			
			<div style="clear: both;"></div>
		</div>
	</div>

</div>




<?php
				$user_browser = browser_detection('browser');
				$rowCount=1;
				$rowClass="";
				$yeterId=$this->yeterlilik_id;
				$sonuclar=getDahiliZorunluBirim($yeterId);
				if (!empty($sonuclar)) { }?>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="kaynak_yeterlilik_secmeli_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
	<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yeni Birim oluşturmak için Birimler sayfasını kullanınız.
</div>
<br>
<hr />
<br>
<?php
				$user_browser = browser_detection('browser');
				$rowCount=1;
				$rowClass="";
				$yeterId=$this->yeterlilik_id;
				$sonuclar=getDahiliSecmeliBirim($yeterId);
				if (!empty($sonuclar)) { ?>
<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="kaynak_yeterlilik_secmeli_yeni_div">
		
		
		<table  cellspacing="0" border="1" width=800>
			<tr class="tablo_header">
				<th width=10>#</th>
				<th class="sortable-numeric" style="font-size:12px;" width=200>Yeterlilik Adı</th>
				<th class="sortable-text" style="font-size:12px; "  width=30>Birim No</th>
				<th class="sortable-text" style="font-size:12px;  " width=500>Birim Adı</th>
			</tr> 
	
			<?php
				
				
				foreach($sonuclar AS $satir){
					
					
					if($rowCount%2==0)
						$rowClass = "even_row";
					else
						$rowClass = "odd_row";
					echo '<tr class="'.$rowClass.'" >';
					
						echo '<td style="font-size:10px;">'.$rowCount.'</td>';
						echo '<td style="font-size:10px;">'.$satir['YETERLILIK_ADI'].'</td>';
						echo '<td>'.$satir['YETERLILIK_ALT_BIRIM_NO'].'</td>';
						echo '<td>'.$satir['YETERLILIK_ALT_BIRIM_ADI'].'</td>';
						
						echo '</tr>';
							$rowCount++;
				
				}
			?>
	

		</table>	
		</div>
	</div>
	<div class="cfclear">&nbsp;</div>
	<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yukarıdaki Birimler bu Yeterliliğin Birimler sayfasında yeni oluşturduğunuz Seçmeli Yeterlilik Birimlerini gösterir. Düzenlemek için yeni birimler<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; sayfasına gidebilirsiniz.<br><br>
</div>
<?php } ?>
<!-- Birimlerin Gruplandırılma Alternatifleri ve İlave Öğrenme Çıktıları -->
<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">11-c) Birimlerin Gruplandırılma Alternatifleri ve İlave Öğrenme Çıktıları</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="form_item">
	<div class="form_element cf_textarea"> 
		<textarea class="cf_inputbox" rows="3"
			id="birimlerin_gruplandirilma" title="" cols="50" name="birimlerin_gruplandirilma"><?php echo $this->taslakYeterlilik["BIRIMLERIN_GRUPLANDIRILMA"] ? $this->taslakYeterlilik["BIRIMLERIN_GRUPLANDIRILMA"] : "";?></textarea>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>
<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">İlave Öğrenme Çıktıları (Varsa)</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="form_item">
	<div class="form_element cf_textarea">
		<textarea class="cf_inputbox" rows="3"
			id="ilave_ogrenme_ciktilari" title="" cols="50" name="ilave_ogrenme_ciktilari"><?php echo $this->taslakYeterlilik["ILAVE_OGRENME_CIKTILARI"] ? $this->taslakYeterlilik["ILAVE_OGRENME_CIKTILARI"] : "";?></textarea>
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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('yeterliligin_yapisi', <?php echo $this->yeterlilik_id;?>)"/>
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

	//KAYNAK YETERLİLİK
<?php
$data = $this->onayliYeterlilik;
//$data2 = $this->yeterlilikTumBirim;
$r = 'dTables.kaynak_yeterlilik_zorunlu = new Array(
												new Array("text","","4", "", readOnly),
												
												new Array("combo", new Array(';
$s = 'new Array ("Seçiniz", "Seçiniz"),';

if(isset($data)){
  foreach ($data as $row){
      $id 	 = $row["YETERLILIK_ID"];
      $value = FormFactory::normalizeVariable ($row["YETERLILIK_ADI"]);
      $s .= 'new Array ("'.$id.'","'.$value.'"),';
  }
}

$s = substr ($s, 0, strlen($s)-1);
$r = $r.$s.',"comboReq", "", "200"),"", "getYetBirim(this.value, this.id)"),

new Array("combo", new Array(';
$s = 'new Array ("Seçiniz", "Seçiniz"),';

/*if(isset($data2)){
  foreach ($data2 as $row2){
      $id 	 = $row2["YETERLILIK_ALT_BIRIM_ID"];
      $value = FormFactory::normalizeVariable ($row2["YETERLILIK_ALT_BIRIM_ADI"]);
      $s .= 'new Array ("'.$id.'","'.$value.'"),';
  }
}*/

$s = substr ($s, 0, strlen($s)-1);
$r = $r.$s.'),"comboReq", "", "200")
);';
echo $r;

$data = $this->onayliYeterlilik;
//$data2 = $this->yeterlilikTumBirim;
$r = 'dTables.kaynak_yeterlilik_secmeli = new Array(
												new Array("text","","4", "", readOnly),
												
												new Array("combo", new Array(';
$s = 'new Array ("Seçiniz", "Seçiniz"),';

if(isset($data)){
  foreach ($data as $row){
      $id 	 = $row["YETERLILIK_ID"];
      $value = FormFactory::normalizeVariable ($row["YETERLILIK_ADI"]);
      $s .= 'new Array ("'.$id.'","'.$value.'"),';
  }
}

$s = substr ($s, 0, strlen($s)-1);
$r = $r.$s.',"comboReq", "", "200"),"300", "getYetBirim(this.value, this.id)"),

new Array("combo", new Array(';
$s = 'new Array ("Seçiniz", "Seçiniz"),';

/*if(isset($data2)){
  foreach ($data2 as $row2){
      $id 	 = $row2["YETERLILIK_ALT_BIRIM_ID"];
      $value = FormFactory::normalizeVariable ($row2["YETERLILIK_ALT_BIRIM_ADI"]);
      $s .= 'new Array ("'.$id.'","'.$value.'"),';
  }
}*/

$s = substr ($s, 0, strlen($s)-1);
$r = $r.$s.'),"comboReq", "", "200")
);';
echo $r;
?>
//KAYNAK YETERLİLİK


								  
function createTables(){
	var tableName = 'kaynak_yeterlilik_zorunlu'; 
	var headers	  = new Array ('Sıra No', 'Yeterlilik Adı', 'Birim Adı');
	createTable(tableName, headers);
	patchSatirEkle(tableName,headers,tableName);
	addKaynakZBirimValues (dTables.kaynak_yeterlilik_zorunlu, tableName);

	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 4);
	}
	var tableName = 'kaynak_yeterlilik_secmeli'; 
	var headers	  = new Array ('Sıra No', 'Yeterlilik Adı', 'Birim Adı');
	createTable(tableName, headers);
	patchSatirEkle(tableName,headers,tableName);
	addKaynakSBirimValues (dTables.kaynak_yeterlilik_secmeli, tableName);

	if (isReadOnly){
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 4);
	}
		
}

function addKaynakZBirimValues (birim, name){
	var length = birim.length;
	var params = new Array ();
	var arr    = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = birim[i][0];
	}
	
	<?php
	$data = $this->yeterlilikZBirim;
	$tableCount = count ($data);
	
	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $data[$i];
		$yetid=getHariciYeterlilik($arr["YETERLILIK_ALT_BIRIM_ID"]);
		echo 'arr['.$c++.']= "'.($i+1).'";';
	    echo 'arr['.$c++.']= "'.$yetid.'";';
	    echo 'arr['.$c++.']= "'.$arr["YETERLILIK_ALT_BIRIM_ID"] .'";';
	   
	}
	?>

	if (isset (arr)){
		addTableValues (arr, params, name);
	}
}

function addKaynakSBirimValues (birim, name){
	var length = birim.length;
	var params = new Array ();
	var arr    = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = birim[i][0];
	}
	
	<?php
	$data = $this->yeterlilikSBirim;
	$tableCount = count ($data);
	
	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $data[$i];
		$yetid=getHariciYeterlilik($arr["YETERLILIK_ALT_BIRIM_ID"]);
		echo 'arr['.$c++.']= "'.($i+1).'";';
	    echo 'arr['.$c++.']= "'.$yetid.'";';
	    echo 'arr['.$c++.']= "'.$arr["YETERLILIK_ALT_BIRIM_ID"] .'";';
	   
	}
	?>

	if (isset (arr)){
		addTableValues (arr, params, name);
	}
}


function getYetBirim(val, id){
	
	var tmp = id.split("-");

	jQuery.ajax({  
		url: "index.php?option=com_yeterlilik_taslak_yeni&task=getYeterlilikBirim&format=raw&yeterlilik_id=" + val,  
		dataType: 'json',    
		async: false,  
		success: function(respond){  
			var html = '';
			var birimComboID = tmp[0]+"-3-"+tmp[2];
			
			
			if(respond["result"] == "success"){
				var data = respond["data"];
				html = '<option value="Seçiniz">Seçiniz</option>';
				
				for (var i = 0; i < data.length; i++){
					html += '<option value="'+data[i]['YETERLILIK_ALT_BIRIM_ID']+'">'+data[i]['YETERLILIK_ALT_BIRIM_ADI']+'</option>';
				}
	
				jQuery("#"+birimComboID).html(html);
				
			}else{
				html = '<option value="-1">Diğer</option>';
				
				
			} 
		}  
	});
	
	
	
	
	
	
	
	
}

</script>

<?php
function getHariciYeterlilik ($birim_id){//Azat
		$_db = &JFactory::getOracleDBO();
		

		$sql= "SELECT YETERLILIK_ID  
			   FROM m_yeterlilik_alt_birim_yeni 
			   WHERE yeterlilik_alt_birim_id = ?";
			
		$params = array ($birim_id);
		
		$data = $_db->prep_exec($sql, $params);
		
		
		foreach($data AS $satir){
		
			$yetId=$satir['YETERLILIK_ID'];
		}
		
			return $yetId;
		
	}
function getDahiliZorunluBirim ($yeterlilik_id){//Azat
		$_db = &JFactory::getOracleDBO();
		

		$sql= "SELECT m_yeterlilik.yeterlilik_adi,
		m_yeterlilik_alt_birim_yeni.yeterlilik_alt_birim_no,
		m_yeterlilik_alt_birim_yeni.yeterlilik_alt_birim_adi  
		FROM m_yeterlilik_alt_birim_yeni,m_yeterlilik 
		WHERE m_yeterlilik.yeterlilik_id=m_yeterlilik_alt_birim_yeni.yeterlilik_id and m_yeterlilik_alt_birim_yeni.yeterlilik_id = ? and m_yeterlilik_alt_birim_yeni.yeterlilik_zorunlu<>1";
			
		$params = array ($yeterlilik_id);
		
		$sonuclar = $_db->prep_exec($sql, $params);
		return $sonuclar;
		
	}
function getDahiliSecmeliBirim ($yeterlilik_id){//Azat
		$_db = &JFactory::getOracleDBO();
		

		$sql= "SELECT m_yeterlilik.yeterlilik_adi,
		m_yeterlilik_alt_birim_yeni.yeterlilik_alt_birim_no,
		m_yeterlilik_alt_birim_yeni.yeterlilik_alt_birim_adi  
		FROM m_yeterlilik_alt_birim_yeni,m_yeterlilik 
		WHERE m_yeterlilik.yeterlilik_id=m_yeterlilik_alt_birim_yeni.yeterlilik_id and m_yeterlilik_alt_birim_yeni.yeterlilik_id = ? and m_yeterlilik_alt_birim_yeni.yeterlilik_zorunlu=1";
			
		$params = array ($yeterlilik_id);
		
		$sonuclar = $_db->prep_exec($sql, $params);
		return $sonuclar;
		
	}
?>


<script type="text/javascript">
jQuery(document).ready(function() {	
	var existingStandartHidden = 1;

	//BIRIMLER
	var oTableBirim = jQuery('#birimler').dataTable({
    	"oLanguage": {
			"sLengthMenu": "<?php echo JText::_("LENGTH_MENU");?>",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "<?php echo JText::_("INFO");?>",
			"sInfoEmpty": "<?php echo JText::_("INFO_EMPTY");?>",
			"sInfoFiltered": "<?php echo JText::_("INFO_FILTERED");?>",
			"sSearch": "<?php echo JText::_("SEARCH");?>",
			"oPaginate": {
				"sFirst":    "<?php echo JText::_("FIRST");?>",
				"sPrevious": "<?php echo JText::_("PREVIOUS");?>",
				"sNext":     "<?php echo JText::_("NEXT");?>",
				"sLast":     "<?php echo JText::_("LAST");?>"
			}
		}
    }); 

	//VAROLAN BIRIMLER ARAMA GRIDVIEW
    var oTableVarolanBirim = jQuery('#existing_birimler').dataTable({
    	"oLanguage": {
			"sLengthMenu": "<?php echo JText::_("LENGTH_MENU");?>",
			"sZeroRecords": "<?php echo JText::_("ZERO_RECORDS");?>",
			"sInfo": "<?php echo JText::_("INFO");?>",
			"sInfoEmpty": "<?php echo JText::_("INFO_EMPTY");?>",
			"sInfoFiltered": "<?php echo JText::_("INFO_FILTERED");?>",
			"sSearch": "<?php echo JText::_("SEARCH");?>",
			"oPaginate": {
				"sFirst":    "<?php echo JText::_("FIRST");?>",
				"sPrevious": "<?php echo JText::_("PREVIOUS");?>",
				"sNext":     "<?php echo JText::_("NEXT");?>",
				"sLast":     "<?php echo JText::_("LAST");?>"
			}
		}
		 
    });
	
	jQuery('#addExistingBirimTogglerButton').click( function (e) {
	
		if(existingStandartHidden==0)//gizli değilse gizle
		{
			jQuery('#existing_birimler').hide();
			jQuery('#existing_birim_wrapper').hide();
	
			var oTableVarolanBirim = jQuery('#existing_birimler').dataTable();
			oTableVarolanBirim.fnClearTable();
	
			existingStandartHidden = 1;
		}
		else // zaten gizliyse göster
		{
			jQuery('#existing_birim_wrapper').show();
			jQuery('#existing_birimler').show();
			existingStandartHidden = 0;
			existingVariablesChanged();
		}
	
		// Stop event handling in IE
		return false;
	} );

	jQuery('#newBirimTogglerButton').click( function (e) {

		jQuery('#new_birim_wrapper').toggle();
	} );

	



	
});


function existingVariablesChanged()
{

}


var popupName = 'biriminDetaylariPopupDiv';
var rowClass = "tablo_header_acik ogrenmeCiktisiRow";
var rowName = 'ogrenmeCiktisiRow'; 

var basarimOlcutuTDClass = 'ogrenmeCiktisininBasarimOlcutuDataTD';
var basarimOlcutuNumaralariTDClass = 'ogrenmeCiktisininBasarimOlcutuNumaralariTD';

var ogrenmeCiktisiTDClass = 'ogrenmeCiktisiDataTD';
var ogrenmeCiktisiTDName = 'ogrenmeCiktisiDataTD';

var ogrenmeCiktisiNumaralariTDClass = 'ogrenmeCiktisiNumaralariTD';
var ogrenmeCiktisiNumaralariTDName = 'ogrenmeCiktisiNumaralariTD';

var ogrenmeCiktisiSilButtonName = 'ogrenmeCiktisiSilButton';
var basarimOlcutuSilButtonName = 'basarimOlcutuSilButton';

var basarimOlcutuNumaralariDivClass = 'ogrenmeCiktisininBasarimOlcutuNumaralariDiv';


jQuery('.ogrenmeCiktisiEkleButton').live("click",  function (e) {

	var buttonName = 'ogrenmeCiktisiEkleButton';
	var popupIDsi = this.id.substr(buttonName.length+1);
	var ogrenmeCiktisiNumarasi = jQuery('#ogrenmeCiktisiCountHF-'+popupIDsi).val();

	//jQuery('#ogrenmeCiktisiCountHF-'+popupIDsi).val(parseInt(jQuery('#ogrenmeCiktisiCountHF-'+popupIDsi).val())+1);

	yeniOgrenmeCiktisiEkle2(popupIDsi, parseInt(ogrenmeCiktisiNumarasi)+1, "", "");		
	return false;
});

function yeniOgrenmeCiktisiEkle2(popupIdsi, ogrenmeCiktisiNumarasi, ogrenmeCiktisiText, ogrenmeCiktisiBaglamiText)
{

var popupName = 'biriminDetaylariPopupDiv';
var rowClass = "tablo_header_acik ogrenmeCiktisiRow";
var rowName = 'ogrenmeCiktisiRow'; 

var basarimOlcutuTDClass = 'ogrenmeCiktisininBasarimOlcutuDataTD';
var basarimOlcutuNumaralariTDClass = 'ogrenmeCiktisininBasarimOlcutuNumaralariTD';

var ogrenmeCiktisiTDClass = 'ogrenmeCiktisiDataTD';
var ogrenmeCiktisiTDName = 'ogrenmeCiktisiDataTD';

var ogrenmeCiktisiNumaralariTDClass = 'ogrenmeCiktisiNumaralariTD';
var ogrenmeCiktisiNumaralariTDName = 'ogrenmeCiktisiNumaralariTD';

var ogrenmeCiktisiSilButtonName = 'ogrenmeCiktisiSilButton';

var satir='<tr class="' + rowClass + '" id="'+rowName+'-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'-1">'
+    '<td class="'+ogrenmeCiktisiNumaralariTDClass+'" style="width:4%;" id="'+ogrenmeCiktisiNumaralariTDName+'-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'">'
+		'<div id="ogrenmeCiktisiNumaralasiDiv-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'">'+ogrenmeCiktisiNumarasi+'</div>'
+	    '<br><input type="button" id="'+ogrenmeCiktisiSilButtonName+'-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'" value="Sil" class="'+ogrenmeCiktisiSilButtonName+'">'
+ 	 '</td>'
+    '<td class="'+ogrenmeCiktisiTDClass+'" style="padding:10px; width:46%;" id="'+ogrenmeCiktisiTDName+'-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'">'
+		 'Öğrenme Çıktısı:'
+ 		 '<br><textarea style="width:80%;" name="ogrenmeCiktisi['+popupIdsi+']['+ogrenmeCiktisiNumarasi+']" id="ogrenmeCiktisi-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'" rows="5">'+ogrenmeCiktisiText+'</textarea>'
+	 	 '<br>Öğrenme Çıktısı Bağlamı:'
+ 		 '<br><textarea style="width:80%;" name="ogrenmeCiktisiBaglami['+popupIdsi+']['+ogrenmeCiktisiNumarasi+']" id="ogrenmeCiktisiBaglami-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'">'+ogrenmeCiktisiBaglamiText+'</textarea>'
+ 		 '<br><input type="button" class="yeniBasarimOlcutuEkleButton" id="yeniBasarimOlcutuEkleButton-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'" value="Yeni Başarım Ölçütü Ekle >>">'
+ 	 '</td>'
+  	 '<td class="'+basarimOlcutuNumaralariTDClass+'" style="width:4%;" id="'+basarimOlcutuNumaralariTDClass+'-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'-1">&nbsp;</td>'
+    '<td class="'+basarimOlcutuTDClass+'-'+ popupIdsi+ '-1" style="padding:10px; width:46%;" id="'+basarimOlcutuTDClass+'-'+popupIdsi+'-'+ogrenmeCiktisiNumarasi+'-1">'
+ 	 	'Başarım Ölçütü Eklenmemiş'
+ 	 '</td>'
+'</tr>';

jQuery(jQuery('#'+popupName+'-'+popupIdsi+' tr.'+rowName)[jQuery('#'+popupName+'-'+popupIdsi+' tr.'+rowName).length-1]).after(satir);

jQuery('#ogrenmeCiktisiCountHF-'+popupIdsi).val(parseInt(jQuery('#ogrenmeCiktisiCountHF-'+popupIdsi).val())+1);

var kacOgrenmeCiktisiEklenmis = parseInt(jQuery('#ogrenmeCiktisiCountHF-'+popupIdsi).val());
jQuery('#biriminDetaylariPopupDiv-'+popupIdsi).append('<input id="ogrenmeCiktisininBasarimOlcutleriCountHF-'+popupIdsi+'-'+kacOgrenmeCiktisiEklenmis+'" value="0" type="hidden" >');

}

function yeniBasarimOlcutuEkle2(popupIdsi, rowIDsi, basarimOlcutuText, basarimOlcutuBaglamiText )
{
// rowIDsi - > hangi rowun altına ekleyeceği  id = ogrenmeCiktisiRow-49-3 gibisinden
var popupName = 'biriminDetaylariPopupDiv';
var rowClass = "tablo_header_acik ogrenmeCiktisiRow";
var rowName = 'ogrenmeCiktisiRow'; 

var basarimOlcutuTDClass = 'ogrenmeCiktisininBasarimOlcutuDataTD';
var basarimOlcutuNumaralariTDClass = 'ogrenmeCiktisininBasarimOlcutuNumaralariTD';

var basarimOlcutuNumaralariDivClass = 'ogrenmeCiktisininBasarimOlcutuNumaralariDiv';


var ogrenmeCiktisiTDClass = 'ogrenmeCiktisiDataTD';
var ogrenmeCiktisiTDName = 'ogrenmeCiktisiDataTD';

var ogrenmeCiktisiNumaralariTDClass = 'ogrenmeCiktisiNumaralariTD';
var ogrenmeCiktisiNumaralariTDName = 'ogrenmeCiktisiNumaralariTD';

var ogrenmeCiktisiSilButtonName = 'ogrenmeCiktisiSilButton';

var rowElement = jQuery('#'+rowName+'-'+popupIdsi+'-'+rowIDsi+'-1'); 
var textAreaElements = jQuery('#'+basarimOlcutuTDClass+'-'+popupIdsi+'-'+rowIDsi+'-1 textarea');


var kacOgrenmeCiktisiEklenmis = parseInt(jQuery('#ogrenmeCiktisiCountHF-'+popupIdsi).val());
var kacBasarimOlcutuEklenmis = parseInt(jQuery('#ogrenmeCiktisininBasarimOlcutleriCountHF-'+popupIdsi+'-'+rowIDsi).val());
if(isNaN(kacBasarimOlcutuEklenmis))
	kacBasarimOlcutuEklenmis = 0;

if(textAreaElements.length == 0)
{	
	jQuery('#'+basarimOlcutuNumaralariTDClass+'-'+popupIdsi+'-'+rowIDsi+'-1').html(
			'<div id="'+basarimOlcutuNumaralariDivClass+'-'+popupIdsi+'-'+rowIDsi+'-1">'
			+ jQuery('#'+ogrenmeCiktisiNumaralariTDName+'-'+popupIdsi+'-'+rowIDsi).text()+".1"
			+ '</div>'
			+ '<br /><input type="button" id="basarimOlcutuSilButton-'+popupIdsi+'-'+rowIDsi+'-1" value="Sil" class="basarimOlcutuSilButton">'
	);

	var basarimOlcutuTextAreaHTML = 'Başarım Ölçütü:'
	+ '<br>'
	+ '<textarea style="width:80%" id="basarimOlcutu-'+popupIdsi+'-'+rowIDsi+'-1" name="basarimOlcutu['+popupIdsi+']['+rowIDsi+'][]" rows="5" >'+basarimOlcutuText+'</textarea>'
	+ '<br>Başarım Ölçütü Bağlamı:'
	+ '<br><textarea style="width:80%" id="basarimOlcutuBaglami-'+popupIdsi+'-'+rowIDsi+'-1"  name="basarimOlcutuBaglami['+popupIdsi+']['+rowIDsi+'][]" rows="5" >'+basarimOlcutuBaglamiText+'</textarea>'
	;

	jQuery('#'+basarimOlcutuTDClass+'-'+popupIdsi+'-'+rowIDsi+'-1').html(basarimOlcutuTextAreaHTML);

	jQuery('#ogrenmeCiktisininBasarimOlcutleriCountHF-'+popupIdsi+'-'+rowIDsi).val("1");

}
else
{
	var hiddenFieldName = 'ogrenmeCiktisininBasarimOlcutleriCountHF';
	
	var rowSpanValue = parseInt(jQuery('#'+ogrenmeCiktisiNumaralariTDName+'-'+popupIdsi+'-'+rowIDsi).attr("rowspan"));
	if(isNaN(rowSpanValue)) rowSpanValue = 1;
	var newRowSpanValue = ""+(rowSpanValue+1);
	
	var yeniEklenecekBasariOlcutununNumarasi = kacBasarimOlcutuEklenmis +1;
	var rowText = '<tr id="'+rowName+'-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" class="'+rowClass+'">'
	+ '<td id="'+basarimOlcutuNumaralariTDClass+'-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" style="width:4%;" class="'+basarimOlcutuNumaralariTDClass+'">'
	+ '<div id="'+basarimOlcutuNumaralariDivClass+'-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'">'
	+rowIDsi+'.'+yeniEklenecekBasariOlcutununNumarasi
	+'</div><br>'
	+ '<input type="button" class="basarimOlcutuSilButton" value="Sil" id="basarimOlcutuSilButton-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'"></td>'
	+ '<td id="'+basarimOlcutuTDClass+'-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" style="padding:10px; width:46%;" class="'+basarimOlcutuTDClass+'-'+popupIdsi+'-'+rowIDsi+'">'
	+ 'Başarım Ölçütü:<br>'
	+ '<textarea rows="5" id="basarimOlcutu-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" name="basarimOlcutu['+popupIdsi+']['+rowIDsi+'][]" style="width:80%">'+basarimOlcutuText+' </textarea>'
	+ '<br>Başarım Ölçütü Bağlamı:<br>'
	+ '<textarea rows="5" id="basarimOlcutuBaglami-'+popupIdsi+'-'+rowIDsi+'-'+yeniEklenecekBasariOlcutununNumarasi+'" name="basarimOlcutuBaglami['+popupIdsi+']['+rowIDsi+'][]" style="width:80%">'+basarimOlcutuBaglamiText+'</textarea>'
	+ '</td>'
	+ '</tr>';

	
	jQuery('#'+rowName+'-'+popupIdsi+'-'+rowIDsi+'-'+kacBasarimOlcutuEklenmis).after(rowText);
	jQuery('#'+ogrenmeCiktisiNumaralariTDName+'-'+popupIdsi+'-'+rowIDsi).attr("rowspan", newRowSpanValue);
	jQuery('#'+ogrenmeCiktisiTDName+'-'+popupIdsi+'-'+rowIDsi).attr("rowspan", newRowSpanValue);
	
}


jQuery('#'+hiddenFieldName+'-'+popupIdsi+'-'+rowIDsi).val(kacBasarimOlcutuEklenmis+1);

return true;
}


</script>