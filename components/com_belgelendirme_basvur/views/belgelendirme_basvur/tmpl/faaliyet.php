<?php 
$basvuru = $this->basvuru;
$durum = $this->durum;
$faaliyet = $this->faaliyet;

$YetOption = '<option value="0">Seçiniz</option>';
foreach($this->pm_yeterlilik_ad as $row){
    $YetOption .= '<option value="'.$row['YETERLILIK_ID'].'">'.$row['YETERLILIK_ADI'].' ('.$row['YETERLILIK_KODU'].') (Revizyon: '.$row['REVIZYON'].')</option>';
}
?>
<style>
.tdPad5>tr>td{
    padding: 5px;
}
.thPad5>tr>th{
    padding: 5px;
}
</style>
<form
	onsubmit="return validate('ChronoContact_belgelendirme_basvuru_t3')"
	action="index.php?option=com_belgelendirme_basvur&amp;layout=faaliyet&amp;task=belgelendirmeKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_belgelendirme_basvuru_t3"
	name="ChronoContact_belgelendirme_basvuru_t3">
	
<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
echo '<h2><u>'.$this->kurulus['KURULUS_ADI'].' Sınav ve Belgelendirme Başvuru Formu</u></h2>';
echo $this->pageTree;
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">5. Faaliyet gösterdiği sektör(ler)[1] </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_placeholder">
	<div id="sektor_div"></div>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">6. Faaliyet alanları </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<!-- 6. bölüm faaliyet alanları kısmı paragraf şeklinde olsun, tek bir alan yeterli: -->
<div class="form_item">
  <div class="form_element cf_textarea">
    <textarea class="cf_inputbox" rows="5" 
    	id="inputfaaliyet-1" title="" cols="100" name="inputfaaliyet-1"><?php echo $faaliyet? $faaliyet[0]["FALIYET_ALAN_ADI"] : "" ; ?></textarea>
    	  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<!--<div class="form_item">
  <div class="form_element cf_placeholder"><div id="faaliyet_div">
</div></div>
  <div class="cfclear">&nbsp;</div>
</div>-->

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">7. Faaliyet süresi </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_radiobutton">
	<div class="float_left"><?php 
	$data = $this->pm_faaliyet_sure;
	
	if(isset($data)){
		$i = 0;
		$name = "radio0";
		foreach ($data as $row){
			$checked = "";
			if ($row[0] == $basvuru["FALIYET_SURE_ID"])
				$checked = "checked";
				
			echo '<input '.$checked.' value="'.$row[0].'" title="" class="radio" id="'.$name.$i.'" name="'.$name.'" type="radio" /> 
				  <label for="'.$name.$i.'" class="radio_label">'.$row[1].'</label><br />';
			$i++;
		}
	}
	?></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>


<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">8.	Sınav ve belgelendirme süreçlerinde görev alacak personel sayısı </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_text"> <span class="cf_text">a) Toplam Personel Sayısı</span> </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_textbox">
    <input class="cf_inputbox numeric" maxlength="150" size="5"  
    	id="personel_sayisi" name="personel_sayisi" type="text" value = "<?php echo $basvuru["PERSONEL_SAYISI"]; ?>"/>
  
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_text"> <span class="cf_text">b) Görevlendirilecek ekipteki kişi sayısı</span> </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_textbox">
    <input class="cf_inputbox numeric" maxlength="150" size="5"  
    	id="ekip_sayisi" name="ekip_sayisi" type="text" value = "<?php echo $basvuru["EKIP_SAYISI"]; ?>"/>
  
  </div>
  <div class="cfclear">&nbsp;</div>
</div>


<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">9. Kuruluşun sınav ve belgelendirme faaliyetlerine ve yetkilendirilme talebine ilişkin bilgiler</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_text"> 
		<span class="cf_text">a) Sınav ve belgelendirme yapılan yeterlilikler, kuruluşun sınav ve belgelendirme faaliyetlerine ne zaman başladığı ve sürekliliği, bir yılda alınan ortalama başvuru, yapılan sınav ve verilen belge sayıları gibi kuruluşun faaliyetlerini açıklayan bilgiler</span> 
	</div>
  	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_textarea">
    <textarea class="cf_inputbox" rows="5" 
    	id="text_37" title="" cols="100" name="madde_7a"><?php echo $basvuru["KURULUS_TALEP_ACIKLAMA"];?></textarea>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_text" > 
		<span class="cf_text">b) Yetki talep edilen yeterlilik(ler)</span> 
	</div>
  	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_placeholder">
      <div id="TalepEdilen" style="overflow: auto">
          <table style="width: 100%">
              <thead class="tablo_header thPad5">
                <tr>
                    <th width="50%">Yeterliliğin Adı</th>
                    <th width="20%">Başvuru tarihine kadar verilmiş belge sayısı</th>
                    <th width="20%">Başvuru tarihine kadar gerçekleştirilmiş sınav sayısı</th>
                    <th width="10%">Sil</th>
                </tr>
              </thead>
              <tbody id="YetTbody" class="tdPad5">
              <?php
              $say = 0;
              foreach($this->yetkiTalep as $row){
                  $say++;
                  $bgcolor = '';
                  if($say%2 == 0){
                      $bgcolor = 'bgcolor="#F0F0FA"';
                  }
                  echo '<tr '.$bgcolor.' id="'.$this->evrak_id.'_'.$row['YETERLILIK_ID'].'">';
                  echo '<td>'.$row['YETERLILIK_ADI'].'('.$row['YETERLILIK_KODU'].') (Revizyon: '.$row['REVIZYON'].')'.'</td>';
                  echo '<td align="center">'.$row['VERILEN_BELGE'].'</td>';
                  echo '<td align="center">'.$row['YAPILAN_SINAV'].'</td>';
                  if($this->canEdit || ($durum == 0 || $durum == 2 || $durum == 6 || $durum == 10 || $durum == 14)){
                      echo '<td align="center"><input type="button" onclick="FuncYetkiTalepYetSil('.$this->evrak_id.','.$row['YETERLILIK_ID'].')" value="Sil"></td>';
                  }else{
                      echo '<td></td>';
                  }

                  echo '</tr>';
              }
              ?>
              </tbody>
          </table>
      </div>
      <?php if($this->canEdit || ($durum == 0 || $durum == 2 || $durum == 6 || $durum == 10 || $durum == 14)){ ?>
      <div><input type="button" class="btn btn-xs btn-primary" id="YetSatirEkle" value="Yeni Satır Ekle"/></div>
      <?php } ?>
      <div class="cfclear">&nbsp;</div>
  	<div id="yetkiTalep_div" style="overflow-x: auto;"></div>
  </div>
  
  <div class="cfclear">&nbsp;</div>
</div>

<?php if($durum == 0 || $durum == 2 || $durum == 6 || $durum == 10 || $durum == 14){ ?>
<div class="form_item" style="padding-top: 25px;">
	<div class="form_element cf_button">
		<input value="Kaydet" name="kaydet" type="submit" />
	</div>
	<div class="cfclear">&nbsp;</div>
</div>
<?php }
else if($this->canEdit){
?>
<div class="form_item" style="padding-top: 25px;">
	<div class="form_element cf_button">
		<input value="Kaydet" name="kaydet" type="submit" />
	</div>
	<div class="cfclear">&nbsp;</div>
</div>
<?php   
}?>

<br>
<hr>
<div class="form_item" style="padding-top: 25px; font-style:italic;">
	<p>[1]-Sektor listesine http://www.myk.gov.tr/page.php?page=msd3 adresinden ulaşabilir.</p>
	<div class="cfclear">&nbsp;</div>
</div>

</form>

<script type="text/javascript">
var YetStatir = '<tr>';
YetStatir += '<td><select name="inputyetkiTalep-1[]" class="input-sm"><?php echo $YetOption; ?></select></td>';
YetStatir += '<td><input type="text" name="inputyetkiTalep-2[]" size="25" class="numeric"></td>';
YetStatir += '<td><input type="text" name="inputyetkiTalep-3[]" size="25" class="numeric"></td>';
YetStatir += '<td><input type="button" class="btn btn-xs btn-danger YetSil" value="Sil"/></td>';
YetStatir += '</tr>';

jQuery(document).ready(function(){
    jQuery('#YetTbody .YetSil').live('click',function(e){
        e.preventDefault();
        jQuery(this).closest('tr').remove();
    });

    jQuery('#YetSatirEkle').live('click',function(e){
        e.preventDefault();
        jQuery('#YetTbody').append(YetStatir);
    });
});

function FuncYetkiTalepYetSil(eId,yId){
    if(confirm('Yetki Talebini Silmek İstediğinizden Emin misiniz?')){
        jQuery.ajax({
            async:false,
            type:'POST',
            url:'index.php?option=com_belgelendirme_basvur&task=AjaxYetTalepSil&format=raw',
            data:'eId='+eId+'&yId='+yId
        }).done(function(data){
            var dat = jQuery.parseJSON(data);
            if(dat){
                jQuery('#YetTbody tr#'+eId+'_'+yId).remove();
                alert('Yetki Talebi Başarıyla Silindi.');
            }else{
                alert('Bir hata meydana geldi. Lütfen tekrar deneyin.');
            }
        });
    }
}

//SEKTORLER
<?php
$data = $this->pm_sektor;

$r = 'dTables.sektor = new Array( new Array("combo", new Array(';
$s = 'new Array ("Seçiniz", "Seçiniz"),';

if(isset($data)){
  foreach ($data as $row){
      $id = $row[0];
      $value = $row[1];
      $s .= 'new Array ("'.$id.'","'.$value.'"),';
  }
}

$s = substr ($s, 0, strlen($s)-1);
$r = $r.$s.'),"comboReq"), new Array ("text", "", "65"));';
echo $r;
?>
//SEKTORLER SONU

//YETKI TALEP
<?php
$r = 'dTables.yetkiTalep = new Array( new Array("combo", new Array (';
$k ='new Array("text", "numeric"),new Array("text", "numeric"));';
$data = $this->pm_yeterlilik_ad;

$s = 'new Array ("Seçiniz", "Seçiniz"),';
$yetAdi = "";
if(isset($data)){
    foreach ($data as $row){
        //if ($row[1] != $yetAdi){
        	$s .= 'new Array ("'.FormFactory2::normalizeVariable ($row[0]).'","'.FormFactory2::normalizeVariable ($row[1].' ('.$row[2].')').($row[3] <> '' ? '  (REVİZYON : '.$row[3].')' : '').'"),';
    		//$yetAdi = $row[1].' ('.$row[2].')';
    	//}
    }
}

$s = substr ($s, 0, strlen($s)-1);
$r .= $s.'),""),'.$k;
echo $r;
?>
// YETKI TALEP SONU
dTables.faaliyet = new Array(new Array("text", "required", "80"));

function createTables(){
	var tableName = "sektor";
	createTable( tableName, new Array ('Faaliyet Gösterdiği Sektör(ler)', 'Açıklama'));
	addSektorValues (dTables.sektor, tableName);

//	tableName = "faaliyet";
//	createTable(tableName, new Array ('Faaliyet Alanları'));
//	addFaaliyetValues (dTables.faaliyet, tableName);

	tableName = "yetkiTalep";
	/*createTable(tableName , new Array('Yeterliliğin Adı',
                                	  
 									  'Başvuru tarihine kadar<br />verilmiş belge sayısı',
									  'Başvuru tarihine kadar<br />gerçekleştirilmiş sınav sayısı'));

	addYetkiTalepValues (dTables.yetkiTalep, tableName);*/
}

function addSektorValues (sektor, name){
	var length = sektor.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = sektor[i][0];
	}
	
	<?php
	$data = $this->sektor;
	$tableCount = count ($data);
	
	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $data[$i];
		echo 'arrId['.$id++.']= "'. $arr["SEKTOR_ID"] .'";';
		
	    echo 'arr['.$c++.']= "'. $arr["SEKTOR_ID"] .'";';
	    echo 'arr['.$c++.']= "'. FormFactory2::normalizeVariable ($arr["SEKTOR_ACIKLAMA"]) .'";';
	}
	?>

	if (isset (arr))
		addTableValues (arr,arrId, params, name);
}

//function addFaaliyetValues (faaliyet, name){
//	var length = faaliyet.length;
//	var params = new Array ();
//	var arr    = new Array ();
//	var arrId  = new Array ();
	
//	for (var i = 0; i < length; i++){
//		params[i] = faaliyet[i][0];
//	}
	
//	< ?php
//	$data = $this->faaliyet;	
//	$tableCount = count ($data);
	
//	$c = 0;
//	$id = 0;
//	for ($i=0; $i< $tableCount; $i++) {
//		$arr = $data[$i];
	
//		echo 'arrId['.$id++.']= "'. $arr["FALIYET_ALAN_ID"] .'";';
//	    echo 'arr['.$c++.']= "'. FormFactory2::normalizeVariable ($arr["FALIYET_ALAN_ADI"]) .'";';
//	}
//	?>

//	if (isset (arr))
//		addTableValues (arr, arrId, params, name);
//}

function addYetkiTalepValues (yetkiTalep, name){
	var length = yetkiTalep.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	var arrSeviyeId = new Array(); ///
	
	for (var i = 0; i < length; i++){
		params[i] = yetkiTalep[i][0];
	}
	
	<?php
	$data = $this->yetkiTalep;
	$tableCount = count ($data);
	
	$c = 0;
	$id = 0;
	$sId = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $data[$i];
	
		echo 'arrId['.$id++.']= "'.$arr["YETERLILIK_ID"] .'";';
		
	    echo 'arr['.$c++.']= "'. FormFactory2::normalizeVariable ($arr["YETERLILIK_ADI"]).' ('.FormFactory2::normalizeVariable ($arr["YETERLILIK_KODU"]).')' .'";';
	    
	    //echo 'arr['.$c++.']= "'. FormFactory2::normalizeVariable ($arr["YETERLILIK_KODU"])  .'";';
	    echo 'arr['.$c++.']= "'. FormFactory2::normalizeVariable ($arr["VERILEN_BELGE"])  .'";';
	    echo 'arr['.$c++.']= "'. FormFactory2::normalizeVariable ($arr["YAPILAN_SINAV"])  .'";';
	}
	?>

	if (isset (arr)){
		addYetkiTalepTableValues (arr, arrId, arrSeviyeId, params, name);
	}
}

function addYetkiTalepTableValues (arr, arrId, arrSeviyeId, params, name){
	var colCount = params.length;
	var arrLength = arr.length;
	var rowNumber = (arrLength/colCount)-1;

	for (var sayy = 0; sayy < rowNumber; sayy++)
		document.getElementById ("satirEkle_"+name).onclick();
	
	//Add the values to table
	var count = 0;
	var sayy = 0;
	for (var i = 0, m = 0; count < arrLength; i++, m++){
		var elementId =  name+(i+1);
		
		var idInp = document.createElement("input");
		idInp.setAttribute("type", "hidden");
		idInp.setAttribute("id", elementId);
		idInp.setAttribute("name", name+"[]");
		idInp.setAttribute("value", arrId [i]);
		
		var mainDiv = document.getElementById(name + "_div");
		mainDiv.appendChild(idInp);
		
		for (var j = 0; j < colCount; j++){ 
			var item = document.getElementById ('input'+name+'-'+(j+1)+'-'+(i+1));
			
		    if (params[j] == "text"){
		    	item.value = arr[count];
		    }else if (params[j] == "combo"){
		    	for (var k = 0; k < item.options.length; k++){
			    	// Burada arr[count] yeterlilik adi olarak geliyor dolayisiyla .value degil .text ile karsilastirilmali:
		    		// if(item.options[k].value == arr[count])
		        	if(item.options[k].value == arrId[sayy]){
		        		item.options[k].selected = "\"selected\"";
		        		sayy++;
		        		break;
		        	}
		        }
				if (j == 1){
					// arr[count]'tan seviye adı geliyor. Seviye Id'yi gondermelıyız:
					//item.options[0]= new Option(arr[count], arr[count], true, true);
					item.options[0]= new Option(arr[count], arrSeviyeId[m], true, true);
				}else if (j == 2){
					item.options[0]= new Option(arr[count], arrId[i], true, true);
				}

		    }
		    count++;  
		}
	}
}

function xmlhttpPost(checkFunction, strURL, getQueryStringFunction, updatePageFunction, comboObj) {
    var id = comboObj.id;
    var splitArr = id.split ("-");
    var lineNo = splitArr[(splitArr.length-1)];

	if(!checkFunction())
		return;
	var xmlHttpReq = false;
	var self = this;
	// Mozilla/Safari
	if (window.XMLHttpRequest) {
		self.xmlHttpReq = new XMLHttpRequest();
	}
	// IE
	else if (window.ActiveXObject) {
		self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
	}
	self.xmlHttpReq.open('POST', strURL, true);
	self.xmlHttpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	self.xmlHttpReq.onreadystatechange = function() {
		if (self.xmlHttpReq.readyState == 4) {
			var str = self.xmlHttpReq.responseText;
			updatePageFunction(str, lineNo);
		}
	};
	self.xmlHttpReq.send(getQueryStringFunction(lineNo));
}

function seviyeUpdatePageFunction(str, lineNo){
	var sSelect = getSelectClause ("divyetkiTalep-2-"+lineNo);
	var fStr = sSelect + parseStr (str) + "</select>";
	document.getElementById("divyetkiTalep-2-"+lineNo).innerHTML = fStr;

	/*sSelect = getSelectClause ("divyetkiTalep-3-"+lineNo);
	fStr = sSelect + '<option value="Seçiniz">Seçiniz</option>' + "</select>";
	document.getElementById( "divyetkiTalep-3-"+lineNo ).innerHTML = fStr;*/
}

function getSelectClause (id){
	var cSeviye = document.getElementById(id);
	var sInner = cSeviye.innerHTML;
	var sIndex = sInner.indexOf(">");
	return sInner.substring(0, sIndex+1);
}

function parseStr (str){
	var startPos = str.lastIndexOf("<div id='parse'>");
	var endPos   = str.indexOf ("</div>",startPos);
	var parsed   = str.substring(startPos+16, endPos);
	return parsed;
}

function seviyeGetQueryString(lineNo){
	var yeterlilikValue = document.getElementById("inputyetkiTalep-1-"+lineNo).value;
	var qstr = 'yet=' + yeterlilikValue;
	return qstr;
}

function seviyeCheck(){
	return true;
}

/*function kodUpdatePageFunction(str, lineNo){
	var sSelect = getSelectClause ("divyetkiTalep-3-"+lineNo);
	var fStr = sSelect + parseStr(str) + "</select>";
	document.getElementById( "divyetkiTalep-3-"+lineNo ).innerHTML = fStr;
}*/

function kodGetQueryString(lineNo){	
	var yeterlilikValue = document.getElementById("inputyetkiTalep-1-"+lineNo).value;
	var seviyeVal = document.getElementById("inputyetkiTalep-2-"+lineNo).value;
	var qstr = 'yet=' + yeterlilikValue + '&seviye=' + seviyeVal;
	return qstr;
}

function kodCheck(){
	return true;
}

<?php
$chosen = JRequest::getVar('chosen', '0');
$db =& JFactory::getOracleDBO();

if ($chosen=='1'){
	$yet =JRequest::getVar('yet');
	$options = '<option value="Seçiniz">Seçiniz</option>';
		
	$sql = "SELECT seviye_id, seviye_adi 
			FROM pm_seviye 
			WHERE seviye_id IN
	        (SELECT seviye_id
	         FROM m_yeterlilik 
	         WHERE yeterlilik_adi IN ( SELECT yeterlilik_adi FROM m_yeterlilik WHERE yeterlilik_id = ".$yet."))";
	
	$data = $db->loadList($sql);
	
	if(isset($data)){
		foreach ($data as $row){
		    $options .= '<option value="'.$row[0].'">'.$row[1].'</option>';
		}
	}
	echo "<div id='parse'>".$options."</div>";
	
}else if ($chosen=='2'){
	$yet = JRequest::getVar('yet');
	$seviye =JRequest::getVar('seviye');
	
	$options = '';
		
	$sql="SELECT yeterlilik_id, yeterlilik_kodu
	      FROM m_yeterlilik 
	      	JOIN pm_seviye USING (seviye_id) 
	      WHERE yeterlilik_adi = (SELECT yeterlilik_adi FROM m_yeterlilik WHERE yeterlilik_id = '".$yet."') 
	      		AND seviye_id = '".$seviye."'";
	
	$data = $db->loadList($sql);
	
	if(isset($data)){
		foreach ($data as $row){
		    $options .= '<option value="'.$row[0].'">'.$row[1].'</option>';
		}
	}
	echo "<div id='parse'>".$options."</div>";
}
?>
</script>
