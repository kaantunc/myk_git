<?php 
$sektorSorumlusu = $this->sektorSorumlusu;
$yonetimKuruluTarihleri = $this->yonetimKuruluTarihleri;
$genelKurulTarihleri = $this->genelKurulTarihleri;
$komiteTarihleri = $this->komiteTarihleri;
$gorevAlan = $this->gorevAlan;    
?>
<form
<?php 
$task = "task=taslakKaydet";
echo 'action="index.php?option=com_meslek_std_taslak&amp;layout=gorev_alanlar&amp;'.$task.'&amp;standart_id='.$this->standart_id.'"'	
?>
	onSubmit = "return validate('ChronoContact_meslek_std_taslak')"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_meslek_std_taslak"
	name="ChronoContact_meslek_std_taslak">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id;?>" />

<?php 
echo $this->pageTree;
?>

<div class="form_item">
	<div class="form_element cf_placeholder"> 
		<label class="cf_label" style="color:red;">Not: Bu kısım Resmi Gazete’de yayımlanmayacaktır. Sadece MYK web sitesinde yer alacaktır.</label>
	</div> 
</div>

<br />
<br />

<div class="form_item">
  <div class="form_element cf_heading">
  	<h1 class="contentheading">Ek: Meslek Standardı Hazırlama Sürecinde Görev Alanlar</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">1. Meslek Standardı Hazırlayan Kuruluşun Meslek Standardı Ekibi</h2>
  </div><div class="cfclear">&nbsp;</div>
    <div class="form_item">
    	<div class="form_element cf_placeholder">
    		<div id="gorevAlanlar1_div">
                <table id="gorevAlanlarListesi1" style="width: 100%;">
                    <thead class="tablo_header">
                        <tr>
                            <th>Sıra No</th>
                            <th>Ad / Soyad</th>
                            <th>Unvan</th>
                            <th>Kurum / Kuruluş</th>
                            <th>Satırı Sil?</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    $i=0;
    foreach ($gorevAlan[0] as $row) {
        $i++;
        echo '
                        <tr class="tablo_row" id="gorevAlanlarSatir1'.$i.'">
                            <td style="text-align:center;"><input type="hidden" id="datatablosuId1" value="'.$i.'">'.$i.'</td>
                            <td><input type="text" id="adSoyad1'.$i.'" name="adSoyad[1][]" size="25" class="required" value="'. FormFactory::normalizeVariable ($row["GOREV_ALAN_AD_SOYAD"]) .'"></td>
                            <td><input type="text" id="unvan1'.$i.'" name="unvan[1][]" size="25" value="'. FormFactory::normalizeVariable ($row["GOREV_ALAN_UNVAN"]) .'"></td>
                            <td><input type="text" id="kurum1'.$i.'" name="kurum[1][]" size="50" value="'. FormFactory::normalizeVariable ($row["GOREV_ALAN_KURULUS"]) .'"></td>
                        <td width="10%" class="tablo_sil_hucre"><input type="button" value="Sil" onclick="satirsil(1,'.$i.');"></td>
                        </tr>
            ';
    }
    ?>
                    </tbody>
                </table>
                <input type="button" value="Yeni Satır Ekle" style="" onclick="satirekle('gorevAlanlarListesi','',1);"/>
            </div>
    	</div>
    	
    </div>
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="gorevAlanlar2_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">2. Teknik Çalışma Grubu Üyeleri</h2>
  </div><div class="cfclear">&nbsp;</div>
    <div class="form_item">
    	<div class="form_element cf_placeholder">
    		<div id="gorevAlanlar2_div">
                <table id="gorevAlanlarListesi2" style="width: 100%;">
                    <thead class="tablo_header">
                        <tr>
                            <th>Sıra No</th>
                            <th>Ad / Soyad</th>
                            <th>Unvan</th>
                            <th>Kurum / Kuruluş</th>
                            <th>Satırı Sil?</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    $i=0;
    foreach ($gorevAlan[1] as $row) {
        $i++;
        echo '
                        <tr class="tablo_row" id="gorevAlanlarSatir2'.$i.'">
                            <td style="text-align:center;"><input type="hidden" id="datatablosuId2" value="'.$i.'">'.$i.'</td>
                            <td><input type="text" id="adSoyad2'.$i.'" name="adSoyad[2][]" size="25" class="required" value="'. FormFactory::normalizeVariable ($row["GOREV_ALAN_AD_SOYAD"]) .'"></td>
                            <td><input type="text" id="unvan2'.$i.'" name="unvan[2][]" size="25" value="'. FormFactory::normalizeVariable ($row["GOREV_ALAN_UNVAN"]) .'"></td>
                            <td><input type="text" id="kurum2'.$i.'" name="kurum[2][]" size="50" value="'. FormFactory::normalizeVariable ($row["GOREV_ALAN_KURULUS"]) .'"></td>
                        <td width="10%" class="tablo_sil_hucre"><input type="button" value="Sil" onclick="satirsil(2,'.$i.');"></td>
                        </tr>
            ';
    }
    ?>
                    </tbody>
                </table>
                <input type="button" value="Yeni Satır Ekle" style="" onclick="satirekle('gorevAlanlarListesi','',2);"/>
            </div>
    	</div>
    	
    </div>
</div>


<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="gorevAlanlar2_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>


<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">3. Görüş İstenen Kişi, Kurum ve Kuruluşlar</h2>
  </div><div class="cfclear">&nbsp;</div>
    <div class="form_item">
    	<div class="form_element cf_placeholder">
    		<div id="gorevAlanlar3_div">
                <table id="gorevAlanlarListesi3" style="width: 100%;">
                    <thead class="tablo_header">
                        <tr>
                            <th>Sıra No</th>
                            <th>Ad / Soyad</th>
                            <th>Unvan</th>
                            <th>Kurum / Kuruluş</th>
                            <th>Satırı Sil?</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    $i=0;
    foreach ($gorevAlan[2] as $row) {
        $i++;
        echo '
                        <tr class="tablo_row" id="gorevAlanlarSatir3'.$i.'">
                            <td style="text-align:center;"><input type="hidden" id="datatablosuId3" value="'.$i.'">'.$i.'</td>
                            <td><input type="text" id="adSoyad3'.$i.'" name="adSoyad[3][]" size="25" class="required" value="'. FormFactory::normalizeVariable ($row["GOREV_ALAN_AD_SOYAD"]) .'"></td>
                            <td><input type="text" id="unvan3'.$i.'" name="unvan[3][]" size="25" value="'. FormFactory::normalizeVariable ($row["GOREV_ALAN_UNVAN"]) .'"></td>
                            <td><input type="text" id="kurum3'.$i.'" name="kurum[3][]" size="50" value="'. FormFactory::normalizeVariable ($row["GOREV_ALAN_KURULUS"]) .'"></td>
                        <td width="10%" class="tablo_sil_hucre"><input type="button" value="Sil" onclick="satirsil(3,'.$i.');"></td>
                        </tr>
            ';
    }
    ?>
                    </tbody>
                </table>
                <input type="button" value="Yeni Satır Ekle" style="" onclick="satirekle('gorevAlanlarListesi','',3);"/>
            </div>
    	</div>
    	
    </div>
</div>
<div style="width:100%; float: none; text-align:center;;">
<?php
echo "<select id='gtarih'>";
$i=0;
foreach ($genelKurulTarihleri as $row){
	echo '<option value="'.$row['TARIH'].'">'.tariheDonustur($row['TARIH']).'</option>';
}
?>
</select>
<input type='button' value='tarihli Genel Kurul listesini getir' onclick='listeGetir3(jQuery("#gtarih").val());' />
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="gorevAlanlar4_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">4. MYK Sektör Komitesi Üyeleri ve Uzmanlar</h2>
  </div><div class="cfclear">&nbsp;</div>
    <div class="form_item">
    	<div class="form_element cf_placeholder">
    		<div id="gorevAlanlar4_div">
                <table id="gorevAlanlarListesi4" style="width: 100%;">
                    <thead class="tablo_header">
                        <tr>
                            <th>Sıra No</th>
                            <th>Ad / Soyad</th>
                            <th>Komite Unvanı</th>
                            <th>Kurum / Kuruluş</th>
                            <th>Satırı Sil?</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    $i=0;
    foreach ($gorevAlan[3] as $row) {
        $i++;
        echo '
                        <tr class="tablo_row" id="gorevAlanlarSatir4'.$i.'">
                            <td style="text-align:center;"><input type="hidden" id="datatablosuId4" value="'.$i.'">'.$i.'</td>
                            <td><input type="text" id="adSoyad4'.$i.'" name="adSoyad[4][]" size="25" class="required" value="'. FormFactory::normalizeVariable ($row["GOREV_ALAN_AD_SOYAD"]) .'"></td>
                            <td><input type="text" id="unvan4'.$i.'" name="unvan[4][]" size="25" value="'. FormFactory::normalizeVariable ($row["GOREV_ALAN_UNVAN"]) .'"></td>
                            <td><input type="text" id="kurum4'.$i.'" name="kurum[4][]" size="50" value="'. FormFactory::normalizeVariable ($row["GOREV_ALAN_KURULUS"]) .'"></td>
                        <td width="10%" class="tablo_sil_hucre"><input type="button" value="Sil" onclick="satirsil(4,'.$i.');"></td>
                        </tr>
            ';
    }
    ?>
                    </tbody>
                </table>
                <input type="button" value="Yeni Satır Ekle" style="" onclick="satirekle('gorevAlanlarListesi','',4);"/>
            </div>
    	</div>
    	
    </div>
</div>
<div style="width:100%; float: none; text-align:center;;">
<?php
echo "<select id='ktarih'>";
$i=0;
foreach ($komiteTarihleri as $row){
	echo '<option value="'.$row['TARIH'].'">'.tariheDonustur($row['TARIH']).'</option>';
}
?>
</select>
<input type='button' value='tarihli Sektör Komitesi listesini getir' onclick='listeGetir2(jQuery("#ktarih").val(),1);' />
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="gorevAlanlar5_div"></div>
	</div>
	<div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">5. MYK Yönetim Kurulu</h2>
  </div><div class="cfclear">&nbsp;</div>
    <div class="form_item">
    	<div class="form_element cf_placeholder">
    		<div id="gorevAlanlar5_div">
                <table id="gorevAlanlarListesi5" style="width: 100%;">
                    <thead class="tablo_header">
                        <tr>
                            <th>Sıra No</th>
                            <th>Ad / Soyad</th>
                            <th>Unvan</th>
                            <th>Kurum / Kuruluş</th>
                            <th>Satırı Sil?</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    $i=0;
    foreach ($gorevAlan[4] as $row) {
        $i++;
        echo '
                        <tr class="tablo_row" id="gorevAlanlarSatir5'.$i.'">
                            <td style="text-align:center;"><input type="hidden" id="datatablosuId5" value="'.$i.'">'.$i.'</td>
                            <td><input type="text" id="adSoyad5'.$i.'" name="adSoyad[5][]" size="25" class="required" value="'. FormFactory::normalizeVariable ($row["GOREV_ALAN_AD_SOYAD"]) .'"></td>
                            <td><input type="text" id="unvan5'.$i.'" name="unvan[5][]" size="25" value="'. FormFactory::normalizeVariable ($row["GOREV_ALAN_UNVAN"]) .'"></td>
                            <td><input type="text" id="kurum5'.$i.'" name="kurum[5][]" size="50" value="'. FormFactory::normalizeVariable ($row["GOREV_ALAN_KURULUS"]) .'"></td>
                        <td width="10%" class="tablo_sil_hucre"><input type="button" value="Sil" onclick="satirsil(5,'.$i.');"></td>
                        </tr>
            ';
    }
    ?>
                    </tbody>
                </table>
                <input type="button" value="Yeni Satır Ekle" style="" onclick="satirekle('gorevAlanlarListesi','',5);"/>
            </div>
    	</div>
    	
    </div>
  
</div>
<div style="width:100%; float: none; text-align:center;;">
<?php
echo "<select id='ytarih'>";
$i=0;
foreach ($yonetimKuruluTarihleri as $row){
	echo '<option value="'.$row['TARIH'].'">'.tariheDonustur($row['TARIH']).'</option>';
}
?>
</select>
<input type='button' value='tarihli Yönetim Kurulu listesini getir' onclick='listeGetir(jQuery("#ytarih").val(),1);' />
</div>

<div class="form_item">
	<div class="form_element cf_placeholder">
		<div id="gorevAlanlar5_div"></div>
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

if ($sektorSorumlusu && $this->yorumDiv!=""){
?>
	<div class="form_item" style="padding-top: 25px;">
		<div class="form_element cf_button">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('gorev_alanlar', <?php echo $this->standart_id;?>)"/>
		</div>
		<div class="cfclear">&nbsp;</div>
	</div>
<?php 
}


echo $this->yorumDiv_Kurulus;

if (!$this->sektorSorumlusu && $this->yorumDiv_Kurulus!=""){
	?>
    <div style="width:100%;float: none;text-align:center;">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet_Kurulus('bilgi_beceri', <?php echo $this->standart_id;?>)"/>
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

// 3. "required" alani silindi:
function listeGetir(tarih){
    var sendData = "tarih="+tarih;
    
    var url = 'index.php?option=com_meslek_std_taslak&task=ajaxYonetimKuruluGetir&format=raw';
//    var str="";
	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
			     if (jQuery("#adSoyad51").val()==""){
			         satirsil(5,1);
			     }
				  	var arrayToPut = data['array'];
            		var adet = arrayToPut.length;
            		for(var i=0;i<adet;i++){
//                        str=str+arrayToPut[i]["TERIM_ADI"];
                        if (arrayToPut[i]["ON_EK"]){onek=arrayToPut[i]["ON_EK"]+' ';} else {onek="";}
                        veri=Array(onek+arrayToPut[i]["AD_SOYAD"],arrayToPut[i]["UNVAN"],arrayToPut[i]["KURUM"]);
                        satirekle('gorevAlanlarListesi',veri,5);
             		}
                }else{
                    alert("Hata.")
					
			  }
		  }
	});


}

function listeGetir3(tarih){
    var sendData = "tarih="+tarih;
    
    var url = 'index.php?option=com_meslek_std_taslak&task=ajaxGenelKurulGetir&format=raw';
//    var str="";
	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
			     if (jQuery("#adSoyad31").val()==""){
			         satirsil(3,1);
			     }
				  	var arrayToPut = data['array'];
            		var adet = arrayToPut.length;
            		for(var i=0;i<adet;i++){
//                        str=str+arrayToPut[i]["TERIM_ADI"];
                        if (arrayToPut[i]["ON_EK"]){onek=arrayToPut[i]["ON_EK"]+' ';} else {onek="";}
                        veri=Array("","",arrayToPut[i]["KURUM"]);
                        satirekle('gorevAlanlarListesi',veri,3);
             		}
                }else{
                    alert("Hata.")
					
			  }
		  }
	});


}

function listeGetir2(tarih){
    var sendData = "tarih="+tarih;
    
    var url = 'index.php?option=com_meslek_std_taslak&task=ajaxKomiteGetir&format=raw&sektor_id=<?php echo $komiteTarihleri[0]["SEKTOR_ID"];?>';
//    var str="";
	jQuery.ajax({
		  url: url,
		  data: sendData,
		  type: "POST",
		  dataType: 'json',
		  success: function(data) {
			  if(data['success']){
			     if (jQuery("#adSoyad41").val()==""){
			         satirsil(4,1);
			     }
				  	var arrayToPut = data['array'];
            		var adet = arrayToPut.length;
            		for(var i=0;i<adet;i++){
//                        str=str+arrayToPut[i]["TERIM_ADI"];
                        if (arrayToPut[i]["UNVANI"]){onek=arrayToPut[i]["UNVANI"]+' ';} else {onek="";}
                        veri=Array(onek+arrayToPut[i]["AD_SOYAD"],arrayToPut[i]["KOMITE_UNVANI"],arrayToPut[i]["TEMSIL_ETTIGI_KURUM"]);
                        satirekle('gorevAlanlarListesi',veri,4);
             		}
                }else{
                    alert("Hata.")
					
			  }
		  }
	});


}


window.datatablosuAdi="gorevAlanlarListesi";
window.datatablosuSatiradi="gorevAlanlarSatir";
dtalanlar= new Array("adSoyad","unvan","kurum");
window.datatablosuAlanlar=dtalanlar;
window.count=dtalanlar.length;
window.yeniSatirId=new Array();
veri=new Array();
for(a=1;a<6;a++){
    if(jQuery('#datatablosuId'+a).val()){
        window.yeniSatirId[a] = jQuery('#datatablosuId'+a).val()+1;
    } else {
        window.yeniSatirId[a]=1;
    }
}
function satirsil(alan,id){
    jQuery("#"+window.datatablosuSatiradi+alan+id).hide("slow");
    for(i=0;i<window.count;i++){
        jQuery("#"+window.datatablosuAlanlar[i]+alan+id).val("");        
    }
    window.son=i;
}
function satirekle(id,veri,alan){
    window.sonSatir=jQuery("#"+window.datatablosuAdi+alan+" tr").length-1 ;   
    var yeniSatir=window.sonSatir+1;
    satir='<tr id="'+window.datatablosuSatiradi+alan+'y'+window.yeniSatirId[alan]+'" class="tablo_row" ><td style="text-align:center;">'+yeniSatir+'</td>';
    for(i=0;i<window.count;i++){
        size=25;
        if (window.count==i+1){size=50;}
        satir=satir+"<td><input name="+window.datatablosuAlanlar[i]+"["+alan+"]"+"[] id="+window.datatablosuAlanlar[i]+alan+"y"+window.yeniSatirId[alan]+" value='";
        if (veri.length>0){satir=satir+veri[i];}
        satir=satir+"' size='"+size+"'></td>";        
    }
    satir=satir+'<td style="text-align: center;"><input type="button" value="Sil" onclick="satirsil('+alan+',\'y'+window.yeniSatirId[alan]+'\');"></td></tr>';
    jQuery("#"+window.datatablosuAdi+alan).append(satir);
    window.yeniSatirId[alan]=window.yeniSatirId[alan]+1;
    window.sonSatir=yeniSatir;
}

</script>