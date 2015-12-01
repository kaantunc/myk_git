<?php 
$sektorSorumlusu = $this->sektorSorumlusu;
$ekipman=$this->ekipman;
?>
<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">3.2.	Kullanılan Araç, Gereç ve Ekipman</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>


<form
<?php 
$task = "task=taslakKaydet";
echo 'action="index.php?option=com_meslek_std_taslak&amp;layout=ekipman&amp;'.$task.'&amp;standart_id='.$this->standart_id.'"'	
?>
	onSubmit = "return validate('ChronoContact_meslek_std_taslak')"
	enctype="multipart/form-data" method="post"
	id="ChronoContact_meslek_std_taslak"
	name="ChronoContact_meslek_std_taslak">

<input type="hidden" name="evrak_id" value="<?php echo $this->evrak_id?>" />

<?php 
echo $this->pageTree;
?>

<div id="topluEkleDiv" style="border: 1px solid #00A7DE; padding: 10px; width:600px;height:500px;display:none;background-color: white;">
<textarea id="topluEkleText" cols="82" rows="30"></textarea>
<input type="button" id="ekleButton" value="Listeye Ekle" />
</div>

    <div style="width:100%;float: none;">
    <table id="ekipmanListesi" style="margin-left: auto; margin-right: auto;" >
    <thead class="tablo_header">
        <tr id="ekipmanListeBaslik">
            <td style="font-weight: bold; text-align: center;">Sıra No</td>
            <td style="font-weight: bold; text-align: center;">Ekipman</td>
            <td style="font-weight: bold; text-align: center;">Sil?</td>
        </tr>
    </thead>
    <?php
    $i=0;
    foreach ($ekipman as $arr) {
        $i++;
        echo '
            <tr id="ekipmanSatir'.$i.'" class="tablo_row">
                <input type="hidden" name="datatablosuId" value="'.$i.'">
                <td style="text-align:center;">'.$i.'</td>
                <td style=""><input name="ekipman[]" size=75 id="ekipman'.$i.'" value="'.FormFactory::normalizeVariable ($arr["EKIPMAN_ADI"]).'"></td>
                <td style="text-align: center;"><input type="button" value="Sil" onclick="satirsil('.$i.');"></td>
            </tr>
            ';
    }
    echo "<script>
    window.sonSatir=".$i."
    </script>";
    ?>
    </table>
    <div style="width:100%;float: none;text-align:center; padding-bottom: 15px;">
        <input type="button" value="Yeni Satır Ekle" style="" onclick="satirekle('ekipmanListesi');"/>
        <input type="button" id="topluEkleLink" value="Toplu Satır Ekle">
    </div>
    </div>
<?php 
if ($this->canEdit){
?>
    <div style="width:100%;float: none;text-align:center;">
        <input type="submit" value="Kaydet" />
    </div>
<?php 
}

echo $this->yorumDiv;

if ($this->sektorSorumlusu && $this->yorumDiv!=""){
?>
    <div style="width:100%;float: none;text-align:center;">
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('ekipman', <?php echo $this->standart_id;?>)"/>
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
		
window.datatablosuAdi="ekipmanListesi";
window.datatablosuSatiradi="ekipmanSatir";
dtalanlar= new Array("ekipman");
window.datatablosuAlanlar=dtalanlar;
window.count=dtalanlar.length;
window.yeniSatirId = jQuery('input[name="datatablosuId"]').val()+1;

function satirsil(id){
    jQuery("#"+window.datatablosuSatiradi+id).hide("slow");
    for(i=0;i<window.count;i++){
        jQuery("#"+window.datatablosuAlanlar[i]+id).val("");        
    }
    window.son=i;
}
function satirekle(id,veri){
    if (veri==null){veri="";}
    var yeniSatir=window.sonSatir+1;
    satir='<tr class="tablo_row" id="ekipmanSatiry'+window.yeniSatirId+'"><td style="text-align:center;">'+yeniSatir+'</td>';
    for(i=0;i<window.count;i++){
        satir=satir+"<td><input name="+window.datatablosuAlanlar[i]+"[] size=75 id="+window.datatablosuAlanlar[i]+"y"+window.yeniSatirId+" value='"+veri+"'></td>";        
    }
    satir=satir+'<td style="text-align: center;"><input type="button" value="Sil" onclick="satirsil(\'y'+window.yeniSatirId+'\');"></td></tr>';
    jQuery("#"+window.datatablosuAdi).append(satir);
    window.yeniSatirId=window.yeniSatirId+1;
    window.sonSatir=yeniSatir;
}
//satirekle('ekipmanListesi');

jQuery('#topluEkleLink').click(function(e) {
    jQuery('#topluEkleDiv').lightbox_me({
        centered: true, 
        });
    e.preventDefault();
});

jQuery('#ekleButton').click(function(e) {
    text=jQuery("#topluEkleText").val ();
    text=text.replace("\r\n","\n");
    text=text.split("\n");
    var veri= new Array();
	var adet = text.length;
    for (j=0;j<adet;j++){
        if (text[j].replace(" ","")!=""){
            yenitext=text[j].split(". ");
            if (yenitext.length>1){
                yenitext1="";
                for (i=1;i<yenitext.length;i++){
                    yenitext1=yenitext1+yenitext[i]+". "
                }
                yenitext1=rtrim(yenitext1,". ");
            } else {
                yenitext1=text[j];
            }
            veri.push(trim(yenitext1)) ;
        }
    }
    
    for(k=0;k<veri.length;k++){
        satirekle('ekipmanListesi',veri[k]);
        jQuery("#topluEkleText").val ("Satırlar eklendi..");
        setTimeout(function(){
            jQuery('#topluEkleDiv').trigger('close');
            jQuery("#topluEkleText").val ("");
        }, 1000);
        
    }

});

</script>
