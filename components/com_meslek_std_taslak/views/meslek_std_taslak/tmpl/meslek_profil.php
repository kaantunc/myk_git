<?php 
$sektorSorumlusu = $this->sektorSorumlusu;
$profil=$this->profil;
?>
<script>
var harfler = ['A', 'B', 'C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','Y','Z'];
window.yeniGorev=1;
var yeniIslemId=new Array();
var BOId=new Array();
var gorevRow=new Array();
var islemRow=new Array();
var gorevSayisi=0;
var islemSayisi=new Array();
var BOSayisi=new Array();
//var sonBasarim=2;
//var sonIslem=2

function yeniGorevEkle(gorev,gdip,islem,idip,bo,bodip){
    islemSayisi[window.yeniGorev] =0;   
    BOSayisi[window.yeniGorev+"-1"]=0;
    if (gorev==undefined){gorev="";}
    if (gdip==undefined){gdip="";}
    if (islem==undefined){islem="";}
    if (idip==undefined){idip="";}
    if (bo==undefined){bo="";}
    if (bodip==undefined){bodip="";}
    sira=10*window.yeniGorev;
    satir='<tr class="tablo_header_acik" id="profil-'+window.yeniGorev+'-1-1">'
        +    '<td id="gorev1-'+window.yeniGorev+'">'+harfler[(window.yeniGorev-1)]+'<br><input type="button" id="gorevSilButon-'+window.yeniGorev+'" value="Sil" onclick="gorevSil('+window.yeniGorev+')" class="gorevSilButon" style="display:none; width: 28px;"><br><input name="sira[]" value="'+sira+'" size="2" class="gsira" style="display:none; width: 28px;"></td>'
        +    '<td id="gorev2-'+window.yeniGorev+'"><textarea name="gorev[]" id="gorev-'+window.yeniGorev+'" rows="4" cols="32">'+gorev+'</textarea><br><textarea name="dipnotGorev[]" id="dipnotGorev-'+window.yeniGorev+'" rows="2" cols="32">'+gdip+'</textarea><br><input type="button" id="islemEkle-'+window.yeniGorev+'" onclick="islemEkle('+window.yeniGorev+')" value="Yeni İşlem Ekle >>"><br><input type="button" onclick="gorunurYap(\'dipnotGorev-'+window.yeniGorev+'\')" value="Dipnot"></td>'
        +    '<td id="islem1-'+window.yeniGorev+'-1">'+harfler[(window.yeniGorev-1)]+'.1</td>'
        +    '<td id="islem2-'+window.yeniGorev+'-1"><textarea name="islem['+(window.yeniGorev-1)+'][]" id="islem-'+window.yeniGorev+'-1" rows="4" cols="32">'+islem+'</textarea><br><textarea name="dipnotIslem['+(window.yeniGorev-1)+'][]" id="dipnotIslem-'+window.yeniGorev+'-1" rows="2" cols="32">'+idip+'</textarea><br><input type="button" id="BOEkle-'+window.yeniGorev+'-1" onclick="BOEkle('+window.yeniGorev+',1)" value="Yeni Başarım Ölçütü Ekle >>"><br><input type="button" onclick="gorunurYap(\'dipnotIslem-'+window.yeniGorev+'-1\')" value="Dipnot"></td>'
        +    '<td>'+harfler[(window.yeniGorev-1)]+'.1.1</td>'
        +    '<td><textarea name="BO['+(window.yeniGorev-1)+'][0][]" id="BO-'+window.yeniGorev+'-1-1" rows="4" cols="32">'+bo+'</textarea><br><textarea name="dipnotBO['+(window.yeniGorev-1)+'][0][]" id="dipnotBO-'+window.yeniGorev+'-1-1" rows="2" cols="32">'+bodip+'</textarea><br><input type="button" onclick="gorunurYap(\'dipnotBO-'+window.yeniGorev+'-1-1\')" value="Dipnot"></td>'
        +'</tr>';
    jQuery("#MPtablosu").append(satir);    
    jQuery("#gorevSilButon-1").removeAttr("disabled"); 
    if (gdip==""){jQuery("#dipnotGorev-"+window.yeniGorev).css("display","none");}
    if (idip==""){jQuery("#dipnotIslem-"+window.yeniGorev+"-1").css("display","none");}
    if (bodip==""){jQuery("#dipnotBO-"+window.yeniGorev+"-1-1").css("display","none");}
    gorevSayisi++;
    islemSayisi[window.yeniGorev]++;
    BOSayisi[window.yeniGorev+"-1"]++;
    if (gorevSayisi<2){
        jQuery('.gorevSilButon').css("display","none");
    } else {
        jQuery('.gorevSilButon').css("display","block")
    }
    window.yeniGorev=window.yeniGorev+1;
}
function islemEkle(id,islem,idip,bo,bodip){
    BOSayisi[id+'-1']=0;
    if (islem==undefined){islem="";}
    if (idip==undefined){idip="";}
    if (bo==undefined){bo="";}
    if (bodip==undefined){bodip="";}
    if(yeniIslemId[id]==null){yeniIslemId[id]=2} else {yeniIslemId[id]++;};
    if(BOId[id+"-"+(yeniIslemId[id]-1)]==null){BOId[id+"-"+(yeniIslemId[id]-1)]=1};
    if(gorevRow[id]==null){gorevRow[id]=1}
    
    gorevRow[id]++;
    
    jQuery("#gorev1-"+id).attr("rowspan",gorevRow[id]);
    jQuery("#gorev2-"+id).attr("rowspan",gorevRow[id]);
    
    satir='<tr class="tablo_header_acik" id="profil-'+id+'-'+yeniIslemId[id]+'-1">'
        +    '<td id="islem1-'+id+'-'+yeniIslemId[id]+'">'+harfler[(id-1)]+'.'+yeniIslemId[id]+'<br /><input type="button" id="islemSilButon-'+id+'-'+yeniIslemId[id]+'" value="Sil" onclick="islemSil('+id+','+yeniIslemId[id]+')" class="islemSilButon-'+id+'" style="display:none;"></td>'
        +    '<td id="islem2-'+id+'-'+yeniIslemId[id]+'"><textarea name="islem['+(id-1)+'][]" id="islem-'+id+'-'+yeniIslemId[id]+'" rows="4" cols="32">'+islem+'</textarea><br><textarea name="dipnotIslem['+(id-1)+'][]" id="dipnotIslem-'+id+'-'+yeniIslemId[id]+'" rows="2" cols="32">'+idip+'</textarea><br><input type="button" id="BOEkle-'+id+'-'+yeniIslemId[id]+'" onclick="BOEkle('+id+','+yeniIslemId[id]+')" value="Yeni Başarım Ölçütü Ekle >>"><br><input type="button" onclick="gorunurYap(\'dipnotIslem-'+id+'-'+yeniIslemId[id]+'\')" value="Dipnot"></td>'
        +    '<td>'+harfler[(id-1)]+'.'+yeniIslemId[id]+'.1</td>'
        +    '<td><textarea name="BO['+(id-1)+']['+(yeniIslemId[id]-1)+'][]" id="BO-'+id+'-'+yeniIslemId[id]+'-1" rows="4" cols="32">'+bo+'</textarea><textarea name="dipnotBO['+(id-1)+']['+(yeniIslemId[id]-1)+'][]" id="dipnotBO-'+id+'-'+yeniIslemId[id]+'-1" rows="2" cols="32">'+bodip+'</textarea><br><input type="button" onclick="gorunurYap(\'dipnotBO-'+id+'-'+yeniIslemId[id]+'-1\')" value="Dipnot"></td>'
        +'</tr>';
    jQuery("#profil-"+id+"-"+(yeniIslemId[id]-1)+"-"+BOId[id+"-"+(yeniIslemId[id]-1)]).after(satir);   
    jQuery("#islemSilButon-"+id+"-1").removeAttr("disabled");
    if (idip==""){jQuery("#dipnotIslem-"+id+"-"+yeniIslemId[id]).css("display","none");}
    if (bodip==""){jQuery("#dipnotBO-"+id+"-"+yeniIslemId[id]+"-1").css("display","none");}
    islemSayisi[id]++;
    BOSayisi[id+'-1']++;
    if (islemSayisi[id]<2){
        jQuery('.islemSilButon-'+id).css("display","none");
    } else {
        jQuery('.islemSilButon-'+id).css("display","block")
    } 

}
function BOEkle(id,islemId,bo,bodip){
    if (bo==undefined){bo="";}
    if (bodip==undefined){bodip="";}
    if(BOId[id+"-"+islemId]==null){BOId[id+"-"+islemId]=2} else {BOId[id+"-"+islemId]++;};
    if(gorevRow[id]==null){gorevRow[id]=1;}
    if(islemRow[id+"-"+islemId]==null){islemRow[id+"-"+islemId]=1;}
    gorevRow[id]++;
    islemRow[id+"-"+islemId]++;
    jQuery("#gorev1-"+id).attr("rowspan",gorevRow[id]);
    jQuery("#gorev2-"+id).attr("rowspan",gorevRow[id]);
    jQuery("#islem1-"+id+"-"+islemId).attr("rowspan", islemRow[id+"-"+islemId]);
    jQuery("#islem2-"+id+"-"+islemId).attr("rowspan", islemRow[id+"-"+islemId]);                                                                                                                                                        
    satir='<tr class="tablo_header_acik" id="profil-'+id+'-'+islemId+'-'+BOId[id+"-"+islemId]+'">'
        +    '<td>'+harfler[(id-1)]+'.'+islemId+'.'+BOId[id+"-"+islemId]+'<br><input type="button" id="BOSilButon-'+id+'-'+islemId+'-'+BOId[id+"-"+islemId]+'" value="Sil" onclick="BOSil('+id+','+islemId+','+BOId[id+"-"+islemId]+')"class="BOSilButon-'+id+'-'+islemId+'" style="display:none;"></td>'
           +    '<td><textarea name="BO['+(id-1)+']['+(islemId-1)+'][]" id="BO-'+id+'-'+islemId+'-'+BOId[id+"-"+islemId]+'" rows="4" cols="32">'+bo+'</textarea><br><textarea name="dipnotBO['+(id-1)+']['+(islemId-1)+'][]" id="dipnotBO-'+id+'-'+islemId+'-'+BOId[id+"-"+islemId]+'" rows="2" cols="32">'+bodip+'</textarea><br><input type="button" onclick="gorunurYap(\'dipnotBO-'+id+'-'+islemId+'-'+BOId[id+"-"+islemId]+'\')" value="Dipnot"></td>'
           +'</tr>';
    jQuery("#profil-"+id+"-"+islemId+'-'+(BOId[id+"-"+islemId]-1)).after(satir);
      
    if (bodip==""){jQuery("#dipnotBO-"+id+"-"+islemId+"-"+BOId[id+"-"+islemId]).css("display","none");}
    BOSayisi[id+'-'+islemId]++;
    if (BOSayisi[id+'-'+islemId]<2){
        jQuery('.BOSilButon-'+id+'-'+islemId).css("display","none");
    } else {
        jQuery('.BOSilButon-'+id+'-'+islemId).css("display","block")
    }
  
}

function gorevSil(id){
    gorevSayisi--;
    islemSayisi[id]--;
    BOSayisi[id+'-1']--;
    if (gorevSayisi<2){
        jQuery('.gorevSilButon').css("display","none");
    } else {
        jQuery('.gorevSilButon').css("display","block")
    }
//    jQuery("#gorev-"+id).val("");
//    jQuery("#profil-"+id+"-1-1").hide("slow");
    jQuery('TR[id*=profil-'+id+']:visible').remove();
}
function islemSil(id,islemId){
    jQuery("#islem-"+id+"-"+islemId).val("");
    var rows = jQuery("#islem1-"+id+"-"+islemId).attr("rowspan");
    jQuery("#profil-"+id+"-"+islemId+"-1").hide("slow");
    gorevRow[id]=gorevRow[id]-rows;
    islemSayisi[id]--;
    BOSayisi[id+'-'+islemId]--;
    if (islemSayisi[id]<2){
        jQuery('.islemSilButon-'+id).css("display","none");
    } else {
        jQuery('.islemSilButon-'+id).css("display","block")
    }
    jQuery("#gorev1-"+id).attr("rowspan",gorevRow[id]);
    jQuery("#gorev2-"+id).attr("rowspan",gorevRow[id]);
    jQuery('TR[id*=profil-'+id+'-'+islemId+']:visible').remove();

}
function BOSil(id,islemId,BOId){

    jQuery("#BO-"+id+"-"+islemId+"-"+BOId).val("");
    jQuery("#profil-"+id+"-"+islemId+"-"+BOId).hide("slow");
    gorevRow[id]--;
    islemRow[id+"-"+islemId]--;
    jQuery("#gorev1-"+id).attr("rowspan",gorevRow[id]);
    jQuery("#gorev2-"+id).attr("rowspan",gorevRow[id]);
    BOSayisi[id+'-'+islemId]--;
    if (BOSayisi[id+'-'+islemId+'-'+BOId]<2){
        jQuery('.BOSilButon-'+id+'-'+islemId).css("display","none");
    } else {
        jQuery('.BOSilButon-'+id+'-'+islemId).css("display","block")
    }
    jQuery("#islem1-"+id+"-"+islemId).attr("rowspan", islemRow[id+"-"+islemId]);
    jQuery("#islem2-"+id+"-"+islemId).attr("rowspan", islemRow[id+"-"+islemId]);
    jQuery('TR[id*=profil-'+id+'-'+islemId+'-'+BOId+']:visible').remove();
    
    
}
function gorunurYap(id){
    jQuery("#"+id).toggle();
    jQuery("#"+id).val("");;
}
</script>
<style>
td{
    text-align:center;
}
</style>
<form
<?php 
$task = "task=taslakKaydet";
echo 'action="index.php?option=com_meslek_std_taslak&amp;layout=meslek_profil&amp;'.$task.'&amp;standart_id='.$this->standart_id.'"'	
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
  <div class="form_element cf_heading">
  	<h1 class="contentheading">3. MESLEK PROFİLİ</h1>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>

<div class="form_item">
  <div class="form_element cf_heading">
  	<h2 class="contentheading">3.1.	Görevler, İşlemler ve Başarım Ölçütleri</h2>
  </div>
  <div class="cfclear">&nbsp;</div>
</div>
<div class="form_item">
<!--  <div class="form_element">-->
<div id="gibTable">
<table id="MPtablosu" class="tableGib" border="0">
    <thead class="gibHeader">
        <tr>
            <td colspan="2">Görevler</td>
            <td colspan="2">İşlemler</td>
            <td colspan="2">Başarım Ölçütleri</td>
        </tr>
    </thead>
    <tr class="tablo_header_acik" id="MPBaslik">
        <td style="width: 30px;">Kod</td>
        <td>Adı/Dipnot</td>
        <td>Kod</td>
        <td>Adı/Dipnot</td>
        <td>Kod</td>
        <td>Açıklama/Dipnot</td>
    </tr>
<?php
foreach($profil as $arr){
    if ($arr["PROFIL_GOREV_ADI"] != null){
        $i++;
        $gorev_profil_id = $arr["PROFIL_ID"];
        $gorev[$i]=FormFactory::normalizeVariable ($arr["PROFIL_GOREV_ADI"]);
        $gorevdip[$i]=FormFactory::normalizeVariable ($arr["PROFIL_GOREV_DIPNOT"]);
        $sira[$i]=FormFactory::normalizeVariable ($arr["SIRA"]);
        $j=0;
        $k=0;
    } else if ($arr["PROFIL_ISLEM_ADI"] != null){
        $j++;
        $islemParent = $arr["PARENT_ID"];
        $islem[$i][$j]=FormFactory::normalizeVariable ($arr["PROFIL_ISLEM_ADI"]);
        $islemdip[$i][$j]=FormFactory::normalizeVariable ($arr["PROFIL_ISLEM_DIPNOT"]);
        $k=0;
    } else if($arr["PROFIL_BASARIM_OLCUT"] != null){
        $k++;
        $BOParent = $arr["PARENT_ID"];
        $bo[$i][$j][$k]=FormFactory::normalizeVariable ($arr["PROFIL_BASARIM_OLCUT"]);
        $bodip[$i][$j][$k]=FormFactory::normalizeVariable ($arr["PROFIL_BASARIM_DIPNOT"]);        
    }    
}
echo "<script>";
for ($i=1;$i<=count($gorev);$i++){
    echo "yeniGorevEkle('".$gorev[$i]."','".$gorevdip[$i]."','".$islem[$i][1]."','".$islemdip[$i][1]."','".$bo[$i][1][1]."','".$bodip[$i][1][1]."');";
    for ($k=2;$k<=count($bo[$i][1]);$k++){
        echo "BOEkle($i,1,'".$bo[$i][1][$k]."','".$bodip[$i][1][$k]."');";
    }    
    for ($j=2;$j<=count($islem[$i]);$j++){
        echo "islemEkle($i,'".$islem[$i][$j]."','".$islemdip[$i][$j]."','".$bo[$i][$j][1]."','".$bodip[$i][$j][1]."');";
        for ($k=2;$k<=count($bo[$i][$j]);$k++){
            echo "BOEkle($i,$j,'".$bo[$i][$j][$k]."','".$bodip[$i][$j][$k]."');";
        }    
    }
}
if (count($gorev)==""){
    count($gorev);
echo "window.yeniGorev=1;";
echo "yeniGorevEkle();";
} else{
echo "window.yeniGorev=".$i;
}
echo "</script>";
?>
</table>



</div>
<?php

if ($this->canEdit)
	echo '<input type="button" onclick="yeniGorevEkle()" value="Yeni Görev" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="jQuery(\'.gsira\').toggle()" value="Yeniden Sırala" />';
?>
  </div>
  <div class="cfclear">&nbsp;</div>
<!--</div>-->

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
			<input value="Yorum Kaydet" name="kaydet" type="button"  onclick="yorumKaydet('meslek_profil', <?php echo $this->standart_id;?>)"/>
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
