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
	<div class="birim_wrapper">
		<div class="gridview_wrapper">
			<div id="container">
				<div>
					<a id="addExistingBirim" href="">Varolan Birim Ekle</a>
				</div>
				<div style="display: none;"	class="existing_birim_wrapper" id="existing_birim_wrapper">
					<div id="existing_birim_container">
						<div class="arama_wrapper">
							Meslek Seviyesi Seçiniz:<br> 
							<select id="existing_seviyeler">
								<?php
								$seviyeler = $this->meslekStandartSeviyeleri;
								echo "<option value='0'>Seçiniz</option>";
								for($i = 0; $i< count($seviyeler); $i++)
								echo "<option value='".$seviyeler[$i]["SEVIYE_ID"]."'>" .$seviyeler[$i]["SEVIYE_ADI"]. "</option>";
								?>
							</select> 
							<br> Meslek Sektörü Seçiniz:<br> 
							
							<select	id="existing_sektorler">
									<?php
									$sektorler = $this->meslekStandartSektorleri;
									echo "<option value='0'>Seçiniz</option>";
									for($i = 0; $i< count($sektorler); $i++)
									echo "<option value='".$sektorler[$i]["SEKTOR_ID"]."'>" .$sektorler[$i]["SEKTOR_ADI"]. "</option>";
									?>
							</select>
						</div>

						<div id="varolanBirimlerContainer" style="display: none;">
							<div style="width: 100%; padding-bottom: 10px;">
								<a style="display: none;" href='' class='varolanBirileriEkleButton'>EKLE</a>
							</div>

							<div style="width: 100%;">
								<table style="display: none; width: 100%;" id="existing_birimler">
									<thead>
										<tr>
											<th>Yeterlilik Adı</th>
											<th>Birim No</th>
											<th>Birim Adı</th>
										</tr>							
									</thead>
									<tbody>
										<tr>
											<td>-</td>
											<td>-</td>
											<td>-</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div style="clear: both;"></div>
							<div style="width: 100%; padding-top: 10px;">
								<a style="display: none;" href='' class='varolanBirileriEkleButton'>EKLE</a>
							</div>
						</div>
					</div>
					
					<div style="clear: both;"></div>
				</div>
				
				<div style="width: 100%; padding-top: 10px;padding-bottom: 10px;">
					<a id="newBirim" href="">Yeni Birim Ekle </a>
				</div>
				
				<div id="birimler_gridview">
					<table style="width: 100%;" id="birimler">
						<thead>
							<tr>
								<th>-</th>
								<th>-</th>
								<th><?php echo JText::_("EDIT_TEXT"); ?></th>
								<th><?php echo JText::_("DELETE_TEXT"); ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>-</td>
								<td>-</td>
								<td><?php echo JText::_("EDIT_TEXT"); ?></td>
								<td><?php echo JText::_("DELETE_TEXT"); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div style="clear: both;"></div>
			</div>
			
			<div style="clear: both;"></div>
		</div>
	</div>

</div>


<br/>
<br/>
<br/>
<hr />

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">Zorunlu Yeterlilik Birimleri</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="kaynak_yeterlilik_zorunlu_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
	<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yukarıdaki Birimler diğer Yeterliliklerden almış olduğunuz Zorunlu Yeterlilik Birimlerini gösterir. Düzenleme Yapabilirsiniz.Yeni Birim oluşturmak için<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yeni Birimler sayfasını kullanınız.<br><br>
</div>
<?php
				$user_browser = browser_detection('browser');
				$rowCount=1;
				$rowClass="";
				$yeterId=$this->yeterlilik_id;
				$sonuclar=getDahiliZorunluBirim($yeterId);
				if (!empty($sonuclar)) { ?>
<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="kaynak_yeterlilik_zorunlu_yeni_div">
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
	<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yukarıdaki Birimler bu Yeterliliğin Birimler sayfasında yeni oluşturduğunuz Zorunlu Yeterlilik Birimlerini gösterir. Düzenlemek için yeni birimler <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;sayfasına gidebilirsiniz.<br><br>
</div>
<?php }?>
<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">Seçmeli Yeterlilik Birimleri</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="kaynak_yeterlilik_secmeli_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
	<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yukarıdaki Birimler diğer Yeterliliklerden almış olduğunuz Seçmeli Yeterlilik Birimlerini gösterir. Düzenleme Yapabilirsiniz. Yeni Birim oluşturmak için<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yeni Birimler sayfasını kullanınız.<br><br>
</div>
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
	
	jQuery('#addExistingBirim').click( function (e) {
	
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
});


function existingVariablesChanged()
{

}
</script>