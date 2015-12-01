<form
	onsubmit="return validate('ChronoContact_yeterlilik_basvuru_t2')"
	action="index.php?option=com_yeterlilik_basvur&amp;layout=kapsam&amp;task=yeterlilikKaydet"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_yeterlilik_basvuru_t2"
	name="ChronoContact_yeterlilik_basvuru_t2">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php
$sektorler = $this->pm_sektor;
echo $this->pageTree;
?>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">Yeterlilik Geliştirme Kapsamı/Planı</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">13. Geliştirilmesi/Hazırlanması öngörülen yeterlilikleri belirtiniz.</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
        <form>
		<div id="ongorulenYeterlilik_div">
			<?php 
				$meslek = $this->yeterlilik;
				$mesuzun = count($meslek);
				if($mesuzun==0){
				echo('<table id="ongorulenYeterlilik0" style="table-layout: auto; width: 450px;border-collapse: separate; border-bottom:3px solid #666666; margin-bottom:1px;">
				<thead class="tablo_header">
					<tr>
						<th>Yeterliliğin Adı</th>
						<th>Yeterliliğe İlişkin Yasal Düzenleme (varsa)</th>
						<th>Yeterliliğin İlgili Olduğu Sektör</th>
					</tr>
				</thead>
				<tbody>
					<tr class="tablo_row">
						<td>
                            <input id="inputongorulenYeterlilik-1-0" class="required uppercase" type="text" name="inputongorulenYeterlilik-1[]" size="30" value="">
                        </td>  
                        <td>
                        	<input id="inputongorulenYeterlilik-3-0" class="required uppercase" type="text" name="inputongorulenYeterlilik-3[]" size="30" value="">
                        </td>
						<td>
                           <div id="divmeslek_standart-5-1">
                                <select id="inputongorulenYeterlilik-5-0" class="comboReq" name="inputongorulenYeterlilik-5[]">
                                	<option value="Seçiniz">Seçiniz</option>')?>
                                	<?php  $sektorler = $this->pm_sektor; 
                                	$sekuzun=count($sektorler);
                                	for($i=0;$i<$sekuzun;$i++){
                                		echo('<option value="'.$sektorler[$i][SEKTOR_ID].'">'.$sektorler[$i] [SEKTOR_ADI].'</option>');
                                	}
                                    ?>
									<?php echo('
                        </select>
                        </div>
                        </td> 
					</tr>
				</tbody>
				<thead class="tablo_header">
					<tr>
						<th style="display:none;">Yeterliliklerin<br>Geliştirilmesi/Hazırlanması<br>İçin Öngörülen<br>Başlangıç Tarihi</th>
						<th>Yeterliliklerin<br>Geliştirilmesi/Hazırlanması<br>İçin Öngörülen<br>Bitiş Süresi</th>
						<th>Yeterliliğe Kaynak Teşkil Eden<br> Meslek Standardı,<br> Meslek Standardı<br> Birimleri/Görevleri<br> Veya Yeterlilik Birimleri</th>
						<th>Seviye</th>
					</tr>
				</thead>
				<tbody>
					<tr class="tablo_row">
					<td WIDTH="20"  style="display:none;">
                            <input id="inputongorulenYeterlilik-6-0" class="datepickbas" type="text" name="inputongorulenYeterlilik-6[]" size="15" value="" >
                        </td>
					<td WIDTH=20>
                            <input  id="inputongorulenYeterlilik-7-0" class="monthpicker" type="text" name="inputongorulenYeterlilik-7[]" size="15" value="">
                    </td>
					<td>
                        	<textarea id="inputongorulenYeterlilik-4-0" class="required uppercase" type="text" name="inputongorulenYeterlilik-4[]" size="30" value=""></textarea>
                    </td>
					<td>
                            <div id="divmeslek_standart-2-1">
                            <select id="inputongorulenYeterlilik-2-0" class="comboReq" name="inputongorulenYeterlilik-2[]">
                                <option value="Seçiniz">Seçiniz</option>')?>
								<?php
									$seviye = $this->pm_seviye;
									$sevuzun = count($seviye);
									for($k=0; $k<$sevuzun; $k++){
										echo('<option value="'.$seviye[$k][SEVIYE_ID].'">'.$seviye[$k] [SEVIYE_ADI].'</option>');
									}
								?>
								<?php echo('
                            </select>
                        </div>
                        </td>
					 	
						<td><input class="sil" id="0" type="button" value="Sil"/></td>
					</tr>
				</tbody>
			</table>');
			$mesuzun=$mesuzun+1;}
	
			//BİRDEN FAZLA VARSA			
				else{
				for($j=0;$j<$mesuzun;$j++){echo('<table id="ongorulenYeterlilik'.$j.'" style="table-layout: auto; width: 450px;border-collapse: separate; border-bottom:3px solid #666666; margin-bottom:1px;">
				<thead class="tablo_header">
					<tr>
						<th>Yeterliliğn Adı</th>
						<th>Yeterliliğe İlişkin Yasal Düzenleme (varsa)</th>
						<th>Yeterliliğin İlgili Olduğu Sektör</th>
					</tr>
				</thead>
				<tbody>
					<tr class="tablo_row">
						<td>
                            <input id="inputongorulenYeterlilik-1-'.$j.'" class="required uppercase" type="text" name="inputongorulenYeterlilik-1[]" size="30" value="'.$meslek[$j][YETERLILIK_ADI].'">
                        </td>
                        <td>
                            <input id="inputongorulenYeterlilik-3-'.$j.'" class="required" name="inputongorulenYeterlilik-3[]" value="'.$meslek[$j][YETERLILIK_YASAL].'"/>
                        </td>
                        <td>
                            <div id="divmeslek_standart-5-1">
                            <select id="inputongorulenYeterlilik-5-'.$j.'" class="comboReq" name="inputongorulenYeterlilik-5[]">')
				?>
								<?php
									$sektorler = $this->pm_sektor; 
                                	$sekuzun=count($sektorler);
                                	for($i=0;$i<$sekuzun;$i++){
                                		if ($meslek[$j][SEKTOR_ID]==$sektorler[$i][SEKTOR_ID]){
                                			$selected="selected";
                                		} else {
                                			$selected="";
                                		}
                                		echo('<option value="'.$sektorler[$i][SEKTOR_ID].'" '.$selected.'>'.$sektorler[$i] [SEKTOR_ADI].'</option>');
                                	}
                                    ?>
								<?php echo('
                            </select>
                        </div>
                        </td>
					</tr>
				</tbody>
				<thead class="tablo_header">
					<tr>
						<th style="display:none;">Yeterliliklerin<br>Geliştirilmesi/Hazırlanması<br>İçin Öngörülen<br>Başlangıç Tarihi</th>
						<th>Yeterliliklerin<br>Geliştirilmesi/Hazırlanması<br>İçin Öngörülen<br>Bitiş Süresi</th>
						<th>Yeterliliğe Kaynak Teşkil Eden<br> Meslek Standardı,<br> Meslek Standardı<br> Birimleri/Görevleri<br> Veya Yeterlilik Birimleri</th>
						<th>Seviye</th>
					</tr>
				</thead>
				<tbody>
					<tr class="tablo_row">
						<td style="display:none;">
                            <input id="inputongorulenYeterlilik-6-'.$j.'" class="datepickbas" type="text" name="inputongorulenYeterlilik-6[]" size="15" value="'.$meslek[$j][YETERLILIK_BASLANGIC].'">
                        </td>
                        <td>
                            <input  id="inputongorulenYeterlilik-7-'.$j.'" class="monthpicker" type="text" name="inputongorulenYeterlilik-7[]" size="15" value="'.$meslek[$j][YETERLILIK_BITIS].'">
                        </td>
						<td>
                        	<textarea id="inputongorulenYeterlilik-4-'.$j.'" class="required uppercase" type="text" name="inputongorulenYeterlilik-4[]" size="30">'.$meslek[$j][KAYNAK_TESKIL_EDENLER].'</textarea>
                    </td>
					<td>
                            <div id="divmeslek_standart-2-1">
                            <select id="inputongorulenYeterlilik-2-'.$j.'" class="comboReq" name="inputongorulenYeterlilik-2[]">
                                <option value="'.$meslek[$j][SEVIYE_ID].'">'.$this->pm_seviye[$meslek[$j][SEVIYE_ID]-1][SEVIYE_ADI].'</option>')?>
								<?php
									$seviye = $this->pm_seviye;
									$sevuzun = count($seviye);
									for($k=0; $k<$sevuzun; $k++){
										echo('<option value="'.$seviye[$k][SEVIYE_ID].'">'.$seviye[$k] [SEVIYE_ADI].'</option>');
									}
								?>
								<?php echo('
                            </select>
                        </div>
                        </td>
						<td><input class="sil" id="'.$j.'" type="button" value="Sil"/></td>
					</tr>
				</tbody>
			</table>');}
			}?>
		</div>
		<input id="kacdefa" type="text" name="rowNumber-meslek_standart" size="1" value="1">
		<input id="ekle" type="button" value="Adet yeni satir ekle">
		<?php 
		for($qwq = 0; $qwq<$mesuzun; $qwq++){
		echo('<input id="meslek_standart1" type="hidden" name="meslek_standart[]" value="'.$meslek[$qwq][STANDART_ID].'">');
		}
		?>
	<div class="cfclear">&nbsp;</div>
</div>

<br />
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
  <div class="form_element cf_heading">
  	<h3 class="contentheading">14. Bu mesleklere ilişkin mevcut durumu ve geleceğe yönelik eğilimleri gösteren piyasa çalışması var mı?</h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_textarea">
    <textarea class="cf_inputbox" rows="5" 
    	id="text_29" title="" cols="60" name="madde_14"><?php echo $this->basvuru["PIYASA_ACIKLAMA"]; ?></textarea>
    
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h3 class="contentheading">15.  Belirtilmek istenen diğer hususlar ve/veya eklenmek istenen belgeler (tanıtım broşürü, süreli yayınlar vb.) </h3>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_placeholder">
      <div id="ekler_div"></div>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_placeholder">
      <div>
      <br>AÇIKLAMA<br>
      <textarea cols="60" rows="5" name="belirtilmekIstenenDigerHususTextArea"><?php 
      	echo $this->basvuru["BELIRTILECEK_DIGER_HUSUSLAR"]; 
      ?></textarea>
      
      </div>
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
//Ongorulen Yeterlilik Tablosu
<?php
$db = JFactory::getOracleDBO ();
$param = array ($this->pm_seviye,  $this->pm_sektor);
$k = array ('),"comboReq"), new Array("text","","15"), new Array("text","","25"),new Array("combo",new Array(' , '),"comboReq", "", "220"), new Array("text","","10","date"), new Array("text","","10","date"));');
$r = 'dTables.ongorulenYeterlilik = new Array( new Array("text","uppercase"),new Array("combo",	new Array(';
$p = '';
$count = count ($param);
for ($i = 0; $i < $count; $i++){
	$data = $param[$i];
	
	$s = 'new Array ("Seçiniz", "Seçiniz"),';
	if(isset($data)){
	    foreach ($data as $row){
	        $id = $row[0];
	        $value = $row[1];
//	        if ($i == 1)
//	            $value = $row[1]." - ".$row[2]; //M_MESLEK_STANDARTLARI
	        if ($id != 0)
	            $s .= 'new Array ("'.$id.'","'.FormFactory::normalizeVariable ($value).'"),';
	    }
	}
	
	$s = substr ($s, 0, strlen($s)-1);
	
	$p .= $s.$k[$i];
}
$r .= $p;
echo $r;
?>


dTables.ekler = new Array(new Array("text"), new Array("upload"));

jQuery(document).ready(function(){
	whatever = <?php echo $mesuzun; ?>;
});
//Yeni Tablo Ekleme    
jQuery("input#ekle").live("click",function(){
  	var kac = jQuery("#kacdefa").val();
    var kac = parseInt(kac);
	var kac=kac+whatever;
	for (whatever; whatever<kac; whatever++)
	{
		jQuery("div#ongorulenYeterlilik_div").append('<table id="ongorulenYeterlilik'+whatever+'" style="table-layout: auto; width: 450px;border-collapse: separate; border-bottom:3px solid #666666; margin-bottom:1px;"><thead class="tablo_header"><tr><th>Yeterliliğn Adı</th><th>Yeterliliğe İlişkin Yasal Düzenleme</th><th>Yeterliliğin İlgili Olduğu Sektör</th></tr></thead><tbody><tr class="tablo_row"><td><input  id="inputongorulenYeterlilik-1-'+whatever+'" type="text" name="inputongorulenYeterlilik-1[]" size="30"/></td><td><input type="text"  id="inputongorulenYeterlilik-3-'+whatever+'" size="30" name="inputongorulenYeterlilik-3[]"/></td><td><select  id="inputongorulenYeterlilik-5-'+whatever+'" name="inputongorulenYeterlilik-5[]"><option style="padding-left:20px; padding-right:20px" value="Seçiniz">Seçiniz</option>'+'<?php $sektorler = $this->pm_sektor; $sekuzun=count($sektorler);for($i=0;$i<$sekuzun;$i++){echo('<option value="'.$sektorler[$i][SEKTOR_ID].'">'.$sektorler[$i] [SEKTOR_ADI].'</option>');}?>'+'</select></td></tr></tbody><thead class="tablo_header"><tr><th style="display:none;">Yeterliliklerin<br>Geliştirilmesi/Hazırlanması<br>İçin Öngörülen<br>Başlangıç Tarihi</th><th>Yeterliliklerin<br>Geliştirilmesi/Hazırlanması<br>İçin Öngörülen<br>Bitiş Süresi</th><th>Yeterliliğe Kaynak Teşkil Eden</br> Meslek Standardı,</br> Meslek Standardı</br> Birimleri/Görevleri</br> Veya Yeterlilik Birimleri</th><th>Seviye</th></tr></thead><tbody><tr class="tablo_row"><td style="display:none;"><input id="inputongorulenYeterlilik-6-'+whatever+'" class="datepickbas" type="text" name="inputongorulenYeterlilik-6[]" size="15"></td><td><input id="inputongorulenYeterlilik-7-'+whatever+'" class="monthpicker" type="text" name="inputongorulenYeterlilik-7[]" size="15"></td><td><textarea  id="inputongorulenYeterlilik-4-'+whatever+'" type="text" size="30" name="inputongorulenYeterlilik-4[]"></textarea></td><td><select  id="inputongorulenYeterlilik-2-'+whatever+'" name="inputongorulenYeterlilik-2[]"><option value="Seçiniz">Seçiniz</option>'+'<?php $seviye = $this->pm_seviye;$sevuzun = count($seviye);for($k=0; $k<$sevuzun; $k++){echo('<option value="'.$seviye[$k][SEVIYE_ID].'">'.$seviye[$k] [SEVIYE_ADI].'</option>');} ?>'+'</select></td><td><input class="sil" id="'+whatever+'" type="button" value="Sil"/></td></tr></tbody></table>');
	}
});
//Yeni Tablo Ekleme	
//Silme
jQuery(".sil").live("click",function(){
	var silno = jQuery(this).attr("id");
	jQuery("table#ongorulenYeterlilik"+silno).remove();		
});
//Silme


function createTables (){
/*	var header = new Array('Yeterliliğin<br />Adı',
					       'Seviyesi*',
					       'Yeterliliğe İlişkin<br />Yasal Düzenleme<br />(varsa)',
					       'Yeterliliğe Kaynak Teşkil Eden <br /> Meslek Standardı,<br />Meslek Standardı Birimleri/Görevleri<br />Veya Yeterlilik Birimleri',
					       'Yeterliliğin İlgili<br />Olduğu Sektör',
					       'Yeterliliklerin<br />Geliştirilmesi/Hazırlanması<br />İçin Öngörülen<br />Başlangıç Tarihi',
					       'Yeterliliklerin<br />Geliştirilmesi/Hazırlanması<br />İçin Öngörülen<br />Bitiş Süresi'
						  );
	var tableName = "ongorulenYeterlilik";
	createTable(tableName, header);
	patchEkleForDatePick(tableName, new Array ('6' , '7'), header);
	addYeterlilikValues (dTables.ongorulenYeterlilik, tableName);
	*/
	createTable('ekler', new Array ('Açıklama', 'Belge Gönderimi'));
	addEkValues (new Array (new Array ("text")), 'ekler');
}

/*function addYeterlilikValues (yeterlilik, name){
	var length = yeterlilik.length;
	var params = new Array ();
	var arr    = new Array ();
	var arrId  = new Array ();
	
	for (var i = 0; i < length; i++){
		params[i] = yeterlilik[i][0];
	}
	*/
	<?php	
	/*$data = $this->yeterlilik;	
	$tableCount = count ($data);
	
	$c = 0;
	$id = 0;
	for ($i=0; $i< $tableCount; $i++) {
		$arr = $data[$i];
		echo 'arrId['.$id++.']= "'. $arr["YETERLILIK_ID"] .'";';
		
	    echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["YETERLILIK_ADI"]) .'";';
	    echo 'arr['.$c++.']= "'. $arr["SEVIYE_ID"] .'";';
	    echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["YETERLILIK_YASAL"]) .'";';
	    echo 'arr['.$c++.']= "'. $arr["KAYNAK_TESKIL_EDENLER"] .'";';
	    echo 'arr['.$c++.']= "'. $arr["SEKTOR_ID"] .'";';
	    echo 'arr['.$c++.']= "'. $arr["YETERLILIK_BASLANGIC"] .'";';
	    echo 'arr['.$c++.']= "'. $arr["YETERLILIK_BITIS"] .'";';
	}*/
	?>
/*
	if (isset (arr))
		addTableValues (arr,arrId, params, name);
}
*/




//dok ekle bas
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
//dok ekle sonu
//Datepicker
jQuery(".datepickbas").datepicker({
		dateFormat: "dd.mm.yy",
		changeYear: true,
		changeMonth: true,
			}).live("click",function() {
		jQuery(this).datepicker().focus();});

jQuery(".datepickson").datepicker({
		dateFormat: "dd.mm.yy",
		changeYear: true,
		changeMonth: true,
		}).live("click",function()  {
		jQuery(this).datepicker().focus();});

/*jQuery('.monthpicker').monthpicker({
	monthNames: ['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran', 'Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'],
	monthNamesShort: ['Oca','Şub','Mar','Nis','May','Hzr', 'Tem','Ağu','Eyl','Eki','Kas','Ara'],
	showOn: "both",
	//buttonImage: "images/calendar.png",
	buttonImageOnly: true,
	changeYear: false,
	yearRange: 'c-70:c',
	dateFormat: 'mm/yy'
});*/
//Datepicker

jQuery(document).ready(function(){
<?php if($durum[0]['DURUM_ID'] != -1 && $durum[0]['DURUM_ID'] != -2 && $this->ssyetkili != true && $this->evrak_id != -1){?>
	jQuery('input[value="Sil"]').remove();
	jQuery('input[value="Değiştir"]').remove();
	jQuery('#ekle').remove();
	jQuery('#kacdefa').remove();
	jQuery('#satirEkle_ekler').remove();
	jQuery('#rowNumber-ekler').remove();
	jQuery('#up_submitbtn').remove();
	jQuery('input[type=file]').remove();
<?php } ?>
});
</script>
