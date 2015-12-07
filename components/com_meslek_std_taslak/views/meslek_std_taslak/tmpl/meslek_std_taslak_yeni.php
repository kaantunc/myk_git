<script type="text/javascript">
	jQuery.blockUI();
	jQuery(window).load(function() {
		jQuery.unblockUI();
	})
</script>
<?php

$standartBilgi  = $this->meslekStandardi;
$gelistiren_kurulus = $this->hazirlayan;
$taslakStandart = $this->taslakStandart;

?>
<style>
@CHARSET "UTF-8";
#navigation {
    width:250px;
}

#content {
    width:700px;
}

#navigation,
#content {
    float:left;
    margin:10px;
}

.collapsible,
.page_collapsible {
    margin: 0;
    padding:10px;
    height:20px;

    border-top:#f0f0f0 1px solid;

	background:url(templates/paradigm_shift/images/title_arrow_green.png) no-repeat #cdcdcd scroll 15px 12px;
    font-family: Arial, Helvetica, sans-serif;
    text-decoration:none;
    text-transform:uppercase;
    color: #000;
    font-size:1em;
}

.collapsible em{
	padding: 0 0 0 25px; 
}
.collapse-open {
    background:url(templates/paradigm_shift/images/title_arrow.png) no-repeat #1C617C scroll 15px 12px;
    color: #fff;
}

.collapse-open span {
    display:block;
    float:right;
    padding:10px;
}

.collapse-open span {
    background:url(images/minus_white.png) center center no-repeat;
}

.collapse-close span {
    display:block;
    float:right;
    background:url(images/plus_green.png) center center no-repeat;
    padding:10px;
}

div.container {
    padding:0;
    margin:0;
}

div.content {
    background:#fafafa;
    margin: 0;
    padding:10px;
    font-size:.9em;
    line-height:1.5em;
    font-family:"Helvetica Neue", Arial, Helvetica, Geneva, sans-serif;
}

div.content ul, div.content p {
    margin:0;
    padding:3px;
}

div.content ul li {
    list-style-position:inside;
    line-height:25px;
}

div.content ul li a {
    color:#555555;
}

code {
    overflow:auto;
}
.form_item{
	padding: 5px 0 5px 0;
}
.form_item input{
	float:none;
}
</style>
<form
<?php 
$task = "task=taslakKaydetYeni";
echo 'onSubmit = "return validate(\'ChronoContact_meslek_std_taslak\')"';
echo 'action=index.php?option=com_meslek_std_taslak&layout=meslek_std_taslak_yeni&standart_id='.$this->standart_id;	
?>
	enctype="multipart/form-data" method="post"
	id="ChronoContact_meslek_std_taslak"
	name="ChronoContact_meslek_std_taslak">
	<input type="hidden" name="typetaslak" value="1" />
<div class="page_container">
	<?php echo $this->pageTree;?>
	<div id="accordion_container" style="float:left; width:99%; margin-top:20px;">
		<div class="collapsible" id="section1"><em>Temel Bilgiler</em><span></span></div>
		<div class="container">
		    <div class="content">
		        <div class="form_element cf_heading">
					<a href="http://tuikapp.tuik.gov.tr/DIESS/SozlukDetayiGetirAction.do?surumId=210&ustKod=yok&duzey=0" target="_blank">ISCO 08 Uluslararası Standart Meslek Sınıflaması</a>
				</div>
				<div class="form_item">
					<div class="form_element cf_placeholder">
						<div id="standart_div"></div>
					</div>
					<div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
				  <div class="form_element cf_textbox">
				    <label class="cf_label" style="width: 150px;">Referans Kodu:</label>
				    <input class="cf_inputbox" maxlength="150" size="20" <?php echo ($this->sektorSorumlusu ? "" : "disabled"); ?>
				    	id="referans_kodu" name="referans_kodu" type="text" value="<?php echo $standartBilgi['STANDART_KODU'];?>" />
				  </div>
				  <div class="cfclear">&nbsp;</div>
				</div>
				<?php 
				if ($this->canEdit){
				?>	
					<div class="form_item">
					  <div class="form_element cf_placeholder">
					  <?php 
					  if ($standartBilgi['REVIZYON']=="00"){ 
						$data = $this->pm_MESLEK_STANDART_SUREC_DURUM;
					  } else {
					  	$data = $this->pm_MESLEK_STANDART_REVIZYON_SUREC_DURUM;
					  }
						?>
						<label class="cf_label" style="width:150px;"><?php if ($standartBilgi['REVIZYON']!="00"){?>Revizyon<?php } else {?>Meslek Standardı<?php }?> Durumu:</label>
						<select id="revizyon_durum" class="cf_inputbox" name="revizyon_durum" title="" size="1" firstoption="1" firstoptiontext="Seçiniz" onchange="checkYeterlilikDurum(this)" <?php echo ($this->sektorSorumlusu ? "" : "disabled"); ?>>
							<option value="">Seçiniz</option>
						<?php
							if ($standartBilgi['REVIZYON']=="00"){
								$durum=$standartBilgi[MESLEK_STANDART_SUREC_DURUM_ID];
							} else {
								$durum=$standartBilgi["REVIZYON_DURUMU"];
							}
							if(isset($data)){
								foreach ($data as $row){
								  if ($durum == $row["MESLEK_STANDART_SUREC_DURUM_ID"]){
								     $selected = 'selected="selected"';
								  } else { 
								     $selected = '';
								  }
								  echo "<option ".$selected." value='".$row['MESLEK_STANDART_SUREC_DURUM_ID']."'>".$row['STANDART_SUREC_DURUM_ADI']."</option>";
								}
							}
						?>
						</select></div>
					  <div class="cfclear">&nbsp;</div>
					</div>
				<?php 
				}
				?>	
				<div class="form_item">
				  <div class="form_element cf_textbox">
				    <label class="cf_label" style="width: 150px;">Resmi Gazete Tarih ve Sayısı:</label>
				    <input class="cf_inputbox date" maxlength="150" size="10"  <?php echo ($this->sektorSorumlusu ? "" : "disabled"); ?>
				    	id="yayin_tarihi" name="yayin_tarihi" type="text" value="<?php echo $standartBilgi["YAYIN_TARIHI"];?>" />
				  </div>
				  <div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
					  <div class="form_element cf_textbox">
					    <label class="cf_label" style="width: 150px;">YK Onay Tarihi ve sayısı</label>
					    <input class="cf_inputbox date" maxlength="150" size="10" id="onay_tarih" name="onay_tarih" type="text" value="<?php echo  $standartBilgi['KARAR_TARIHI'];?>" <?php echo ($this->sektorSorumlusu ? "" : "disabled"); ?> /> /    
					  	<input class="cf_inputbox" maxlength=10 size="6" id="onay_sayi" name="onay_sayi" type="text" value="<?php echo $standartBilgi['KARAR_SAYI'];?>" <?php echo ($this->sektorSorumlusu ? "" : "disabled"); ?> />
					  	<em style="color: red; font-size: 10px;">Revizyon ise revizyon onay tarihi girilmelidir !</em>
					  </div>
					  <div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
				  <div class="form_element cf_textbox">
				    <label class="cf_label" style="width: 150px;">Görüşe Gönderilme Tarihi:</label>
				    <input class="cf_inputbox date" maxlength="150" size="10"  
				    	id="goruse_cikma_tarihi" name="goruse_cikma_tarihi" type="text"   value="<?php echo $taslakStandart["GORUSE_CIKMA_TARIHI"];?>" <?php echo ($this->sektorSorumlusu ? "" : "disabled"); ?>/>
				  	</div>
				  <div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
				  <div class="form_element cf_textbox" style="margin-left:32px;">
				    <input type="checkbox" name="tehlikeli_is_durum" id="tehlikeli_is_durum" value="1" style="float:left;" <?php echo ($standartBilgi['TEHLIKELI_IS_DURUM'] == "1" ? "checked='checked'" : "");?> <?php echo ($this->sektorSorumlusu ? "" : "disabled"); ?>/>
				    <label class="cf_label" style="margin: 0 0 0 10px; line-height: 13px;">Meslek Standardı tehlikeli ve çok tehlikeli işler sınıfındadır.</label>    
				  </div> 
				  <div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
				  <div class="form_element cf_textbox">
				    <label class="cf_label" style="width: 150px;">Geliştiren Kuruluş(lar):</label>
				  </div>
				  <div class="cfclear">&nbsp;</div>
				</div>
				<div class="form_item">
				<div class="form_element cf_placeholder">
					<div>
					<table id="gelistirenKurulusTable" style="width:100%;">
					<thead>
						<tr style="background-color:#E8E8E8;">
							<th width="5%">Sıra No</th>
							<th width="90%">Kuruluş Adı</th>
							<th width="10%">Yardımcı/Yüklenici Kuruluş</th>
							<th width="3%">Sil?</th>
						</tr>
					</thead>
					<tbody>
						<?php echo "<pre>"; 
						if(count($gelistiren_kurulus) <= 0){
							echo "<tr id='emptytablegelistiren'><td colspan='6'><center><p>Geliştiren kuruluş bulunamadı !</p></center></td></tr>";
						}else{
							for($i=0; $i<count($gelistiren_kurulus); $i++){
								if($i%2==1) $rowClass='tablo_row'; else $rowClass = 'tablo_row2';
								if($gelistiren_kurulus[$i]["ILK_GELISTIRME_YAPAN"]=='1') $ilkGelistirenChecked = ' checked="checked" '; else  $ilkGelistirenChecked = ' '; 
								if($gelistiren_kurulus[$i]["REVIZE_YAPAN"]=='1') $revizeYapanChecked = ' checked="checked" '; else  $revizeYapanChecked = ' ';
								if($gelistiren_kurulus[$i]["REVIZE_YAPAN"]!='1') $revizeNoTextboxReadOnlyVal = ' readonly="readonly" '; else  $revizeNoTextboxReadOnlyVal = ' ';
								
								
								if($ulusalOlmus==true)
									$ilkGelistirenReadOnly = ' disabled="disabled" ';
								else
									$ilkGelistirenReadOnly = ' ';
									
								echo '<tr class="'.$rowClass.'" style="padding:5px 0 5px 0;">';
								echo '<td width="5%">'.($i+1).'</td>';
								echo '<td width="80%"> <input type="text" name="inputhazirlayan-2[]" value="'.$gelistiren_kurulus[$i]["KURULUS_ADI"].'" class="required"  style="width:100%;"  /> </td>';
								echo '<td width="10%"> 
										 <input type="radio" name="inputhazirlayan-3-'.($i+1).'[]" style="margin-left:10%;" '.$ilkGelistirenChecked.' '.$ilkGelistirenReadOnly.' value="1" '.($gelistiren_kurulus[$i]["KURULUS_TURU"] == 1 ? 'checked="checked"' : "").' class="yardyuklenici">Yüklenici<br/>
    							         <input type="radio" name="inputhazirlayan-3-'.($i+1).'[]" style="margin-left:10%;" '.$ilkGelistirenChecked.' '.$ilkGelistirenReadOnly.' value="2" '.($gelistiren_kurulus[$i]["KURULUS_TURU"] == 2 ? 'checked="checked"' : "").' class="yardyuklenici">Yardımcı
    								  </td>';
								echo '<td width="3%"><input type="button" class="gelistirenKurulusSilButton" value="Sil"></td>';
								echo '</tr>';
								
							}
						}
						?>
					</tbody>
					</table>
					<input style="float:left; height: 20px;" type="text" id="satirSayisiTextbox" size="3" value="1" ><input style="float:left;" class="yeniKurulusEkleButton" type="button" value="Adet Satır Ekle">
					</div>
				</div>
				<div class="cfclear">&nbsp;</div>
			</div>
			<?php if($this->standart_duzenleme_yetki){?>
				<input type="button" value="Kaydet" id="save_section1" />	
			<?php }?>
		    </div>
		</div>
		<?php 
			$path2 = FormFactory::normalizeVariable ($standartBilgi["RESMI_GORUS_ONCESI_PDF"]);
			$path3 = FormFactory::normalizeVariable ($standartBilgi["SEKTOR_KOMITESI_ONCESI_PDF"]);
			$path4 = FormFactory::normalizeVariable ($standartBilgi["YONETIM_KURULU_ONCESI_PDF"]);
			$path5 = FormFactory::normalizeVariable ($standartBilgi["SON_TASLAK_PDF"]);
		?>
		<div class="collapsible" id="section5"><em>Versiyonlar</em><span></span></div>
		<div class="container">
		    <div class="content">
		        <div class="form_item">
					<div class="form_element cf_placeholder">
						<div id="taslakPdf_div"></div>
					</div>
					<div class="cfclear">&nbsp;</div>
				</div>
				<?php if($this->standart_duzenleme_yetki){?>
				<input type="button" value="Kaydet" id="save_section5" />
				<?php }?>	
		</div>
	</div>
</div>
</form>
<script>
	jQuery(document).ready(function(){

		jQuery("#onay_tarih").mask("99/99/9999");
		jQuery("#yayin_tarihi").mask("99/99/9999");
		jQuery("#goruse_cikma_tarihi").mask("99/99/9999");

		 jQuery('.collapsible').collapsible({
            defaultOpen: 'section1'
         });
		 jQuery("#onay_tarih,#yayin_tarihi,#goruse_cikma_tarihi").datepicker({
	            changeYear: true,
	            changeMonth: true
	     });
		 <?php 
		 if ($this->canEdit)
			echo "var isReadOnly = false;";
		 else
			echo "var isReadOnly = true;";
		 ?>
		 var readOnly = null;
		 if (isReadOnly)
			readOnly = "readOnly";

		jQuery("#save_section1").click(function(){
			parameters = 'standart_id='+'<?php echo $this->standart_id;?>'+
							'&onayTarihi='+jQuery.trim(jQuery("#onay_tarih").val())+
		     				'&onaySayisi='+jQuery.trim(jQuery("#onay_sayi").val())+
						    '&yayinTarihi='+jQuery.trim(jQuery("#yayin_tarihi").val())+
						    '&goruse_cikma_tarihi='+jQuery.trim(jQuery("#goruse_cikma_tarihi").val())+
						    '&referans_kodu='+jQuery.trim(jQuery("#referans_kodu").val())+
						    '&revizyon_durum='+jQuery.trim(jQuery("#revizyon_durum").val())+
						    '&tehlikeli_is_durum='+(jQuery("#tehlikeli_is_durum:checked").val() ? "1" : "0")+
						   '&'+jQuery("input[name='inputstandart-2[]']").serialize()+
						  '&'+jQuery("textarea[name='inputstandart-3[]']").serialize()+
						 '&'+jQuery("input[name='inputhazirlayan-2[]']").serialize()+
						'&'+jQuery(".yardyuklenici").serialize();
			saveSection('section1',parameters);
		});
		
		jQuery("#save_section5").click(function(){ 
			parameters = 'standart_id='+'<?php echo $this->standart_id;?>'+ 
						'&path_taslakPdf_0_1='+(jQuery("input[name=path_taslakPdf_0_1]").length > 0 ? jQuery("input[name=path_taslakPdf_0_1]").val() : "")+
						'&path_taslakPdf_0_2='+(jQuery("input[name=path_taslakPdf_0_2]").length > 0 ? jQuery("input[name=path_taslakPdf_0_2]").val() : "")+
						'&path_taslakPdf_0_3='+(jQuery("input[name=path_taslakPdf_0_3]").length > 0 ? jQuery("input[name=path_taslakPdf_0_3]").val() : "")+
						'&path_taslakPdf_0_4='+(jQuery("input[name=path_taslakPdf_0_4]").length > 0 ? jQuery("input[name=path_taslakPdf_0_4]").val() : "");
				saveSection('section5',parameters);
		});

		jQuery('#kurulusTopluEklemeTumunuEkleButton').click( function (e) {
			text=jQuery("#gelistirenkurulus_editarea").val();
		    text=text.replace("\r\n","\n");
		    var ek1Array=text.split("\n");
			if(ek1Array.length > 0){
				jQuery("#ek5Tablosu #emptytable").hide();
			}else{
				if(jQuery("#ek5Tablosu tbody tr").length > 0){
					jQuery("#ek5Tablosu #emptytable").hide();
				}else{
					jQuery("#ek5Tablosu #emptytable").show();
				}
			}
		    for(var i=0; i<ek1Array.length; i++)
		    {   
			    
			    var readOnlyValue = "";
				if (isReadOnly)
					readOnlyValue = ' readOnly="true" ';
				
			    
				var x = "inputkurulus-1[]";
				var rowCount = jQuery('#ek5Tablosu tbody tr:not(#emptytable)').length;
				var nextRowNumber = rowCount+1;

				satirRow = '<tr>'
					+'<td class="siraNoTD" style="text-align:center;">'+nextRowNumber+'</td>'
	                +'<td><input style="width:100%;" id="inputkurulus-2-'+nextRowNumber+'" type="text" name="inputkurulus-2[]" size="40" value="'+ ek1Array[i] +'"></td>' 
	                +'<td class="silButtonTD "><input onclick="jQuery(this.getParent().getParent()).remove(); tabloyuDuzenle();" type="button" value="SİL"></td></tr>';

	    		if(jQuery(".dataTables_empty").length == 0)
					jQuery('#ek5Tablosu tbody').append(satirRow);
	    		else
	    		{
	    			jQuery('#ek5Tablosu tbody tr').remove();
	    			jQuery('#ek5Tablosu tbody').append(satirRow);
	    		}
			    
			//    var satirText = '<tr class="tablo_row2 even" id="tablo_kurulus_6"><td class="  sorting_1"><input type="text" id="inputkurulus-1-6" name="inputkurulus-1[]" size="4" value="6" readonly=""></td><td class=" "><input type="text" id="inputkurulus-2-6" name="inputkurulus-2[]" size="40"></td><td width="10%" class="tablo_sil_hucre "><input type="button" id="satirSil_kurulus-6" value="SİL"></td></tr>';
		   	//	jQuery('#tablo_kurulus  tbody').append(satirText);
		    }
		    jQuery("#kurulusTopluEklemeTextArea").val("");
		    jQuery("#kurulusTopluEklemeDiv").toggle("slow");

		    tabloyuDuzenle();
			return false;
		});
        
        jQuery('.gelistirenKurulusSilButton').live("click", function(e){
        	jQuery(this.getParent().getParent()).remove();
        	if(jQuery('#gelistirenKurulusTable tbody tr:not(#emptytablegelistiren)').length == 0){
        		jQuery("#emptytablegelistiren").show();
            }
        	adjustNumbersOfTable();
        });
        jQuery('.yeniKurulusEkleButton').live("click", function(e){
			jQuery("#emptytablegelistiren").hide();
        	var eklenecekSatirlar = jQuery('#satirSayisiTextbox');

        	if(!isNaN(parseInt(jQuery('#satirSayisiTextbox').val())))
        	{
        		var count = parseInt(jQuery('#satirSayisiTextbox').val());
        		jQuery('#gelistirenKurulusTable tbody tr td.dataTables_empty').parent().remove();
        		
        		for(var i=0; i<count; i++)
        		{
        			
        			var satirCount = jQuery('#gelistirenKurulusTable tbody tr:not(#emptytablegelistiren)').length + 1;
        			
        			var rowClass = "even";
        			if(satirCount%2 == 1) rowClass = "odd";
        			
        			var satir = '<tr class="'+rowClass+'">'
        			+ '<td>'+satirCount+'</td>'
        			+ '<td> <input type="text" name="inputhazirlayan-2[]" class="required"  style="width:100%;"  /> </td>'
        			+ '<td>'
        			+'<input type="radio" name="inputhazirlayan-3-'+satirCount+'[]" style="margin-left:10%;" value="1" class="yardyuklenici">Yüklenici<br>'
        			+'<input type="radio" name="inputhazirlayan-3-'+satirCount+'[]" style="margin-left:10%;" value="2" class="yardyuklenici">Yardımcı'
        			+ '</td>'
        			+ '<td style><input type="button" class="gelistirenKurulusSilButton" value="Sil"></td>'
        			+ '</tr>';

        			jQuery('#gelistirenKurulusTable tbody').append(satir);
        				
        		}
        						
        	}
        });
	});

	function adjustNumbersOfTable()
	{
		var rows = jQuery('#gelistirenKurulusTable tbody tr:not(#emptytablegelistiren)');
		for(var i=0; i<rows.length; i++)
		{
			rows[i].getChildren()[0].innerHTML = (i+1);
		}
	}
	
	dTables.taslakPdf = new Array(new Array("text","read_only", "55"), new Array("upload"));

	function belgelerInit (tableName){
		var rowCount = 4; //1
		for(var i=1;i<rowCount;i++){
			document.getElementById ("satirEkle_"+tableName).onclick();
		}

		var belgeAciklamalari = new Array(
			"Resmi görüşe/Kamuoyuna sunmadan önceki taslak",
			"Sektör Komitelerine sunmadan önceki taslak",
			"Yönetim Kuruluna sunmadan önceki taslak",
			"REGA"
		); //2

		for(var i=1;i<=rowCount;i++){
			var inp = document.getElementById("input"+tableName+"-1-" +i);
			inp.value = belgeAciklamalari[i-1];
			inp.setAttribute("readonly","readonly");
			<?php if(!$this->sektorSorumlusu){ ?>
			var inp_file = document.getElementById(tableName+"_0_file_" +i);
			inp_file.setAttribute("disabled","disabled");
			jQuery(".up_submitbtn").attr("disabled","disabled");
			<?php } ?>
		}
		addTaslakPdf (tableName);
		satirEkleKaldir (tableName);
		satirSilKaldir (tableName, 2);
	}
	function userSubmit (index, standart_id){
		var form = document.ChronoContact_meslek_std_taslak;
		if (index == 1){
			form.action = 'index.php?option=com_meslek_std_taslak&task=sektorSorumlusunaGonder&standart_id='+standart_id;  
	    }else if (index == 2){ // Onaylanmis
	    	form.action = 'index.php?option=com_meslek_std_taslak&task=onBasvuruBitir&standart_id='+standart_id;  
		}else if (index == 3){ // Onaylanmis Taslak Basvuru
	    	form.action = 'index.php?option=com_meslek_std_taslak&task=basvuruBitir&standart_id='+standart_id;  
		} 
		form.submit(); 
	}
	function addTaslakPdf (tableName){
		var paths = new Array ();
		var fileNames = new Array ();
		<?php
		
		$path2 = FormFactory::normalizeVariable ($standartBilgi["RESMI_GORUS_ONCESI_PDF"]);
		$path3 = FormFactory::normalizeVariable ($standartBilgi["SEKTOR_KOMITESI_ONCESI_PDF"]);
		$path4 = FormFactory::normalizeVariable ($standartBilgi["YONETIM_KURULU_ONCESI_PDF"]);
		$path5 = FormFactory::normalizeVariable ($standartBilgi["SON_TASLAK_PDF"]);
		
		//echo "paths[0] = '".$path1."';";
		echo "paths[0] = '".$path2."';";
		echo "paths[1] = '".$path3."';";
		echo "paths[2] = '".$path4."';";
		echo "paths[3] = '".$path5."';";
		
		$filename2 = FormFactory::getNormalFilename(basename  ($path2));
		$filename3 = FormFactory::getNormalFilename(basename  ($path3));
		$filename4 = FormFactory::getNormalFilename(basename  ($path4));
		$filename5 = FormFactory::getNormalFilename(basename  ($path5));

		//echo "fileNames [0] = '".FormFactory::getNormalFilename(basename  ($path1))."';";
		echo "fileNames [0] = '".(strlen($filename2) > 10 ? substr($filename2,0,10)."....".substr($filename2,-3) : $filename2)."';";
		echo "fileNames [1] = '".(strlen($filename3) > 10 ? substr($filename3,0,10)."....".substr($filename3,-3) : $filename3)."';";
		echo "fileNames [2] = '".(strlen($filename4) > 10 ? substr($filename4,0,10)."....".substr($filename4,-3) : $filename4)."';";
		echo "fileNames [3] = '".(strlen($filename5) > 10 ? substr($filename5,0,10)."....".substr($filename5,-3) : $filename5)."';"; //5
		?>
		var id = tableName + "_0";
		for (var i = 0; i < 5; i++){//6
			if (paths[i] != null && paths[i] != ''){
				var sira = i+1;
				
				var resultDiv 	= document.getElementById(id + "_result_div_" + sira);
				var inputPath = '<input type="hidden" value="'+paths[i]+'" name="path_'+tableName+'_0_'+sira +'">' +
								'<input type="hidden" value="" name="filename_'+tableName+'_0_'+sira +'">';				

				var result = inputPath + '<br><div id="success_'+tableName+'_0_'+sira+'" class="up_success">'+fileNames[i]+' yüklendi!</div><div> <input type="button" value="İndir / Oku" onclick="window.location.href=\'index.php?option=com_meslek_std_taslak&amp;view=taslak_revizyon&amp;task=indir&amp;id='+sira+'&amp;standart_id=<?php echo $this->standart_id;?>&amp;revize_no=<?php echo $_GET[revize_no];?>\'" class="up_submitbtn" style="float:none;"><input type="button" value="Sil / Değiştir" onclick="window.location.href=\'index.php?option=com_meslek_std_taslak&amp;view=taslak_revizyon&amp;task=sil&amp;id='+sira+'&amp;standart_id=<?php echo $this->standart_id;?>&amp;revize_no=<?php echo $revize_no;?>\'" class="up_submitbtn" style="float:none;"></div>';
				resultDiv.innerHTML = result;
			
				var uploadSpan = document.getElementById(id + "_upload_form_span_" + sira);
				uploadSpan.style.visibility = 'hidden';
				uploadSpan.style.height = 0;
			}
		}
	}

	function saveSection(section,parameters){
		jQuery.ajax({
 			type: "POST",
 			dataType:"json",
 			url: "index.php?option=com_meslek_std_taslak&task=taslakKaydetYeni&format=raw&section="+section,
 			data: parameters,
 			beforeSend:function(){
 				 jQuery.blockUI();
	 		},
 			success: function(data){ 
 				if(data.ERROR_STATUS == true){
 	 				alert(data.ERROR_MESSAGE);
 	 			}
 			},
 			complete : function (){
 				jQuery.unblockUI();
 				window.location.reload();
             }
 		});
	}
	function tabloyuDuzenle(){
		var rowElements = jQuery('#ek5Tablosu tbody tr:not(#emptytable)');
		for(var i=0; i<rowElements.length; i++)
		{
			var classname = "even";
			if(i%2 == 1)
				classname = "odd";
				
			jQuery(rowElements[i]).attr("class", classname);
			jQuery(rowElements[i].getChildren()[0]).html(i+1);
		}		
	}

<?php 
	if ($this->canEdit)
		echo "var isReadOnly = false;";
	else
		echo "var isReadOnly = true;";
?>
	var readOnly = null;
	if (isReadOnly)
		readOnly = "readOnly";

	dTables.standart = new Array(new Array("text","required","4", "", readOnly),
			                       	   new Array("text","required","" , "", readOnly),	
									   new Array("textarea", "", "3","30", readOnly));

	function createTables(){
		var tableName = 'standart';
		var headers = new Array ('Sıra No', 'Uluslararası Standart Kodu', 'Açıklama');
		createTable(tableName, headers);
		patchSatirEkle(tableName, headers, tableName);
		addStandartValues (dTables.standart, tableName);

		if (isReadOnly){
			satirEkleKaldir (tableName);
			satirSilKaldir (tableName, 3);
		}

		tableName = "taslakPdf";
		createTable(tableName, new Array('Açıklama', 'PDF'));
		belgelerInit (tableName);
	}

	function addStandartValues (standart, name){
		var length = standart.length;
		var params = new Array ();
		var arr    = new Array ();
		
		for (var i = 0; i < length; i++){
			params[i] = standart[i][0];
		}
		<?php
		$tableCount = count ($this->meslekStandart);

		$c = 0;
		$id = 0;
		for ($i=0; $i< $tableCount; $i++) {
			$arr = $this->meslekStandart[$i];
			
			echo 'arr['.$c++.']= "'. ($i+1) .'";';
			echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["STANDART_ADI"]) .'";';
		    echo 'arr['.$c++.']= "'. FormFactory::normalizeVariable ($arr["STANDART_ACIKLAMA"]) .'";';
		}
		
		?>
		if (isset (arr))
			addTableValues (arr, params, name);
	}
</script>
