<?php 
echo $this->pageTree;
$sektorler = $this->sektorler;
if ($_REQUEST["sektorId"]!=""){
    $komiteTarihleri = $this->komiteTarihleri;
    $sektorKomitesi = $this->sektorKomitesi;
}


?>

<div style="width:100%; float: none; text-align:center;">
<?php
echo "<select id='sektor'><option value=''>Bir Sektör Seçiniz</option>";
foreach ($sektorler as $row){
	echo '<option value="'.$row['SEKTOR_ID'].'"';
    if ($_REQUEST["sektorId"]==$row['SEKTOR_ID']){echo " selected";$sektoradi=$row['SEKTOR_ADI'];}
    echo '>'.$row['SEKTOR_ADI'].'</option>';
}
echo "</select>";
if ($komiteTarihleri==false){
?>
<input type='button' value='Sektörünü Seç' onclick='listeGetir(jQuery("#sektor").val(),"");' />
</div>
<?php 
} else {
?>
        <?php
        echo "<select id='tarih'>";
        $i="";
        foreach ($komiteTarihleri as $row){
        if ($i==0){$sontarih=$row['TARIH'];}
        $i++;
        	echo '<option value="'.$row['TARIH'].'"';
            if ($_REQUEST["tarih"]==$row['TARIH']){echo " selected";}
            echo '>'.tariheDonustur($row['TARIH']).'</option>';
        }
        ?>
        </select>
    </div>
    <div style="width:100%; float: none; text-align:center;">
        <input type='button' value='Liste Getir' onclick='listeGetir(jQuery("#sektor").val(),jQuery("#tarih").val());' />
    
    </div>

<div style="padding-top:25px;padding-bottom:25px;width:100%;float: none;text-align:center; font-size:16px; font-weight: bold;">
<?php
    if ($_REQUEST["tarih"]==""){$_REQUEST["tarih"]=$sontarih;} 
    echo "<u>".$sektoradi."</u> Sektörünün <u>".tariheDonustur($_REQUEST["tarih"])." Tarihli Listesi";
?>
</div>
<?php
}
if ($_REQUEST["sektorId"]!=""){
?>    
    
    <div style="width:100%;float: none;">
    <form action="index.php?option=com_admin&layout=komite&task=komiteKaydet&sektorId=<?php echo $_REQUEST["sektorId"];?>" method="post" id="sektorKomitesiForm">
    <table id="sektorKomitesiListesi" style="margin-left: auto; margin-right: auto;" >
        <tr id="sektorKomitesiListeBaslik">
            <td style="font-weight: bold; text-align: center;">Sıra</td>
            <td style="font-weight: bold; text-align: center;">Temsil Ettiği Kurum</td>
            <td style="font-weight: bold; text-align: center;">Ön Ek</td>
            <td style="font-weight: bold; text-align: center;">Adı Soyadı</td>
            <td style="font-weight: bold; text-align: center;">Komite Ünvanı</td>
            <td style="font-weight: bold; text-align: center;">Çalıştığı Kurum</td>
            <td style="font-weight: bold; text-align: center;">Kurum Ünvanı</td>
            <td style="font-weight: bold; text-align: center;">Sil?</td>
        </tr>
    <?php
    $i=0;
    foreach ($sektorKomitesi as $arr) {
        $i++;
        $sira=$i*10;
        echo '
            <tr id="sektorKomitesiSatir'.$i.'">
                <input type="hidden" name="datatablosuId" value="'.$i.'">
                <td style=""><input name="sira[]" id="sira'.$i.'" value="'.$sira.'" style="width:25px"></td>
                <td style=""><input name="temsil[]" id="temsil'.$i.'" value="'.FormFactory::normalizeVariable ($arr["TEMSIL_ETTIGI_KURUM"]).'" style="width:160px"></td>
                <td style=""><input name="onek[]" id="onek'.$i.'" value="'.FormFactory::normalizeVariable ($arr["UNVANI"]).'" style="width:60px"></td>
                <td style=""><input name="adsoyad[]" id="adsoyad'.$i.'" value="'.FormFactory::normalizeVariable ($arr["AD_SOYAD"]).'" style="width:150px"></td>
                <td style=""><input name="komiteUnvani[]" id="komiteUnvani'.$i.'" value="'.FormFactory::normalizeVariable ($arr["KOMITE_UNVANI"]).'" style="width:100px"></td>
                <td style=""><input name="calistigi_kurum[]" id="calistigi_kurum'.$i.'" value="'.FormFactory::normalizeVariable ($arr["CALISTIGI_KURUM"]).'" style="width:150px"></td>
                <td style=""><input name="kurum_unvani[]" id="kurum_unvani'.$i.'" value="'.FormFactory::normalizeVariable ($arr["KURUM_UNVANI"]).'" style="width:150px"></td>
                <td style="text-align: center;"><input type="button" value="Sil" onclick="satirsil('.$i.');"></td>
            </tr>
            ';
    }
    ?>
    </table>
    <div style="width:100%;float: none;text-align:center; padding-bottom: 15px;">
        <input type="button" value="Yeni Satır Ekle" style="" onclick="satirekle('sektorKomitesiListesi');"/>
    </div>
    <div style="width:100%;float: none;text-align:center;">
        <input type="hidden" name="sektor" id="sektor" value="<?php echo $_REQUEST["sektorId"];?>">
        Yeni Tarih: <input name="tarih" id="tarih" value="<?php echo tariheDonustur(time());?>">
    </div>
    <div style="width:100%;float: none;text-align:center;">
        <input type="submit" value="Kaydet" />
    </div>
    </form>
    </div>

<?php
}
?>

<script>
function listeGetir(sektor,tarih){
        window.location="index.php?option=com_admin&layout=komite&sektorId="+sektor+"&tarih="+tarih;
}



window.datatablosuAdi="sektorKomitesiListesi";
window.datatablosuSatiradi="sektorKomitesiSatir";
dtalanlar= new Array("sira","temsil","onek","adsoyad","komiteUnvani","calistigi_kurum","kurum_unvani");
dtalanlarsize= new Array("25","160","60","150","100","150","150");
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
    satir='<tr id="sektorKomitesiSatiry'+window.yeniSatirId+'">';
    sira=<?php if ($sira){echo $sira;} else {echo 0;}?>+window.yeniSatirId*10-10;
    for(i=0;i<window.count;i++){
        if (window.datatablosuAlanlar[i]=="sira"){
        	satir=satir+"<td><input name="+window.datatablosuAlanlar[i]+"[] id="+window.datatablosuAlanlar[i]+"y"+window.yeniSatirId+" style='width:"+window.datatablosuAlanlarSize[i]+"px' value='"+sira+"'></td>";
        } else {
        	satir=satir+"<td><input name="+window.datatablosuAlanlar[i]+"[] id="+window.datatablosuAlanlar[i]+"y"+window.yeniSatirId+" style='width:"+window.datatablosuAlanlarSize[i]+"px'></td>";
        }        
    }
    satir=satir+'<td style="text-align: center;"><input type="button" value="Sil" onclick="satirsil(\'y'+window.yeniSatirId+'\');"></td></tr>';
    jQuery("#"+window.datatablosuAdi).append(satir);
    window.yeniSatirId=window.yeniSatirId+1;
}
</script>
<?php
if ($_REQUEST[sektorId]!=""){
    ?>
<script>
satirekle('sektorKomitesiListesi');
</script>
<?php
}
?>