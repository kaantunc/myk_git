<?php 
echo $this->pageTree;
$yonetimKuruluTarihleri1 = $this->yonetimKuruluTarihleri1;
$yonetimKuruluTarihleri2 = $this->yonetimKuruluTarihleri2;
$yonetimKurulu = $this->yonetimKurulu;
if ($_REQUEST["etkin"]==""){
    $_REQUEST["etkin"]=1;
}


?>

<div style="width:100%; float: none; text-align:center;">
<?php
echo "<select id='tarih'>";
$i=0;
foreach ($yonetimKuruluTarihleri1 as $row){
    if ($i==0){$sontarih1=$row['TARIH'];}
    $i++;
	echo '<option value="'.$row['TARIH'].'"';
    if ($_REQUEST["tarih"]==$row['TARIH'] and $_REQUEST["etkin"]==1){echo " selected";}
    echo '>'.tariheDonustur($row['TARIH']).'</option>';
}
?>
</select>
<input type='button' style="width: 250px;" value='Yönetim Kurulu (Asil) listesini getir' onclick='listeGetir(jQuery("#tarih").val(),1);' />
</div>

<div style="width:100%; float: none; text-align:center;">
<?php
echo "<select id='tarih2'>";
$i=0;
$sira=0;
foreach ($yonetimKuruluTarihleri2 as $row){
    if ($i==0){$sontarih2=$row['TARIH'];}
    $i++;
	echo '<option value="'.$row['TARIH'].'"';
    if ($_REQUEST["tarih"]==$row['TARIH'] and $_REQUEST["etkin"]==2){echo " selected";}
    echo '>'.tariheDonustur($row['TARIH']).'</option>';
}
?>
</select>
<input type='button' style="width: 250px;" value='Yönetim Kurulu (Yedek) listesini getir' onclick='listeGetir(jQuery("#tarih2").val(),2);' />
</div>
<div style="padding-top:25px;padding-bottom: 15px;width:100%;float: none;text-align:center; font-size:16px; font-weight: bold;">
<?php
if ($_REQUEST["etkin"]==1){
    if ($_REQUEST["tarih"]==""){$_REQUEST["tarih"]=$sontarih1;} 
    echo tariheDonustur($_REQUEST["tarih"])." tarihli Asil Liste";
} else {
    if ($_REQUEST["tarih"]==""){$_REQUEST["tarih"]=$sontarih2;} 
    echo tariheDonustur($_REQUEST["tarih"])." tarihli Yedek Liste";
}
?>
</div>
<div style="width:100%;float: none;">
<form action="index.php?option=com_admin&layout=yonetim&task=yonetimKaydet" method="post" id="yonetimKuruluForm">
<table id="yonetimKuruluListesi" style="margin-left: auto; margin-right: auto;" >
    <tr id="yonetimKuruluListeBaslik">
        <td style="font-weight: bold; text-align: center;">Sıra</td>
    	<td style="font-weight: bold; text-align: center; width:20px;">Ön Ek</td>
        <td style="font-weight: bold; text-align: center; width:80px;">Adı Soyadı</td>
        <td style="font-weight: bold; text-align: center; width:80px;">Ünvanı</td>
        <td style="font-weight: bold; text-align: center; width:80px;">Kurum</td>
        <td style="font-weight: bold; text-align: center; width:20px;">Başlangıç</td>
        <td style="font-weight: bold; text-align: center; width:20px;">Bitiş</td>
        <td style="font-weight: bold; text-align: center; width:10px;">Sil?</td>
    </tr>
<?php
$i=0;
$sira=0;
foreach ($yonetimKurulu as $arr) {
    $i++;
    $sira=$i*10;
    echo '
        <tr id="yonetimKuruluSatir'.$i.'">
            <input type="hidden" name="datatablosuId" value="'.$i.'">
            <td style=""><input name="sira[]" id="sira'.$i.'" value="'.$sira.'" style="width:25px"></td>
            <td style=""><input name="onek[]" id="onek'.$i.'" value="'.FormFactory::normalizeVariable ($arr["ON_EK"]).'" style="width:50px"></td>
            <td style=""><input name="adsoyad[]" id="adsoyad'.$i.'" value="'.FormFactory::normalizeVariable ($arr["AD_SOYAD"]).'" style="width:160px"></td>
            <td style=""><input name="unvan[]" id="unvan'.$i.'" value="'.FormFactory::normalizeVariable ($arr["UNVAN"]).'" style="width:150px"></td>
            <td style=""><input name="kurum[]" id="kurum'.$i.'" value="'.FormFactory::normalizeVariable ($arr["KURUM"]).'" style="width:150px"></td>
            <td style=""><input name="baslangic[]" id="baslangic'.$i.'" value="'.FormFactory::normalizeVariable (tariheDonustur($arr["BASLANGIC"])).'" class="baslangictarihi" style="width:100px"></td>
            <td style=""><input name="bitis[]" id="bitis'.$i.'" value="'.FormFactory::normalizeVariable (tariheDonustur($arr["BITIS"])).'" class="bitistarihi" style="width:100px"></td>
            <td style="text-align: center;"><input type="button" value="Sil" onclick="satirsil('.$i.');"></td>
        </tr>
        ';
}
?>
</table>
<div style="width:100%;float: none;text-align:center; padding-bottom: 15px;">
    <input type="button" value="Yeni Satır Ekle" onclick="satirekle('yonetimKuruluListesi');"/>
</div>
<div style="width:100%;float: none;text-align:center;">
    Yeni Tarih: <input name="tarih" id="tarih" value="<?php echo tariheDonustur(time());?>">
</div>
<div style="width:100%;float: none;text-align:center;">
    <select name="etkin" id="etkin">
        <option value="1"<?php if($_REQUEST["etkin"]==1){echo " selected";}?>>ASİL Listeye</option>
        <option value="2"<?php if($_REQUEST["etkin"]==2){echo " selected";}?>>YEDEK Listeye</option>
    </select>
    <input type="submit" value="Kaydet" />
</div>
</form>
</div>
<script>
function listeGetir(tarih,etkin){
    window.location="index.php?option=com_admin&layout=yonetim&tarih="+tarih+"&etkin="+etkin;
}

window.datatablosuAdi="yonetimKuruluListesi";
window.datatablosuSatiradi="yonetimKuruluSatir";
dtalanlar= new Array("sira","onek","adsoyad","unvan","kurum","baslangic","bitis");
dtalanlarsize= new Array("25","50","160","150","150","100","100");
window.datatablosuAlanlar=dtalanlar;
window.datatablosuAlanlarSize=dtalanlarsize;
window.count=dtalanlar.length;
window.yeniSatirId = parseFloat(jQuery('input[name="datatablosuId"]').val())+1;
if (!window.yeniSatirId){
	window.yeniSatirId=2;
}

function satirsil(id){
    jQuery("#"+window.datatablosuSatiradi+id).hide("slow");
    for(i=0;i<window.count;i++){
        jQuery("#"+window.datatablosuAlanlar[i]+id).val("");        
    }
    window.son=i;
}
function satirekle(id){
    satir='<tr id="yonetimKuruluSatiry'+window.yeniSatirId+'">';
    sira=<?php if ($sira){echo $sira;} else {echo 0;}?>+window.yeniSatirId*10-10;
    for(i=0;i<window.count;i++){
        if (window.datatablosuAlanlar[i]=="baslangic"){
            classname="baslangictarihi";
        } else if(window.datatablosuAlanlar[i]=="bitis"){
        	classname="bitistarihi";
        } else {
        	classname="";
        }
        if (window.datatablosuAlanlar[i]=="sira"){        
        	satir=satir+"<td><input name="+window.datatablosuAlanlar[i]+"[] id="+window.datatablosuAlanlar[i]+"y"+window.yeniSatirId+" class='"+classname+"' value='"+sira+"' style='width:"+window.datatablosuAlanlarSize[i]+"px'></td>";        
        } else {
            satir=satir+"<td><input name="+window.datatablosuAlanlar[i]+"[] id="+window.datatablosuAlanlar[i]+"y"+window.yeniSatirId+" class='"+classname+"' style='width:"+window.datatablosuAlanlarSize[i]+"px'></td>";        
        }
    }
    satir=satir+'<td style="text-align: center;"><input type="button" value="Sil" onclick="satirsil(\'y'+window.yeniSatirId+'\');"></td></tr>';
    jQuery("#"+window.datatablosuAdi).append(satir);
    window.yeniSatirId=window.yeniSatirId+1;
    datepickercalistir();
}
function datepickercalistir() {	
	jQuery( ".baslangictarihi" ).datepicker({ });
	jQuery( ".bitistarihi" ).datepicker({ });
};
datepickercalistir();
</script>
